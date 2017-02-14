<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model {

    public  $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'report_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type'];


    public function reports()
    {
        return $this->hasMany('App\Models\Report', 'report_type_id', 'id');
    }

}
