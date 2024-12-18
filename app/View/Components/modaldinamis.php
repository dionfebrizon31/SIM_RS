<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modaldinamis extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $tittle;
    public $size;

    public function __construct($id = 'modal-id', $tittle = 'Modal Title', $size = 'modal-xl')
    {
        $this->id = $id;
        $this->tittle = $tittle;
        $this->size = $size; // Bisa 'sm', 'md', atau 'lg'
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modaldinamis');
    }
}
