<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");




function refreshDataProfile($currentUserid, $userid)
{
    $connectionStatue = connectionStatueCheck($userid);
    $profileLiked = profileLiked($currentUserid, $userid);
    $currentUserLiked = currentUserLiked($currentUserid, $userid);
    $currentUserBlocked = checkUserBlocking($currentUserid, $userid);

    $array = [
        "connectionStatue" => $connectionStatue[0],
        "profileLiked" => $profileLiked == FALSE ? FALSE : TRUE,
        "currentUserLiked" => $currentUserLiked == FALSE ? FALSE : TRUE,
        "currentUserBlocked" => $currentUserBlocked == FALSE ? FALSE : TRUE
    ];

    echo(json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}


?>