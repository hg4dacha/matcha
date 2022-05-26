<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");





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

    addNewNotification('visit', 'new', date(DATE_ATOM), $currentUserid, $userid);
    addHistory($currentUserid, $userid, date(DATE_ATOM));

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