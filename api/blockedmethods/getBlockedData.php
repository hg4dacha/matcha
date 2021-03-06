<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");




function getBlockedData($currentUserid, $userid)
{
    if(is_numeric($userid))
    {
        if(checkIDExistence($userid) > 0)
        {
            if(checkCurrentUserBlocking($currentUserid, $userid) != FALSE ||
            checkUserBlocking($currentUserid, $userid) != FALSE)
            {
                echo(json_encode(getDataFromBlocked($userid), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                http_response_code(200);
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