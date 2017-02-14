<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Demo Mode
    |--------------------------------------------------------------------------
    |
    | The demo mode enables application to be used in demo mode.
    | When enable the passwords for the users and permission checking will be disabled.
    |
    */
    'demo' => [

        'enabled' => env('DEMO_MODE', true),

        'user' => [
            'password' => 'test1234',
            'passcode'  => '1234',
            'phone'     => 1234567890,
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Single session
    |--------------------------------------------------------------------------
    |
    | The single session means a user would have one and only one session.
    | This will disallow user to login from different devices at the same time.
    | If a user tries to do so, he will automatically kicked out from the first
    | device, and he will be logged in to second device.
    |
    */
    'single_session' => false,


    /*
    |--------------------------------------------------------------------------
    | Session expiring settings
    |--------------------------------------------------------------------------
    |
    | The session expiring hours is a window period for a system to keep users
    | sessions alive, once the session reaches beyond the hours it will be
    | deleted.
    |
    | The session online expired is a flags that defines how long a user can
    | use the system, with having online status, once it expires, the status
    | goes back to offline.
    |
    */
    'session_hours' => 48,                                  // In hours
    'session_online_expired'    =>  '20',                   // In minutes


    /*
    |--------------------------------------------------------------------------
    | Transaction upcoming days
    |--------------------------------------------------------------------------
    |
    | This property defines the window period for a transaction to be upcoming.
    |
    */
    'upcoming_days' => 14,


    /*
    |--------------------------------------------------------------------------
    | Product expiring soon days
    |--------------------------------------------------------------------------
    |
    | This property defines the window period for a product to be expired.
    |
    */
    'expiring_days' => 7,


    /*
    |--------------------------------------------------------------------------
    | Application Date Format
    |--------------------------------------------------------------------------
    |
    | The variable is used to define the applications date format that would
    | be used when receiving any date as a parameter.
    |
    */
    'date_format' => 'Y-m-d',


    /*
    |--------------------------------------------------------------------------
    | Product Expiring days
    |--------------------------------------------------------------------------
    |
    | The product 'expiring days' is normally a window period based on that
    | there will be many actions calculated, such as firing event that tells
    | the owner that the product is expiring, and so on.
    |
    */
    'expiring_days' => '14',


    /*
    |--------------------------------------------------------------------------
    | Product Meta Identifier
    |--------------------------------------------------------------------------
    |
    | The product meta identifier prefix is being checked on the creation and
    | update of the product. When system encounters fields that are prefixed by
    | given value then the fields will be treated as meta values and will be
    | store in product meta table with appropriate values.
    |
    */

    'meta_keyword_identifier' => '_meta_',


    /*
    |--------------------------------------------------------------------------
    | User Media Path
    |--------------------------------------------------------------------------
    |
    | The configurations is for user media.
    | The path of the profile images and allowed extensions are defined here.
    |
    */

    'user'   => [

        'media'    => [

            'path'          => '/media/users/',                 // put '/' in the beginning

            'extensions'    => [ 'jpg', 'png', 'jpeg' ],        // Allowed photo extensions

            'default'       => 'default.png'                    // Default profile image
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Product Media Path
    |--------------------------------------------------------------------------
    |
    | The configurations is for product media.
    | The path of the media files and allowed extensions are defined here.
    |
    */

    'product'   => [

        'media'    => [

            'path'  => '/media/products/',                  // put '/' in the beginning

            'extensions' => [ 'jpg', 'png', 'jpeg' ],       // Allowed photo extensions

            'default'    => 'default.png'                   // Default product image
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Category Media Path
    |--------------------------------------------------------------------------
    |
    | The configurations is for category media.
    | The path of the media files and allowed extensions are defined here.
    |
    */

    'category'   => [

        'media'    => [

            'path'  => '/media/category/',                  // put '/' in the beginning

            'extensions' => [ 'jpg', 'png', 'jpeg' ],       // Allowed photo extensions

            'default'    => 'default.png'                   // Default category image
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Contracts Path
    |--------------------------------------------------------------------------
    |
    | The configurations is for Contracts.
    | The path of the documents and allowed extensions are defined here.
    |
    */

    'contract'   => [

        'document'    => [

            'path'  => '/media/contracts/',                 // put '/' in the beginning

            'extensions' => [ 'pdf' ],                      // Allowed document extensions
        ],
    ],


   /*
   |--------------------------------------------------------------------------
   | SendBird API
   |--------------------------------------------------------------------------
   |
   | The configurations is for SendBird messaging service.
   |
   */

    'sendbird'   => [

        'api'    => [
            'id'    => env('SENDBIRD_API', '982BC799-18FE-4AF7-B0B5-7CF9DB2E758A'),      // Application ID
            'token'  => env('SENDBIRD_TOKEN', '4927d0a25ab55d8a0e7a464503ae7ce348b14afc'),
        ],

        'message_read_limit' => 50,
    ],

   /*
   |--------------------------------------------------------------------------
   | Mandrill API
   |--------------------------------------------------------------------------
   |
   | The configurations is for Mandrill service.
   |
   */

    'mandrill'   => [

        'templates'   => [
            'offer'   => [
                'pending_approval' => [
                    'subject'   => "Final approval required for an offer",
                    'template'  => 'offer_approve_waiting'
                ],
            ],

            'validation'    => [
                'required' => [
                    'subject'   => "A new validation request",
                    'template'  => 'validation_required'
                ],

                'failed'  => [
                    'subject'   => "Validation failed",
                    'template'  => 'validation_failed'
                ]
            ],

            'user' => [
                'password_forgot' => [
                    'subject'   => "A new password reset request",
                    'template'  => 'password_forgot'
                ]
            ],


            'report' => [
                'new' => [
                    'subject'   => "A new report has been submitted by a user",
                    'template'  => 'report_new'
                ]
            ],

            'transaction' => [
                'approved' => [
                    'subject'   => "The transaction has been approved",
                    'template'  => 'transaction_approved'
                ]
            ]
        ],

        'emails' => [
            'no-reply'    => [
                'email'   => 'no-reply@offshoresharing.com',
                'name'    => 'No Reply',
            ],

            'admin'    => [
            
                'email'   => env('ADMIN_EMAIL', 'administrators@offshoresharing.com'),
                'name'   => env('ADMIN_NAME', 'Admin Offshore Sharing'),

            ],
        ],

    ],




    /*
    |--------------------------------------------------------------------------
    | Application Messages
    |--------------------------------------------------------------------------
    |
    | The Application messages are defined strings and codes that would be shown,
    | When application needs to send a message to clients.
    |
    */
    'push_enabled' => env('PUSH_ENABLED', true),

    'messages'   => [

        'NOT_FOUND' => [
            'code'      => 404,
            'message'   => 'The page not found.'
        ],


        'INTERNAL_SERVER' => [
            'code'      => 500,
            'message'   => 'The server has encountered an error.'
        ],


        'NOT_AUTHORIZED' => [
            'code'      => 403,
            'message'   => 'You are not authorized to perform this action.'
        ],

        'ALREADY_REGISTERED' => [
            'code'      => 403,
            'message'   => 'A device has already been registered for this session.'
        ],

        'BAD_REQUEST' => [
            'code'      => 400,
            'message'   => 'Bad request.'
        ],
        'CANT_REDO' => [
            'code'      => 400,
            'message'   => 'You can not re-do this action.'
        ],


        'NO_RESULT' =>[
            'code'      => 200,
            'message'   => 'No result found.'
        ],


        'RE_DO' => [
            'code'      => 400,
            'message'   => 'You can not re-do the action.'
        ],
        
        
        'REQUIRED_VALUE_MISSING' => [
            'code'      => 400,
            'message'   => 'Required values are missing.'
        ],

        'CATEGORY_INVALID' => [
            'code'      => 400,
            'message'   => 'You can not post in this category, please select a sub category.'
        ],

        'DATE_REQUIRED' => [
            'code'      => 400,
            'message'   => 'Dates are required.'
        ],

        'DATES_INVALID' => [
            'code'      => 400,
            'message'   => 'Dates are invalid.'
        ],
        'BAD_DATES' => [
            'code'      => 400,
            'message'   => 'Bad dates.'
        ],

        'BAD_IMAGE_FORMAT' => [
            'code'      => 400,
            'message'   => 'Bad Image Format.'
        ],

        'NO_SETTING' => [
            'code'      => 404,
            'message'   => 'No setting found.'
        ],

        'PERMISSION_NOT_FOUND' => [
            'code'      => 404,
            'message'   => 'The permission not found.'
        ],


        'notification' => [

            'NOTIF_TYPE_NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'The notification type not found.'
            ],

        ],


        'transaction' => [

            'NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'The transaction not found.'
            ],


            'DISABLED'  => [
                'code'      => 400,
                'message'   => 'The transaction has been closed.'
            ],

            'VALIDATION' => [
                'code'      => 400,
                'message'   => 'The transaction is waiting for the third-party validation.'
            ],

            'REQUEST_VALIDATE' => [
                'code'      => 400,
                'message'   => 'You can not validate the transaction at this stage.'
            ],

            'OPERATION_FAILED' => [
                'code'      => 400,
                'message'   => 'You can not perform this operation at this stage.'
            ],

        ],


        'category' => [

            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'The category not found.'
            ],

            'NO_PARENT_ER' => [
                'code'      => 404,
                'message'   => 'No parent category found.'
            ],

            'NO_IMAGE_FOUND' => [
                'code'      => 404,
                'message'   => 'No category image found.'
            ],

            'IMAGE_DELETED' => [
                'code'      => 200,
                'message'   => 'The image has been deleted successfully.'
            ],
        ],


        'directory' => [

            'NOT_AUTHORIZED_TO_CREATE_FOLDER' => [
                'code'      => 403,
                'message'   => 'A user is not authorized to create a directory.'
            ],
            'NOT_AUTHORIZED_TO_CREATE_FOLDER_OTHER' => [
                'code'      => 403,
                'message'   => 'A user is not authorized to create a directory for other users.'
            ],
            'ROOT_NAME_ERR' => [
                'code'      => 400,
                'message'   => '\'ROOT\' can not be the name of the folder.'
            ],

            'NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'The directory not found.'
            ],
            'OBJECT_NOT_DIRECTORY' => [
                'code'      => 400,
                'message'   => 'The object is not a directory..'
            ],

        ],


        'user' => [
            'NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'The user not found.'
            ],
            'PASSWORD_UPDATED' => [
                'code'      => 200,
                'message'   => 'The Password has been updated.'
            ],
            'PASSWORD_NOT_MATCH' => [
                'code'      => 400,
                'message'   => 'The passwords don\'t match.'
            ],

            'PASSWORD_ERROR' => [
                'code'      => 400,
                'message'   => 'The password is wrong.'
            ],

            'USERNAME_TAKEN' => [
                'code'      => 400,
                'message'   => 'Username is taken.'
            ],
            'EMAIL_TAKEN' => [
                'code'      => 400,
                'message'   => 'Email is taken.'
            ],
            'DELETED' => [
                'code'      => 200,
                'message'   => 'The user has been deleted.'
            ],
            'LOGGED_OUT' => [
                'code'      => 200,
                'message'   => 'The user logged out successfully.'
            ],
            'VERIFICATION_NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'Verification not found.'
            ],
            'ACCOUNT_DEACTIVATED'  => [
                'code'      => 400,
                'message'   => 'The user account has been deactivated.'
            ],
            'AUTH_ERROR'  => [
                'code'      => 400,
                'message'   => 'The user authentication failed.'
            ],
            'AUTH_REQUIRE'  => [
                'code'      => 403,
                'message'   => 'Authentication required.'
            ],

        ],


        'company' => [

            'NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'The company not found.'
            ],
            'COMPANY_DELETED' => [
                'code'      => 200,
                'message'   => 'The company has been deleted.'
            ],

        ],


        'document' => [

            'MISSING_ERR' => [
                'code'      => 400,
                'message'   => 'A document is missing.'
            ],
            'FORMAT_NOT_SUPPORTED' => [
                'code'      => 400,
                'message'   => 'This document format is not supported currently.'
            ],
            'NOT_AUTHORIZED_TO_CREATE' => [
                'code'      => 403,
                'message'   => 'A user is not authorized to create a document.'
            ],
            'NOT_AUTHORIZED_TO_CREATE_OTHER' => [
                'code'      => 403,
                'message'   => 'A user is not authorized to create a document for other users.'
            ],
            'NOT_AUTHORIZED_TO_LIST_OTHER' => [
                'code'      => 403,
                'message'   => 'The user is not authorized to list documents for other users.'
            ],

            'INVALID_SIZE' => [
                'code'      => 400,
                'message'   => 'Invalid document size.'
            ],
            'TYPE_NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'No doc type found.'
            ],
            'NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'No doc found.'
            ],
            
        ],


        'product' => [
            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'The product not found.'
            ],

            'MEDIA_NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'The product image not found.'
            ],

            'MEDIA_REMOVED' =>[
                'code'      => 200,
                'message'   => 'The product image has been removed.'
            ],

            'OWN_PRODUCT_OFFER_ERR' => [
                'code'      => 400,
                'message'   => 'You can not make an offer to your own product.'
            ],
            'PRODUCT_OFFER_MADE_ALREADY_ERR' => [
                'code'      => 400,
                'message'   => 'You have already made an offer for the product.'
            ],
            'NOT_AUTHORIZED_THIRD_PARTY' => [
                'code'      => 403,
                'message'   => 'You are not authorized to perform this action.The third party request has been sent.'
            ],
            'NOT_AUTHORIZED_POST' => [
                'code'      => 403,
                'message'   => 'You cannot authorize post at this stage.'
            ],
            'NOT_AUTHORIZED_POST_UPDATE' => [
                'code'      => 403,
                'message'   => 'You cannot update the post at this stage.'
            ],
            'DELETED' => [
                'code'      => 200,
                'message'   => 'The product has been deleted successfully.'
            ],

            'EXPIRED' => [
                'code'      => 400,
                'message'   => 'The product has been expired.'
            ],

        ],


        'status' => [
            'NOT_FOUND_ER' => [
                'code'      => 400,
                'message'   => 'The status named \'offer\' not found.'
            ],
        ],

 
        'flag' => [
            'NOT_FOUND_ER' => [
                'code'      => 400,
                'message'   => 'The flag named \'offerspending\' not found.'
            ],
            'NOT_FOUND' => [
                'code'      => 404,
                'message'   => 'The flag not found.'
            ],

            'NO_ADD_FLAG' => [
                'code'      => 400,
                'message'   => 'You can not add this flag.'
            ],
            'ALREADY_ATTACHED' => [
                'code'      => 400,
                'message'   => 'This flag has already been attached to the product.'
            ],
            'NOT_ATTACHED' => [
                'code'      => 400,
                'message'   => 'This flag hasn\'t been attached to the product'
            ],

            'CANT_REMOVE' => [
                'code'      => 400,
                'message'   => 'You can not remove this flag.'
            ],
            'DELETED' => [
                'code'      => 200,
                'message'   => 'The flag has been deleted successfully.'
            ],

        ],


        'role' => [
            'NOT_FOUND_ER' => [
                'code'      => 400,
                'message'   => 'The role not found.'
            ],
            'USER_ROLE_UPDATED' => [
                'code'      => 200,
                'message'   => 'The user\'s role has been updated.'
            ],

            'ROLE_PERMISSION_UPDATED' => [
                'code'      => 200,
                'message'   => 'The role\'s permission has been updated.'
            ],
            'DELETED' => [
                'code'      => 200,
                'message'   => 'The role has been deleted.'
            ],
            'ALREADY_EXISTS_IDEN' => [
                'code'      => 400,
                'message'   => 'The role already exists with given identifier.'
            ],

        ],


        'offer' => [
            'NOT_FOUND_ER'  => [
                'code'      => 404,
                'message'   => 'The offer not found.'
            ],
            'NO_DECISION_MADE' => [
                'code'      => 400,
                'message'   => 'Owner of the post hasn\'t made any decision yet.'
            ],
            'OFFER_DENIED'     => [
                'code'      => 200,
                'message'   => 'The owner has denied your offer.'
            ],
            'NO_OFFER'     => [
                'code'      => 200,
                'message'   => 'You can not make an offer at this point.'
            ],

        ],


        'contracts' => [

            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'The resource not found.'
            ],

            'NOT_FOUND_DIR_ER' => [
                'code'      => 404,
                'message'   => 'The directory not found.'
            ],

            'NOT_FOUND_DOC_ER' => [
                'code'      => 404,
                'message'   => 'The document not found.'
            ],

            'DELETE_ROOT_ER' => [
                'code'      => 400,
                'message'   => 'The resource is \'ROOT\' which can not be deleted.'
            ],

            'DELETE_DIRECTORY_SUC' => [
                'code'      => 200,
                'message'   => 'The directory has been deleted successfully.'
            ],

            'DELETE_DOCUMENT_SUC' => [
                'code'      => 200,
                'message'   => 'The document has been deleted successfully.'
            ],

            'MOVE_ROOT_ER' => [
                'code'      => 400,
                'message'   => 'You can not move \'ROOT\'.'
            ],

            'MOVE_DIRECTORY_ER' => [
                'code'      => 400,
                'message'   => 'You can not move a directory.'
            ],

            'MOVE_IN_DOC_ER' => [
                'code'      => 400,
                'message'   => 'You can not move the document in the document. It has to be a folder. Please.'
            ],

            'MOVE_DOC_SUC' => [
                'code'      => 200,
                'message'   => 'The document has been moved successfully.'
            ],

            'NOT_AUTHORIZED_LIST_ER' => [
                'code'      => 403,
                'message'   => 'A user is not authorized to list contracts.'
            ],

            'INFORMATION.MISSING' => [
                'code'      => 400,
                'message'   => 'The type information is missing ( i. e. Folder, Document ).'
            ],

            'OBJECT_NOT_CONTRACT' => [
                'code'      => 400,
                'message'   => 'The object is not a contract.'
            ],
            

        ],

 
        'report' => [

            'CREATED' => [
                'code'      => 200,
                'message'   => 'Report has been created'
            ],

            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'Report not found.'
            ],

        ],


        'request' => [

            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'Request not found.'
            ],

        ],


        'country' => [

            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'The country not found.'
            ],

            'NOT_FOUND_ER' => [
                'code'      => 404,
                'message'   => 'Region not found.'
            ],
            'BEEN_SET' => [
                'code'      => 200,
                'message'   => 'The region has been set.'
            ],

        ],


        'message' => [

            'NO_ALERT' => [
                'code'      => 404,
                'message'   => 'No alert found.'
            ],
        ],

    ],


    'alerts'   => [

        'offer' => [

            'ADMIN_AWAITING_APPROVAL' => [
                'type'      => 'offer',
                'action'    => 'admin_awaiting_approval',
                'alert'     => 'An offer is awaiting approval by administrators.'
            ],

            'ADMIN_AWAITING_VALIDATION' => [
                'type'      => 'offer',
                'action'    => 'admin_awaiting_validation',
                'alert'     => 'An offer is awaiting validation by administrators.'
            ],

            'AWAITING_APPROVAL' => [
                'type'      => 'offer',
                'action'    => 'awaiting_approval',
                'alert'     => 'Your offer is awaiting approval.'
            ],

            'AWAITING_CONFIRMATION' => [
                'type'      => 'offer',
                'action'    => 'awaiting_confirmation',
                'alert'     => 'An offer is awaiting confirmation.'
            ],

            'OFFER_MADE' => [
                'type'          => 'offer',
                'action'        => 'offer_made',
                'alert'         => 'An offer has been made on your post.',
                'identifier'    => 'made_offer'
            ],

            'OFFER_SENT' => [
                'type'          => 'offer',
                'action'        => 'offer_sent',
                'alert'         => 'You have made an offer on a post.',
                'identifier'    => 'sent_offer'
            ],

            'DENIED_CONFIRMED' => [
                'type'          => 'offer',
                'action'        => 'offer_denied_confirmed',
                'alert'         => 'Your offer confirmation was declined.',
                'identifier'    => 'confirmed_denied_offer'
            ],

            'SENT_DENIED_CONFIRMED' => [
                'type'          => 'offer',
                'action'        => 'sent_offer_denied_confirmed',
                'alert'         => 'You have declined to confirm an offer.',
                'identifier'    => 'confirmed_denied_offer_sent'
            ],

            'DENIED' => [
                'type'          => 'offer',
                'action'        => 'offer_denied',
                'alert'         => 'The offer has been denied.',
                'identifier'    => 'denied_offer'
            ],

            'SENT_DENIED' => [
                'type'          => 'offer',
                'action'        => 'sent_offer_denied',
                'alert'         => 'You have denied an offer.',
                'identifier'    => 'denied_offer_sent'
            ],

            'APPROVED' => [
                'type'          => 'offer',
                'action'        => 'approved',
                'alert'         => 'Your offer has been approved.',
                'identifier'    => 'approved_offer'
            ],

            'CONFIRMED' => [
                'type'          => 'offer',
                'action'        => 'confirmed',
                'alert'         => 'Your offer has been confirmed.',
                'identifier'    => 'confirmed_transaction'
            ],

            'CANCELED' => [
                'type'          => 'offer',
                'action'        => 'confirmed',
                'alert'         => 'Your offer has been canceled.',
                'identifier'    => 'canceled_transaction'
            ],

        ],

        'transaction' => [
            'STARTED' => [
                'type'          => 'transaction',
                'action'        => 'transaction_started',
                'alert'         => 'A transaction has been started.',
                'identifier'    => 'transaction_start'
            ],

            'ENDED' => [
                'type'          => 'transaction',
                'action'        => 'transaction_started',
                'alert'         => 'A transaction has been started.',
                'identifier'    => 'end_transaction'
            ],

            'RECEIVED' => [
                'type'      => 'message',
                'action'    => 'received',
                'alert'     => 'You have received a message.'
            ],

            'APPROVED' => [
                'type'      => 'message',
                'action'    => 'approved',
                'alert'     => 'Your transaction has been approved.'
            ],

            'DENIED' => [
                'type'      => 'message',
                'action'    => 'denied',
                'alert'     => 'Your transaction has been denied.'
            ],

            'VALIDATION_FAILED' => [
                'type'      => 'message',
                'action'    => 'validation_failed',
                'alert'     => 'This transaction did not pass 3rd party validation checks.'
            ],

            'VALIDATION_SUCCESS' => [
                'type'      => 'message',
                'action'    => 'validation_success',
                'alert'     => 'This transaction has passed 3rd party validation checks.'
            ],
        ],

        'rate' => [
            'CREATE'    => [
                'type'      => 'rate',
                'action'    => 'create_rate',
                'alert'     => 'Please rate the transaction.'
            ],
        ],

    ],

    'push_notifications' => [ 

        'ses_arn' => env('AMAZON_SES_ARN'),
        'ses_region' => env('AMAZON_SES_REGION'),
        'ses_key' => env('AMAZON_KEY'),
        'ses_secret' => env('AMAZON_SECRET')

    ]
];
