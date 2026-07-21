<?php

namespace Controllers\Security;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Security\Security as SecurityDAO;

class RolesUsuarios extends PrivateController
{
    public function run(): void
    {
        $viewData = array();

        $viewData["usuarios"] = SecurityDAO::getUsuarios();

        Renderer::render(
            "security/rolesusuarios",
            $viewData
        );
    }
}