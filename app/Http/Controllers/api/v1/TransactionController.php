<?php namespace App\Http\Controllers\api\v1;

use App\Models\ProductStatus;
use Auth;
use SendBird;
use Mandrill;
use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;
use App\Models\RatingRequired;
use App\Models\Transaction;
use App\Models\TransactionStage;
use App\Models\Company;
use Carbon\Carbon;
use App\Models\TransactionFlag as Flag;

class TransactionController extends Controller {

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
	 * Display a listing of the transaction for the current user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $transaction_stage = TransactionStage::where('identifier', '=', 'expired')->first();

		$transactions = Transaction::with([ 'transaction_flag', 'transaction_stage', 'users', 'product', 'product.user', 'product.category', 'product.country'])
            ->where('transaction_stage_id', '!=', $transaction_stage->id)
            ->orderBy('created_at', 'ASC')->get();

        return $transactions->toArray();
	}

	/**
     * Display a listing of the transaction for the specified user.
	 *
     * @param  int  $id ( user_id )
	 * @return Response
	 */
	public function user($id)
	{
        // If the user is not authorized to list other user's trnasactions.
        if(!$this->current_user->can('super_list_transaction'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $user = User::find($id);

        if(!$user)
            return $this->prepareResponse('user.NOT_FOUND');

        $transaction_stage = TransactionStage::where('identifier', '=', 'expired')->first();

        $transactions = $user->transactions()->with([ 'transaction_flag', 'transaction_stage', 'users', 'product'])
            ->where('transaction_stage_id', '!=', $transaction_stage->id)
            ->orderBy('enable', 'ASC')->orderBy('created_at', 'ASC')->get();

        return $transactions->toArray();
    }


    public function show($id)
    {
        $transaction = Transaction::with([ 'users', 'product', 'transaction_flag', 'transaction_stage' ])->where('id', '=', $id)->first();

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        return $transaction->toArray();

    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$transaction = Transaction::find($id);
        $transaction_user = false;

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

        if(!$transaction->enable)
            return $this->prepareResponse('RE_DO');

        $transaction->enable = false;
        $transaction->save();

        foreach ($transaction->users as $user){
            RatingRequired::create([ 'user_id' => $user->id, 'transaction_id' => $transaction->id ]);
            $this->prepareAlert($user->id, 'transaction.RATE', $transaction->id);
        }

        return $transaction->toArray();
	}

    public function require_validation($id)
    {
        $transaction = Transaction::find($id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        foreach ($transaction->users as $user)
            if($user->id == $this->current_user->id){
                $id = $user->id;
                $allowed = true;
            }

        if(!$allowed)
            return $this->prepareResponse('NOT_AUTHORIZED');

        $transaction->validation = true;
        $transaction->save();

        $transaction->users()->updateExistingPivot($id, [ 'validation_request' => true ], false);

        Mandrill::send_email(array('address' => Config::get('oss.mandrill.emails.admin.email'), 'name' => Config::get('oss.mandrill.emails.admin.name')),
                            'emails.alerts.offer.ADMIN_AWAITING_VALIDATION', 
                            [ 'subject' => 'An offer is awaiting validation by administrators', 'offer' => $transaction->offer ]);


        $transaction->load('transaction_stage');
        $transaction->load('transaction_flag');

        return $transaction->toArray();
    }

    public function validated($id)
    {
        $transaction = Transaction::find($id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$this->current_user->can('super_validate'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($transaction->transaction_stage->identifier != 'validation_pending')
            return $this->prepareResponse('transaction.OPERATION_FAILED');

        $stage = TransactionStage::where('identifier', '=', 'pending_admin_approval')->first();
        $transaction->transaction_stage_id = $stage->id;
        $transaction->validation = false;
        $transaction->save();

        foreach ($transaction->users as $user)
        {
            $this->prepareAlert($user->id, 'transaction.VALIDATION_SUCCESS', $transaction->id);
        }

        $transaction->load('transaction_flag');
        $transaction->load('transaction_stage');
        return $transaction->toArray();
    }

    public function validation_failed($id)
    {
        $transaction = Transaction::find($id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$this->current_user->can('super_validate'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($transaction->transaction_stage->identifier != 'validation_pending')
            return $this->prepareResponse('transaction.OPERATION_FAILED');

        $stage = TransactionStage::where('identifier', '=', 'expired')->first();
        $transaction->transaction_stage_id = $stage->id;
        $transaction->validation = false;
        $transaction->enable = false;
        $transaction->save();

        foreach ($transaction->users as $user)
        {
            $this->prepareAlert($user, 'transaction.VALIDATION_FAILED', $transaction->id);
        }

        $transaction->load('transaction_flag');
        $transaction->load('transaction_stage');
        return $transaction->toArray();
    }


	public function approve($id)
    {
        if(!$this->current_user->can('super_approve_transaction'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $transaction = Transaction::find($id);
        $transaction->load('product');

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('CANT_REDO');

        if($transaction->validation)
            return $this->prepareResponse('transaction.VALIDATION');

        if($transaction->transaction_stage->identifier != 'pending_admin_approval')
            return $this->prepareResponse('transaction.OPERATION_FAILED');

        $transaction_stage = TransactionStage::where('identifier', '=', 'admin_approved')->first();

        $transaction->transaction_stage_id = $transaction_stage->id;

        $from = Carbon::createFromFormat('Y-m-d', $transaction->product['available_from']);
        $to = Carbon::createFromFormat('Y-m-d', $transaction->product['available_to']);
        $now = Carbon::now();

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

        foreach ($transaction->users as $user)
        {
            $this->prepareAlert($user->id, 'transaction.APPROVED', $transaction->id);
        }

        $status = ProductStatus::where('name', '=', 'sold')->first();
        $transaction->product->status_id = $status->id;
        $transaction->push();

        foreach ($transaction->users as $user)
            Mandrill::send_user_email($user, 'emails.alerts.transaction.APPROVED',
                [   'subject' => 'Offer has been approved by administrators',
		    'build_from_oss_config' => false,
                    'transaction'=>$transaction,
		    'user' => $user,
                    'offer' => $transaction->offer ]);

        $transaction->load('transaction_stage');
        $transaction->load('transaction_flag');
        return $transaction->toArray();

    }


    public function deny($id)
    {
        if(!$this->current_user->can('super_deny_transaction'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $transaction = Transaction::find($id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND');

        if(!$transaction->enable)
            return $this->prepareResponse('CANT_REDO');

        if($transaction->transaction_stage->identifier != 'pending_admin_approval')
            return $this->prepareResponse('transaction.OPERATION_FAILED');

        $transaction_stage = TransactionStage::where('identifier', '=', 'admin_denied')->first();

        foreach ($transaction->users as $user)
        {
            $this->prepareAlert($user, 'transaction.DENIED', $transaction->id);
        }

        $transaction->enable = false;
        $transaction->transaction_stage_id = $transaction_stage->id;
        $transaction->save();

        return $transaction->toArray();
    }


	public function company($id)
    {
        $company = Company::find($id);

        if(!$company)
            return $this->prepareResponse('company.NOT_FOUND');

        $users = $company->users()->select('id')->get();

        $ids = [];
        if(count($users))
            foreach ($users as $user)
                array_push($ids, $user['id']);


        $transactions = Transaction::with([ 'transaction_stage', 'users', 'product' ])->join('transactions_users', 'transactions.id', '=', 'transactions_users.transaction_id')
            ->whereIn('transactions_users.user_id', $ids)->groupBy('transactions_users.transaction_id')
            ->orderBy('transactions.enable', 'ASC')->orderBy('transactions.created_at', 'ASC')->get();

        return $transactions->toArray();
    }

}
