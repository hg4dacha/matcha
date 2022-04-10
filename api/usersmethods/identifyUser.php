<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");



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
                $userID = getIdByEmail($email);
                $completedProfile = completedProfile($userID[0]);
                
                if ( $completedProfile[0] )
                {
                    http_response_code(200);
                }
                else
                {
                    http_response_code(206);
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