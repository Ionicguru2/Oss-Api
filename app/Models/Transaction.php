<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'offer_id', 'enable', 'sendbird_name',
        'sendbird_url', 'transaction_stage_id', 'transaction_flag_id', 'validation'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'enable'        => 'boolean',
        'validation'    => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'transactions_users', 'transaction_id', 'user_id')->withPivot('validation_request');;
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id');
    }

    public function contracts()
    {
        return $this->belongsToMany('App\Models\Contract', 'contracts_transactions', 'transaction_id', 'contract_id');
    }

    public function rating_required()
    {
        return $this->hasMany('App\Models\RatingRequired', 'transaction_id', 'id');
    }

    public function transaction_stage()
    {
        return $this->belongsTo('App\Models\TransactionStage', 'transaction_stage_id', 'id');
    }

    public function transaction_flag()
    {
        return $this->belongsTo('App\Models\TransactionFlag', 'transaction_flag_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'transaction_id', 'id');
    }
}
