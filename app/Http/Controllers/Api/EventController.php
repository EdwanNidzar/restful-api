<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Handle image upload as a method to reuse
    private function handleImageUpload($image)
    {
        if ($image) {
            $path = $image->storeAs('public/events', $image->hashName());
            return $image->hashName();
        }
        return null;
    }

    public function index()
    {
        $events = Event::all();
        return new PostResource(true, 'Events retrieved successfully.', $events);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), 
        [
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'event_location' => 'required|string|max:255',
            'event_address' => 'required|string|max:255',
            'event_image' => 'required|image|max:2048',
            'event_organization' => 'required|string|max:255',
            'event_contact' => 'required|string|max:255',
            'event_status' => 'required|string|max:255',
            'submission_status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $imageName = $this->handleImageUpload($request->file('event_image'));

        $event = Event::create([
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_name' => $request->event_name,
            'event_description' => $request->event_description,
            'event_location' => $request->event_location,
            'event_address' => $request->event_address,
            'event_image' => $imageName,
            'event_organization' => $request->event_organization,
            'event_contact' => $request->event_contact,
            'event_status' => $request->event_status,
            'submission_status' => $request->submission_status,
            'notes' => $request->notes ?? '',
        ]);

        return new PostResource(true, 'Event created successfully.', $event);
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        return new PostResource(true, 'Event retrieved successfully.', $event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        $validator = Validator::make($request->all(), 
        [
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string',
            'event_location' => 'required|string|max:255',
            'event_address' => 'required|string|max:255',
            'event_image' => 'nullable|image|max:2048',
            'event_organization' => 'required|string|max:255',
            'event_contact' => 'required|string|max:255',
            'event_status' => 'required|string|max:255',
            'submission_status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $imageName = $event->event_image; // Preserve the existing image name if no new image is uploaded
        if ($request->hasFile('event_image')) {
            // Delete the old image
            Storage::delete('public/events/' . $event->event_image);
            $imageName = $this->handleImageUpload($request->file('event_image'));
        }

        $event->update([
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'event_name' => $request->event_name,
            'event_description' => $request->event_description,
            'event_location' => $request->event_location,
            'event_address' => $request->event_address,
            'event_image' => $imageName,
            'event_organization' => $request->event_organization,
            'event_contact' => $request->event_contact,
            'event_status' => $request->event_status,
            'submission_status' => $request->submission_status,
            'notes' => $request->notes ?? '',
        ]);

        return new PostResource(true, 'Event updated successfully.', $event);
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if (is_null($event)) {
            return response()->json(['success' => false, 'message' => 'Event not found'], 404);
        }

        // Delete the event image
        Storage::delete('public/events/' . $event->event_image);

        $event->delete();
        return new PostResource(true, 'Event deleted successfully.', null);
    }
}
