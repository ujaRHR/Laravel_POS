<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken
{
    public static function createToken($userEmail, $userID) : string
    {
        $key     = env('JWT_KEY');
        $payload = [
            'iss'       => 'laravel_POS',
            'iat'       => time(),
            'exp'       => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userID'    => $userID
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function passwordResetToken($userEmail) : string
    {
        $key     = env('JWT_KEY');
        $payload = [
            'iss'       => 'laravel_POS',
            'iat'       => time(),
            'exp'       => time() + 60 * 15,
            'userEmail' => $userEmail,
            'userID'    => '0'
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }


    public static function verifyToken($token) : string|object
    {
        try {
            if ($token != null) {
                $key     = env('JWT_KEY');
                $decoded = JWT::decode($token, new Key($key, 'HS256'));

                return $decoded;
            } else {
                return 'unauthorized';
            }
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }
}