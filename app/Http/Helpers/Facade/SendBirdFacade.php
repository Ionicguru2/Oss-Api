<?php namespace App\Http\Helpers\Facade;

use Illuminate\Support\Facades\Facade;

class SendBirdFacade extends Facade {

    protected static function getFacadeAccessor() { return 'sendbird'; }

}