<?php
/**
 * Created by PhpStorm.
 * User: Sahak
 * Date: 8/12/2016
 * Time: 12:29 PM
 */

namespace Sahakavatar\Settings\Http\Controllers\Api;

use File;
use Illuminate\Routing\Controller;
use Socialite;

class SotialAuthorisationController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($sotial, $event = null)
    {
        $redir = ['main' => $event];
        File::put(base_path('app/Modules/Settings/social.json'), json_encode($redir, true));
        return Socialite::driver($sotial)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($sotial)
    {
        $event = json_decode(File::get(base_path('app/Modules/Settings/social.json')), true);
        File::put(base_path('app/Modules/Settings/social.json'), json_encode([], true));
        $user = Socialite::driver($sotial)->user();

        return $this->HookSocial($sotial, $user, $event['main']);
    }

    protected function HookSocial($sotial, $user, $event)
    {
        $functions = (\Config::get('sociale_actions'));
        if ($functions and isset($functions[$sotial])) {
            foreach ($functions[$sotial] as $function) {
                if ($function['event'] != $event) {
                    try {
                        $p_function = $function['function'];
                        $p_function($user);
                    } catch (\Exception $e) {
                        // echo 'Caught exception: ',  $e->getMessage(), "\n";
                    }
                } else {
                    $main = $function['function'];
                }
            }

            if (isset($main)) {
                return $main($user);
            }
        }
    }
}