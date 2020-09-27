<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function get($id, Request $request){
        $data = User::with('posts')->find($id);

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 201);
    }
}
