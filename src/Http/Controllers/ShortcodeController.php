<?php

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class ShortcodeController extends Controller
{

    public function getIndex()
    {
        return view('settings::shortcode');
    }

}
