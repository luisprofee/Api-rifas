<?php

namespace App\Http\Controllers;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected function jwt(User $user)
    {
    	$datos = [
    	'name' 		            =>	$user->name,
    	'identification' 	    =>	$user->identification,
		'id'			        =>  $user->id,
    	'iat' 			        => time(),
        'exp' 			        => time() + 60*60
    	];

    	return JWT::encode($datos, env('JWT_SECRET'), 'HS256');
    }



    public function login(Request $request)
    {
    	$user = User::where('identification', $request->input('identification'))->first();
    	if(!$user)	return response()->json(["status"=>400, "data"=>"El usuario no existe"],404);
    	

    	if(Hash::check($request->input('password'),$user->password))
    	{
    		return response()->json(["status"=>200, "token"=> $this->jwt($user)]);
    	}
		
    	return response()->json(["status"=> 400, "data" => "Credenciales incorrectas"],400);

    	

    }

}
