<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
    ){
    }

    public function login(UserAuthRequest $request)
    {
        $token = $this->authService->login($request->getDto());
        
        if ($token) {
            return new SuccessResponse(
                ['token' => $token]
            );
        }

        return new ErrorResponse([], __('Invalid credentials.'));
    }

    public function user(Request $request)
    {
        return new SuccessResponse($request->user());
    }
}
