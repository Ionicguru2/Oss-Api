<?php namespace App\Console\Commands;

use Log;
use Config;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Session;
use App\Models\User;


class UserSession extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:online';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command will filter all the transaction and attach proper tags.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

        $users = User::online()->get();

        foreach ($users as $user)
        {
            $online = false;
            foreach ($user->session as $session){
                $last_activity = Carbon::createFromTimestamp($session->last_activity);
                $now = Carbon::now();

                if($last_activity->lt($now) &&
                    $last_activity->diffInMinutes($now) < Config::get('oss.session_online_expired')) {
                    $online = true;
                }
            }
            $user->update([ 'online' => $online ]);
        }

	}

}
