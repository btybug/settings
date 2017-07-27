<?php

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sahakavatar\Settings\Fesetting;
use App\Repositories\TemplatesRepository as Templates;
use Sahakavatar\Settings\AdminListingRepository as AdmnList;
use Sahakavatar\Cms\Helpers\helpers;
use Session,
    URL;

class SettingController extends Controller {

    private $templates = null;
    private $dbhelper = null;
    private $adminlisting = null;

    public function __construct(Templates $templates, dbhelper $dbhelper, AdmnList $adminlisting) {
        $this->templates = $templates;
        $this->dbhelper = $dbhelper;
        $this->adminlisting = $adminlisting;
    }

    public function getIndex() {
        $fesetting = Fesetting::find('1');
        $layouts = $this->getLayout();
        $position = $this->getPosition();
        $classes = $this->getClasses();
        $grids = $this->getGrids();
        $orientations = $this->getOrientation();
        $contents = $this->getContents();
        $templates = $this->templates->getHeaderTemplates();


        return view('settings::setting', compact(['templates', 'fesetting', 'layouts', 'position', 'classes', 'orientations', 'grids', 'contents']));
    }

    public function postSetting(Request $request) {

        $req = $request->all();

        $obj = Fesetting::find('1');
        $obj->update($req);

        if ($request->hasFile('site_logo')) {
            $destinationPath = 'public/uploads'; // upload path
            $extension = Input::file('site_logo')->getClientOriginalExtension(); // getting image extension
            $fileName = 'logo.' . $extension; // renameing image
            Input::file('site_logo')->move($destinationPath, $fileName); // uploading file to given path
        }
        Session::flash('success', 'Updated successfully');
        return redirect('/admin/settings/setting/');
    }

    /**
     * Tthis function provides the facility to set view column namaes facility for given table
     * 
     * @param type $table_name
     * @param type $back_path
     */
    public function getTablesettings($table_name, $bk = '') {
        $bk = ($bk=='')?URL::previous():$bk;
        $avail = [];
        $cols = $this->dbhelper->getTbCols($table_name);
        $rs = $this->adminlisting->findBy('code', $table_name);
        if($rs){
            $values = $rs->values;
            if($values!=''){
                $avail = unserialize($values);
            }
        }
        return view('settings::tblsetting', compact(['cols', 'bk', 'table_name','avail']));
    }

    /**
     * Save Columns those should be available for view
     * 
     * @param Request $request
     * @return type
     */
    public function postTablesettings(Request $request) {
        $req = $request->all();
        $cols = $req['cols'];
        $code = $req['code'];
        $data = ['code' => $code, 'values' => serialize($cols)];
        $rec = $this->adminlisting->findBy('code', $code);
        if ($rec) {
            $this->adminlisting->updateRich($data, $rec->id);
        } else {
            $this->adminlisting->create($data);
        }
        return redirect($req['bk']);
    }

    private function getLayout() {
        return ['full' => 'Full Width', 'rnav' => 'Right Nav'];
    }

    private function getPosition() {
        return ['top_left' => 'Top Left',
            'top_right' => 'Top Right',
            'bottom_left' => 'Bottom Left',
            'bottom_right' => 'Bottom Right',
            'middle' => 'Middle',
        ];
    }

    private function getGrids() {
        return ['1' => 'Grid 1',
            '2' => 'Grid 2',
            '3' => 'Grid 3',
            '4' => 'Grid 4',
            '5' => 'Grid 5',
            '6' => 'Grid 6',
        ];
    }

    private function getContents() {
        return ['template' => 'Template',
            'widgets' => 'Widgets',
            'custom' => 'Custom',
        ];
    }

    private function getClasses() {
        return ['primary' => 'Primary',
            'info' => 'Info',
            'success' => 'Success Left',
            'warning' => 'Warning',
            'danger' => 'Danger',
        ];
    }

    private function getOrientation() {
        return ['ltr' => 'Left To Right',
            'rtl' => 'Right To Left',
        ];
    }

}
