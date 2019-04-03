<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface as UserInterface;

class UserController extends BaseController
{
    protected  $user;
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        parent::__construct($user);
    }

    public function index(Request $request){
        try {
            $parametersToSelect = ["id", "name", "api_token", "created_at"];
            $users = $this->user->getAll($parametersToSelect, false);
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
