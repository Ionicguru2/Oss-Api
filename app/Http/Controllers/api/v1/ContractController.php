<?php namespace App\Http\Controllers\api\v1;

use App\Models\Transaction;
use Auth;
use File;
use Config;
use Storage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ContractType;
use App\Models\Contract;
use App\Models\User;
use App\Models\Company;

class ContractController extends Controller {

    /**
     * The property holds current authenticated user.
     *
     * @var \App\Models\User
     */
    protected $current_user;


    /**
     * The document path defines the path where contract will be uploaded/retrieved.
     *
     * @var String
     */
    private $document_path;


    /**
     * The document extension contains the list of allowed file extensions.
     *
     * @var Array
     */
    private $document_extensions;


    /**
     * Constructor will initialize the class with basic properties.
     */
    public function __construct()
    {
        $this->current_user = Auth::getUser();
        $this->document_path = Config::get('oss.contract.document.path');
        $this->document_extensions = Config::get('oss.contract.document.extensions');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        // if the current user is not authorized to list the documents.
        if(!$this->current_user->can('list_contract'))
           return $this->prepareResponse('contracts.NOT_AUTHORIZED_LIST_ER');
		  

        $root = $this->_get_root_directory($this->current_user->id);
        $root->children;
        $root->load('children.contract_type');
        return $root->toArray();
    }

    public function tree()
    {
        // if the current user is not authorized to list the documents.
        if(!$this->current_user->can('list_contract'))
           return $this->prepareResponse('contracts.NOT_AUTHORIZED_LIST_ER');

        $root = $this->_get_root_directory($this->current_user->id);
        $root->children;
        
        function traverse(&$children)
        {
            foreach ($children as $child)
            {
                $child->load('children');
                traverse($child->children);
            }
        };

        traverse($root->children);

        return $root->toArray();
    }


    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

        $contract_type = $request->input('type');
        $parent_id = $request->input('parent_id');
        $user_id = $request->input('user_id');
        $name = $request->input('name');

        if(!$user_id)
            $user_id = $this->current_user->id;

        if(!$contract_type)
             return $this->prepareResponse('contracts.INFORMATION_MISSING');

        $type = ContractType::where('name', '=', $contract_type)->first();
        $root = $this->_get_root_directory($user_id);

        if(!$parent_id) {
            $parent_id = $root->id;
        }

        if($type->name == 'FOLDER'){

            // if the current user is not authorize to create a directory
            if(!$this->current_user->can('create_directory'))
				return $this->prepareResponse('directory.NOT_AUTHORIZED_TO_CREATE_FOLDER');

            // if the current user is not authorized to create a directory for other users.
            if($user_id != $this->current_user->id) {
                if(!$this->current_user->can('super_create_directory')) {
                    return $this->prepareResponse('directory.NOT_AUTHORIZED_TO_CREATE_FOLDER_OTHER');
                }
            }

            if($name == 'ROOT')
                return $this->prepareResponse('directory.ROOT_NAME_ERR');

            $parent = Contract::find($parent_id);

            if(!$parent)
                return $this->prepareResponse('contracts.NOT_FOUND_DIR_ER');

            if($parent->contract_type->name == 'DOCUMENT')
                return $this->prepareResponse('contracts.MOVE_IN_DOC_ER');

            if($parent->user_id != $this->current_user->id)
                return $this->prepareResponse('NOT_AUTHORIZED');

            $path = str_replace(" ", "_", strtolower( $name ) );
            $path = $parent->path . '/' . $path;

            $directory = Contract::create([
                'name'              => $name,
                'size'              => '-',
                'path'              => $path,
                'user_id'           => $user_id,
                'contract_type_id'  => $type->id,
                'parent_id'         => $parent_id

            ]);

            $directory->load('contract_type');
            return $directory->toArray();
        }

        if($type->name == 'DOCUMENT'){

            $document = $request->file('document');

            if(!$document)
                return $this->prepareResponse('document.MISSING_ERR');


            if(array_search($document->getClientOriginalExtension(), $this->document_extensions) === false) {
				return $this->prepareResponse('document.FORMAT_NOT_SUPPORTED');
            }

            // if the current user is not authorized to create a document.
            if(!$this->current_user->can('create_contract'))
				return $this->prepareResponse('document.NOT_AUTHORIZED_TO_CREATE');

            // if the current user is not authorized to create a document for other users.
            if($user_id != $this->current_user->id) {
                if(!$this->current_user->can('super_create_contract')) {
					return $this->prepareResponse('document.NOT_AUTHORIZED_TO_CREATE_OTHER');

                }
            }

            $parent = Contract::find($parent_id);

            if(!$parent)
                return $this->prepareResponse('contracts.NOT_FOUND_DIR_ER');

            if($parent->contract_type->name == 'DOCUMENT')
                return $this->prepareResponse('contracts.MOVE_IN_DOC_ER');

            if($parent->user_id != $this->current_user->id)
                return $this->prepareResponse('NOT_AUTHORIZED');

            $doc_name = $document->getClientOriginalName();
            $size = $document->getClientSize();

            if($size <= 0)
				return $this->prepareResponse('document.INVALID_SIZE');

            if($size > 0 && $size <= 999) {
                $size = $size . ' Bytes';
            }

            if($size > 999 && $size <= 999999) {
                $size = round ( ( $size / 1000 ), 2 ) . ' KB';
            }

            if($size > 999999) {
                $size = round ( ( $size / 1000000 ), 2 ) . ' MB';
            }

            $file_name =  $this->_get_filename() .'.' . $document->getClientOriginalExtension();
            $filePath = $this->document_path . $file_name;
            $s3 = Storage::disk('s3');
            $s3->put($filePath, file_get_contents($document), 'public');

            $contract = Contract::create([
                'name'              => $doc_name,
                'size'              => $size,
                'path'              => $file_name,
                'contract_type_id'  => $type->id,
                'user_id'           => $user_id,
                'parent_id'         => $parent_id
            ]);

            $contract->load('contract_type');
            return $contract->toArray();

        }

	}

    public function user($id){

        // if the current user is not authorized to list the documents for other users.
        if($id != $this->current_user->id) {
            if(!$this->current_user->can('super_list_contract')) {
				return $this->prepareResponse('document.NOT_AUTHORIZED_TO_LIST_OTHER');
            }
        }

        $user = User::find($id);

        if(!$user)
            return $this->prepareResponse('user.NOT_FOUND');

        $root = $this->_get_root_directory($user->id);
        $root->load('children');
        $root->load('children.contract_type');

        return $root->toArray();

    }

    public function company($id){
        // if the current user is not authorized to list the documents for other users.
        if($id != $this->current_user->id) {
            if(!$this->current_user->can('super_list_contract')) {
                return $this->prepareResponse('document.NOT_AUTHORIZED_TO_LIST_OTHER');
            }
        }

        $company = Company::find($id);

        if(!$company)
            return $this->prepareResponse('company.NOT_FOUND');

        $roots = [];
        foreach ($company->users as $user) {
            $root = $this->_get_root_directory($user->id);
            $root->load('user');
            array_push($roots, $root);
        }

        return $roots;
    }

    public function folder($id) {

        // if the current user is not authorized to view a directory.
        if(!$this->current_user->can('view_directory'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $type = ContractType::where('name', '=', 'FOLDER')->first();
        $directory = Contract::find($id);

        if(!$directory)
			return $this->prepareResponse('directory.NOT_FOUND');


        if($directory->contract_type_id != $type->id)
            return $this->prepareResponse('directory.OBJECT_NOT_DIRECTORY');

        if($directory->user_id != $this->current_user->id)
            // if the current user is not authorized to view a directory of other users.
            if(!$this->current_user->can('super_view_directory'))
                return $this->prepareResponse('NOT_AUTHORIZED');

        $directory->load('children');
        $directory->load('children.contract_type');
        return $directory->toArray();
    }

    public function document($id) {

        // if the current user is not authorized to download a document.
        if(!$this->current_user->can('download_contract'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        $type = ContractType::where('name', '=', 'DOCUMENT')->first();
        $contract = Contract::find($id);

        if($contract->contract_type_id != $type->id)
			return $this->prepareResponse('contracts.OBJECT_NOT_CONTRACT');


        if($contract->user_id != $this->current_user->id)
            // if the current user is not authorized to download a document of other users.
            if(!$this->current_user->can('super_download_contract'))
                return $this->prepareResponse('NOT_AUTHORIZED');

//        $transaction_user = false;
//        if($contract->transaction_id) {
//            $transaction = Transaction::find($contract->transaction_id);
//            $users = $transaction->users();
//            foreach($users as $user) {
//                if($this->current_user->id == $user->id)
//                    $transaction_user = true;
//            }
//        }

//        if(!$transaction_user)
//            return $this->prepareResponse('NOT_AUTHORIZED');

        $file = public_path() . $this->document_path . $contract->path;
        $headers = array('Content-Type: application/pdf',);

        return response()->download($file, $contract->name, $headers);
    }


    public function transaction($id, $transaction_id)
    {
        $contract = Contract::find($id);

        if(!$contract)
            return $this->prepareResponse('contracts.NOT_FOUND_DOC_ER');

        if($this->current_user->id != $contract->user_id)
            if(!$this->current_user->can('super_delete_directory'))
                return $this->prepareResponse('NOT_AUTHORIZED');

        $transaction = Transaction::find($transaction_id);

        if(!$transaction)
            return $this->prepareResponse('transaction.NOT_FOUND_ER');

        if(!$this->current_user->can('attach_contract_transaction'))
            return $this->prepareResponse('NOT_AUTHORIZED');

        if($this->current_user->id != $contract->user_id)
            if( !$this->current_user->can('super_attach_contract_transaction') )
                return $this->prepareResponse('NOT_AUTHORIZED');

        $transaction->contracts()->attach($contract->id);

        $contract->load('transactions');
        return $contract->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $resource = Contract::find($id);

        if(!$resource)
            return $this->prepareResponse('contracts.NOT_FOUND_ER');

        if($resource->contract_type->name == 'ROOT')
            return $this->prepareResponse('contracts.DELETE_ROOT_ER');

        if($resource->contract_type->name == 'FOLDER') {

            // if the current user is not authorize to delete a directory
            if(!$this->current_user->can('delete_directory'))
                return $this->prepareResponse('NOT_AUTHORIZED');

            // if the current user is not authorize to delete a directory of other users.
            if($resource->user_id != $this->current_user->id)
                if(!$this->current_user->can('super_delete_directory'))
                    return $this->prepareResponse('NOT_AUTHORIZED');

            // It will delete all the children
            Contract::where('parent_id', '=', $resource->id)->delete();
            $resource->delete();

            return $this->prepareResponse('contracts.DELETE_DIRECTORY_SUC');
        }

        if($resource->contract_type->name == 'DOCUMENT') {

            // if the current user is not authorize to delete a document
            if(!$this->current_user->can('delete_contract'))
                return $this->prepareResponse('NOT_AUTHORIZED');

            // if the current user is not authorize to delete a document of other users.
            if($resource->user_id != $this->current_user->id)
                if(!$this->current_user->can('super_delete_contract'))
                    return $this->prepareResponse('NOT_AUTHORIZED');

            $resource_path = $this->document_path . $resource->getOriginal('path');
            if(Storage::disk('s3')->exists($resource_path))
                Storage::disk('s3')->delete($resource_path);

            $resource->delete();
            return $this->prepareResponse('contracts.DELETE_DOCUMENT_SUC');
        }
    }

    public function move($id, $folder_id) {

        $contract = Contract::find($id);

        if(!$contract)
            return $this->prepareResponse('contracts.NOT_FOUND_DOC_ER');

        if($contract->contract_type->name == 'ROOT')
            return $this->prepareResponse('contracts.MOVE_ROOT_ER');

        if($contract->contract_type->name == 'FOLDER')
            return $this->prepareResponse('contracts.MOVE_DIRECTORY_ER');

        if($contract->contract_type->name == 'DOCUMENT') {

            // if the current user is not authorize to delete a document
            if(!$this->current_user->can('move_contract'))
                return $this->prepareResponse('NOT_AUTHORIZED');

            // if the current user is not authorize to delete a document of other users.
            if($contract->user_id != $this->current_user->id)
                if(!$this->current_user->can('super_move_contract'))
                    return $this->prepareResponse('NOT_AUTHORIZED');

            $folder = Contract::find($folder_id);

            if(!$folder)
                return $this->prepareResponse('contracts.NOT_FOUND_DIR_ER');

            if($folder->contract_type->name == 'DOCUMENT')
                return $this->prepareResponse('contracts.MOVE_IN_DOC_ER');

            $contract->parent_id = $folder->id;
            $contract->save();

            return $this->prepareResponse('contracts.MOVE_DOC_SUC');
        }

    }
    private function _get_root_directory($user_id)
    {
        $contract_root = ContractType::where('name', '=', 'ROOT')->first();
        $root_directory = Contract::where('user_id', '=', $user_id)
            ->where('contract_type_id', '=', $contract_root->id)
            ->where('path', '=', '/')
            ->whereNull('parent_id')
            ->first();

        if(!$root_directory){

            // if the current user is not authorize to create a directory
            if(!$this->current_user->can('create_directory'))
                return $this->prepareResponse('NOT_AUTHORIZED');

            // if the current user is not authorized to create a directory for other users.
            if($user_id != $this->current_user->id) {
                if(!$this->current_user->can('super_create_directory')) {
                    return $this->prepareResponse('NOT_AUTHORIZED');
                }
            }

            $root_directory = Contract::create([
                'name'              => $contract_root->name,
                'size'              => '-',
                'path'              => '/',
                'user_id'           => $user_id,
                'contract_type_id'  => $contract_root->id,
                'parent_id'         => null,

            ]);
        }

        return $root_directory;
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
