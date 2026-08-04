<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Dao\Security\Bitacora as BitacoraDAO;
use Views\Renderer;

class Bitacora extends PrivateController
{
    public function run(): void
    {
        $viewData = [
            "bitacora" => BitacoraDAO::obtenerBitacora()
        ];

        Renderer::render(
            "security/bitacora",
            $viewData
        );
    }
}