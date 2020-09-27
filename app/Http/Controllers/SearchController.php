<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Searches extends Controller
{
    //
    public function get($slug, Request $request){
        $data = User::where([
            ['name', 'like', '%'.$slug.'%'],
            ['id', '!=', 1]
        ])->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ], 201);
    }
}
