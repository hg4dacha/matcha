<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");


function getAllMessages($currentUserid, $userid)
{
    $profileLiked = profileLiked($currentUserid, $userid);
    $currentUserLiked = currentUserLiked($currentUserid, $userid);
    $currentUserBlocked = checkUserBlocking($currentUserid, $userid);
    $currentUserBlocking = checkCurrentUserBlocking($currentUserid, $userid);

    if($profileLiked != FALSE && $currentUserLiked != FALSE)
    {
        if($currentUserBlocked == FALSE && $currentUserBlocking == FALSE)
        {
            $unviewedMessages = getNumberOFNewMessages($currentUserid, $userid);
            $allMessages = getAllUserMessages($currentUserid, $userid);
            echo(json_encode([
                "unviewedMessages" => count($unviewedMessages),
                "messages" => $allMessages
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            if(count($unviewedMessages) > 0) {

                $i = 0;
                while($i !== count($unviewedMessages)) {
                    markMessagesAsViewed($unviewedMessages[$i]['id']);
                    $i++;
                }

            }
        }
        else {
            http_response_code(400);
        }
    }
    else {
        http_response_code(400);
    }
}


?>