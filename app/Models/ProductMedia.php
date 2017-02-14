<?php namespace App\Models;

use File;
use Config;
use Storage;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'path', 'order', 'product_id' ];


    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }


    public function getPathAttribute($path)
    {
        $image_path = Config::get('oss.product.media.path') . $path;

        if (Storage::disk('s3')->exists($image_path))
            return Storage::disk('s3')->getDriver()->getAdapter()->getClient()->getObjectUrl(env('AMAZON_S3_BUCKET'), $image_path);
        else
            return url('/') . Config::get('oss.product.media.path') . Config::get('oss.product.media.default');
    }

}
