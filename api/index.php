<?php


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, X-PINGOTHER");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");
header("Access-Control-Allow-Credentials: true");


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
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/logoutUser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/getNewToken.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/getProfileData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/updateUserData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/getUsers.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/getFilteredUsers.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/checkUserStatus.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/getUserProfileData.php");

// LIKES FUNCTIONS
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/likesmethods/addlike.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/likesmethods/deletelike.php");

// BLOCKED FUNCTIONS
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/blockedmethods/addBlocking.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/blockedmethods/deleteBlocking.php");






try {

    // REQUEST DATA
    $url = $_SERVER['REQUEST_URI'];
    $urlData = explode('/', (filter_var($url , FILTER_SANITIZE_URL)));
    $request = $urlData[3];
    $method = $_SERVER['REQUEST_METHOD'];
    if(isset($urlData[4]) && !empty($urlData[4])) {
        $action = $urlData[4];
    }
    if(isset($urlData[5]) && !empty($urlData[5])) {
        $object = $urlData[5];
    }
    

    // ***REQUESTS WITHOUT JWT*** //
    if( $request === "users" &&
        ( ($method === "POST" && ($action === "add" || $action === "identification")) ||
          ($method === "PATCH" && ($action === "confirm" || $action === "omission" || $action === "reset")) ||
          ($method === "GET" && $action === "checking")
        )
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
            case "GET":
                if ( $action == 'checking' )
                {
                    if(isset($_COOKIE['REFRESH_TOKEN']) && !empty($_COOKIE['REFRESH_TOKEN']))
                    {
                        http_response_code(400);
                    }
                    else
                    {
                        http_response_code(200);
                    }
                }
            break;
        }
    }
     // ***REQUEST NEW TOKEN*** //
    elseif($request === "users" && $action === "token" && $method === "POST")
    {
        if(isset($_COOKIE['REFRESH_TOKEN']) && !empty($_COOKIE['REFRESH_TOKEN'])) {
            getNewToken($_COOKIE['REFRESH_TOKEN']);
        }
        else {
            http_response_code(206);
            exit;
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

        if($method === "POST" || $method === "GET" || $method === 'PATCH' || $method === 'DELETE') // FOR AVOID CORS ERRORS /!\
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
                header("HTTP/1.1 401 expired token");
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
                        elseif ( $action == 'logout' )
                        {
                            logoutUser($userid);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                    case "PATCH":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'profile' )
                        {
                            updateUserData($data, $userid, $object);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                    case "GET":
                        if ( $action == 'conclude' )
                        {
                            getPrimaryUserData($userid);
                        }
                        elseif ( $action == 'profile' )
                        {
                            getProfileData($userid);
                        }
                        elseif ( $action == 'users' )
                        {
                            getUsers($userid);
                        }
                        elseif( $action == 'filter' )
                        {
                            if ( isset($_GET['minAge']) && isset($_GET['maxAge']) &&
                                 isset($_GET['minPop']) && isset($_GET['maxPop']) &&
                                 isset($_GET['minGap']) && isset($_GET['maxGap']) &&
                                 isset($_GET['minTag']) && isset($_GET['maxTag']) )
                            {
                                getFilteredUsers(
                                    $userid, $_GET['minAge'], $_GET['maxAge'], $_GET['minPop'], $_GET['maxPop'],
                                    $_GET['minGap'], $_GET['maxGap'], $_GET['minTag'], $_GET['maxTag']
                                );
                            }
                            else
                            {
                                http_response_code(400);
                            }
                        }
                        elseif ( $action == 'status' )
                        {
                            checkUserStatus($userid, $object);
                        }
                        elseif ( $action == 'data' )
                        {
                            getUserProfileData($userid, $object);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                    case "DELETE":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'profile' )
                        {
                            updateUserData($data, $userid, $object);
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
                switch($method)
                {
                    case "POST":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'add' )
                        {
                            addLike($userid, $data);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                    case "DELETE":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'delete' )
                        {
                            deleteLike($userid, $data);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                }
            }
            else if ($request === 'blocked')
            {
                switch($method)
                {
                    case "POST":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'add' )
                        {
                            addBlocking($userid, $data);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                    case "DELETE":
                        $data = json_decode(file_get_contents('php://input'));
                        if ( $action == 'delete' )
                        {
                            deleteBlocking($userid, $data);
                        }
                        else
                        {
                            throw new Exception ("Requête invalide");
                        }
                    break;
                }
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