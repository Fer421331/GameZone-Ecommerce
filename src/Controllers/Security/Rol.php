<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Dao\Security\Roles as RolesDAO;
use Views\Renderer;
use Utilities\Site;
use Utilities\Validators;
use Utilities\Bitacora;

class Rol extends PrivateController
{
    private $viewData = [];
    private $mode = "DSP";

    private $rol = [
        "rolescod" => "",
        "rolesdsc" => "",
        "rolesest" => "ACT"
    ];

    private $modeDescriptions = [
        "DSP" => "Detalle de %s",
        "INS" => "Nuevo Rol",
        "UPD" => "Editar %s",
        "DEL" => "Eliminar %s"
    ];

    private $readonly = "";
    private $showCommitBtn = true;


    public function run(): void
    {
        try {

            $this->getData();

            if ($this->isPostBack()) {

                if ($this->validateData()) {

                    $this->handlePost();
                    return;
                }
            }

            $this->setViewData();

            Renderer::render(
                "security/rol",
                $this->viewData
            );
        } catch (\Exception $e) {

            Site::redirectToWithMsg(
                "index.php?page=Security_Roles",
                $e->getMessage()
            );
        }
    }


    private function getData(): void
    {
        $this->mode =
            $_GET["mode"] ?? "NOF";


        if (!isset($this->modeDescriptions[$this->mode])) {

            throw new \Exception(
                "Modo inválido"
            );
        }


        $this->readonly =
            $this->mode === "DEL"
            ? "readonly"
            : "";


        $this->showCommitBtn =
            $this->mode !== "DSP";


        if ($this->mode !== "INS") {

            $id =
                $_GET["rolescod"] ?? "";


            if ($id === "") {

                throw new \Exception(
                    "Falta código del rol"
                );
            }


            $this->rol =
                RolesDAO::getRolById($id);


            if (!$this->rol) {

                throw new \Exception(
                    "Rol no encontrado"
                );
            }
        }
    }


    private function validateData(): bool
    {
        $errors = [];


        $this->rol["rolescod"] =
            trim(
                $_POST["rolescod"] ?? ""
            );


        $this->rol["rolesdsc"] =
            trim(
                $_POST["rolesdsc"] ?? ""
            );


        $this->rol["rolesest"] =
            $_POST["rolesest"] ?? "ACT";


        if ($this->mode === "INS") {

            if ($this->rol["rolescod"] === "") {

                $errors["rolescod_error"] =
                    "El código es obligatorio";
            } else {

                $existing =
                    RolesDAO::getRolById(
                        $this->rol["rolescod"]
                    );


                if ($existing) {

                    $errors["rolescod_error"] =
                        "El código ya existe";
                }
            }
        }


        if (Validators::IsEmpty(
            $this->rol["rolesdsc"]
        )) {

            $errors["rolesdsc_error"] =
                "La descripción es obligatoria";
        }


        if (!in_array(
            $this->rol["rolesest"],
            [
                "ACT",
                "INA"
            ]
        )) {

            $errors["rolesest_error"] =
                "Estado inválido";
        }


        if (count($errors) > 0) {

            foreach ($errors as $key => $value) {

                $this->rol[$key] = $value;
            }


            return false;
        }


        return true;
    }


    private function handlePost(): void
    {
        switch ($this->mode) {

            case "INS":

                RolesDAO::insertRol(
                    $this->rol["rolescod"],
                    $this->rol["rolesdsc"],
                    $this->rol["rolesest"]
                );

                Bitacora::registrar(
                    "Seguridad",
                    "Rol creado",
                    "Código: " . $this->rol["rolescod"] .
                        " Descripción: " . $this->rol["rolesdsc"],
                    "LOG"
                );

                break;


            case "UPD":

                RolesDAO::updateRol(
                    $this->rol["rolescod"],
                    $this->rol["rolesdsc"],
                    $this->rol["rolesest"]
                );

                RolesDAO::updateRol(
                    $this->rol["rolescod"],
                    $this->rol["rolesdsc"],
                    $this->rol["rolesest"]
                );

                break;


            case "DEL":

                RolesDAO::deleteRol(
                    $this->rol["rolescod"]
                );

                Bitacora::registrar(
                    "Seguridad",
                    "Rol eliminado",
                    "Código: " . $this->rol["rolescod"],
                    "WAR"
                );

                break;
        }


        Site::redirectToWithMsg(
            "index.php?page=Security_Roles&clear=1",
            "Operación realizada correctamente"
        );
    }


    private function setViewData(): void
    {
        $this->viewData["mode"] =
            $this->mode;


        $this->viewData["FormTitle"] =
            sprintf(
                $this->modeDescriptions[$this->mode],
                $this->rol["rolescod"]
            );


        $this->viewData["rol"] =
            $this->rol;


        $this->viewData["readonly"] =
            $this->readonly;


        $this->viewData["showCommitBtn"] =
            $this->showCommitBtn;
    }
}
