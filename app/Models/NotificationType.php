<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model {

    /**
     * This will disable auto-time stamping.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notification_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'identifier'];

}
