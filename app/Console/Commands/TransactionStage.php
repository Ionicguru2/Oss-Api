<?php namespace App\Console\Commands;

use Log;
use Config;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\TransactionFlag as Flag;
use App\Models\TransactionStage as Stage;
use App\Models\Alert;
use App\Models\Product;


class TransactionStage extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'transaction:cleanup';

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
        Log::info('The system everyday transaction maintenance process...Initiating....');

        $transactions = Transaction::with('product')->get();
        Log::info('Total transactions found: ' . count($transactions) );

        foreach ($transactions as $transaction) {

            $from = Carbon::createFromFormat('Y-m-d', $transaction->product['available_from']);
            $to = Carbon::createFromFormat('Y-m-d', $transaction->product['available_to']);
            $now = Carbon::now();

            $ongoing_stage = Stage::where('identifier', '=', 'ongoing')->first();

            if($transaction->enable){

                if($now->lt($from))
                    if($now->diffInDays($from) <= Config::get('oss.upcoming_days')){
                        $flag = Flag::where('flag', '=', 'Upcoming')->first();
                        $transaction->transaction_flag_id = $flag->id;
                    }


                if($now->gte($from) && $now->lte($to) && $transaction->transaction_stage_id != $ongoing_stage->id){
                    $flag = Flag::where('flag', '=', 'Ongoing')->first();
                    $transaction->transaction_flag_id = $flag->id;

                    
                    $transaction->transaction_stage_id = $ongoing_stage->id;

                    foreach ($transaction->users as $user)
                    {
                        $this->prepareAlert( $user, 'transaction.STARTED', $transaction->id );
                    }
                }

                if($now->gt($to)){
                    $transaction->transaction_flag_id = null;
                    $transaction->enable = false;

                    if($transaction->transaction_stage->identifier != 'rating'){
                        $stage = Stage::where('identifier', '=', 'expired')->first();
                        $transaction->transaction_stage_id = $stage->id;

                        foreach ($transaction->users as $user)
                        {
                            $this->prepareAlert( $user, 'transaction.ENDED', $transaction->id );
                        }
                    }
                }
            } 
            else 
            {
                $transaction_stage = Stage::where('identifier', '=', 'admin_approved')->first();

                if($now->lt($from) && $transaction->transaction_stage_id == $transaction_stage->id)
                {
                    $flag = Flag::where('flag', '=', 'Upcoming')->first();
                    $transaction->transaction_flag_id = $flag->id;
                }
                else if($now->gte($from) && $now->lte($to) && $transaction->transaction_stage_id == $transaction_stage->id)
                {
                    $flag = Flag::where('flag', '=', 'Ongoing')->first();
                    $transaction->transaction_flag_id = $flag->id;
                }
            }

            $transaction->save();
        }

        Log::info('The system everyday transaction maintenance process...Terminated....Bye.');
	}


    /**
     * This method is one of the most important of all.
     * The method will take a parameter and based on that,
     * it will create the JSON response and send it over.
     *
     * @param $message_code String ( A code that matches config/OSS.php )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function prepareAlert($user, $message_code, $type_id) {

        if($message_code && $user && $type_id)
        {

            // get alert type and message
            $type       = 'oss.alerts.' . $message_code . '.type';
            $message    = 'oss.alerts.' . $message_code . '.alert';
            $action     = 'oss.alerts.' . $message_code . '.action';

            // create Alert
            $alert = Alert::create([
                'type'      => Config::get($type),
                'message'   => Config::get($message),
                'user_id'   => $user->id,
                'type_id'   => $type_id,
                'action'    => $action
            ]);

            return $alert;
        }
        return false;
    }

}
