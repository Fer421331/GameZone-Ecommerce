<?php

namespace Controllers\Plataformas;

use Controllers\PrivateController;
use Dao\Plataformas\Plataformas as PlataformasDao;
use Utilities\Paging;
use Views\Renderer;

class Plataformas extends PrivateController
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


        $plataformas =
            PlataformasDao::getPlataformas(
                $this->itemsPerPage,
                $offset
            );


        $totalPlataformas =
            PlataformasDao::getTotalPlataformas();



        foreach ($plataformas as &$plataforma) {

            $plataforma["plataforma_nombre"] =
                $this->escape(
                    $plataforma["plataforma_nombre"]
                );


            $plataforma["plataforma_descripcion"] =
                $this->escape(
                    $plataforma["plataforma_descripcion"]
                );


            $plataforma["plataforma_estado_texto"] =
                $plataforma["plataforma_estado"] === "ACT"
                ? "Activo"
                : "Inactivo";

        }


        unset($plataforma);



        Renderer::render(
            "plataformas/plataformas",
            [

                "plataformas" =>
                    $plataformas,


                "pagination" =>

                    Paging::getPagination(
                        $totalPlataformas,
                        $this->itemsPerPage,
                        $this->pageNumber,
                        "index.php?page=Plataformas_Plataformas",
                        "Plataformas_Plataformas"
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