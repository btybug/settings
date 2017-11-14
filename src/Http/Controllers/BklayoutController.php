<?php

namespace Btybug\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class BklayoutController extends Controller
{

    public function __construct()
    {
    }

    public function getIndex()
    {
        return view('settings::backend.layout');
    }

}
