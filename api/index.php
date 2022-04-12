<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");


// USERS FUNCTIONS
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/adduser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/validateUser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/passwordOmission.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/resetPassword.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/identifyUser.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/completeUserData.php");




try {

    // REQUEST DATA
    $url = $_SERVER['REQUEST_URI'];
    $urlData = explode('/', (filter_var($url , FILTER_SANITIZE_URL)));
    $request = $urlData[3];
    $method = $_SERVER['REQUEST_METHOD'];


    // CHECK REQUEST
    if($request === "users")
    {
        switch($method)
        {
            case "POST":
                $data = json_decode(file_get_contents('php://input'));
                $action = $urlData[4];
                if ( $action == 'add' )
                {
                    addUser($data);
                }
                else if ( $action == 'conclude' )
                {
                    completeUserData($data);
                }
                else if ( $action == 'identification' )
                {
                    identifyUser($data);
                }
                else
                {
                    throw new Exception ("Requête invalide");
                }
            break;
            case "PATCH":
                $data = json_decode(file_get_contents('php://input'));
                $action = $urlData[4];
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
                else
                {
                    throw new Exception ("Requête invalide");
                }
            break;
            case "GET":
                // if (isset($_GET['username']) && isset($_GET['token']))
                // {
                //     confirmUserRegistration($_GET['username'], $_GET['token']);
                // }
                // else
                // {
                //     throw new Exception ("Requête invalide");
                // }
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
catch(Exception $e) {

    http_response_code(400);
    $error = [
        "error" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($error);

}

?>