<?php

namespace Controllers\Sec;

use Utilities\Bitacora;

class Logout extends \Controllers\PublicController
{
    public function run(): void
    {
        $user = \Utilities\Security::getUser();

        Bitacora::registrar(
            "Logout",
            "Cierre de sesión",
            "Usuario: " . ($user ? $user["userEmail"] : "Sesión expirada"),
            "LOG"
        );
        \Utilities\Security::logout();
        \Utilities\Site::redirectTo("index.php");
    }
}
