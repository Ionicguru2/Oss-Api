<?php namespace App\Http\Controllers\api\v1;

use App\Models\Category;
use Auth;
use Config;
use Storage;
use App\Models\Alert;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductMeta;
use App\Models\ProductFlag;
use App\Models\Permission;
use App\Models\ProductStatus;

class ProductController extends Controller {

    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    /**
     * The media extension contains the list of allowed photo extensions.
     *
     * @var Array
     */
    private $media_extensions;


    /**
     * The media path defines the path where product photos will be uploaded/retrieved.
     *
     * @var String
     */
    private $media_path;


    /**
     * The meta regex defines the pattern where all the meta keys start with.
     *
     * @var String
     */
    private $meta_regex;


    /**
     * The meta keyword identifier is the pattern that is begining of all the keys.
     *
     * @var String
     */
    private $meta_keyword;


    function __construct()
    {
        $this->media_extensions = Config::get('oss.product.media.extensions');
        $this->media_path = Config::get('oss.product.media.path');
        $this->meta_keyword = Config::get('oss.meta_keyword_identifier');
        $this->meta_regex = '/^' . $this->meta_keyword . '/';
        $this->current_user = Auth::getUser();
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::with([ 'user', 'status', 'country', 'category', 'media', 'meta', 'flags', 'country.region' ])->orderBy('created_at', 'DESC')->get();
        return $products->toArray();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
        $title = $request->input('title');
        $type = $request->input('type');
        $sku = $request->input('sku');
        $details = $request->input('details');
        $price = floatval($request->input('price'));
        $available_from = $request->input('available_from');
        $available_to = $request->input('available_to');
        $category_id = $request->input('category_id');
        $country_id = $request->input('country_id');
        $certification = $request->input('certification');

        $product_meta = $this->_get_product_meta($request);

        $images = $request->file('images');

        // this will go through every uploaded images and match the extensions with OSS.product.media.extensions
        if(count($images)) {
            foreach($images as $image) {
                if(array_search($image->getClientOriginalExtension(), $this->media_extensions) === false) {
				  return $this->prepareResponse('BAD_IMAGE_FORMAT');
                }
            }
        }

        if(!$available_from || !$available_to)
			return $this->prepareResponse('DATE_REQUIRED');

        $dates['from'] = $this->_format_date($available_from);
        $dates['to'] = $this->_format_date($available_to);

        if($dates['from']->gt($dates['to']))
			return $this->prepareResponse('DATES_INVALID');

        $status = ProductStatus::where('name', '=','created')->first();

        $category = Category::find($category_id);
        if(count($category->children))
            return $this->prepareResponse('CATEGORY_INVALID');

        if($title && $type && $sku && $details &&
            $price &&
            $category_id && $country_id ) {

            $product = Product::create([
                'title'             => $title,
                'type'              => $type,
                'sku'               => $sku,
                'details'           => $details,
                'price'             => $price,
                'available_from'    => $dates['from'],
                'available_to'      => $dates['to'],
                'user_id'           => $this->current_user->id,
                'status_id'         => $status->id,
                'country_id'        => $country_id,
                'category_id'       => $category_id,
                'certification'     => $certification
            ]);

            if($product) {

                // will store product media
                if(count($images)) {
                    $i = 1;
                    foreach($images as $image) {

                        $file_name =  $this->_get_filename() .'.' . $image->getClientOriginalExtension();
                        $s3 = Storage::disk('s3');
                        $filePath = $this->media_path . $file_name;
                        $s3->put($filePath, file_get_contents($image), 'public');

                        ProductMedia::create([
                            'path'          => $file_name,
                            'order'         => $i++,
                            'product_id'    => $product->id
                        ]);
                    }
                }

                // will store the product meta
                if($product_meta) {
                    foreach($product_meta as $key => $value) {
                        ProductMeta::create([
                            'key'           => $key,
                            'value'         => $value,
                            'product_id'    => $product->id
                        ]);
                    }
                }

                if($this->current_user->can('create_post')){
                    $posted = ProductStatus::where('name', '=', 'posted')->first();
                    $product->status_id = $posted->id;
                    $product->save();

                    $product->meta;
                    $product->media;
                    $product->flags;
                    return $product->toArray();

                } else{
                    $this->_ask_authorization($product);
					return $this->prepareResponse('product.NOT_AUTHORIZED_THIRD_PARTY');

                }
            } else {

					return $this->prepareResponse('BAD_REQUEST');
            }
        } else {
				return $this->prepareResponse('BAD_REQUEST');
        }

	}

    /**
     * Creates a authorization request.
     *
     * @return null
     */
    public function authorize($id)
    {
        $product = $this->_get_product($id, 'authorize_post');
        $posted = ProductStatus::where('name', '=', 'posted')->first();

        if($product->status->name == 'created' || $product->status->name == 'posted') {
            $product->status_id = $posted->id;
            $product->save();

            return $product->toArray();
        }
        else{
            return $this->prepareResponse('product.NOT_AUTHORIZED_POST');
        }
    }

    /**
     * Creates a authorization request.
     *
     * @return null
     */
    private function _ask_authorization()
    {

        Alert::create([

        ]);
    }


	/**
	 * Adds a flag to the given product
	 *
	 * @return Response
	 */
	public function add_flag($id, $identifier)
	{
        $product = $this->_get_product($id, 'remove_flag');

        if($product->user->id != $this->current_user->id)
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($identifier == 'expiring_soon' || $identifier == 'discounted' || $identifier == 'offerspending')
            return $this->prepareResponse('flag.NO_ADD_FLAG');
        $flag = ProductFlag::where('identifier', '=', $identifier)->first();

        if(!$flag)
            return $this->prepareResponse('flag.NOT_FOUND');
        if ($product->has_flag($identifier)) {
            return $this->prepareResponse('flag.ALREADY_ATTACHED');
        }

        $product->flags()->attach($flag->id);
        return $product->toArray();
	}


    /**
     * Removes a flag from the given product.
     *
     * @return Response
     */
    public function remove_flag($id, $identifier)
    {
        $product = $this->_get_product($id, 'remove_flag');
        $flag = ProductFlag::where('identifier', '=', $identifier)->first();

        if($product->user->id != $this->current_user->id)
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($identifier == 'expiring_soon' || $identifier == 'discounted' || $identifier == 'offerspending')
            return $this->prepareResponse('flag.CANT_REMOVE');

        if(!$flag)
            return $this->prepareResponse('flag.NOT_FOUND');

        if (!$product->has_flag($identifier)) {
            return $this->prepareResponse('flag.NOT_ATTACHED');
        }

        $product->flags()->detach($flag->id);
        return $product->toArray();
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $product = Product::with([ 'user', 'status', 'country', 'category', 'media', 'meta', 'flags'])
            ->where('id', '=', $id)->first();

        if(!$product){
            return $this->prepareResponse('product.NOT_FOUND_ER');
        }

        return $product->toArray();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
        $product = $this->_get_product($id, 'update_post');

        $title = $request->input('title');
        $type = $request->input('type');
        $sku = $request->input('sku');
        $details = $request->input('details');
        $price = floatval($request->input('price'));
        $available_from = $request->input('available_from');
        $available_to = $request->input('available_to');
        $category_id = $request->input('category_id');
        $country_id = $request->input('country_id');
        $certification = $request->input('certification');

        $product_meta = $this->_get_product_meta($request);

        $images = $request->file('images');

        // this will go through every uploaded images and match the extensions with OSS.product.media.extensions
        if(count($images)) {
            foreach($images as $image) {
                if(array_search($image->getClientOriginalExtension(), $this->media_extensions) === false) {
                    return $this->prepareResponse('BAD_IMAGE_FORMAT');
                }
            }
        }

        if($product_meta) {
            foreach( $product_meta as $key => $value ) {
                $meta = ProductMeta::where('product_id', '=', $product->id)
                    ->where('key', '=', $key)->first();

                if($meta) {
                    $meta->value = $value;
                    $meta->save();
                } else {
                    ProductMeta::create([
                        'key'           => $key,
                        'value'         => $value,
                        'product_id'    => $product->id
                    ]);
                }

            }
        }

        // will store product media
        if(count($images)) {

            $image = ProductMedia::where('product_id', '=', $product->id)->orderBy('order', 'DESC')->first();

            if($image)
                $i = $image->order;
            else
                $i = 0;

            foreach($images as $image) {
                $file_name =  $this->_get_filename() .'.' . $image->getClientOriginalExtension();
                $image->move(public_path() . $this->media_path, $file_name );

                ProductMedia::create([
                    'path'          => $file_name,
                    'order'         => ++$i,
                    'product_id'    => $product->id
                ]);
            }
        }

        if($available_from)
            $dates['from'] = $this->_format_date($available_from);
        else
            $dates['from'] = $this->_format_date($product->available_from);

        if($available_to)
            $dates['to'] = $this->_format_date($available_to);
        else
            $dates['to'] = $this->_format_date($product->available_to);

        if($dates['from']->gt($dates['to']))
            return $this->prepareResponse('DATES_INVALID');

        if($product->status->name == 'created' || $product->status->name == 'posted') {

            $product->available_from = $dates['from'];

            $product->available_to = $dates['to'];

            if($product->title != $title && $title)
                $product->title = $title;

            if($product->type != $type && $type)
                $product->type = $type;

            if($product->sku != $sku && $sku)
                $product->sku = $sku;

            if($product->details != $details && $details)
                $product->details = $details;

            if($product->price != $price && $price)
                $product->price = $price;

            if($product->category_id != $category_id && $category_id)
                $product->category_id =  $category_id;

            if($product->country_id != $country_id && $country_id)
                $product->country_id =  $country_id;

            if($product->certification != $certification && $certification)
                $product->certification =  $certification;

            $product->save();

            return $product->toArray();
        }
        else{
			return $this->prepareResponse('product.NOT_AUTHORIZED_POST_UPDATE');
        }
	}

    public function remove_image($id)
    {
        $product_media = ProductMedia::find($id);

        if(!$product_media)
            return $this->prepareResponse('product.MEDIA_NOT_FOUND');

        if($this->current_user->id != $product_media->product->user_id)
            if(!$this->current_user->can('super_remove_images'))
                return $this->prepareResponse('product.NOT_AUTHORIZED_POST_UPDATE');

        $image_path = $this->media_path . $product_media->getOriginal('path');
        if(Storage::disk('s3')->exists($image_path))
            Storage::disk('s3')->delete($image_path);

        $product_media->delete();
        return $this->prepareResponse('product.MEDIA_REMOVED');
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $product = $this->_get_product($id, 'delete_post');

        if($product->user_id != $this->current_user->id)
            if(!$this->current_user->can('super_remove_post'))
			    return $this->prepareResponse('NOT_AUTHORIZED');

        $product->delete();
        return $this->prepareResponse('product.DELETED');
	}


    private function _get_product($id, $permission)
    {
        if(!$this->current_user->can($permission))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $product = Product::find($id);

        if(!$product)
           return $this->prepareResponse('flag.NOT_FOUND');

        return $product;
    }


    private function _get_product_meta($request)
    {
        $all = $request->all();
        $meta = [];

        foreach($all as $param => $value)
        {
            if(preg_match($this->meta_regex, $param)){
                //$key = str_replace([$this->meta_keyword], '', $param);
                $meta[$param] = $value;
            }
        }

        return $meta;
    }

    private function _format_date($date)
    {
        try{
            return Carbon::createFromFormat(Config::get('oss.date_format'), $date);
        } catch(\InvalidArgumentException $e) {
            return $this->prepareResponse('DATES_INVALID');
        }
    }

    private function _get_filename( $length = 52 )
    {
        $filename = "";
        $crypt_allowed_code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $crypt_allowed_code.= "abcdefghijklmnopqrstuvwxyz";
        $crypt_allowed_code.= "0123456789_-";

        for($i=0; $i < $length ;$i++){
            $filename .= $crypt_allowed_code[ $this->_crypto_rand_secure( 0, strlen($crypt_allowed_code) ) ];
        }
        return $filename;
    }

    private function _crypto_rand_secure($min, $max) {
        $range = $max - $min;

        if ($range < 0) return $min;
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1;
        $bits = (int) $log + 1;
        $filter = (int) (1 << $bits) - 1;

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);

        return $min + $rnd;
    }

}
