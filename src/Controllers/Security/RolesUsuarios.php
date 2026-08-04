<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;
use Utilities\Paging;

class RolesUsuarios extends PrivateController
{
    private $pageNumber = 1;
    private $itemsPerPage = 10;


    public function run(): void
    {

        $this->pageNumber =
            isset($_GET["pageNum"])
            ? intval($_GET["pageNum"])
            : 1;


        $this->itemsPerPage =
            isset($_GET["itemsPerPage"])
            ? intval($_GET["itemsPerPage"])
            : 10;



        $resultado =
            SecurityDAO::getUsuariosPaginados(
                $this->pageNumber - 1,
                $this->itemsPerPage
            );


        $total =
            $resultado["total"];


        $viewData = [

            "usuarios" =>
            $resultado["usuarios"],


            "pagination" =>
            Paging::getPagination(
                $total,
                $this->itemsPerPage,
                $this->pageNumber,
                "index.php?page=Security_RolesUsuarios",
                "Security_RolesUsuarios"
            )

        ];



        Renderer::render(
            "security/rolesusuarios",
            $viewData
        );
    }
}
