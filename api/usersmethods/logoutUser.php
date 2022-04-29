<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");



function logoutUser($userid)
{
    updateUserConnection(FALSE, date(DATE_ATOM), $userid);
    // unset($_COOKIE['refresh_token']);
    setcookie('refresh_token', '', time() - 10, '/', NULL, false, true);
    http_response_code(200);
}


?>