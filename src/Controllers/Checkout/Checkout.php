<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Carrito\Carrito as CarritoDao;
use Utilities\Context;
use Utilities\PayPal\PayPalRestApi;
use Utilities\PayPal\PayPalOrder;
use Utilities\Site;
use Views\Renderer;
use Dao\Reservas\Reservas as ReservasDao;
use Dao\Productos\Productos as ProductosDao;
use Utilities\Security;

class Checkout extends PublicController
{
    private array $viewData = [];

    public function run(): void
    {
        $this->viewData["productos"] = CarritoDao::getCart();
        $this->viewData["total"] = number_format(
            CarritoDao::getTotal(),
            2
        );

        if ($this->isPostBack()) {

            $carrito = CarritoDao::getCart();

            if (empty($carrito)) {
                Site::redirectTo("index.php?page=Carrito_Carrito");
            }

            $usercod = Security::getUserId();


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
                    rtrim(dirname($_SERVER["PHP_SELF"]), "/\\")
                );

            $errorUrl =
                $baseUrl .
                "/index.php?page=Checkout_Error";

            $acceptUrl =
                $baseUrl .
                "/index.php?page=Checkout_Accept";

            $paypalOrder = new PayPalOrder(
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

            $paypal = new PayPalRestApi(
                Context::getContextByKey("PAYPAL_CLIENT_ID"),
                Context::getContextByKey("PAYPAL_CLIENT_SECRET")
            );

            $paypal->getAccessToken();

            $response = $paypal->createOrder(
                $paypalOrder
            );

            if (!isset($response->id)) {
                Site::redirectTo(
                    "index.php?page=Checkout_Error"
                );
            }

            $_SESSION["orderid"] = $response->id;

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
                }
            }

            Site::redirectTo(
                "index.php?page=Checkout_Error"
            );
        }

        Renderer::render(
            "paypal/checkout",
            $this->viewData
        );
    }
}
