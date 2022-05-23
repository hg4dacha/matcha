<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");



function getProfileData($currentUserid, $userid)
{
    if(checkUserBlocking($currentUserid, $userid) != 0) {
        http_response_code(200);
        exit;
    }

    if(checkCurrentUserBlocking($currentUserid, $userid) != 0) {
        http_response_code(200);
        exit;
    }

    echo(json_encode(profileData($userid, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    http_response_code(200);
}



?>