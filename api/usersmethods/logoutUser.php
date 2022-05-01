<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");



function logoutUser($userid)
{
    updateUserConnection(FALSE, date(DATE_ATOM), $userid);
    if(isset($_COOKIE['REFRESH_TOKEN']) && !empty($_COOKIE['REFRESH_TOKEN'])) {
        unset($_COOKIE['REFRESH_TOKEN']);
    }
    setcookie('REFRESH_TOKEN', '', time() - 10, '/', NULL, false, true);
    http_response_code(200);
}


?>