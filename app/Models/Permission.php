<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'description'];


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'roles_permissions', 'role_id', 'permission_id');
    }
}
