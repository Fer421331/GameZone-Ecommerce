<?php

namespace Controllers\Favoritos;

use Controllers\PrivateController;
use Dao\Favoritos\Favoritos as FavoritosDao;
use Utilities\Security;
use Views\Renderer;

class Favoritos extends PrivateController
{
    public function run(): void
    {
        $usercod = Security::getUserId();

        $favoritos = FavoritosDao::getFavoritos($usercod);

        Renderer::render(
            "favoritos/favoritos",
            [
                "favoritos" => $favoritos
            ]
        );
    }
}