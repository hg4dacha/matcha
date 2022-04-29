<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/jwt.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/includes/config.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");




function getPasswordByEmail($email)
{
    $dbc = db_connex();
    try {
        $reqGet = $dbc->prepare("SELECT passwordUser FROM users WHERE email = :email");
        $reqGet->bindValue(':email', $email, PDO::PARAM_STR);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}

function getIdByEmail($email)
{
    $dbc = db_connex();
    try {
        $reqGet = $dbc->prepare("SELECT id FROM users WHERE email = :email");
        $reqGet->bindValue(':email', $email, PDO::PARAM_STR);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}


function identifyUser($data)
{
    if ( (isset($data->email) && !empty($data->email)) &&
         (isset($data->password) && !empty($data->password))
       )
    {
        $email = htmlspecialchars($data->email);
        $password = htmlspecialchars($data->password);

        if ( checkEmailExistence(strtolower($email)) == 1 )
        {
            $passwordDatabase = getPasswordByEmail($email);

            if ( password_verify($password, $passwordDatabase[0]) )
            {
                $userid = getIdByEmail($email);
                $registrationValidated = registrationValidatedCheck($userid[0]);

                if ( $registrationValidated[0] == TRUE )
                {
                    $primaryUserData = primaryUserData($userid[0]);



                    // REFRESH TOKEN CREATION
                    $header_ = [
                        "alg" => "HS256",
                        "typ" => "JWT"
                    ];

                    $payload_ = [
                        "user_id" => $userid[0],
                        "lastname" => $primaryUserData['lastname'],
                        "firstname" => $primaryUserData['firstname'],
                        "username" => $primaryUserData['username'],
                        "email" => $primaryUserData['email']
                    ];

                    $tokenInstance = new JWT();
                    $refresh_token_cookie = $tokenInstance->generate($header_, $payload_, COOKIE_TOKEN_SECRET, 86400 * 30);
                    //_________________________



                    // JWT CREATION
                    $header = [
                        "alg" => "HS256",
                        "typ" => "JWT"
                    ];

                    $payload = [
                        "user_id" => $userid[0],
                        "lastname" => $primaryUserData['lastname'],
                        "firstname" => $primaryUserData['firstname'],
                        "username" => $primaryUserData['username'],
                        "email" => $primaryUserData['email']
                    ];

                    $jwtInstance = new JWT();
                    $jwt = $jwtInstance->generate($header, $payload);
                    //_________________________



                    // USER DATA
                    $userData = [
                        "user_id" => $userid[0],
                        "lastname" => $primaryUserData['lastname'],
                        "firstname" => $primaryUserData['firstname'],
                        "username" => $primaryUserData['username'],
                        "email" => $primaryUserData['email'],
                        "jwt" => $jwt
                    ];
                    //_________________________


                    $completedProfile = completedProfileCheck($userid[0]);
                    
                    if ( $completedProfile[0] == TRUE )
                    {
                        updateUserConnection(TRUE, date(DATE_ATOM), $userid[0]);
                        setcookie('refresh_token', $refresh_token_cookie, time() + 60 * 60 * 24 * 30, '/', NULL, false, true);
                        echo json_encode($userData);
                        http_response_code(200);
                    }
                    else if ( $completedProfile[0] == FALSE )
                    {
                        setcookie('refresh_token', $refresh_token_cookie, time() + 60 * 60 * 24 * 30, '/', NULL, false, true);
                        echo json_encode($userData);
                        http_response_code(206);
                    }
                }
                else
                {
                    header("HTTP/1.1 400 registration invalidated");
                }
            }
            else
            {
                http_response_code(400);
            }
        }
        else
        {
            http_response_code(400);
        }
    }
    else
    {
        http_response_code(400);
    }
}



?>