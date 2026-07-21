<?php

namespace Controllers\RutasEntrega;

use Controllers\PublicController;
use Views\Renderer;
use Dao\RutasEntrega\RutasEntrega as RutasEntregaDao;
use Utilities\Site;
use Utilities\Validators;

class RutaEntrega extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";

    private $modeDescriptions = [
        "DSP" => "Detalle Ruta %s",
        "INS" => "Nueva Ruta",
        "UPD" => "Editar Ruta %s",
        "DEL" => "Eliminar Ruta %s"
    ];

    private $readonly = "";
    private $showCommitBtn = true;

    private $ruta = [
        "id_ruta" => "",
        "origen" => "",
        "destino" => "",
        "distancia_km" => "",
        "duracion_min" => "",
        "estado" => "ACT"
    ];

    private $ruta_xss_token = "";

    public function run(): void
    {
        try {

            $this->getData();

            if ($this->isPostBack()) {

                if ($this->mode == "DEL") {

                    $this->handleDelete();

                } else {

                    if ($this->validateData()) {
                        $this->handlePostAction();
                    }

                }

            }

            $this->setViewData();

            Renderer::render(
                "rutasentrega/rutaentrega",
                $this->viewData
            );

        } catch (\Exception $ex) {

            Site::redirectToWithMsg(
                "index.php?page=RutasEntrega_RutasEntrega",
                $ex->getMessage()
            );

        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";

        if (isset($this->modeDescriptions[$this->mode])) {

            $this->readonly =
                ($this->mode == "DEL")
                ? "readonly"
                : "";

            $this->showCommitBtn =
                ($this->mode != "DSP");

            if ($this->mode != "INS") {

                $this->ruta =
                    RutasEntregaDao::getRutaEntregaById(
                        $_GET["id_ruta"]
                    );

                if (!$this->ruta) {
                    throw new \Exception(
                        "No se encontró la Ruta"
                    );
                }

            }

        } else {

            throw new \Exception(
                "Modo inválido"
            );

        }
    }
        private function validateData()
    {
        $errors = [];

        $this->ruta_xss_token = $_POST["ruta_xss_token"] ?? "";

        $this->ruta["id_ruta"] = strval($_POST["id_ruta"] ?? "");
        $this->ruta["origen"] = strval($_POST["origen"] ?? "");
        $this->ruta["destino"] = strval($_POST["destino"] ?? "");
        $this->ruta["distancia_km"] = strval($_POST["distancia_km"] ?? "");
        $this->ruta["duracion_min"] = strval($_POST["duracion_min"] ?? "");
        $this->ruta["estado"] = strval($_POST["estado"] ?? "");

        if (Validators::IsEmpty($this->ruta["origen"])) {
            $errors["origen_error"] = "Origen requerido";
        }

        if (Validators::IsEmpty($this->ruta["destino"])) {
            $errors["destino_error"] = "Destino requerido";
        }

        if (Validators::IsEmpty($this->ruta["distancia_km"])) {
            $errors["distancia_km_error"] = "Distancia requerida";
        }

        if (Validators::IsEmpty($this->ruta["duracion_min"])) {
            $errors["duracion_min_error"] = "Duración requerida";
        }

        if (Validators::IsEmpty($this->ruta["estado"])) {
            $errors["estado_error"] = "Estado requerido";
        }

        if (count($errors) > 0) {

            foreach ($errors as $key => $value) {
                $this->ruta[$key] = $value;
            }

            return false;
        }

        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {

            case "INS":
                $this->handleInsert();
                break;

            case "UPD":
                $this->handleUpdate();
                break;

            case "DEL":
                $this->handleDelete();
                break;

            default:
                throw new \Exception("Modo inválido");
        }
    }
        private function handleInsert()
    {
        if (
            RutasEntregaDao::insertRutaEntrega(
                $this->ruta["origen"],
                $this->ruta["destino"],
                $this->ruta["distancia_km"],
                $this->ruta["duracion_min"],
                $this->ruta["estado"]
            )
        ) {
            Site::redirectToWithMsg(
                "index.php?page=RutasEntrega_RutasEntrega",
                "Ruta agregada correctamente"
            );
        }
    }

    private function handleUpdate()
    {
        if (
            RutasEntregaDao::updateRutaEntrega(
                $this->ruta["id_ruta"],
                $this->ruta["origen"],
                $this->ruta["destino"],
                $this->ruta["distancia_km"],
                $this->ruta["duracion_min"],
                $this->ruta["estado"]
            )
        ) {
            Site::redirectToWithMsg(
                "index.php?page=RutasEntrega_RutasEntrega",
                "Ruta actualizada correctamente"
            );
        }
    }

    private function handleDelete()
    {
        if (
            RutasEntregaDao::deleteRutaEntrega(
                $this->ruta["id_ruta"]
            )
        ) {
            Site::redirectToWithMsg(
                "index.php?page=RutasEntrega_RutasEntrega",
                "Ruta eliminada correctamente"
            );
        }
    }
        private function setViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["ruta_xss_token"] = $this->ruta_xss_token;

        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->ruta["id_ruta"]
        );

        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;

        $statusKey = "estado_" . strtolower($this->ruta["estado"]);
        $this->ruta[$statusKey] = "selected";

        $this->viewData = array_merge(
            $this->viewData,
            $this->ruta
        );

        $this->viewData["ruta"] = $this->ruta;
    }
}