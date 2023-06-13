<?php

namespace App\View\Livewire;

use Livewire\Component;

class ShopLike extends Component
{
    public $item;
    public $isLike;
    public function changeLike()
    {

    }
    public function render()
    {
        return view('livewire.shop-like');
    }
}