<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LoginServices {
   public static function login($validator, $guard) {
      if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
     }

     if (!$token = Auth::guard($guard)->attempt($validator->validate())) {
         return response()->json(['error' => 'Unauthorized'], 401);
     }
     
     return self::createNewToken($token);
   }

   protected static function createNewToken($token){
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth('users')->factory()->getTTL() * 60
      ]);
  }
}