<?php

namespace Controllers\Dashboard;

use Controllers\PrivateController;
use Dao\Dashboard\Dashboard as DAODashboard;
use Views\Renderer;

const DASHBOARD_VIEW = "dashboard/dashboard";

class Dashboard extends PrivateController
{
    public function run(): void
    {
        $viewData = DAODashboard::getDashboardData();

        Renderer::render(
            DASHBOARD_VIEW,
            $viewData
        );
    }
}
