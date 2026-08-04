<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Views\Renderer;

class Error extends PublicController
{
    public function run(): void
    {
        Renderer::render(
            "paypal/error",
            []
        );
    }
}