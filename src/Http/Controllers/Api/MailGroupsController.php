<?php

namespace Sahakavatar\Settings\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sahakavatar\Settings\Models\EmailGroups as EmailGroups;


/**
 * @property Templates templates
 * @property helpers helpers
 */
class MailGroupsController extends Controller
{
    private $email_groups = null;


    /**
     * MailGroupsController constructor.
     *
     * @param EmailGroups $email_groups
     */
    public function __construct(EmailGroups $email_groups)
    {
        $this->email_groups = $email_groups;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndex(Request $request)
    {
        return $this->email_groups->findGroups($request->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @internal param Request $request
     */
    public function getGroup($id)
    {
        return $this->email_groups->findGroup($id,'json');

    }

}
