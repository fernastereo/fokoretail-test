<?php

namespace App\Observers;

use App\Group;
use App\Events\GroupCreated;
use Illuminate\Support\Facades\DB;

class GroupObserver
{
    public function created(Group $group)
    {
        // echo $group->users;
        // DB::table('groups')->insert([
        //     ['name' => 'Otro Grupo Nuevo'],
        // ]);

        // event(new GroupCreated($group));
    }
}
