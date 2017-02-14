<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionFlag extends Model {

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
    protected $table = 'transaction_flags';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['flag', 'transaction_id'];

}
