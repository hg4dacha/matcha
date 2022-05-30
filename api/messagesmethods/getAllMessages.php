<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");


function getAllMessages($currentUserid, $userid)
{
    $profileLiked = profileLiked($currentUserid, $userid);
    $currentUserLiked = currentUserLiked($currentUserid, $userid);
    $currentUserBlocked = checkUserBlocking($currentUserid, $userid);
    $currentUserBlocking = checkCurrentUserBlocking($currentUserid, $userid);

    if($profileLiked != FALSE && $currentUserLiked != FALSE)
    {
        if($currentUserBlocked == FALSE && $currentUserBlocking == FALSE)
        {
            echo(json_encode(getAllUserMessages($currentUserid, $userid), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
        else {
            http_response_code(400);
        }
    }
    else {
        http_response_code(400);
    }
}


?>