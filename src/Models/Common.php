<?php

namespace Btybug\Settings\Models;

use App\Models\Moduledb;
use File;
use Sahakavatar\Create\Fields;

/**
 * Class Common
 *
 * @package Btybug\Settings\Models
 */
class Common
{
    /**
     * Common constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getEmailDrivers()
    {
        return [
            'smtp' => 'SMTP',
            'mail' => 'Mail'
        ];
    }

    /**
     * @return mixed
     */
    public function getEmailsettings()
    {
        return \Config::get('admin.emailsettings');
    }

    /**
     * @param $form
     * @param $model
     */
    public function formSubmit($form, $model)
    {

        /*$form = $form;
         
        $emails = Emails::where('form_id', $form->id)->get();

        if (count($emails) > 0) {
            foreach ($emails as $email) {
                $this->sendEmail->sendEmail($email,$model);
            }
        }*/
    }


    /**
     * @param $dataobj
     */
    public function updateEmailSettings($dataobj)
    {
        $str = "<?php return [";
        $contents = $dataobj->all();
        $from = $contents['from'];

        unset($contents['_token']);
        unset($contents['from']);

        foreach ($contents as $key => $val) {

            $str .= " '" . $key . "'=>'" . $val . "',";
        }

        $str .= " 'from'=> [ ";
        foreach ($from as $key => $val) {
            $str .= " '" . $key . "'=>'" . $val . "',";
        }
        $str = substr($str, 0, -1);

        $str .= " ] ";

        $str .= "];";

        File::put('config/admin/emailsettings.php', $str);
    }

    /**
     * @param $module_folder
     * @return mixed
     */
    public function getModuleFilters($module_folder)
    {
        $data[''] = 'Select Filter';
        $modules = config('paths.modules_path');
        $path = $modules . $module_folder . "/Filters";

        if (File::exists($path)) {
            $files = File::allFiles($path);
            foreach ($files as $file) {
                $base = basename((string)$file);
                $name = str_replace('.json', '', $base);
                $data[$base] = $name;
            }
        }

        return $data;
    }

    public function updateFilter($request)
    {
        $id = $request->id;
        $data = config('admin.filters');
        $info = $data[$id];
        $info['title'] = $request->title;
        $info['filter_data'] = $request->return_result;
        $data[$id] = $info;
        $this->updateFilterFile($data);
        $data = [
            'id' => str_replace(".json", "", $info['file_name']), //$filter->id,
            'module_name' => $info['module'],
            'info' => $request->filter_json
        ];
        $this->mkJson($data);
    }

    public function updateFilterFile($data)
    {
        $path = 'appdata/config/admin/filters.php';
        $data = var_export($data, 1);
        File::put($path, "<?php\n return $data ;");

    }

    /**
     * Generate Json At Given Path
     *
     * @param $data
     */
    public function mkJson($data)
    {
        $id = $data['id'];
        $module_folder = $data['module_name'];
        $info = $data['info'];
        $modules = config('paths.modules_path') . $module_folder . "/Filters";
        if (!file_exists($modules)) {
            File::makeDirectory($modules, 0777);
        }
        $path = $modules . "/" . $id . ".json";
        File::put($path, $info);
    }

    public function updateFiltersArr($request, $module)
    {
        $new_data = [
            'title' => $request->title,
            'module' => $module->folder_name,
            'created_at' => date("m-d-Y"),
            'filter_data' => $request->return_result,
            'file_name' => str_replace(' ', '_', $request->title) . '.json'
        ];
        $data = config('admin.filters');
        $key = max(array_keys($data));
        $key++;
        $data[$key] = $new_data;
        $this->updateFilterFile($data);
    }

    public function delJson($id)
    {
        $data = File::getRequire('appdata/config/admin/filters.php');
        $info = $data[$id];
        unset($data[$id]);
        $this->updateFilterFile($data);

        $modules = config('paths.modules_path');
        $path = $modules . @$info['module'] . "/Filters/" . @$info['file_name'];
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    /**
     * @param $request
     * @return string
     */
    public function getJson($request)
    {
        $json = '';
        $module = Moduledb::find($request->module);
        $field = Fields::find($request->filter);
        if ($module and $field) {
            $main_type = Fields::getFieldTarget($field);

            $data = [
                "model" => $field->model,
                "main_type" => ($main_type) ? $main_type : '',
                "field_type" => $field->filter_option
            ];

            $json = json_encode($data, true);
        }
        return $json;
    }

}
