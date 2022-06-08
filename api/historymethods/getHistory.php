<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");



function getHistory($userid)
{
    echo(json_encode(getUserHistory($userid), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    http_response_code(200);
}



?>