<?php

namespace Dao\Categorias;

use Dao\Table;

class Categorias extends Table
{
    public static function getCategorias(
        string $partialName = "",
        string $status = "",
        int $page = 0,
        int $itemsPerPage = 10
    ): array {

        $sql = "
        SELECT
            categoria_id,
            categoria_nombre,
            categoria_descripcion,
            categoria_estado,
            categoria_fecha_creacion,
            categoria_fecha_actualizacion
        FROM categorias
    ";

        $count = "
        SELECT COUNT(*) AS total
        FROM categorias
    ";

        $where = [];
        $params = [];


        if ($partialName !== "") {

            $where[] = "
            (
                categoria_nombre LIKE :nombre
                OR categoria_descripcion LIKE :descripcion
            )
        ";

            $params["nombre"] =
                "%" . $partialName . "%";

            $params["descripcion"] =
                "%" . $partialName . "%";
        }


        if ($status !== "") {

            $where[] =
                "categoria_estado = :estado";

            $params["estado"] =
                $status;
        }


        if (count($where) > 0) {

            $sql .= " WHERE " . implode(" AND ", $where);

            $count .= " WHERE " . implode(" AND ", $where);
        }


        $sql .= "
        ORDER BY categoria_nombre
        LIMIT " . ($page * $itemsPerPage) . ",
        " . $itemsPerPage;


        $total =
            self::obtenerUnRegistro(
                $count,
                $params
            )["total"];


        return [
            "categorias" =>
            self::obtenerRegistros(
                $sql,
                $params
            ),

            "total" =>
            intval($total)
        ];
    }

    public static function getCategoriaById(int $categoriaId): ?array
    {
        $sql = "
            SELECT
                categoria_id,
                categoria_nombre,
                categoria_descripcion,
                categoria_estado,
                categoria_fecha_creacion,
                categoria_fecha_actualizacion
            FROM categorias
            WHERE categoria_id = :categoria_id;
        ";

        return self::obtenerUnRegistro($sql, [
            "categoria_id" => $categoriaId
        ]);
    }

    public static function insertCategoria(
        string $nombre,
        string $descripcion,
        string $estado
    ): bool {

        $sql = "
            INSERT INTO categorias
            (
                categoria_nombre,
                categoria_descripcion,
                categoria_estado
            )
            VALUES
            (
                :categoria_nombre,
                :categoria_descripcion,
                :categoria_estado
            );
        ";

        return self::executeNonQuery($sql, [
            "categoria_nombre" => $nombre,
            "categoria_descripcion" => $descripcion,
            "categoria_estado" => $estado
        ]) > 0;
    }

    public static function updateCategoria(
        int $categoriaId,
        string $nombre,
        string $descripcion,
        string $estado
    ): bool {

        $sql = "
            UPDATE categorias
            SET
                categoria_nombre = :categoria_nombre,
                categoria_descripcion = :categoria_descripcion,
                categoria_estado = :categoria_estado,
                categoria_fecha_actualizacion = CURRENT_TIMESTAMP
            WHERE categoria_id = :categoria_id;
        ";

        return self::executeNonQuery($sql, [
            "categoria_id" => $categoriaId,
            "categoria_nombre" => $nombre,
            "categoria_descripcion" => $descripcion,
            "categoria_estado" => $estado
        ]) > 0;
    }

    public static function deleteCategoria(int $categoriaId): bool
    {
        $sql = "
            DELETE FROM categorias
            WHERE categoria_id = :categoria_id;
        ";

        return self::executeNonQuery($sql, [
            "categoria_id" => $categoriaId
        ]) > 0;
    }

    public static function existeNombre(
        string $nombre,
        int $categoriaId = 0
    ): bool {

        $sql = "
            SELECT COUNT(*) AS total
            FROM categorias
            WHERE categoria_nombre = :categoria_nombre
            AND categoria_id <> :categoria_id;
        ";

        $result = self::obtenerUnRegistro($sql, [
            "categoria_nombre" => $nombre,
            "categoria_id" => $categoriaId
        ]);

        return intval($result["total"]) > 0;
    }
}
