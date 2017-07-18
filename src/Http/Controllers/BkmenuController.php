<?php

namespace Sahakavatar\Settings\Http\Controllers;

use App\Repositories\MenuRepository as Menus;
use App\Http\Controllers\Controller;
use App\helpers\helpers;
use Illuminate\Http\Request;
use Sahakavatar\Users\Models\Roles;
use File,Auth;

class BkmenuController extends Controller {

    private $menus = null;
    private $short_code = ['lnav' => 'Left Navbar', 'umenu' => 'User Menu', 'lheader' => 'Left Header', 'rheader' => 'Right Header'];
    private $id_map = ['lnav' => '1', 'umenu' => '2', 'lheader' => '3', 'rheader' => '4'];
    private $index_page = '';
    private $helper = null;

    /**
     * 
     * @param Menus $menus
     */
    public function __construct(Menus $menus) {
        $this->menus = $menus;
        $this->index_page = url('admin/settings/backmenu');
        $this->helper = new helpers;
    }

    /**
     * 
     * @return type
     */
    public function getIndex() {
        $menues = $this->menus->findAllBy('section', 'admin');
        return view('settings::backend.menu.index', compact(['menues']));
    }

    public function getShow($id) {
        $menu = $this->menus->find($id);
        $filename = config('paths.ADMIN_MENU') . $id . '.json';
        try {
            $menu->raw_data = File::get($filename);
        } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
            dd($filename . " Invalid Menu");
        }
        return view('settings::backend.menu.show', compact(['menu']));
    }

    public function getCreate() {
        $links = $this->links();
        $roles = Roles::lists('name', 'id');
        return view('settings::backend.menu.create', compact(['roles', 'links']));
    }

    public function postCreate(Request $request) {
        $req = $request->all();

        $data = [
            'title'  =>$req['title'],
            'section' => 'admin',
            'user_role' => $req['user_role'],
            'type' => $req['menuType'],
            'short_code' => $this->short_code[$req['menuType']]
        ];
        $memu = $this->menus->create($data);
        $filename = config('paths.ADMIN_MENU') . $memu->id . '.json';
        File::put($filename, $req['raw_data']);
        $this->helper->updatesession('Menu Created Successfully');
        return redirect($this->index_page);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getUpdate($id) {
        $menu = $this->menus->find($id);
        $links = $this->links();
        $raw_data = $this->filedata($id);
        $roles = Roles::lists('name', 'id');
        return view('settings::backend.menu.edit', compact(['menu', 'links', 'raw_data', 'roles']));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function postUpdate(Request $request) {
        $req = $request->all();
        $id = $req['id'];
        $data = [
            'title'  =>$req['title'],
            'user_role' => $req['user_role'],
            'type' => $req['menuType'],
            'short_code' => $this->short_code[$req['menuType']]
        ];
        
        $this->menus->updateRich($data,$id);
        $filename = config('paths.ADMIN_MENU') . $id . '.json';
        File::put($filename, $req['raw_data']);
        $this->helper->updatesession('Menu Updated Successfully');
        return redirect($this->index_page);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getDelete($id) {
        $filename = config('paths.ADMIN_MENU') . $id . '.json';
        if (File::exists($filename)) {
            File::delete($filename);
        }
        $this->menus->delete($id);
        $this->helper->updatesession('Menu Deleted Successfully');
        return redirect($this->index_page);
    }
    
    /**
     * 
     * @param type $section
     * @return type
     */
    public function getFiledata($section){
        $id = $this->id_map[$section];
        return $this->filedata($id); 
    }
    
    /**
     * 
     * @param type $id
     * @return string
     */
    public function filedata($id) {
        $filename = config('paths.ADMIN_MENU') . $id . '.json';
        if (File::exists($filename)) {
            return File::get($filename);
        } else {
            return '';
        }
    }

    /**
     * 
     * @return string
     */
    public function links() {
        $links = [];
        $links_loop = [
            '1' => 'left_navbar',
            '2' => 'user_menu',
            '3' => 'header_left',
            '4' => 'header_right',
        ];
        foreach ($links_loop as $key => $val) {
            $srt = "";
            $filename = config('paths.ADMIN_MENU') . $key . '.json';
            try {
                $data = File::get($filename);
                $data = json_decode($data, true);
                foreach ($data as $menu) {
                    $srt .= '<option value="' . $menu['id'] . '" link="' . $menu['link'] . '" icon="' . $menu['icon'] . '">' . $menu['title'] . '</option>';
                    if (array_key_exists('children', $menu)) {
                        foreach ($menu['children'] as $cmenu) {
                            $srt .= '<option value="' . $cmenu['id'] . '" link="' . $cmenu['link'] . '" icon="' . $cmenu['icon'] . '">&nbsp;&nbsp;&nbsp;' . $cmenu['title'] . '</option>';
                        }
                    }
                }
                $links[$val] = $srt;
            } catch (Illuminate\Filesystem\FileNotFoundException $exception) {
                dd($filename . " Invalid Menu");
            }
        }
        return $links;
    }

}
