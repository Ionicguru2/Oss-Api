<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Session extends Model {

    /**
     * Deactivating the auto-timestamp creating and updating
     * @var bool
     */
    public  $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sessions';

    /**
     * The boot method controls the way data is being saved into the system.
     */
    public static function boot()
    {
        /**
         * This method will be fired when a new model is being created
         */
        static::creating(function ($login) {
            $login->created_at = $login->freshTimestamp();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'rest_token', 'region_id', 'last_activity'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * The function will return a list of the push registrations this sessino has
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function push_registration()
    {
        return $this->hasMany('App\Models\SessionPushRegistration', 'session_id', 'id');
    }
}
