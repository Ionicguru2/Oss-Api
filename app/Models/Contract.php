<?php namespace App\Models;

use File;
use Config;
use Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

class Contract extends Model {

    /**
     * This trait will allow user to soft-delete the resource.
     */
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contracts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'size', 'path', 'user_id', 'contract_type_id', 'parent_id'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];


    /**
     * The property will return the type of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract_type()
    {
        return $this->belongsTo('App\Models\ContractType', 'contract_type_id', 'id');
    }


    /**
     * The property will return the belonging user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }


    /**
     * The property will return all the children of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Contract', 'parent_id', 'id')->orderBy('contract_type_id');
    }


    /**
     * The property will return the parent resource.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Contract', 'parent_id', 'id');
    }


    public function transactions()
    {
        return $this->belongsToMany('App\Models\Transaction', 'contracts_transactions', 'contract_id', 'transaction_id');
    }


    public function getPathAttribute($path)
    {
        $contract_path = Config::get('oss.contract.document.path') . $path;

        if (Storage::disk('s3')->exists($contract_path))
            return Storage::disk('s3')->getDriver()->getAdapter()->getClient()->getObjectUrl(env('AMAZON_S3_BUCKET'), $contract_path);
        else
            return '';
    }

}
