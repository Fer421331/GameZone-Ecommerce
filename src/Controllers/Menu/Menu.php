<?php

namespace Controllers\Menu;

use Controllers\PrivateController;
use Dao\Menu\Menu as DAOMenu;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;

class Menu extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        $userId = \Utilities\Security::getUserId();
        $roles = SecurityDAO::getRolesByUsuario($userId);

        $esAdministrador = false;
        $esAuditor = false;
        $esVentas = false;

        foreach ($roles as $rol) {
            if ($rol["rolescod"] == "1") {
                $esAdministrador = true;
            }

            if (strtolower($rol["rolesdsc"]) == "auditor" || $rol["rolescod"] == "4") {
                $esAuditor = true;
            }

            if ($rol["rolescod"] == "2") {
                $esVentas = true;
            }
        }

        // Definir el menú y el título según el rol
        if ($esAdministrador || $esAuditor) {
            $this->viewData["menu"] = DAOMenu::getMenuCompleto();
            $this->viewData["menu_titulo"] = "Menú Administrativo";
        } elseif ($esVentas) {
            $this->viewData["menu"] = DAOMenu::getMenuPorRoles($roles);
            $this->viewData["menu_titulo"] = "Menú Ventas";
        } else {
            // Invitado o sin rol válido: menú vacío
            $this->viewData["menu"] = [];
            $this->viewData["menu_titulo"] = "";
        }

        Renderer::render(
            "menu/menu",
            $this->viewData
        );
    }
}