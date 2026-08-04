<?php

namespace Utilities;

class UserMenu
{
    public static function getMenu(): array
    {
        if (!isset($_SESSION["login"])) {
            return [];
        }


        $userId = Security::getUserId();

        $menu = [];


        $menu[] = [
            "url" => "index.php?page=Perfil_Perfil",
            "icon" => "fas fa-user",
            "label" => "Mi Perfil"
        ];

        if (Security::isInRol($userId, "1") || Security::isInRol($userId, "4")) {

            $menu[] = [
                "url" => "index.php?page=Security_Bitacora",
                "icon" => "fas fa-clipboard-list",
                "label" => "Bitácora"
            ];

            $menu[] = [
                "url" => "index.php?page=Dashboard_Dashboard",
                "icon" => "fas fa-tachometer-alt",
                "label" => "Dashboard"
            ];

            $menu[] = [
                "url" => "index.php?page=Favoritos_Favoritos",
                "icon" => "fas fa-heart",
                "label" => "Mis Favoritos"
            ];
        }

        if (Security::isInRol($userId, "2")) {

            $menu[] = [
                "url" => "index.php?page=Security_Bitacora",
                "icon" => "fas fa-clipboard-list",
                "label" => "Bitácora"
            ];

            $menu[] = [
                "url" => "index.php?page=Dashboard_Dashboard",
                "icon" => "fas fa-store",
                "label" => "Dashboard"
            ];

            $menu[] = [
                "url" => "index.php?page=Favoritos_Favoritos",
                "icon" => "fas fa-heart",
                "label" => "Mis Favoritos"
            ];
        }

        if (Security::isInRol($userId, "3")) {

            $menu[] = [
                "url" => "index.php?page=Carrito_Carrito",
                "icon" => "fas fa-shopping-cart",
                "label" => "Mi Carrito"
            ];

            $menu[] = [
                "url" => "index.php?page=Historial_Historial",
                "icon" => "fas fa-history",
                "label" => "Mi Historial"
            ];

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