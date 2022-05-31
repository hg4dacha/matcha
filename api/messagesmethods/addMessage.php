<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");





function addMessage($currentUserid, $userid, $message)
{
    if(isset($message->message) && !empty($message->message) && strlen($message->message) <= 700)
    {
        $message = htmlspecialchars($message->message);
        if(is_numeric($userid) && $currentUserid !== $userid)
        {
            $profileLiked = profileLiked($currentUserid, $userid);
            $currentUserLiked = currentUserLiked($currentUserid, $userid);
            $currentUserBlocked = checkUserBlocking($currentUserid, $userid);
            $currentUserBlocking = checkCurrentUserBlocking($currentUserid, $userid);

            if($profileLiked != FALSE && $currentUserLiked != FALSE)
            {
                if($currentUserBlocked == FALSE && $currentUserBlocking == FALSE)
                {
                    addNewMessage($currentUserid, $currentUserid,	$userid, $message, date(DATE_ATOM));
                    addNewMessage($userid, $currentUserid,	$userid, $message, date(DATE_ATOM));
                    addNewNotification('message', 'new', date(DATE_ATOM), $currentUserid, $userid);
                }
                else {
                    http_response_code(400);
                }
            }
            else {
                http_response_code(400);
            }
        }
        else {
            http_response_code(400);
        }
    }
    else {
        header("HTTP/1.1 409 empty message");
    }
}


?>