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

    public function login(UserAuthRequest $userAuthRequest)
    {
        $tokenDto = $this->authService->login($userAuthRequest->getDto());
        
        if ($tokenDto) {
            return new SuccessResponse($tokenDto->toArray());
        }

        return new ErrorResponse([], __('Invalid credentials.'));
    }

    public function user(Request $request)
    {
        return new SuccessResponse($this->authService->format($request->user()));
    }

    public function logout(): SuccessResponse
    {
        $this->authService->logout();

        return new SuccessResponse();
    }
}
