<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\NotificationSetting;
use App\Models\NotificationType;

class NotificationSettings extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $n1 = NotificationType::where('identifier', '=', 'send_message')->first();
        $n2 = NotificationType::where('identifier', '=', 'made_offer')->first();
        $n3 = NotificationType::where('identifier', '=', 'denied_offer')->first();
        $n4 = NotificationType::where('identifier', '=', 'approved_offer')->first();
        $n5 = NotificationType::where('identifier', '=', 'confirmed_transaction')->first();
        $n6 = NotificationType::where('identifier', '=', 'canceled_transaction')->first();
        $n7 = NotificationType::where('identifier', '=', 'transaction_start')->first();
        $n8 = NotificationType::where('identifier', '=', 'end_transaction')->first();

        $users = User::all();

        if(count($users)) {
            foreach( $users as $user ) {
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n1->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n2->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n3->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n4->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n5->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n6->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n7->id, 'allowed' => true ]);
                NotificationSetting::create([ 'user_id' => $user->id, 'notification_type_id' => $n8->id, 'allowed' => true ]);
            }
        }

    }

}
