<?php

namespace Controllers\Favoritos;

use Controllers\PrivateController;
use Dao\Favoritos\Favoritos as FavoritosDao;
use Utilities\Security;
use Utilities\Site;
use Utilities\Bitacora;

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

            if (
                FavoritosDao::eliminarFavorito(
                    $usercod,
                    $producto_id
                )
            ) {

                Bitacora::registrar(
                    "Favoritos",
                    "Producto eliminado de favoritos",
                    "Usuario ID: " . $usercod .
                        " eliminó producto ID: " . $producto_id,
                    "LOG"
                );
            } else {

                Bitacora::registrar(
                    "Favoritos",
                    "Error al eliminar favorito",
                    "Usuario ID: " . $usercod .
                        " intentó eliminar producto ID: " . $producto_id,
                    "WAR"
                );
            }
        } else {

            if (
                FavoritosDao::agregarFavorito(
                    $usercod,
                    $producto_id
                )
            ) {

                Bitacora::registrar(
                    "Favoritos",
                    "Producto agregado a favoritos",
                    "Usuario ID: " . $usercod .
                        " agregó producto ID: " . $producto_id,
                    "LOG"
                );
            } else {

                Bitacora::registrar(
                    "Favoritos",
                    "Error al agregar favorito",
                    "Usuario ID: " . $usercod .
                        " intentó agregar producto ID: " . $producto_id,
                    "WAR"
                );
            }
        }

        Site::redirectTo("index.php?page=Catalogo_Catalogo");
    }
}
