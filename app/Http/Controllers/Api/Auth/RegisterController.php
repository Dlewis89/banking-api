<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\StoreRequest;
use App\Macros\ResponseMacro;
use App\Services\UserService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\User;
use App\Models\Role;

class RegisterController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }
    public function store(StoreRequest $request): JsonResponse
    {
        try {

            $role = Role::firstWhere('name', $request->type ?? 'client');

            $user = User::create($request->validated());

            $token = $user->createToken('banking');

            $role->users()->attach($user);

            $user = $this->userService->append_token_to_user($user, $token);

            return response()->success($user, 201);
        } catch(Exception $e) {
            report($e);
            return response()->errorResponse("failed to create new user", 401);
        }
    }
}
