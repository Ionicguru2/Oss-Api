<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\CleanupSessions',
		'App\Console\Commands\TransactionStage',
		'App\Console\Commands\ProductStatus',
		'App\Console\Commands\UserSession',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
//		$schedule->command('inspire')
//				 ->hourly();
//
//        // Clean up will run daily at midnight
//        $schedule->command('session:cleanup')
//            ->daily();
//
//        // Create proper transaction tags and stages.
//        $schedule->command('transaction:cleanup')
//            ->daily();
//
//        // Create proper product tags and stages.
//        $schedule->command('product:cleanup')
//            ->daily();
//
//        // Create proper product tags and stages.
//        $schedule->command('user:online')
//            ->everyFiveMinutes();
    }

}
