<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");



function checkUserStatus($currentUserid, $userid)
{
    if(checkUserBlocking($currentUserid, $userid) != 0) {
        echo "403";
        http_response_code(200);
        exit;
    }
    elseif(checkCurrentUserBlocking($currentUserid, $userid) != 0) {
        echo "302";
        http_response_code(200);
        exit;
    }
    else {
        echo "200";
        http_response_code(200);
        exit;
    }
}

?>