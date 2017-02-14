<?php namespace App\Models;

use File;
use Config;
use Storage;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'identifier', 'job',
        'password', 'passcode', 'phone', 'email', 'role_id', 'company_id', 'country_id',
        'profile_image', 'sendbird', 'sendbird_id', 'online', 'terms_accepted'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'deleted_at', 'passcode'];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'online' => 'boolean',
        'terms_accepted' => 'boolean',
    ];


    /**
     * The method will return the company details attached to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }


    /**
     * This function will return the role attached to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }


    /**
     * The method will return the login token for the users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function session()
    {
        return $this->hasMany('App\Models\Session', 'user_id', 'id');
    }


    /**
     * The function will return a list of product published by the user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'user_id', 'id');
    }


    /**
     * The function will return a boolean value based on the permission identifier.
     *
     * @param $identifier
     * @return bool
     */
    public function can($identifier)
    {
        if (Config::get('oss.demo.enabled'))
            return true;

        $role = $this->role()->first();
        $permissions = $role->permissions;

        if ($permissions) {
            foreach ($permissions as $permission) {
                if ($permission->identifier == $identifier)
                    return true;
            }
        }

        return false;
    }

    /**
     * The function will return the list of alerts for the given user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alerts()
    {
        return $this->hasMany('App\Models\Alert', 'user_id', 'id');
    }


    /**
     * The function retrieves the notification settings for the given user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notification_settings()
    {
        return $this->hasMany('App\Models\NotificationSetting', 'user_id', 'id');
    }


    /**
     * The function will return all the transaction intiated by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions()
    {
        return $this->belongsToMany('App\Models\Transaction', 'transactions_users', 'user_id', 'transaction_id');
    }


    /**
     * The function will generate a random identifier string for the users.
     *
     * @param string $country_code
     * @return string
     */
    public static function generate_identifier($country_code = 'CA')
    {
        do {
            $ident = rand(0, 999999999);
        } while (\DB::table('users')->where('identifier', '=', $ident)->first());

        return $ident . '-' . $country_code;
    }


    /**
     * The mutator will return the first letter capital.
     *
     * @param $value
     * @return string
     */
    public function getFirstnameAttribute($value)
    {
        return ucfirst($value);
    }


    /**
     * The mutator will return the first letter capital.
     *
     * @param $value
     * @return string
     */
    public function getLastnameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * This mutator method will return the path of the user's profile image.
     *
     * @param $value
     * @return string
     */
    public function getProfileImageAttribute($value)
    {
        $image_path = Config::get('oss.user.media.path') . $value;

        if (Storage::disk('s3')->exists($image_path))
            return Storage::disk('s3')->getDriver()->getAdapter()->getClient()->getObjectUrl(env('S3_BUCKET'), $image_path);
        else
            return url('/') . Config::get('oss.user.media.path') . Config::get('oss.user.media.default');
    }

    public function updateCurrentTimestamp()
    {
        $last_activity = Carbon::now()->timestamp;
        $this->session()->update([ 'last_activity' => $last_activity]);
        $this->update([ 'online' => true ]);
    }


    public function rating_required()
    {
        return $this->hasMany('App\Models\RatingRequired', 'user_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\TransactionRating', 'user_id', 'id');
    }

    public function scopeOnline(Builder $query)
    {
        return $query->where('online', '=', true);
    }


    public function check_notification($identifier)
    {
        $notification = NotificationSetting::join('notification_types',
            'notification_settings.notification_type_id','=', 'notification_types.id')
            -> where('notification_settings.user_id', '=', $this->id)
            ->where('notification_types.identifier', '=', $identifier)->first();

        if(!$notification)
            return false;

        if(!$notification->allowed)
            return false;

        return true;
    }

    public function get_name()
    {
        return trim($this->firstname . " " . $this->lastname);
    }

    public function get_active_push_registrations()
    {
        $registrations = SessionPushRegistration::join('sessions', 'sessions.id', '=', 'session_push_registrations.session_id')
                                                  ->where('sessions.user_id', '=', $this->id)
                                                  ->groupBy('session_push_registrations.key')
                                                  ->get();
        
        return $registrations;
    }
}
