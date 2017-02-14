<?php namespace App\Http\Controllers\api\v1;

use \Auth as Auth;
use \App as App;
use Config;
use SendBird;
use Storage;
use Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\AmazonSNS;

/*
 * Model imports
 */
use App\Models\User;
use App\Models\Company;
use App\Models\Session;
use App\Models\NotificationType;
use App\Models\NotificationSetting;
use App\Models\TransactionRating;
use App\Models\SessionPushRegistration;
use League\Flysystem\Exception;

class UserController extends Controller {

    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    /**
     * The media extension contains the list of allowed photo extensions.
     *
     * @var Array
     */
    private $media_extensions;


    /**
     * The media path defines the path where user's profile images will be uploaded/retrieved.
     *
     * @var String
     */
    private $media_path;

    /**
     * Constructor will initialize the class with basic properties.
     */
    public function __construct()
    {
        $this->current_user = Auth::getUser();
        $this->media_extensions = Config::get('oss.user.media.extensions');
        $this->media_path = Config::get('oss.user.media.path');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if(!$this->current_user->can('list_user'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $users = User::with(['company', 'company.region', 'role'])->get();

        return $users->toArray();
    }

	/**
	 * Logs in the customer with the system
	 */
	public function login(Request $request)
	{
        $email = $request->input('username');
        $password = $request->input('password');

        if($email && $password) {
            if (Auth::once(['email' => $email, 'password' => $password])){
                $user = User::where('email', '=', $email)->first();
                $user->update(['online' => true]);
                return $this->login_user($user);

            } else {
                $user = User::where('email', '=', $email)->first();

                if(!$user)
                    return $this->prepareResponse('user.NOT_FOUND');

                if($user->deleted_at)
                    return $this->prepareResponse('user.ACCOUNT_DEACTIVATED');
                else
                    return $this->prepareResponse('user.PASSWORD_ERROR');

            }
        }

        return $this->prepareResponse('BAD_REQUEST');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {

        if(!Config::get('oss.demo.enabled')) {
            if(!$this->current_user->can('create_user'))
                return $this->prepareResponse('NOT_AUTHORIZED');
        }

//        if(!$this->current_user->can('create_user'))
//            return $this->prepareResponse('NOT_AUTHORIZED');

		$firstname      = $request->input('firstname');
		$lastname       = $request->input('lastname');
        $identifier     = $request->input('identifier');
        $password       = $request->input('password');
        $passcode       = $request->input('passcode');
        $phone          = $request->input('phone');
        $email          = $request->input('email');
        $job            = $request->input('job');
        $company_id     = $request->input('company_id');
        $role_id        = $request->input('role_id');
        $country_id     = $request->input('country_id');
        $image          = $request->file('image');

        if($image) {
            if(array_search($image->getClientOriginalExtension(), $this->media_extensions) === false) {
                return $this->prepareResponse('BAD_IMAGE_FORMAT');
            }
        }

        if(Config::get('oss.demo.enabled')) {
            $password   = Config::get('oss.demo.user.password');
            $passcode   = Config::get('oss.demo.user.passcode');
            $phone      = Config::get('oss.demo.user.phone');
        }

	$identifier = User::generate_identifier();

        if($firstname && $lastname && $password && $email && $company_id && $role_id && $country_id) {

            // Check if the email is taken or not
            $user = User::where(function($query) use ($email) {
                $query->where('email', '=', $email);
            })->first();

            if($user)
            {
                // return what's taken
                return $this->prepareResponse('user.EMAIL_TAKEN');
            }

            if($image) {
                $file_name =  $this->_get_filename() .'.' . $image->getClientOriginalExtension();
                $s3 = Storage::disk('s3');
                $filePath = $this->media_path . $file_name;
                $s3->put($filePath, file_get_contents($image), 'public');
            } else {
                $file_name = Config::get('oss.user.media.default');
            }

            // create a new user
            $user = User::create([
                'firstname'             => ucfirst($firstname),
                'lastname'              => ucfirst($lastname),
                'phone'                 => ($phone) ? $phone : null,
                'identifier'            => $identifier,
                'password'              => bcrypt($password),
                'passcode'              => $passcode ? $passcode : null,
                'email'                 => $email,
                'job'                   => $job,
                'profile_image'         => $file_name,
                'company_id'            => $company_id,
                'role_id'               => $role_id,
                'country_id'            => $country_id,
                'sendbird'              => null,
                'sendbird_id'           => null,
                'terms_accepted'        => false
            ]);

            $notification_types = NotificationType::all();

            foreach($notification_types as $notification_type){
                NotificationSetting::create([
                    'user_id'               => $user->id,
                    'notification_type_id'  => $notification_type->id,
                    'allowed'               => true
                ]);
            }

            SendBird::create_user($user);

            return $this->login_user($user);
        }

         return $this->prepareResponse('REQUIRED_VALUE_MISSING');
    }

    public function read_terms()
    {
        $this->current_user->terms_accepted = true;
        $this->current_user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::with(['rating_required', 'role', 'company'])->where('id', '=', $id)->first();;

        if(!$this->current_user->can('view_user'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($user) {
            return $user->toArray();
        }

        $user->rating = TransactionRating::where('user_id', $user->id)->avg('rating');
        return $this->prepareResponse('user.NOT_FOUND');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request ,$id)
    {
        $user = User::find($id);

        if(!$user)
             return $this->prepareResponse('user.NOT_FOUND');

        if(!$this->current_user->id == $id && !$this->current_user->can('update_user'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $passcode = $request->input('passcode');
        $email = $request->input('email');
        $job = $request->input('job');
        $terms_accepted = $request->input('terms_accepted');
    	$company_id = $request->input('company_id');
    	$country_id = $request->input('country_id');

        if(Config::get('oss.demo.enabled')) {
            $password = Config::get('oss.demo.user.password');
            $passcode = Config::get('oss.demo.user.passcode');
            $phone    = Config::get('oss.demo.user.phone');
        }

        if($firstname)
            $user->firstname = ucfirst($firstname);

        if($lastname)
            $user->lastname = ucfirst($lastname);

        if($phone)
            $user->phone = $phone;

        if($password)
            $user->password = bcrypt($password);

        if($passcode)
            $user->passcode = bcrypt($passcode);

        if($email)
            $user->email = $email;

        if($job)
            $user->job = $job;

        if($terms_accepted)
            $user->terms_accepted = $terms_accepted;

    	if ($company_id)
    	    $user->company_id = $company_id;

    	if ($country_id)
    	    $user->country_id = $country_id;

        try {
            $user->save();
            $user->load('role');
            $user->load('company');
            return $user->toArray();

        } catch(Exception $e) {
            return $this->prepareResponse('BAD_REQUEST');
            
        }
    }

    public function change_pin($id, Request $request)
    {
        $user = User::find($id);

        if(!$user)
             return $this->prepareResponse('user.NOT_FOUND');

        if(!$this->current_user->id == $id && !$this->current_user->can('update_user'))
            return $this->prepareResponse('NOT_AUTHORIZED');

    }

    public function pin(Request $request)
    {
        $pin = $request->input('pin');

        if($this->current_user->passcode == $pin)
            return \Response::json([ 'success' => 200, 'message' => true]);

        return \Response::json([ 'success' => 200, 'message' => false ]);
    }

    public function company($id, $company_id){

        if(!$this->current_user->can('change_company')) {
            return $this->prepareResponse('NOT_AUTHORIZED');
        }

        $user = User::find($id);

        if(!$user)
            return $this->prepareResponse('user.NOT_FOUND');

        $company = Company::find($company_id);

        if(!$company)
            return $this->prepareResponse('company.NOT_FOUND');

        $user->company_id = $company->id;
        $user->save();

        $user->load('company');
        return $user->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(!$user)
             return $this->prepareResponse('user.NOT_FOUND');

        if($this->current_user->id != $id && !$this->current_user->can('delete_user'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $user->delete();
        return $this->prepareResponse('user.DELETED');
    }

    /**
     * The function will log user out
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function logout()
    {
        if(Auth::check()) {

            Session::where('user_id', '=', $this->current_user->id)->delete();
            Auth::logout();

            return $this->prepareResponse('user.LOGGED_OUT');
           
        }
        return $this->prepareResponse('NOT_AUTHORIZED');
    }

    public function suspend()
    {
        if(!$this->current_user->can('list_user'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $users = User::onlyTrashed()->get();
        return $users->toArray();
    }

    public function products($id)
    {

        if($this->current_user->id != $id)
            if(!$this->current_user->can('super_list_post'))
                return $this->prepareResponse('NOT_AUTHORIZED');

        if($this->current_user->id == $id){
            $user = $this->current_user;
        }
        else{
            $user = User::find($id);

            if(!$user)
                return $this->prepareResponse('use.NOT_FOUND');
        }

        $user->products->load('status');
        $user->products->load('category');

        foreach ($user->products as $product) {
            $product['user']['identifier'] = $user->identifier;

            unset($product['user']['firstname']);
            unset($product['user']['lastname']);
            unset($product['user']['username']);
            unset($product['user']['email']);
            unset($product['user']['sendbird']);
            unset($product['user']['sendbird_id']);
            unset($product['user']['company_id']);
            unset($product['user']['profile_image']);
            unset($product['user']['job']);
            unset($product['user']['terms_accepted']);
            unset($product['user']['role_id']);
            unset($product['user']['country_id']);
            unset($product['user']['phone']);
            unset($product['user']['online']);
            unset($product['category']['parent_id']);
            unset($product['category']['created_at']);
            unset($product['category']['updated_at']);
        }


        return $user->products->toArray();
    }

    /**
     * This function will register a users session to receive push notifications. The type
     * of notifications they receive will depend on the type of device they register here
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function register_push(Request $request)
    {
        $device_type = $request->get('type');
        $device_key = $request->get('key');
        $session = Session::where('rest_token', '=', $request->get('_rest_token'))->first();
        
        if (count(SessionPushRegistration::where('session_id', '=', $session->id)->get()))
            return $this->prepareResponse('ALREADY_REGISTERED');

        $push_registration = SessionPushRegistration::create([

            'session_id'    => $session->id,
            'type'          => $device_type,
            'key'           => AmazonSNS::register($this->current_user, $device_key)

        ]);

        return $push_registration->toArray();
    }

    /**
     * The function will take the user object and log the user in.
     * It will also generate the login creds and pass it back to the client.
     *
     * @param $user
     * @return mixed
     */
    private function login_user($user)
    {
        if(Config::get('oss.single_session'))
            Session::where('user_id', '=', $user->id)->delete();

        if(!$user->can('access_admin') && !$user->can('access_front_end'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $session = Session::create([
            'user_id'   => $user->id,
            'rest_token' => md5(uniqid(rand(), true))
        ]);

        $user->session = $session;
        $user->load(['company', 'role', 'rating_required']);
        $user->rating = TransactionRating::where('user_id', $user->id)->avg('rating');
        return $user;
    }


    private function _get_filename( $length = 52 )
    {
        $filename = "";
        $crypt_allowed_code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $crypt_allowed_code.= "abcdefghijklmnopqrstuvwxyz";
        $crypt_allowed_code.= "0123456789_-";

        for($i=0; $i < $length ;$i++){
            $filename .= $crypt_allowed_code[ $this->_crypto_rand_secure( 0, strlen($crypt_allowed_code) ) ];
        }
        return $filename;
    }

    private function _crypto_rand_secure($min, $max) {
        $range = $max - $min;

        if ($range < 0) return $min;
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);

        return $min + $rnd;
    }
}
