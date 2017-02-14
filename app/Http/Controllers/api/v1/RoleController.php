<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class RoleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $roles = Role::all();
        return $roles->toArray();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$name = $request->input('name');
        $identifier = $request->input('identifier');

        $role = Role::where('identifier', '=', $identifier)->first();

        if($role)
			return $this->prepareResponse('role.ALREADY_EXISTS_IDEN');
            

        $role = Role::create([
            'name'          => $name,
            'identifier'    => $identifier
        ]);

        return $role->toArray();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role = Role::find($id);

        if(!$role)
            return $this->prepareResponse('role.NOT_FOUND_ER');

        return $role->toArray();
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        $name = $request->input('name');

        $role = Role::find($id);

        if(!$role)
            return $this->prepareResponse('role.NOT_FOUND_ER');

        if($name)
            $role->name = $name;

        $role->save();

        return $role->toArray();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $role = Role::find($id);

        if(!$role)
           return $this->prepareResponse('role.NOT_FOUND_ER');

        $role->delete();

        return $this->prepareResponse('role.DELETED');
	}

    public function attach_user($id, $user_id)
    {
        $role = Role::find($id);

        if(!$role)
			return $this->prepareResponse('role.NOT_FOUND_ER');

        $user = User::find($user_id);

        if(!$user)
            return $this->prepareResponse('BAD_REQUEST');


        $user->roles()->attach($role->id);
		return $this->prepareResponse('role.USER_ROLE_UPDATED');
    }

    public function attach_permission($id, $permission_id)
    {
        $role = Role::find($id);

        if(!$role)
			return $this->prepareResponse('role.NOT_FOUND_ER');

        $permission = Permission::find($permission_id);

        if(!$permission)
            return $this->prepareResponse('BAD_REQUEST');


        $role->permissions()->attach($permission->id);
		return $this->prepareResponse('role.ROLE_PERMISSION_UPDATED');
       
    }
}
