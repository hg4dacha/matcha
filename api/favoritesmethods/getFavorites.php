<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");



function getFavorites($userid)
{
    echo(json_encode(getUserFavorites($userid), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    http_response_code(200);
}



?>