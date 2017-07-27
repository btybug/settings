<?php
/**
 * Created by PhpStorm.
 * User: muzammal
 * Date: 8/9/2016
 * Time: 11:51 AM
 */

namespace Sahakavatar\Settings\Repository;
use App\Models\Setting;
use Sahakavatar\Cms\Helpers\helpers;


/**
 * @property helpers helpers
 */
class Settings
{
    /**
     * Page constructor.
     */
    public function __construct(helpers $helpers)
    {
        $this->helpers = $helpers;
    }

    /**
     * Get All Seo Settings and format it
     */
    public function getSettings()
    {
        $data = [];
        $settings = Setting::where('section', 'seo')->get();
        foreach ($settings as $setting) {
            $data[$setting->settingkey] = ($setting->val != '') ? unserialize($setting->val) : [];
        }

        return $data;
    }

    /**
     * Get SEO Settings and save them in settings table with different sections
     *
     * @param $request
     */
    public function updateSeoSettings($request)
    {
        $req = $request->all();
        $data['facebook'] = @$request->facebook;
        $data['googleanalytics'] = @$request->googleanalytics;
        $data['pagespeedinsights'] = @$request->pagespeedinsights;
        $data['twittercards'] = @$request->twittercards;
        $data['titlemeta'] = @$request->titlemeta;
        $data['common'] = @$request->common;

        foreach ($data as $key => $val) {
            $setting = Setting::where('section', 'seo')->where('settingkey', $key)->first();
            if (!$setting) {
                $setting = new Setting;
                $setting->section = 'seo';
                $setting->settingkey = $key;
            }
            $setting->val = (is_array($val)) ? serialize($val) : $val;
            $setting->save();
        }

        $this->helpers->updatesession('Settings updated successfully');
    }

}