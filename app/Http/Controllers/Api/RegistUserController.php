<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistUserController extends Controller
{

    public function store(RegistUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            $user->remember_token = $user->createToken('auth_token', ['*'], now()->addWeek())->plainTextToken;
            $user->save();
            $user->access_token = $user->remember_token;
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => ['message' => 'invalid regist']]);
        }
    }
}