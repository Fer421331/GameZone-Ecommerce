<?php

namespace Controllers\RutasEntrega;

use Controllers\PrivateController;
use Dao\RutasEntrega\RutasEntrega as RutasEntregaDao;
use Utilities\Context;
use Utilities\Paging;
use Views\Renderer;

class RutasEntrega extends PrivateController
{
    private $partialName = "";
    private $status = "";
    private $pageNumber = 1;
    private $itemsPerPage = 10;

    private $viewData = [];

    private $rutasEntrega = [];
    private $rutasEntregaCount = 0;
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

        $tmp = RutasEntregaDao::getRutasEntrega(
            $this->partialName,
            $this->status,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->rutasEntrega = $tmp["rutas"];
        $this->rutasEntregaCount = $tmp["total"];

        $this->pages = $this->rutasEntregaCount > 0
            ? ceil($this->rutasEntregaCount / $this->itemsPerPage)
            : 1;

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToView();

        Renderer::render(
            "rutasentrega/rutasentrega",
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
                "rutasentrega_partialName"
            );

        $this->status =
            Context::getContextByKey(
                "rutasentrega_status"
            );

        $this->pageNumber =
            intval(
                Context::getContextByKey(
                    "rutasentrega_page"
                )
            );

        $this->itemsPerPage =
            intval(
                Context::getContextByKey(
                    "rutasentrega_itemsPerPage"
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
            "rutasentrega_partialName",
            $this->partialName,
            true
        );

        Context::setContext(
            "rutasentrega_status",
            $this->status,
            true
        );

        Context::setContext(
            "rutasentrega_page",
            $this->pageNumber,
            true
        );

        Context::setContext(
            "rutasentrega_itemsPerPage",
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

        $this->viewData["rutasentrega"] =
            $this->rutasEntrega;

        $this->viewData["rutasEntregaCount"] =
            $this->rutasEntregaCount;

        $this->viewData["pages"] =
            $this->pages;

        $this->viewData["pageNum"] =
            $this->pageNumber;

        $this->viewData["pagination"] =
            Paging::getPagination(
                $this->rutasEntregaCount,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=RutasEntrega_RutasEntrega",
                "RutasEntrega_RutasEntrega"
            );
    }
}
