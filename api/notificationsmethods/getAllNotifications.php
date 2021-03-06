<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");




function getAllNotifications($userid)
{
    $newNotifications = getAllUSerNotifications($userid, "new");
    $oldNotifications = getAllUSerNotifications($userid, "old");

    echo(json_encode([
        "newNotifications" => $newNotifications,
        "oldNotifications" => $oldNotifications
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    http_response_code(200);


    if(count($newNotifications) > 0) {

        $i = 0;
        while($i !== count($newNotifications)) {
            markNotificationAsOld($newNotifications[$i]['id']);
            $i++;
        }

    }
}



?>