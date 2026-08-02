<?php

namespace Controllers\Historial;

use Controllers\PrivateController;
use Dao\Historial\Historial as HistorialDao;
use Utilities\Security;
use Views\Renderer;

class Historial extends PrivateController
{
    public function run(): void
    {
        $usercod = Security::getUserId();

        $ventas = HistorialDao::getHistorial($usercod);

        foreach ($ventas as &$venta) {
            $venta["detalle"] = HistorialDao::getDetalleVenta(
                intval($venta["venta_id"])
            );
        }

        Renderer::render(
            "historial/historial",
            [
                "ventas" => $ventas
            ]
        );
    }
}