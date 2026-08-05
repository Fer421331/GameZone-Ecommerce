<?php

namespace Controllers\Marcas;

use Controllers\PrivateController;
use Dao\Marcas\Marcas as MarcasDao;
use Utilities\Paging;
use Views\Renderer;

class Marcas extends PrivateController
{

    private int $pageNumber = 1;
    private int $itemsPerPage = 100;


    public function run(): void
    {

        $this->pageNumber =
            intval($_GET["pageNum"] ?? 1);


        $offset =
            ($this->pageNumber - 1)
            * $this->itemsPerPage;


        $buscar =
            trim($_GET["buscar"] ?? "");


        $estado =
            $_GET["estado"] ?? "";


        $resultado =
            MarcasDao::getMarcas(
                $buscar,
                $estado,
                $offset,
                $this->itemsPerPage
            );


        $marcas =
            $resultado["marcas"];


        foreach($marcas as &$marca)
        {

            $marca["marca_nombre"] =
                $this->escape(
                    $marca["marca_nombre"]
                );


            $marca["marca_descripcion"] =
                $this->escape(
                    $marca["marca_descripcion"]
                );


            $marca["marca_estado_texto"] =
                $marca["marca_estado"]==="ACT"
                ? "Activo"
                : "Inactivo";

        }


        unset($marca);



        Renderer::render(
            "marcas/marcas",
            [

                "marcas"=>$marcas,


                "buscar"=>$buscar,


                "pagination"=>

                Paging::getPagination(
                    $resultado["total"],
                    $this->itemsPerPage,
                    $this->pageNumber,
                    "index.php?page=Marcas_Marcas",
                    "Marcas_Marcas"
                )

            ]
        );

    }




    private function escape($value):string
    {

        return htmlspecialchars(
            strval($value ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

    }

}