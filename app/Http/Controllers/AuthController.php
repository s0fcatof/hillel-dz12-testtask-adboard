<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::query()
            ->where('username', '=', $credentials['username'])
            ->first();

        if ($user === null) {
            $user = User::create([
                'username' => $credentials['username'],
                'password' => Hash::make($credentials['password'])
            ]);
        } else {
            if (!Hash::check($credentials['password'], $user->password)) {
                return back()
                    ->withErrors(['password' => 'The provided password does not match the username.'])
                    ->withInput();
            }
        }

        Auth::login($user);
        $request->session()->regenerate();

        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
