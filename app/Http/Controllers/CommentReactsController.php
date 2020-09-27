<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\CommentReacts;

class CommentReactsController extends Controller
{
    public function create($comment_id, Request $request){

        $data = Comments::where('id', $comment_id)->doesntExists();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        CommentReacts::create([
            'comment_id' => $comment_id,
            'user_id' => $this->guard()->user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);
    }

    public function destroy($comment_id, $comment_react_id, Request $request){
        $data = Comments::where('id', $comment_id)->doesntExists();

        if($data){ 
            return response()->json([
                'status' => false,
                'message' => 'Item Not Found'
            ], 400);
        }

        CommentReacts::where([
            ['user_id', '=', $this->guard()->user()->id],
            ['comment_id', '=', $comment_id],
            ['id', '=', $comment_react_id]
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
