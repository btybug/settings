<?php

namespace Btybug\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class EmailsController extends Controller
{

    public function __construct()
    {

    }

    public function getIndex()
    {

        return view('settings::emails');
    }


}
