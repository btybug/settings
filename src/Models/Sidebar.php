<?php

namespace Sahakavatar\Settings\Models;

use Sahakavatar\Assets\Models\ClassesVariations;
use Illuminate\Database\Eloquent\Model;
use File;
use App\Models\Menu;

class Sidebar extends Model
{
    //protected $fillable = array('*');
    protected $guarded = ['_token'];


    /**
     * Generate Sidebar and return its Path
     *
     * @param $id
     * @return string
     */
    public static function getSideBarFile($id)
    {
        $file = config('paths.CACHE') . "sidebars/" . $id . ".blade.php";
        if (!File::exists($file)) {
           self::generateSidebar($id);
        }
        $sidebar = self::find($id);
        $data = $sidebar->raw_data;
        $data = json_decode($data, true);
        $css = '<style>';
        foreach($data as $sngl_rec){
            if($sngl_rec['type'] == 'menu'){
                $oid = $sngl_rec['oid'];
                $menu = Menu::find($oid);
                $menu_css = ClassesVariations::find($menu->menu_class);
                if($menu_css){
                    $css .= $menu_css->css_data;
                }
            }
        }
        $css .= '</style>';

        return ['file'=>$file,'css'=>$css];
    }

    public static function updateSideBarFile($id){
        $file = config('paths.CACHE') . "sidebars/" . $id . ".blade.php";
        if (File::exists($file)) {
            File::delete($file);
        }
        self::generateSidebar($id);
    }

    /**
     * Generate Side Bar Cache File
     *
     * @param $id
     */
    public static function generateSidebar($id)
    {

        $side_bar_data = '';
        $file = config('paths.CACHE') . "sidebars/" . $id . ".blade.php";
        File::delete($file);
        $sidebar = self::find($id);
        $raw_data = $sidebar->raw_data;

        $data = json_decode($raw_data, true);

        if(is_array($data)){
            foreach($data as $sngle_item){

                $type = $sngle_item['type'];
                if($type == 'image'){
                    $w = 1000;
                    $h = 1000;
                    if( $sngle_item['size'] !="org") {
                            $size_arr = explode("_", @$sngle_item['size']);
                            if (is_array($size_arr)) {
                                $w = $size_arr[0];
                                $h = $size_arr[1];
                            }
                    }
                    $side_bar_data .= '<div data-edit-mod="' . $sngle_item['id'] . '"><img src="/' . BBMediaThumb($sngle_item['oid'],$w,$h) . '"></div>';
                }
                if($type == 'menu'){
                    $id = $sngle_item['oid'];
                    $contents = '';
                    $menu_file = config('paths.FRONT_MENU') . $id . '.html';
                    if(File::exists($menu_file)){
                        $contents = File::get($menu_file);
                    } else {
                        $contents = '';
                    }
                    $side_bar_data .= '<div data-edit-mod="'.$sngle_item['id'].'">'.$contents.'</div>';

                }
                if($type == 'forms'){
                    $side_bar_data .= '<div data-edit-mod="'.$sngle_item['id'].'">[getCoreForm id='.$sngle_item['oid'].']</div>';
                }
                if($type == 'widgets'){
                    $side_bar_data .= widget(['id'=>$sngle_item['oid']]);
                }
            }

            File::put($file,$side_bar_data);
        }
    }
    public function type(){
        return $this->belongsTo('Sahakavatar\Settings\Models\SidebarTypes','sidebar_type_id');
    }
}
