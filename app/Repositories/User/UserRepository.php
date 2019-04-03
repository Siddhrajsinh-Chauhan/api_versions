<?php

namespace App\Repositories\User;

use App\Repositories\User\UserInterface as UserInterface;
use App\User;

class UserRepository implements UserInterface
{
    protected  $status = true;

    public function __construct()
    {
    }

    /*
     * return array of users object
     * */
    public function getAll($selectParams = "*", $flag = true)
    {
        if ($flag)
            return User::select($selectParams)->where("id", "!=", auth()->user()->id)->get();

        return User::select($selectParams)->where("id", "!=", auth()->guard('api')->user()->id)->get();
    }

    /*
     * return array of users object
     * */
    public function getAllActiveUsers($selectParams = "*")
    {
        return User::select($selectParams)->where("id", "!=", auth()->guard('api')->user()->id)->where('status', User::STATUS_ACTIVE)->get();
    }

    /*
     * return user object if user find by id
     * return object
     * */
    public function find($id)
    {
        return User::find($id);
    }

    /*
     * remove user object
     * return void
     * */
    public function delete($id)
    {
        return User::find($id)->delete();
    }

    /*
     * email : string
     * return object
     * */
    public function getUserByEmail($email, $selectParams = "*")
    {
        try {
            $user = User::select($selectParams)->where("email", $email)->firstOrFail();
            return ["user" => $user, 'status' => $this->status];
        } catch (\Exception $e) {
            return ["user" => $e->getMessage(), 'status' => false];
        }
    }
}