<?php

namespace App\Http\Controllers\Api\v3;

use Exception;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;
use App\Http\Resources\UserCollection;

class UserController extends \App\Http\Controllers\Api\v2\UserController
{

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }

    public function index(Request $request)
    {
        try {
            $parametersToSelect = ["id", "name", "email", "status", "created_at"];
            $users = new UserCollection($this->user->getAllActiveUsers($parametersToSelect));
            $users = $users->additional(['message' => 'User listing']);

            return $users;
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => $this->status,
                    'message' => $e->getMessage(),
                    'data' => $this->response
                ],BAD_REQUEST);
        }
    }
}
