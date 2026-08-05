<?php

namespace Dao\Perfil;

use Dao\Table;
use Dao\Favoritos\Favoritos as FavoritosDao;

class Perfil extends Table
{

    public static function getPerfil(
        string $usercod
    ): ?array {


        $sql = "

            SELECT

                u.usercod,
                u.username,
                u.useremail,
                u.userfching,
                u.userest,
                u.usertipo,

                r.rolescod,
                r.rolesdsc


            FROM usuario u


            LEFT JOIN roles_usuarios ru

                ON ru.usercod = u.usercod

                AND ru.roleuserest = 'ACT'


            LEFT JOIN roles r

                ON r.rolescod = ru.rolescod

                AND r.rolesest = 'ACT'


            WHERE u.usercod = :usercod

            LIMIT 1;

        ";


        $perfil = self::obtenerUnRegistro(
            $sql,
            [
                "usercod" => $usercod
            ]
        );


        return $perfil ?: null;
    }




    public static function updatePerfil(
        string $usercod,
        string $username,
        string $useremail
    ): bool {


        $sql = "

            UPDATE usuario

            SET

                username = :username,

                useremail = :useremail


            WHERE usercod = :usercod;

        ";


        return self::executeNonQuery(
            $sql,
            [

                "usercod" => $usercod,

                "username" => $username,

                "useremail" => $useremail

            ]

        ) > 0;
    }





    public static function existeCorreo(
        string $correo,
        string $usercod
    ): bool {


        $sql = "

            SELECT COUNT(*) total

            FROM usuario

            WHERE LOWER(useremail)=LOWER(:correo)

            AND usercod <> :usercod;

        ";


        $resultado = self::obtenerUnRegistro(
            $sql,
            [

                "correo" => $correo,

                "usercod" => $usercod

            ]
        );


        return intval(
            $resultado["total"] ?? 0
        ) > 0;
    }





    public static function getEstadisticas(
        string $usercod
    ): array {
        $estadisticas = [];

        $sql = "
        SELECT COUNT(*) total
        FROM ventas
        WHERE usercod = :usercod;
    ";

        $estadisticas["compras"] = intval(
            self::obtenerUnRegistro(
                $sql,
                [
                    "usercod" => $usercod
                ]
            )["total"] ?? 0
        );

      
        $estadisticas["favoritos"] =
            FavoritosDao::contarFavoritos($usercod);

        $estadisticas["carrito"] =
            count($_SESSION["cart"] ?? []);

        return $estadisticas;
    } 

}