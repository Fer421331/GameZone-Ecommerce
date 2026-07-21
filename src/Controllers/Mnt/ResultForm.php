<?php

namespace Controllers\Mnt;

use Exception;
use DateTime;
use Controllers\PublicController;
use Views\Renderer;
use Dao\Mantenimiento\WcResult as ResultDAO;
use Utilities\Site;
use Utilities\Validators;

const LIST_VIEW_URI = "index.php?page=Mnt-ResultList";
const FORM_VIEW_URI = "index.php?page=Mnt-ResultForm";
const FORM_VIEW_TEMPLATE = "mnt/form";

class ResultForm extends PublicController
{
    private string $mode = "NAS"; // Not Assigned as defualt
    private array  $modes = [
        "INS" => "Creando Nuevo Resultado",
        "UPD" => "Editar Resultados de %s - %s",
        "DEL" => "Eliminar Resultados de %s - %s",
        "DSP" => "Resultados de %s - %s"
    ];
    private array $resultado = [
        "id" => null,
        "equipo_a" => "",
        "equipo_b" => "",
        "resumen" => "",
        "score_a" => 0,
        "score_b" => 0,
        "fecha" => null
    ];
    private $errors = [];

    /*
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    equipo_a VARCHAR(255),
    equipo_b VARCHAR(255),
    resumen VARCHAR(255),
    score_a INT,
    score_b INT,
    fecha DATE
    */

    public function run(): void
    {
        /*
           --> Capturar los query params (mode, id)
           --> SI mode != INS 
           -->   Extraer la información del registro de la db
           --> SI es un postback 
           -->     Validar la data del formulario (POST)
           -->     SI Validado
           -->         Realizar el INS UPD DEL en la DB
           -->         Redirijir al listado despues de mostrar el mensaje
           -->     SINO
                    Mostrar el error en el formulario para corregir.
            --> Prepara los datos de la vista
            --> Renderizar la vista
        */
        try {
            $this->getQueryParams();
            if ($this->isPostBack()) {
                $validado = $this->validarPostData();
                if ($validado) {
                    $this->procesarPost();
                }
            }

            $this->mostrarVista();
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(
                LIST_VIEW_URI,
                "Algo inesperado occurio, vuelva a intentar. Si el error persiste contacte con el administrador."
                //$ex->getMessage()
            );
        }
    }

    private function getQueryParams()
    {
        $this->mode = $_GET["mode"] ?? "NAS";
        if (!isset($this->modes[$this->mode])) {
            throw new Exception("Modo no adecuado");
        }
        if ($this->mode !== "INS") {
            $this->resultado["id"] = intval($_GET["id"] ?? 0);
            if ($this->resultado["id"] == 0) {
                throw new Exception("ID es invalido.");
            }
            $resultadoFromDb = ResultDAO::getById($this->resultado["id"]);

            $this->resultado["equipo_a"] = $resultadoFromDb["equipo_a"];
            $this->resultado["equipo_b"] = $resultadoFromDb["equipo_b"];
            $this->resultado["resumen"] = $resultadoFromDb["resumen"];
            $this->resultado["score_a"] = $resultadoFromDb["score_a"];
            $this->resultado["score_b"] = $resultadoFromDb["score_b"];
            $this->resultado["fecha"] = $resultadoFromDb["fecha"];
        }
    }

    private function validarPostData(): bool
    {
        $tmp_mode = $_POST["mode"] ?? 'NAP';
        if (!isset($this->modes[$tmp_mode])) {
            throw new Exception("Error modo no es válido");
        }
        $equipo_a = $_POST["equipo_a"] ?? '';
        $equipo_b = $_POST["equipo_b"] ?? '';
        $resumen = $_POST["resumen"] ?? '';
        $score_a = intval($_POST["score_a"] ?? '0');
        $score_b =  intval($_POST["score_b"] ?? '0');

        if (Validators::IsEmpty($equipo_a)) {
            $this->addViewError("Campo requiere de un valor", "equipo_a");
        }
        if (Validators::IsEmpty($equipo_b)) {
            $this->addViewError("Campo requiere de un valor", "equipo_b");
        }
        if (Validators::IsEmpty($resumen)) {
            $this->addViewError("Campo requiere de un valor", "resumen");
        }

        $this->resultado["equipo_a"] = $equipo_a;
        $this->resultado["equipo_b"] = $equipo_b;
        $this->resultado["resumen"] = $resumen;
        $this->resultado["score_a"] = $score_a;
        $this->resultado["score_b"] = $score_b;


        return count($this->errors) <= 0;
    }

    private function procesarPost(): void
    {
        switch ($this->mode) {
            case "INS":
                if (ResultDAO::create(
                    $this->resultado["equipo_a"],
                    $this->resultado["equipo_b"],
                    $this->resultado["resumen"],
                    $this->resultado["score_a"],
                    $this->resultado["score_b"],
                    new DateTime()
                ) > 0) {
                    Site::redirectToWithMsg(LIST_VIEW_URI, "Resultado Creado Satisfactoriamente!!!!");
                } else {
                    $this->addViewError("No se pudo insertar nuevo registro");
                }
                break;
            case "UPD":
                if (ResultDAO::update(
                    $this->resultado["id"],
                    $this->resultado["equipo_a"],
                    $this->resultado["equipo_b"],
                    $this->resultado["resumen"],
                    $this->resultado["score_a"],
                    $this->resultado["score_b"],
                    new DateTime()
                ) > 0) {
                    Site::redirectToWithMsg(LIST_VIEW_URI, "Resultado Actualizado Satisfactoriamente!!!!");
                } else {
                    $this->addViewError("No se actualizó registro");
                }
                break;
            case "DEL":
                if (ResultDAO::delete(
                    $this->resultado["id"]
                ) > 0) {
                    Site::redirectToWithMsg(LIST_VIEW_URI, "Resultado Eliminado Satisfactoriamente!!!!");
                } else {
                    $this->addViewError("No se eliminó registro");
                }
                break;
        }
    }

    private function mostrarVista()
    {
        $dataView = [];
        $dataView["mode"] = $this->mode;
        $dataView["modeDsc"] = ($this->mode === "INS") ?
            $this->modes[$this->mode]
            : sprintf(
                $this->modes[$this->mode],
                $this->resultado["equipo_a"],
                $this->resultado["equipo_b"]
            );
        $dataView["resultado"] = $this->resultado;

        if (count($this->errors)) {
            foreach ($this->errors as $scope => $errors) {
                $dataView['error_' . $scope] = $errors;
            }
        }

        // $dataView["prevalue"] = json_encode($dataView, JSON_PRETTY_PRINT);
        Renderer::render(FORM_VIEW_TEMPLATE, $dataView);
    }

    private function addViewError($errormsg, $context = "global")
    {
        if (isset($this->errors[$context])) {
            $this->errors[$context][] = $errormsg;
        } else {
            $this->errors[$context] = [$errormsg];
        }
    }
}
