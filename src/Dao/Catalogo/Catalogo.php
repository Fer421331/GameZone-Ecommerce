<?php

namespace Dao\Catalogo;

use Dao\Table;

class Catalogo extends Table
{
    public static function getCatalogo(): array
    {
        $sql = "
            SELECT
                p.producto_id,
                p.producto_nombre,
                p.producto_descripcion,
                p.producto_precio,
                p.producto_stock,
                p.producto_slug,

                c.categoria_nombre,

                m.marca_nombre,

                pl.plataforma_nombre,

                img.imagen_ruta

            FROM productos p

            INNER JOIN categorias c
                ON p.categoria_id = c.categoria_id

            INNER JOIN marcas m
                ON p.marca_id = m.marca_id

            LEFT JOIN plataformas pl
                ON p.plataforma_id = pl.plataforma_id

            LEFT JOIN producto_imagenes img
                ON p.producto_id = img.producto_id
                AND img.imagen_principal = 1
                AND img.imagen_estado = 'ACT'

            WHERE
                p.producto_estado = 'ACT'
            AND
                p.producto_activo_web = 'ACT'

            ORDER BY
                p.producto_nombre;
        ";

        return self::obtenerRegistros($sql, []);
    }

    public static function getProductoById(int $productoId): ?array
    {
        $sql = "
            SELECT
                p.producto_id,
                p.producto_nombre,
                p.producto_descripcion,
                p.producto_precio,
                p.producto_stock,
                p.producto_slug,

                c.categoria_nombre,

                m.marca_nombre,

                pl.plataforma_nombre,

                img.imagen_ruta

            FROM productos p

            INNER JOIN categorias c
                ON p.categoria_id = c.categoria_id

            INNER JOIN marcas m
                ON p.marca_id = m.marca_id

            LEFT JOIN plataformas pl
                ON p.plataforma_id = pl.plataforma_id

            LEFT JOIN producto_imagenes img
                ON p.producto_id = img.producto_id
                AND img.imagen_principal = 1
                AND img.imagen_estado = 'ACT'

            WHERE
                p.producto_id = :producto_id;
        ";

        return self::obtenerUnRegistro($sql, [
            "producto_id" => $productoId
        ]);
    }
}