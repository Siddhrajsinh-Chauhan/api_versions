<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Repositories\User\UserInterface as UserInterface;
use Exception;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = $this->user->getAll();
            return view("user.index", ["users" => $users]);
        } catch (Exception $e) {
            return redirect()->route('home')->withError($e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $user = $this->user;
            return view("user.form", ["user" => $user]);
        } catch (Exception $e) {
            return redirect()->route('users')->withError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id . ',id'
        ]);
        try {
            $message = "User detail created successfully.";
            if (isset($request->id) && !empty($request->id)) {
                $message = "User detail updated successfully.";
                $userModel = $this->user->find($request->id);

                if (!isset($userModel->id) && empty($userModel->id)) {
                    throw new Exception("User not found");
                }
            } else {
                $userModel = new User();
            }

            $userModel->name = $request->name;
            $userModel->email = $request->email;
            $userModel->save();

            return redirect()->route('users')->withSuccess($message);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        try {
            if (empty($id)) {
                throw new Exception("Invalid request");
            }

            $user = $this->user->find($id);

            if (!isset($user->id) && empty($user->id)) {
                throw new Exception("User not found");
            }

            return view('user.show', ['user' => $user]);
        } catch (Exception $e) {
            return redirect()->route('users')->withError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        try {
            if (empty($id)) {
                throw new Exception("Invalid input.");
            }

            $user = $this->user->find($id);
            if (!isset($user->id) && empty($user->id)) {
                throw new Exception("User not found");
            }

            return view("user.form", ["user" => $user]);
        } catch (Exception $e) {
            return redirect()->route('users')->withError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception("Not valid request.");
            }

            if (empty($request->id)) {
                throw new Exception("Invalid input.");
            }

            $user = $this->user->find($request->id);
            if (!isset($user->id) && empty($user->id)) {
                throw new Exception("User not found");
            }

            $user->delete();
            return response()->Json(["isSuccess" => "success", "message" => "User deleted successfully."]);
        } catch (Exception $e) {
            return response()->Json(["isSuccess" => "failure", "message" => $e->getMessage()]);
        }
    }
}
