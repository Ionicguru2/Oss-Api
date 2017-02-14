<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;

class Company extends Model {

    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'region_id'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];


    /**
     * The function will return the region of the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id', 'id');
    }


    /**
     * The function will return the list of users that are associated with the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'company_id', 'id');
    }


    /**
     * This function will return the number of users associated with the company.
     *
     * @return integer
     */
    public function user_counts()
    {
        return $this->users()->count();
    }


    /**
     * THe function will return all the list of transactions that are initiated by company/
     */
    public function trasactions()
    {
        $users = $this->users();

        if($users) {

            $i = 1;
            $ids = [];
            foreach($users as $user) {
                $ids[$i++] = $user['id'];
            }

            return $ids;

        }
    }
}
