<?php
/**
 * PHP Version 7.2
 *
 * @category Public
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @version  CVS:1.0.0
 * @link     http://
 */
namespace Controllers;

use Dao\Productos\Productos as ProductosDao;

/**
 * Index Controller
 *
 * @category Public
 * @package  Controllers
 * @author   Orlando J Betancourth <orlando.betancourth@gmail.com>
 * @license  MIT http://
 * @link     http://
 */
class Index extends PublicController
{
    /**
     * Index run method
     *
     * @return void
     */
    public function run() :void
    {
        $viewData = array();


        $productos = ProductosDao::getProductosPublicados();


        $productos = array_slice(
            $productos,
            0,
            4
        );

        $productos = ProductosDao::getProductosMasFavoritos(4);


        foreach ($productos as &$producto) {

            $producto["producto_nombre"] = htmlspecialchars(
                $producto["producto_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );


            $producto["categoria_nombre"] = htmlspecialchars(
                $producto["categoria_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );


            $producto["marca_nombre"] = htmlspecialchars(
                $producto["marca_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );


            $producto["plataforma_nombre"] = htmlspecialchars(
                $producto["plataforma_nombre"],
                ENT_QUOTES,
                "UTF-8"
            );


            $producto["producto_precio"] = number_format(
                (float)$producto["producto_precio"],
                2
            );
        }


        unset($producto);


        $viewData["productos"] = $productos;


        \Views\Renderer::render("index", $viewData);
    }
}
?>