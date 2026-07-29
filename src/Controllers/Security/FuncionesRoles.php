<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;

class FuncionesRoles extends PrivateController
{
    private $viewData = [];

    public function run(): void
    {
        $this->viewData["roles"] = SecurityDAO::getRoles();

        Renderer::render(
            "security/funcionesroles",
            $this->viewData
        );
    }
}