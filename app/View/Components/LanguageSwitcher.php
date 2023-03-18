<?php

namespace App\View\Components;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    public $currentLanguage;
    public $possibleLanguage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setLocaleData(App::getLocale());
    }

    private function setLocaleData($locale) {
        if ($locale == 'nl-NL') {
            $this->currentLanguage = ['locale' => 'nl-NL', 'label' => 'NL'];
            $this->possibleLanguage = ['locale' => 'en', 'label' => 'EN'];
        } else {
            $this->possibleLanguage = ['locale' => 'nl-NL', 'label' => 'NL'];
            $this->currentLanguage = ['locale' => 'en', 'label' => 'EN'];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.language-switcher');
    }
}
