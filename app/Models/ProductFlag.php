<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFlag extends Model {

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
    protected $table = 'product_flags';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'identifier'];


    /**
     * This function will return the list of products that are under this flag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'products_product_flags', 'product_id', 'product_flag_id');
    }
}
