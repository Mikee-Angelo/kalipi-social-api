<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follows;
use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{
    //
    public function create($user_id, Request $request){ 
        $id = $this->guard()->user()->id;
        $user = User::findOrFail($id);
        
        if($user_id == $id){
            return response()->json([
                'status' => true,
                'message' => 'Forbidden Error'
            ], 403);            
        }

        try{
            Follows::create([
                'user_id' => $id,
                'follower_id' => $user_id,
            ]);          
        }catch(Exception $e){
            return response()->json([
                'status' => true,
                'message' => 'Forbidden Error'
            ], 403);                 
        }

        return response()->json([
            'status' => true,
            'message' => 'Followed Successfully'
        ], 201);
    }

    public function delete($user_id, Request $request){
        Follows::where([
            ['user_id', '=' , $this->guard()->user()->id],
            ['follower_id', '=' , $user_id]
        ])->delete();

        return response()->json([
            'status' => true,
            'message' => 'Unfollowed Successfully'
        ], 201);        
    }

    private function guard(){
        return Auth::guard('api');
    }
}
