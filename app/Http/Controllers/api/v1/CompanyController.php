<?php namespace App\Http\Controllers\api\v1;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Company;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class CompanyController extends Controller {

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if(!$this->current_user->can('view_company_list'))
			return $this->prepareResponse('NOT_AUTHORIZED');

        $companies = Company::with(['region'])->get();

        if(count($companies)) {
            foreach($companies as $company){
                $company['user_count'] = $company->user_counts();

                $transactions = 0;
                if($company->user_counts()) {
                    $users = $company->users();
                    foreach($users as $user){
                        $products = $user->products();
                        foreach($products as $product) {
                            $trans = Transaction::where('product_id', '=', $product->id)->count();
                            $transactions = $transactions + $trans;
                        }
                    }
                }

                $company['transaction_count'] = $transactions;
            }
        }

        return $companies->toArray();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $name = $request->input('name');
        $region_id = $request->input('region_id');

        if(!$this->current_user->can('create_company'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        if(!$name || !$region_id)
            return $this->prepareResponse('REQUIRED_VALUE_MISSING');


        $company = Company::create([
            'name' => $name,
            'region_id' => $region_id
        ]);

        return $company->toArray();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $company = $this->__get_company($id, 'view_company');
        return $company->toArray();
	}


    /**
     * Return the lost of user by given company ID
     * @param $id
     * @return mixed
     */
	public function users($id)
    {
        $company = $this->__get_company($id, 'view_company');
        $users = $company->users;
        $users->load('role');
        return $company->users->toArray();
    }


    public function products($id)
    {
        $company = $this->__get_company($id, 'super_list_post');

        $ids = [];

        foreach ($company->users as $user)
            array_push($ids, $user->id);

        $products = Product::whereIn('user_id', $ids)->get();

        $products->load('user');
        $products->load('category');
        $products->load('country');

        return $products->toArray();
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        $name = $request->input('name');
        $region_id = $request->input('region_id');

        $company = $this->__get_company($id, 'update_company');

        if($name)
            $company->name = $name;

        if($region_id)
            $company->region_id = $region_id;

        try {
            $company->save();

            $company->region;
            return $company->toArray();

        }catch (Exception $e){
             return $this->prepareResponse('BAD_REQUEST');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $company = $this->__get_company($id, 'delete_company');

        $company->delete();
        return $this->prepareResponse('company.COMPANY_DELETED');
	}

    private function __get_company($id, $operation)
    {
        if(!$this->current_user->can($operation))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $company = Company::find($id);

        if(!$company)
			return $this->prepareResponse('company.NOT_FOUND');

        return $company;
    }

}
