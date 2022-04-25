<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");


// JWT
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/jwt.php");

// USERS FUNCTIONS
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/adduser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/validateUser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/passwordOmission.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/resetPassword.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/identifyUser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/completeUserData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/getPrimaryUserData.php");




try {

    // REQUEST DATA
    $url = $_SERVER['REQUEST_URI'];
    $urlData = explode('/', (filter_var($url , FILTER_SANITIZE_URL)));
    $request = $urlData[3];
    $method = $_SERVER['REQUEST_METHOD'];
    $action = $urlData[4];


    // ***REQUESTS WITHOUT JWT*** //
    if( $request === "users" &&
        (($method === "POST" && ($action === "add" || $action === "identification")) ||
        ($method === "PATCH" && ($action === "confirm" || $action === "omission" || $action === "reset")))
      )
    {
        $data = json_decode(file_get_contents('php://input'));

        switch($method)
        {
            case "POST":
                if ( $action == 'add' )
                {
                    addUser($data);
                }
                else if ( $action == 'identification' )
                {
                    identifyUser($data);
                }
            break;
            case "PATCH":
                if ( $action == 'confirm' )
                {
                    validateUser($data);
                }
                else if ( $action == 'omission' )
                {
                    passwordOmission($data);
                }
                else if ( $action == 'reset' )
                {
                    resetPassword($data);
                }
            break;
        }
    }
    // ***SECURE REQUESTS WITH A JWT*** //
    else
    {
        //CHECK TOKEN PRESENCE
        if (isset($_SERVER['Authorization'])) {
            $token = trim($_SERVER['Authorization']);
        }
        elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = trim($_SERVER['HTTP_AUTHORIZATION']);
        }
        elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            if (isset($requestHeaders['Authorization'])) {
                $token = trim($requestHeaders['Authorization']);
            }
        }

        if($method === "POST" || $method === "GET" || $method === 'PATCH' || $method === 'DELETE')
        {
            if (!isset($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches))
            {
                http_response_code(401);
                $error = [
                    "error" => "Vous ne disposez pas des autorisations requises",
                    "code" => 401
                ];
                echo(json_encode($error));
                exit;
            }

            $token = str_replace('Bearer ', '', $token);
            $jwt = new JWT();

            // CHECK TOKEN SYNTAX VALIDITY
            if (!$jwt->validSyntax($token)) {
                http_response_code(401);
                $error = [
                    "error" => "Vous ne disposez pas des autorisations requises",
                    "code" => 401
                ];
                echo(json_encode($error));
                exit;
            }

            // CHECK TOKEN SIGNATURE
            if (!$jwt->check($token)) {
                http_response_code(401);
                $error = [
                    "error" => "Vous ne disposez pas des autorisations requises",
                    "code" => 401
                ];
                echo(json_encode($error));
                exit;
            }

            // CHECK TOKEN EXPIRATION
            if ($jwt->expired($token)) {
                http_response_code(401);
                $error = [
                    "error" => "Vous ne disposez pas des autorisations requises => Token expiré",
                    "code" => 401
                ];
                echo(json_encode($error));
                exit;
            }

            $payload = $jwt->getPayload($token);
            
            if (!isset($payload['user_id']) || empty($payload['user_id']) || !is_numeric($payload['user_id'])) {
                http_response_code(401);
                $error = [
                    "error" => "Vous ne disposez pas des autorisations requises",
                    "code" => 401
                ];
                echo(json_encode($error));
                exit;
            }

            $userid = $payload['user_id'];

            
            // CHECK REQUEST
            if($request === "users")
            {
                switch($method)
                {
                    case "POST":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'conclude' )
                        {
                            completeUserData($data, $userid);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                    case "PATCH":
                        // $data = json_decode(file_get_contents('php://input'));
                        // if ()
                        // {

                        // }
                        // else
                        // {
                        //     throw new Exception ("Requête invalide");
                        // }
                    break;
                    case "GET":
                        if ( $action == 'conclude' )
                        {
                            getPrimaryUserData($userid);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                }
            }
            else if ($request === 'likes')
            {

            }
            else
            {
                throw new Exception ("Requête invalide");
            }
        }
    }
}
catch(Exception $e) {

    http_response_code(400);
    $error = [
        "error" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    echo(json_encode($error));
}

?>