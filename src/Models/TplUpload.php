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

namespace Sahakavatar\Settings\Models;

use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\ExceptionCaster;
use App\helpers\helpers;
use App\Models\MenuData;
use App\Models\Templates\Templates as Tpl;
use Zipper,File;

/**
 * Class TplUpload
 * @package Sahakavatar\Packeges\Models
 */
class TplUpload
{
    /**
     *
     */
    const ZIP = ".zip";
    /**
     * @var mixed
     */
    public $uf;
    /**
     * @var
     */
    public $fileNmae;
    /**
     * @var
     */
    public $helper;
    /**
     * @var
     */
    public $generatedName;

    /**
     * @var
     */
    protected $dir;

    /**
     * TplUpload constructor.
     */
    public function __construct()
    {
        $this->helpers = new helpers;
        $this->uf = config('paths.tmp_upl_packages');
    }

    /**
     * @param $data
     * @param $code
     * @param null $links
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function ResponseSuccess($data, $code, $links = null, $id = null)
    {
        return \Response::json(['data' => $data, 'invalid' => false, 'id' => $id, 'links' => $links, 'code' => $code, 'error' => false], $code);
    }

    /**
     * @param $data
     * @param $code
     * @param $messages
     * @return \Illuminate\Http\JsonResponse
     */
    public function ResponseInvalid($data, $code, $messages)
    {
        return \Response::json(['data' => $data, 'invalid' => true, 'messages' => $messages, 'code' => $code, 'error' => false], $code);
    }

    /**
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function ResponseError($message, $code)
    {
        return \Response::json(['message' => $message, 'code' => $code, 'error' => true], $code);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {

        if ($request->hasFile('file')) {

            $extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
            $zip_file = $request->file('file')->getClientOriginalName();
            $this->fileNmae = str_replace(self::ZIP, "", $zip_file);
            $request->file('file')->move($this->uf, $zip_file); // uploading file to given path

            try {
                $this->extract();
            } catch (Exception $e) {
                return ['message' => $e->getMessage(), 'code' => $e->getCode(), 'error' => true];
            }

            return ['folder' => $this->generatedName, 'data' => $this->fileNmae, 'code' => 200, 'error' => false];
        }
    }

    /**
     *
     */
    public function extract()
    {
        $fileName = $this->fileNmae;
        $this->generatedName = $fileName.'_'.uniqid();
        File::makeDirectory($this->uf . $this->generatedName);
        Zipper::make($this->uf . "/" . $fileName . self::ZIP)->extractTo($this->uf . $this->generatedName . '/');
    }

    /**
     * @param $folder
     * @param $name
     * @return array|string
     */
    public function validatConfAndMoveToMain($folder, $name,$type)
    {
        if (File::exists($this->uf . $folder . '/' . 'config.json')) {
            $file = $this->uf . $folder . '/' . 'config.json';
            $response =  $this->validate($file, $folder,$type);
            if($response['error'])
                return $response;

            if(isset($response['data']['main_type'])){
                $this->dir = config('paths.template_path') . $response['data']['main_type'] .'/'. $response['data']['type'] .'/'.$folder;
            }else{
                $this->dir = config('paths.template_path'). $response['data']['type'].'/'.$folder;
            }

            File::copyDirectory($this->uf . $folder, $this->dir);

            return $response;
        } else {
            if (File::exists($this->uf . $folder . '/' . $name . '/' . 'config.json')) {
                $file = $this->uf . $folder . '/' . $name . '/' . 'config.json';
                $response =  $this->validate($file, $folder,$type);
                if($response['error'])
                    return $response;

                if(isset($response['data']['main_type'])){
                    $this->dir = config('paths.template_path'). $response['data']['main_type'] .'/'. $response['data']['type'] .'/'.$folder;
                }else{
                    $this->dir = config('paths.template_path'). $response['data']['type'].'/'.$folder;
                }

                File::copyDirectory($this->uf . $folder. '/' . $name, $this->dir);

                return $response;
            }else{
                return ['error' => 'true', 'message' => 'config.json file is not exists'];
            }
        }

        return $this->uf . $folder . '/' . 'config.json';
    }

    /**
     * @param $file
     * @param $key
     * @return array
     */
    private function validate($file, $key,$type)
    {
        $conf = File::get($file);
        if ($conf) {
            $conf = json_decode($conf, true);
            if (!isset($conf['type']))
                return ['message' => 'Type are required', 'code' => '404', 'error' => true];
            if($conf['type'] != $type)
                return ['message' => 'Please Uplaod in correct Place, Type is not match', 'code' => '404', 'error' => true];

            $conf['slug'] = (string)$key;
            $conf['created_at'] = time('now');
            $json = json_encode($conf, true);
            File::put($file, $json);
            return ['data' => $conf,'code' => '200', 'error' => false];
        }

        return ['message' => 'Json file is empty !!!', 'code' => '404', 'error' => true];
    }

    /**
     * @param $fileName
     */
    public function deleteFolderZip($fileName)
    {
        File::deleteDirectory($this->uf . $fileName);
        File::delete($this->uf . $fileName . self::ZIP);
    }

    /**
     * @param $data
     * @return array
     */
    public function makeVariations($data)
    {
        $variation_path = $this->dir . '/variations';
        if (File::isDirectory($variation_path)) {
            if($files = File::allFiles($variation_path)){
                foreach ($files as $file) {
                    if (File::extension($file) == 'json') {
                        $json = File::get($file);
                        if ($json) {
                            $json = json_decode($json, true);
                            $json['id'] = (string)$data['slug'] . '.' . uniqid();
                            File::put($variation_path . '/' . $json['id'] . '.json', json_encode($json,true));
                            File::delete($file);
                        }
                    }
                }
                return ['code' => '200', 'error' => false];
            }
        }
        File::makeDirectory($variation_path);
        Tpl::find($data['slug'])->makeVariation(['title'=> 'main variation'])->save();
    }

    /**
     * @param $data
     */
    public function makeWidgets($data){
        $widget_path = $this->dir . '/installable/widgets';
        if (File::isDirectory($widget_path)) {
            $widgets = File::directories($widget_path);
            if($widgets){
                foreach ($widgets as $widget) {
                    if(File::exists($widget . '/config.json')){
                        $conf = json_decode(File::get($widget . '/config.json'),true);
                        if($conf){
                            $conf['slug'] = uniqid();
                            $json = json_encode($conf, true);
                            File::put($widget . '/config.json',$json);
                            rename( $widget, $widget_path.'/'.$conf['slug']);
                            $this->dir = $widget_path . '/'. $conf['slug'];
                            $this->makeVariations($conf);
                        }
                    }
                }
            }
        }
    }
}
