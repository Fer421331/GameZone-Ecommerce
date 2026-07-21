<?php

namespace Dao\Mantenimiento;

use Dao\Table;
use DateTime;

/*
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    equipo_a VARCHAR(255),
    equipo_b VARCHAR(255),
    resumen VARCHAR(255),
    score_a INT,
    score_b INT,
    fecha DATE
*/

class WcResult extends Table
{
    //CRUD Create Read Update Delete 
    // Read One Read All

    public static function getAll(): array
    {
        $sqlstr = "SELECT * FROM wcresults;";
        // if soft delete
        // $sqlstr = "SELECT * FROM wcresults where deleted_at is null;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $id): array
    {
        $sqlstr = "SELECT * FROM wcresults where id=:idwcr;";
        // if soft delete
        //  $sqlstr = "SELECT * FROM wcresults where id=:idwcr and deleted_at is null;";
        return self::obtenerUnRegistro($sqlstr, ["idwcr" => $id]);
    }

    public static function create(
        string $equipo_a,
        string $equipo_b,
        string $resumen,
        int $score_a,
        int $score_b,
        DateTime $fecha
    ) {
        $sqlIns = "insert into  wcresults (
            equipo_a, equipo_b, resumen, score_a, score_b, fecha )
        values
            ( :equipo_a, :equipo_b, :resumen, :score_a, :score_b, :fecha);";

        $param = [
            "equipo_a" => $equipo_a,
            "equipo_b" => $equipo_b,
            "resumen" => $resumen,
            "score_a" => $score_a,
            "score_b" => $score_b,
            "fecha" => $fecha->format('Y-m-d')
        ];

        return self::executeNonQuery($sqlIns, $param);
    }

    public static function update(
        int $id,
        string $equipo_a,
        string $equipo_b,
        string $resumen,
        int $score_a,
        int $score_b,
        DateTime $fecha
    ) {
        $sqlUpd = "update wcresults set
            equipo_a = :equipo_a, equipo_b = :equipo_b,
            resumen = :resumen, score_a = :score_a,
            score_b = :score_b, fecha = :fecha 
            where id = :id;";

        $param = [
            "equipo_a" => $equipo_a,
            "equipo_b" => $equipo_b,
            "resumen" => $resumen,
            "score_a" => $score_a,
            "score_b" => $score_b,
            "fecha" => $fecha->format('Y-m-d'),
            "id" => $id
        ];

        return self::executeNonQuery($sqlUpd, $param);
    }
    // HARD Delete
    public static function delete(int $id)
    {
        $sqlstr = "DELETE FROM wcresults where id=:idwcr;";
        return self::executeNonQuery($sqlstr, ["idwcr" => $id]);
    }

    // Buena Práctica (NO SE BORRA NADA DE NADA PARA NADA NI DE BROMA)
    // SOFT Delete 
    // Implica en la tabla existe un campo (columna) deleted_at (null)
    public static function softDelete(int $id): array
    {
        $sqlstr = "UPDATE FROM wcresults set deleted_at = now() where id=:idwcr;";
        return self::executeNonQuery($sqlstr, ["idwcr" => $id]);
    }
}
