<?php

namespace Controllers\Ventas;

use Controllers\PrivateController;
use Dao\Ventas\Ventas as VentasDao;
use Dao\Ventas\VentasDetalle as VentasDetalleDao;
use Views\Renderer;
use Utilities\Site;


class Detalle extends PrivateController
{

    private $viewData = [];


    public function run(): void
    {

        try {


            $venta_id =
                intval(
                    $_GET["venta_id"] ?? 0
                );



            if ($venta_id <= 0) {

                throw new \Exception(
                    "Venta no válida"
                );

            }



            $venta =
                VentasDao::getVentaById(
                    $venta_id
                );



            if (!$venta) {

                throw new \Exception(
                    "No se encontró la venta"
                );

            }



            $detalle =
                VentasDetalleDao::getDetallesByVenta(
                    $venta_id
                );



            foreach ($detalle as &$producto) {


                $producto["precio_unitario"] =
                    number_format(
                        floatval(
                            $producto["precio_unitario"]
                        ),
                        2
                    );


                $producto["subtotal"] =
                    number_format(
                        floatval(
                            $producto["subtotal"]
                        ),
                        2
                    );


            }


            unset($producto);




            $direccion =
                VentasDao::getDireccionVenta(
                    $venta_id
                );





            $this->viewData =
                array_merge(

                    $venta,

                    [

                        "venta_id" =>
                            $venta_id,


                        "detalle" =>
                            $detalle

                    ],

                    $direccion ?? []

                );





            Renderer::render(
                "ventas/detalle",
                $this->viewData
            );



        } catch (\Exception $ex) {


            Site::redirectToWithMsg(
                "index.php?page=Ventas_Ventas",
                $ex->getMessage()
            );


        }


    }


}