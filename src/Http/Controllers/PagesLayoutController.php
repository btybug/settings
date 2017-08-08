<?php
/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 11/1/2016
 * Time: 9:35 PM
 */

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts;
use Sahakavatar\Resources\Models\LayoutUpload;
use Sahakavatar\Resources\Models\Validation as thValid;
use File;
use Illuminate\Http\Request;
use view;


class PagesLayoutController extends Controller
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
    }


    /**
     * @return view
     */
    public function getPagesLayout()
    {
        $layouts = ContentLayouts::findByType('admin_layout');
        return view("resources::backend_theme.pages_layout", compact(['layouts']));
    }


    public function postLayoutSettings(Request $request, $id, $save = false)
    {
        $layout = ContentLayouts::findByVariation($id);
        $html = $layout->renderLive($request->except('_token'));
        if ($save) {
            $variation=ContentLayouts::findVariation($id);
            $variation->settings=$request->except('_token');
            $variation->save();
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

    public function settings($slug)
    {
        $view['view'] = "resources::backend_theme.pages_layout_settings";
        return ContentLayouts::find($slug)->renderSettings($view);


    }

    public function getPagesLayoutDelete(Request $request, $slug)
    {
        $layouts = ContentLayouts::find($slug);
        if ($layouts->delete()) return redirect()->back();
    }

}