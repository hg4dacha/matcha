<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");




function deleteNotification($userid, $notificationId)
{
    $result = checkNotificationDeletionRights($userid, $notificationId);
    
    if($result === 1) {
        deleteUserNotification($userid, $notificationId);
        http_response_code(200);
    }
    else {
        header("HTTP/1.1 409 no rights");
    }
}



?>