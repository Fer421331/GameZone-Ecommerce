<?php

namespace Dao\Security;

use Dao\Table;

class Bitacora extends Table
{
    public static function registrar(
        ?int $usuario,
        string $programa,
        string $descripcion,
        string $observacion,
        string $tipo
    ): bool {

        $sql = "INSERT INTO bitacora
                (
                    bitacorafch,
                    bitprograma,
                    bitdescripcion,
                    bitobservacion,
                    bitTipo,
                    bitusuario
                )
                VALUES
                (
                    NOW(),
                    :programa,
                    :descripcion,
                    :observacion,
                    :tipo,
                    :usuario
                );";

        return self::executeNonQuery(
            $sql,
            [
                "programa" => $programa,
                "descripcion" => $descripcion,
                "observacion" => $observacion,
                "tipo" => $tipo,
                "usuario" => $usuario
            ]
        ) > 0;
    }

    public static function obtenerBitacora(
        string $fechaDesde = "",
        string $fechaHasta = "",
        int $page = 0,
        int $limit = 10
    ): array {

        $where = "";
        $params = [];


        if ($fechaDesde !== "") {

            $where .= "
            AND DATE(b.bitacorafch) >= :fechaDesde
        ";

            $params["fechaDesde"] = $fechaDesde;
        }

        if ($fechaHasta !== "") {

            $where .= "
            AND DATE(b.bitacorafch) <= :fechaHasta
        ";

            $params["fechaHasta"] = $fechaHasta;
        }

        $sqlCount = "
        SELECT COUNT(*) total

        FROM bitacora b

        LEFT JOIN usuario u
            ON b.bitusuario = u.usercod

        WHERE 1=1

        $where
    ";

        $total =
            self::obtenerUnRegistro(
                $sqlCount,
                $params
            )["total"];

        $sql = "

        SELECT
            b.*,

            COALESCE(
                u.username,
                'Usuario no autenticado'
            ) username

        FROM bitacora b

        LEFT JOIN usuario u

            ON b.bitusuario = u.usercod

        WHERE 1=1

        $where

        ORDER BY
            b.bitacorafch DESC

        LIMIT $limit

        OFFSET " . ($page * $limit) . ";

    ";

        return [

            "bitacora" =>
            self::obtenerRegistros(
                $sql,
                $params
            ),

            "total" =>
            intval($total)

        ];
    }
}
