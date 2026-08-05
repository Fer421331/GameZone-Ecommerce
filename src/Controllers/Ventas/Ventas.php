<?php

namespace Controllers\Ventas;

use Controllers\PrivateController;
use Dao\Ventas\Ventas as VentasDao;
use Utilities\Context;
use Utilities\Paging;
use Views\Renderer;


class Ventas extends PrivateController
{

    private $buscar = "";
    private $estado = "";

    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];

    private $ventas = [];
    private $ventasCount = 0;
    private $pages = 0;



    public function run(): void
    {

        $this->getParamsFromContext();
        $this->getParams();



        if(isset($_GET["clear"])) {

            $this->buscar = "";
            $this->estado = "";
            $this->pageNumber = 1;

        }



        $tmp =
            VentasDao::getVentas(
                $this->buscar,
                $this->estado,
                $this->pageNumber - 1,
                $this->itemsPerPage
            );



        $this->ventas =
            $tmp["ventas"];



        $this->ventasCount =
            $tmp["total"];



        $this->pages =
            $this->ventasCount > 0
            ? ceil(
                $this->ventasCount /
                $this->itemsPerPage
            )
            : 1;



        if($this->pageNumber > $this->pages){

            $this->pageNumber = $this->pages;

        }



        $this->setParamsToContext();
        $this->setParamsToView();



        Renderer::render(
            "ventas/ventas",
            $this->viewData
        );

    }






    private function getParams(): void
    {

        $this->buscar =
            $_GET["buscar"]
            ??
            $this->buscar;



        $this->estado =
            $_GET["estado"]
            ??
            $this->estado;




        $this->pageNumber =
            isset($_GET["pageNum"])
            ?
            intval($_GET["pageNum"])
            :
            $this->pageNumber;



        $this->itemsPerPage =
            isset($_GET["itemsPerPage"])
            ?
            intval($_GET["itemsPerPage"])
            :
            $this->itemsPerPage;

    }







    private function getParamsFromContext(): void
    {

        $this->buscar =
            Context::getContextByKey(
                "ventas_buscar"
            );



        $this->estado =
            Context::getContextByKey(
                "ventas_estado"
            );



        $this->pageNumber =
            intval(
                Context::getContextByKey(
                    "ventas_page"
                )
            );



        $this->itemsPerPage =
            intval(
                Context::getContextByKey(
                    "ventas_itemsPerPage"
                )
            );



        if($this->pageNumber < 1){

            $this->pageNumber = 1;

        }



        if($this->itemsPerPage < 1){

            $this->itemsPerPage = 10;

        }

    }







    private function setParamsToContext(): void
    {

        Context::setContext(
            "ventas_buscar",
            $this->buscar,
            true
        );



        Context::setContext(
            "ventas_estado",
            $this->estado,
            true
        );



        Context::setContext(
            "ventas_page",
            $this->pageNumber,
            true
        );



        Context::setContext(
            "ventas_itemsPerPage",
            $this->itemsPerPage,
            true
        );

    }







    private function setParamsToView(): void
    {


        $this->viewData["buscar"] =
            $this->buscar;



        $this->viewData["estado"] =
            $this->estado;



        $this->viewData["ventas"] =
            $this->ventas;



        $this->viewData["ventasCount"] =
            $this->ventasCount;



        $this->viewData["pages"] =
            $this->pages;



        $this->viewData["pageNum"] =
            $this->pageNumber;



        $this->viewData["pagination"] =
            Paging::getPagination(
                $this->ventasCount,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=Ventas_Ventas",
                "Ventas_Ventas"
            );

    }

}