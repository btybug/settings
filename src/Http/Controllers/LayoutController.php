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
namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Themes\Themes;
use Sahakavatar\Assets\Models\LayoutUpload;
use Sahakavatar\Settings\Models\Sidebar;
use Sahakavatar\Settings\Models\SidebarTypes;
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
        $this->dhelp = new \Sahakavatar\Cms\Helpers\helpers;
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