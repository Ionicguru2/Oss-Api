<?php namespace App\Models;

use \App\Http\Helpers\Mandrill;
use \App\Http\Helpers\AmazonSNS;
use Config;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model {


    /**
     * Deactivating the auto-timestamp creating and updating
     * @var bool
     */
    public  $timestamps = false;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alerts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'message', 'seen', 'user_id', 'type_id', 'action'];

    /**
     * The boot method controls the way data is being saved into the system.
     */
    public static function boot()
    {
        /**
         * This method will be fired when a new model is being created
         */
        static::creating(function ($alert) {

            $alert->created_at = $alert->freshTimestamp();

        });

    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'seen' => 'boolean',
    ];

    /**
     * The property will return the associated user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * This property will return the offer this alert is referring to
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offer()
    {
        return $this->belongsTo('App\Models\Offer', 'type_id', 'id');
    }

    /**
     * This property will return the offer this alert is referring to
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\transaction', 'type_id', 'id');
    }

    public function send_notification()
    {
        $alert_args = explode(".", $this->action);

        $obj_type   = $alert_args[2];
        $view_name  = $alert_args[3];

        $obj = call_user_func_array(array('App\\Models\\' . ucwords($obj_type), 'find'), array($this->type_id));

        if (!Config::get('oss.push_enabled'))
        {
            Mandrill::send_user_email($this->user, 'emails.alerts.' . $obj_type . '.' . $view_name, [ 'subject' => $this->message, 'user' => $this->user, $obj_type => $obj ]);
        }
        else
        {
            $view = View::make('push.alerts.' . $obj_type . '.' . $view_name, [ $obj_type => $obj ]);
            AmazonSNS::send_push($this->user, $view->render(), [ 'alertId' => $this->id ]);
        }
    }
}


