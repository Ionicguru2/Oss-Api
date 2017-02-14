<?php namespace App\Http\Controllers;

use App\Models\Alert;
use Config;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    /**
     * This method is one of the most important of all.
     * The method will take a parameter and based on that,
     * it will create the JSON response and send it over.
     *
     * @param $message_code String ( A code that matches config/OSS.php )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function prepareAlert($user_id, $message_code, $type_id) {

		if($message_code && $user_id && $type_id)
		{
            // get alert type and message
            $type       = 'oss.alerts.' . $message_code . '.type';
	        $message    = 'oss.alerts.' . $message_code . '.alert';
	        $action     = 'oss.alerts.' . $message_code . '.action';
            $identifier = 'oss.alerts.' . $message_code . '.identifier';

            // create Alert
			$alert = Alert::create([
				'type'      => Config::get($type),
				'message'   => Config::get($message),
				'user_id'   => $user_id,
				'type_id'   => $type_id,
                'action'    => $action
			]);

            $alert->send_notification();
	
			return $alert;		
		}
		return false;
    }


    /**
     * This is a core API method, This method must not be altered.
     * The method takes `message_code` as a parameter and creates
     * a JSON response for all of the controller.
     *
     * @param $message_code     [ Message Codes are defined at config/oss.config ]
     * @return Response         [ JSON RESPONSE object ]
     */
	function prepareResponse($message_code) {

        // Get Code and Message of the message code.
        $code = 'oss.messages.' . $message_code . '.code';
        $message = 'oss.messages.' . $message_code . '.message';

        // this will return a response.
		if(Config::get($code) == 200)
	        return \Response::json([ 'success' => Config::get($code), 'message' => Config::get($message) ], Config::get($code));
		else
	        return \Response::json([ 'error' => Config::get($code), 'message' => Config::get($message) ], Config::get($code));
		
    }
}
