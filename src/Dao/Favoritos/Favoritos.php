<?php

namespace Dao\Favoritos;

class Favoritos extends \Dao\Table
{
    public static function agregarFavorito($usercod, $producto_id)
    {
        $sql = "INSERT IGNORE INTO favoritos
                (usercod, producto_id)
                VALUES
                (:usercod, :producto_id);";

        return self::executeNonQuery(
            $sql,
            [
                "usercod" => $usercod,
                "producto_id" => $producto_id
            ]
        );
    }

    public static function eliminarFavorito($usercod, $producto_id)
    {
        $sql = "DELETE FROM favoritos
                WHERE usercod = :usercod
                AND producto_id = :producto_id;";

        return self::executeNonQuery(
            $sql,
            [
                "usercod" => $usercod,
                "producto_id" => $producto_id
            ]
        );
    }

    public static function esFavorito($usercod, $producto_id)
    {
        $sql = "SELECT COUNT(*) cantidad
                FROM favoritos
                WHERE usercod = :usercod
                AND producto_id = :producto_id;";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "usercod" => $usercod,
                "producto_id" => $producto_id
            ]
        );

        return $resultado["cantidad"] > 0;
    }

    public static function contarFavoritos($usercod)
    {
        $sql = "SELECT COUNT(*) cantidad
                FROM favoritos
                WHERE usercod = :usercod;";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "usercod" => $usercod
            ]
        );

        return intval($resultado["cantidad"]);
    }

    public static function getFavoritos($usercod)
    {
        $sql = "
        SELECT
            p.producto_id,
            p.producto_nombre,
            p.producto_descripcion,
            p.producto_precio,
            p.producto_stock,

            c.categoria_nombre,

            m.marca_nombre,

            COALESCE(
                pl.plataforma_nombre,
                'Sin plataforma'
            ) AS plataforma_nombre,

            COALESCE(
                img.imagen_ruta,
                'public/img/no-image.png'
            ) AS imagen_ruta

        FROM favoritos f

        INNER JOIN productos p
            ON f.producto_id = p.producto_id

        INNER JOIN categorias c
            ON p.categoria_id = c.categoria_id

        INNER JOIN marcas m
            ON p.marca_id = m.marca_id

        LEFT JOIN plataformas pl
            ON p.plataforma_id = pl.plataforma_id

        LEFT JOIN producto_imagenes img
            ON img.imagen_id = (
                SELECT imagen_id
                FROM producto_imagenes
                WHERE producto_id = p.producto_id
                  AND imagen_estado = 'ACT'
                ORDER BY
                    imagen_principal DESC,
                    imagen_orden ASC
                LIMIT 1
            )

        WHERE
            f.usercod = :usercod
        AND
            p.producto_estado = 'ACT'
        AND
            p.producto_activo_web = 'ACT'

        ORDER BY
            f.favorito_fecha DESC;
    ";

        return self::obtenerRegistros(
            $sql,
            [
                "usercod" => $usercod
            ]
        );
    }
}
