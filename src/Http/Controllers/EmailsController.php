<?php

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailsController extends Controller {

    public function __construct() {
        
    }

    public function getIndex() {

        return view('settings::emails');
    }

   
}
