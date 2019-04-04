<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Repositories\User\UserInterface as UserInterface;

class LoginController extends BaseController
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }

    /**
     * @return string
     */
    protected function getApiToken()
    {
        return \Str::random(60);
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
                throw new Exception(explode(",", $validator->errors()->all()), BAD_REQUEST);
            }

            if (!Auth::guard()->attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new Exception("Invalid user name or Password", BAD_REQUEST);
            }

            $user = $this->user->getUserByEmail($request->email, ["id", "name", "api_token", "created_at"]);

            if (!$user['status']) {
                throw new Exception("Email address not found in our database.", BAD_REQUEST);
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


    /*
     * return void
     * */
    public function logout()
    {
        try {
            auth()->guard("api")->user()->forceFill(["api_token" => null])->save();
            return response()->json(
                [
                    'status' => true,
                    'data' => (object)$this->response,
                    'message' => "You have successfully logout."
                ]);
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
