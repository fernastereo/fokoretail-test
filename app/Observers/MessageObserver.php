<?php

namespace App\Observers;

use App\Message;
use App\Conversation;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        $conversation = Conversation::where('user_id', $message->sender_id)
                          ->where('contact_id', $message->receiver_id)
                          ->first();
        if ($conversation) {
          $conversation->last_message = "You: $message->content";
          $conversation->last_time = $message->created_at;
          $conversation->save();
        }

        $conversation = Conversation::where('contact_id', $message->sender_id)
                          ->where('user_id', $message->receiver_id)
                          ->first();
        if ($conversation) {
          $conversation->last_message = "$conversation->contact_name: $message->content";
          $conversation->last_time = $message->created_at;
          $conversation->save();
        }
    }

    /**
     * Handle the Message "updated" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function updated(Message $message)
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        //
    }

    /**
     * Handle the Message "forceDeleted" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
    }
}