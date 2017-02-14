<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSessionFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement("ALTER TABLE `sessions` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);");
        
        DB::statement("CREATE TABLE IF NOT EXISTS `session_push_registrations` (
                        `id` int(11) NOT NULL,
                        `session_id` int(11) NOT NULL,
                        `type` enum('ios') NOT NULL,
                        `key` varchar(255) NOT NULL,
                        `updated_at` datetime NOT NULL,
                        `created_at` datetime NOT NULL
                       ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
        DB::statement("ALTER TABLE `session_push_registrations` ADD PRIMARY KEY (`id`), ADD KEY `session_id` (`session_id`);");
        DB::statement("ALTER TABLE `session_push_registrations` ADD CONSTRAINT `session_id` FOREIGN KEY (`session_id`) REFERENCES `sessions`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT;");
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement("DROP TABLE session_push_registrations;");
        DB::statement("ALTER TABLE sessions DROP `id`;");
	}

}
