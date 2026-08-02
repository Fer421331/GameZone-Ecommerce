<?php

namespace Dao\Historial;

use Dao\Table;

class Historial extends Table
{
    public static function getHistorial(string $usercod): array
    {
        $sql = "
            SELECT
                venta_id,
                venta_fecha,
                venta_total,
                venta_estado
            FROM ventas
            WHERE usercod = :usercod
            ORDER BY venta_fecha DESC;
        ";

        return self::obtenerRegistros(
            $sql,
            [
                "usercod" => $usercod
            ]
        );
    }

    public static function getDetalleVenta(int $ventaId): array
    {
        $sql = "
            SELECT
                producto_nombre,
                precio_unitario,
                cantidad,
                subtotal
            FROM venta_detalle
            WHERE venta_id = :venta_id
            ORDER BY detalle_venta_id;
        ";

        return self::obtenerRegistros(
            $sql,
            [
                "venta_id" => $ventaId
            ]
        );
    }
}