<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");


function getProfileData($userid)
{
    $registrationValidatedCheck = registrationValidatedCheck($userid);
    if($registrationValidatedCheck[0] == TRUE)
    {
        $connectionStatueCheck = connectionStatueCheck($userid);
        if($connectionStatueCheck[0] == TRUE)
        {
            $completedProfileCheck = completedProfileCheck($userid);
            if($completedProfileCheck[0] == TRUE)
            {
                echo(json_encode(userProfileData($userid), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
            else {
                header("HTTP/1.1 400 incomplete profile");
            }
        }
        else {
            header("HTTP/1.1 400 disconnect");
        }
    }
    else {
        header("HTTP/1.1 400 invalid registration");
    }

}



?>