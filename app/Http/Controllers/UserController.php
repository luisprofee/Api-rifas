<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store( Request $request )
    {
        $user = User::create([
            'name' => $request->name, 
            'identification' => $request->identification,
            'password' => bcrypt($request->password)    
        ]);

        return response()->json(["usuarios creado con exito"]);

    }
}
