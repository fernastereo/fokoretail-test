<?php

namespace App\Http\Controllers;

use App\Group;
use App\Events\GroupCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try{
            $group = new Group();
        
            $group->name = $request->name;
            $saved = $group->save();

            
            DB::table('groupusers')->insert([
                ['group_id' => $group->id, 'user_id' => auth()->user()->id]
            ]);

            $users = collect(request('users'));
            
            foreach ($users as $user) {                
                DB::table('groupusers')->insert([
                    ['group_id' => $group->id, 'user_id' => $user['contact_id']],
                ]);
            }
            DB::commit();

            event(new GroupCreated($group));
            $data['success'] = 'success';
            $data['group'] = $group;

        }catch(\Exception $e){
            DB::rollback();
            $data['error'] = 'warning,Something Went Wrong!';
        }
        return $data;
    }

}
