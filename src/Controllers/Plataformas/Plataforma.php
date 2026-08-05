<?php

namespace Controllers\Plataformas;

use Controllers\PrivateController;
use Dao\Plataformas\Plataformas as PlataformasDao;
use Utilities\Site;
use Utilities\Bitacora;
use Views\Renderer;


class Plataforma extends PrivateController
{

    private array $viewData = [];

    private string $mode = "DSP";


    private array $modeDescriptions = [

        "DSP" => "Detalle de plataforma %s",
        "INS" => "Nueva plataforma",
        "UPD" => "Editar plataforma %s",
        "DEL" => "Eliminar plataforma %s"

    ];



    private array $plataforma = [

        "plataforma_id" => "",
        "plataforma_nombre" => "",
        "plataforma_descripcion" => "",
        "plataforma_estado" => "ACT"

    ];



    public function run(): void
    {

        try {

            $this->getData();


            if ($this->isPostBack()) {

                $this->validateCsrfToken();


                if ($this->mode === "DEL") {

                    $this->handleDelete();

                } elseif ($this->validateData()) {

                    $this->handlePostAction();

                }

            }


            $this->setViewData();


            Renderer::render(
                "plataformas/plataforma",
                $this->viewData
            );


        } catch (\Exception $ex) {


            Site::redirectToWithMsg(
                "index.php?page=Plataformas_Plataformas",
                $ex->getMessage()
            );

        }

    }





    private function getData(): void
    {

        $this->mode =
            strtoupper(
                trim($_GET["mode"] ?? "DSP")
            );


        if (!isset($this->modeDescriptions[$this->mode])) {

            throw new \Exception(
                "Modo inválido."
            );

        }



        if ($this->mode !== "INS") {


            $id =
                filter_input(
                    INPUT_GET,
                    "plataforma_id",
                    FILTER_VALIDATE_INT
                );


            if (!$id) {

                throw new \Exception(
                    "Identificador inválido."
                );

            }



            $plataforma =
                PlataformasDao::getPlataformaById(
                    $id
                );


            if (!$plataforma) {

                throw new \Exception(
                    "Plataforma no encontrada."
                );

            }


            $this->plataforma =
                array_merge(
                    $this->plataforma,
                    $plataforma
                );

        }

    }







    private function validateData(): bool
    {

        $errors = [];


        $this->plataforma["plataforma_id"] =
            trim($_POST["plataforma_id"] ?? "");


        $this->plataforma["plataforma_nombre"] =
            trim($_POST["plataforma_nombre"] ?? "");



        $this->plataforma["plataforma_descripcion"] =
            trim($_POST["plataforma_descripcion"] ?? "");



        $this->plataforma["plataforma_estado"] =
            strtoupper(
                trim($_POST["plataforma_estado"] ?? "")
            );



        if (
            $this->plataforma["plataforma_nombre"] === ""
        ) {

            $errors["plataforma_nombre_error"] =
                "El nombre es obligatorio.";

        }


        elseif (
            strlen(
                $this->plataforma["plataforma_nombre"]
            ) > 100
        ) {

            $errors["plataforma_nombre_error"] =
                "Máximo 100 caracteres.";

        }


        elseif (
            PlataformasDao::existeNombre(
                $this->plataforma["plataforma_nombre"],
                intval(
                    $this->plataforma["plataforma_id"] ?: 0
                )
            )
        ) {

            $errors["plataforma_nombre_error"] =
                "Ya existe una plataforma con ese nombre.";

        }



        if (
            strlen(
                $this->plataforma["plataforma_descripcion"]
            ) > 2000
        ) {

            $errors["plataforma_descripcion_error"] =
                "Descripción demasiado larga.";

        }



        if (
            !in_array(
                $this->plataforma["plataforma_estado"],
                ["ACT","INA"],
                true
            )
        ) {

            $errors["plataforma_estado_error"] =
                "Estado inválido.";

        }



        if(count($errors)>0){

            $this->viewData =
                array_merge(
                    $this->viewData,
                    $errors
                );

            return false;

        }


        return true;

    }

        private function handlePostAction(): void
    {

        if ($this->mode === "INS") {


            $success =
                PlataformasDao::insertPlataforma(
                    $this->plataforma["plataforma_nombre"],
                    $this->plataforma["plataforma_descripcion"],
                    $this->plataforma["plataforma_estado"]
                );


            $message =
                "Plataforma agregada correctamente.";



            if ($success) {

                Bitacora::registrar(
                    "Plataformas",
                    "Plataforma insertada",
                    "Plataforma: " .
                    $this->plataforma["plataforma_nombre"],
                    "LOG"
                );

            }


        } elseif ($this->mode === "UPD") {


            $success =
                PlataformasDao::updatePlataforma(
                    intval(
                        $this->plataforma["plataforma_id"]
                    ),
                    $this->plataforma["plataforma_nombre"],
                    $this->plataforma["plataforma_descripcion"],
                    $this->plataforma["plataforma_estado"]
                );


            $message =
                "Plataforma actualizada correctamente.";



            if ($success) {

                Bitacora::registrar(
                    "Plataformas",
                    "Plataforma modificada",
                    "ID: " .
                    $this->plataforma["plataforma_id"],
                    "LOG"
                );

            }



        } else {

            throw new \Exception(
                "Operación inválida."
            );

        }




        if (!$success) {

            throw new \Exception(
                "No fue posible guardar la plataforma."
            );

        }



        Site::redirectToWithMsg(
            "index.php?page=Plataformas_Plataformas",
            $message
        );

    }







    private function handleDelete(): void
    {

        $id =
            filter_input(
                INPUT_POST,
                "plataforma_id",
                FILTER_VALIDATE_INT
            );



        if (
            !$id ||
            intval($id) !==
            intval($this->plataforma["plataforma_id"])
        ) {

            throw new \Exception(
                "El identificador no coincide."
            );

        }



        if (
            !PlataformasDao::deletePlataforma($id)
        ) {

            throw new \Exception(
                "No fue posible eliminar la plataforma."
            );

        }



        Bitacora::registrar(
            "Plataformas",
            "Plataforma eliminada",
            "ID: ".$id,
            "LOG"
        );



        Site::redirectToWithMsg(
            "index.php?page=Plataformas_Plataformas",
            "Plataforma desactivada correctamente."
        );

    }








    private function setViewData(): void
    {

        $readonly =
            in_array(
                $this->mode,
                ["DSP","DEL"],
                true
            );



        $this->plataforma[
            "estado_" .
            strtolower(
                $this->plataforma["plataforma_estado"]
            )
        ] = "selected";



        $this->viewData =
            array_merge(
                $this->viewData,
                $this->escapePlataforma(
                    $this->plataforma
                )
            );



        $this->viewData["mode"] =
            $this->mode;



        $this->viewData["FormTitle"] =
            sprintf(
                $this->modeDescriptions[$this->mode],
                $this->plataforma["plataforma_id"]
            );



        $this->viewData["readonly"] =
            $readonly ? "readonly" : "";



        $this->viewData["disabled"] =
            $readonly ? "disabled" : "";



        $this->viewData["showCommitBtn"] =
            $this->mode !== "DSP";



        $this->viewData["isDelete"] =
            $this->mode === "DEL";



        $this->viewData["plataforma_csrf_token"] =
            $this->getCsrfToken();

    }







    private function getCsrfToken(): string
    {

        if (
            empty(
                $_SESSION["plataforma_csrf_token"]
            )
        ) {

            $_SESSION["plataforma_csrf_token"] =
                bin2hex(
                    random_bytes(32)
                );

        }


        return $_SESSION["plataforma_csrf_token"];

    }







    private function validateCsrfToken(): void
    {

        $token =
            $_POST["plataforma_csrf_token"] ?? "";


        $sessionToken =
            $_SESSION["plataforma_csrf_token"] ?? "";



        if (
            $token === "" ||
            $sessionToken === "" ||
            !hash_equals(
                $sessionToken,
                $token
            )
        ) {

            throw new \Exception(
                "La solicitud expiró."
            );

        }

    }







    private function escapePlataforma(array $data): array
    {

        foreach($data as $key=>$value){

            if(
                is_scalar($value) ||
                $value === null
            ){

                $data[$key] =
                    $this->escape($value);

            }

        }


        return $data;

    }

    private function escape($value): string
    {

        return htmlspecialchars(
            strval($value ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

    }
}