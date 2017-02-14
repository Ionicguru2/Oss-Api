<?php namespace App\Http\Helpers;

use App\Models\User;
use Config;
use Aws\Sns\SnsClient;
use App\Models\SessionPushRegistration;
use phpDocumentor\Reflection\Types\Array_;

class AmazonSNS {

    /**
     * This is a generalized method for all email calls.
     *
     * @param $receiver [ if build_from_oss_config == true then this is oss.config setting, otherwise User object. ]
     * @param $template String
     * @param $data
     */
    public static function send_push(User $user, $content, $data)
    {
    	$client = SnsClient::factory(array(
            'key'    => Config::get('oss.push_notifications.ses_key'),
            'secret' => Config::get('oss.push_notifications.ses_secret'),
            'region' => Config::get('oss.push_notifications.ses_region')
            ));


        $registration = $user->get_active_push_registrations();

        foreach ($registration as $reg)
        {
	try
{
        	$client->publish(array(
			    'TargetArn' => $reg->key,
			    'MessageStructure' => 'json',
			    'Message' => json_encode(array(
			        'default' => $content,
			        'APNS' => json_encode(array(
			            'aps' => array(
			                'alert' => $content,
			                'alertId' => $data['alertId']
			            ),
			        )),
			        'APNS_SANDBOX' => json_encode(array(
			            'aps' => array(
			                'alert' => $content,
			                'alertId' => $data['alertId']
			            ),
			        )),

			    ))

			));
}
catch (\Exception $e)
{
} 
       }
    }

    public static function register(User $user, $device_key)
    {
    	$client = SnsClient::factory(array(
            'key'    => Config::get('oss.push_notifications.ses_key'),
            'secret' => Config::get('oss.push_notifications.ses_secret'),
            'region' => Config::get('oss.push_notifications.ses_region')
            ));

    	$result = $client->createPlatformEndpoint([ 

    		'PlatformApplicationArn' => Config::get('oss.push_notifications.ses_arn'),
    		'Token'					 => $device_key,
    		'CustomUserData'		 => 'User' . $user->id

		]);

    	return $result->get('EndpointArn');
    }
}
