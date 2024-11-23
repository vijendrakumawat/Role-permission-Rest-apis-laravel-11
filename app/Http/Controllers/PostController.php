<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        // $data = Post::all();
        return Post::get();
    }
    public function store(Request $request)
    {
        // dd(auth()->user()->getRoleNames());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',

        ]);
        if ($validator->fails()) {
            return responce()->json($validator->error(), 422);
        }
        $user = auth()->user();
        // dd($user);
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = $user->id;
        $post->save();
        return response()->json(['message' => 'User create  successfully', 'post' => $post], 200);
    }
    public function update(Request $request, $id)
    {
        $post = Post::findorfail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',

        ]);
        if ($validator->fails()) {
            return responce()->json($validator->error(), 422);
        }
        $post->update($request->all());
        return response()->json($post);
    }
    public function destroy($id)
    {
        $post = Post::findorfail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
