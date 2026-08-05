<?php

namespace Dao\DireccionesUsuario;

use Dao\Table;


class DireccionesUsuario extends Table
{


    public static function getDireccionesUsuario(
        string $usercod
    ): array {


        $sql = "

            SELECT

                du.*,

                re.origen,
                re.destino,
                re.distancia_km,
                re.duracion_min


            FROM direcciones_usuario du


            LEFT JOIN rutas_entrega re

                ON re.id_ruta = du.id_ruta


            WHERE du.usercod = :usercod

            AND du.direccion_estado = 'ACT'


            ORDER BY

                du.direccion_predeterminada DESC,

                du.direccion_id DESC;

        ";


        return self::obtenerRegistros(
            $sql,
            [
                "usercod" => $usercod
            ]
        );
    }




    public static function getDireccionById(
        int $direccion_id,
        string $usercod
    ): ?array {


        $sql = "

            SELECT *

            FROM direcciones_usuario


            WHERE direccion_id = :direccion_id

            AND usercod = :usercod


            LIMIT 1;

        ";


        $direccion =
            self::obtenerUnRegistro(
                $sql,
                [

                    "direccion_id" => $direccion_id,

                    "usercod" => $usercod

                ]
            );


        return $direccion ?: null;
    }





    public static function getDireccionPredeterminada(
        string $usercod
    ): ?array {


        $sql = "

            SELECT

                du.*,

                re.origen,

                re.destino


            FROM direcciones_usuario du


            LEFT JOIN rutas_entrega re

                ON re.id_ruta = du.id_ruta


            WHERE du.usercod = :usercod


            AND du.direccion_predeterminada = 1

            AND du.direccion_estado = 'ACT'


            LIMIT 1;

        ";


        $direccion =
            self::obtenerUnRegistro(
                $sql,
                [
                    "usercod" => $usercod
                ]
            );


        return $direccion ?: null;
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


            ORDER BY destino;


        ";


        return self::obtenerRegistros(
            $sql,
            []
        );
    }








    public static function insertDireccion(
        string $usercod,
        array $direccion
    ): bool {


        /*
            Si esta será la dirección principal,
            quitamos la anterior
        */

        if (
            $direccion["direccion_predeterminada"] == 1
        ) {

            self::executeNonQuery(

                "

                UPDATE direcciones_usuario

                SET

                    direccion_predeterminada = 0


                WHERE usercod = :usercod;

                ",

                [
                    "usercod" => $usercod
                ]

            );
        }





        $sql = "

            INSERT INTO direcciones_usuario

            (

                usercod,

                direccion_alias,

                direccion_receptor,

                direccion_telefono,

                direccion_departamento,

                direccion_ciudad,

                id_ruta,

                direccion_detalle,

                direccion_referencia,

                direccion_predeterminada

            )


            VALUES

            (

                :usercod,

                :direccion_alias,

                :direccion_receptor,

                :direccion_telefono,

                :direccion_departamento,

                :direccion_ciudad,

                :id_ruta,

                :direccion_detalle,

                :direccion_referencia,

                :direccion_predeterminada

            );

        ";



        return self::executeNonQuery(

            $sql,

            [

                "usercod" => $usercod,

                "direccion_alias" => $direccion["direccion_alias"],

                "direccion_receptor" => $direccion["direccion_receptor"],

                "direccion_telefono" => $direccion["direccion_telefono"],

                "direccion_departamento" => $direccion["direccion_departamento"],

                "direccion_ciudad" => $direccion["direccion_ciudad"],

                "id_ruta" => $direccion["id_ruta"],

                "direccion_detalle" => $direccion["direccion_detalle"],

                "direccion_referencia" => $direccion["direccion_referencia"],

                "direccion_predeterminada" => $direccion["direccion_predeterminada"]

            ]

        ) > 0;
    }









    public static function updateDireccion(
        string $usercod,
        array $direccion
    ): bool {


        if (
            $direccion["direccion_predeterminada"] == 1
        ) {

            self::executeNonQuery(

                "

                UPDATE direcciones_usuario

                SET

                    direccion_predeterminada = 0


                WHERE usercod = :usercod;


                ",

                [

                    "usercod" => $usercod

                ]

            );
        }






        $sql = "

            UPDATE direcciones_usuario

            SET


                direccion_alias = :direccion_alias,

                direccion_receptor = :direccion_receptor,

                direccion_telefono = :direccion_telefono,

                direccion_departamento = :direccion_departamento,

                direccion_ciudad = :direccion_ciudad,

                id_ruta = :id_ruta,

                direccion_detalle = :direccion_detalle,

                direccion_referencia = :direccion_referencia,

                direccion_predeterminada = :direccion_predeterminada,

                direccion_fecha_actualizacion = NOW()


            WHERE direccion_id = :direccion_id


            AND usercod = :usercod;


        ";



        return self::executeNonQuery(

            $sql,

            [

                "direccion_id" => $direccion["direccion_id"],

                "usercod" => $usercod,

                "direccion_alias" => $direccion["direccion_alias"],

                "direccion_receptor" => $direccion["direccion_receptor"],

                "direccion_telefono" => $direccion["direccion_telefono"],

                "direccion_departamento" => $direccion["direccion_departamento"],

                "direccion_ciudad" => $direccion["direccion_ciudad"],

                "id_ruta" => $direccion["id_ruta"],

                "direccion_detalle" => $direccion["direccion_detalle"],

                "direccion_referencia" => $direccion["direccion_referencia"],

                "direccion_predeterminada" => $direccion["direccion_predeterminada"]

            ]

        ) > 0;
    }









    public static function deleteDireccion(
        int $direccion_id,
        string $usercod
    ): bool {


        $sql = "

            UPDATE direcciones_usuario

            SET

                direccion_estado = 'INA',

                direccion_fecha_actualizacion = NOW()


            WHERE direccion_id = :direccion_id


            AND usercod = :usercod;


        ";



        return self::executeNonQuery(

            $sql,

            [

                "direccion_id" => $direccion_id,

                "usercod" => $usercod

            ]

        ) > 0;
    }

    public static function setDireccionPredeterminada(
        string $usercod,
        int $direccion_id
    ): bool {


        self::executeNonQuery(

            "
        UPDATE direcciones_usuario

        SET direccion_predeterminada = 0

        WHERE usercod = :usercod;
        ",

            [
                "usercod" => $usercod
            ]

        );



        return self::executeNonQuery(

            "
        UPDATE direcciones_usuario

        SET direccion_predeterminada = 1

        WHERE direccion_id = :direccion_id

        AND usercod = :usercod;
        ",

            [

                "direccion_id" => $direccion_id,

                "usercod" => $usercod

            ]

        ) > 0;
    }
}
