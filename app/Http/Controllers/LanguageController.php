<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (array_key_exists($locale, Config::get('languages'))) {
            Session::put('applocale', $locale);
        }

        return redirect()->back();
    }
}
