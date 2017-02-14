<?php namespace App\Http\Controllers\api\v1;

use \Mendrill;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Database\QueryException;

class PasswordResetController extends Controller {

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
     * The method will take the request object and username.
     * It will get the username and update a pin in tables.
     *
     * @param  String $username
     * @return Response Json
     */
    public function create($username)
    {

        $user = User::where('username', '=', $username)->first();

        if(!user)
            return $this->prepareResponse('user.NOT_FOUND');

        Mandrill::send_email('admin', 'user.password_forgot',
            [ 'build_from_oss_config' => true, 'user' => $user ]);
    }


    /**
     * The method will get the parameter PIN and password1, password2.
     * It will check pin, match passwords and updated the user's password.
	 *
	 * @param  Request $request
	 * @return Response Json
	 */
	public function update($id, Request $request)
	{
        $user = User::find($id);

        if(!$user)
            return $this->prepareResponse('user.NOT_FOUND');

        if(!$this->current_user->can('super_password_update'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $password1 = $request->input('password1');
        $password2 = $request->input('password2');

        if($password1 != $password2)
            return $this->prepareResponse('user.PASSWORD_NOT_MATCH');

        $user->password = bcrypt($password1);
        $user->save();

        return $this->prepareResponse('user.PASSWORD_UPDATED');
	}
}
