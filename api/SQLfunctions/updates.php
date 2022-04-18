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
function insertUserPictures($secondPicture, $thirdPicture, $fourthPicture, $fifthPicture)
{
    $dbc = db_connex();
    try
    {
        $reqInsert = $dbc->prepare("INSERT INTO pictures (secondPicture, thirdPicture, fourthPicture, fifthPicture)
                                    VALUES (:secondPicture, :thirdPicture, :fourthPicture, :fifthPicture)");
        $reqInsert->bindValue(':secondPicture', $secondPicture, PDO::PARAM_STR);
        $reqInsert->bindValue(':thirdPicture', $thirdPicture, PDO::PARAM_STR);
        $reqInsert->bindValue(':fourthPicture', $fourthPicture, PDO::PARAM_STR);
        $reqInsert->bindValue(':fifthPicture', $fifthPicture, PDO::PARAM_STR);
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


?>