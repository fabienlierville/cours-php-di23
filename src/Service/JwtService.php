<?php
namespace src\Service;

use Firebase\JWT\JWT;

class JwtService {
    public static String $secretKey = "cesi";

    public static function createToken(array $datas) : String{
        //$datas = Données personnelles qui seront dans le payload du JWT
        $issuedAt = new \DateTimeImmutable();
        $expire = $issuedAt->modify("+6 minutes")->getTimestamp();
        $serverName = "cesi.local";

        $data = [
            "iat" => $issuedAt->getTimestamp(),
            "iss" => $serverName,
            "nbf" => $issuedAt->getTimestamp(),
            "exp" => $expire,
            "data" => $datas
        ];

        $jwt = JWT::encode(
            $data,
            self::$secretKey,
            "HS256"
        );
        return $jwt;
    }
}