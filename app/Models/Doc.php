<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'docs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'lang', 'docs_type_id'];

    public function doc_type()
    {
        return $this->belongsTo('App\Models\DocType', 'docs_type_id', 'id');
    }
}
