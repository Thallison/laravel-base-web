<?php

namespace Modules\Base\Helpers\menu;

use League\CommonMark\Util\UrlEncoder;

class Dropdown
{

    /**
     *
     * @var type
     */
    private $menuHtml;

    /**
     *
     * @var type
     */
    private $ulClass;

    /**
     *
     * @var type
     */
    private $liClass;

    /**
     *
     * @var array Array contendo os liks a serem exibidos
     */
    private $links;

    /**
     * Contem o Html do menu do usuário
     * @var type
     */
    private $menuUser;

    /**
     * Variavel para controlar se será exibido o menu do usuário com a imagem e
     * algumas configurações do mesmo
     * @var type
     */
    private $showUserMenu = false;

    /**
     *
     * @param type $links
     * @param type $ul_class
     * @param type $li_class
     */
    public function __construct($links = array(), $ul_class = "nav nav-treeview", $li_class = "nav-item")
    {
        $this->setLinks($links);
        $this->setUlClass($ul_class);
        $this->setLiClass($li_class);
        $this->menuHtml = "";
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function getMenuHtml()
    {
        return $this->menuHtml;
    }

    public function setMenuHtml($menuHtml)
    {
        $this->menuHtml = $menuHtml;
    }

    /**
     * Este método gera uma string com o atributo classe a ser usado
     * @return string
     */
    public function getUlClass()
    {
        $this->setUlClass('nav nav-treeview');
        return "class='" . $this->ulClass . "'";
    }

    public function setUlClass($ulClass)
    {
        $this->ulClass = $ulClass;
    }

    /**
     * Este método gera a string com o atributo class a ser usado pelas li
     * @return string
     */
    public function getLiClass()
    {
        if (!empty($this->liClass)) {
            return $this->liClass;
        }
        return "";
    }

    public function setLiClass($liClass)
    {
        $this->liClass = $liClass;
    }

    /**
     * Adiciona novos links no final da barra
     * @param type $links
     * @return \BarraNavegacao
     */
    public function addLinks($links)
    {
        $this->links[] = $links;
        return $this;
    }

    public function setLinks($links)
    {
        $this->links = $links;
        return $this;
    }

    public function getMenuUser()
    {
        return $this->menuUser;
    }

    public function setMenuUser($menuUser)
    {
        $this->menuUser = $menuUser;
    }

    public function getShowUserMenu()
    {
        return $this->showUserMenu;
    }

    public function setShowUserMenu($showUserMenu = true)
    {
        //$this->setMenuUser((new MenuUser())->showUserMenu());
        $this->showUserMenu = $showUserMenu;
    }

    /**
     * Abre a tag de criação do menu
     */
    public function openTagMenu()
    {
        $this->menuHtml = ' <div class="sidebar-wrapper">
                                <nav class="mt-2">
                                    <!--begin::Sidebar Menu-->
                                    <ul
                                        class="nav sidebar-menu flex-column"
                                        data-lte-toggle="treeview"
                                        role="navigation"
                                        aria-label="Main navigation"
                                        data-accordion="false"
                                        id="navigation"
                                        >';
    }

    /**
     * Fecha a tag de criação do menu
     */
    public function closeTagMenu()
    {
        $this->menuHtml .= '        </ul>
                                </nav>
                            </div>';
    }

    /**
     * Este método monta o cabecalho de cada UL seguindo os padroes do menu desenvolvido no layout
     * @param array $link
     * @return string
     */
    private function mountHeadOpenUl($link, $dataTitle = false)
    {
        $c = $this->getLiClass();
        $d = '';
        if(session()->has('opmn')){
            if(base64_decode(session()->get('opmn')) == $link['opmn'] ){
                $d = ' menu-open ';
            }
        }

        $icon = '';
        if(!empty($link['link']['icone'])){
            $icon = "<i class='nav-icon {$link['link']['icone']}'></i>";
        }

        $html = "<li class='".$c.$d."' >";
        $html .= "<a href='#' class='nav-link' > {$icon}<p>{$link['link']['titulo']}<i class='nav-arrow bi bi-chevron-right'></i></p></a>";
        if($dataTitle){
            $html .= "<ul data-submenu-title='{$link['link']['titulo']}' {$this->getUlClass()}>";
        }else{
            $html .= "<ul  {$this->getUlClass()}>";
        }
        return $html;
    }

    /**
     * Este método fecha o conteudo da ul seguindo os padroes definidos no layout do ecossistema
     */
    private function mountHeadCloseUl($link)
    {
         $d = '';
        if(session()->has('opmn')){
            if(base64_decode(session()->get('opmn')) == $link['opmn'] ){
                $d = ' menu-open ';
            }
        }
        $this->menuHtml .= "<li class='nav-item ".$d."'>" . $this->mountA($link['link']) . "</li>";
    }

    /**
     * Este metodo monta a lista com os links passados
     */
    private function mountLinks() {

        $this->openTagMenu();

        foreach ($this->links as $link) {
            if (isset($link['submenu'])) {
                $this->menuHtml .= $this->mountHeadOpenUl($link, true);

                foreach ($link['submenu'] as $submenu) {
                    if (isset($submenu['submenu'])) {
                        $this->menuHtml .= $this->mountHeadOpenUl($submenu);

                        foreach ($submenu['submenu'] as $submenu2) {
                            if (isset($submenu2['submenu'])) {
                                $this->menuHtml .= $this->mountHeadOpenUl($submenu2);

                                foreach ($submenu2['submenu'] as $submenu3) {
                                    if (isset($submenu3['submenu'])) {
                                        $this->menuHtml .= $this->mountHeadOpenUl($submenu3);

                                        foreach ($submenu3['submenu'] as $submenu4) {
                                            if (isset($submenu4['submenu'])) {
                                                $this->menuHtml .= $this->mountHeadOpenUl($submenu4);
                                                foreach ($submenu4['submenu'] as $submenu5) {
                                                    $this->menuHtml .= "<li>" . $this->mountA($submenu5['link']) . "</li>";
                                                }
                                                $this->menuHtml .= "</ul>";
                                            }
                                            else {
                                                $this->menuHtml .= $this->mountHeadCloseUl($submenu3);
                                            }
                                        }
                                        $this->menuHtml .= "</ul>";
                                    }
                                    else {
                                        $this->menuHtml .= $this->mountHeadCloseUl($submenu3);
                                    }
                                }
                                $this->menuHtml .= "</ul>";
                            }
                            else {
                                $this->menuHtml .= $this->mountHeadCloseUl($submenu2);
                            }
                        }
                        $this->menuHtml .= "</ul>";
                    }
                    else {
                        $this->menuHtml .= $this->mountHeadCloseUl($submenu);
                    }
                }

                $this->menuHtml .= "</ul>";
            } else {
                $this->menuHtml .= $this->mountHeadCloseUl($link);
            }
        }
        $this->closeTagMenu();
    }

    /**
     * Monta a barra de navegacao
     * @return string
     */
    public function showMenu() {
        $this->mountLinks();
        return $this->menuHtml;
    }

    /**
     * Este metodo cria o elemento a
     * @param type $link
     * @return string
     */
    public function mountA($link) {

        $c = 'nav-link';
        $d = '';
        if(session()->has('opmn')){
            if(base64_decode(session()->get('opmn')) == $link['opmn'] ){
                $c = 'nav-link active';
                $d = 'menu-open';
            }
        }

        $a = "<a class='".$c."'";
        $icone = $link['icone'];
        $titulo = $link['titulo'];
        $linkHref =  $link['href'] ? route($link['href']) : '#';
        $a .= "href='" . strtolower($linkHref) . "?opmn=".base64_encode($link['opmn'])."'";
        unset($link['icone']);
        unset($link['titulo']);
        unset($link['href']);

        foreach ($link as $chave => $value) {
            $a .= "{$chave}=\"" . $value . "\" ";
        }
        $a .= ">";
        if ($icone) {
            $a .= " <i class=\"nav-icon " . $icone . "\"></i> ";
        }
        //validar se é submenu colocar o icone dentro do a (<i class="nav-arrow bi bi-chevron-right"></i>)
        $a .= " <p>" . $titulo . "</p> </a>";
        return $a;
    }

}
