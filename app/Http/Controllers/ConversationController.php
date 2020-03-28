<?php

namespace App\Http\Controllers;

use App\Invitation;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{
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
            $id = Conversation::insertGetId([
                'name' => $request->has('name') ? $request->name : null,
                'last_message' => null,
                'last_time' => null,
            ]);
            
            $users = $request->users;
            
            foreach ($users as $user) {
                DB::table('conversation_user')->insert([
                    'conversation_id'   => $id,
                    'user_id'   => $user['id'],
                ]);
            }

            if ($request->invitation_id) {
                $invitation = Invitation::findOrFail($request->invitation_id);
                if($invitation){
                    $invitation->viewed = true;
                    $invitation->save();
                }
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
