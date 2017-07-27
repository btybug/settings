<?php
namespace Sahakavatar\Settings\Http\Controllers;

use Sahakavatar\Cms\Helpers\helpers;
use App\helpers\MainHelper as Helper;
use App\Http\Controllers\Controller;
use Sahakavatar\Settings\Repository\AdminsettingRepository as Settings;
use File;
use Illuminate\Http\Request;
use Validator;

/**
 * Class SystemController
 * @package Sahakavatar\Settings\Http\Controllers
 */
class SystemController extends Controller
{
    /**
     * @var Settings|null
     */
    private $settings = null;
    /**
     * @var helpers|null
     */
    private $helpers = null;

    /**
     * SystemController constructor.
     * @param Settings $settings
     */
    public function __construct (Settings $settings)
    {
        $this->helpers = new helpers;
        $this->settings = $settings;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex ()
    {
        $languages = Helper::getAllLanguages();
        $config = Helper::getConfiguration();
        $timezones = Helper::getAllTimezones();
        $groups = [];//MemberGroups::pluck('title', 'id');
        $system = $this->settings->getSystemSettings();
        $data = [
            'groups'    => $groups,
            'languages' => $languages,
            'config'    => $config,
            'timezones' => $timezones,
            'category'  => null,
            'system'    => $system
        ];

        return view('settings::system', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMain ()
    {
        $system = $this->settings->getSystemSettings();
        $languages = Helper::getAllLanguages();
        $config = Helper::getConfiguration();
        $timezones = Helper::getAllTimezones();
        $groups = [];//MemberGroups::pluck('title', 'id');
        $data = [
            'groups'    => $groups,
            'languages' => $languages,
            'config'    => $config,
            'timezones' => $timezones,
            'category'  => null,
            'system'    => $system
        ];
        return view('settings::frontend.main',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postMain (Request $request)
    {
        $input = $request->except('_token');
        if ($request->file('site_logo')) {
            File::cleanDirectory('resources/assets/images/logo/');
            $name = $request->file('site_logo')->getClientOriginalName();
            $request->file('site_logo')->move('resources/assets/images/logo/', $name);

            $input['site_logo'] = $name;
        }

        $this->settings->updateSystemSettings($input);
        $this->helpers->updatesession('System successfully saved');

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNotifications ()
    {

        return view('settings::notifications');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUrlMenger ()
    {

        return view('settings::url_menger');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLoginRegistration ()
    {
        $languages = Helper::getAllLanguages();
        $config = Helper::getConfiguration();
        $timezones = Helper::getAllTimezones();
        $groups = [];//MemberGroups::pluck('title', 'id');
        $system = $this->settings->getSystemSettings();
        $data = [
            'groups'    => $groups,
            'languages' => $languages,
            'config'    => $config,
            'timezones' => $timezones,
            'category'  => null,
            'system'    => $system
        ];

        return view('settings::login_registration', $data);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSystem (Request $request)
    {
        $input = $request->except('_token');
        $this->settings->updateSystemSettings($input);
        $this->helpers->updatesession('System successfully saved');

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSocialApiKeys (Request $request)
    {
        $input = $request->except(['_token']);
        if ( $this->settings->saveSocialApiKey($input)) {
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function urlManager (Request $request)
    {
        $data = $request->all();
        if ($this->settings->urlManager($data)) {
            return redirect()->back();
        }
    }

    /**
     * @return mixed
     */
    public function getAdminemails ()
    {
        $emails = [];
        $data = $this->settings->findAllBy('section', 'admin_emails')->toArray();
        foreach ($data as $rs) {
            $emails[$rs['settingkey']] = $rs['val'];
        }

        return view('settings::admin_emails', compact(['emails']));
    }


    /**
     * @param Request $request
     */
    public function postAdminemails (Request $request)
    {
        $input = $request->except('_token');

        $validator = Validator::make(
            $request->all(),
            [
                'info'            => 'required|email',
                'support'         => 'required|email',
                'admin'           => 'required|email',
                'sales'           => 'required|email',
                'technical_staff' => 'required|email',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $this->settings->updateSystemSettings($input, 'admin_emails');
            $this->helpers->updatesession('Admin Emails successfully updated');

            return redirect()->back();
        }
    }

}
