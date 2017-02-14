<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingRequired extends Model {

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
    protected $table = 'rating_required';


    /**
     * The boot method controls the way data is being saved into the system.
     */
    public static function boot()
    {
        /**
         * This method will be fired when a new model is being created
         */
        static::creating(function ($rating_required) {
            $rating_required->created_at = $rating_required->freshTimestamp();
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'transaction_id'];

}
