<?php

namespace App\View\Livewire;

use Livewire\Component;

class ProductDetailUnlogin extends Component
{

    public $item;
    public $class;

    public function mount()
    {

    }
    public function render()
    {
        return view('livewire.product-detail-unlogin');
    }
}