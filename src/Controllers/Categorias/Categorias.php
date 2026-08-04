<?php

namespace Controllers\Categorias;

use Controllers\PrivateController;
use Dao\Categorias\Categorias as CategoriasDao;
use Utilities\Context;
use Utilities\Paging;
use Views\Renderer;

class Categorias extends PrivateController
{
    private $partialName = "";
    private $status = "";
    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];

    private $categorias = [];
    private $categoriasCount = 0;
    private $pages = 0;


    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();


        if (isset($_GET["clear"])) {

            $this->partialName = "";
            $this->status = "";
            $this->pageNumber = 1;
        }


        $tmp =
            CategoriasDao::getCategorias(
                $this->partialName,
                $this->status,
                $this->pageNumber - 1,
                $this->itemsPerPage
            );


        $this->categorias =
            $tmp["categorias"];


        $this->categoriasCount =
            $tmp["total"];


        $this->pages =
            $this->categoriasCount > 0
            ? ceil($this->categoriasCount / $this->itemsPerPage)
            : 1;


        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }


        $this->setParamsToContext();
        $this->setParamsToView();


        Renderer::render(
            "categorias/categorias",
            $this->viewData
        );
    }



    private function getParams(): void
    {
        $this->partialName =
            $_GET["partialName"] ?? $this->partialName;


        $this->status =
            $_GET["status"] ?? $this->status;


        $this->pageNumber =
            isset($_GET["pageNum"])
            ? intval($_GET["pageNum"])
            : $this->pageNumber;


        $this->itemsPerPage =
            isset($_GET["itemsPerPage"])
            ? intval($_GET["itemsPerPage"])
            : $this->itemsPerPage;
    }



    private function getParamsFromContext(): void
    {
        $this->partialName =
            Context::getContextByKey(
                "categorias_partialName"
            );


        $this->status =
            Context::getContextByKey(
                "categorias_status"
            );


        $this->pageNumber =
            intval(
                Context::getContextByKey(
                    "categorias_page"
                )
            );


        $this->itemsPerPage =
            intval(
                Context::getContextByKey(
                    "categorias_itemsPerPage"
                )
            );


        if ($this->pageNumber < 1) {
            $this->pageNumber = 1;
        }


        if ($this->itemsPerPage < 1) {
            $this->itemsPerPage = 10;
        }
    }



    private function setParamsToContext(): void
    {
        Context::setContext(
            "categorias_partialName",
            $this->partialName,
            true
        );


        Context::setContext(
            "categorias_status",
            $this->status,
            true
        );


        Context::setContext(
            "categorias_page",
            $this->pageNumber,
            true
        );


        Context::setContext(
            "categorias_itemsPerPage",
            $this->itemsPerPage,
            true
        );
    }



    private function setParamsToView(): void
    {
        $this->viewData["partialName"] =
            $this->partialName;


        $this->viewData["status"] =
            $this->status;


        $this->viewData["categorias"] =
            $this->categorias;


        $this->viewData["categoriasCount"] =
            $this->categoriasCount;


        $this->viewData["pages"] =
            $this->pages;


        $this->viewData["pageNum"] =
            $this->pageNumber;


        $this->viewData["pagination"] =
            Paging::getPagination(
                $this->categoriasCount,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=Categorias_Categorias",
                "Categorias_Categorias"
            );
    }
}
