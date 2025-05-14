<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        return response()
                ->json(['message'=> 'User Registered Successfully',
                'User'=> $user]);
    }

    public function login(Request $request)
    {
        // we dont have make a FormRequest for this simple case 
        $validated = $request->validate([
            'email'=>'string|required|email',
            'password'=>'string|required'
        ]);
        if(!Auth::attempt($validated))
        {
            return response()->json(['message'=>'Invalid email or password',401]);
        }
        else
        {
            $user = User::where('email',$request->email)->first();
            $token = $user->createToken('auth_Token')->plainTextToken;
            return response()
            ->json(['message'=> 'User LogedIn Successfully',
            'User'=> $user,
            'Token'=> $token]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()
                ->json([
                    'message'=> 'User LogOut Successfully',
                ]);
    }
}
