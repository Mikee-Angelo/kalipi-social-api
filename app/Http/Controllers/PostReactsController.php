<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostReacts;
use App\Models\Posts;

class PostReactsController extends Controller
{
    //
    public function create($posts_id, Request $request){

        $data = Posts::where('id', $posts_id)->doesntExists();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        PostReacts::create([
            'post_id' => $data['post_id'],
            'user_id' => $this->guard()->user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);
    }

    public function destroy($post_id, $post_react_id, Request $request){
        $data = Posts::where('id', $post_id)->doesntExists();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        PostReacts::where([
            ['user_id', '=', $this->guard()->user()->id],
            ['post_id', '=', $post_id],
            ['id', '=', $post_react_id]
        ])->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ], 201);
    }

    private function guard(){
        return Auth::guard();
    }
}
