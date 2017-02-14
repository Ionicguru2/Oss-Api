<?php namespace App\Http\Middleware\api\v1;

use Carbon\Carbon;
use Config;
use Closure;
use App\Models\Session;

class VerifyRestToken {

	/**
	 * Handle an incoming request.
     * The class with check for the rest token,
     * and if the token is supplied then check for the validations,
     * and if validated then logs the user in
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $rest_token = $request->input('_rest_token');

        if($rest_token) {

            $user = \DB::table('users')
                    ->select('users.*')
                    ->join('sessions', 'sessions.user_id', '=', 'users.id')
                    ->where('sessions.rest_token', '=', $rest_token)
                    ->first();

            if($user){
                if($user->deleted_at)
                    return \App::abort(Config::get('oss.messages.user.ACCOUNT_DEACTIVATED.code'), Config::get('oss.messages.user.ACCOUNT_DEACTIVATED.message'));

                $user = \Auth::loginUsingId($user->id);
                if($user){
                    $user->updateCurrentTimestamp();
                    return $next($request);
                }
                else
                    return \App::abort(Config::get('oss.messages.user.AUTH_ERROR.code'), Config::get('oss.messages.user.AUTH_ERROR.message'));
            }

        }

        return \App::abort(Config::get('oss.messages.user.AUTH_REQUIRE.code'), Config::get('oss.messages.user.AUTH_REQUIRE.message'));
	}

}
