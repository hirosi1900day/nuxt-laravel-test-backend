<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TemporaryRegister;
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
use App\Services\Auth\LoginServices;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemporaryRegisterMail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:users', ['except' => ['login', 'register','temporaryRegister']]);
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
 
        return LoginServices::login($validator, 'users');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('users')->user());
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

    public function register(RegisterValidate $request) {    
        
       
        DB::beginTransaction();
        try {
            $email = TemporaryRegister::where('status', false)->where('token', $request->email_token)->first()['email'];
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($request['password'])  
            ]);
            DB::commit();
            // $this->login($user);
            return response($user, 201);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('WEB /user/verify - Class ' . get_class() . ' - PDOException Error. Rollback was executed.' . $e->getMessage());
            return response($e->getMessage);
        }
    }

    public function temporaryRegister(Request $request) {
        
        // return response($validator);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        DB::beginTransaction();
        try{
            $token =  Str::random(20);
            TemporaryRegister::create([
                'email' => $request->email,
                'token' => $token
            ]);
            Mail::to($request)->send(new TemporaryRegisterMail($token));
            DB::commit();
            return response('メール送信に成功しました', 201);
        } catch(Exception $e){
            DB::rollBack();
            return response('メール送信に失敗しました', 401);
        }
    }
}
