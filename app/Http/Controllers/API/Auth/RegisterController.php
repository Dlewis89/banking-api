<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends Controller
{
    /**
     * Summary of store
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request) : JsonResponse
    {
        try {
            // Hash the user password before saving to the database
            $request['password'] = Hash::make($request['password']);

            $user = User::create($request->all());

            $token = $user->createToken('bankapi')->plainTextToken;

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'data' => array_merge($user->toArray(), ['token' => $token])
            ], Response::HTTP_CREATED);
        } catch(Exception $e) {
            return response()->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error' => 'User can not be created'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
