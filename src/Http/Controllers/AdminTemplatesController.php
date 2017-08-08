<?php
/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 11/1/2016
 * Time: 9:35 PM
 */

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts as AdminTemplates;
use Sahakavatar\Cms\Models\Templates\Units;
use Sahakavatar\Cms\Models\Widgets;
use Sahakavatar\Modules\Models\AdminPages;
use Sahakavatar\Resources\Models\LayoutUpload;
use Sahakavatar\Resources\Models\Validation as thValid;
use File;
use Illuminate\Http\Request;
use view;


class AdminTemplatesController extends Controller
{

    /**
     * @var
     */
    public $lyUpload;
    /**
     * @var
     */
    public $validateUpl;
    /**
     * @var mixed
     */
    public $up;
    public $unitTypes;

    /**
     * BackendThemeController constructor.
     * @param ThUpload $thUpload
     * @param thValid $validateUpl
     */
    public function __construct(LayoutUpload $lyUpload, thValid $validateUpl)
    {
        $this->lyUpload = $lyUpload;
        $this->validateUpl = new $validateUpl;

        $this->up = config('paths.backend_themes_upl');
        $this->unitTypes = @json_decode(File::get(config('paths.unit_path') . 'configTypes.json'), 1)['types'];
    }


    /**
     * @return view
     */
    public function getPagesLayout()
    {
        $layouts = AdminTemplates::findByType('admin_template');
        return view("settings::admin_templates.page_templates", compact(['layouts']));
    }
    public function getMainBody()
    {
        $layouts = AdminTemplates::findByType('main_body');
        return view("settings::admin_templates.main_body", compact(['layouts']));
    }
    public function getUnits(Request $request)
    {
        $slug = $request->get('p');
        $type = $request->get('type');
        $types = [];
        $ui_elemements = null;
        $unit = null;
        if(count( $this->unitTypes)){
            foreach($this->unitTypes as $unitType){
                $types[$unitType['foldername']] = $unitType['title'];
            }

            $main_type =$this->unitTypes[0]['foldername'];
            if($type){
                $main_type = $type;
            }

            $ui_elemements = Units::getAllUnits()->where('type',$main_type )->run();
            if($slug){
                $unit = Units::find($slug);
            }else{
                $unit = Units::find($ui_elemements[0]->slug);
            }
        }
        return view("settings::admin_templates.units",compact(['ui_elemements','types','unit','type']));
    }


    public function postLayoutSettings(Request $request, $id, $save = false)
    {
        $layout = ContentLayouts::find($id);
        $html = $layout->renderLive($request->except('_token'));
        if ($save) {
            $layout->saveSettings($request->except('_token'));
        }
        return \Response::json(['error' => false, 'html' => $html]);
    }


    public function postUploadLayout(Request $request)
    {
        $isValid = $this->validateUpl->isCompress($request->file('file'));

        if (!$isValid) return $this->lyUpload->ResponseError('Uploaded data is InValid!!!', 500);

        $response = $this->lyUpload->upload($request);
        if (!$response['error']) {
            $result = $this->lyUpload->validatConfAndMoveToMain($response['folder'], $response['data']);

            if (!$result['error']) {
                File::deleteDirectory($this->up, true);
                return $result;
            } else {
                File::deleteDirectory($this->up, true);
                return $result;
            }
        } else {
            File::deleteDirectory($this->up, true);
            return $response;
        }
    }

    public function getPagesLayoutDelete(Request $request, $slug)
    {
        $layouts = ContentLayouts::find($slug);
        if ($layouts->delete()) return redirect()->back();
    }

}