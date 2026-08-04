<?php

namespace Dao\Carrito;

use Dao\Productos\Productos as ProductosDao;

class Carrito
{
    private const SESSION_KEY = "cart";

    private static function iniciarSesion(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    public static function addProducto(int $productoId): bool
    {
        self::iniciarSesion();

        unset($_SESSION["cart_message"]);

        $producto = ProductosDao::getProductoCatalogoById($productoId);

        if (!$producto) {
            $_SESSION["cart_message"] = "El producto no existe.";
            return false;
        }

        $stockDisponible = ProductosDao::getStockDisponible(
            $productoId
        );

        $cantidadActual = 0;

        if (isset($_SESSION[self::SESSION_KEY][$productoId])) {
            $cantidadActual = $_SESSION[self::SESSION_KEY][$productoId]["cantidad"];
        }

        if (($cantidadActual + 1) > $stockDisponible) {
            $_SESSION["cart_message"] =
                "No hay más unidades disponibles de este producto.";

            return false;
        }

        if (isset($_SESSION[self::SESSION_KEY][$productoId])) {

            $_SESSION[self::SESSION_KEY][$productoId]["cantidad"]++;

        } else {

            $_SESSION[self::SESSION_KEY][$productoId] = [
                "producto_id" => $productoId,
                "cantidad" => 1
            ];
        }

        return true;
    }

    public static function updateCantidad(
        int $productoId,
        int $cantidad
    ): bool {

        self::iniciarSesion();

        unset($_SESSION["cart_message"]);

        if (!isset($_SESSION[self::SESSION_KEY][$productoId])) {
            $_SESSION["cart_message"] = "El producto no está en el carrito.";
            return false;
        }

        if ($cantidad <= 0) {

            unset($_SESSION[self::SESSION_KEY][$productoId]);

            return true;
        }

        $stockDisponible = ProductosDao::getStockDisponible(
            $productoId
        );

        if ($cantidad > $stockDisponible) {

            $_SESSION["cart_message"] =
                "La cantidad solicitada supera el stock disponible.";

            return false;
        }

        $_SESSION[self::SESSION_KEY][$productoId]["cantidad"] = $cantidad;

        return true;
    }

    public static function getMensaje(): string
    {
        self::iniciarSesion();

        $mensaje = $_SESSION["cart_message"] ?? "";

        unset($_SESSION["cart_message"]);

        return $mensaje;
    }

    public static function removeProducto(int $productoId): bool
    {
        self::iniciarSesion();

        if (!isset($_SESSION[self::SESSION_KEY][$productoId])) {
            return false;
        }

        unset($_SESSION[self::SESSION_KEY][$productoId]);

        return true;
    }

    public static function clearCart(): void
    {
        self::iniciarSesion();

        $_SESSION[self::SESSION_KEY] = [];
    }

    public static function getCart(): array
    {
        self::iniciarSesion();

        $items = [];

        foreach ($_SESSION[self::SESSION_KEY] as $item) {

            $producto = ProductosDao::getProductoCatalogoById(
                $item["producto_id"]
            );

            if (!$producto) {
                continue;
            }

            $producto["cantidad"] = $item["cantidad"];

            $producto["subtotal"] =
                $producto["producto_precio"] *
                $item["cantidad"];

            $items[] = $producto;
        }

        return $items;
    }

    public static function getCantidadItems(): int
    {
        self::iniciarSesion();

        $cantidad = 0;

        foreach ($_SESSION[self::SESSION_KEY] as $item) {
            $cantidad += $item["cantidad"];
        }

        return $cantidad;
    }

    public static function getTotal(): float
    {
        $total = 0;

        foreach (self::getCart() as $item) {
            $total += $item["subtotal"];
        }

        return $total;
    }
}