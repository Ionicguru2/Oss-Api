<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {

    /**
     * Deactivating the auto-timestamp creating and updating
     * @var bool
     */
    public  $timestamps = false;

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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'pin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];

}
