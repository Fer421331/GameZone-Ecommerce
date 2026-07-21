<?php

namespace Dao;

class Profile extends Table
{

    public static function ObtenerProfile()
    {
        // Arreglo de Arreglos
        // Lista de Diccionarios
        return [
            "codigo_curso" => "IF352",
            "desc_curso" => "Negocios Web",
            "seccion_curso" => "2001",
            "docente_curso" => "Orlando Betancourth",
            "docente_codigo" => "6836",
            "bio_curso" => "Manejo de Comercios Electronicos utiliznado PHP y MVC",
            "matriculados" => 50
        ];
    }

    public static function ObtenerPerfiles()
    {
        $sqls = 'select * from perfiles;';
        return self::obtenerRegistros($sqls, []);
        /* return [
            [
                "codigo_curso" => "IF352",
                "desc_curso" => "Negocios Web",
                "seccion_curso" => "2001",
                "docente_curso" => "Orlando Betancourth",
                "docente_codigo" => "6836",
                "bio_curso" => "Manejo de Comercios Electronicos utiliznado PHP y MVC",
                "matriculados" => 50
            ],
            [
                "codigo_curso" => "IF351",
                "desc_curso" => "Portales Web II",
                "seccion_curso" => "1901",
                "docente_curso" => "Orlando Betancourth",
                "docente_codigo" => "6836",
                "bio_curso" => "Portales Web Recargado",
                "matriculados" => 60
            ],
            [
                "codigo_curso" => "IF350",
                "desc_curso" => "Portales Web I",
                "seccion_curso" => "1801",
                "docente_curso" => "Orlando Betancourth",
                "docente_codigo" => "6836",
                "bio_curso" => "Portales Web Inicios",
                "matriculados" => 25
            ]

        ];
        */
    }
}
