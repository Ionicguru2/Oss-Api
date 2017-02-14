<?php namespace App\Models;

use File;
use Config;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'identifier'];


    /**
     * This function will return all the associated products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public  function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }


    /**
     * This property will return the parent category of the given category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id', 'id');
    }


    /**
     * This property will return all the child category of the given category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }


    /**
     * This property defines one-to-many relationship with the CategoryImages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category_images()
    {
        return $this->hasMany('App\Models\CategoryImage', 'category_id', 'id');
    }

}
