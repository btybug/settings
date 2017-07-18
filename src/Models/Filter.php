<?php

namespace Sahakavatar\Models\Settings;

use App\Models\Moduledb;
use Illuminate\Database\Eloquent\Model;
use File;

class Filter extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','filter_data','module_id'];



    /**
     * The attributes which using Carbon.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get the user that owns the phone.
     */
    public function module()
    {
        return $this->belongsTo('App\Models\Moduledb', 'module_id');
    }


    public function getModuleFilters()
    {
        $data = [];
        $modules = Moduledb::get();

        $modules_path = config('paths.modules_path');

        foreach($modules as $module) {
            $path = $modules_path . $module->folder_name . "/Filters";
            if (File::exists($path)) {
                $files = File::allFiles($path);
                foreach ($files as $file) {
                    $base = basename((string)$file);
                    $name = str_replace('.json', '', $base);
                    $data[] = ['title'=>$name,'Module'=>$module->folder_name];
                }
            }
        }
        return $data;
    }

}
