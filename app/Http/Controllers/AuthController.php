<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * login.
     */
    public function login(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required|string',
                'password' => 'required|string',
            ]
        );

        if ($validateUser->fails()) {
            return ResponseFormatter::error(null, $validateUser->errors(), 401);
        }

        $request['username'] = Str::lower($request->username);

        $token = Auth::attempt($request->only(['username', 'password']));

        if (! $token) {
            return ResponseFormatter::error(null, 'Error Login', 401);
        }

        $user = Auth::user();

        $data = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ];

        return ResponseFormatter::success($data, 'Login Succesfull', 200);
    }

    /**
     * register.
     */
    public function register(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required|string|unique:users,username',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string',
            ]
        );

        if ($validateUser->fails()) {
            return ResponseFormatter::error(null, $validateUser->errors(), 401);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        $data = [
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ];

        return ResponseFormatter::success($data, 'Register Succesfull', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
