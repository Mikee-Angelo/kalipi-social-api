<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;
use App\Models\Posts;

class CommentsController extends Controller
{
    //
    public function create($posts_id, Request $request){
        $data = Posts::where('id', $posts_id)->doesntExist();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        $data = $request->validate([
            'comment_content' => ['required', 'string']
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Comments::create([
            'post_id' => $posts_id,
            'comment_content' => $data['comment_content'],
            'user_id' => $this->guard()->user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);
    }

    public function getSingleComment($comments_id, Request $request){
        $comments = Comments::findorFail($comments_id);

        return response()->json([
            'status' => true,
            'data' => $comments
        ], 200);
    }

    public function update($comments_id, Request $request){
        $data = $request->validate([
            'comment_content' => ['required', 'string']
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        $comments = Comments::findOrFail($comments_id);
        $comments->update([
            'comment_content' => $data['comment_content'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);
    }

    public function destroy($comments_id, Request $request){
        Comments::where([
            ['user_id', '=', $this->guard()->user()->id],
            ['id', '=', $comments_id]
        ])->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ], 201);
    }

    public function reply($posts_id, $comment_id, Request $request){
        $data = Posts::where('id', $posts_id)->doesntExist();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        $data = $request->validate([
            'comment_content' => ['required', 'string'],
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Comments::create([
            'post_id' => $posts_id,
            'comment_content' => $data['comment_content'],
            'user_id' => $this->guard()->user()->id,
            'comment_reply_to' => $comment_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);
    }

    private function guard(){
        return Auth::guard('api');
    }
}
