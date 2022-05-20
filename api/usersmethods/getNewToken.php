<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/jwt.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/includes/config.php");



function getNewToken($REFRESH_TOKEN_COOKIE)
{
    // var_dump($REFRESH_TOKEN_COOKIE);
    $jwt = new JWT();

    // CHECK TOKEN SYNTAX VALIDITY
    if (!$jwt->validSyntax($REFRESH_TOKEN_COOKIE)) {
        http_response_code(206);
        exit;
    }

    // CHECK TOKEN SIGNATURE
    if (!$jwt->check($REFRESH_TOKEN_COOKIE, COOKIE_TOKEN_SECRET)) {
        http_response_code(206);
        exit;
    }

    // CHECK TOKEN EXPIRATION
    if ($jwt->expired($REFRESH_TOKEN_COOKIE)) {
        http_response_code(206);
        exit;
    }

    $payload = $jwt->getPayload($REFRESH_TOKEN_COOKIE);


    // JWT CREATION
    $header = [
        "alg" => "HS256",
        "typ" => "JWT"
    ];

    $payload = [
        "user_id" => $payload['user_id'],
        "lastname" => $payload['lastname'],
        "firstname" => $payload['firstname'],
        "username" => $payload['username'],
        "email" => $payload['email'],
        "lat" => $payload['lat'],
        "lng" => $payload['lng'],
        "thumbnail" => $payload['thumbnail']
    ];

    $jwtInstance = new JWT();
    $jwt = $jwtInstance->generate($header, $payload);
    //_________________________


    // USER DATA
    $userData = [
        "user" => [
            "user_id" => $payload['user_id'],
            "lastname" => $payload['lastname'],
            "firstname" => $payload['firstname'],
            "username" => $payload['username'],
            "email" => $payload['email'],
            "lat" => $payload['lat'],
            "lng" => $payload['lng'],
            "thumbnail" => $payload['thumbnail']
        ],
        "EXPIRE_IN" => 3600,
        "AUTH_TOKEN" => $jwt
    ];
    //_________________________


    echo json_encode($userData);
    http_response_code(200);
}



?>