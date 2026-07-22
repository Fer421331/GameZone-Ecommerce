<?php

namespace Dao\Dashboard;

use Dao\Table;

class Dashboard extends Table
{
    /**
     * 
     *
     * @return array
     */
    public static function getDashboardData()
    {
        $data = [];

        $data["totalProductos"] = self::totalProductos();
        $data["totalCategorias"] = self::totalCategorias();
        $data["totalUsuarios"] = self::totalUsuarios();
        $data["totalVentas"] = self::totalVentas();

        $data["ultimosProductos"] = self::ultimosProductos();
        $data["ultimasVentas"] = self::ultimasVentas();
        $data["stockBajo"] = self::stockBajo();

        return $data;
    }


    private static function totalProductos()
    {
        $sql = "SELECT COUNT(*) AS total FROM productos";

        $result = self::obtenerUnRegistro($sql, []);

        return $result["total"];
    }


    private static function totalCategorias()
    {
        $sql = "SELECT COUNT(*) AS total FROM categorias";

        $result = self::obtenerUnRegistro($sql, []);

        return $result["total"];
    }


    private static function totalUsuarios()
    {
        $sql = "SELECT COUNT(*) AS total FROM usuario";

        $result = self::obtenerUnRegistro($sql, []);

        return $result["total"];
    }

    private static function totalVentas()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas";

        $result = self::obtenerUnRegistro($sql, []);

        return $result["total"];
    }


    private static function ultimosProductos()
    {
        $sql = "
            SELECT
                p.producto_nombre,
                c.categoria_nombre,
                p.producto_precio,
                p.producto_stock
            FROM productos p
            INNER JOIN categorias c
                ON p.categoria_id = c.categoria_id
            ORDER BY p.producto_fecha_creacion DESC
            LIMIT 5;
        ";

        return self::obtenerRegistros($sql, []);
    }

    private static function ultimasVentas()
    {
        $sql = "
            SELECT
                v.venta_id,
                u.username,
                v.venta_fecha,
                v.venta_total,
                v.venta_estado
            FROM ventas v
            INNER JOIN usuario u
                ON v.usercod = u.usercod
            ORDER BY v.venta_fecha DESC
            LIMIT 5;
        ";

        return self::obtenerRegistros($sql, []);
    }


    private static function stockBajo()
    {
        $sql = "
            SELECT
                producto_nombre,
                producto_stock
            FROM productos
            WHERE producto_stock <= 5
            ORDER BY producto_stock ASC;
        ";

        return self::obtenerRegistros($sql, []);
    }
}
