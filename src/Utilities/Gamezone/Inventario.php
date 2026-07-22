<?php

namespace Utilities\Gamezone;

use Dao\Table;

class Inventario extends Table
{
    public static function hayStock(int $productoId, int $cantidad): bool
    {
        $sql = "
            SELECT producto_stock
            FROM productos
            WHERE producto_id = :producto_id;
        ";

        $producto = self::obtenerUnRegistro($sql, [
            "producto_id" => $productoId
        ]);

        if (!$producto) {
            return false;
        }

        return intval($producto["producto_stock"]) >= $cantidad;
    }

    public static function aumentarStock(int $productoId, int $cantidad): bool
    {
        $sql = "
            UPDATE productos
            SET producto_stock = producto_stock + :cantidad
            WHERE producto_id = :producto_id;
        ";

        return self::executeNonQuery($sql, [
            "cantidad" => $cantidad,
            "producto_id" => $productoId
        ]) > 0;
    }

    public static function disminuirStock(int $productoId, int $cantidad): bool
    {
        if (!self::hayStock($productoId, $cantidad)) {
            return false;
        }

        $sql = "
            UPDATE productos
            SET producto_stock = producto_stock - :cantidad
            WHERE producto_id = :producto_id;
        ";

        return self::executeNonQuery($sql, [
            "cantidad" => $cantidad,
            "producto_id" => $productoId
        ]) > 0;
    }

    public static function obtenerStock(int $productoId): int
    {
        $sql = "
            SELECT producto_stock
            FROM productos
            WHERE producto_id = :producto_id;
        ";

        $producto = self::obtenerUnRegistro($sql, [
            "producto_id" => $productoId
        ]);

        if (!$producto) {
            return 0;
        }

        return intval($producto["producto_stock"]);
    }
}
