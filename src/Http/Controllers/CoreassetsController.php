<?php
namespace App\Modules\Settings\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoreassetsController extends Controller
{

	public function getIndex()
	{
		return view('settings::coreassets');
	}
}