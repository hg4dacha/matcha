<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");


function getNewMessages($currentUserid, $userid)
{
    $unviewedMessages = getNumberOFNewMessages($currentUserid, $userid);
    echo(json_encode($unviewedMessages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}



?>