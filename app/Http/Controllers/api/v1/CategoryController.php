<?php namespace App\Http\Controllers\api\v1;

use Auth;
use Config;
use Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\CategoryImage;

class CategoryController extends Controller {

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


    public function __construct()
    {
        $this->current_user = Auth::getUser();
        $this->media_extensions = Config::get('oss.category.media.extensions');
        $this->media_path = Config::get('oss.category.media.path');
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $categories = Category::with('category_images')->get();
        return $categories->toArray();
	}

    public function main()
    {
        $categories = Category::with('category_images')
            ->whereNull('parent_id')
            ->orWhere('parent_id', '=', 1)
            ->orderBy('id')
            ->get();

        return $categories->toArray();
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = Category::with([ 'category_images', 'children', 'children.category_images' ])->where('id', '=', $id)->first();

        if(!$category)
            return $this->prepareResponse('category.NOT_FOUND_ER');


        return $category->toArray();
	}

    public function parent($id)
    {
        $child = Category::where('id', '=', $id)->first();

        if(!$child)
            return $this->prepareResponse('category.NOT_FOUND_ER');

        $parent = Category::with('category_images')->where('id', '=', $child->parent_id)->first();

        if(!$parent)
            return $this->prepareResponse('category.NO_PARENT_ER');

        return $parent->toArray();


    }

    public function products($id, Request $request)
    {
        $category = Category::find($id);

        if(!$category)
            return $this->prepareResponse('category.NOT_FOUND_ER');

        $action = $request->action ? $request->action : 'buy';
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 20;
        $regions = $request->input('regions');

        $regions = explode(',', $regions);

        if($request->input('regions'))
            $countries = Country::whereIn('region_id', $regions)->get();
        else
            $countries = Country::all();

        $ids = [];
        foreach($countries as $country) {
            array_push($ids, $country->id);
        }

        $skip = $page * $limit - $limit;

        $products = Product::with(['country', 'user', 'user.company'])
                            ->where('category_id', '=', $id)
                            ->whereIn('country_id', $ids)
                            ->where('type', '=', $action)
                            ->skip($skip)
                            ->take($limit)
                            ->get();

        if(count($products))
            return $products->toArray();

        return $this->prepareResponse('product.NOT_FOUND_ER');

    }

	/**
	 * Handles image upload and replace for the categories.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function add($id, Request $request)
    {
        if(!$this->current_user->can('add_category_image'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $type   = $request->input('type');                                   // listing, buy, sell, header
        $image  = $request->file('image');

        $category = Category::find($id);

        if(!$category)
            return $this->prepareResponse('category.NOT_FOUND_ER');

        if(!$image || !$type)
            return $this->prepareResponse('BAD_REQUEST');

        if(array_search($image->getClientOriginalExtension(), $this->media_extensions) === false) {
            return $this->prepareResponse('BAD_IMAGE_FORMAT');
        }

        $file_name =  $this->_get_filename() .'.' . $image->getClientOriginalExtension();
        $s3 = Storage::disk('s3');
        $filePath = $this->media_path . $file_name;
        $s3->put($filePath, file_get_contents($image), 'public');

        if($type == 'BUY' || $type == 'SELL' || $type == 'LISTING' || $type == 'HEADER') {

            $category_image = CategoryImage::where('category_id', '=', $category->id)
                ->where('types', '=', $type)->first();

            if($category_image) {
                $category_image->path = $file_name;
                $category_image->save();
            } else {
                $category_image = CategoryImage::create([
                    'types'         => $type,
                    'path'          => $file_name,
                    'category_id'   => $category->id
                ]);
            }
        }

        return $category_image->toArray();
    }

    public function remove($id) {

        if(!$this->current_user->can('remove_category_image'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $category_image = CategoryImage::find($id);

        if(!$category_image)
            return $this->prepareResponse('category.NO_IMAGE_FOUND');

        $image_path = $this->media_path . $category_image->getOriginal('path');
        if(Storage::disk('s3')->exists($image_path))
            Storage::disk('s3')->delete($image_path);

        $category_image->delete();
        return $this->prepareResponse('category.IMAGE_DELETED');
    }

    private function __get_category($id, $operation)
    {
        if(!$this->current_user->can($operation))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $category = Category::find($id);

        if(!$category)
            return $this->prepareResponse('category.NOT_FOUND_ER');

        return $category;
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
