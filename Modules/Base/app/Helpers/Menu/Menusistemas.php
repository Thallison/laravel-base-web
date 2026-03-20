<?php

namespace Modules\Base\Helpers\menu;

use Illuminate\Support\Facades\Auth;

class Menusistemas
{

    private $html;

    public function sistemas()
    {
        return $this->menuSistemas();
    }

    private function menuSistemas()
    {
        $this->html = '';
        if(Auth::check()){

            if(Auth::user()->sistemasUsuario()->get()->count() > 1){

                $sessionSis = session()->get('sistemas');

                $this->html = '<li class="nav-item dropdown">';
                $this->html .= "<a class='navbar-nav-link d-flex align-items-center dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>";
                $this->html .= "<i class='position-left {$sessionSis['sisIcone']}'></i>{$sessionSis['sisNome']}<span class='caret'></span></a>";
                $this->html .= '<div class="dropdown-menu dropdown-menu-right">';
                $this->html .= '<a class="dropdown-item" href="#"> Selecione Sistema</a>';
                $this->html .= '<div class="dropdown-divider"></div>';

                if(isset($sessionSis['sistemasUsuario'])){
                    foreach ($sessionSis['sistemasUsuario'] as $sistema) {
                        $this->html .= "<a class='dropdown-item' href='".route('seguranca::sistemas.selecionasistema', ['sistema' => $sistema->sis_id ])."'><i class='{$sistema->sis_icone}'></i>{$sistema->sis_nome}</a>";
                    }
                }

                $this->html .= '</div></li>';

            }
        }

        return $this->html;
    }
}
