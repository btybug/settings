<?php
namespace Sahakavatar\Settings\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class LangController extends Controller
{

	public function getIndex()
	{
		return view('settings::languages.lang');
	}
}
