<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{

    public function handle(Request $request, Closure $next) : Response
    {
        $token  = $request->cookie('token');
        $result = JWTToken::verifyToken($token);

        if ($result == 'unauthorized') {
            return redirect('/user-login');
        } else {
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userID);
            return $next($request);
        }
    }
}
