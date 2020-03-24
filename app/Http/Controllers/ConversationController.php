<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Conversation::where('user_id', auth()->id())->get(
            [
                'id',
                'user_id',
                'contact_id',
                'has_blocked',
                'allow_notifications',
                'last_message',
                'last_time'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        try{
            Conversation::insert([
                'user_id' => $request->user_id,
                'contact_id' => $request->contact_id,
            ]);
            Conversation::insert([
                'user_id' => $request->contact_id,
                'contact_id' => $request->user_id,
            ]);

            $invitation = Invitation::findOrFail($request->invitation_id);
            if($invitation){
                $invitation->viewed = true;
                $invitation->save();
            }
            
            DB::commit();
            $data['success'] = 'success';
        
        }catch(\Exception $e){
            DB::rollback();
            $data['error'] = 'warning,Something Went Wrong!';
        }   

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
