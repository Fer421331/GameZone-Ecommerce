<?php

namespace Controllers\Carrito;

use Controllers\PrivateController;
use Dao\Carrito\Carrito as CarritoDao;
use Utilities\Site;
use Views\Renderer;

class Carrito extends PrivateController
{
    private array $viewData = [];

    public function run(): void
    {
        $action = strtoupper($_GET["action"] ?? "");

        switch ($action) {

            case "ADD":

                $productoId = intval(
                    $_GET["producto_id"] ?? 0
                );

                if ($productoId > 0) {

                    CarritoDao::addProducto(
                        $productoId
                    );
                }

                Site::redirectTo(
                    "index.php?page=Carrito_Carrito"
                );

                return;

            case "REMOVE":

                $productoId = intval(
                    $_GET["producto_id"] ?? 0
                );

                if ($productoId > 0) {

                    CarritoDao::removeProducto(
                        $productoId
                    );
                }

                Site::redirectTo(
                    "index.php?page=Carrito_Carrito"
                );

                return;

            case "CLEAR":

                CarritoDao::clearCart();

                Site::redirectTo(
                    "index.php?page=Carrito_Carrito"
                );

                return;

            case "UPDATE":

                if ($this->isPostBack()) {

                    $cantidades =
                        $_POST["cantidad"] ?? [];

                    foreach (
                        $cantidades as $productoId => $cantidad
                    ) {

                        CarritoDao::updateCantidad(
                            intval($productoId),
                            intval($cantidad)
                        );
                    }
                }

                Site::redirectTo(
                    "index.php?page=Carrito_Carrito"
                );

                return;
        }

        $productos = CarritoDao::getCart();

        foreach ($productos as &$producto) {

            $producto["producto_precio"] =
                number_format(
                    floatval(
                        $producto["producto_precio"]
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

        $this->viewData["productos"] =
            $productos;

        $this->viewData["total"] =
            number_format(
                CarritoDao::getTotal(),
                2
            );

        $this->viewData["mensaje"] =
            CarritoDao::getMensaje();

        Renderer::render(
            "carrito/carrito",
            $this->viewData
        );
    }
}
