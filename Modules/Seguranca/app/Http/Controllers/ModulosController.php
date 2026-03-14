<?php

namespace Modules\Seguranca\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Seguranca\Models\Sistemas;

class ModulosController extends BaseController
{
    /** Set atributos da view */
    protected function getAttributesView(){
        return array(
            'sistemas' => $this->getAllSistemas()
        );
    }

    /** Busca Todas os sistemas cadastrados */
    private function getAllSistemas()
    {
        $sisModel = new Sistemas();

        $sistemas = $sisModel
            ->orderBy('sis_nome','ASC')
            ->get(['sis_nome','sis_id'])
            ->pluck('sis_nome', 'sis_id')
            ->toArray();

        return $sistemas;
    }
}
