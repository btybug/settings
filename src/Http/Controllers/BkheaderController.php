<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;

class BkheaderController extends Controller {

     public function __construct() {
    }

    public function getIndex() {
         return view('settings::backend.header');
    }
}
