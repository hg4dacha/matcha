<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");




function primaryUserData($userID)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare("SELECT lastname, firstname, username, email FROM users WHERE id  = :userID");
        $reqSelect->bindValue(':userID', $userID, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->fetch();
    }
    catch(PDOException $e)
    {
        $error = [
            "error" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        return ($error);
    }
}



function getPrimaryUserData($userID)
{
    if ( isset($userID) && !empty($userID) )
    {
        if ( is_numeric($userID) )
        {
            if ( checkIDExistence($userID) == 1 )
            {
                $registrationValidated = registrationValidatedCheck($userID);
                if ( $registrationValidated[0] == TRUE )
                {
                    $completedProfile = completedProfileCheck($userID);
                    if ( $completedProfile[0] == FALSE )
                    {
                        echo(json_encode(primaryUserData($userID)));
                    }
                    else
                    {
                        header("HTTP/1.1 400 completed profile");
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