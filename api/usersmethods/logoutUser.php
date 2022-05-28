<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");



function logoutUser($userid)
{
    updateUserConnection(FALSE, date(DATE_ATOM), $userid);
    if(isset($_COOKIE['REFRESH_TOKEN']) && !empty($_COOKIE['REFRESH_TOKEN'])) {
        unset($_COOKIE['REFRESH_TOKEN']);
    }
    $arr_cookie_options = array (
        'expires' => time() - 10,
        'path' => '/',
        'domain' => NULL,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    );
    setcookie('REFRESH_TOKEN', '', $arr_cookie_options);
    http_response_code(200);
}


?>