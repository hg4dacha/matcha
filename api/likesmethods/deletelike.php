<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");




function deletelike($currentUserid, $userid)
{
    $profileLiked = profileLiked($currentUserid, $userid);
    if($profileLiked != FALSE)
    {
        if(checkUserBlocking($currentUserid, $userid) != FALSE || checkCurrentUserBlocking($currentUserid, $userid) != FALSE)
        {
            http_response_code(200);
            exit;
        }

        deleteExistingLike($currentUserid, $userid);
        addNewNotification('dislike', 'new', date(DATE_ATOM), $currentUserid, $userid);
        decreasePopularity($userid, 10);
        http_response_code(200);
    }
    else {
        http_response_code(200);
    }
}


?>