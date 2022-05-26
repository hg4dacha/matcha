<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");



function checkUserStatus($currentUserid, $userid)
{
    if(checkCurrentUserBlocking($currentUserid, $userid) != FALSE) {
        echo "302";
        http_response_code(200);
        exit;
    }
    elseif(checkUserBlocking($currentUserid, $userid) != FALSE) {
        echo "403";
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