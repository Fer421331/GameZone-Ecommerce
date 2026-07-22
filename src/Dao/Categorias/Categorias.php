<?php

namespace Dao\Categorias;

use Dao\Table;

class Categorias extends Table
{
    public static function getCategorias(): array
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
            ORDER BY categoria_nombre;
        ";

        return self::obtenerRegistros($sql, []);
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
