<?php

namespace Modules\Base\Helpers;

use Facade\FlareClient\Stacktrace\Stacktrace;
use Modules\Base\Helpers\Menu\Navigation;
use Modules\Base\Helpers\Menu\Navbar;


class Menu
{
    /**
     * Retorna a instancia e criação do menu navigation
     *
     * @return Navigation
     */
    public static function navigation()
    {
        return (new Navigation())->navigation();
    }

    /**
     * Retorna a instancia e criação do menu navbar
     *
     * @return Navbar
     */
    public static function navbar()
    {
        return (new Navbar())->navbar();
    }

}
