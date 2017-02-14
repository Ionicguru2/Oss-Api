<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = Permission::all();
        return $permissions->toArray();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$permission = Permission::with(['roles'])->where('id', '=', $id)->first();

        if(!$permission)
			return $this->prepareResponse('PERMISSION_NOT_FOUND');

        return $permission->toArray();
	}
}
