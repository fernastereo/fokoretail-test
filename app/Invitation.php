<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $appends = ['user_name'];

    public function getUserNameAttribute(){
        return $this->user()->first(['name'])->name;
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
