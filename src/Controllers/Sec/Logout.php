<?php

namespace Controllers\Sec;

use Utilities\Bitacora;

class Logout extends \Controllers\PublicController
{
    public function run(): void
    {
        Bitacora::registrar(
            "Logout",
            "Cierre de sesión",
            "Usuario: " . \Utilities\Security::getUser()["userEmail"],
            "LOG"
        );
        \Utilities\Security::logout();
        \Utilities\Site::redirectTo("index.php");
    }
}
