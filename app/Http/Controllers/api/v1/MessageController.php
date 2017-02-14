<?php namespace App\Http\Controllers\api\v1;

use App\Models\Contract;
use App\Models\User;
use Auth;
use SendBird;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MessageController extends Controller {


    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    public function __construct()
    {
        $this->current_user = Auth::getUser();
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $channels = SendBird::list_channel($this->current_user);

        if(count($channels)){
            foreach ( $channels as $key => $channel ) {
                if ( count($channel['members']) < 2)
                    unset($channels[$key]);

                if (count($channel['members']) == 2) {
                    foreach ( $channel['members'] as $member ) {
                        if ( $member['id'] != $this->current_user->id)
                            $channels[$key]['user'] =  User::find(intval($member['id']))->toArray();
                    }
                }
            }

        }

        $clean_list = array();
        foreach ($channels as $key => $resp)
        {
            if (!$transaction = Transaction::where('sendbird_url', '=', $resp['channel_url'])->first())
               continue;

            $resp['transaction_id'] = $transaction->id;
            $clean_list[] = $resp;
        }

        return $clean_list;
	}

	/**
	 * This function performs sending text messages.
	 *
	 * @return Response
	 */
	public function message(Request $request)
	{
        $transaction_id = $request->input('transaction_id');
        $message = $request->input('message');
        $transaction_user = false;

		$transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('transaction.DISABLED');

        foreach($transaction->users as $user){
            if($user->id == $this->current_user->id)
                $transaction_user = true;
        }

        if(!$transaction_user)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $message = trim($message);
        if(!$message && $message == '')
            return $this->prepareResponse('BAD_REQUEST');

        $response = SendBird::send_message($transaction, $this->current_user, $message);

        return $response;
	}


	public function invite($id)
    {
        $transaction = Transaction::find($id);

        $data  = SendBird::invite_users($transaction);
        return $data;
    }


    public function contract(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $contract_id = $request->input('contract_id');
        $transaction_user = false;

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('transaction.DISABLED');

        foreach($transaction->users as $user){
            if($user->id == $this->current_user->id)
                $transaction_user = true;
        }

        if(!$transaction_user)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $contract = Contract::find($contract_id);

        if(!$contract)
            return $this->prepareResponse('document.NOT_FOUND');


        if($contract->user_id != $this->current_user->id)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $response = SendBird::send_file($transaction, $contract, $this->current_user);

        if(!$response)
            $transaction->contracts()->attach($contract->id);

        return $response;

    }


    public function channel(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $unread         = $request->input('unread_messages');

        $transaction_user = false;

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('transaction.DISABLED');

        foreach($transaction->users as $user){
            if($user->id == $this->current_user->id)
                $transaction_user = true;
        }

        if(!$transaction_user)
            return $this->prepareResponse('NOT_AUTHORIZED');


        $response = SendBird::read_messages($transaction, $unread ? $unread : 1);

        return $response;
    }


    public function refresh(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $message_id = $request->input('message_id');

        $transaction_user = false;

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('transaction.DISABLED');

        foreach($transaction->users as $user){
            if($user->id == $this->current_user->id)
                $transaction_user = true;
        }

        if(!$transaction_user)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $response = SendBird::refresh($transaction, $message_id);

        return $response;
    }

    public function open(Request $request)
    {
        $transaction_id = $request->input('transaction_id');

        $transaction_user = false;

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('transaction.DISABLED');

        foreach($transaction->users as $user){
            if($user->id == $this->current_user->id)
                $transaction_user = true;
        }

        if(!$transaction_user)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $response = SendBird::open_chat($transaction);

        return response()->json($response);
    }


    public function reload(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $message_id = $request->input('message_id');

        $transaction_user = false;

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('transaction.DISABLED');

        foreach($transaction->users as $user){
            if($user->id == $this->current_user->id)
                $transaction_user = true;
        }

        if(!$transaction_user)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $response = SendBird::reload_chat($transaction, $message_id);

        return $response;
    }


}
