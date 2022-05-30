<?php

// https://randomuser.me/api/?results=500&nat=fr&gender=male&inc=name,email&exc=gender,login,registered,dob,phone,cell,id,picture,nat,location
// https://geo.api.gouv.fr/departements/93/communes?fields=code,nom,region,centre
// https://avatars.dicebear.com/api/avataaars/3154323123.svg?top=shortHair&hatColor=black&hairColor=black&facialHair=majestic&facialHairChance=100&facialHairColor=black&skin=light

require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");


// $hourdiff = round((strtotime(date(DATE_ATOM)) - strtotime('2022-05-30T10:00:32+02:00')) / 3600, 0);
// var_dump($hourdiff);


function getVisitedProfile($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id, visitDate FROM history WHERE visitor = :currentUserid AND profileVisited = :userid"
        );
        $reqSelect->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
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

var_dump(getVisitedProfile(497, 1014));



?>