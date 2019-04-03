<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Repositories\User\UserInterface as UserInterface;

class LoginController extends \App\Http\Controllers\Api\v1\LoginController
{
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required",
            ]);

            if ($validator->fails()) {
                throw new Exception(implode(",", $validator->errors()->all()), BAD_REQUEST);
            }

            if (!Auth::guard()->attempt(
                [
                    'email' => $request->email,
                    'password' => $request->password,
                ]) ) {
                throw new Exception("Invalid user name or Password", BAD_REQUEST);
            }

            $user = $this->user->getUserByEmail($request->email, ["id", "name", "api_token", 'status', "created_at"]);

            if (!$user['status']) {
                throw new Exception("Email address not found in our database.", BAD_REQUEST);
            }

            if ($user['user']->status != User::STATUS_ACTIVE) {
                throw new Exception("Your account seems to be disabled. Please contact admin.", ACCEPTED);
            }

            $user['user']->forceFill([
                'api_token' => hash('sha256', $this->getApiToken()),
            ])->save();

            return response()->json(['status' => true, 'data' => $user['user'], 'message' => "Login Successfully."]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => $this->status,
                    'message' => $e->getMessage(),
                    'data' => (object)$this->response
                ], $e->getCode());
        }
    }

}
