<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");



function deleteVisitHistory($currentUserid, $userid)
{
    $check = checkHistory($currentUserid, $userid);
    if($check > 0) {
        deleteHistory($currentUserid, $userid);
        http_response_code(200);
    }
    else {
        http_response_code(400);
    }
}


?>