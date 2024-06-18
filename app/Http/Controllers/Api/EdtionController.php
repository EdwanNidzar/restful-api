<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edtion;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class EdtionController extends Controller
{
    public function index()
    {
        $edtions = Edtion::all();
        return new PostResource(true, 'Data fetched successfully', $edtions);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'release_date'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $edtion = Edtion::create($request->all());
        return new PostResource(true, 'Data stored successfully', $edtion);
    }

    public function show($id)
    {
        $edtion = Edtion::find($id);
        if (is_null($edtion)) {
            return response()->json('Data not found', 404);
        }
        return new PostResource(true, 'Data fetched successfully', $edtion);
    }

    public function update(Request $request, $id)
    {
        $edtion = Edtion::find($id);
        if (is_null($edtion)) {
            return response()->json('Data not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'release_date'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $edtion->update($request->all());
        return new PostResource(true, 'Data updated successfully', $edtion);
    }

    public function destroy($id)
    {
        $edtion = Edtion::find($id);
        if (is_null($edtion)) {
            return response()->json('Data not found', 404);
        }

        $edtion->delete();
        return new PostResource(true, 'Data deleted successfully', $edtion);
    }
}
