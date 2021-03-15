<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use App\Mail\AccountConfirmation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('api_jwt_auth', [ 'except' => ['login', 'register', 'forgotPassword'] ]);
    }

    /**
     * Get a JWT via given credentials.
    */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|string|email|max:255',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register new User and Get its JWT.
    */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:250',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = auth()->tokenById($user->id);
        Mail::to($user->email)->send(new AccountConfirmation($token, $user));

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
    */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Request Reset password and send email with token for password reset.
    */
    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users,email',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $user = User::where('email', $request->email)->first();
        $token = auth()->tokenById($user->id);
        Mail::to($user->email)->send(new PasswordReset($token, $user));

        return response()->json([ 'message' => 'Password reset email send successfully, check your inbox.' ], 200);
    }

    /**
     * Reset password.
    */
    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Get the token array structure.
    */
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
