<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionStage extends Model {

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
    protected $table = 'transaction_stages';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'identifier'];

}
