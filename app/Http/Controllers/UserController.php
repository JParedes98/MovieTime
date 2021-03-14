<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin_access', [ 'except' => [] ]);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers() {
        $users = User::select('id', 'name', 'email', 'is_admin')->get();
        return response()->json($users, 200);
    }

    /**
     * Update the Rol of the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserRol(Request $request, $user_id) {
        $user = User::findOrFail($user_id);
            $user->is_admin = !$user->is_admin;
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the user with the specified ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request, $user_id) {
        $user = User::findOrFail($user_id)->delete();
        return response()->json($user, 200);
    }
}
