<?php namespace App\Http\Controllers\api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Doc;
use App\Models\DocType;

class DocController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$docs = Doc::with('doc_type')->get();
        return $docs->toArray();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($type, $lang = 'en')
	{

        $doc_type = DocType::where('name', '=', $type)->first();

        if(!$doc_type)
            return $this->prepareResponse('document.TYPE_NOT_FOUND');

        $doc = Doc::where('docs_type_id', '=', $doc_type->id)->where('lang', '=', $lang)->first();

        if(!$doc)
            return $this->prepareResponse('document.NOT_FOUND');

        return $doc->toArray();
	}

}
