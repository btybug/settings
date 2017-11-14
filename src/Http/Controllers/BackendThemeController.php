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
use File;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Models\ContentLayouts\ContentLayouts;
use Sahakavatar\Cms\Models\UiElements;
use Sahakavatar\Create\Models\Menu;
use Sahakavatar\Resources\Models\BackendTh;
use Sahakavatar\Resources\Models\StyleItems;
use Sahakavatar\Resources\Models\Styles;
use Sahakavatar\Settings\Models\LayoutUpload;
use Sahakavatar\Settings\Models\ThUpload;
use Sahakavatar\Settings\Models\Validation as thValid;
use Sahakavatar\User\Models\Roles;
use view;

/**
 * Class ModulesController
 * @package Sahakavatar\Modules\Http\Controllers
 */
class BackendThemeController extends Controller
{

    /**
     * @var
     */
    public $thUpload;
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
    public function __construct(ThUpload $thUpload, LayoutUpload $lyUpload, thValid $validateUpl)
    {
        $this->thUpload = new $thUpload;
        $this->lyUpload = $lyUpload;
        $this->validateUpl = new $validateUpl;

        $this->up = config('paths.backend_themes_upl');
    }

    /**
     * @return view
     */
    public function getIndex()
    {
        $themes = BackendTh::all()->run();
        return view("settings::backend_theme.main_theme", compact(['themes']));
    }

    /**
     * @return view
     */
    public function getPagesLayout()
    {
        $layouts = ContentLayouts::all();
        return view("settings::backend_theme.pages_layout", compact(['layouts']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMakeActive(Request $request)
    {
        $slug = $request->get('slug');

        if ($theme = BackendTh::find($slug)) {
            $response = $theme->setActive();
            if ($response) return \Response::json(['error' => false]);
        }

        return \Response::json(['error' => true]);
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

    /**
     * @param Request $request
     * @return mixed
     */
    public function postUploadTheme(Request $request)
    {
        $isValid = $this->validateUpl->isCompress($request->file('file'));

        if (!$isValid) return $this->thUpload->ResponseError('Uploaded data is InValid!!!', 500);

        $response = $this->thUpload->upload($request);
        if (!$response['error']) {
            $result = $this->thUpload->validatConfAndMoveToMain($response['folder'], $response['data']);

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
        $view['view'] = "settings::backend_theme.pages_layout_settings";
        return ContentLayouts::find($slug)->renderSettings($view);


    }

    public function getPagesLayoutDelete(Request $request, $slug)
    {
        $layouts = ContentLayouts::find($slug);
        if ($layouts->delete()) return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteTheme(Request $request)
    {
        $slug = $request->get('slug');
        if ($theme = BackendTh::find($slug)) {
            if ($theme->isActive()) {
                BackendTh::setDefault();
            }

            $theme->delete();

            return \Response::json(['error' => false]);
        }
        return \Response::json(['error' => true]);
    }

    public function getSettings($slug, $role)
    {
        $theme = BackendTh::find($slug);
        $roles = Roles::where('slug', $role)->where('slug', '!=', 'user')->first();
        if (!$theme or !$roles) return redirect()->back();
        \Config::set('activeThem', $theme->slug);
        foreach (\Config::get('shortcode.extra') as $key => $value) {
            if (isset($value['class'])) {
                \Config::set("shortcode.extra.$key", ['class' => 'BBclassSettings']);
                \Config::set("extra.role", $role);

            }
            if (isset($value['widget'])) {
                \Config::set("shortcode.extra.$key", ['widget' => 'BBwidgetSettings']);
                \Config::set("extra.role", $role);
            }

        }

        $theme_v_active = $theme;
        return view("settings::backend_theme.settings", compact(['theme', 'slug', 'role', 'theme_v_active']));
    }

    public function postThemeSettings($slug, Request $request)
    {
        $data = $request->except(['_token', 'slug']);
        $theme = BackendTh::where('slug', $slug)->first();
//        dd($theme->generateCss("body {background: green}"));
        $theme->save($data);

        return redirect()->back();
    }

    public function psotStylesOptions(Request $request)
    {
        $id = $request->get('id');
        $key = $request->get('key');
        $styles = Styles::find($id);
        if (!$styles) return \Response::json(['error' => true]);
        $items = $styles->items;
        $ajax = true;
        $html = View::make('settings::_partials.styles', compact(['items', 'key', 'ajax']))->render();
        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function postMenusOptions(Request $request)
    {
        $id = $request->get('id');

        $menus = \Sahakavatar\Backend\Models\Menus\BackendMenus::all();

        $html = View::make('settings::_partials.menus', compact(['menus']))->render();
        return $html;
    }

    public function postWidgetsOptions(Request $request)
    {
        $id = $request->get('id');
        $key = $request->get('key');
        $ajax = true;
        $widget = UiElements::find($id);
        if (!$widget) return \Response::json(['error' => true]);

        $items = $widget->variations();

        $html = View::make('settings::_partials.widgets', compact(['items', 'key', 'widget', 'ajax']))->render();
        return ['html' => $html];
    }

    public function postSettingsLive(Request $request, $slug, $role)
    {
        $actions = [
            'styles' => 'getStyles',
            'widgets' => 'getWidgets',
            'menus' => 'getMenus'
        ];

        $data = $request->all();

        if (isset($actions[$data['action']])) {

            $function = $actions[$data['action']];
            return $this->$function($data, $slug, $role);
        }
    }

    public function getStyles($data, $slug, $role)
    {

        $them = BackendTh::find($slug);
        $settings = $them->settings;
        $key = $data['key'];
        isset($data['type']) ? $type = $data['type'] : $type = 'text';
        $styles = Styles::where('type', $type)->get();
        if (!count($styles)) return \Response::json(['error' => true]);

        if (isset($settings['data'][$role])) {
            $rol_settings = $settings['data'][$role];
            if (isset($rol_settings[$key])) {
                $item_id = $rol_settings[$key];
                $item = StyleItems::find($item_id);
                if ($item) {
                    $classe = $item->classe;
                    $classe_id = $classe->id;
                    $items = $classe->items;
                    $html = View::make('settings::_partials.styles', compact('styles', 'items', 'item_id', 'classe_id', 'key'))->render();
                    return \Response::json(['error' => false, 'html' => $html]);
                }

            }
        }

        $styles = Styles::where('type', 'text')->get();
        $items = (count($styles)) ? $styles[0]->items : [];
        $html = View::make('settings::_partials.styles', compact('styles', 'items', 'key'))->render();
        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function getMenus($data, $slug, $role)
    {

        $them = BackendTh::find($slug);
        $settings = $them->settings;
        $key = $data['key'];
        $item_id = null;
        if (isset($settings['data'][$role])) {
            $rol_settings = $settings['data'][$role];
            if (isset($rol_settings[$key])) {
                $item_id = $rol_settings[$key];
            }
        }

        $menus = Menu::all();
        $html = View::make('settings::_partials.menus', compact(['menus', 'key', 'item_id']))->render();

        return \Response::json(['error' => false, 'html' => $html]);
    }

    public function getWidgets($data, $slug, $role)
    {

        $them = BackendTh::find($slug);
        $settings = $them->settings;
        $key = $data['key'];
        $variation = null;
        $widget = null;
        $items = array();
        $widgets = UiElements::getAllWidgets()->where('section', 'backend')->run();

        if (isset($settings['data'][$role])) {
            $rol_settings = $settings['data'][$role];
            if (isset($rol_settings[$key])) {
                $item_id = $rol_settings[$key];
                $data = explode('.', $item_id);
                $widget = UiElements::find($data[0]);
            }
        }

        if ($widget) {
            $variation = UiElements::findVariation($item_id);
            $items = $widget->variations();
        } else {
            if (count($widgets)) {
                $items = $widgets[0]->variations();
            }
        }

        $html = View::make('settings::_partials.widgets', compact(['widgets', 'items', 'key', 'variation', 'widget']))->render();
        return \Response::json(['error' => false, 'html' => $html]);

    }

    public function postLiveSave(Request $request)
    {
        $data = $request->except(['slug', 'role', '_token']);
        $slug = $request->get('slug');
        $role = $request->get('role');
        $theme = BackendTh::find($slug);
        if ($theme) {
            $settings = $theme->settings;
            foreach ($data as $k => $v) {
                $newData = $settings['data'][$role];
                $newData[$k] = $v;
                $theme->save($newData);

                if ($request->ajax()) return \Response::json(['error' => false]);
                return redirect()->back();
            }
        }

        if ($request->ajax()) return \Response::json(['error' => true, 'message' => 'undefined theme']);

        return redirect()->back()->with(['flash' => ['message' => 'undefined theme']]);
    }

    public function postEditCheckboxes(Request $request)
    {
        $data = $request->get('data');
        $slug = $request->get('slug');
        $role = $request->get('role');
        $edit = array();
        $theme = BackendTh::find($slug);
        if ($theme) {
            $settings = $theme->settings;
            if (isset($settings['data'][$role])) {
                $roleData = $settings['data'][$role];
                foreach ($roleData as $key => $value) {
                    if (in_array($key, $data)) {
                        $edit[$key] = $value;
                    }
                }
            }
        }

        return \Response::json(['edit' => $edit]);
    }

    protected function settingser($slug, $role)
    {
        $theme = BackendTh::find($slug);
        $roles = Roles::where('slug', $role)->where('slug', '!=', 'user')->first();
        if (!$theme or !$roles) return redirect()->back();
        \Config::set('activeThem', $theme->slug);
        return View::make("settings::backend_theme.settings", compact(['theme', 'slug', 'role']))->render();
    }

    protected function editTheme($data, $them, $role)
    {
        $settinds = $them->settings['data'][$role];
        $edit = array();
        foreach ($data['data'] as $key) {
            if (isset($settinds[$key['key']])) {
                $item = StyleItems::find($settinds[$key['key']]);
                if ($item) {
                    $edit[$key['value']]['par'] = $item->classe->id;
                    $edit[$key['value']]['ch'] = $settinds[$key['key']];
                }

            }
        }
        return \Response::json(['edit' => $edit]);
    }
}
