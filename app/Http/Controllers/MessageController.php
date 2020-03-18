<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $contact_id = $request->contact_id;
        return Message::select(
            'id',
            DB::raw("IF(sender_id=$user_id, TRUE, FALSE) as written_by_me"),
            'content',
            'created_at'
        )->where(function($query) use ($user_id, $contact_id){
            $query->where('sender_id', $user_id)->where('receiver_id', $contact_id);
        })->orWhere(function($query) use ($user_id, $contact_id){
            $query->where('sender_id', $contact_id)->where('receiver_id', $user_id);
        })->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->sender_id = auth()->id();
        $message->receiver_id = $request->receiver_id;
        $message->content = $request->content;
        $saved = $message->save();

        $data = [];
        $data['success'] = $saved;
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
