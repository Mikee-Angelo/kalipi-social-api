<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class EventsController extends Controller
{
    //
    public function create(Request $request){
        $validate = $request->validate([
            'event_name' => ['string', 'required'],
            'event_description' => ['string', 'required'],
            'event_start' => ['date', 'required'],
            'event_end' => ['date', 'required'],
            'event_payment' => ['numeric', 'required'],
            'event_payment_type' => ['required', 'numeric'],
        ]);

        if(!$validate){ 
            return response()->json($validator->errors()->toJson(), 400);
        }

        Events::create($validate);

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully'
        ], 201);

    }

    public function getAll(Request $request){
        $events = Events::get();

        return response()->json([
            'status' => true,
            'data' => $events
        ], 200);
    }

    public function get($event_id, Request $request){
        $events = Events::findorFail($event_id);

        return response()->json([
            'status' => true,
            'data' => $events
        ], 200);
    }
        
    public function update($event_id, Request $request){
        $validate = $request->validate([
            'event_name' => ['string', 'required'],
            'event_description' => ['string', 'required'],
            'event_start' => ['date', 'required'],
            'event_end' => ['date', 'required'],
            'event_payment' => ['numeric', 'required'],
            'event_payment_type' => ['required', 'numeric'],
        ]);

        if(!$validate){ 
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $datas = Events::findOrFail($event_id);

        $datas->update($validate);

        return response()->json([
            'status' => true,
            'message' => 'Updated Successfully'
        ], 201);

    }

    public function destroy($event_id, Request $request){
        $events = Events::findOrFail($event_id);

        $events->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully'
        ], 201);
    }
}
