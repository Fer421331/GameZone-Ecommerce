<?php

namespace Utilities;

class UserMenu
{
    public static function getMenu(): array
    {
        if (!Security::isLogged()) {
            return [];
        }


        $userId = Security::getUserId();

        $menu = [];


        $menu[] = [
            "url" => "index.php?page=Perfil_Perfil",
            "icon" => "fas fa-user",
            "label" => "Mi Perfil"
        ];



        if (
            Security::isAuthorized(
                $userId,
                "Menu_Dashboard"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Dashboard_Dashboard",
                "icon" => "fas fa-tachometer-alt",
                "label" => "Dashboard"
            ];
        }



        if (
            Security::isAuthorized(
                $userId,
                "Bitacora_Menu"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Security_Bitacora",
                "icon" => "fas fa-clipboard-list",
                "label" => "Bitácora"
            ];
        }


        if (
            Security::isAuthorized(
                $userId,
                "Menu_Productos"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Productos_Productos",
                "icon" => "fas fa-gamepad",
                "label" => "Productos"
            ];
        }



        if (
            Security::isAuthorized(
                $userId,
                "Menu_Categorias"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Categorias_Categorias",
                "icon" => "fas fa-list",
                "label" => "Categorías"
            ];
        }

        if (
            Security::isAuthorized(
                $userId,
                "Controllers\DireccionesUsuario\DireccionesUsuarios"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=DireccionesUsuario_DireccionesUsuarios",
                "icon" => "fas fa-map-marker-alt",
                "label" => "Direcciones de entrega"
            ];
        }

        if (
            Security::isAuthorized(
                $userId,
                "Menu_Carrito"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Carrito_Carrito",
                "icon" => "fas fa-shopping-cart",
                "label" => "Mi Carrito"
            ];
        }



        if (
            Security::isAuthorized(
                $userId,
                "Menu_Historial"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Historial_Historial",
                "icon" => "fas fa-history",
                "label" => "Mi Historial"
            ];
        }



        if (
            Security::isAuthorized(
                $userId,
                "Menu_Favoritos"
            )
        ) {

            $menu[] = [
                "url" => "index.php?page=Favoritos_Favoritos",
                "icon" => "fas fa-heart",
                "label" => "Mis Favoritos"
            ];
        }

        $menu[] = [
            "url" => "index.php?page=sec_logout",
            "icon" => "fas fa-sign-out-alt",
            "label" => "Cerrar Sesión"
        ];


        return $menu;
    }
}
