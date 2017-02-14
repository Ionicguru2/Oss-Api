<?php namespace App\Http\Helpers;

use App\Models\User;
use Config;
use Mail;
use phpDocumentor\Reflection\Types\Array_;

class Mandrill {

    /**
     * This is a generalized method for all email calls.
     *
     * @param $receiver [ if build_from_oss_config == true then this is oss.config setting, otherwise User object. ]
     * @param $template String
     * @param $data
     */
    public function send_user_email(User $user,$template,$data)
    {
        // get No reply address and name
        $no_reply['address'] = Config::get('oss.mandrill.emails.no-reply.email');
        $no_reply['name']    = Config::get('oss.mandrill.emails.no-reply.name');

        Mail::send($template, $data, function($message) use ($no_reply, $user, $data) {
            $message->from($no_reply['address'], $no_reply['name']);
            $message->to($user->email, $user->get_name());
            $message->subject($data['subject']);
        });

    }

    /**
     * This is a generalized method for all email calls.
     *
     * @param $receiver [ if build_from_oss_config == true then this is oss.config setting, otherwise User object. ]
     * @param $template String
     * @param $data
     */
    public function send_email($email,$template,$data)
    {
        // get No reply address and name
        $no_reply['address'] = Config::get('oss.mandrill.emails.no-reply.email');
        $no_reply['name']    = Config::get('oss.mandrill.emails.no-reply.name');

        Mail::send($template, $data, function($message) use ($no_reply, $email, $data) {
            $message->from($no_reply['address'], $no_reply['name']);
            $message->to($email['address'], $email['name']);
            $message->subject($data['subject']);
        });

    }

}