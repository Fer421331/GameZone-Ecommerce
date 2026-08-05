<?php

namespace Dao\Plataformas;

use Dao\Table;


class Plataformas extends Table
{


    public static function getPlataformas(
        int $limit = 0,
        int $offset = 0
    ): array {


        $sql = "

        SELECT

            plataforma_id,
            plataforma_nombre,
            plataforma_descripcion,
            plataforma_estado

        FROM plataformas

        ORDER BY plataforma_id DESC

        ";


        if($limit > 0){

            $sql .= "

            LIMIT :limit
            OFFSET :offset

            ";


            return self::obtenerRegistros(
                $sql,
                [
                    "limit"=>$limit,
                    "offset"=>$offset
                ]
            );

        }


        return self::obtenerRegistros(
            $sql,
            []
        );

    }



    public static function getTotalPlataformas(): int
    {

        $sql = "

        SELECT COUNT(*) AS total

        FROM plataformas

        ";


        $resultado =
            self::obtenerUnRegistro(
                $sql,
                []
            );


        return intval(
            $resultado["total"] ?? 0
        );

    }




    public static function getPlataformaById(
        int $id
    ): ?array {


        $sql = "

        SELECT

            plataforma_id,
            plataforma_nombre,
            plataforma_descripcion,
            plataforma_estado

        FROM plataformas

        WHERE plataforma_id = :id

        ";


        $resultado =
            self::obtenerUnRegistro(
                $sql,
                [
                    "id"=>$id
                ]
            );


        return $resultado ?: null;

    }




    public static function insertPlataforma(
        string $nombre,
        string $descripcion,
        string $estado
    ): bool {


        $sql = "

        INSERT INTO plataformas
        (
            plataforma_nombre,
            plataforma_descripcion,
            plataforma_estado
        )

        VALUES
        (
            :nombre,
            :descripcion,
            :estado
        )

        ";


        return self::executeNonQuery(
            $sql,
            [
                "nombre"=>$nombre,
                "descripcion"=>$descripcion,
                "estado"=>$estado
            ]
        ) > 0;

    }





    public static function updatePlataforma(
        int $id,
        string $nombre,
        string $descripcion,
        string $estado
    ): bool {


        $sql = "

        UPDATE plataformas

        SET

            plataforma_nombre=:nombre,

            plataforma_descripcion=:descripcion,

            plataforma_estado=:estado,

            plataforma_fecha_actualizacion =
                CURRENT_TIMESTAMP

        WHERE plataforma_id=:id

        ";


        return self::executeNonQuery(
            $sql,
            [
                "id"=>$id,
                "nombre"=>$nombre,
                "descripcion"=>$descripcion,
                "estado"=>$estado
            ]
        ) > 0;


    }





    public static function deletePlataforma(
        int $id
    ): bool {


        $sql = "

        UPDATE plataformas

        SET

            plataforma_estado='INA',

            plataforma_fecha_actualizacion =
                CURRENT_TIMESTAMP

        WHERE plataforma_id=:id

        ";


        return self::executeNonQuery(
            $sql,
            [
                "id"=>$id
            ]
        ) > 0;


    }





    public static function existeNombre(
        string $nombre,
        int $id = 0
    ): bool {


        $sql = "

        SELECT COUNT(*) total

        FROM plataformas

        WHERE LOWER(plataforma_nombre)
        =
        LOWER(:nombre)

        AND plataforma_id <> :id

        ";


        $resultado =
            self::obtenerUnRegistro(
                $sql,
                [
                    "nombre"=>$nombre,
                    "id"=>$id
                ]
            );


        return intval(
            $resultado["total"] ?? 0
        ) > 0;


    }


}