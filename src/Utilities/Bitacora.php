<?php

namespace Utilities;

use Dao\Security\Bitacora as BitacoraDAO;

class Bitacora
{
    /**
     * Registra un evento en la bitácora.
     *
     * @param string $programa
     * @param string $descripcion
     * @param string $observacion
     * @param string $tipo
     * @return bool
     */
    public static function registrar(
        string $programa,
        string $descripcion,
        string $observacion = "",
        string $tipo = "LOG"
    ): bool {

        $usuario = Security::isLogged()
            ? Security::getUserId()
            : null;

        return BitacoraDAO::registrar(
            $usuario,
            $programa,
            $descripcion,
            $observacion,
            $tipo
        );
    }
}