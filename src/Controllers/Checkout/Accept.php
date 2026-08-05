<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Carrito\Carrito as CarritoDao;
use Dao\Ventas\Ventas as VentasDao;
use Utilities\Security;
use Utilities\Context;
use Utilities\Bitacora;
use Utilities\PayPal\PayPalRestApi;
use Views\Renderer;
use Dao\Reservas\Reservas as ReservasDao;
use Dao\Productos\Productos as ProductosDao;
use Dao\DireccionesUsuario\DireccionesUsuario as DireccionesDao;


class Accept extends PublicController
{
    public function run(): void
    {

        $dataview = [
            "mensaje" => "",
            "venta_id" => "",
            "productos" => [],
            "direccion" => null,
            "total" => "0.00"
        ];



        $token =
            $_GET["token"] ?? "";


        $session_token =
            $_SESSION["orderid"] ?? "";



        if (
            $token !== ""
            &&
            $token == $session_token
        ) {


            $paypal =
                new PayPalRestApi(
                    Context::getContextByKey("PAYPAL_CLIENT_ID"),
                    Context::getContextByKey("PAYPAL_CLIENT_SECRET")
                );



            $result =
                $paypal->captureOrder(
                    $session_token
                );



            if (
                isset($result->status)
                &&
                $result->status == "COMPLETED"
            ) {


                $usercod =
                    Security::getUserId();



                /*
                    Carrito temporal usado
                    solamente para construir la venta
                */

                $productos =
                    CarritoDao::getCart();



                $total =
                    (float)CarritoDao::getTotal();



                $dataview["total"] =
                    number_format(
                        $total,
                        2
                    );




                $direccion_id =
                    $_SESSION["direccion_id_compra"] ?? 0;




                $direccion =
                    DireccionesDao::getDireccionById(
                        intval($direccion_id),
                        $usercod
                    );




                if (!$direccion) {


                    $dataview["mensaje"] =
                        "No se encontró una dirección de entrega.";


                    Renderer::render(
                        "paypal/accept",
                        $dataview
                    );


                    return;
                }






                if (
                    !ReservasDao::validarReservasUsuario(
                        $usercod
                    )
                ) {


                    Bitacora::registrar(
                        "Checkout",
                        "Compra cancelada por falta de stock",
                        "Usuario ID: " . $usercod,
                        "WAR"
                    );



                    $dataview["mensaje"] =
                        "Uno o más productos ya no tienen stock disponible.";



                    Renderer::render(
                        "paypal/accept",
                        $dataview
                    );


                    return;
                }







                $metodo_pago_id =
                    VentasDao::getMetodoPagoId(
                        "PayPal"
                    );







                $venta_id =
                    VentasDao::crearVenta(
                        $usercod,
                        intval(
                            $direccion["direccion_id"]
                        ),
                        $metodo_pago_id,
                        $total,
                        $total,
                        "APR"
                    );




                $dataview["direccion"] = true;

                $dataview["direccion_receptor"] =
                    $direccion["direccion_receptor"];

                $dataview["direccion_departamento"] =
                    $direccion["direccion_departamento"];

                $dataview["direccion_ciudad"] =
                    $direccion["direccion_ciudad"];

                $dataview["direccion_detalle"] =
                    $direccion["direccion_detalle"];

                $dataview["direccion_referencia"] =
                    $direccion["direccion_referencia"];

                foreach ($productos as $producto) {


                    VentasDao::agregarDetalle(
                        $venta_id,
                        $producto
                    );



                    ProductosDao::descontarStock(
                        intval(
                            $producto["producto_id"]
                        ),
                        intval(
                            $producto["cantidad"]
                        )
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







                /*
                    Caso B:
                    La compra mostrada sale
                    de la venta almacenada
                    en la base de datos
                */

                $productosVenta =
                    VentasDao::getDetalleVenta(
                        $venta_id
                    );






                foreach ($productosVenta as &$producto) {


                    $producto["producto_precio"] =
                        number_format(
                            floatval(
                                $producto["precio_unitario"]
                            ),
                            2
                        );



                    $producto["subtotal"] =
                        number_format(
                            floatval(
                                $producto["subtotal"]
                            ),
                            2
                        );
                }


                unset($producto);








                Bitacora::registrar(
                    "Checkout",
                    "Compra realizada correctamente",
                    "Venta ID: " .
                        $venta_id .
                        " Total: $" .
                        number_format(
                            $total,
                            2
                        ),
                    "LOG"
                );








                $dataview["productos"] =
                    $productosVenta;



                $dataview["mensaje"] =
                    "Compra realizada correctamente.";




                $dataview["venta_id"] =
                    $venta_id;







                CarritoDao::clearCart();



                unset(
                    $_SESSION["orderid"]
                );


                unset(
                    $_SESSION["direccion_id_compra"]
                );
            } else {


                Bitacora::registrar(
                    "Checkout",
                    "Pago no completado",
                    "La orden de PayPal no fue aprobada. Token: " .
                        $session_token,
                    "WAR"
                );



                $dataview["mensaje"] =
                    "El pago no fue completado.";
            }







            $dataview["orderjson"] =
                json_encode(
                    $result,
                    JSON_PRETTY_PRINT
                );
        } else {


            $dataview["orderjson"] =
                "No Order Available!!!";
        }







        Renderer::render(
            "paypal/accept",
            $dataview
        );
    }
}
