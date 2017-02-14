<?php namespace App\Models;

use Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'type', 'sku', 'details', 'price', 'image', 'available_from',
        'available_to', 'user_id', 'status_id', 'country_id', 'category_id', 'region_id',
        'certification'
    ];

    /**
     * The attributes will be hidden in the response.
     *
     * @var array
     */
    protected $hidden = [ 'deleted_at' ];

    /**
     * The property will return the category of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    /**
     * The property will return the owner of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * The property will return the status of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Models\ProductStatus', 'status_id', 'id');
    }

    /**
     * The property will return the country of the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /**
     * The property will return media of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany('App\Models\ProductMedia', 'product_id', 'id');
    }

    /**
     * The property will return meta data of the products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany('App\Models\ProductMeta', 'product_id', 'id');
    }


    /**
     * This function will return the attached flag with the given product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flags()
    {
        return $this->belongsToMany('App\Models\ProductFlag', 'products_product_flags', 'product_id', 'product_flag_id');
    }

    /**
     * The function will check if the product has already a flag attached to it,
     * based on the given identifier. If yes then returns true, otherwise false.
     *
     * @param $identifier String
     * @return bool
     */
    public function has_flag($identifier)
    {
        $flags = $this->flags();

        if (count($flags)) {
            foreach($flags as $flag) {
                if($flag->identifier == $identifier)
                    return true;
            }
        }

        return false;
    }
}
