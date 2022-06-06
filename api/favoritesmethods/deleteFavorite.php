<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/addings.php");



function deleteFavorite($currentUserid, $userid)
{
    $check = profileLiked($currentUserid, $userid);
    if($check !== FALSE) {
        deleteUserFavorite($currentUserid, $userid);
        http_response_code(200);
        addNewNotification('dislike', 'new', date(DATE_ATOM), $currentUserid, $userid);
    }
    else {
        http_response_code(400);
    }
}


?>