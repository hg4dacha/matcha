<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");




function addlike($currentUserid, $userid)
{
    if($currentUserid != $userid)
    {
        $profileLiked = profileLiked($currentUserid, $userid);
        if($profileLiked == FALSE)
        {
            if(checkUserBlocking($currentUserid, $userid) != FALSE || checkCurrentUserBlocking($currentUserid, $userid) != FALSE)
            {
                http_response_code(200);
                exit;
            }
    
            addNewLike($currentUserid, $userid);
    
            $currentUserLiked = currentUserLiked($currentUserid, $userid);
            if($currentUserLiked != FALSE)
            {
                addNewNotification('match', 'new', date(DATE_ATOM), $currentUserid, $userid);
            }
            else
            {
                addNewNotification('like', 'new', date(DATE_ATOM), $currentUserid, $userid);
            }
    
            addPopularity($userid, 10);
    
            http_response_code(200);
        }
        else {
            http_response_code(200);
        }
    } else {
        http_response_code(401);
    }
}


?>