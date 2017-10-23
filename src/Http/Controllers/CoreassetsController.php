<?php

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class CoreassetsController extends Controller
{

    public function getIndex()
    {
        return view('settings::coreassets');
    }
}
