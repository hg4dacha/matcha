<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

var_dump(file_get_contents('php://input'));


try {

    if(!empty($_SERVER['REQUEST_URI']))
    {
        $url_ = explode('/', (filter_var($_SERVER['REQUEST_URI'] , FILTER_SANITIZE_URL)));
        $url = $url_[3];

        switch($url) {
            case "users":
        }
    }
    else
    {
        throw new Exception ("Error");
    }

}
catch(Exception $e) {

    $error = [
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($error);

}

?>