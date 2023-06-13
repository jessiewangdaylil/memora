<?php

namespace App\View\Livewire;

use App\Models\UserItemLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShopLike extends Component
{
    // public
    public $item;
    public $isLike;
    public $user;
    public function changeLike()
    {
        if ($this->isLike == false) {
            $userItemLike = UserItemLike::create([
                'user_id' => $this->user,
                'item_id' => $this->item->id,
            ]);
            if ($userItemLike->wasRecentlyCreated) {
                $this->isLike = true;
            }
        } elseif ($this->isLike == true) {
            $userItemLike = UserItemLike::where('user_id', $this->user)->where('item_id', $this->item->id)->latest()->first();
            $userItemLike->delete();
            $this->isLike = false;
        }

    }
    public function mount()
    {
        if (count(UserItemLike::where('user_id', Auth::id())->where('item_id', $this->item->id)->get()) == 0) {
            $this->isLike = false;
        } else {
            $this->isLike = true;
        }
        $this->user = Auth::id();

    }
    public function render()
    {

        return view('livewire.shop-like');
    }
}