<?php

namespace Controllers\Categorias;

use Controllers\PrivateController;
use Dao\Categorias\Categorias as CategoriasDao;
use Views\Renderer;

class Categorias extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        $this->viewData["categorias"] =
            CategoriasDao::getCategorias();

        Renderer::render(
            "categorias/categorias",
            $this->viewData
        );
    }
}
 