<?php
/**
 * User: muzammal
 * Date: 5/23/2016
 * Time: 1:28 PM
 */

namespace Sahakavatar\Settings\Models;

use Sahakavatar\User\Models\Roles;
use Carbon\Carbon;
use Mail;

/**
 * Class SendEmail
 *
 * @package Sahakavatar\Settings\Models
 */
class SendEmail
{
    /**
     * @param $email
     */
    public function sendEmail($email, $model = null)
    {
        $data = [];

        $to_users = $this->getTo($email->to_, $model);
        $date = Carbon::now();
        $date = $date->toDateTimeString();
        if (count($to_users) > 0) {
            foreach ($to_users as $user) {
                if ($user) {
                    //\Eventy::action('user_send_email', [$user, $email]);
                    Mail::send(
                        'emails.mail_content',
                        ['user' => $user, 'date' => $date],
                        function ($message) use ($email, $user) {
                            $message->from(@$email->from_, @$email->from_);
                            $message->to(@$user->email, @$user->email);
                            $message->subject(@$email->subject);

                            if ($email->attachment != '') {
                                $message->attach(url('/') . @$email->attachment);
                            }
                            $cc = $this->getMails($email->cc);
                            if ($cc != '') {
                                $message->cc($cc);
                            }
                            $bcc = $this->getMails($email->bcc);
                            if ($bcc != '') {
                                $message->bcc($bcc);
                            }
                            if ($email->replyto != '') {
                                $message->replyTo($email->replyto, $email->replyto);
                            }
                        }
                    );
                }
            }
        }

    }




    /**
     * @param $to
     * @return array
     */
    public function getTo($to, $model = null)
    {
        $users = [];
        switch ($to) {
            case 'Logged  User':
                $user = \Auth::user();
                if ($user) {
                    $users[] = $user;
                }
                break;
            case 'Signup User':
                $user = $model;
                if ($user) {
                    $users[] = $user;
                }
                break;

            default:
                $rs = Roles::where('slug', $to)->first();
                if ($rs) {
                    foreach ($rs->role_user as $rec) {
                        $users[] = $rec;
                    }
                }
                break;
        }

        return $users;
    }

    public function getMails($receiver)
    {
        $rs = '';
        if ($receiver != '') {
            $users = $this->getTo($receiver);
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $rs[] = $user->email;
                }
            }
        }

        return $rs;
    }
}
