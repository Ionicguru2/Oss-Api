<?php namespace App\Http\Controllers\api\v1;

use App\Models\NotificationType;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;

class NotificationSettingController extends Controller {

    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    /**
     * Constructor will initialize the class with basic properties.
     */
    public function __construct()
    {
        $this->current_user = Auth::getUser();
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$notifications = $this->current_user->notification_settings;

        foreach($notifications as $notification)
            $notification->load('notification_type');

        return $notifications->toArray();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $identifier
	 * @return Response
	 */
    public function update($id, Request $request)
    {
        $allowed = $request->input('allowed');

        if(!$allowed)
            return $this->prepareResponse('BAD_REQUEST');

        $setting = NotificationSetting::where('id', '=', $id)->where('user_id', '=', \Auth::user()->id)->first();

        if(!$setting)
			return $this->prepareResponse('NO_SETTING');

        if($allowed == 'yes') {
            $setting->allowed = true;
        }

        if($allowed == 'no') {
            $setting->allowed = false;
        }

        $setting->save();
        return $setting->toArray();
    }

	/**
	 * Toggles the notification setting to turn on and off.
	 *
	 * @param  string  $identifier
	 * @return Response
	 */
	public function toggle($identifier)
	{
        $notification_type = NotificationType::where('identifier', '=', $identifier)->first();

        if(!$notification_type)
            return $this->prepareResponse('notification.NOTIF_TYPE_NOT_FOUND_ER');

        $notification_setting = NotificationSetting::where('user_id', '=', $this->current_user->id)
                                                ->where('notification_type_id', '=', $notification_type->id)->first();

        if(!$notification_setting):
            $notification_setting = NotificationSetting::create([ 'user_id' => $this->current_user->id,
                                          'notification_type_id' => $notification_type->id,
                                          'allowed' => true]);
        else:
            if($notification_setting->allowed):
                $notification_setting->allowed = false;
            else:
                $notification_setting->allowed = true;
            endif;

            $notification_setting->save();
        endif;

        $notification_setting->load('notification_type');
        return $notification_setting->toArray();
	}

}
