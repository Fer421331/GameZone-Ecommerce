<?php

namespace Dao\Ventas;

use Dao\Table;

class Ventas extends Table
{
    public static function getMetodoPagoId(string $nombre): int
    {
        $sql = "
            SELECT metodo_pago_id
            FROM metodos_pago
            WHERE metodo_nombre = :nombre
            LIMIT 1
        ";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "nombre" => $nombre
            ]
        );

        return intval($resultado["metodo_pago_id"]);
    }

    public static function crearVenta(
        int $usercod,
        int $direccion_id,
        int $metodo_pago_id,
        float $subtotal,
        float $total,
        string $estado = "PEN"
    ): int {

        $sql = "
            INSERT INTO ventas
            (
                usercod,
                direccion_id,
                metodo_pago_id,
                venta_subtotal,
                venta_impuesto,
                venta_descuento,
                venta_total,
                venta_estado
            )
            VALUES
            (
                :usercod,
                :direccion_id,
                :metodo_pago_id,
                :subtotal,
                0,
                0,
                :total,
                :estado
            )
        ";

        $conn = self::getConn();

        self::executeNonQuery(
            $sql,
            [
                "usercod" => $usercod,
                "direccion_id" => $direccion_id,
                "metodo_pago_id" => $metodo_pago_id,
                "subtotal" => $subtotal,
                "total" => $total,
                "estado" => $estado
            ],
            $conn
        );

        return intval($conn->lastInsertId());
    }

    public static function agregarDetalle(
        int $venta_id,
        array $producto
    ): bool {

        $sql = "
            INSERT INTO venta_detalle
            (
                venta_id,
                producto_id,
                producto_nombre,
                precio_unitario,
                cantidad,
                descuento,
                subtotal
            )
            VALUES
            (
                :venta_id,
                :producto_id,
                :producto_nombre,
                :precio,
                :cantidad,
                0,
                :subtotal
            )
        ";

        return self::executeNonQuery(
            $sql,
            [
                "venta_id" => $venta_id,
                "producto_id" => $producto["producto_id"],
                "producto_nombre" => $producto["producto_nombre"],
                "precio" => $producto["producto_precio"],
                "cantidad" => $producto["cantidad"],
                "subtotal" =>
                $producto["producto_precio"] *
                    $producto["cantidad"]
            ]
        );
    }

    public static function registrarPago(
        int $venta_id,
        int $metodo_pago_id,
        float $monto,
        string $referencia
    ): bool {

        $sql = "
            INSERT INTO pagos
            (
                venta_id,
                metodo_pago_id,
                pago_monto,
                pago_referencia,
                pago_estado
            )
            VALUES
            (
                :venta_id,
                :metodo_pago_id,
                :monto,
                :referencia,
                'APR'
            )
        ";

        return self::executeNonQuery(
            $sql,
            [
                "venta_id" => $venta_id,
                "metodo_pago_id" => $metodo_pago_id,
                "monto" => $monto,
                "referencia" => $referencia
            ]
        );
    }

    public static function descontarStock(
        int $producto_id,
        int $cantidad
    ): bool {

        $sql = "
        UPDATE productos
        SET
            producto_stock = producto_stock - :cantidad,
            producto_fecha_actualizacion = CURRENT_TIMESTAMP
        WHERE producto_id = :producto_id
        AND producto_stock >= :cantidad;
    ";

        return self::executeNonQuery(
            $sql,
            [
                "producto_id" => $producto_id,
                "cantidad" => $cantidad
            ]
        ) > 0;
    }
}
