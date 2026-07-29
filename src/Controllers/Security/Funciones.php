<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Security\Security as SecurityDAO;
use Views\Renderer;

class Funciones extends PrivateController
{
    private $partialName = "";
    private $status = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];
    private $funciones = [];
    private $funcionesCount = 0;
    private $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        if (isset($_GET["clear"])) {
            $this->partialName = "";
            $this->status = "";
            $this->orderBy = "";
            $this->orderDescending = false;
            $this->pageNumber = 1;
        }

        $tmp = SecurityDAO::getFunciones(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->funciones = $tmp["funciones"];
        $this->funcionesCount = $tmp["total"];

        $this->pages = $this->funcionesCount > 0
            ? ceil($this->funcionesCount / $this->itemsPerPage)
            : 1;

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToView();

        Renderer::render(
            "security/funciones",
            $this->viewData
        );
    }


    private function getParams(): void
    {
        $this->partialName =
            $_GET["partialName"] ?? $this->partialName;


        $this->status =
            $_GET["status"] ?? $this->status;


        $this->orderBy =
            $_GET["orderBy"] ?? $this->orderBy;


        $this->orderDescending =
            isset($_GET["orderDescending"])
                ? boolval($_GET["orderDescending"])
                : false;


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
            Context::getContextByKey("funciones_partialName");


        $this->status =
            Context::getContextByKey("funciones_status");


        $this->orderBy =
            Context::getContextByKey("funciones_orderBy");


        $this->orderDescending =
            boolval(
                Context::getContextByKey("funciones_orderDescending")
            );


        $this->pageNumber =
            intval(
                Context::getContextByKey("funciones_page")
            );


        $this->itemsPerPage =
            intval(
                Context::getContextByKey("funciones_itemsPerPage")
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
            "funciones_partialName",
            $this->partialName,
            true
        );


        Context::setContext(
            "funciones_status",
            $this->status,
            true
        );


        Context::setContext(
            "funciones_orderBy",
            $this->orderBy,
            true
        );


        Context::setContext(
            "funciones_orderDescending",
            $this->orderDescending,
            true
        );


        Context::setContext(
            "funciones_page",
            $this->pageNumber,
            true
        );


        Context::setContext(
            "funciones_itemsPerPage",
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


        $this->viewData["funciones"] =
            $this->funciones;


        $this->viewData["funcionesCount"] =
            $this->funcionesCount;


        $this->viewData["pages"] =
            $this->pages;


        $this->viewData["pageNum"] =
            $this->pageNumber;


        $this->viewData["pagination"] =
            Paging::getPagination(
                $this->funcionesCount,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=Security_Funciones",
                "Security_Funciones"
            );
    }
}