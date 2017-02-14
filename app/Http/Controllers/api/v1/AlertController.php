<?php namespace App\Http\Controllers\api\v1;

use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Alert;

class AlertController extends Controller {

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
        $alerts = Alert::where('user_id', '=', $this->current_user->id)->orderBy('created_at', 'DESC')->with('offer.product', 'offer', 'offer.transaction')->get();

        foreach ($alerts as $key => $alert)
        {
            $not_me = null;

            if ($alert->type != 'message' && $alert->offer && $alert->offer->transaction)
            {
                foreach ($alert->offer->transaction->users as $user)
                {
                    if ($user->id == $this->current_user->id)
                        continue;

                    $alerts[$key]->participant = $user;
                }
            }
            else if ($alert->transaction && $alert->transaction->offer)
            {
                $alerts[$key]->setRelation('offer', $alert->transaction->offer);
                foreach ($alert->transaction->users as $user)
                {
                    if ($user->id == $this->current_user->id)
                        continue;

                    $alerts[$key]->participant = $user;
                }

                $alerts[$key]->type_id = $alert->transaction->offer->id;
                $alerts[$key]->type = 'offer';
            }
            else
            {
                continue;
            }
        }

        return $alerts->toArray();
	}

	/**
	 * Mark the alert seen.
	 *
	 * @return Response
	 */
	public function seen($id)
	{
        $alert = Alert::find($id);

        if(!$alert)
			return $this->prepareResponse('message.NO_ALERT');

        if($this->current_user->id != $alert->user_id)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $alert->seen = true;
        $alert->save();

        return $alert->toArray();
	}

}
