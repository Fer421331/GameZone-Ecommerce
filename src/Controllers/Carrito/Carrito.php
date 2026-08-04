<?php

namespace Controllers\Carrito;

use Controllers\PrivateController;
use Dao\Carrito\Carrito as CarritoDao;
use Utilities\Site;
use Utilities\Bitacora;
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

                    if (CarritoDao::addProducto($productoId)) {

                        Bitacora::registrar(
                            "Carrito",
                            "Producto agregado al carrito",
                            "Producto ID: " . $productoId,
                            "LOG"
                        );
                    } else {

                        Bitacora::registrar(
                            "Carrito",
                            "Intento fallido de agregar producto al carrito",
                            "Producto ID: " . $productoId,
                            "WAR"
                        );
                    }
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

                    if (CarritoDao::removeProducto($productoId)) {

                        Bitacora::registrar(
                            "Carrito",
                            "Producto eliminado del carrito",
                            "Producto ID: " . $productoId,
                            "LOG"
                        );
                    }
                }

                Site::redirectTo(
                    "index.php?page=Carrito_Carrito"
                );

                return;

            case "CLEAR":

                CarritoDao::clearCart();

                Bitacora::registrar(
                    "Carrito",
                    "Carrito vaciado",
                    "Usuario limpió todos los productos del carrito",
                    "LOG"
                );

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

                        if (
                            CarritoDao::updateCantidad(
                                intval($productoId),
                                intval($cantidad)
                            )
                        ) {

                            Bitacora::registrar(
                                "Carrito",
                                "Cantidad de producto modificada",
                                "Producto ID: " . $productoId .
                                    " nueva cantidad: " . $cantidad,
                                "LOG"
                            );
                        } else {

                            Bitacora::registrar(
                                "Carrito",
                                "Intento fallido de modificar cantidad",
                                "Producto ID: " . $productoId .
                                    " cantidad solicitada: " . $cantidad,
                                "WAR"
                            );
                        }
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
