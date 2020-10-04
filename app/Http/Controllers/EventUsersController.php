<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Events;
use App\Models\EventUsers;
use App\Models\User;

class EventUsersController extends Controller
{
    //
    public function create($event_id, Request $request){
        $event = Events::findOrFail($event_id);

        EventUsers::create([
            'event_id' => $event_id,
            'user_id' => $this->guard()->user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);
    }

    public function getAll(Request $request){
        $user = User::findOrFail($this->guard()->user()->id);

        return response()->json([
            'status' => true,
            'data' => $user->event_users[0]->event
        ], 200);
    }

    public function getSingle($events_id, Request $request){
        $event = Events::findOrFail($events_id);

        return response()->json([
            'status' => true,
            'data' => $event->makeHidden('id')
        ], 200);
    }

    private function guard(){
        return Auth::guard('api');
    }
}
