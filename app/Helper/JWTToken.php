<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken
{

    public static function createToken($userEmail): string
    {

        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'lara-token',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public static function createTokenForResetPass($userEmail): string
    {

        $key = env('JWT_KEY');

        $payload = [
            'iss' => 'reset-token',
            'iat' => time(),
            'exp' => time() + 60,
            'userEmail' => $userEmail,
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }

    public static function verifyToken($token)
    {

        try {
            $key = env('JWT_KEY');

            $decodedToken =  JWT::decode($token, new Key($key, 'HS256'));
            return $decodedToken->userEmail;
        } catch (Exception $e) {
            return 'unauthorized';
        }
    }
}
