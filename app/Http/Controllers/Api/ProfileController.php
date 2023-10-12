<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class ProfileController extends Controller
{
    //
    public function updateUserInfos(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string']
        ]);
 
        auth()->user()->update($validatedData);
 
        return response()->json([
            'user' => auth()->user()
        ], Response::HTTP_ACCEPTED);
    }

    public function updateUserPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required'],
        ]);
        
        auth()->user()->update([
            'password' => Hash::make($request->input('password')),
        ]);
 
        return response()->json([
            'message' => 'Your password has been updated.',
        ], Response::HTTP_ACCEPTED);
    }
}