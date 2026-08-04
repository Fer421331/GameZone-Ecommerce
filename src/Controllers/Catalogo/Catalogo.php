<?php

namespace Controllers\Catalogo;

use Controllers\PublicController;
use Dao\Productos\Productos as ProductosDao;
use Dao\Favoritos\Favoritos as FavoritosDao;
use Utilities\Security;
use Views\Renderer;

class Catalogo extends PublicController
{
    private array $viewData = [];

    public function run(): void
    {
        $buscar = trim($_GET["buscar"] ?? "");

        $categoria = intval($_GET["categoria"] ?? 0);

        $orden = $_GET["orden"] ?? "recientes";

        $productos = ProductosDao::getProductosPublicados(
            $buscar,
            $categoria,
            $orden
        );

        $usercod = Security::isLogged()
            ? Security::getUserId()
            : 0;

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

            $producto["esFavorito"] = false;

            if ($usercod > 0) {

                $producto["esFavorito"] =
                    FavoritosDao::esFavorito(
                        $usercod,
                        $producto["producto_id"]
                    );
            }
        }

        unset($producto);

        $this->viewData["productos"] = $productos;


        $this->viewData["buscar"] = $buscar;
        $this->viewData["categoria"] = $categoria;
        $this->viewData["orden"] = $orden;
        $this->viewData["orden_recientes"] =
            $orden == "recientes" ? "selected" : "";

        $this->viewData["orden_nombre_asc"] =
            $orden == "nombre_asc" ? "selected" : "";

        $this->viewData["orden_nombre_desc"] =
            $orden == "nombre_desc" ? "selected" : "";

        $this->viewData["orden_precio_asc"] =
            $orden == "precio_asc" ? "selected" : "";

        $this->viewData["orden_precio_desc"] =
            $orden == "precio_desc" ? "selected" : "";

        $this->viewData["orden_favoritos"] =
            $orden == "favoritos" ? "selected" : "";

        $this->viewData["categorias"] =
            ProductosDao::getCategoriasActivas();

        Renderer::render(
            "catalogo/catalogo",
            $this->viewData
        );
    }
}