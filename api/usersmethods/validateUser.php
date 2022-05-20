<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");



function getTokenByUsername($username)
{
    $dbc = db_connex();
    try {
        $reqCtrl = $dbc->prepare("SELECT token FROM users WHERE username = :username");
        $reqCtrl->bindValue(':username', $username, PDO::PARAM_STR);
        $reqCtrl->execute();
        return $reqCtrl->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}

function confirmRegistration($username, $newtoken)
{
    $dbc = db_connex();
    try {
        $reqUpdate = $dbc->prepare("UPDATE users SET registrationValidated = TRUE, token = :newtoken WHERE username = :username");
        $reqUpdate->bindValue(':username', $username, PDO::PARAM_STR);
        $reqUpdate->bindValue(':newtoken', $newtoken, PDO::PARAM_STR);
        $reqUpdate->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}
	

function validateUser($data)
{
    if ( (isset($data->username) && !empty($data->username)) &&
         (isset($data->token) && !empty($data->token))
       )
    {
        $username = htmlspecialchars($data->username);
        $token = htmlspecialchars($data->token);

        if ( checkUsernameExistence($username) == 1 )
        {
            $tokenDatabase = getTokenByUsername($username);
            if ( $tokenDatabase[0] == $token)
            {
                $newtoken = uniqid().random_int(583483, 962379835641329875);
                confirmRegistration($username, $newtoken);
                http_response_code(200);
            }
            else
            {
                header("HTTP/1.1 409 error data");
            }
        }
        else
        {
            header("HTTP/1.1 409 error data");
        }
    }
    else
    {
        http_response_code(400);
    }
}


?>