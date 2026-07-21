<?php

namespace Dao\RutasEntrega;

use Dao\Table;

class RutasEntrega extends Table
{
    public static function getRutasEntrega()
    {
        $sqlstr = "SELECT * FROM rutas_entrega;";

        return self::obtenerRegistros(
            $sqlstr,
            []
        ); 
    }

    public static function getRutaEntregaById($id_ruta)
    {
        $sqlstr = "SELECT * FROM rutas_entrega
                    WHERE id_ruta = :id_ruta;";

        return self::obtenerUnRegistro(
            $sqlstr,
            [
                "id_ruta" => $id_ruta
            ]
        );
    }

    public static function insertRutaEntrega(
        $origen,
        $destino,
        $distancia_km,
        $duracion_min,
        $estado
    ) {
        $sqlstr = "INSERT INTO rutas_entrega
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
                    );";

        return self::executeNonQuery(
            $sqlstr,
            [
                "origen" => $origen,
                "destino" => $destino,
                "distancia_km" => $distancia_km,
                "duracion_min" => $duracion_min,
                "estado" => $estado
            ]
        );
    }

    public static function updateRutaEntrega(
        $id_ruta,
        $origen,
        $destino,
        $distancia_km,
        $duracion_min,
        $estado
    ) {
        $sqlstr = "UPDATE rutas_entrega
                    SET
                        origen = :origen,
                        destino = :destino,
                        distancia_km = :distancia_km,
                        duracion_min = :duracion_min,
                        estado = :estado
                    WHERE id_ruta = :id_ruta;";

        return self::executeNonQuery(
            $sqlstr,
            [
                "id_ruta" => $id_ruta,
                "origen" => $origen,
                "destino" => $destino,
                "distancia_km" => $distancia_km,
                "duracion_min" => $duracion_min,
                "estado" => $estado
            ]
        );
    }

    public static function deleteRutaEntrega($id_ruta)
    {
        $sqlstr = "DELETE FROM rutas_entrega
                    WHERE id_ruta = :id_ruta;";

        return self::executeNonQuery(
            $sqlstr,
            [
                "id_ruta" => $id_ruta
            ]
        );
    }
}