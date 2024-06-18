<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return new PostResource(true, 'Data fetched successfully', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $post = Post::create($request->all());
        return new PostResource(true, 'Data stored successfully', $post);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if (is_null($post)) {
            return response()->json('Data not found', 404);
        }
        return new PostResource(true, 'Data fetched successfully', $post);
    }

    public function update(Request $request, $id)
    {
        // Find the post by id
        $post = Post::find($id);
        
        // Check if the post exists
        if (is_null($post)) {
            return response()->json('Data not found', 404);
        }
        
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // Update the post with the new data
        $post->update($request->all());
        
        return new PostResource(true, 'Data updated successfully', $post);
    }

    public function destroy($id)
    {
        // Find the post by id
        $post = Post::find($id);
        
        // Check if the post exists
        if (is_null($post)) {
            return response()->json('Data not found', 404);
        }
        
        // Delete the post
        $post->delete();
        
        return new PostResource(true, 'Data deleted successfully', $post);
    }
}
