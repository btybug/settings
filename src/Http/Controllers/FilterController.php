<?php
namespace App\Modules\Settings\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Moduledb;
use App\Modules\Settings\Models\Filter;
use App\helpers\helpers;
use App\helpers\dbhelper;
use App\Modules\Settings\Models\Common;
use App\Modules\Create\Fields;
use Illuminate\Support\Collection;
use Datatables, File;
use App\Modules\Users\Models\Sessions;
use Redirect;
use Illuminate\Support\Facades\Session;
use App\Modules\Users\User;



/**
 * @property CHelper chelper
 * @property Term term
 */
class FilterController extends Controller
{
    protected $dhelp;
    private $helpers = null;
    protected $common;

    /**
     * UploaderController constructor.
     *
     * @param Common $common
     */
    public function __construct(Common $common)
    {
        $this->helpers = new helpers;
        $this->dhelp = new dbhelper;
        $this->home = '/admin/settings/filter';
        $this->common = $common;
    }

    public function getIndex()
    {
        $form_fields = [
            '#' => '#',
            'title' => 'Title',
            'filter_data' => 'Filter Data',
            'module' => 'Module',
            'created_at' => 'Add Date',
            'action' => 'Action'
        ];
        $columns = $this->dhelp->getColumnsJson($form_fields);

        return view('settings::filter.index', compact(['form_fields', 'columns']));
    }


    /**
     * @return CHelper
     */
    public function getForceLogOut($user_id)
    {
        $sesion=  Sessions::where('user_id',$user_id)->first();
        $sesion->delete();
        return Redirect::back()->with('logoutMsg', 'User Logged Out Successfully!');
    }
    /**
     * Add new Filter
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        $modules = Moduledb::all()->pluck('title', 'id');
        $modules->prepend('Select Module', '');

        return view('settings::filter.create', compact(['modules']));
    }


    /**
     * Save Filter in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreate(Request $request)
    {

        $rules = [
            'title' => 'required',
            'module_id' => 'required|integer'
        ];
        $v = $this->validate($request, $rules);
        $module = Moduledb::find($request->module_id);
        $data = [
            'id' => $this->helpers->underScore($request->title), //$filter->id,
            'module_name' => $module->folder_name,
            'info' => $request->filter_json
        ];
        $this->common->mkJson($data);
        $this->common->updateFiltersArr($request, $module);
        $this->helpers->updatesession('Filter Added Successfully');

        return redirect($this->home);

    }

    /**
     * Add new Filter
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate($id = null)
    {
        $modules = Moduledb::all()->lists('title', 'id');
        $data = config('admin.filters');
        $info = $data[$id];
        //Temp CODE, MUST SHIFT IN SOME MODEL LATER
        $path = config('paths.modules_path') .  $info['module']."/Filters/".$info["file_name"];
        if (File::exists($path)) {
            $json = File::get($path);
        }
        $json = preg_replace('/\s+/', '', $json);
        $jsonObject = json_decode($json, true);

        //Temp CODE, MUST SHIFT IN SOME MODEL LATER
        return view('settings::filter.update', compact(['modules', 'json','info', 'jsonObject', 'id']));

    }

    /**
     * Update Filter in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdate(Request $request)
    {
        $this->common->updateFilter($request);
        $this->helpers->updatesession('Filter Updated Successfully');

        return redirect($this->home);
    }

    /**
     * Delete Filter
     *
     * @param Request $request
     * @internal param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDelete(Request $request)
    {
        $id = $request->id;
        $this->common->delJson($id);
        $this->helpers->updatesession('Filter Deleted Successfully');

        return redirect($this->home);

    }

    public function postDeleteblk(Request $request)
    {
        $ids = $request->ids;
        $ids_arr = explode(",", $ids);
        if (is_array($ids_arr)) {
            foreach ($ids_arr as $id) {
                $this->common->delJson($id);
            }
        }
        $this->helpers->updatesession('Filter Deleted Successfully');
    }


    public function postFilterdata(Request $request)
    {
        $json = $this->common->getJson($request);

        return $json;

    }


    /**
     * Show all filters related to one module
     *
     * @param Request $request
     * @return View Object
     */
    public function postFilters(Request $request)
    {
        $id = $request->get('module');
        $module = Moduledb::find($id);
        $filters[''] = '';
        if ($module) {
            $filters = Fields::ModuleFilters($module->folder_name)->lists('name', 'id');
            $filters->prepend('Select Filter', '');
        }

        return $this->helpers->ddbyarray($filters);
    }


    public function getData()
    {
        $users = new Collection();
        $filter = new Filter;
        $data = config('admin.filters');
        foreach ($data as $key => $val) {
            $users->push(
                [
                    'id' => $key,
                    'title' => $val['title'],
                    'module' => $val['module'],
                    'created_at' => $val['created_at'],
                    'filter_data' => $val['filter_data']

                ]
            );
        }
        $obj = Datatables::of($users);
        $obj->addColumn(
            '#',
            function ($class) {
                return '<input name="plugin" class="del_select chk_unchk_all" type="checkbox" value="' . $class['id'] . '" />';
            }
        );


        $obj->addColumn(
            'action',
            $this->dhelp->actionBtns(
                [
                    'edit' => ['link' => '/admin/settings/filter/update/{!! $id !!}'],
                    'delete_post' => ['link' => '/admin/settings/filter/delete', 'id' => '{!! $id !!}'],
                ]
            )
        );
        $obj = $obj->make(true);

        return $obj;
    }

    public function postRunQuery(Request $request)
    {
        return BBRunQuery($request->get('json'), 'JSON');
    }
}