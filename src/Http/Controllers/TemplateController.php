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
use App\Models\Setting;
use App\Models\Taxonomy;
use Assets;
use Datatables;
use File;
use Illuminate\Http\Request;
use Input;
use Sahakavatar\Cms\Helpers\helpers;
use Sahakavatar\Cms\Helpers\helpers;
use Sahakavatar\Cms\Models\Templates as Tpl;
use Sahakavatar\Cms\Models\TplVariations;
use Sahakavatar\Cms\Models\UiElements;
use Sahakavatar\Create\Models\Corepage;
use Sahakavatar\Settings\Models\Template;
use Sahakavatar\Settings\Models\TemplateVariations;
use Sahakavatar\Settings\Models\TplUpload;
use Session;
use Validator;
use View;
use Zipper;

//use Sahakavatar\Assets\Models\Validation as validateUpl;

/**
 * Class TemplateController
 *
 * @package Sahakavatar\Packeges\Http\Controllers
 */
class TemplateController extends Controller
{

    /**
     * @var helpers|null
     */
    private $helpers = null;
    /**
     * @var null|string
     */
    private $rootpath = null;
    /**
     * @var null|string
     */
    private $index_path = null;
    /**
     * @var Templates|null
     */
    private $templates = null;
    /**
     * @var packegehelper|null
     */
    private $phelper = null;
    /**
     * @var mixed|string
     */
    private $tmp_upload = '';
    /**
     * @var dbhelper|string
     */
    private $dhelper = "";
    /**
     * @var
     */
    private $upload;
    /**
     * @var
     */
    private $validateUpl;
    /**
     * @var mixed
     */
    private $up;
    /**
     * @var mixed
     */
    private $tp;

    private $types;

    /**
     * TemplateController constructor.
     * @param Templates $templates
     * @param TplUpload $tplUpload
     * @param validateUpl $validateUpl
     */
    public function __construct(TplUpload $tplUpload)
    {
        $this->helpers = new helpers;
        $this->rootpath = templatesPath();
        $this->index_path = "/admin/templates/";
        $this->tmp_upload = config('paths.tmp_upload');
        $this->dhelper = new dbhelper;
        $this->upload = new $tplUpload;
        $this->up = config('paths.tmp_upl_packages');
        $this->tp = config('paths.template_path');
        $this->types = @json_decode(File::get(config('paths.template_path') . 'configTypes.json'), 1)['types'];
    }

    /**
     * @return View
     */
    public function getIndex()
    {
        $types = $this->types;
        $templates = Tpl::where('general_type', 'header')->run();
        return view('settings::frontend.templates.templates', compact(['templates', 'types']));
    }

    public function gatFrontThemes()
    {
        $types = [
            [
                "type" => "core",
                "title" => "Front layouts",
                "foldername" => "frontlayouts"]
        ];
        $templates = Tpl::where('type', 'frontlayouts')->run();
        $front_layout = true;
        return view('settings::frontend.templates.templates', compact(['templates', 'types', 'front_layout']));
    }

    public function activateFrontTheme($slug)
    {
        $tpl = \App\Models\Setting::where('section', 'setting_system')->where('settingkey', 'layout')->first();
        $tpl->val = $slug;
        $tpl->save();
        return redirect()->back();
    }

    public function postNewType(Request $request)
    {
        $title = $request->get('title');
        $foldername = str_replace(' ', '', strtolower($title));
        $type = "body";
        $general = array_where($this->types, function ($value, $key) use ($type) {
            return ($value['foldername'] == $type);
        });
        $key = key($general);
        if (isset($general[$key]['subs'])) {
            $result = array_search($foldername, array_column($general[$key]['subs'], 'foldername'));
            if ($result === false) {
                $this->types[$key]['subs'][] = [
                    'title' => $title,
                    'foldername' => $foldername,
                    'type' => 'custom',
                ];
            } else {
                return redirect()->back()->with('message', 'Please enter new Type Title, "' . $title . '" type aleardy exist type!!!');
            }
        } else {
            $this->types[$key]['subs'][] = [
                'title' => $title,
                'foldername' => $foldername,
                'type' => 'custom',
            ];
        }

        $this->types[$key]['subs'] = array_values($this->types[$key]['subs']);
        File::put(config('paths.template_path') . 'configTypes.json', json_encode(['types' => $this->types], 1));
        File::makeDirectory($this->tp . $type . '/' . $foldername);
        File::put($this->tp . $type . '/' . $foldername . '/.gitignor', '');

        return redirect()->back()->with('message', 'New Type successfully created');

    }

    public function postDeleteType(Request $request)
    {
        $foldername = $request->get('folder');
        $type = "body";
        $general = array_where($this->types, function ($value, $key) use ($type) {
            return ($value['foldername'] == $type);
        });
        $key = key($general);

        if (isset($general[$key]['subs'])) {
            $result = array_search($foldername, array_column($general[$key]['subs'], 'foldername'));
            if ($result !== false) {
                $types = $general[$key]['subs'];
                unset($types[$result]);
                $general[$key]['subs'] = array_values($types);
                $this->types[$key] = $general[$key];
                File::put(config('paths.template_path') . 'configTypes.json', json_encode(['types' => $this->types], 1));
                if (File::isDirectory($this->tp . $type . '/' . $foldername)) {
                    File::deleteDirectory($this->tp . $type . '/' . $foldername);
                }

                return \Response::json(['error' => false]);
            }
        }


        return \Response::json(['message' => 'Please try again', 'error' => true]);
    }

    /**
     *
     */
    public function getTestWidget()
    {
        $templates = UiElements::getAllWidgets()->where('type', 'dashboard')->run();
        dd($templates);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesWithType(Request $request)
    {
        $main_type = $request->get('main_type');
        $general_type = $request->get('type', null);

        if ($general_type) {
            $templates = Tpl::where('general_type', $general_type)->where('type', $main_type)->run();
        } else {
            $templates = Tpl::where('general_type', $main_type)->run();
        }

        if ($general_type or $main_type == 'body') {
            $html = View::make('settings::frontend.templates._partrials.tpl_list_cube', compact(['templates']))->render();
        } else {
            $html = View::make('settings::frontend.templates._partrials.tpl_list', compact(['templates']))->render();
        }


        return \Response::json(['html' => $html, 'error' => false]);
    }

    public function postTemplatesInModal(Request $request)
    {
        $main_type = $request->get('main_type');
        $general_type = $request->get('type', null);

        if ($general_type) {
            $templates = Tpl::where('general_type', $general_type)->where('type', $main_type)->run();
        } else {
            $templates = Tpl::where('general_type', $main_type)->run();
        }
        $html = View::make('settings::frontend.templates._partrials.tpl_modal_list', compact(['templates']))->render();


        return \Response::json(['html' => $html, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesListByType(Request $request)
    {
        $main_type = $request->get('main_type');
        $general_type = $request->get('type', null);

        if ($general_type) {
            $templates = Tpl::where('general_type', $general_type)->where('type', $main_type)->run();
        } else {
            $templates = Tpl::where('general_type', $main_type)->run();
        }

        return \Response::json(['list' => $templates, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTemplatesVariations(Request $request)
    {
        $slug = $request->get('slug');
        $template = Tpl::find($slug);
        if (!$template) return \Response::json(['error' => true]);
        $variations = $template->variations();
        $html = View::make('settings::frontend.templates._partrials.variation_select')->with(['variations' => $variations])->render();

        return \Response::json(['list' => $html, 'selector' => $slug, 'error' => false]);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getTemplateRender($slug)
    {
        return Tpl::find($slug)->render();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getTemplateVRender($slug)
    {
        return Tpl::findVariation($slug)->renderVariation();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postUploadTemplate(Request $request)
    {
        $type = $request->get('type');
        $isValid = $this->validateUpl->isCompress($request->file('file'));

        if (!$isValid) return $this->upload->ResponseError('Uploaded data is InValid!!!', 500);
        $response = $this->upload->upload($request);
        if (!$response['error']) {
            $result = $this->upload->validatConfAndMoveToMain($response['folder'], $response['data'], $type);
            if (!$result['error']) {
                File::deleteDirectory($this->up, true);
                $this->upload->makeVariations($result['data']);
                $this->upload->makeWidgets($result['data']);
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDelete(Request $request)
    {
        $slug = $request->get('slug');
        $tpl = Tpl::find($slug)->delete();
        return \Response::json(['message' => 'Please try again', 'error' => !$tpl]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function getTplVariations($slug)
    {
        $template = Tpl::find($slug);
        if (!count($template)) return redirect()->back();
        $variation = [];
        $variations = $template->variations();

        //conditon if type is section
        if ($template->type == 'single_section' || $template->type == 'all_section') {
            $sections = Sections::lists('blog_slug', 'id')->all();
        }

        if ($template->type == 'taxonomies' || $template->type == 'terms') {
            $taxonomies = Taxonomy::all();
        }


        return view(
            'settings::frontend.templates.variations',
            compact(['template', 'variations', 'title', 'sections', 'variation', 'taxonomies'])
        );
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTplVariations(Request $request, $slug)
    {
        $template = Tpl::find($slug);
        if (!$template) return redirect()->back();
        $template->makeVariation($request->except('_token', 'template_slug'))->save();

        return redirect()->back();
    }


    public function TemplatePerview($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (!$variation) return redirect()->back();
        $ifrem = array();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $ifrem['body'] = url('/admin/templates/settings-edit-theme', $id);
        return view('resources::preview', compact(['ui', 'id', 'ifrem', 'settings']));
    }

    public function TemplateLayoutPerview($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (!$variation) return redirect()->back();
        $ifrem = array();
        $htmlSettings = "No Settings!!!";
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $htmlBody = $ui->render(['settings' => $settings]);
        if ($ui->have_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }
        $layout = $id;
        return view('settings::frontend.page_layouts.edit_page_layout', compact(['htmlBody', 'htmlSettings', 'layout']));
    }

    public function TemplateIframeLayout($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (!$variation) echo "worrning";
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $htmlBody = $ui->render(['settings' => $settings]);
        echo $htmlBody;
        die;
    }

    public function frontLayoutSettings($id, Request $request)
    {

        $data = $this->getDataTpl($id);
        if (!$data) return "warning";
        $variation = $data['tpl'];
        $variation->render(['settings' => $request->all()]);
        return \Response::json(['error' => false]);
    }

    protected function getDataTpl($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (!$variation) return false;
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        return ['tpl' => $ui, 'variation' => $variation, 'settings' => $settings];
    }

    public function TemplatePerviewIframe($id, $page_id = null, $edit = false)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (!$variation) return redirect()->back();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $page = Corepage::find($page_id);
        if ($page) {
            $page_data = @json_decode($page->data_option, true);
            $htmlBody = $ui->render(['settings' => $page_data]);
        } else {
            $htmlBody = $ui->render(['settings' => $settings]);
        }
        $htmlSettings = "No Settings!!!";
        if ($ui->has_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }
        $settings_json = json_encode($settings, true);
        return view('settings::frontend.templates.ifpreview', compact(['htmlBody', 'htmlSettings', 'settings', 'settings_json', 'id', 'ui', 'edit']));
    }

    public function TemplatePerviewEditIframe($id)
    {
        $slug = explode('.', $id);
        $ui = Tpl::find($slug[0]);
        $variation = Tpl::findVariation($id);
        if (!$variation) return redirect()->back();
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $settings_json = json_encode($settings, true);
        $htmlSettings = "No Settings!!!";

        if ($ui->have_setting) {
            $htmlSettings = $ui->renderSettings(compact(['settings']));
        }
        $htmlBody = $ui->render(['settings' => $settings]);
        $settings_json = json_encode($settings, true);
        return view('settings::frontend.templates.if_edit_preview', compact(['htmlBody', 'htmlSettings', 'settings_json', 'id', 'settings']));
    }

    public function postSettings(Request $request, $id, $save = false)
    {
        $data = $request->except(['_token']);
        $variation = Templates::findVariation($id);

        if (!empty($data) && $variation) {

            $variation->setAttributes('settings', $data);
            if ($save) {
                $variation->save();
            }
        }
        $settings = (isset($variation->settings) && $variation->settings) ? $variation->settings : [];
        $slug = explode('.', $id);
        $ui = Templates::find($slug[0]);
        $html = $ui->render(['settings' => $settings, 'edit' => true]);
        return \Response::json(['html' => $html, 'error' => false]);
    }

    /**
     * @param Request $request
     * @return array|null
     */
    public function getClassVariations(Request $request)
    {
        $req = $request->all();
        if (isset($req['classID'])) {
            return BBGetClassVariations($req['classID']);
        }

        return null;
    }




    // Get Menu Data

    /**
     * @param Request $request
     * @return null
     */
    public function getWidgetsVariations(Request $request)
    {
        $req = $request->all();
        if (isset($req['widget_id'])) {
            return BBGetWidgetsVariations($req['widget_id']);
        }

        return null;
    }

    // Variations

    /**
     * @param Request $request
     * @return array|null
     */
    public function getMenuData(Request $request)
    {
        $req = $request->all();
        if (isset($req['menuID'])) {
            $data = BBGetMenu($req['menuID'], ['wrapper' => false]);

            return $data;
        }

        return null;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postGetVariations(Request $request)
    {
        $id = $request->get('id');
        $variation = Tpl::findVariation($id);
        $slug = explode('.', $id);
        $html = View::make('settings::frontend.templates._partrials.edit_variation', compact(['variation', 'slug']))->render();

        return \Response::json(['html' => $html]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditVariation(Request $request)
    {
        $variation = Tpl::findVariation($request->get('id'));
        $variation->title = $request->get('title');
        $variation->save();
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postVariations(Request $request)
    {
        $data = $request->all();

        $variation = new TemplateVariations;
        if (isset($data['variation_id'])) {
            $variation = TemplateVariations::find($data['variation_id']);
            if (isset($variation->section) and is_array($variation->section)) {
                $variation_section = $variation->section[0]->id;
            }
        }

        $variation->template_id = $data['template_id'];
        $variation->variation_name = $data['variation_name'];
//        $template = Template::find($data['template_id']);
        // Make a variation active for its section
        if (isset($data['make_active'])) {
            // Deactivate others
            $section = Sections::find($data['section']);
            $section_variations = $section->variations->toArray();

            TemplateVariations::whereIn('id', array_column($section_variations, 'id'))->update(['status' => 0]);


            $variation->status = 1;
        }

        $variation->save();

        if (isset($data['section'])) {
            if (!empty($data['section'])) {
                if (isset($data['variation_id'])) {
                    $variation->section()->detach($variation_section);
                }
                $variation->section()->attach($data['section']);
            } else {
                return redirect()->back();
            }
        }

        if (isset($data['variation_id'])) {
            return redirect($this->index_path . 'variations/' . $data['template_id']);
        }

        return redirect()->back();
    }

    // Activate variation

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteVariation($id)
    {
        $variation = Tpl::deleteVariation($id);

        return redirect()->back();
    }

    /**
     * @param $variation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getActivate($variation)
    {
        $variation = TemplateVariations::find($variation);
        $variation->status = 1;

        // Detect type
        $template = Template::find($variation->template_id);
        if ($template->type == 'header' or $template->type == 'footer') {
            $other_variations = $template->variations->toArray();
        } else {
            $section = Sections::find($variation->section[0]->id);
            $other_variations = $section->variations->toArray();
        }

        // Deactivate others
        TemplateVariations::whereIn('id', array_column($other_variations, 'id'))->where(
            'template_id',
            $variation->template_id
        )->update(['status' => 0]);


        $variation->save();

        return redirect()->back();
    }

    /**
     * @param $variation_id
     * @param $template_id
     * @return View
     */
    public function getCustomiser($variation_id, $template_id)
    {
        $template = $this->helpers->getTemplateData($template_id);

        // Customise path
        $customiser = [];
        $customiser_path = 'appdata/resources/custom_templates/' . $template->folder_name . '/customiser.php';
        if (file_exists($customiser_path)) {
            $customiser = (include $customiser_path);
        }

        $settings = [];
        // Get template settings
        $templateSettings = TemplateVariations::find($variation_id);
        if ($templateSettings->settings !== null) {
            $settings = unserialize($templateSettings->settings);
        }

        $serializedSettings = json_encode($settings);

        return view(
            'resources::templates.customise',
            compact('template_id', 'template', 'variation_id', 'settings', 'customiser', 'serializedSettings')
        );
    }

    /**
     * @param $variation_id
     * @return View
     */
    public function getTemplateSettings($variation_id)
    {
        $template_id = explode('.', $variation_id);
        $template_id = $template_id[0];

        return view(
            'settings::frontend.templates.template_settings',
            compact(['variation_id'])
        );
    }

    /**
     * @param $template_id
     * @param $variation_id
     * @return View
     */
    public function getPreviewTemplate($template_id, $variation_id)
    {
        $file = $this->helpers->tplCreate($template_id, '', 'admin_preview');
        $template = $this->helpers->getTemplateData($template_id);

        // Customiser path
        $customiser = [];
        $customiser_path = 'appdata/resources/custom_templates/' . $template->folder_name . '/customiser.php';
        if ($variation_id == 'mapping') {
            $customiser_path = 'appdata/resources/custom_templates/' . $template->folder_name . '/mapping.php';
        }
        if (file_exists($customiser_path)) {
            $customiser = (include $customiser_path);
        }

        $settings = [];
        // Get template settings
        if ($variation_id == 'mapping') {
            // Get template settings
            if ($template->setting_contents !== null) {
                $settings = unserialize($template->setting_contents);
                // Check if settings has post_id and get this post
                if (isset($settings['post_id'])) {
                    $post = BBGetPost($settings['post_id']);
                }
            }
        } else {
            $templateSettings = TemplateVariations::find($variation_id);
            if ($templateSettings->settings !== null) {
                $settings = unserialize($templateSettings->settings);
            }
        }


        // Get variation CSS
        $injectedCSS = '<style>';
        foreach ($customiser as $tab) {
            if (isset($tab['groups'])) {
                foreach ($tab['groups'] as $group) {
                    if (issetReturn($group, 'type')) {
                        $injectedCSS .= $tab['selector'] . '{';
                        foreach ($group['fields'] as $field) {
                            $injectedCSS .= $field['css'] . ':';
                            $injectedCSS .= isset($settings[$field['name']]) ? $settings[$field['name']] . ";" : '';
                        }
                        $injectedCSS .= '}';
                    }
                }
            }
        }
        $injectedCSS .= '</style>';

        return view($file, compact('injectedCSS', 'settings'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function getSetting($id)
    {
        $template = Template::find($id);
        if ($template) {
            $path = $template->folder_name . "/setting";

            $file = $this->phelper->getFileData($this->rootpath . '/' . $template->folder_name . "/tpl.blade.php");
            $have_setting = $template->have_setting;
            $setting_contents = $template->setting_contents;
            if ($setting_contents != '') {
                $setting_contents = unserialize($setting_contents);
            }

            return view(
                'settings::frontend.templates.setting',
                compact(['template', 'path', 'setting_contents', 'have_setting', 'file'])
            );
        }

        return redirect($this->index_path);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSetting(Request $request)
    {
        $this->helpers->clearTplCache();
        $all_req = $request->all();
        $id = $all_req['id'];
        $template = Template::find($id);

        $template_img_path = $this->rootpath . '/' . $template->folder_name . "/images/";

        $data = $request->except(['_token', 'id', 'image']);

        if ($template->have_setting == 1) {
            //Preserve old images
            $image_field_name = @$all_req['image'];
            $settings_contents = unserialize($template->setting_contents);
            foreach ($image_field_name as $key => $val) {
                $data[$key] = (is_array($settings_contents) && array_key_exists(
                        $key,
                        $settings_contents
                    )) ? $settings_contents[$key] : "";
            }
            //image Manupulation
            if ($request->hasFile('image')) {
                $files = Input::file('image');
                foreach ($files as $key => $file) {
                    $imageName = $key . '.' . $file->getClientOriginalExtension();
                    $file->move($template_img_path, $imageName);
                    $data[$key] = $template_img_path . $imageName;
                }
            }
            $template->setting_contents = serialize($data);
            $template->save();
        }

        $data = $all_req['content'];
        $this->phelper->putFileData($this->rootpath . '/' . $template->folder_name . "/tpl.blade.php", $data);

        return redirect($this->index_path);
    }

    /**
     * @param Request $request
     */
    public function postUpload(Request $request)
    {
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        ini_set('max_input_time', 30000);
        ini_set('max_execution_time', 30000);

        if ($request->hasFile('file')) {

            $destinationPath = $this->rootpath; // upload path
            $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
            if ($extension != 'zip') {
                Session::flash('message', 'Invalid File Type!');
                Session::flash('alert-class', 'alert-danger');
            } else {
                $name = Input::file('file')->getClientOriginalName();
                $tpl_name = str_replace(".zip", "", $name);
                File::deleteDirectory($this->rootpath . "/" . $tpl_name);
                Input::file('file')->move($destinationPath, $name); // uploading file to given path
                File::makeDirectory($destinationPath . "/" . $tpl_name, 0755, true);
                Zipper::make($destinationPath . "/" . $name)->extractTo($destinationPath . "/" . $tpl_name);

                if (!File::exists($destinationPath . "/" . $tpl_name . "/conf.json")) {
                    File::copyDirectory(
                        $destinationPath . "/" . $tpl_name . "/" . $tpl_name,
                        $destinationPath . "/" . $tpl_name
                    );
                    File::deleteDirectory($destinationPath . "/" . $tpl_name . "/" . $tpl_name);
                }
                $conf_arr = file_get_contents($destinationPath . "/" . $tpl_name . "/conf.json");
                $conf_arr = json_decode($conf_arr, true);

                File::delete($destinationPath . "/" . $tpl_name . "/conf.json");

                $obj = Template::where('slug', $conf_arr['slug'])->first();
                if (!$obj) {
                    $obj = new Template;
                }
                $obj->title = $conf_arr['title'];
                $obj->folder_name = $tpl_name;

                $obj->description = $conf_arr['description'];
                $obj->slug = $conf_arr['slug'];
                $obj->have_setting = $conf_arr['have_setting'];

                $obj->type = $conf_arr['type'];
                $obj->version = $conf_arr['version'];
                $obj->author = $conf_arr['author'];
                $obj->site = $conf_arr['site'];

                $obj->save();

                $variation = new TemplateVariations;
                $variation->template_id = $obj->id;
                if (isset($obj->title)) {
                    $variation->variation_name = $obj->title . " Default Variation";
                }
                $variation->save();

                if (isset($conf_arr['required_widgets']) && $conf_arr['required_widgets'] == 1) {
                    $this->phelper->registerWidgets($destinationPath . "/" . $tpl_name, $obj->folder_name, $obj->id);
                }

                if (isset($conf_arr['required_forms']) && $conf_arr['required_forms'] == 1) {
                    $this->phelper->registerForms($destinationPath . "/" . $tpl_name, $obj->folder_name);
                }


                if (isset($conf_arr['require_menu']) && $conf_arr['require_menu'] == 1) {
                    $this->phelper->registerMenu($destinationPath . "/" . $tpl_name, $obj->folder_name);
                }


                File::delete($destinationPath . "/" . $name);
            }
        } else {
            $this->helpers->updatesession('Upload Not Successfull!', 'alert-danger');
        }
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getTemplate()
    {
        $id = Input::get('tpl_id');
        if ($id) {
            $template = Template::find($id);
            $path = templatesPath($template->folder_name . "/tpl.blade.php");
            $data = '';
            if (\File::exists($path)) {
                $data = \File::get($path);
            }
        }

        return response()->json(['data' => $data]);
    }

    /**
     * @param $id
     * @return View
     */
    public function getDelete($id)
    {
        $tpl = Template::find($id);
        $folder = $tpl->folder_name;

        /* File::deleteDirectory($this->rootpath . "/" . $folder);
         $tpl->delete();
         $this->helpers->updatesession('Deleted Successfully!', 'alert-success');
         return redirect($this->index_path);*/

        return view('settings::frontend.templates.delete', compact(['tpl']));
    }

    /**
     * @param Request $request
     */
    public function postState(Request $request)
    {
        $req = $request->all();
        $id = $req['id'];
        $tpl = Template::find($id);
        if ($req['status'] == 'true') {
            $this->helpers->tplCreate($id);
        } else {
            $this->helpers->tplDelete($id);
        }
        $tpl->status = $req['status'];
        $tpl->save();
    }

    /**
     *
     */
    public function postEdit()
    {
        $id = Input::get('pk');
        $obj = Template::find($id);
        $obj->title = Input::get('value');
        $obj->save();
    }

    /**
     * @return View
     */
    public function getStart()
    {
        return view('settings::frontend.templates.tplsample');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postStart(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|min:3',
                'author' => 'required|max:25',
                'description' => 'required|max:250|min:25',
                'version' => 'required'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $req = $request->all();
            $folder = $this->phelper->makeTemplate($req);

            return response()->download($this->tmp_upload . $folder . '.zip');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {

        $cols = $this->dhelper->getCustomSelect(7);
        $data = $this->templates->allcustom();

        $obj = Datatables::of($data);

        $obj->addColumn(
            'action',
            '@if($author == "Core")' .
            $this->dhelper->actionBtns(
                [
                    'setting_same' => ['link' => '/admin/templates/setting/{!! $id !!}'],
                    'edit' => ['link' => '/admin/templates/variations/{!! $id !!}'],
                ]
            ) . '@elseif($type!="general")' .
            $this->dhelper->actionBtns(
                [
                    'edit' => ['link' => '/admin/templates/variations/{!! $id !!}'],
                    'setting_same' => ['link' => '/admin/templates/setting/{!! $id !!}'],
                    'delete' => ['link' => '/admin/templates/delete/{!! $id !!}'],
                ]
            ) .
            '@else' .
            $this->dhelper->actionBtns(
                [
                    'edit' => ['link' => '/admin/templates/variations/{!! $id !!}'],
                    'setting_same' => ['link' => '/admin/templates/setting/{!! $id !!}'],
                    'delete' => ['link' => '/admin/templates/delete/{!! $id !!}'],
                ]
            ) .
            '@endif'
        );

        $obj = $obj->make(true);
        $tot_obj = $obj->getData();
        $data = $tot_obj->data;

        return $this->dhelper->addCustomData($tot_obj, $data, array_filter($cols));
    }

    /**
     * @return string
     */
    public function getTplvariationdd()
    {
        $tpl_id = Input::get('tpl_id');
        $tpl = TemplateVariations::where('template_id', $tpl_id)->lists('variation_name', 'id');

        return $this->helpers->ddbyarray($tpl);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|View
     */
    public function getWidgetSettings($id)
    {
        $variation = TemplateVariations::find($id);

        if ($variation) {
            $template = Template::find($variation->template_id);
            if ($template->type != 'widget') return redirect()->back();
        }
        //\View::make($template->folder_name . "/settings")->render(); //templatesPath($template->folder_name . "/settings");
        $settings = @unserialize($variation->settings);
        (isset($settings['widget'])) ? $settings = $settings['widget'] : $settings = [];

        $path = view()->file(templatesPath($template->folder_name . "/setting.blade.php"), ['settings' => $settings]);

        return view('settings::frontend.templates.variation_settings', compact(['settings', 'path', 'template', 'variation']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postWidgetSettings(Request $request)
    {
        $data = $request->except('_token');
        $variation = TemplateVariations::find($data['id']);
        if ($variation) {
            $settings = @unserialize($variation->settings);
            if ($settings) {
                $settings['widget'] = $data;
                $variation->update(['settings' => serialize($settings)]);
            }
        }

        return redirect()->back();
    }

    /**
     * @return View
     */
    public function getNewindex()
    {
        $templates = Tpl::where('general_type', 'header')->run();
        return view('settings::frontend.templates.new_templates', compact(['templates']));
    }
}
