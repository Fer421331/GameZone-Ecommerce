<?php

namespace Controllers\Favoritos;

use Controllers\PrivateController;
use Dao\Favoritos\Favoritos as FavoritosDao;
use Utilities\Security;
use Utilities\Site;

class Favorito extends PrivateController
{
    public function run(): void
    {
        $usercod = Security::getUserId();

        $producto_id = intval($_GET["producto_id"] ?? 0);

        if ($producto_id <= 0) {
            Site::redirectTo("index.php?page=Catalogo_Catalogo");
            return;
        }

        if (FavoritosDao::esFavorito($usercod, $producto_id)) {

            FavoritosDao::eliminarFavorito(
                $usercod,
                $producto_id
            );

        } else {

            FavoritosDao::agregarFavorito(
                $usercod,
                $producto_id
            );
        }

        Site::redirectTo("index.php?page=Catalogo_Catalogo");
    }
}