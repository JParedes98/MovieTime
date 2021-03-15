<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAdminController extends Controller
{
     /**
     * Create a new UserAdminController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin_access', [ 'except' => [] ]);
        $this->middleware('api_jwt_auth', [ 'except' => [] ]);
    }

    /**
     * Display a listing of the users.
     */
    public function getAllUsers() {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Update the Rol of the specified user.
     */
    public function updateUserRol(Request $request, $user_id) {
        $user = User::findOrFail($user_id);
            $user->is_admin = !$user->is_admin;
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Remove the user with the specified ID.
    */
    public function deleteUser(Request $request, $user_id) {
        $user = User::findOrFail($user_id)->delete();
        return response()->json($user, 200);
    }
}
