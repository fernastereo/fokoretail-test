<?php

use App\Message;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::create([
            'user_id' => 1,
            'conversation_id' => 1,
            'content' => 'Hola Como estas?',
        ]);
        Message::create([
            'user_id' => 2,
            'conversation_id' => 1,
            'content' => 'Aqui bien y tu?',
        ]);


        Message::create([
            'user_id' => 3,
            'conversation_id' => 2,
            'content' => 'Todo bien y tu?',
        ]);
        Message::create([
            'user_id' => 1,
            'conversation_id' => 2,
            'content' => 'Como va la vaina?',
        ]);
    }
}
