<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");



function deleteAllMessages($currentUserid, $userid)
{
    $profileLiked = profileLiked($currentUserid, $userid);
    $currentUserLiked = currentUserLiked($currentUserid, $userid);
    $currentUserBlocked = checkUserBlocking($currentUserid, $userid);
    $currentUserBlocking = checkCurrentUserBlocking($currentUserid, $userid);

    if($profileLiked != FALSE && $currentUserLiked != FALSE)
    {
        if($currentUserBlocked == FALSE && $currentUserBlocking == FALSE)
        {
            deleteAllUserMessages($currentUserid, $userid);
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