<?php

namespace Modules\Base\Helpers\menu;

use Illuminate\Support\Facades\Auth;

class Navbar
{

    private $html;

    /**
     * Este objeto contem as funcoes que percorre o array com as funcionalidade e gera o menu em html
     */
    private $menuSistemas;

    public function __construct() {
        $this->menuSistemas = (new Menusistemas())->sistemas();
    }

    public function navbar()
    {
        return $this->menuNavBar();
    }

    private function menuNavBar()
    {

        $this->html = '';
        if(Auth::check()){
            $this->html = '<div class="navbar navbar-expand-md navbar-dark">
                                <div class="navbar-brand">
                                    <a href="'.route("home").'?opmn=" class="d-inline-block">
                                        <img src="'. asset("css/images/logo_light.png") .'" alt="">
                                    </a>
                                </div>

                                <div class="d-md-none">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                                        <i class="icon-tree5"></i>
                                    </button>
                                    <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                                        <i class="icon-paragraph-justify3"></i>
                                    </button>
                                </div>

                                <div class="collapse navbar-collapse" id="navbar-mobile">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                                                <i class="icon-paragraph-justify3"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <span class="ml-md-3 mr-md-auto" style="text-transform: uppercase"> NOME GESTOR</span>

                                    <ul class="navbar-nav navbar-right">
                                        '.$this->menuSistemas.'
                                        <li class="nav-item dropdown dropdown-user">
                                            <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                                                <!--<img src="../../../../global_assets/images/demo/users/face11.jpg" class="rounded-circle mr-2" height="34" alt="">-->
                                                <span>'.Auth::user()->usr_nome.'</span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> Perfil</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="'.route('configUsuario').'?opmn=" class="dropdown-item"><i class="icon-cog5"></i> Configuração</a>
                                                <a href="'. route('logout') .'" class="dropdown-item"><i class="icon-switch2"></i> Sair</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>';
        }

        return $this->html;
    }
}
