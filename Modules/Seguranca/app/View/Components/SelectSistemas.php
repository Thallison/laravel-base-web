<?php

namespace Modules\Seguranca\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class SelectSistemas extends Component
{
    public $sistemas;
    public $selected;

    public function __construct($sistemas, $selected = null)
    {
        $this->sistemas = $sistemas;
        $this->selected = $selected;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('seguranca::components.selectsistemas');
    }
}
