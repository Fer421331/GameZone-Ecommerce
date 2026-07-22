<?php

namespace Controllers\Categorias;

use Controllers\PrivateController;
use Dao\Categorias\Categorias as CategoriasDao;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class Categoria extends PrivateController
{
    private $viewData = [];
    private $mode = "DSP";

    private $modeDescriptions = [
        "DSP" => "Detalle Categoría %s",
        "INS" => "Nueva Categoría",
        "UPD" => "Editar Categoría %s",
        "DEL" => "Eliminar Categoría %s"
    ];

    private $readonly = "";
    private $showCommitBtn = true;

    private $categoria = [
        "categoria_id" => "",
        "categoria_nombre" => "",
        "categoria_descripcion" => "",
        "categoria_estado" => "ACT"
    ];

    private $categoria_xss_token = "";

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
                "categorias/categoria",
                $this->viewData
            );
        } catch (\Exception $ex) {

            Site::redirectToWithMsg(
                "index.php?page=Categorias_Categorias",
                $ex->getMessage()
            );
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";

        if (!isset($this->modeDescriptions[$this->mode])) {
            throw new \Exception("Modo inválido");
        }

        $this->readonly =
            (
                $this->mode == "DSP" ||
                $this->mode == "DEL"
            )
            ? "readonly"
            : "";

        $this->viewData["disabled"] =
            (
                $this->mode == "DSP" ||
                $this->mode == "DEL"
            )
            ? "disabled"
            : "";

        $this->showCommitBtn =
            ($this->mode != "DSP");

        if ($this->mode != "INS") {

            $this->categoria =
                CategoriasDao::getCategoriaById(
                    intval($_GET["categoria_id"])
                );

            if (!$this->categoria) {
                throw new \Exception(
                    "No se encontró la categoría"
                );
            }
        }
    }

    private function validateData()
    {
        $errors = [];

        $this->categoria_xss_token =
            $_POST["categoria_xss_token"] ?? "";

        $this->categoria["categoria_id"] =
            strval($_POST["categoria_id"] ?? 0);

        $this->categoria["categoria_nombre"] =
            trim($_POST["categoria_nombre"] ?? "");

        $this->categoria["categoria_descripcion"] =
            trim($_POST["categoria_descripcion"] ?? "");

        $this->categoria["categoria_estado"] =
            trim($_POST["categoria_estado"] ?? "");

        if (Validators::IsEmpty($this->categoria["categoria_nombre"])) {
            $errors["categoria_nombre_error"] =
                "Nombre requerido";
        }

        if (
            CategoriasDao::existeNombre(
                $this->categoria["categoria_nombre"],
                intval($this->categoria["categoria_id"])
            )
        ) {
            $errors["categoria_nombre_error"] =
                "La categoría ya existe";
        }

        if (Validators::IsEmpty($this->categoria["categoria_estado"])) {
            $errors["categoria_estado_error"] =
                "Estado requerido";
        }

        if (count($errors) > 0) {

            foreach ($errors as $key => $value) {
                $this->categoria[$key] = $value;
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
            CategoriasDao::insertCategoria(
                $this->categoria["categoria_nombre"],
                $this->categoria["categoria_descripcion"],
                $this->categoria["categoria_estado"]
            )
        ) {

            Site::redirectToWithMsg(
                "index.php?page=Categorias_Categorias",
                "Categoría agregada correctamente"
            );
        }
    }

    private function handleUpdate()
    {
        if (
            CategoriasDao::updateCategoria(
                intval($this->categoria["categoria_id"]),
                $this->categoria["categoria_nombre"],
                $this->categoria["categoria_descripcion"],
                $this->categoria["categoria_estado"]
            )
        ) {

            Site::redirectToWithMsg(
                "index.php?page=Categorias_Categorias",
                "Categoría actualizada correctamente"
            );
        }
    }

    private function handleDelete()
    {
        if (
            CategoriasDao::deleteCategoria(
                intval($this->categoria["categoria_id"])
            )
        ) {

            Site::redirectToWithMsg(
                "index.php?page=Categorias_Categorias",
                "Categoría eliminada correctamente"
            );
        }
    }

    private function setViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["categoria_xss_token"] =
            $this->categoria_xss_token;

        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->categoria["categoria_id"]
        );

        $this->viewData["showCommitBtn"] =
            $this->showCommitBtn;

        $this->viewData["readonly"] =
            $this->readonly;

        $this->viewData["disabled"] =
            (
                $this->mode == "DSP" ||
                $this->mode == "DEL"
            )
            ? "disabled"
            : "";

        $statusKey =
            "estado_" .
            strtolower($this->categoria["categoria_estado"]);

        $this->categoria[$statusKey] = "selected";

        $this->viewData = array_merge(
            $this->viewData,
            $this->categoria
        );

        $this->viewData["categoria"] =
            $this->categoria;
    }
}
