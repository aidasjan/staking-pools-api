<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Retrieves the profile data of the currently authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function self(Request $request)
    {
        return $request->user();
    }

    /**
     * Update the authenticated user's data.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateSelf(Request $request)
    {
        $this->validateUserData($request);

        return $this->userService->updateUser($request->user(), $request);
    }

    /**
     * Validate the user data.
     *
     * @param Request $request
     * @return void
     */
    private function validateUserData(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ];

        $this->validate($request, $rules);
    }
}
