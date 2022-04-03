<?php


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/usersmethods/adduser.php");




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
                $userData = json_decode(file_get_contents('php://input'));
                addUser($userData);
                break;
        }
    }
    else if ($request === 'likes')
    {

    }
    else
    {
        throw new Exception ("The request is not valid");
    }

}
catch(Exception $e) {

    // http_response_code(404);
    $error = [
        "error" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($error);

}

?>