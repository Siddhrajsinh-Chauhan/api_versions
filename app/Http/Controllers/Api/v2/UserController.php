<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;

class UserController extends \App\Http\Controllers\Api\v1\UserController
{

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }

    public function index(Request $request){
        try {
            $parametersToSelect = ["id", "name", "created_at"];
            $users = $this->user->getAllActiveUsers($parametersToSelect);
            return response()->json(['status' => true, 'data' => $users, 'message' => "User listing."]);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => $this->status,
                    'message' => $e->getMessage(),
                    'data' => $this->response
                ], $e->getCode());
        }
    }
}
