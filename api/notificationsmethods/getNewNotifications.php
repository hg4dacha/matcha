<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");



function getNewNotifications($userid)
{
    $newNotifications = getAllUSerNotifications($userid, "new");

    if(count($newNotifications) > 0) {

        echo(json_encode($newNotifications, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        http_response_code(200);
        
        $i = 0;
        while($i !== count($newNotifications)) {
            markNotificationAsOld($newNotifications[$i]['id']);
            $i++;
        }

    }
    else {
        http_response_code(200);
    }
}


?>