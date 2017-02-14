<?php namespace App\Models;

use File;
use Config;
use Storage;
use Illuminate\Database\Eloquent\Model;

class CategoryImage extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['types', 'path', 'category_id'];


    /**
     * This property defines the belonging relationship to Categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }


    /**
     * The function will be called upon each retrieval of the instance.
     * The function will check if the file exists, if not then returns
     * the default images.
     *
     * @param $value
     * @return string
     */
    public function getPathAttribute($value)
    {
        $path = Config::get('oss.category.media.path') . $value;

        if (Storage::disk('s3')->exists($path))
            return Storage::disk('s3')->getDriver()->getAdapter()->getClient()->getObjectUrl(env('AMAZON_S3_BUCKET'), $path);
        else
            return url() . Config::get('oss.category.media.path') . Config::get('oss.category.media.default');
    }

}
