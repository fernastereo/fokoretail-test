<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $base64_image = $request->avatar;

        /*Guardar en s3 en lugar del local storage*/

        // if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
        //     $data = substr($base64_image, strpos($base64_image, ',') + 1);

        //     $data = base64_decode($data);
        //     $f = finfo_open();

        //     $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
        //     $split = explode( '/', $mime_type );
        //     $type = $split[1];
        //     $imageName = Str::random(15) . '.' . $type;

        //     Storage::disk('local')->put($imageName, $data);
        //     $user->avatar = '/storage/users/' . $imageName;
        // }
        // $user->name = $request->input('name');
        // $saved = $user->save();
        try{
            $user = User::findOrFail(auth()->user()->id);

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            // Solo procesar el avatar si se envió un archivo
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $storagePath = Storage::disk('s3')->put('profiles', $avatar, 'public');
                $url = Storage::url($storagePath);
                $user->avatar = $url;
            }
            $saved = $user->save();

            $data = [];
            $data['success'] = $saved;
            $data['profile'] = $user;
            return $data;
        }catch(\Exception $e){
            return 'warning, Something Went Wrong!' . $e->getMessage();
        }
    }
}
