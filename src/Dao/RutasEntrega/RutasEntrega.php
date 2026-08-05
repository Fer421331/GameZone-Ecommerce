<?php

namespace Dao\RutasEntrega;

use Dao\Table;

class RutasEntrega extends Table
{
    public static function getRutasEntrega(
        string $partialName = "",
        string $status = "",
        int $page = 0,
        int $itemsPerPage = 10
    ): array {

        $sql = "
            SELECT
                id_ruta,
                origen,
                destino,
                distancia_km,
                duracion_min,
                estado
            FROM rutas_entrega
        ";

        $count = "
            SELECT COUNT(*) AS total
            FROM rutas_entrega
        ";

        $where = [];
        $params = [];

        if ($partialName !== "") {

            $where[] = "
                (
                    origen LIKE :origen
                    OR destino LIKE :destino
                )
            ";

            $params["origen"] = "%" . $partialName . "%";
            $params["destino"] = "%" . $partialName . "%";
        }

        if ($status !== "") {

            $where[] = "estado = :estado";
            $params["estado"] = $status;
        }

        if (count($where) > 0) {

            $sql .= " WHERE " . implode(" AND ", $where);
            $count .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= "
            ORDER BY origen, destino
            LIMIT " . ($page * $itemsPerPage) . ",
            " . $itemsPerPage;

        $total = self::obtenerUnRegistro(
            $count,
            $params
        )["total"];

        return [
            "rutas" => self::obtenerRegistros(
                $sql,
                $params
            ),
            "total" => intval($total)
        ];
    }

    public static function getRutaEntregaById(int $id_ruta): ?array
    {
        $sql = "
            SELECT
                id_ruta,
                origen,
                destino,
                distancia_km,
                duracion_min,
                estado
            FROM rutas_entrega
            WHERE id_ruta = :id_ruta;
        ";

        return self::obtenerUnRegistro(
            $sql,
            [
                "id_ruta" => $id_ruta
            ]
        );
    }

    public static function insertRutaEntrega(
        string $origen,
        string $destino,
        float $distancia_km,
        int $duracion_min,
        string $estado
    ): bool {

        $sql = "
            INSERT INTO rutas_entrega
            (
                origen,
                destino,
                distancia_km,
                duracion_min,
                estado
            )
            VALUES
            (
                :origen,
                :destino,
                :distancia_km,
                :duracion_min,
                :estado
            );
        ";

        return self::executeNonQuery(
            $sql,
            [
                "origen" => $origen,
                "destino" => $destino,
                "distancia_km" => $distancia_km,
                "duracion_min" => $duracion_min,
                "estado" => $estado
            ]
        ) > 0;
    }

    public static function updateRutaEntrega(
        int $id_ruta,
        string $origen,
        string $destino,
        float $distancia_km,
        int $duracion_min,
        string $estado
    ): bool {

        $sql = "
            UPDATE rutas_entrega
            SET
                origen = :origen,
                destino = :destino,
                distancia_km = :distancia_km,
                duracion_min = :duracion_min,
                estado = :estado
            WHERE id_ruta = :id_ruta;
        ";

        return self::executeNonQuery(
            $sql,
            [
                "id_ruta" => $id_ruta,
                "origen" => $origen,
                "destino" => $destino,
                "distancia_km" => $distancia_km,
                "duracion_min" => $duracion_min,
                "estado" => $estado
            ]
        ) > 0;
    }

    public static function deleteRutaEntrega(int $id_ruta): bool
    {
        $sql = "
            DELETE FROM rutas_entrega
            WHERE id_ruta = :id_ruta;
        ";

        return self::executeNonQuery(
            $sql,
            [
                "id_ruta" => $id_ruta
            ]
        ) > 0;
    }

    public static function getRutasActivas(): array
    {
        $sql = "
            SELECT
                id_ruta,
                origen,
                destino,
                distancia_km,
                duracion_min
            FROM rutas_entrega
            WHERE estado = 'ACT'
            ORDER BY origen, destino;
        ";

        return self::obtenerRegistros(
            $sql,
            []
        );
    }

    public static function existeRuta(
        string $origen,
        string $destino,
        int $id_ruta = 0
    ): bool {

        $sql = "
            SELECT COUNT(*) AS total
            FROM rutas_entrega
            WHERE origen = :origen
              AND destino = :destino
              AND id_ruta <> :id_ruta;
        ";

        $result = self::obtenerUnRegistro(
            $sql,
            [
                "origen" => $origen,
                "destino" => $destino,
                "id_ruta" => $id_ruta
            ]
        );

        return intval($result["total"]) > 0;
    }
}