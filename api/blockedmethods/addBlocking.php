<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");



function addBlocking($currentUserid, $userid)
{
    if(checkCurrentUserBlocking($currentUserid, $userid) == FALSE)
    {
        addBlocked($currentUserid, $userid);
        decreasePopularity($userid, 10);
    } else {
        http_response_code(200);
    }
}



?>