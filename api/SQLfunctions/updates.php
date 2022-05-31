<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// UPDATE CONNECTION
function updateUserConnection($connectionStatue, $lastConnection, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET connectionStatue = :connectionStatue, lastConnection = :lastConnection WHERE id = :userid");
        $reqUpdate->bindValue(':connectionStatue', $connectionStatue, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':lastConnection', $lastConnection, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// INSERT PROFILE PICTURE
function insertProfilePicture($userid, $picturePath)
{
    $dbc = db_connex();
    try
    {
        $reqInsert = $dbc->prepare("INSERT INTO pictures (userid, profilePicture)
                                    VALUES (:userid, :picturePath)");
        $reqInsert->bindValue(':picturePath', $picturePath, PDO::PARAM_STR);
        $reqInsert->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqInsert->execute();
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





// UPDATE PROFILE PICTURE
function updateProfilePicture($userid, $picturePath)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE pictures SET profilePicture = :picturePath WHERE userid = :userid");
        $reqUpdate->bindValue(':picturePath', $picturePath, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// INSERT USER PICTURES
function updateUserPictures($userid, $pictureNumber, $picturePath)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE pictures SET ".$pictureNumber." = :picturePath WHERE userid = :userid");
        $reqUpdate->bindValue(':picturePath', $picturePath, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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

// PICTURE NULL
function updatePictureNull($userid, $pictureNumber)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE pictures SET ".$pictureNumber." = NULL WHERE userid = :userid");
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER BIRTHDATE
function updateUserBirthdate($userid, $birthdate)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET birthdate = :birthdate WHERE id = :userid");
        $reqUpdate->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER GENDER
function updateUserGender($userid, $gender)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET gender = :gender WHERE id = :userid");
        $reqUpdate->bindValue(':gender', $gender, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER ORIENTATION
function updateUserOrientation($userid, $maleOrientation, $femaleOrientation)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET maleOrientation = :maleOrientation, femaleOrientation = :femaleOrientation WHERE id = :userid");
        $reqUpdate->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER LOCATION
function updateUserLocation($userid, $userLocation, $lat, $lng)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET locationUser = :userLocation, lat = :lat, lng = :lng WHERE id = :userid");
        $reqUpdate->bindValue(':userLocation', $userLocation, PDO::PARAM_STR);
        $reqUpdate->bindValue(':lat', $lat, PDO::PARAM_STR);
        $reqUpdate->bindValue(':lng', $lng, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER TAGS
function updateUserTags($userid, $userTags, $tag1, $tag2, $tag3, $tag4, $tag5)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare(
            "UPDATE users SET tags = :userTags, tag1 = :tag1, tag2 = :tag2,
            tag3 = :tag3, tag4 = :tag4, tag5 = :tag5 WHERE id = :userid"
        );
        $reqUpdate->bindValue(':userTags', $userTags, PDO::PARAM_STR);
        $reqUpdate->bindValue(':tag1', $tag1, PDO::PARAM_STR);
        $reqUpdate->bindValue(':tag2', $tag2, PDO::PARAM_STR);
        $reqUpdate->bindValue(':tag3', $tag3, PDO::PARAM_STR);
        $reqUpdate->bindValue(':tag4', $tag4, PDO::PARAM_STR);
        $reqUpdate->bindValue(':tag5', $tag5, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER DESCRIPTION
function updateUserDescription($userid, $descriptionUser)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET descriptionUser = :descriptionUser WHERE id = :userid");
        $reqUpdate->bindValue(':descriptionUser', $descriptionUser, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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






// UPDATE USER INFO
function updateUserInfo($userid, $lastname, $firstname, $username, $email)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET lastname = :lastname, firstname = :firstname, username = :username, email = :email WHERE id = :userid");
        $reqUpdate->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $reqUpdate->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $reqUpdate->bindValue(':username', $username, PDO::PARAM_STR);
        $reqUpdate->bindValue(':email', $email, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE USER PASSWORD
function updateUserPassword($userid, $passwordUser)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET passwordUser = :passwordUser WHERE id = :userid");
        $reqUpdate->bindValue(':passwordUser', $passwordUser, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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





// UPDATE POPULARITY
function addPopularity($userid, $addition)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET popularity = popularity + :addition WHERE id = :userid");
        $reqUpdate->bindValue(':addition', $addition, PDO::PARAM_INT);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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


function decreasePopularity($userid, $addition)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET popularity = popularity - :addition WHERE id = :userid");
        $reqUpdate->bindValue(':addition', $addition, PDO::PARAM_INT);
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
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




?>