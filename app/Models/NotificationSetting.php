<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notification_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'notification_type_id', 'allowed'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'allowed' => 'boolean',
    ];

    public function notification_type()
    {
        return $this->belongsTo('App\Models\NotificationType', 'notification_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
