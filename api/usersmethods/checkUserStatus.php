<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");



function checkUserStatus($currentUserid, $userid)
{
    if(is_numeric($userid))
    {
        if(checkIDExistence($userid) > 0)
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
        else
        {
            http_response_code(400);
        }
    }
    else
    {
        http_response_code(400);
    }
}

?>