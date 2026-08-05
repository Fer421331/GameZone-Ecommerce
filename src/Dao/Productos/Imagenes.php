<?php

namespace Dao\Productos;

use Dao\Table;

class Imagenes extends Table
{

    public static function getImagenesPorProducto(int $producto_id): array
    {

        $sql = "
            SELECT *
            FROM producto_imagenes
            WHERE producto_id = :producto_id
            AND imagen_estado = 'ACT'
            ORDER BY imagen_orden ASC
        ";

        return self::obtenerRegistros(
            $sql,
            [
                "producto_id" => $producto_id
            ]
        );

    }



    public static function getImagenPrincipal(int $producto_id): array
    {

        $sql = "
            SELECT *
            FROM producto_imagenes
            WHERE producto_id = :producto_id
            AND imagen_principal = 1
            AND imagen_estado='ACT'
            LIMIT 1
        ";


        return self::obtenerUnRegistro(
            $sql,
            [
                "producto_id"=>$producto_id
            ]
        );

    }




    public static function insertarImagen(
        int $producto_id,
        string $ruta
    ): bool
    {


        $sql="
            INSERT INTO producto_imagenes
            (
                producto_id,
                imagen_ruta,
                imagen_principal,
                imagen_orden,
                imagen_estado
            )
            VALUES
            (
                :producto_id,
                :ruta,
                0,
                1,
                'ACT'
            )
        ";


        return self::executeNonQuery(
            $sql,
            [
                "producto_id"=>$producto_id,
                "ruta"=>$ruta
            ]
        );


    }




    public static function eliminarImagen(
        int $imagen_id
    ): bool
    {

        $sql="
            UPDATE producto_imagenes
            SET imagen_estado='INA'
            WHERE imagen_id=:imagen_id
        ";


        return self::executeNonQuery(
            $sql,
            [
                "imagen_id"=>$imagen_id
            ]
        );

    }





    public static function marcarPrincipal(
        int $imagen_id,
        int $producto_id
    ): bool
    {

        self::executeNonQuery(
            "
            UPDATE producto_imagenes
            SET imagen_principal=0
            WHERE producto_id=:producto_id
            ",
            [
                "producto_id"=>$producto_id
            ]
        );



        return self::executeNonQuery(
            "
            UPDATE producto_imagenes
            SET imagen_principal=1
            WHERE imagen_id=:imagen_id
            ",
            [
                "imagen_id"=>$imagen_id
            ]
        );


    }



}