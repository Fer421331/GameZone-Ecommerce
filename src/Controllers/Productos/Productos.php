<?php

namespace Controllers\Productos;

use Controllers\PrivateController;
use Dao\Productos\Productos as ProductosDao;
use Utilities\Paging;
use Views\Renderer;

class Productos extends PrivateController
{
    private int $pageNumber = 1;
    private int $itemsPerPage = 100;

    public function run(): void
    {

        $this->pageNumber = intval($_GET["pageNum"] ?? 1);

        $offset = ($this->pageNumber - 1) * $this->itemsPerPage;


        $productos = ProductosDao::getProductos(
            $this->itemsPerPage,
            $offset
        );


        $totalProductos = ProductosDao::getTotalProductos();


        foreach ($productos as &$producto) {


            $producto["producto_sku"] =
                $this->escape($producto["producto_sku"]);


            $producto["producto_nombre"] =
                $this->escape($producto["producto_nombre"]);


            $producto["categoria_nombre"] =
                $this->escape($producto["categoria_nombre"]);


            $producto["marca_nombre"] =
                $this->escape($producto["marca_nombre"]);


            $producto["plataforma_nombre"] =
                $this->escape($producto["plataforma_nombre"]);


            $producto["producto_costo"] =
                number_format(
                    floatval($producto["producto_costo"]),
                    2
                );


            $producto["producto_precio"] =
                number_format(
                    floatval($producto["producto_precio"]),
                    2
                );


            $producto["producto_estado_texto"] =
                $producto["producto_estado"] === "ACT"
                ? "Activo"
                : "Inactivo";


            $producto["producto_web_texto"] =
                $producto["producto_activo_web"] === "ACT"
                ? "Publicado"
                : "Oculto";

        }


        unset($producto);



        Renderer::render(
            "productos/productos",
            [

                "productos" => $productos,


                "pagination" =>

                Paging::getPagination(
                    $totalProductos,
                    $this->itemsPerPage,
                    $this->pageNumber,
                    "index.php?page=Productos_Productos",
                    "Productos_Productos"
                )

            ]
        );

    }



    private function escape($value): string
    {

        return htmlspecialchars(
            strval($value ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

    }
}