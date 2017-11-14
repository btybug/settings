<?php

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class LangController extends Controller
{

    public function getIndex()
    {
        return view('settings::languages.lang');
    }
}
