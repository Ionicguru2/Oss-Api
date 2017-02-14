<?php namespace App\Http\Helpers;

use Config;
use Carbon\Carbon;
use App\Models\Message;
use \GuzzleHttp\Client;

use App\Models\User;
use App\Models\Contract;
use App\Models\Transaction;
use App\Models\Alert;

class SendBird {

    /**
     * The property holds the SendBird client object.
     *
     * @var \GuzzleHttp\Client;
     */
    protected $client;


    /**
     * The property holds the api token of SendBird.
     *
     * @var string
     */
    protected $token;

    public function __construct()
    {
        $this->client  = new Client(['base_uri' => 'https://api.sendbird.com/']);
        $this->token = Config::get('oss.sendbird.api.token');

    }


    /**
     * The function will create a new user in SendBird,
     * This will only be called when an admin creates a user in admin panel.
     *
     * @param User $user
     * @return User
     */
    public function create_user(User $user){

        $response = $this->client->request('POST', 'user/create', [
            'json' => [
                'auth'                  => $this->token,
                'id'                    => $user->id,
                'nickname'              => str_replace("@", "_", $user->email),
                'image_url'             => url('/') . Config::get('oss.user.media.path') . $user->profile_image,
                'issue_access_token'    => true
            ]
        ]);

        // Convert response object to string
        $body = (string) $response->getBody();

        // Convert string to JSON
        $json = (array) json_decode($body, true);

        $user->sendbird = $json['access_token'];
        $user->sendbird_id = $json['user_id'];
        $user->save();

        return $user;
    }


    /**
     * This function will create a messaging channel that will allow
     * users to communicate with through the channel.
     * It will only be created when a new transaction starts.
     *
     * @param Transaction $transaction
     * @return Transaction
     */
    public function create_chennel(Transaction $transaction) {

        // Get random name for a channel
        $name = $this->_get_name();

        // create messaging channel
        $response = $this->client->request('POST', 'messaging/create', [
            'json' => [
                'auth'                  => $this->token,
                'channel_url'           => $name,
                'name'                  => 'TRANSACTION#' . $transaction->id,
                'data'                  => '{"id":"'. $transaction->id .'"}'
            ]
        ]);

        $data = $this->_convert_json($response);

        $transaction->sendbird_name = $data['channel']['name'];
        $transaction->sendbird_url = $data['channel']['channel_url'];
        $transaction->save();


        $ids = [];
        foreach ( $transaction->users as $user)
            array_push($ids, strval($user->id));

        $this->client->request('POST', 'messaging/invite', [
            'json' => [
                'auth'          => $this->token,
                'user_ids'      => $ids,
                'channel_url'   => $transaction->sendbird_url,
            ]
        ]);

        return $transaction;
    }


    /**
     * This function is resposible to send messages to the channels.
     *
     * @param Transaction $transaction
     * @param User $user
     * @param String $message
     * @return array
     */
    public function send_message(Transaction $transaction, User $user, $message)
    {
        $response = $this->client->request('POST', 'channel/send', [
            'json' => [
                'auth'          => $this->token,
                'id'            => $user->id,
                'channel_url'   => $transaction->sendbird_url,
                'message'       => $message,
                'data'          => '{"type":"TEXT"}'
            ]
        ]);
		
		
		$data = $this->_convert_json($response);

        if(!$data)
            $this->_prepareAlert( $user, 'transaction.RECEIVED', $transaction );

		return $data ;
    }

    /**
     * This function is responsible to send file links over the transaction.
     *
     * @param Transaction $transaction
     * @param Contract $contract
     * @return array
     */
    public function send_file(Transaction $transaction, Contract $contract, User $user)
    {
        $response = $this->client->request('POST', 'channel/send', [
            'json' => [
                'auth'          => $this->token,
                'id'            => $user->id,
                'channel_url'   => $transaction->sendbird_url,
                'message'       => $contract->path,
                'data'          => '{"type":"FILE","filename":"'. $contract->name .'","id":"'. $contract->id .'", "size":"'. $contract->size .'"}'
            ]
        ]);

        $data = $this->_convert_json($response);

        if(!$data)
            $this->_prepareAlert( $user, 'transaction.RECEIVED', $transaction );

        return $data ;
    }

    /**
     * The function lists all the active channel for the given user.
     *
     * @param User $user
     * @return array
     */
    public function list_channel(User $user)
    {
        $response = $this->client->request('POST', 'admin/list_messaging_channels', [
            'json' => [
                'auth'     => $this->token,
                'id'       => $user->id
            ]
        ]);
	$data = $this->_convert_json($response);
        return $data;
    }


    public function read_messages(Transaction $transaction, $limit)
    {
        $response = $this->client->request('POST', 'admin/read_messages', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url,
                'limit'         => $limit,
                'message_id'    => 0
            ]
        ]);

        return $this->_convert_json($response);
    }

    /**
     * The function will periodically refresh the messages.
     *
     * @param Transaction $transaction
     * @return array
     */
    public function refresh(Transaction $transaction, $message_id)
    {
        $response = $this->client->request('POST', 'admin/read_messages', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url,
                'limit'         => 10,
                'message_id'    => 0
            ]
        ]);

        $data = $this->_convert_json($response);

        foreach ($data['messages'] as $key => $message){
            if($message_id != $message['message_id']) {
                unset($data['messages'][$key]);
            } else {
                unset($data['messages'][$key]);
                break ;
            }
        }

        return array_values($data['messages']);
    }

    /**
     * This function will be called when a chat is being open.
     * @param Transaction $transaction
     * @return array
     */
    public function open_chat(Transaction $transaction)
    {
        $response = $this->client->request('POST', 'admin/read_messages', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url,
                'limit'         => 50,
                'message_id'    => 0
            ]
        ]);
        $data = $this->_convert_json($response);
        return $data;
    }

    /**
     * This function will pull last 50 messages from the given message id.
     * @param Transaction $transaction
     * @param $message_id
     * @return array
     */
    public function reload_chat(Transaction $transaction, $message_id)
    {
        $response = $this->client->request('POST', 'admin/read_messages', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url,
                'limit'         => 50,
                'message_id'    => $message_id
            ]
        ]);

        $data = $this->_convert_json($response);
        return $data;
    }

    public function message_count(Transaction $transaction)
    {
        $response = $this->client->request('POST', 'messaging/message_count', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url,
            ]
        ]);

        // Convert response object to string
        $body = (string) $response->getBody();

        // Convert string to JSON
        $json = (array) json_decode($body, true);

        return $json;
    }

    public function channel_view(Transaction $transaction)
    {
        $response = $this->client->request('POST', 'messaging/view', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url,
            ]
        ]);

        // Convert response object to string
        $body = (string) $response->getBody();

        // Convert string to JSON
        $json = (array) json_decode($body, true);

        return $json;
    }

    public function channel_delete(Transaction $transaction)
    {
        $response = $this->client->request('POST', 'channel/delete', [
            'json' => [
                'auth'          => $this->token,
                'channel_url'   => $transaction->sendbird_url
            ]
        ]);

        // Convert response object to string
        $body = (string) $response->getBody();

        // Convert string to JSON
        $json = (array) json_decode($body, true);

        return $json;
    }

    private function _store_in_db($response, Transaction $transaction)
    {
        $last_message = $transaction->messages()
            ->orderBy('timestamp', 'DESC')->limit(1)->get()->toArray();

        $collection = collect($response['messages']);

        $filtered = $collection->reject(function($item) use ($last_message) {

            if(!$last_message)
                $timestamp = Carbon::create(0,0,0);
            else
                $timestamp = Carbon::createFromFormat('Y-m-d H:i:s', $last_message[0]['timestamp']);

            $ts = Carbon::createFromTimestamp($item['timestamp']/1000);
            return $ts->lte($timestamp);

        })->all();

        foreach ($filtered as $message){
            $date = Carbon::createFromTimestamp($message['timestamp']/1000)->toDateTimeString();
            Message::create([
                'message_id'        => intval($message['message_id']),
                'nickname'          => $message['nickname'],
                'data'              => $message['data'],
                'message'           => $message['message'],
                'timestamp'         => $date,
                'id'                => intval($message['id']),
                'transaction_id'    => $transaction->id,
            ]);
        }

        return ;
    }

    private function _prepareAlert($user, $type, $transaction) {

        # if user is online then don't create an alert
        if($user->online)
            return ;

        // get alert type and message
        $type       = 'oss.alerts.' . $type . '.type';
        $message    = 'oss.alerts.' . $type . '.alert';
        $action     = 'oss.alerts.' . $type . '.action';

        // Find older alerts of the same type for the same user
        $alert = Alert::where('user_id', '=', $user->id)
                    ->where('type_id', '=', $transaction->id)
                    ->where('action', '=', $action)
                    ->first();

        // Re-do the timestemps
        if($alert){
            $alert->updated_at = Carbon::now()->toDateTimeString();
            $alert->created_at = Carbon::now()->toDateTimeString();
            $alert->save();
            return ;
        }


        // create Alert
        Alert::create([
            'type'      => Config::get($type),
            'message'   => Config::get($message),
            'user_id'   => $user->id,
            'type_id'   => $transaction->id,
            'action'    => $action
        ]);
    }

    private function _convert_json($response)
    {
        $body = (string) $response->getBody();
        $json = (array) json_decode($body, true);

        return $json;
    }

    private function _get_name( $length = 52 )
    {
        $filename = "";
        $crypt_allowed_code = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $crypt_allowed_code.= "abcdefghijklmnopqrstuvwxyz";
        $crypt_allowed_code.= "0123456789";

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
