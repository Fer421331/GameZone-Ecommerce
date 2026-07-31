<?php

namespace Controllers\Catalogo;

use Controllers\PrivateController;
use Dao\Productos\Productos as ProductosDao;
use Views\Renderer;

class Catalogo extends PrivateController
{
    private array $viewData = [];

    public function run(): void
    {
        $productos = ProductosDao::getProductosPublicados();

        foreach ($productos as &$producto) {

            $producto["producto_nombre"] = htmlspecialchars(
                $producto["producto_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );

            $producto["categoria_nombre"] = htmlspecialchars(
                $producto["categoria_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );

            $producto["marca_nombre"] = htmlspecialchars(
                $producto["marca_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );

            $producto["plataforma_nombre"] = htmlspecialchars(
                $producto["plataforma_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );

            $producto["producto_precio"] = number_format(
                (float)$producto["producto_precio"],
                2
            );

            $producto["producto_stock_texto"] =
                intval($producto["producto_stock"]) > 0
                ? "Disponible"
                : "Agotado";
        }

        unset($producto);

        $this->viewData["productos"] = $productos;

        Renderer::render(
            "catalogo/catalogo",
            $this->viewData
        );
    }
}