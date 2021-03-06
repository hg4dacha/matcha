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
                    $connectionStatue = connectionStatueCheck($userid[0]);

                    if ( $connectionStatue[0] == FALSE )
                    {
                        // COOKIE OPTIONS
                        $arr_cookie_options = array (
                            'expires' => time() + 60 * 60 * 24 * 30,
                            'path' => '/',
                            'domain' => NULL,
                            'secure' => false,
                            'httponly' => true,
                            'samesite' => 'Lax'
                        );


                        $completedProfile = completedProfileCheck($userid[0]);

                        if ( $completedProfile[0] == TRUE )
                        {
                            $userData = getUserData($userid[0]);


                            // REFRESH TOKEN CREATION
                            $header_ = [
                                "alg" => "HS256",
                                "typ" => "JWT"
                            ];

                            $payload_ = [
                                "user_id" => $userid[0],
                                "lastname" => $userData['lastname'],
                                "firstname" => $userData['firstname'],
                                "username" => $userData['username'],
                                "email" => $userData['email'],
                                "popularity" => $userData['popularity'],
                                "lat" => $userData['lat'],
                                "lng" => $userData['lng'],
                                "thumbnail" => urlencode($userData['thumbnail'])
                            ];
        
                            $tokenInstance = new JWT();
                            $REFRESH_TOKEN = $tokenInstance->generate($header_, $payload_, COOKIE_TOKEN_SECRET, 86400 * 30);
                            //_________________________
        
        
        
                            // JWT CREATION
                            $header = [
                                "alg" => "HS256",
                                "typ" => "JWT"
                            ];
        
                            $payload = [
                                "user_id" => $userid[0],
                                "lastname" => $userData['lastname'],
                                "firstname" => $userData['firstname'],
                                "username" => $userData['username'],
                                "email" => $userData['email'],
                                "popularity" => $userData['popularity'],
                                "lat" => $userData['lat'],
                                "lng" => $userData['lng'],
                                "thumbnail" => urlencode($userData['thumbnail'])
                            ];
        
                            $jwtInstance = new JWT();
                            $jwt = $jwtInstance->generate($header, $payload);
                            //_________________________
        
        
        
                            // USER DATA
                            $userData = [
                                "user" => [
                                    "user_id" => $userid[0],
                                    "lastname" => $userData['lastname'],
                                    "firstname" => $userData['firstname'],
                                    "username" => $userData['username'],
                                    "email" => $userData['email'],
                                    "popularity" => $userData['popularity'],
                                    "lat" => $userData['lat'],
                                    "lng" => $userData['lng'],
                                    "thumbnail" => $userData['thumbnail']
                                ],
                                "EXPIRE_IN" => 3600,
                                "AUTH_TOKEN" => $jwt
                            ];
                            //_________________________

                            updateUserConnection(TRUE, date(DATE_ATOM), $userid[0]);
                            setcookie('REFRESH_TOKEN', $REFRESH_TOKEN, $arr_cookie_options);
                            echo json_encode($userData);
                            http_response_code(200);
                        }
                        else if ( $completedProfile[0] == FALSE )
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
                                "email" => $primaryUserData['email'],
                                "popularity" => "empty",
                                "lat" => "empty",
                                "lng" => "empty",
                                "thumbnail" => "empty"
                            ];
        
                            $tokenInstance = new JWT();
                            $REFRESH_TOKEN = $tokenInstance->generate($header_, $payload_, COOKIE_TOKEN_SECRET, 86400 * 30);
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
                                "email" => $primaryUserData['email'],
                                "popularity" => "empty",
                                "lat" => "empty",
                                "lng" => "empty",
                                "thumbnail" => "empty"
                            ];
        
                            $jwtInstance = new JWT();
                            $jwt = $jwtInstance->generate($header, $payload);
                            //_________________________
        
        
        
                            // USER DATA
                            $userData = [
                                "user" => [
                                    "user_id" => $userid[0],
                                    "lastname" => $primaryUserData['lastname'],
                                    "firstname" => $primaryUserData['firstname'],
                                    "username" => $primaryUserData['username'],
                                    "email" => $primaryUserData['email'],
                                    "popularity" => "empty",
                                    "lat" => "empty",
                                    "lng" => "empty",
                                    "thumbnail" => "empty"
                                ],
                                "EXPIRE_IN" => 3600,
                                "AUTH_TOKEN" => $jwt
                            ];
                            //_________________________


                            updateUserConnection(TRUE, date(DATE_ATOM), $userid[0]);
                            setcookie('REFRESH_TOKEN', $REFRESH_TOKEN, $arr_cookie_options);
                            echo json_encode($userData);
                            http_response_code(206);
                        }                   

                    }
                    else
                    {
                        header("HTTP/1.1 400 connected");
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