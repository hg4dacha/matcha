<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");




function getPrimaryUserData($userID)
{
    if ( isset($userID) && !empty($userID) )
    {
        if ( is_numeric($userID) )
        {
            if ( checkIDExistence($userID) == 1 )
            {
                if ( registrationValidatedCheck($userID) == TRUE )
                {
                    if ( completedProfileCheck($userID) == FALSE )
                    {
                        
                    }
                    else
                    {
                        header("HTTP/1.1 400 completed profile");
                    }
                }
                else
                {
                    header("HTTP/1.1 400 registration not valid");
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