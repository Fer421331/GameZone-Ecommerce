<?php

namespace Utilities\Gamezone;

use Dao\Table;

class Imagenes extends Table
{
    public static function guardarImagen(
        int $productoId,
        string $imagenRuta,
        int $principal = 0,
        int $orden = 1
    ): bool {

        $sql = "
            INSERT INTO producto_imagenes
            (
                producto_id,
                imagen_ruta,
                imagen_principal,
                imagen_orden
            )
            VALUES
            (
                :producto_id,
                :imagen_ruta,
                :imagen_principal,
                :imagen_orden
            );
        ";

        return self::executeNonQuery($sql, [
            "producto_id" => $productoId,
            "imagen_ruta" => $imagenRuta,
            "imagen_principal" => $principal,
            "imagen_orden" => $orden
        ]) > 0;
    }

    public static function obtenerImagenes(int $productoId): array
    {
        $sql = "
            SELECT *
            FROM producto_imagenes
            WHERE producto_id = :producto_id
              AND imagen_estado = 'ACT'
            ORDER BY imagen_orden;
        ";

        return self::obtenerRegistros($sql, [
            "producto_id" => $productoId
        ]);
    }

    public static function obtenerPrincipal(int $productoId): ?array
    {
        $sql = "
            SELECT *
            FROM producto_imagenes
            WHERE producto_id = :producto_id
              AND imagen_principal = 1
              AND imagen_estado = 'ACT'
            LIMIT 1;
        ";

        return self::obtenerUnRegistro($sql, [
            "producto_id" => $productoId
        ]);
    }

    public static function establecerPrincipal(int $imagenId): bool
    {
        $imagen = self::obtenerUnRegistro(
            "SELECT producto_id
             FROM producto_imagenes
             WHERE imagen_id = :imagen_id",
            [
                "imagen_id" => $imagenId
            ]
        );

        if (!$imagen) {
            return false;
        }

        self::executeNonQuery(
            "UPDATE producto_imagenes
             SET imagen_principal = 0
             WHERE producto_id = :producto_id",
            [
                "producto_id" => $imagen["producto_id"]
            ]
        );

        return self::executeNonQuery(
            "UPDATE producto_imagenes
             SET imagen_principal = 1
             WHERE imagen_id = :imagen_id",
            [
                "imagen_id" => $imagenId
            ]
        ) > 0;
    }

    public static function eliminarImagen(int $imagenId): bool
    {
        $sql = "
            UPDATE producto_imagenes
            SET imagen_estado = 'INA'
            WHERE imagen_id = :imagen_id;
        ";

        return self::executeNonQuery($sql, [
            "imagen_id" => $imagenId
        ]) > 0;
    }
}
