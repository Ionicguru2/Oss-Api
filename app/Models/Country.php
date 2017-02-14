<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

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
    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'region_id'];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'country_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'country_id', 'id');
    }
}
