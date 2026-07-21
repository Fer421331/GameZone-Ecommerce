<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Mantenimiento\WcResult as ResultDAO;

const RESULT_LIST_VIEW = 'mnt/lista';

class ResultList extends PublicController
{

    public function run(): void
    {
        $resultados["resultados"] = ResultDAO::getAll();

        Renderer::render(
            RESULT_LIST_VIEW,
            $resultados
        );
    }
}
