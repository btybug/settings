<?php


// Seetings Email Groups
if (!function_exists('groups')) {

    /**
     * @param $params
     * @return \Illuminate\Http\JsonResponse
     */
    function mailgroups($params = [])
    {
        $groups = new App\Modules\Settings\Models\EmailGroups;

        return $groups->findGroups();
    }

}

if (!function_exists('mailgroup')) {
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @internal param Request $request
     */
    function mailgroup($id)
    {
        $groups = new App\Modules\Settings\Models\EmailGroups;
        return $groups->findGroup($id);
    }
}