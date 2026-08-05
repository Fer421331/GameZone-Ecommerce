<?php

namespace Dao\Ventas;

use Dao\Table;


class VentasDetalle extends Table
{


    public static function getDetallesByVenta(
        int $venta_id
    ): array {


        $sql = "
            SELECT
                vd.detalle_venta_id,
                vd.venta_id,
                vd.producto_id,
                vd.producto_nombre,
                vd.precio_unitario,
                vd.cantidad,
                vd.descuento,
                vd.subtotal

            FROM venta_detalle vd

            WHERE vd.venta_id = :venta_id

            ORDER BY
                vd.detalle_venta_id ASC
        ";


        return self::obtenerRegistros(
            $sql,
            [
                "venta_id" => $venta_id
            ]
        );

    }


}