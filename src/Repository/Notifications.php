<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/9/2016
 * Time: 11:51 AM
 */

namespace App\Modules\Settings\Repository;

use App\Modules\Settings\Models\NotificationCategory;
use App\Modules\Settings\Models\Notification;
use App\Models\Setting;
use App\helpers\helpers;
use App\helpers\dbhelper;
use Datatables;


/**
 * @property helpers helpers
 */
class Notifications
{
    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->helpers = new helpers;
        $this->dhelp = new dbhelper;
    }

    public function getCats()
    {

        $form_fields = [
            'name' => 'Name',
            'is_active' => 'Is Active',
            'type' => 'Type',
            'receivers' => 'Receivers',
            'updated_at' => 'Update Date',
            'action' => 'Action'
        ];

        $columns = $this->dhelp->getColumnsJson($form_fields);

        return compact(['form_fields', 'columns']);
    }

    public function getCat($id)
    {
        return NotificationCategory::find($id);
    }

    /**
     * @param $id
     */
    public function getCatDetails($id)
    {
        $model = $this->getCat($id);
        $from = [];
        $rs = Setting::where('section', 'admin_emails')->get()->toArray();

        foreach ($rs as $rec) {
            $from[$rec['val']] = helpers::studyString($rec['settingkey']);
        }
        $to = $this->helpers->getEmailReceivers();

        return compact(['model', 'from', 'to']);

    }

    public function saveCat($request){
        $data = $request->except(['_token']);
        NotificationCategory::find($request->id)->update($data);
        $this->helpers->updatesession();
    }


    /**
     * Provide a list of data For Datatable
     */
    public function getCatsDataTable()
    {
        $data = NotificationCategory::get();

        $obj = Datatables::of($data)->addColumn(
            'action',
            function ($class) {
                $collection = [];
                $collection['setting_same'] = ['link' => '/admin/settings/system/notifications/edit-cat/' . $class->id];

                return $this->dhelp->actionBtns($collection);
            }
        );

        $obj->editColumn(
            'updated_at',
            function ($class) {
                return BBgetDateFormat($class->updated_at);
            }
        );

        $obj->editColumn(
            'is_active',
            function ($class) {
                return ($class->is_active) ? 'Yes' : 'No';
            }
        );

        return $obj->make(true);
    }


}