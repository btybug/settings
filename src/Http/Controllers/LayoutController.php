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
namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Themes\Themes;
use App\Modules\Assets\Models\LayoutUpload;
use App\Modules\Settings\Models\Sidebar;
use App\Modules\Settings\Models\SidebarTypes;
use Datatables;
use Illuminate\Http\Request;


class LayoutController extends Controller
{
    /**
     * @var mixed
     */
    public $dhelp;

    public function __construct ()
    {
        $this->dhelp = new \App\helpers\dbhelper;
    }


    public function getIndex ()
    {
        $active = Themes::active();
        return view('settings::frontend.page_layouts.index',compact(['active']));
    }
    public function getDeleteLayout ($key)
    {
        $active = Themes::active()->remove($key);
        return redirect()->back();
    }

}