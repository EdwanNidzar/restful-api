<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bulletin;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class BulletinController extends Controller
{
    public function index()
    {
       $bulletins = Bulletin::all();
       return new PostResource(true, 'Bulletin retrieved successfully.', $bulletins);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'page_count' => 'required',
            'cover_image' => 'required',
            'url_bulletin' => 'required',
            'status' => 'required',
            'release_status' => 'required',
            'edition_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bulletin = Bulletin::create($request->all());
        return new PostResource(true, 'Bulletin created successfully.', $bulletin);
    }

    public function show($id)
    {
        $bulletin = Bulletin::find($id);

        if (is_null($bulletin)) {
            return response()->json('Bulletin not found', 404);
        }

        return new PostResource(true, 'Bulletin retrieved successfully.', $bulletin);
    }

    public function update(Request $request, $id)
    {
        $bulletin = Bulletin::find($id);

        if (is_null($bulletin)) {
            return response()->json('Bulletin not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'page_count' => 'required',
            'cover_image' => 'required',
            'url_bulletin' => 'required',
            'status' => 'required',
            'release_status' => 'required',
            'edition_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $bulletin->update($request->all());
        return new PostResource(true, 'Bulletin updated successfully.', $bulletin);
    }

    public function destroy($id)
    {
        $bulletin = Bulletin::find($id);

        if (is_null($bulletin)) {
            return response()->json('Bulletin not found', 404);
        }

        $bulletin->delete();
        return new PostResource(true, 'Bulletin deleted successfully.', $bulletin);
    }
}
