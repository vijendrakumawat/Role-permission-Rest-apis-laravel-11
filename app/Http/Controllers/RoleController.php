<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
       public function store(Request $request)
            {
        $validator = Validator:: make($request->all(),[
            'name' =>'required|string|max:255',
            
        ]);
        if($validator->fails()){
            return responce()->json($validator->error(),422);
        }
        $user = Role::create([
            'name' =>$request->name,
        
        ]);
        return response()->json(['messsage' =>'Role Management created successfully']);
        }
}
