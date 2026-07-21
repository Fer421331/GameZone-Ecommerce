<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;
use Utilities\Site;

class RolUsuario extends PrivateController
{
    private $usercod = 0;
    private $usuario = [];
    private $rolesAsignados = [];
    private $rolesDisponibles = [];

    public function run(): void
    {
        if (!isset($_GET["usercod"])) {
            Site::redirectTo("index.php?page=Security_RolesUsuarios");
        }

        $this->usercod = intval($_GET["usercod"]);

        $usuarios = SecurityDAO::getUsuarios();

        foreach ($usuarios as $usr) {
            if ($usr["usercod"] == $this->usercod) {
                $this->usuario = $usr;
                break;
            }
        }

        $this->rolesAsignados = SecurityDAO::getRolesByUsuario($this->usercod);
        $this->rolesDisponibles = SecurityDAO::getUnAssignedRoles($this->usercod);

        if ($this->isPostBack()) {

            if (isset($_POST["btnAgregar"])) {

                SecurityDAO::assignRolToUser(
                    $this->usercod,
                    $_POST["rolescod"]
                );

                Site::redirectTo(
                    "index.php?page=Security_RolUsuario&usercod=".$this->usercod
                );
            }

            if (isset($_POST["btnEliminar"])) {

                SecurityDAO::removeRolFromUser(
                    $this->usercod,
                    $_POST["rolescod"]
                );

                Site::redirectTo(
                    "index.php?page=Security_RolUsuario&usercod=".$this->usercod
                );
            }
        }

        Renderer::render(
            "security/rolusuario",
            get_object_vars($this)
        );
    }
}