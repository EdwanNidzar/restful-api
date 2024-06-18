<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return new PostResource(true, 'Event retrieved successfully.', $events);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_date' => 'required',
            'event_time' => 'required',
            'event_name' => 'required',
            'event_description' => 'required',
            'event_location' => 'required',
            'event_address' => 'required',
            'event_image' => 'required',
            'event_organization' => 'required',
            'event_contact' => 'required',
            'event_status' => 'required',
            'submission_status' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('event_image');
        if ($image) {
            $image->storeAs('public/events', $image->hashName());
        }

        $event = Event::create([
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_name' => $request->event_name,
            'event_description' => $request->event_description,
            'event_location' => $request->event_location,
            'event_address' => $request->event_address,
            'event_image' => $image->hashName(),
            'event_organization' => $request->event_organization,
            'event_contact' => $request->event_contact,
            'event_status' => $request->event_status,
            'submission_status' => $request->submission_status,
            'notes' => $request->notes ??  '',
        ]);

        return new PostResource(true, 'Event created successfully.', $event);
    }
}
