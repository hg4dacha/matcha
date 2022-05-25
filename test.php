<?php

// https://randomuser.me/api/?results=500&nat=fr&gender=male&inc=name,email&exc=gender,login,registered,dob,phone,cell,id,picture,nat,location
// https://geo.api.gouv.fr/departements/93/communes?fields=code,nom,region,centre

require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");


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

$profileLiked = profileLiked(497, 1016);

$currentUserLiked = currentUserLiked(497, 1016);

$array = ([
    "profileLiked" => $profileLiked,
    "currentUserLiked" => $currentUserLiked
]);

$array2 = ([
    "test" => "test00",
    "test2" => "test01"
]);

echo(json_encode(array_merge($array, $array2)));

// echo(json_encode($array));





?>