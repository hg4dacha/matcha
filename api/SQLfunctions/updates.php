<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// UPDATE CONNECTION
function updateUserConnection($connectionStatue, $lastConnection, $userID)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET connectionStatue = :connectionStatue, lastConnection = :lastConnection WHERE id = :userID");
        $reqUpdate->bindValue(':connectionStatue', $connectionStatue, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':lastConnection', $lastConnection, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function insertProfilePicture($userID, $picturePath)
{
    $dbc = db_connex();
    try
    {
        $reqInsert = $dbc->prepare("INSERT INTO pictures (userID, profilePicture)
                                    VALUES (:userID, :picturePath)");
        $reqInsert->bindValue(':picturePath', $picturePath, PDO::PARAM_STR);
        $reqInsert->bindValue(':userID', $userID, PDO::PARAM_INT);
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





// INSERT USER PICTURES
function insertUserPictures($userID, $pictureNumber, $picturePath)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE pictures SET ".$pictureNumber." = :picturePath WHERE userID = :userID");
        $reqUpdate->bindValue(':picturePath', $picturePath, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updatePictureNull($userID, $pictureNumber)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE pictures SET ".$pictureNumber." = NULL WHERE userID = :userID");
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updateUserBirthdate($userID, $birthdate)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET birthdate = :birthdate WHERE id = :userID");
        $reqUpdate->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updateUserGender($userID, $gender)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET gender = :gender WHERE id = :userID");
        $reqUpdate->bindValue(':gender', $gender, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updateUserOrientation($userID, $maleOrientation, $femaleOrientation)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET maleOrientation = :maleOrientation, femaleOrientation = :femaleOrientation WHERE id = :userID");
        $reqUpdate->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updateUserLocation($userID, $userLocation)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET locationUser = :userLocation WHERE id = :userID");
        $reqUpdate->bindValue(':userLocation', $userLocation, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updateUserTags($userID, $userTags)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET tags = :userTags WHERE id = :userID");
        $reqUpdate->bindValue(':userTags', $userTags, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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
function updateUserDescription($userID, $descriptionUser)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET descriptionUser = :descriptionUser WHERE id = :userID");
        $reqUpdate->bindValue(':descriptionUser', $descriptionUser, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
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