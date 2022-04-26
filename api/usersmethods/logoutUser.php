<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");



function logoutUser($userid)
{
    updateUserConnection(FALSE, date(DATE_ATOM), $userid);
    http_response_code(200);
}


?>