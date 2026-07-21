<?php

namespace Controllers\RutasEntrega;

use Controllers\PublicController;
use Dao\RutasEntrega\RutasEntrega as RutasEntregaDao;
use Views\Renderer;

class RutasEntrega extends PublicController
{
    private $viewData = [];

    public function run(): void
    {
        $this->viewData["rutasentrega"] =
            RutasEntregaDao::getRutasEntrega();

        Renderer::render(
            "rutasentrega/rutasentrega",
            $this->viewData
        );
    }
}    