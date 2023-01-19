<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    /**
     * Summary of store
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request) : Response
    {
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
