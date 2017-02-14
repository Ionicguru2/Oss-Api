<?php namespace App\Http\Controllers\api\v1;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Country;

class RegionController extends Controller {


    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    public function __construct()
    {
        $this->current_user = Auth::getUser();
    }

	/**
	 * Display a listing of the Region.
	 *
	 * @return Response
	 */
	public function index()
	{
        $regions = Region::all()->toArray();
        //$selected = Auth::user()->session->toArray();

        array_unshift($regions, ['id' => 0, 'name' => 'All Regions']);

        //$regions['selected'] = ( $selected['region_id'] ) ? $selected['region_id'] : 0;

        return $regions;
	}

	/**
	 * Store a region in session.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $id = $request->input('id');
        $session = \Auth::user()->session;

        $query = \DB::table('sessions')
            ->where('user_id', '=', $session->user_id)
            ->where('rest_token', '=', $session->rest_token);

        if($id == 0) {
            $query->update(['region_id' => null]);
        }

        if($id != 0 ) {
            $region = Region::find($id);

            if(!$region)
				return $this->prepareResponse('region.NOT_FOUND_ER');

            $query->update(['region_id' => $region->id]);
        }

		return $this->prepareResponse('country.BEEN_SET');
	}

    public function countries($id)
    {
        $countries = null;

        if($id != 0)
            $countries = Country::where('region_id', '=', $id)->get();

        if($id == 0)
            $countries = Country::all();

        if(count($countries))
            return $countries->toArray();
		return $this->prepareResponse('region.COUNTRY_NOT_FOUND_ER');
        
    }


    public function users($id)
    {
        if(!$this->current_user->can('list_users'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $region = Region::with('countries.users')->where('id', '=', $id)->first();

        if(!$region)
            return $this->prepareResponse('region.NOT_FOUND_ER');

        return $region->toArray();
    }

}
