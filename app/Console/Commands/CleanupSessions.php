<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Log;
use Config;
use Carbon\Carbon;
use App\Models\Session;

class CleanupSessions extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'session:cleanup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command will wipe-out all the sessions that are older then specified period.';

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
        Log::info('The system everyday session cleaning process...Initiating....');

        if (Config::get('oss.demo.enabled')){
            Log::info('The system demo mode is enabled....By passing...');
            Log::info('The system everyday session cleaning process...Terminated....Bye.');
            exit(0);
        }

        $sessions = Session::all();
        Log::info('Total session(s) found: ' . count($sessions) );

        $cleared = 0;
        foreach ($sessions as $session) {
            $session_date = Carbon::createFromFormat('Y-m-d H:i:s',$session->created_at);
            $now_date = Carbon::now();

            if($now_date->diffInHours($session_date) > Config::get('oss.session_hours')) {
                Session::where('user_id', '=', $session->user_id)
                    ->where('rest_token', '=', $session->rest_token)
                    ->delete();
                $cleared += 1;
            }
        }

        Log::info('Total session(s) cleared: ' . $cleared );
        Log::info('The system everyday session cleaning process...Terminated....Bye.');
	}

}
