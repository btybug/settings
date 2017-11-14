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

/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 11/1/2016
 * Time: 9:35 PM
 */

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Datatables;
use Illuminate\Http\Request;
use Sahakavatar\Settings\Models\Sidebar;
use Sahakavatar\Settings\Models\SidebarTypes;


/**
 * Class FrontPagesLayoutController
 * @package Sahakavatar\Settings\Http\Controllers
 */
class FrontPagesLayoutController extends Controller
{

    /**
     * @var
     */
    public $lyUpload;
    /**
     * @var mixed
     */
    public $up, $dhelp, $sidebar;

    /**
     * BackendThemeController constructor.
     * @param ThUpload $thUpload
     */
    public function __construct(LayoutUpload $lyUpload, Sidebar $sidebar)
    {
        $this->lyUpload = $lyUpload;

        $this->up = config('paths.backend_themes_upl');
        $this->dhelp = new \Sahakavatar\Cms\Helpers\helpers;
        $this->sidebar = $sidebar;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPageLayout()
    {
        $form_fields = [
            '#' => '#',
            'title' => 'Title',
            "has_header" => "Has Header",
            "has_footer" => "Has Footer",
            "has_sidebar1" => "Has Sidebar1",
            "has_sidebar2" => "Has Sidebar2",
            "extratop" => "Has Extra Top",
            "extrabottom" => "Has Extra Bottom",
            'action' => 'Action'
        ];

        $columns = $this->dhelp->getColumnsJson($form_fields);

        return view('settings::frontend.page_layouts.page_layout', compact(['form_fields', 'columns']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPageLayoutBuilder()
    {
        $sidebars = Sidebars::pluck('name', 'id');
        $types = SidebarTypes::extra()->get();
        $layout = [];

        return view('settings::frontend.page_layouts.page_layout_builder', compact(['sidebars', 'layout', 'types']));
    }

    /**
     * @param Request $request
     */
    public function postDeletebulk(Request $request)
    {
        $vals = $request->get('vals');
        $ids = explode(",", $vals);
        foreach ($ids as $id) {
            $layout = Layouts::find($id);
            if ($layout) {
                $layout->delete();
            }
        }
        $this->helpers->updatesession('Layouts deleted');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteLayout(Request $request)
    {
        $layout = Layouts::find($request->get('id'));

        if ($layout) {
            $layout->delete();
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postPageLayoutBuilder(Request $request)
    {
        $layout = [];
        $data = $request->all();
        $extra = $request->get('extra_types');
        $create_data = $request->only(['title', 'settings_data', 'settings_json', 'settings_css']);

        (isset($data['has_header'])) ? array_push($layout, ['has_header' => []]) : null;
        (isset($data['has_sidebar1'])) ? array_push($layout, ['has_sidebar1' => []]) : null;
        (isset($data['has_sidebar2'])) ? array_push($layout, ['has_sidebar2' => []]) : null;
        (isset($data['extratop'])) ? array_push($layout, ['extratop' => []]) : null;
        (isset($data['extrabottom'])) ? array_push($layout, ['extrabottom' => []]) : null;
        (isset($data['has_footer'])) ? array_push($layout, ['has_footer' => []]) : null;

        if ($extra) {
            $layout_arr[]['extra_types'] = $extra;
        }
        $create_data['data_option'] = json_encode($layout, true);

        Layouts::Create($create_data);

        return redirect('admin/settings/frontend/page-layout');
    }

    /**
     * @return mixed
     */
    public function getDataLayouts()
    {
        $data = Layouts::all();
        $obj = Datatables::of($data);

        $obj->editColumn(
            '#',
            function ($model) {
                return '<input name="plugin" class="del_select" type="checkbox" value="{!! $model->id !!}" /> ';
            }
        );

        $obj->editColumn(
            'has_header',
            function ($model) {
                if ($model->data_option) {
                    $data = json_decode($model->data_option, true);
                    if (isset($data['header'])) {
                        return 'Yes';
                    }
                }

                return 'No';
            }
        );

        $obj->editColumn(
            'has_footer',
            function ($model) {
                if ($model->data_option) {
                    $data = json_decode($model->data_option, true);
                    if (isset($data['footer'])) {
                        return 'Yes';
                    }
                }

                return 'No';
            }
        );

        $obj->editColumn(
            'has_sidebar1',
            function ($model) {
                if ($model->data_option) {
                    $data = json_decode($model->data_option, true);
                    if (isset($data['sidebar1'])) {
                        return 'Yes';
                    }
                }

                return 'No';
            }
        );

        $obj->editColumn(
            'has_sidebar2',
            function ($model) {
                if ($model->data_option) {
                    $data = json_decode($model->data_option, true);
                    if (isset($data['sidebar2'])) {
                        return 'Yes';
                    }
                }

                return 'No';
            }
        );

        $obj->editColumn(
            'extratop',
            function ($model) {
                if ($model->data_option) {
                    $data = json_decode($model->data_option, true);
                    if (isset($data['extratop'])) {
                        return 'Yes';
                    }
                }

                return 'No';
            }
        );

        $obj->editColumn(
            'extrabottom',
            function ($model) {
                if ($model->data_option) {
                    $data = json_decode($model->data_option, true);
                    if (isset($data['extrabottom'])) {
                        return 'Yes';
                    }
                }

                return 'No';
            }
        );


        $obj->addColumn(
            'action',
            $this->dhelp->actionBtns(
                [
                    'delete_post' => ['link' => '/admin/settings/frontend/delete-layout', 'id' => '{!! $id !!}'],
                    'edit' => ['link' => '/admin/settings/frontend/edit-page-layout/{!! $id !!}'],
                ]
            )
        );
        $obj = $obj->make(true);

        return $obj;
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEditPageLayout($id)
    {
        if ($layout = Layouts::find($id)) {
            $sidebars = $this->sidebar->all()->pluck('name', 'id');
            $types = SidebarTypes::extra()->get();

            if ($layout->data_option) {
                $options = json_decode($layout->data_option, true);
                if (!empty($options)) {
                    foreach ($options as $val) {
                        if (key($val) == 'extra_types') {
                            if (count($val)) {
                                foreach ($val as $extra) {
                                    $layout->setAttribute("extra_types[" . key($extra) . "]", key($extra));
                                }
                            }

                        } else {
                            $layout->setAttribute(key($val), 1);
                        }

                    }
                }
            }

            return view('settings::frontend.page_layouts.page_layout_builder', compact(['layout', 'sidebars', 'types']));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEditPageLayoutDesktop($id)
    {
        if ($layout = Layouts::find($id)) {
            $sidebars = Sidebars::pluck('name', 'id');

            return view('settings::frontend.page_layouts.edit_page_layout_desktop', compact(['layout', 'sidebars']));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEditPageLayoutLandscape($id)
    {
        if ($layout = Layouts::find($id)) {
            return view('settings::frontend.page_layouts.edit_page_layout_landscape', compact(['layout']));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEditPageLayoutPortrait($id)
    {
        if ($layout = Layouts::find($id)) {
            return view('settings::frontend.page_layouts.edit_page_layout_portrait', compact(['layout']));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEditPageLayoutMobile($id)
    {
        if ($layout = Layouts::find($id)) {
            return view('settings::frontend.page_layouts.edit_page_layout_mobile', compact(['layout']));
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditPageLayout($id, Request $request)
    {
        if ($layout = Layouts::find($id)) {
            $layout_arr = [];
            $data = $request->all();
            $extra = $request->get('extra_types');
            $create_data = $request->only(['title', 'settings_data', 'settings_json', 'settings_css']);

            (isset($data['has_header'])) ? array_push($layout_arr, ['has_header' => []]) : null;
            (isset($data['has_sidebar1'])) ? array_push($layout_arr, ['has_sidebar1' => []]) : null;
            (isset($data['has_sidebar2'])) ? array_push($layout_arr, ['has_sidebar2' => []]) : null;
            (isset($data['extratop'])) ? array_push($layout_arr, ['extratop' => []]) : null;
            (isset($data['extrabottom'])) ? array_push($layout_arr, ['extrabottom' => []]) : null;
            (isset($data['has_footer'])) ? array_push($layout_arr, ['has_footer' => []]) : null;

            if ($extra) {
                $layout_arr[]['extra_types'] = $extra;
            }
            $create_data['data_option'] = json_encode($layout_arr, true);
            $layout->update($create_data);
        }

        return redirect('admin/settings/frontend/page-layout');
    }
}