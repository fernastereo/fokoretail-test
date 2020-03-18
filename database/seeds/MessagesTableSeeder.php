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
            'sender_id' => 1,
            'receiver_id' => 2,
            'content' => 'Hola Como estas care verga?',
        ]);
        Message::create([
            'sender_id' => 2,
            'receiver_id' => 1,
            'content' => 'Aqui pasando el coronavirus y tu?',
        ]);
        Message::create([
            'sender_id' => 3,
            'receiver_id' => 1,
            'content' => 'Todo bien y tu?',
        ]);
        Message::create([
            'sender_id' => 1,
            'receiver_id' => 3,
            'content' => 'Como va la vaina?',
        ]);
    }
}
