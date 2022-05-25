<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");



function profileLiked($userid, $profileid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id FROM likes WHERE liker = :userid AND liked = :profileid");
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->bindValue(':profileid', $profileid, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->fetch();
    }
    catch(PDOException $e)
    {
        $error = [
            "error" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        return ($error);
    }
}

function currentUserLiked($userid, $profileid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id FROM likes WHERE liked = :userid AND liker = :profileid");
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->bindValue(':profileid', $profileid, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->fetch();
    }
    catch(PDOException $e)
    {
        $error = [
            "error" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        return ($error);
    }
}





function getUserProfileData($currentUserid, $userid)
{
    if(checkUserBlocking($currentUserid, $userid) != 0) {
        http_response_code(200);
        exit;
    }

    if(checkCurrentUserBlocking($currentUserid, $userid) != 0) {
        http_response_code(200);
        exit;
    }

    $profileData = profileData($userid);

    $profileLiked = profileLiked($currentUserid, $userid);
    $currentUserLiked = currentUserLiked($currentUserid, $userid);
    $likesArray = [
        "profileLiked" => $profileLiked,
        "currentUserLiked" => $currentUserLiked
    ];

    // echo(json_encode(profileData($userid), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    echo(json_encode(array_merge($profileData, $likesArray) , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    http_response_code(200);
}



?>