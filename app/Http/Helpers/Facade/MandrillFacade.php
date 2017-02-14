<?php namespace App\Http\Helpers\Facade;

use Illuminate\Support\Facades\Facade;

class MandrillFacade extends Facade {

    protected static function getFacadeAccessor() { return 'mandrill'; }

}