<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'key', 'value', 'product_id' ];

    /**
     * The attributes will be hidden in the response.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * The property will return the belonging product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
