<?php

namespace App\Http\Controllers;

use App\User;
use App\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $invitations = Invitation::where('contact_id', $user->id)->where('viewed', false)->get();
        return $invitations;
    }

    public function invite()
    {
        return view('invitations.invite');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = $request->email;
        $user = User::firstWhere('email', $email);
        $data = [];
        
        if ($user) {
            $invitation = new Invitation();
            
            $invitation->user_id = auth()->id();
            $invitation->contact_id = $user->id;
            $invitation->viewed = false;
            $saved = $invitation->save();            

            $data['success'] = $saved;
            $data['invitation'] = $invitation;
        }

        return $data;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invitation $invitation)
    {
        $data = [];

        $invitation->viewed = true;
        $invitation->save();
        
        $data['success'] = 'success';
    
        return $data;
    }

}
