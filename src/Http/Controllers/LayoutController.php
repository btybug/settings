<?php
/**
 * Copyright (c) 2016.
 * *
 *  * Created by PhpStorm.
 *  * User: Edo
 *  * Date: 10/3/2016
 *  * Time: 10:44 PM
 *
 */

namespace Btybug\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Themes\Themes;
use Datatables;
use Btybug\Assets\Models\LayoutUpload;


class LayoutController extends Controller
{
    /**
     * @var mixed
     */
    public $dhelp;

    public function __construct()
    {
        $this->dhelp = new \Btybug\Cms\Helpers\helpers;
    }


    public function getIndex()
    {
        $active = Themes::active();
        return view('settings::frontend.page_layouts.index', compact(['active']));
    }

    public function getDeleteLayout($key)
    {
        $active = Themes::active()->remove($key);
        return redirect()->back();
    }

}