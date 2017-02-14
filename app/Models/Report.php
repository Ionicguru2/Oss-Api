<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'user_id', 'report_type_id'];


    public function report_type()
    {
        return $this->belongsTo('App\Models\ReportType', 'report_type_id', 'id');
    }

}
