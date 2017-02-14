<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model {

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
    protected $table = 'product_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];


    public function products()
    {
        return $this->hasMany('App\Models\Product', 'status_id', 'id');
    }

}
