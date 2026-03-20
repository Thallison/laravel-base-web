<?php

namespace Modules\Base\Helpers\menu;

use Illuminate\Support\Facades\Auth;
use Modules\Seguranca\Models\Funcionalidades;
use Modules\Seguranca\Models\Modulos;

class Navigation
{


    /**
     * Este objeto contem as funcoes que percorre o array com as funcionalidade e gera o menu em html
     */
    private $menuDropdown;

    public function __construct() {
        $this->menuDropdown = new Dropdown();
    }

    public function navigation()
    {
        return $this->criaNiveisMenu();
    }

    private function criaNiveisMenu()
    {
        if(!Auth::check()){
            return;
        }

        if(session()->has('sistemas')){
            $sessionSistema = session()->get('sistemas');
            $sessionLinkMenu = session()->get('linksMenu');
            $array = [];

            //Verifica se a sessão já possui os links dos menus do sistema selecionado criado
            if( !isset($sessionLinkMenu[$sessionSistema['sisId']]) ){
                $user = Auth::user();
                //busca modulos do sistema do usuario
                $modulosLoad = Modulos::getModulosSistemaUser($sessionSistema['sisId'], $user->usr_id);

                foreach ($modulosLoad as $indiceMod => $modulo) {
                    $link = array('titulo' => $modulo->mod_nome, 'href' => '#', 'icone' => $modulo->mod_icone, 'opmn' => $modulo->mod_id);

                    $funcionalidadesPai = Funcionalidades::getFuncPai($user->usr_id, $modulo->mod_id);

                    $funcionalidades = [];
                    foreach ($funcionalidadesPai as $func) {
                        $submenu1 = Funcionalidades::getFuncFilhas($user->usr_id, $func->func_id);
                        if($submenu1->count()){
                            $funcSubmenu1 = [];
                            $link1 = array('titulo' => $func->func_label, 'href' => $func->func_rota_padrao, 'icone' => $func->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id);
                            // inicia rotina para listar submenu do 1º nivel
                            foreach ($submenu1 as $sub1) {
                                $submenu2 = Funcionalidades::getFuncFilhas($user->usr_id, $sub1->func_id);
                                if($submenu2->count()){
                                    $funcSubmenu2 = [];
                                    $link2 = array('titulo' => $sub1->func_label, 'href' => $sub1->func_rota_padrao, 'icone' => $sub1->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id);
                                    // inicia rotina para listar submenu do 2º nivel
                                    foreach ($submenu2 as $sub2) {
                                        $submenu3 = Funcionalidades::getFuncFilhas($user->usr_id, $sub2->func_id);
                                        if($submenu3->count()){
                                            $funcSubmenu3 = [];
                                            $link3 = array('titulo' => $sub2->func_label, 'href' => $sub2->func_rota_padrao, 'icone' => $sub2->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id.'-'.$sub2->func_id);
                                            // inicia rotina para listar submenu de 3º nivel
                                            foreach ($submenu3 as $sub3) {
                                                $submenu4 = Funcionalidades::getFuncFilhas($user->usr_id, $sub3->func_id);
                                                if($submenu4->count()){
                                                    $funcSubmenu4 = array();
                                                    $link4 = array('titulo' => $sub3->func_label, 'href' => $sub3->func_rota_padrao, 'icone' => $sub3->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id.'-'.$sub2->func_id.'-'.$sub3->func_id);
                                                    foreach ($submenu4 as $sub4) {
                                                        $funcSubmenu4[$sub4->func_id] = array('link' => array('titulo' => $sub4->func_label, 'href' => $sub4->func_rota_padrao, 'icone' => $sub4->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id.'-'.$sub2->func_id.'-'.$sub3->func_id.'-'.$sub4->func_id));
                                                    }
                                                    $item5 = array(
                                                        'link' => $link4,
                                                        'submenu' => $funcSubmenu4
                                                    );
                                                    $funcSubmenu3[$sub3->func_id] = $item5;
                                                }else{
                                                    $funcSubmenu3[$sub3->func_id] = array('link' => array('titulo' => $sub3->func_label, 'href' => $sub3->func_rota_padrao, 'icone' => $sub1->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id.'-'.$sub2->func_id.'-'.$sub3->func_id));
                                                }
                                            }

                                            $item4 = array(
                                                'link' => $link3,
                                                'submenu' => $funcSubmenu3
                                            );
                                            $funcSubmenu2[$sub2->func_id] = $item4;

                                        }else{
                                            $funcSubmenu2[$sub2->func_id] = array('link' => array('titulo' => $sub2->func_label, 'href' => $sub2->func_rota_padrao, 'icone' => $sub2->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id.'-'.$sub2->func_id));
                                        }
                                    }
                                    // termina rotina para listar submenu do 2º nivel
                                    $item3 = array(
                                        'link' => $link2,
                                        'submenu' => $funcSubmenu2
                                    );
                                    $funcSubmenu1[$sub1->func_id] = $item3;
                                }else{
                                    $funcSubmenu1[$sub1->func_id] = array('link' => array('titulo' => $sub1->func_label, 'href' => $sub1->func_rota_padrao, 'icone' => $sub1->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id.'-'.$sub1->func_id));
                                }
                            }
                            // termina a rotina de listar o submenu de nivel 1º
                            $item2 = array(
                                'link' => $link1,
                                'submenu' => $funcSubmenu1
                            );
                            $funcionalidades[$func->func_id] = $item2;
                        }else{
                            $funcionalidades[$func->func_id] = array('link' => array('titulo' => $func->func_label, 'href' => $func->func_rota_padrao, 'icone' => $func->func_icon, 'opmn' => $modulo->mod_id.'-'.$func->func_id));
                        }
                    }

                    if($funcionalidades){
                        $item = array(
                            'link' => $link,
                            'submenu' => $funcionalidades
                        );

                        $array[$indiceMod] = $item;
                    }

                    // termina rotina de listar funcionalidade pai
                }

                if (count($array) == 0) {
                    $array = array(
                        array('link' => array('titulo' => "Você não tem permissão de acesso a nenhum módulo no sistema", 'href' => "", 'icone' => 'icon-shield-notice', 'opmn' => ''))
                    );
                }

                $aux = session()->get('linksMenu');
                $aux[$sessionSistema['sisId']] = $array;
                session()->put('linksMenu', $aux);
            }

            $m = session()->get('linksMenu');

            //Seta os menus do sistema selecionado
            $this->menuDropdown->setLinks($m[$sessionSistema['sisId']]);
            //$this->menuDropdown->setShowUserMenu(true);

            return $this->menuDropdown->showMenu();
        }
    }
}
