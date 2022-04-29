<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");





function getPrimaryUserData($userid)
{
    if ( isset($userid) && !empty($userid) )
    {
        if ( is_numeric($userid) )
        {
            if ( checkIDExistence($userid) == 1 )
            {
                $registrationValidated = registrationValidatedCheck($userid);
                if ( $registrationValidated[0] == TRUE )
                {
                    $completedProfile = completedProfileCheck($userid);
                    if ( $completedProfile[0] == FALSE )
                    {
                        echo(json_encode(primaryUserData($userid)));
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