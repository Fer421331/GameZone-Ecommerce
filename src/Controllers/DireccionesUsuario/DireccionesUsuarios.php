<?php

namespace Controllers\DireccionesUsuario;

use Controllers\PrivateController;
use Dao\DireccionesUsuario\DireccionesUsuario as DireccionesDao;
use Utilities\Security;
use Views\Renderer;
use Utilities\Site;

class DireccionesUsuarios extends PrivateController
{
    private array $viewData = [];

    public function run(): void
    {

        $usercod = strval(
            Security::getUserId()
        );


        if (
            isset($_GET["action"])
            &&
            $_GET["action"] == "principal"
        ) {

            DireccionesDao::setDireccionPredeterminada(

                $usercod,

                intval($_GET["direccion_id"])

            );


            Site::redirectToWithMsg(

                "index.php?page=DireccionesUsuario_DireccionesUsuarios",

                "Dirección seleccionada como principal"

            );

            return;
        }




        $this->viewData["direcciones"] =
            DireccionesDao::getDireccionesUsuario(
                $usercod
            );


        Renderer::render(
            "direccionesusuario/direccionesusuarios",
            $this->viewData
        );
    }
}
