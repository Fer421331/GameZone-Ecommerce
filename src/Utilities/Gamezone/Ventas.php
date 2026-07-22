<?php

namespace Utilities\Gamezone;

use Dao\Table;

class Ventas extends Table
{
    public static function calcularTotales(
        float $subtotal,
        float $impuesto = 0,
        float $descuento = 0
    ): array {

        $total = $subtotal + $impuesto - $descuento;

        return [
            "subtotal" => $subtotal,
            "impuesto" => $impuesto,
            "descuento" => $descuento,
            "total" => $total
        ];
    }

    public static function crearVenta(
        int $usercod,
        int $direccionId,
        int $metodoPagoId,
        float $subtotal,
        float $impuesto,
        float $descuento,
        float $total,
        string $estado = "PEN",
        string $observaciones = ""
    ): bool {

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
                venta_estado,
                venta_observaciones
            )
            VALUES
            (
                :usercod,
                :direccion_id,
                :metodo_pago_id,
                :venta_subtotal,
                :venta_impuesto,
                :venta_descuento,
                :venta_total,
                :venta_estado,
                :venta_observaciones
            );
        ";

        return self::executeNonQuery($sql, [
            "usercod" => $usercod,
            "direccion_id" => $direccionId,
            "metodo_pago_id" => $metodoPagoId,
            "venta_subtotal" => $subtotal,
            "venta_impuesto" => $impuesto,
            "venta_descuento" => $descuento,
            "venta_total" => $total,
            "venta_estado" => $estado,
            "venta_observaciones" => $observaciones
        ]) > 0;
    }

    public static function agregarDetalle(
        int $ventaId,
        int $productoId,
        string $productoNombre,
        float $precio,
        int $cantidad,
        float $descuento = 0
    ): bool {

        $subtotal = ($precio * $cantidad) - $descuento;

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
                :precio_unitario,
                :cantidad,
                :descuento,
                :subtotal
            );
        ";

        return self::executeNonQuery($sql, [
            "venta_id" => $ventaId,
            "producto_id" => $productoId,
            "producto_nombre" => $productoNombre,
            "precio_unitario" => $precio,
            "cantidad" => $cantidad,
            "descuento" => $descuento,
            "subtotal" => $subtotal
        ]) > 0;
    }

    public static function registrarPago(
        int $ventaId,
        int $metodoPagoId,
        float $monto,
        string $referencia = "",
        string $estado = "PEN"
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
                :pago_monto,
                :pago_referencia,
                :pago_estado
            );
        ";

        return self::executeNonQuery($sql, [
            "venta_id" => $ventaId,
            "metodo_pago_id" => $metodoPagoId,
            "pago_monto" => $monto,
            "pago_referencia" => $referencia,
            "pago_estado" => $estado
        ]) > 0;
    }

    public static function actualizarEstado(
        int $ventaId,
        string $estado
    ): bool {

        $sql = "
            UPDATE ventas
            SET venta_estado = :estado
            WHERE venta_id = :venta_id;
        ";

        return self::executeNonQuery($sql, [
            "estado" => $estado,
            "venta_id" => $ventaId
        ]) > 0;
    }

    public static function obtenerVenta(int $ventaId): ?array
    {
        $sql = "
            SELECT *
            FROM ventas
            WHERE venta_id = :venta_id;
        ";

        return self::obtenerUnRegistro($sql, [
            "venta_id" => $ventaId
        ]);
    }

    public static function obtenerDetalles(int $ventaId): array
    {
        $sql = "
            SELECT *
            FROM venta_detalle
            WHERE venta_id = :venta_id;
        ";

        return self::obtenerRegistros($sql, [
            "venta_id" => $ventaId
        ]);
    }

    public static function obtenerPagos(int $ventaId): array
    {
        $sql = "
            SELECT *
            FROM pagos
            WHERE venta_id = :venta_id;
        ";

        return self::obtenerRegistros($sql, [
            "venta_id" => $ventaId
        ]);
    }
}
  
