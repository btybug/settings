<?php

namespace Sahakavatar\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Setting;
use App\Repositories\EmailGroupsRepository as EmailGroups;
use App\Repositories\EmailsRepository as Emails;
use App\Repositories\TemplatesRepository as Templates;
use Datatables;
use Illuminate\Http\Request;
use Sahakavatar\Cms\Helpers\helpers;
use Sahakavatar\Cms\Helpers\helpers;
use Sahakavatar\Settings\Models\Common;
use Validator;


/**
 * @property Templates templates
 * @property helpers helpers
 */
class EmailController extends Controller
{

    protected $common;
    private $email_groups = null;
    private $emails, $dhelp, $index, $emails_floder = null;

    /**
     * EmailController constructor.
     *
     * @param EmailGroups $email_groups
     * @param Emails $emails
     * @param Templates $templates
     */
    public function __construct(EmailGroups $email_groups, Emails $emails, Templates $templates, Common $common)
    {
        $this->email_groups = $email_groups;
        $this->helpers = new helpers;
        $this->emails = $emails;
        $this->dhelp = new dbhelper;
        $this->templates = $templates;
        $this->emails_floder = config('paths.email_templates');
        $this->index = '/admin/settings/email/';
        $this->common = $common;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCore($id = 0)
    {

        $count = 1;
        $groups_list = $this->email_groups->emailGroups('core');
        if ($id == 0) {
            $id = $this->email_groups->getDefault();
        }
        $id = ($id != 0) ? $id : $count = 0;

        return view('settings::email.core', compact(['groups_list', 'id', 'count']));
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCustom($id = 0)
    {
        $groups_list = $this->email_groups->emailGroups('custom');
        $count = $groups_list->count();
        if ($id == 0) {
            $id = $this->email_groups->getDefault('custom');
        }
        $id = ($id != 0) ? $id : $count = 0;

        return view('settings::email.custom', compact(['groups_list', 'id', 'count']));
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        $data = [];
        $drivers = $this->common->getEmailDrivers();
        $data = $this->common->getEmailsettings();

        return view('settings::email.settings', compact(['data', 'drivers']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings(Request $request)
    {
        $this->common->updateEmailSettings($request);
        $this->helpers->updatesession('Email settings updated successfully!');

        return redirect()->back();
    }


    public function getUpdateemail($id = 0)
    {
        $email = $this->emails->find($id);
        $events = Event::all()->pluck('title', 'code');

        $content_type = $this->helpers->getContentType();
        $templates = [];//$this->templates->emailTEmplatesList();
        //$templates->prepend('Select Template', '');
        $to = $this->helpers->getEmailReceivers();
        $settings = ($email->settings != '') ? unserialize($email->settings) : [];

        $to_hint = str_replace(',', ' ,', $to);
        $variations = [];

        //NEED to update
//        if ($email->template_id > 0) {
//            $variations = TemplateVariations::where('template_id', $email->template_id)->lists('variation_name', 'id');
//        }
        $from = [];
        $rs = Setting::where('section', 'admin_emails')->get()->toArray();

        foreach ($rs as $rec) {
            $from[$rec['val']] = helpers::studyString($rec['settingkey']);
        }

        if ($email) {
            return view(
                'settings::email.update',
                compact(
                    ['email', 'events', 'content_type', 'templates', 'variations', 'to', 'from', 'to_hint', 'settings']
                )
            );
        }
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $data = $request->all();
        $email = $this->emails->find($data['email_id']);

        if ($email) {
            $data = array_except($data, ['_token', 'email_id']);
            //Time Settings
            if (@$data['when_'] == 'immediate') {
                $data['custom_days'] = 0;
                $data['custom_time'] = '';
            }

            if (@$data['custom_days'] > 0) {
                $data['custom_time'] = '';
            }

            $this->emails->updateRich($data, $email->id);

            if (@$data['content_type'] == 'template') {
                $contents = $this->getTemplate($data['template_id']);
            } else {
                $contents = $data['content'];
            }

//            $contents = $this->formatEmailCodes($contents);
            \File::put($this->emails_floder . "/" . $email->id . ".blade.php", $contents);

            $this->helpers->updatesession('Email successfully assigned!', 'alert-success');
        } else {
            $this->helpers->updatesession('Email not Found!', 'alert-danger');
        }

        return redirect($this->index . $email->group->type . "/" . $email->group_id);
    }

    public function getTemplate($tpl_id)
    {
        $tpl = $this->templates->find($tpl_id);
        if ($tpl) {
            $path = config('paths.templates_path') . '/' . $tpl->folder_name . "/tpl.blade.php";
            $data = '';
            if (\File::exists($path)) {
                $data = \File::get($path);
            }

            return $data;
        } else {
            return '';
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteEmail(Request $request)
    {
        $data = $request->all();

        $email = $this->emails->find($data['id']);
        if ($email->public()) {
            $email->delete();
            \File::delete($this->emails_floder . "/" . $email->id . ".blade.php");
            $this->helpers->updatesession('Email successfuly deleted!', 'alert-success');

            return redirect()->back();
        }

        $this->helpers->updatesession('Email not Found!', 'alert-danger');

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addEmail(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $data = array_except($data, ['_token', 'email_id']);
            $data['is_public'] = true;

            $this->emails->create($data);

            $this->helpers->updatesession('Email successfuly created!', 'alert-success');

            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editEmail(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $data['is_public'] = true;
            $email = $this->emails->find($data['email_id']);
            if ($email) {
                $email->update($data);

                $this->helpers->updatesession('Email updated!', 'alert-success');

                return redirect()->back();

            } else {
                $this->helpers->updatesession('Email not Found!', 'alert-danger');

                return redirect()->back();
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function duplicateEmail(Request $request)
    {
        $data = $request->all();

        $duplicate = $this->emails->find($data['id']);

        if ($duplicate) {

            $duplicate = array_except($duplicate->toArray(), ['id', 'created_at', 'updated_at']);

            $duplicate['is_public'] = true;

            $this->emails->create($duplicate);

            $this->helpers->updatesession('Email duplicated!', 'alert-success');

            return redirect()->back();
        }

        $this->helpers->updatesession('Email not Found!', 'alert-danger');

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postAddgroup(Request $request)
    {
        $req = $request->all();
        $name = $req['group'];
        $slug = str_slug($name, '-');
        $grp = $this->email_groups->create(['name' => $name, 'slug' => $slug]);

        return $grp;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postEditgroup(Request $request)
    {
        $req = $request->all();
        $id = $req['id'];
        $name = $req['group'];
        $slug = str_slug($name, '-');
        $this->email_groups->updateRich(['name' => $name, 'slug' => $slug], $id);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function postDeletegroup(Request $request)
    {
        $req = $request->all();
        $id = $req['group'];
        $this->email_groups->delete($id);
    }

    /**
     * @return mixed
     */
    public function getData($id = 0)
    {
        $data = $this->emails->findAllBy('group_id', $id);
        $obj = Datatables::of($data);
        $obj->addColumn(
            'action',
            '@if($is_public != "0")' .
            $this->dhelp->actionBtns(
                [
                    'setting_same' => ['link' => '/admin/settings/email/updateemail/{!! $id !!}'],
                    'delete_post' => ['link' => '/admin/settings/delete-email', 'id' => '{!! $id !!}'],
                ]
            )
            . '@else' .
            $this->dhelp->actionBtns(
                [
                    'setting_same' => ['link' => '/admin/settings/email/updateemail/{!! $id !!}']
                ]
            ) . '@endif'
        );
        $obj = $obj->make(true);

        return $obj;
    }

    /**
     * @param $contents
     * @return mixed
     */
    public function formatEmailCodes($contents)
    {
        $codes = [
            '[User Name]',
            '[Email]',
            '[Date]',
            '[Logo]',
            '[Site Name]'
        ];
        $values = [
            '{!! $user->username !!}',
            '{!! $user->email !!}',
            '{!! $date !!}',
            '{!! url(BBGetSiteSettings(\'site_logo\', \'/public/img/logoname.png\')) !!}',
            '{!! BBGetSiteSettings(\'site_name\', \'Site Name\') !!}'
        ];

        return str_replace($codes, $values, $contents);
    }

}