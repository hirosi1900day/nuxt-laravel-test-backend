<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->withHeaders([
        'Access-Control-Allow-Origin' => 'http://localhost:3000',
        'Access-Control-Allow-Credentials' => true,
        'Access-Control-Allow-Headers' => '*' 
        ]);
        return $response;
    }
}
