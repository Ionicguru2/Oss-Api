<?php namespace App\Http\Controllers\api\v1;

use Auth;
use SendBird;
use Mandrill;
use Mail;
use Config;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Offer;
use App\Models\ProductFlag;
use App\Models\ProductStatus;
use App\Models\Transaction;
use App\Models\TransactionStage;
use App\Models\Alert;
use App\Models\TransactionFlag as Flag;

class OfferController extends Controller {

    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    /**
     * Constructor will initialize the class with basic properties.
     */
    public function __construct()
    {
        $this->current_user = Auth::getUser();
    }


    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id, Request $request)
	{
        $product = Product::find($id);

        if(!$product)
			 return $this->prepareResponse('product.NOT_FOUND_ER');

        if(!($product->status->name == 'created'
            || $product->status->name == 'posted'
            || $product->status->name == 'offer'))
            return $this->prepareResponse('offer.NO_OFFER');

        $owner = $product->user;

        if($owner->id == $this->current_user->id)
			 return $this->prepareResponse('product.OWN_PRODUCT_OFFER_ERR');

        $offer = Offer::where('product_id', '=', $product->id)->where('user_id', '=', $this->current_user->id)->first();

        if($offer){
            if($offer->enable_owner && $offer->enable_user){
                return $this->prepareResponse('product.PRODUCT_OFFER_MADE_ALREADY_ERR');
            } else {
                $offer->delete();
                $transaction_stage = TransactionStage::where('identifier', '=', 'expired')->first();
                $transaction = $offer->transaction()->first();
                $transaction->enable = false;
                $transaction->transaction_stage_id = $transaction_stage->id;
                $transaction->save();
            }

        }

        $offer = Offer::create([
            'product_id'    => $product->id,
            'user_id'       => $this->current_user->id,
            'accepted'      => null,
            'confirmed'     => null,
            'enable_user'  => true,
            'enable_owner'  => true
        ]);


        $offer->update([ 'accepted' => null,  'confirmed' => null, 'enable_user' => true, 'enable_owner' => true ]);

        $this->prepareAlert($this->current_user->id, 'offer.AWAITING_APPROVAL', $offer->id);
        $this->prepareAlert($owner->id, 'offer.OFFER_MADE', $offer->id);

        $transaction_offer = TransactionStage::where('identifier', '=', 'offer_stage')->first();

        try {
            $transaction = Transaction::create([
                'product_id'            => $product->id,
                'offer_id'              => $offer->id,
                'enable'                => true,
                'transaction_stage_id'  => $transaction_offer->id,
                'transaction_flag_id'   => null,
                'sendbird_name'         => null,
                'sendbird_url'          => null
            ]);

            $transaction->users()->attach($owner->id);
            $transaction->users()->attach($this->current_user->id);

            SendBird::create_chennel($transaction);

        } catch (QueryException $e) {
            return $this->prepareResponse('BAD_REQUEST');
        }

        $posted = ProductStatus::where('name', '=', 'posted')->first();
        $status = ProductStatus::where('name', '=', 'offer')->first();

        if(!$status)
			return $this->prepareResponse('status.NOT_FOUND_ER');

        if($product->status_id == $posted->id)
            $product->status_id = $status->id;

        $flag = ProductFlag::where('identifier', '=', 'offerspending')->first();

        if(!$flag)
			return $this->prepareResponse('flag.NOT_FOUND_ER');

        $product->flags()->attach($flag->id);
        $product->save();

        return $offer->toArray();
	}

    public function deny($id)
    {
        $offer = Offer::find($id);

        if(!$offer)
            return $this->prepareResponse('offer.NOT_FOUND_ER');

        $product = Product::find($offer->product_id);

        if(!$product)
            return $this->prepareResponse('product.NOT_FOUND_ER');

        $owner = $product->user;

        if($owner->id != $this->current_user->id && $offer->user_id != $this->current_user->id)
            return $this->prepareResponse('NOT_AUTHORIZED');


        // the owner of the product is rejectign the offer placed on it
        if($owner->id == $this->current_user->id) {
            if(!$offer->enable_owner)
                return $this->prepareResponse('CANT_REDO');

            $offer->accepted = false;
            $offer->enable_owner = false;

            $this->prepareAlert($this->current_user->id, 'offer.SENT_DENIED', $offer->id);
            $this->prepareAlert($offer->user_id, 'offer.DENIED', $offer->id);
        }

        // the person making the offer has rejected the confirmation of the offer placed
        if($offer->user_id == $this->current_user->id) {

            if(!$offer->enable_user)
                return $this->prepareResponse('CANT_REDO');

            $offer->confirmed = false;
            $offer->enable_user = false;
            $this->prepareAlert($offer->user_id, 'offer.SENT_DENIED_CONFIRMED', $offer->id);
            $this->prepareAlert($owner->id, 'offer.DENIED_CONFIRMED', $offer->id);
        }

        $offer->save();

        $transaction_stage = TransactionStage::where('identifier', '=', 'expired')->first();
        $transaction = $offer->transaction()->first();
        $transaction->enable = false;
        $transaction->transaction_stage_id = $transaction_stage->id;
        $transaction->save();

        $disabled = Transaction::where('product_id', '=', $offer->product_id)
            ->where('enable', '=', true)->get();

        SendBird::channel_delete($offer->transaction);

        if(!count($disabled)){
            $posted = ProductStatus::where('name', '=', 'posted')->first();
            $offer->product->status_id = $posted->id;
            $offer->push();

            $flag = ProductFlag::where('identifier', '=', 'offerspending')->first();
            $offer->product->flags()->detach($flag->id);
        }

        $offer->delete();
        return $offer->toArray();
    }

    public function approve($id)
    {
        $offer = Offer::find($id);

        if(!$offer)
            return $this->prepareResponse('offer.NOT_FOUND_ER');

        $product = Product::find($offer->product_id);

        if(!$product)
            return $this->prepareResponse('product.NOT_FOUND_ER');

        $owner = $product->user;

        if($owner->id != $this->current_user->id && $offer->user_id != $this->current_user->id)
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($owner->id == $this->current_user->id) {
            if(!$offer->enable_owner)
                return $this->prepareResponse('CANT_REDO');

            $offer->accepted = true;
            $offer->enable_owner = false;
            $offer->save();

            $this->prepareAlert( $offer->user_id, 'offer.APPROVED', $offer->id );
            $this->prepareAlert( $owner->id, 'offer.AWAITING_CONFIRMATION', $offer->id );
        }

        if($offer->user_id == $this->current_user->id) {

            if (!$offer->enable_owner && !$offer->accepted)
                return $this->prepareResponse('offer.OFFER_DENIED');

            if(!$offer->enable_user)
                return $this->prepareResponse('CANT_REDO');

            $offer->confirmed = true;
            $offer->enable_user = false;

            $this->prepareAlert($owner->id, 'offer.CONFIRMED', $offer->id );
        }

        if(!$offer->enable_user && !$offer->enable_owner)
        {

            if($offer->transaction->validation)
            {
                $transaction_offer = TransactionStage::where('identifier', '=', 'validation_pending')->first();
            }
            else
            {
                $transaction_offer = TransactionStage::where('identifier', '=', 'pending_admin_approval')->first();

                Mandrill::send_email(array('address' => Config::get('oss.mandrill.emails.admin.email'), 'name' => Config::get('oss.mandrill.emails.admin.name')),

                            'emails.alerts.offer.ADMIN_AWAITING_APPROVAL', 

                            [ 'subject' => 'An offer is awaiting validation by administrators', 'offer' => $offer ]);
           
            }
        } 
        else 
        {
            $transaction_offer = TransactionStage::where('identifier', '=', 'buyer_seller_approved')->first();
        }

        $offer->transaction->transaction_stage_id = $transaction_offer->id;
        $offer->push();

        $offer->load('transaction.transaction_flag');
        $offer->load('transaction.transaction_stage');
        return $offer->toArray();
    }

    public function show($id)
    {
        $offer = Offer::with(['product', 'transaction', 'transaction.users' ])->where('id', '=', $id)->first();

        if(!$offer)
            return $this->prepareResponse('offer.NOT_FOUND_ER');

        $product = Product::find($offer->product_id);

        if(!$product)
            return $this->prepareResponse('BAD_REQUEST');
        
        if($product->user_id != $this->current_user->id &&  $this->current_user->id != $offer->user_id)
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($product->user_id == $this->current_user->id)
            $offer->user;

        $alert = Alert::where('user_id', '=', $this->current_user->id)
            ->where('type', '=', 'offer')
            ->where('type_id', '=', $offer->id)
            ->where('seen', '=', 0)
            ->first();

        if($alert){
            $alert->seen = true;
            $alert->save();
        }

        return $offer->toArray();
    }
}
