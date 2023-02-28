<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $credentials = $request->getCredentials();
      
        if(!Auth::validate($credentials)){
                return redirect()->back()->withErrors(trans('auth.failed'));
        } 

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return redirect()->route('dashboard-analytics');
    }
}
