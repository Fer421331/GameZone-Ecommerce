<?php

namespace Dao\Reservas;

use Dao\Table;

class Reservas extends Table
{

    public static function getStockReservado(
        int $productoId
    ): int {

        $sql = "
            SELECT
                COALESCE(
                    SUM(cantidad_reservada),
                    0
                ) AS reservado

            FROM reservas_stock

            WHERE producto_id = :producto_id

            AND reserva_estado = 'ACT'

            AND reserva_fecha_expiracion > NOW();
        ";


        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "producto_id" => $productoId
            ]
        );


        return intval(
            $resultado["reservado"] ?? 0
        );
    }


    public static function crearReserva(
        int $productoId,
        int $usercod,
        int $cantidad
    ): bool {

        $sql = "
            INSERT INTO reservas_stock
            (
                producto_id,
                usercod,
                cantidad_reservada,
                reserva_estado,
                reserva_fecha_expiracion
            )

            VALUES
            (
                :producto_id,
                :usercod,
                :cantidad,
                'ACT',
                DATE_ADD(
                    NOW(),
                    INTERVAL 30 MINUTE
                )
            );
        ";


        return self::executeNonQuery(
            $sql,
            [
                "producto_id" => $productoId,
                "usercod" => $usercod,
                "cantidad" => $cantidad
            ]
        );
    }

    public static function confirmarReservas(
        int $usercod
    ): bool {

        $sql = "
        UPDATE reservas_stock
        SET
            reserva_estado = 'CON',
            reserva_fecha_confirmacion = NOW()

        WHERE usercod = :usercod

        AND reserva_estado = 'ACT';
    ";


        return self::executeNonQuery(
            $sql,
            [
                "usercod" => $usercod
            ]
        );
    }


    public static function liberarReservas(
        int $usercod
    ): bool {

        $sql = "
        UPDATE reservas_stock
        SET
            reserva_estado = 'LIB',
            reserva_fecha_liberacion = NOW()

        WHERE usercod = :usercod

        AND reserva_estado = 'ACT';
    ";


        return self::executeNonQuery(
            $sql,
            [
                "usercod" => $usercod
            ]
        );
    }

    public static function validarReservasUsuario(
        int $usercod
    ): bool {

        $sql = "
        SELECT COUNT(*) AS total
        FROM reservas_stock
        WHERE usercod = :usercod
        AND reserva_estado = 'ACT'
        AND reserva_fecha_expiracion > NOW();
    ";

        $resultado = self::obtenerUnRegistro(
            $sql,
            [
                "usercod" => $usercod
            ]
        );

        return intval($resultado["total"] ?? 0) > 0;
    }
}
