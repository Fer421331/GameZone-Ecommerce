<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Dao\Security\Security as SecurityDAO;
use Views\Renderer;
use Utilities\Site;
use Utilities\Validators;
use Utilities\Bitacora;

class Funcion extends PrivateController
{
    private $viewData = [];
    private $mode = "DSP";

    private $funcion = [
        "fncod" => "",
        "fndsc" => "",
        "fnest" => "ACT",
        "fntyp" => ""
    ];

    private $modeDescriptions = [
        "DSP" => "Detalle de %s",
        "INS" => "Nueva Función",
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
                "security/funcion",
                $this->viewData
            );
        } catch (\Exception $e) {

            Site::redirectToWithMsg(
                "index.php?page=Security_Funciones",
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
                $_GET["fncod"] ?? "";


            if ($id === "") {

                throw new \Exception(
                    "Falta código de función"
                );
            }


            $this->funcion =
                SecurityDAO::getFuncionById($id);


            if (!$this->funcion) {

                throw new \Exception(
                    "Función no encontrada"
                );
            }
        }
    }


    private function validateData(): bool
    {
        $errors = [];


        $this->funcion["fncod"] =
            trim(
                $_POST["fncod"] ?? ""
            );


        $this->funcion["fndsc"] =
            trim(
                $_POST["fndsc"] ?? ""
            );


        $this->funcion["fnest"] =
            $_POST["fnest"] ?? "ACT";


        $this->funcion["fntyp"] =
            trim(
                $_POST["fntyp"] ?? ""
            );


        if ($this->mode === "INS") {

            if ($this->funcion["fncod"] === "") {

                $errors["fncod_error"] =
                    "El código es obligatorio";
            } else {

                $existing =
                    SecurityDAO::getFuncionById(
                        $this->funcion["fncod"]
                    );


                if ($existing) {

                    $errors["fncod_error"] =
                        "El código ya existe";
                }
            }
        }


        if (Validators::IsEmpty(
            $this->funcion["fndsc"]
        )) {

            $errors["fndsc_error"] =
                "La descripción es obligatoria";
        }


        if (Validators::IsEmpty(
            $this->funcion["fntyp"]
        )) {

            $errors["fntyp_error"] =
                "El tipo es obligatorio";
        }


        if (!in_array(
            $this->funcion["fnest"],
            ["ACT", "INA"]
        )) {

            $errors["fnest_error"] =
                "Estado inválido";
        }


        if (count($errors) > 0) {

            foreach ($errors as $key => $value) {

                $this->funcion[$key] =
                    $value;
            }


            return false;
        }


        return true;
    }


    private function handlePost(): void
    {
        switch ($this->mode) {


            case "INS":

                SecurityDAO::insertFuncion(
                    $this->funcion["fncod"],
                    $this->funcion["fndsc"],
                    $this->funcion["fnest"],
                    $this->funcion["fntyp"]
                );

                Bitacora::registrar(
                    "Funciones",
                    "Función creada",
                    "Código: " . $this->funcion["fncod"],
                    "LOG"
                );

                break;

            case "UPD":

                SecurityDAO::updateFuncion(
                    $this->funcion["fncod"],
                    $this->funcion["fndsc"],
                    $this->funcion["fnest"],
                    $this->funcion["fntyp"]
                );

                Bitacora::registrar(
                    "Funciones",
                    "Función modificada",
                    "Código: " . $this->funcion["fncod"],
                    "LOG"
                );

                break;

            case "DEL":

                SecurityDAO::deleteFuncion(
                    $this->funcion["fncod"]
                );

                Bitacora::registrar(
                    "Funciones",
                    "Función eliminada",
                    "Código: " . $this->funcion["fncod"],
                    "WAR"
                );

                break;
        }


        Site::redirectToWithMsg(
            "index.php?page=Security_Funciones&clear=1",
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
                $this->funcion["fncod"]
            );


        $this->viewData["funcion"] =
            $this->funcion;


        $this->viewData["readonly"] =
            $this->readonly;


        $this->viewData["showCommitBtn"] =
            $this->showCommitBtn;
    }
}
