<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use App\Models\NotificationTypeController;

class NotifSettingsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $notification_types = NotificationTypeController::all();
		return $notification_types->toArray();
	}

}
