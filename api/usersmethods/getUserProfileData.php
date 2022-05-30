<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");





function getUserProfileData($currentUserid, $userid)
{
    if(checkUserBlocking($currentUserid, $userid) != 0) {
        http_response_code(200);
        exit;
    }

    if(checkCurrentUserBlocking($currentUserid, $userid) != 0) {
        http_response_code(200);
        exit;
    }

    $visitedProfile = getVisitedProfile($currentUserid, $userid);
    if($visitedProfile == FALSE) {
        addHistory($currentUserid, $userid, date(DATE_ATOM));
        addNewNotification('visit', 'new', date(DATE_ATOM), $currentUserid, $userid);
    }
    else {
        deleteHistory($currentUserid, $userid);
        addHistory($currentUserid, $userid, date(DATE_ATOM));
        $hourdiff = round((strtotime(date(DATE_ATOM)) - strtotime($visitedProfile['visitDate'])) / 3600, 0);
        if($hourdiff >= 24) {
            addNewNotification('visit', 'new', date(DATE_ATOM), $currentUserid, $userid);
        }
    }

    $profileData = profileData($userid);

    $profileLiked = profileLiked($currentUserid, $userid);
    $currentUserLiked = currentUserLiked($currentUserid, $userid);
    $likesArray = [
        "profileLiked" => $profileLiked == FALSE ? FALSE : TRUE,
        "currentUserLiked" => $currentUserLiked == FALSE ? FALSE : TRUE
    ];

    echo(json_encode(array_merge($profileData, $likesArray), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    http_response_code(200);
}



?>