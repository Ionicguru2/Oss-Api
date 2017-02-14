<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {

    /**
     * This will disable the auto-time stamping.
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The function will return the list of countries that come under the region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countries()
    {
        return $this->hasMany('App\Models\Country', 'region_id', 'id');
    }


    /**
     * The function will return the list of all companies residing in the region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companies()
    {
        return $this->hasMany('App\Models\Company', 'region_id', 'id');
    }
}
