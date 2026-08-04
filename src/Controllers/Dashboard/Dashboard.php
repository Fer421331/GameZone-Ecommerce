<?php

namespace Controllers\Dashboard;

use Controllers\PrivateController;
use Dao\Dashboard\Dashboard as DAODashboard;
use Views\Renderer;
use Utilities\Bitacora;

const DASHBOARD_VIEW = "dashboard/dashboard";

class Dashboard extends PrivateController
{
    public function run(): void
    {
        $viewData = DAODashboard::getDashboardData();

        Bitacora::registrar(
            "Dashboard",
            "Acceso al dashboard",
            "El usuario consultó el panel administrativo.",
            "LOG"
        );

        Renderer::render(
            DASHBOARD_VIEW,
            $viewData
        );
    }
}
