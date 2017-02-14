<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model {

    /**
     * This property will disable the auto time-stamping.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contract_types';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];


    /**
     * The property will return all the contracts with this type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany('App\Models\Contract', 'contract_id', 'id');
    }
}
