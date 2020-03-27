<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    // protected $appends = ['contact_name', 'contact_avatar'];

    // public function getContactNameAttribute(){
    //     return $this->contact()->first(['name'])->name;
    // }
    
    // public function getContactAvatarAttribute(){
    //     return $this->contact()->first(['avatar'])->avatar;
    // }

    public function users(){
        return $this->belongsToMany(User::class);        
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
