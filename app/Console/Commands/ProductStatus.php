<?php namespace App\Console\Commands;

use Log;
use SendBird;
use Config;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\ProductFlag as Flag;
use App\Models\ProductStatus as Stages;
use App\Models\Product;
use App\Models\Transaction;


class ProductStatus extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'product:cleanup';

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
        Log::info('The system everyday Post maintenance process...Initiating....');

        $products = Product::get();
        Log::info('Total Posts found: ' . count($products) );

        foreach ($products as $product) {

            $from = Carbon::createFromFormat('Y-m-d', $product['available_from']);
            $to = Carbon::createFromFormat('Y-m-d', $product['available_to']);
            $now = Carbon::now();

            if($now->gt($from) && $now->lte($to))
                if($now->diffInDays($to) <= Config::get('oss.expiring_days')){
                    $flag = Flag::where('identifier', '=', 'expiring_soon')->first();
                    $product->flags()->attach($flag->id);
                }

            if($now->gt($to)){
                if($product->status->name == 'created' || $product->status->name == 'posted') {
                    $flag = Flag::where('identifier', '=', 'discounted')->first();
                    $product->flags()->attach($flag->id);

                    $status = Stages::where('name', '=', 'expired')->first();
                    $product->status_id = $status->id;
                    $product->save();
                }

                if($product->status->name == 'sold' && $product->status->name != 'rated') {
                    $status = Stages::where('name', '=', 'completed')->first();
                    $product->status_id = $status->id;
                    $product->save();
                }

                if($product->status->name == 'rated') {
                    $status = Stages::where('name', '=', 'archived')->first();
                    $product->status_id = $status->id;
                    $product->save();
                }

                // get all of the 
                $transactions = Transaction::where('product_id', '=', $product->id)->get();

                foreach ($transactions as $transaction)
                {
                    SendBird::channel_delete($transaction);
                }       

            }


        }

        Log::info('The system everyday Posts maintenance process...Terminated....Bye.');
	}

}
