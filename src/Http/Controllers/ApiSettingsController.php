<?php
/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 8/11/2016
 * Time: 11:00 PM
 */

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Settings\Repository\Settings;
use Socialite;

class ApiSettingsController extends Controller
{
    /**
     * ApiSettingsController constructor.
     *
     * @param Settings $settings
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
        $this->home = '/admin/settings/api-settings';
    }


    public function getIndex()
    {

        $settings = $this->settings->getSettings();
        $config=\Config::get('services');
        return view('settings::settings.index', compact(['settings','config']));
    }
    public function getTest(){
        $user = Socialite::driver('github')->user();
        if($user){
            dd($user);

        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUpdate(Request $request)
    {
        $data=$request->all();
        unset($data['_token']);
       \File::put(base_path('app/Modules/Settings/socialsettings.json'),json_encode($data,true),true);
        $this->settings->updateSeoSettings($request);

        return redirect($this->home);
    }

}