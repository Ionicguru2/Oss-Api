<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RequestAccess;

class RequestAccessController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$requests = RequestAccess::all();
        return $requests->toArray();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$full_name = $request->input('full_name');
        $email = $request->input('email');
        $contact_number = $request->input('contact_number');
        $company = $request->input('company');


        if($full_name && $email & $contact_number & $company) {
            $request_access = RequestAccess::create([
                'full_name'         => $full_name,
                'email'             => $email,
                'contact_number'    => $contact_number,
                'company'           => $company,
            ]);

            return $request_access->toArray();
        }

       return $this->prepareResponse('BAD_REQUEST');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$request = RequestAccess::find($id);

        if(!$request)
			return $this->prepareResponse('request.NOT_FOUND_ER');
 
        return $request->toArray();
	}

}
