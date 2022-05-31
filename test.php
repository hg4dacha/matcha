<?php

// https://randomuser.me/api/?results=500&nat=fr&gender=male&inc=name,email&exc=gender,login,registered,dob,phone,cell,id,picture,nat,location
// https://geo.api.gouv.fr/departements/93/communes?fields=code,nom,region,centre
// https://avatars.dicebear.com/api/avataaars/3154323123.svg?top=shortHair&hatColor=black&hairColor=black&facialHair=majestic&facialHairChance=100&facialHairColor=black&skin=light


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");


function markMessagesAsViewed($msgId)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE messages SET messageViewed = 1 WHERE id = :msgId");
        $reqUpdate->bindValue(':msgId', $msgId, PDO::PARAM_INT);
        $reqUpdate->execute();
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

markMessagesAsViewed(16);



?>