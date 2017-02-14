<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestAccess extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_accesses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['full_name', 'email', 'contact_number', 'company'];

}
