<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!is_null($user) && Hash::check($request->password , $user->password)) {
            $user->api_token = Str::random(150);
            $user->save();
            return response()->json([ 'res' => true,'token' => $user->api_token, 'message' => 'Login correcto'], 200);
        } else {
            return response()->json([ 'res' => false, 'message' => 'Cuenta o password incorrectos'], 200);
        }
    }

    public function logout()
    {
        $user = auth()->user(); //usuario actualmente autenticado
        $user->api_token = null;
        $user->save();

        return \response()->json(['res' => true, 'message'=>'Adios'], 200);
    }
}
