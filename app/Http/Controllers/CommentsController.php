<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;

class CommentsController extends Controller
{
    //
    public function create($posts_id, Request $request){
        $data = $request->validate([
            'post_id' => ['required', 'numeric', 'exists:posts,id'],
            'comments_content' => ['required', 'string']
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Comments::create([
            'post_id' => $data['post_id'],
            'comments_content' => $data['comments_content'],
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
        ], 201);
    }

    public function update($comments_id, Request $request){
        $data = $request->validate([
            'comments_id' => ['required', 'numeric', 'exists:comments,id'],
            'comments_content' => ['required', 'string']
        ]);

        if(!$data){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Comments::where('id', $comments_id)->update([
            'comments_content' => $data['comments_content'],
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

    private function guard(){
        return Auth::guard();
    }
}
