<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;

class PostsController extends Controller
{
    //
    public function create(Request $request){

        $data = $request->validate([
            'post_content' => ['required', 'string'],
            'post_privacy' => ['numeric', 'max:1'],
            'post_feelings' => ['numeric'], //needs to be in feelings table
            'post_location' => ['string'],
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Posts::create([
            'user_id' => $this->guard()->user()->id,
            'post_content' => $data['post_content'],
            'post_privacy' => $data['post_privacy'] ,
            'post_feelings' => $data['post_feelings'], //needs to be in feelings table
            'post_location' => $data['post_location'],
            'active' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Posted Successfully'
        ], 201);
    }
    
    public function getSinglePost($posts_id, Request $request){
        $posts = Posts::with('user')->findorFail($posts_id);

        return response()->json([
            'status' => true,
            'data' => $posts
        ], 201);
    }

    public function destroy($posts_id, Request $request){
        Posts::where([
            ['user_id', '=', $this->guard()->user()->id],
            ['id', '=', $posts_id]
        ])->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ], 201);
    }

    public function update($posts_id, Request $request){

        $data = $request->validate([
            'post_content' => ['required', 'string'],
            'post_privacy' => ['numeric', 'max:1'],
            'post_feelings' => ['numeric'], //needs to be in feelings table
            'post_location' => ['string'],
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Posts::where('id', $posts_id)->update([
            'user_id' => $this->guard()->user()->id,
            'post_content' => $data['post_content'],
            'post_privacy' => $data['post_privacy'] ,
            'post_feelings' => $data['post_feelings'], //needs to be in feelings table
            'post_location' => $data['post_location'],
            'active' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated Successfully'
        ], 201);
    }

    public function share($post_id, Request $request){

        $data = Posts::where('id', $post_id)->doesntExists();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        $data = $request->validate([
            'post_content' => ['string'],
            'post_privacy' => ['numeric', 'max:1'],
            'post_feelings' => ['numeric'], //needs to be in feelings table
            'post_location' => ['string'],
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Posts::create([
            'user_id' => $this->guard()->user()->id,
            'post_content' => $data['post_content'],
            'post_privacy' => $data['post_privacy'] ,
            'post_feelings' => $data['post_feelings'], //needs to be in feelings table
            'post_location' => $data['post_location'],
            'share_from' => $post_id,
            'active' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Posted Successfully'
        ], 201);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
