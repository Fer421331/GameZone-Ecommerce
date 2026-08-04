<?php

namespace Dao\Security;

use Dao\Table;

class Bitacora extends Table
{
    public static function registrar(
        int $usuario,
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

    public static function obtenerBitacora(): array
    {
        $sql = "SELECT
                    b.*,
                    u.username
                FROM bitacora b
                LEFT JOIN usuario u
                    ON b.bitusuario = u.usercod
                ORDER BY b.bitacorafch DESC;";

        return self::obtenerRegistros($sql, []);
    }
}