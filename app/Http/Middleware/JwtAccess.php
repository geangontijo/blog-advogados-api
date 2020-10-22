<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;

class JwtAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jwtString = str_replace('Bearer ','',$request->header('Authorization'));
        try {

            $obj = JWT::decode($jwtString, env('JWT_TOKEN'), ['HS256']);
            $user = DB::table('users')->where('email', '=', $obj->email)->first();
        }catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => 'Não autorizado',
                'data' => [
                    'token' => $jwtString
                ]
            ], 401);
        }

        if (!empty($user)) {
            define('USER_REQUEST',json_encode($user));
            return $next($request);
        } else
            return response()->json([
                'status' => false,
                'message' => 'Não autorizado',
                'data' => [
                    'token' => $jwtString
                ]
            ], 401);
    }
}
