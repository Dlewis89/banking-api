<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\StoreRequest;
use App\Macros\ResponseMacro;
use App\Services\UserService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $request->mergeIfMissing([
                'type' => 'client',
                'is_admin' => false
            ]);

            $user = $this->userService->create($request->validated());

            $token = $user->createToken('banking');

            $user = $this->userService->append_token_to_user($user, $token);

            return response()->success($user, 201);
        } catch(Exception $e) {
            return response()->errorResponse([
                "message" => "failed to create new user"
            ], 401);
        }
    }
}
