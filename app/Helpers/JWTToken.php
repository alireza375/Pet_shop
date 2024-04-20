<?php

namespace App\Helpers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class JWTToken
{
    public static function CreateToken($userEmail):string{
        $key = env('JWT_KEY');
        $payload=[
            'iss' => 'laravel-token',
            'iat' => time(), //Token creation time
            'exp' => time()+60*60, //token expair time
            'userEmail' => $userEmail
        ];

        return JWT::encode($payload, $key, 'HS256');

    }

    public static function VeryfyToken($token):string|object{

        try{
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded->userEmail;
        }
        catch(Exception $e){
            return 'Unauthorized';
        }

    }
}




// class JWTToken{
//     public static function CreateToken($userEmail):string{
//         $key=env("JWT_KEY");
//         $payload=[
//             "iss"=> "laravel_token",
//             "iat"=>time(),
//             "exp"=>time()+60*70,
//             "userEmail"=> $userEmail,
//         ];
//        return JWT::encode($payload, $key, "HS256");

//     }

//     public static function verifyToken($token):string|object{
//         try{
//             $key=env("JWT_KEY");
//             $decode=JWT::decode($token, new Key($key,"HS256"));
//             return $decode->userEmail;
//         }
//         catch(Exception $e){
//             return "Unauthorized";
//         }

//     }


// }
