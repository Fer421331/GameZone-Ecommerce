<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Utilities\Bitacora;
use Views\Renderer;

class Error extends PublicController
{
    public function run(): void
    {

        Bitacora::registrar(
            "Checkout",
            "Pago cancelado o fallido",
            "El usuario no completó el pago mediante PayPal.",
            "WAR"
        );


        Renderer::render(
            "paypal/error",
            []
        );
    }
}