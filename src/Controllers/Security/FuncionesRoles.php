<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;

class FuncionesRoles extends PrivateController
{
    public function run(): void
    {
        $viewData = [];

        $viewData["roles"] = SecurityDAO::getRoles();

        Renderer::render(
            "security/funcionesroles",
            $viewData
        );
    }
}