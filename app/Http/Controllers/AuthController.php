<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use AuthorizesRequests; // Ensure this trait is present

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
    //     $this->middleware('permission:create-user', ['only' => ['create','store']]);
    //     $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    // }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);
        if ($validator->fails()) {
            return responce()->json($validator->error(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password),
        ]);
        //$user = User::find(1); // Replace with your user ID
        $user->assignRole($request->role); // Assign the admin role
        
        return response()->json(['messsage' => 'user registered successfully']);
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        // if (!$user || $user->status !== 'active') {
        //     return response()->json(['error' => 'User is not active or does not exist.'], 403);
        // }
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $user = auth('api')->user();

        return response()->json(['token' => $token], 200);

    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user->update($request->only([
            'name',
        ]));
        return response()->json(['message' => 'Profile updated successfully'], 200);
    }

    public function destroy($id)
    {

        $this->authorize('create-delete-users');

        $user = User::find($id);
        $posts = Post::where('user_id', $id)->get();
        foreach ($posts as $post) {
            $post->delete();
        }

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted  successfully'], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

}
