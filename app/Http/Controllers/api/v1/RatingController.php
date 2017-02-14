<?php namespace App\Http\Controllers\api\v1;

use App\Models\Alert;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\RatingRequired;
use App\Models\Transaction;
use App\Models\TransactionRating;
use App\Models\ProductStatus;
use Illuminate\Http\Request;

class RatingController extends Controller {

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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		$transaction_id = $request->input('transaction_id');
        $rating = $request->input('rating');

        if(!$rating || !$transaction_id)
            $this->prepareResponse('BAD_REQUEST');

        $rating = intval($rating);
        if($rating <= 0 || $rating >= 6)
            $this->prepareResponse('BAD_REQUEST');

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            $this->prepareResponse('transaction.NOT_FOUND');

        $client = null;
        foreach ( $transaction->users as $user)
            if($user->id != $this->current_user->id)
                $client = $user;

        $transaction_rating = TransactionRating::create([
                            'user_id'           => $client->id,
                            'transaction_id'    => $transaction->id,
                            'rating'            => $rating
                        ]);

        RatingRequired::where('user_id', '=', $this->current_user->id)
            ->where('transaction_id', '=', $transaction->id)
            ->delete();

        Alert::where('user_id', '=', $this->current_user->id)
            ->where('type', '=', 'rate')
            ->where('type_id', '=', $transaction->id)
            ->delete();

        $remain = RatingRequired::where('transaction_id', '=', $transaction->id)->first();

        if(!$remain){
            $rated = ProductStatus::where('name', '=', 'rated')->first();
            $transaction->product->status_id = $rated->id;
            $transaction->push();
        }

        return $transaction_rating->toArray();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
