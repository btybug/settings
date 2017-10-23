<?php

use Sahakavatar\Settings\Uploaders;

if (!function_exists('BBUploader')) {

    /**
     * Provide all Media Settings
     *
     * @return array
     */
    function BBUploader($code = null)
    {
        $uploader = Uploaders::where('short_code', $code)->first();
        if ($uploader) {
            $settings = unserialize($uploader->settings);
            return view('settings::uploaders.uploader', compact(['uploader', 'settings']));
        } else {
            return 'No Uploader Found';
        }
    }
}

