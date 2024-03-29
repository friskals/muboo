<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request = $request->validated();
        
        $request['password'] = Hash::make($request['password']);

        $user = User::create($request);

        auth()->login($user);

        return redirect()->route('home');
    }

    public function registerPage(){
        return view('content.authentications.auth-register-basic');
    }
}
