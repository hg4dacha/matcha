<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");



function getNotificationsNumber($userid)
{
    $newNotifications = getAllUSerNotifications($userid, "new");

    if(count($newNotifications) >= 0) {

        echo(count($newNotifications));
        http_response_code(200);

    }
    else {
        http_response_code(200);
    }
}


?>