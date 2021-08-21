<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Registervalidate;
use App\Http\Requests\Loginvalidate;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Type\FalseType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

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
   
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
 
       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 

        $token = Auth::attempt($validator->validate());
        return response($token);
    
        if (!$token = Auth::attempt($validator->validate())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        
        return $this->createNewToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 5000000 * 60
        ]);
    }

    public function register(RegisterValidate $request) {    
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request['email'],
                'password' => Hash::make($request['password'])  
            ]);
            DB::commit();
            // $this->login($user);
            return response($user, 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('WEB /user/verify - Class ' . get_class() . ' - PDOException Error. Rollback was executed.' . $e->getMessage());
            return response()->json(config('error.databaseTransactionRollback'));
        }
    }
}
