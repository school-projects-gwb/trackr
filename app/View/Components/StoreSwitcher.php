<?php

namespace App\View\Components;

use App\Models\Webstore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;

class StoreSwitcher extends Component
{
    public $selectedStore;
    public $userStores;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->selectedStore = Webstore::where('id', $request->cookie('selected_store_id'))->first();
        if ($this->selectedStore != null) {
            $this->userStores = Auth::user()->stores()->where('id', '<>', $this->selectedStore->id)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.store-switcher');
    }
}
