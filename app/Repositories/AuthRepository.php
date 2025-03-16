<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

namespace App\Repositories;

use App\Http\Requests\AuthRequest;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(AuthRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt([
            'username' => $credentials['username'], 
            'password' => $credentials['password']])
        ) {
            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            // Set the token in an HTTP-only cookie
            $cookie = cookie('auth_token', $token, 60 * 24 * 7, null, null, false, true); // 1 week

            return response()->json(['user' => $user])->withCookie($cookie);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            // Delete the user's tokens
            $request->user()->tokens()->delete();
    
            // Remove the HTTP-only cookie
            $cookie = Cookie::forget('auth_token', null, null, '/', null, false, true);
    
            return response()->json(['message' => 'Logged out'])->withCookie($cookie);
        }

        return response()->json(['message' => 'No authenticated user'], 401);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
