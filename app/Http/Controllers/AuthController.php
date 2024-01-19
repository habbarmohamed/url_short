<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
/**
* Create a new AuthController instance.
*
* @return void
*/
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
/**
* Get a JWT via given credentials.
*
* @return \Illuminate\Http\JsonResponse
*/
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        
        return response()->json(['user' => $user]);
    }
/**
* Get a JWT via given credentials.
*
* @return \Illuminate\Http\JsonResponse
*/
    public function login(Request $request)
    {
        if (request(['email', 'password'])) {
            // $credentials = request(['email', 'password']);
            $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => 1];
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        }
    }
/**
* Get the authenticated User.
*
* @return \Illuminate\Http\JsonResponse
*/
    public function me(Request $request)
    {
        $user = auth('api')->user();
        $user->notifications;
        $user->unreadNotifications;
        $user->role;
        $user->role->acces;
        $token = $request->token;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            // 'roles' => $this->guard_roles(),
            // 'permissions' => $this->guard_permissions_role(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60000,
        ]);
    }
    
    
    
    //  public function me(Request $request)
    // {
    //     $token = $request->token;
    //     return $this->respondWithToken($token);
    //     // return response()->json(auth('api')->user());
    // }
/**
* Log the user out (Invalidate the token).
*
* @return \Illuminate\Http\JsonResponse
*/
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
/**
* Refresh a token.
*
* @return \Illuminate\Http\JsonResponse
*/
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
/**
* Get the token array structure.
*
* @param string $token
*
* @return \Illuminate\Http\JsonResponse
*/
    protected function respondWithToken($token)
    {
        $user = Auth::Guard('api')->user();
        $user->notifications;
        $user->unreadNotifications;
        $user->role;
        $user->role->acces;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            // 'roles' => $this->guard_roles(),
            // 'permissions' => $this->guard_permissions_role(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60000,
        ]);
    }

    // public function guard(){
    //     return Auth::Guard('api')->user();
    // }
    // public function guard_roles(){
    //     return Auth::Guard('api')->user()->role;
    // }
    // public function guard_permissions_role(){
    //    $role = Auth::Guard('api')->user()->role->acces;
    //     // if(isset($role)) {
    //     //     foreach($role as $roles) {
    //     //         $roles->accesroles;
    //     //     }
    //     // }
        
    //     return $role;
    // }
}