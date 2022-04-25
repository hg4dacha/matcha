<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/JWT/jwt.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");



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
                    // JWT CREATION
                    $header = [
                        "alg" => "HS256",
                        "typ" => "JWT"
                    ];

                    $payload = [
                        "user_id" => $userid[0]
                    ];

                    $jwtInstance = new JWT();
                    $jwt = $jwtInstance->generate($header, $payload);
                    //_________________________

                    $completedProfile = completedProfileCheck($userid[0]);
                    
                    if ( $completedProfile[0] == TRUE )
                    {
                        updateUserConnection(TRUE, date(DATE_ATOM), $userid[0]);
                        echo $jwt;
                    }
                    else if ( $completedProfile[0] == FALSE )
                    {
                        http_response_code(206);
                        echo $jwt;
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