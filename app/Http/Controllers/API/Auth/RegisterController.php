<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Summary of store
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : Response
    {
        $request->validate([
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'type' => ['required', 'string', Rule::in(['client', 'staff'])],
            'isAdmin' => 'required|boolean'
        ]);

        // Hash the user password before saving to the database
        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->all());

        $token = $user->createToken('bankapi')->plainTextToken;

        return response([
            'status' => 201,
            'data' => array_merge($user->toArray(), ['token' => $token])
        ], 201);
    }
}
