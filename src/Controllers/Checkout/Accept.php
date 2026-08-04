<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Carrito\Carrito as CarritoDao;
use Dao\Ventas\Ventas as VentasDao;
use Utilities\Security;
use Utilities\Context;
use Utilities\PayPal\PayPalRestApi;
use Views\Renderer;
use Dao\Reservas\Reservas as ReservasDao;
use Dao\Productos\Productos as ProductosDao;

class Accept extends PublicController
{
    public function run(): void
    {
        $dataview = array();

        $token = $_GET["token"] ?? "";
        $session_token = $_SESSION["orderid"] ?? "";

        if ($token !== "" && $token == $session_token) {

            $paypal = new PayPalRestApi(
                Context::getContextByKey("PAYPAL_CLIENT_ID"),
                Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );

            $result = $paypal->captureOrder($session_token);

            if (isset($result->status) && $result->status == "COMPLETED") {

                $usercod = Security::getUserId();
                $productos = CarritoDao::getCart();
                $total = (float)CarritoDao::getTotal();

                if (!ReservasDao::validarReservasUsuario($usercod)) {
                    $dataview["mensaje"] = "Uno o más productos ya no tienen stock disponible.";
                    $dataview["orderjson"] = json_encode(
                        $result,
                        JSON_PRETTY_PRINT
                    );

                    Renderer::render(
                        "paypal/accept",
                        $dataview
                    );

                    return;
                }

                $metodo_pago_id = VentasDao::getMetodoPagoId("PayPal");

                $venta_id = VentasDao::crearVenta(
                    $usercod,
                    0,
                    $metodo_pago_id,
                    $total,
                    $total,
                    "APR"
                );

                foreach ($productos as $producto) {

                    VentasDao::agregarDetalle(
                        $venta_id,
                        $producto
                    );

                    ProductosDao::descontarStock(
                        intval($producto["producto_id"]),
                        intval($producto["cantidad"])
                    );
                }
                
                ReservasDao::confirmarReservas(
                    $usercod
                );

                VentasDao::registrarPago(
                    $venta_id,
                    $metodo_pago_id,
                    $total,
                    $session_token
                );

                CarritoDao::clearCart();

                $dataview["mensaje"] = "Compra realizada correctamente.";
                $dataview["venta_id"] = $venta_id;

                unset($_SESSION["orderid"]);
            } else {

                $dataview["mensaje"] = "El pago no fue completado.";
            }

            $dataview["orderjson"] = json_encode(
                $result,
                JSON_PRETTY_PRINT
            );
        } else {

            $dataview["orderjson"] = "No Order Available!!!";
        }

        Renderer::render(
            "paypal/accept",
            $dataview
        );
    }
}
