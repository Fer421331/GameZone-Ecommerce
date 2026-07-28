<?php

namespace Controllers\Productos;

use Controllers\PrivateController;
use Dao\Productos\Productos as ProductosDao;
use Utilities\Site;
use Views\Renderer;

class Producto extends PrivateController
{
    private $viewData = [];
    private $mode = "DSP";

    private $modeDescriptions = [
        "DSP" => "Detalle del producto %s",
        "INS" => "Nuevo producto",
        "UPD" => "Editar producto %s",
        "DEL" => "Desactivar producto %s"
    ];

    private $producto = [
        "producto_id" => "",
        "categoria_id" => "",
        "marca_id" => "",
        "plataforma_id" => "",
        "producto_sku" => "",
        "producto_nombre" => "",
        "producto_descripcion" => "",
        "producto_costo" => "0.00",
        "producto_precio" => "0.00",
        "producto_stock" => "0",
        "producto_activo_web" => "ACT",
        "producto_estado" => "ACT"
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
                "productos/producto",
                $this->viewData
            );
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Productos_Productos",
                $ex->getMessage()
            );
        }
    }

    private function getData(): void
    {
        $this->mode = strtoupper(
            trim($_GET["mode"] ?? "DSP")
        );

        if (!isset($this->modeDescriptions[$this->mode])) {
            throw new \Exception("Modo de operación inválido.");
        }

        if ($this->mode !== "INS") {
            $productoId = filter_input(
                INPUT_GET,
                "producto_id",
                FILTER_VALIDATE_INT
            );

            if (!$productoId || $productoId < 1) {
                throw new \Exception(
                    "El identificador del producto es inválido."
                );
            }

            $producto = ProductosDao::getProductoById(
                intval($productoId)
            );

            if (!$producto) {
                throw new \Exception(
                    "No se encontró el producto solicitado."
                );
            }

            $this->producto = array_merge(
                $this->producto,
                $producto
            );
        }
    }

    private function validateData(): bool
    {
        $errors = [];

        $this->producto["producto_id"] =
            trim(
                $_POST["producto_id"]
                ?? $this->producto["producto_id"]
            );

        $this->producto["categoria_id"] =
            trim($_POST["categoria_id"] ?? "");

        $this->producto["marca_id"] =
            trim($_POST["marca_id"] ?? "");

        $this->producto["plataforma_id"] =
            trim($_POST["plataforma_id"] ?? "");

        $this->producto["producto_sku"] =
            strtoupper(
                trim($_POST["producto_sku"] ?? "")
            );

        $this->producto["producto_nombre"] =
            trim($_POST["producto_nombre"] ?? "");

        $this->producto["producto_descripcion"] =
            trim($_POST["producto_descripcion"] ?? "");

        $this->producto["producto_costo"] =
            trim($_POST["producto_costo"] ?? "");

        $this->producto["producto_precio"] =
            trim($_POST["producto_precio"] ?? "");

        $this->producto["producto_stock"] =
            trim($_POST["producto_stock"] ?? "");

        $this->producto["producto_activo_web"] =
            strtoupper(
                trim($_POST["producto_activo_web"] ?? "")
            );

        $this->producto["producto_estado"] =
            strtoupper(
                trim($_POST["producto_estado"] ?? "")
            );

        $categoriaId = filter_var(
            $this->producto["categoria_id"],
            FILTER_VALIDATE_INT
        );

        if (!$categoriaId || $categoriaId < 1) {
            $errors["categoria_id_error"] =
                "Debe seleccionar una categoría.";
        } elseif (!ProductosDao::categoriaExiste($categoriaId)) {
            $errors["categoria_id_error"] =
                "La categoría seleccionada no es válida.";
        }

        $marcaId = filter_var(
            $this->producto["marca_id"],
            FILTER_VALIDATE_INT
        );

        if (!$marcaId || $marcaId < 1) {
            $errors["marca_id_error"] =
                "Debe seleccionar una marca.";
        } elseif (!ProductosDao::marcaExiste($marcaId)) {
            $errors["marca_id_error"] =
                "La marca seleccionada no es válida.";
        }

        if ($this->producto["plataforma_id"] !== "") {
            $plataformaId = filter_var(
                $this->producto["plataforma_id"],
                FILTER_VALIDATE_INT
            );

            if (
                !$plataformaId ||
                !ProductosDao::plataformaExiste($plataformaId)
            ) {
                $errors["plataforma_id_error"] =
                    "La plataforma seleccionada no es válida.";
            }
        }

        if ($this->producto["producto_sku"] === "") {
            $errors["producto_sku_error"] =
                "El SKU es obligatorio.";
        } elseif (
            strlen($this->producto["producto_sku"]) > 40
        ) {
            $errors["producto_sku_error"] =
                "El SKU no puede superar los 40 caracteres.";
        } elseif (
            ProductosDao::existeSku(
                $this->producto["producto_sku"],
                intval($this->producto["producto_id"] ?: 0)
            )
        ) {
            $errors["producto_sku_error"] =
                "Ya existe un producto con ese SKU.";
        }

        if ($this->producto["producto_nombre"] === "") {
            $errors["producto_nombre_error"] =
                "El nombre es obligatorio.";
        } elseif (
            strlen($this->producto["producto_nombre"]) > 150
        ) {
            $errors["producto_nombre_error"] =
                "El nombre no puede superar los 150 caracteres.";
        }

        if (
            strlen($this->producto["producto_descripcion"]) > 2000
        ) {
            $errors["producto_descripcion_error"] =
                "La descripción es demasiado extensa.";
        }

        if (
            !is_numeric($this->producto["producto_costo"]) ||
            floatval($this->producto["producto_costo"]) < 0
        ) {
            $errors["producto_costo_error"] =
                "Ingrese un costo válido.";
        }

        if (
            !is_numeric($this->producto["producto_precio"]) ||
            floatval($this->producto["producto_precio"]) <= 0
        ) {
            $errors["producto_precio_error"] =
                "Ingrese un precio mayor que cero.";
        }

        if (
            is_numeric($this->producto["producto_costo"]) &&
            is_numeric($this->producto["producto_precio"]) &&
            floatval($this->producto["producto_precio"]) <
            floatval($this->producto["producto_costo"])
        ) {
            $errors["producto_precio_error"] =
                "El precio no puede ser menor que el costo.";
        }

        $stock = filter_var(
            $this->producto["producto_stock"],
            FILTER_VALIDATE_INT
        );

        if ($stock === false || $stock < 0) {
            $errors["producto_stock_error"] =
                "El stock debe ser un número entero no negativo.";
        }

        if (
            !in_array(
                $this->producto["producto_activo_web"],
                ["ACT", "INA"],
                true
            )
        ) {
            $errors["producto_activo_web_error"] =
                "Seleccione una opción válida.";
        }

        if (
            !in_array(
                $this->producto["producto_estado"],
                ["ACT", "INA"],
                true
            )
        ) {
            $errors["producto_estado_error"] =
                "Seleccione un estado válido.";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->viewData[$key] = $value;
            }

            return false;
        }

        return true;
    }

    private function handlePostAction(): void
    {
        $plataformaId =
            $this->producto["plataforma_id"] === ""
                ? null
                : intval($this->producto["plataforma_id"]);

        if ($this->mode === "INS") {
            $success = ProductosDao::insertProducto(
                intval($this->producto["categoria_id"]),
                intval($this->producto["marca_id"]),
                $plataformaId,
                $this->producto["producto_sku"],
                $this->producto["producto_nombre"],
                $this->producto["producto_descripcion"],
                floatval($this->producto["producto_costo"]),
                floatval($this->producto["producto_precio"]),
                intval($this->producto["producto_stock"]),
                $this->producto["producto_activo_web"],
                $this->producto["producto_estado"]
            );

            $message = "Producto agregado correctamente.";
        } elseif ($this->mode === "UPD") {
            $success = ProductosDao::updateProducto(
                intval($this->producto["producto_id"]),
                intval($this->producto["categoria_id"]),
                intval($this->producto["marca_id"]),
                $plataformaId,
                $this->producto["producto_sku"],
                $this->producto["producto_nombre"],
                $this->producto["producto_descripcion"],
                floatval($this->producto["producto_costo"]),
                floatval($this->producto["producto_precio"]),
                intval($this->producto["producto_stock"]),
                $this->producto["producto_activo_web"],
                $this->producto["producto_estado"]
            );

            $message = "Producto actualizado correctamente.";
        } else {
            throw new \Exception(
                "La operación solicitada no es válida."
            );
        }

        if (!$success) {
            throw new \Exception(
                "No fue posible guardar el producto."
            );
        }

        Site::redirectToWithMsg(
            "index.php?page=Productos_Productos",
            $message
        );
    }

    private function handleDelete(): void
    {
        $productoId = filter_input(
            INPUT_POST,
            "producto_id",
            FILTER_VALIDATE_INT
        );

        if (
            !$productoId ||
            intval($productoId) !==
            intval($this->producto["producto_id"])
        ) {
            throw new \Exception(
                "El identificador del producto no coincide."
            );
        }

        if (!ProductosDao::deleteProducto($productoId)) {
            throw new \Exception(
                "No fue posible desactivar el producto."
            );
        }

        Site::redirectToWithMsg(
            "index.php?page=Productos_Productos",
            "Producto desactivado correctamente."
        );
    }

    private function setViewData(): void
    {
        $isReadOnly = in_array(
            $this->mode,
            ["DSP", "DEL"],
            true
        );

        $categorias = ProductosDao::getCategoriasActivas();
        $marcas = ProductosDao::getMarcasActivas();
        $plataformas = ProductosDao::getPlataformasActivas();

        foreach ($categorias as &$categoria) {
            $categoria["selected"] =
                intval($categoria["categoria_id"]) ===
                intval($this->producto["categoria_id"])
                    ? "selected"
                    : "";

            $categoria["categoria_nombre"] =
                $this->escape($categoria["categoria_nombre"]);
        }
        unset($categoria);

        foreach ($marcas as &$marca) {
            $marca["selected"] =
                intval($marca["marca_id"]) ===
                intval($this->producto["marca_id"])
                    ? "selected"
                    : "";

            $marca["marca_nombre"] =
                $this->escape($marca["marca_nombre"]);
        }
        unset($marca);

        foreach ($plataformas as &$plataforma) {
            $plataforma["selected"] =
                intval($plataforma["plataforma_id"]) ===
                intval($this->producto["plataforma_id"])
                    ? "selected"
                    : "";

            $plataforma["plataforma_nombre"] =
                $this->escape($plataforma["plataforma_nombre"]);
        }
        unset($plataforma);

        $this->producto[
            "estado_" .
            strtolower($this->producto["producto_estado"])
        ] = "selected";

        $this->producto[
            "web_" .
            strtolower($this->producto["producto_activo_web"])
        ] = "selected";

        $this->viewData = array_merge(
            $this->viewData,
            $this->escapeProduct($this->producto)
        );

        $this->viewData["mode"] = $this->mode;

        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->producto["producto_id"]
        );

        $this->viewData["categorias"] = $categorias;
        $this->viewData["marcas"] = $marcas;
        $this->viewData["plataformas"] = $plataformas;
        $this->viewData["readonly"] =
            $isReadOnly ? "readonly" : "";
        $this->viewData["disabled"] =
            $isReadOnly ? "disabled" : "";
        $this->viewData["showCommitBtn"] =
            $this->mode !== "DSP";
        $this->viewData["isDelete"] =
            $this->mode === "DEL";
        $this->viewData["producto_csrf_token"] =
            $this->getCsrfToken();
    }

    private function getCsrfToken(): string
    {
        if (empty($_SESSION["producto_csrf_token"])) {
            $_SESSION["producto_csrf_token"] =
                bin2hex(random_bytes(32));
        }

        return $_SESSION["producto_csrf_token"];
    }

    private function validateCsrfToken(): void
    {
        $token =
            $_POST["producto_csrf_token"] ?? "";

        $sessionToken =
            $_SESSION["producto_csrf_token"] ?? "";

        if (
            $token === "" ||
            $sessionToken === "" ||
            !hash_equals($sessionToken, $token)
        ) {
            throw new \Exception(
                "La solicitud expiró. Intente nuevamente."
            );
        }
    }

    private function escapeProduct(array $producto): array
    {
        foreach ($producto as $key => $value) {
            if (is_scalar($value) || $value === null) {
                $producto[$key] = $this->escape($value);
            }
        }

        return $producto;
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