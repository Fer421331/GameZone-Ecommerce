<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Dao\Security\Bitacora as BitacoraDAO;
use Utilities\Paging;
use Views\Renderer;

class Bitacora extends PrivateController
{

    private $fechaDesde = "";
    private $fechaHasta = "";

    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];


    public function run(): void
    {

        $this->getParams();


        if (isset($_GET["clear"])) {

            $this->fechaDesde = "";
            $this->fechaHasta = "";
            $this->pageNumber = 1;
        }


        $resultado =
            BitacoraDAO::obtenerBitacora(
                $this->fechaDesde,
                $this->fechaHasta,
                $this->pageNumber - 1,
                $this->itemsPerPage
            );


        $bitacora =
            $resultado["bitacora"];


        $total =
            $resultado["total"];


        $paginas =
            $total > 0
            ? ceil($total / $this->itemsPerPage)
            : 1;



        $this->viewData = [

            "bitacora" => $bitacora,

            "fechaDesde" => $this->fechaDesde,

            "fechaHasta" => $this->fechaHasta,

            "pageNum" => $this->pageNumber,

            "pagination" =>
            Paging::getPagination(
                $total,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=Security_Bitacora",
                "Security_Bitacora"
            )

        ];


        Renderer::render(
            "security/bitacora",
            $this->viewData
        );
    }



    private function getParams(): void
    {

        $this->fechaDesde =
            $_GET["fechaDesde"] ?? "";


        $this->fechaHasta =
            $_GET["fechaHasta"] ?? "";


        $this->pageNumber =
            isset($_GET["pageNum"])
            ? intval($_GET["pageNum"])
            : 1;


        $this->itemsPerPage =
            isset($_GET["itemsPerPage"])
            ? intval($_GET["itemsPerPage"])
            : 10;
    }
}
