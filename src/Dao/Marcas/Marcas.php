<?php

namespace Dao\Marcas;

use Dao\Table;

class Marcas extends Table
{

    public static function getMarcas(
        string $buscar = "",
        string $estado = "",
        int $page = 0,
        int $itemsPerPage = 100
    ): array {

        $sql = "
        SELECT
            marca_id,
            marca_nombre,
            marca_descripcion,
            marca_estado,
            marca_fecha_creacion,
            marca_fecha_actualizacion
        FROM marcas
        ";

        $count = "
        SELECT COUNT(*) AS total
        FROM marcas
        ";

        $where = [];
        $params = [];


        if ($buscar !== "") {

            $where[] = "
            (
                marca_nombre LIKE :nombre
                OR marca_descripcion LIKE :descripcion
            )
            ";

            $params["nombre"] =
                "%".$buscar."%";

            $params["descripcion"] =
                "%".$buscar."%";
        }


        if ($estado !== "") {

            $where[] =
                "marca_estado = :estado";

            $params["estado"] =
                $estado;
        }


        if(count($where)>0){

            $sql .= 
                " WHERE ".implode(" AND ",$where);

            $count .= 
                " WHERE ".implode(" AND ",$where);
        }


        $sql .= "
        ORDER BY marca_nombre
        LIMIT $page,$itemsPerPage
        ";


        $total =
            self::obtenerUnRegistro(
                $count,
                $params
            );


        return [

            "marcas" =>
                self::obtenerRegistros(
                    $sql,
                    $params
                ),

            "total" =>
                intval($total["total"] ?? 0)

        ];

    }



    public static function getMarcaById(
        int $id
    ): ?array {

        $sql="
        SELECT *
        FROM marcas
        WHERE marca_id=:id;
        ";


        return self::obtenerUnRegistro(
            $sql,
            [
                "id"=>$id
            ]
        );

    }




    public static function insertMarca(
        string $nombre,
        string $descripcion,
        string $estado
    ): bool {


        $sql="
        INSERT INTO marcas
        (
            marca_nombre,
            marca_descripcion,
            marca_estado
        )
        VALUES
        (
            :nombre,
            :descripcion,
            :estado
        );
        ";


        return self::executeNonQuery(
            $sql,
            [
                "nombre"=>$nombre,
                "descripcion"=>$descripcion,
                "estado"=>$estado
            ]
        )>0;

    }




    public static function updateMarca(
        int $id,
        string $nombre,
        string $descripcion,
        string $estado
    ): bool {


        $sql="
        UPDATE marcas
        SET
            marca_nombre=:nombre,
            marca_descripcion=:descripcion,
            marca_estado=:estado,
            marca_fecha_actualizacion=CURRENT_TIMESTAMP
        WHERE marca_id=:id;
        ";


        return self::executeNonQuery(
            $sql,
            [
                "id"=>$id,
                "nombre"=>$nombre,
                "descripcion"=>$descripcion,
                "estado"=>$estado
            ]
        )>0;

    }





    public static function deleteMarca(
        int $id
    ): bool {


        $sql="
        UPDATE marcas
        SET
            marca_estado='INA',
            marca_fecha_actualizacion=CURRENT_TIMESTAMP
        WHERE marca_id=:id;
        ";


        return self::executeNonQuery(
            $sql,
            [
                "id"=>$id
            ]
        )>0;

    }




    public static function existeNombre(
        string $nombre,
        int $id=0
    ): bool {


        $sql="
        SELECT COUNT(*) total
        FROM marcas
        WHERE marca_nombre=:nombre
        AND marca_id<>:id;
        ";


        $r=self::obtenerUnRegistro(
            $sql,
            [
                "nombre"=>$nombre,
                "id"=>$id
            ]
        );


        return intval($r["total"]??0)>0;

    }


}