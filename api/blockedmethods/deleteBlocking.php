<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");




function deleteBlocking($currentUserid, $userid)
{
    if(checkCurrentUserBlocking($currentUserid, $userid) != FALSE)
    {
        deleteBlocked($currentUserid, $userid);
        addPopularity($userid, 5);
    
        if(checkUserBlocking($currentUserid, $userid) != FALSE) {
            echo "403";
        }
        else {
            echo "200";
        }
        
        http_response_code(200);
    }
    else {
        if(checkUserBlocking($currentUserid, $userid) != FALSE) {
            echo "403";
        }
        else {
            echo "200";
        }
        
        http_response_code(200);
    }
}



?>