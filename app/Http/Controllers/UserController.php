<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return USer::findOrFail($user->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $base64_image = $request->avatar;
        
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            
            $data = base64_decode($data);
            $f = finfo_open();

            $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
            $split = explode( '/', $mime_type );
            $type = $split[1]; 
            $imageName = $user->id . '.' . $type;
            
            Storage::disk('local')->put($imageName, $data);
            $user->avatar = $imageName;
        }
        $user->name = $request->input('name');
        $saved = $user->save();

        $data = [];
        $data['success'] = $saved;
        $data['profile'] = $user;
        return $data;
    }
}
