<?php

namespace App\Http\Controllers;

use App\User;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $conversation_prev = $user->conversations->pluck('id');
        
        $conversations = DB::table('conversations')
        ->join('conversation_user', 'conversations.id', '=', 'conversation_user.conversation_id')
        ->join('users', 'users.id', '=', 'conversation_user.user_id')
        ->select('conversations.id',
                DB::raw("IF(conversations.name IS NULL, users.name, conversations.name) as name"), 
                DB::raw("IF(conversations.name IS NULL, users.avatar, conversations.avatar) as avatar"), 
                'conversations.last_message', 'conversations.last_time')
        ->whereIn('conversations.id', $conversation_prev)
        ->where('conversation_user.user_id', '<>', $user->id)
        ->distinct('')
        ->get();
        
        
        foreach ($conversations as $conversation) {
            $users = Conversation::find($conversation->id)->users->where('id', '<>', $user->id)->pluck('id');
            $conversation->users = $users;
        }
        
        return $conversations;
    }
}
