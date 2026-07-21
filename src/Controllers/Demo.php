<?php

namespace Controllers;

use Dao\Profile as DAOProfile;
use DateTime;
use Views\Renderer;

const DEMO_VIEW = "demo/page";

class Demo extends PublicController
{

    function run(): void
    {
        $unRegistro = DAOProfile::ObtenerProfile();
        $variosRegistros = DAOProfile::ObtenerPerfiles();
        $fecha = (new DateTime('now'))->format("Y-m-d H:m:s");

        Renderer::render(DEMO_VIEW, [
            "perfil" => $unRegistro,
            "perfiles" => $variosRegistros,
            "fecha" => $fecha
        ]);
    }
}
