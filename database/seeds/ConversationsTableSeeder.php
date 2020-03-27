<?php

use App\User;
use App\Conversation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Conversation::create(
            [
                'name' => null,
                'last_message' => null,
                'last_time' => null,
            ]
        );

        DB::table('conversation_user')->insert([
            'conversation_id'   => 1,
            'user_id'   => 1,
        ]);
        DB::table('conversation_user')->insert([
            'conversation_id'   => 1,
            'user_id'   => 2,
        ]);


        Conversation::create(
            [
                'name' => null,
                'last_message' => null,
                'last_time' => null,
            ]
        );

        DB::table('conversation_user')->insert([
            'conversation_id'   => 2,
            'user_id'   => 1,
        ]);
        DB::table('conversation_user')->insert([
            'conversation_id'   => 2,
            'user_id'   => 3,
        ]);

        Conversation::create(
            [
                'name' => 'Grupo de la empresa',
                'last_message' => null,
                'last_time' => null,
            ]
        );

        DB::table('conversation_user')->insert([
            'conversation_id'   => 3,
            'user_id'   => 1,
        ]);
        DB::table('conversation_user')->insert([
            'conversation_id'   => 3,
            'user_id'   => 2,
        ]);
        DB::table('conversation_user')->insert([
            'conversation_id'   => 3,
            'user_id'   => 3,
        ]);
        DB::table('conversation_user')->insert([
            'conversation_id'   => 3,
            'user_id'   => 4,
        ]);

    }
}
