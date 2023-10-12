<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
 
        event(new Registered($user));
 
        $device = substr($request->userAgent() ?? '', 0, 255);
        
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken($device)->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
 
        $device    = substr($request->userAgent() ?? '', 0, 255);
        $expiresAt = $request->remember ? null : now()->addMinutes(config('session.lifetime'));
 
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken($device, expiresAt: $expiresAt)->plainTextToken,
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
 
        return response()->noContent();
    }
}
