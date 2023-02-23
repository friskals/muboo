<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $request = $request->validated();

        $user = User::create($request);

        auth()->login($user);

        return redirect()->route('dashboard-analytics');
    }
}
