<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/jsonHandler.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

$tokenSecret = 'waduhtokensecretkokditaruhsini';

function encodeToken($data)
{
    global $tokenSecret;
    $token = array(
        'iss' => 'http://localhost/tribone-api',
        'iat' => time(),
        'exp' => time() + 3600, // 1hr
        'data' => $data
    );
    return JWT::encode($token, $tokenSecret, 'HS256');
}

function decodeToken($token)
{
    global $tokenSecret;
    try {
        $decode = JWT::decode($token, new Key($tokenSecret, 'HS256'));
        return $decode->data;
    } catch (ExpiredException | SignatureInvalidException $e) {
        jsonHandler(401, $e->getMessage());
    } catch (UnexpectedValueException | Exception $e) {
        jsonHandler(400, $e->getMessage());
    }
}


?>