<?php

namespace Controllers\Checkout;

use Controllers\PrivateController;
use Dao\Carrito\Carrito as CarritoDao;
use Utilities\Context;
use Utilities\PayPal\PayPalRestApi;
use Utilities\PayPal\PayPalOrder;
use Utilities\Bitacora;
use Utilities\Site;
use Views\Renderer;
use Dao\Reservas\Reservas as ReservasDao;
use Dao\Productos\Productos as ProductosDao;
use Dao\DireccionesUsuario\DireccionesUsuario as DireccionesDao;
use Utilities\Security;

class Checkout extends PrivateController
{
    private array $viewData = [];

    public function run(): void
    {

        $usercod = Security::getUserId();


        $this->viewData["productos"] =
            CarritoDao::getCart();


        $this->viewData["total"] =
            number_format(
                CarritoDao::getTotal(),
                2
            );

        $direccion =
            DireccionesDao::getDireccionPredeterminada(
                $usercod
            );


        if (!$direccion) {

            $this->viewData["errorDireccion"] =
                "Debe registrar una dirección de entrega antes de realizar la compra.";

            $this->viewData["puedeComprar"] = false;

        } else {

            $this->viewData["direccion"] =
                $direccion;

            $this->viewData["puedeComprar"] =
                true;
        }



        if ($this->isPostBack()) {


            $usercod = Security::getUserId();


            $direccion =
                DireccionesDao::getDireccionPredeterminada(
                    $usercod
                );


            if (!$direccion) {


                Site::redirectToWithMsg(
                    "index.php?page=DireccionesUsuario_DireccionesUsuarios",
                    "Debe agregar una dirección de entrega antes de comprar."
                );


                return;
            }



            $carrito =
                CarritoDao::getCart();



            if (empty($carrito)) {


                Site::redirectTo(
                    "index.php?page=Carrito_Carrito"
                );


                return;
            }


            foreach ($carrito as $producto) {


                $stockDisponible =
                    ProductosDao::getStockDisponible(
                        $producto["producto_id"]
                    );


                if (
                    $producto["cantidad"]
                    >
                    $stockDisponible
                ) {


                    $_SESSION["cart_message"] =
                        "La compra no puede continuar porque el producto '{$producto["producto_nombre"]}' ya no tiene stock suficiente.";


                    Bitacora::registrar(
                        "Checkout",
                        "Compra rechazada por falta de stock",
                        "Producto: " .
                            $producto["producto_nombre"] .
                            " solicitado: " .
                            $producto["cantidad"] .
                            " disponible: " .
                            $stockDisponible,
                        "WAR"
                    );


                    Site::redirectTo(
                        "index.php?page=Carrito_Carrito"
                    );


                    return;
                }
            }


            $baseUrl =
                sprintf(
                    "%s://%s%s",
                    isset($_SERVER["HTTPS"]) &&
                    $_SERVER["HTTPS"] !== "off"
                        ? "https"
                        : "http",
                    $_SERVER["HTTP_HOST"],
                    rtrim(
                        dirname($_SERVER["PHP_SELF"]),
                        "/\\"
                    )
                );



            $errorUrl =
                $baseUrl .
                "/index.php?page=Checkout_Error";


            $acceptUrl =
                $baseUrl .
                "/index.php?page=Checkout_Accept";




            $paypalOrder =
                new PayPalOrder(
                    "ORD-" . time(),
                    $errorUrl,
                    $acceptUrl
                );



            foreach ($carrito as $producto) {


                $paypalOrder->addItem(
                    $producto["producto_nombre"],
                    $producto["producto_descripcion"],
                    (string)$producto["producto_id"],
                    (float)$producto["producto_precio"],
                    0,
                    (int)$producto["cantidad"],
                    "DIGITAL_GOODS"
                );
            }



            $paypal =
                new PayPalRestApi(
                    Context::getContextByKey("PAYPAL_CLIENT_ID"),
                    Context::getContextByKey("PAYPAL_CLIENT_SECRET")
                );



            $paypal->getAccessToken();



            $response =
                $paypal->createOrder(
                    $paypalOrder
                );



            if (!isset($response->id)) {


                Bitacora::registrar(
                    "Checkout",
                    "No se pudo crear la orden de pago",
                    "PayPal no devolvió un ID de orden.",
                    "ERR"
                );


                Site::redirectTo(
                    "index.php?page=Checkout_Error"
                );


                return;
            }


            $_SESSION["direccion_id_compra"] =
                intval(
                    $direccion["direccion_id"]
                );


            $_SESSION["orderid"] =
                $response->id;



            foreach ($carrito as $producto) {


                ReservasDao::crearReserva(
                    $producto["producto_id"],
                    $usercod,
                    $producto["cantidad"]
                );
            }




            foreach ($response->links as $link) {


                if ($link->rel === "approve") {


                    Site::redirectTo(
                        $link->href
                    );


                    return;
                }
            }




            Site::redirectTo(
                "index.php?page=Checkout_Error"
            );
        }



        $this->viewData["mostrarDirecciones"] =
            true;



        Renderer::render(
            "paypal/checkout",
            $this->viewData
        );
    }
}