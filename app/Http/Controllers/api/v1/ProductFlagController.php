<?php namespace App\Http\Controllers\api\v1;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ProductFlag;
use Illuminate\Http\Request;

class ProductFlagController extends Controller {

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
		$product_flags = ProductFlag::all();
        return $product_flags->toArray();
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$flag = $this->_get_flag($id, 'update_flag');
        $name = $request->input('name');

        if($name)
            $flag->name = $name;

        $flag->save();
        return $flag->toArray();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $flag = $this->_get_flag($id, 'delete_flag');

        $flag->delete();
		return $this->prepareResponse('flag.DELETED');
        
	}

    private function _get_flag($id, $permission)
    {
        if(!$this->current_user->can($permission))
			return $this->prepareResponse('NOT_AUTHORIZED');

        $flag = ProductFlag::find($id);

        if(!$flag)
            return $this->prepareResponse('flag.NOT_FOUND');

        return $flag;
    }

}
