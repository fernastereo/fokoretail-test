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
        $user = User::findOrFail(2);
        Conversation::create(
            [
                'name' => $user->name,
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

        $user = User::findOrFail(3);
        Conversation::create(
            [
                'name' => $user->name,
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

    }
}
