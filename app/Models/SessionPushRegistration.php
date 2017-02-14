<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SessionPushRegistration extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'session_push_registrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['session_id', 'type', 'key'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];

    public function session()
    {
        return $this->belongsTo('App\Models\Session', 'session_id', 'id');
    }

}
