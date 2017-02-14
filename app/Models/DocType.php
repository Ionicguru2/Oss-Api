<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocType extends Model {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'docs_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function docs()
    {
        return $this->hasMany('App\Models\Doc', 'docs_type_id', 'id');
    }
}
