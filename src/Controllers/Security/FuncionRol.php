<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;
use Utilities\Site;

class FuncionRol extends PrivateController 
{
    private $rolescod = "";
    private $rol = [];
    private $funcionesAsignadas = [];
    private $funcionesDisponibles = [];

    public function run(): void
    {
        if (!isset($_GET["rolescod"])) {
            Site::redirectTo("index.php?page=Security_FuncionesRoles");
        }

        $this->rolescod = $_GET["rolescod"];

        $roles = SecurityDAO::getRoles();

        foreach ($roles as $rol) {
            if ($rol["rolescod"] == $this->rolescod) {
                $this->rol = $rol;
                break;
            }
        }

        if ($this->isPostBack()) {

            if (isset($_POST["btnAgregar"])) {

                SecurityDAO::assignFeatureToRol(
                    $this->rolescod,
                    $_POST["fncod"]
                );
            }

            if (isset($_POST["btnEliminar"])) {

                SecurityDAO::removeFeatureFromRol(
                    $_POST["fncod"],
                    $this->rolescod
                );
            }

            Site::redirectTo(
                "index.php?page=Security_FuncionRol&rolescod=" . $this->rolescod
            );
        }

        $this->funcionesAsignadas =
            SecurityDAO::getFuncionesByRol($this->rolescod);

        $this->funcionesDisponibles =
            SecurityDAO::getUnAssignedFeatures($this->rolescod);

        $viewData = [
            "rolescod" => $this->rolescod,
            "rol" => $this->rol,
            "funcionesAsignadas" => $this->funcionesAsignadas,
            "funcionesDisponibles" => $this->funcionesDisponibles
        ];

        Renderer::render(
            "security/funcionrol",
            $viewData
        );
    }
}