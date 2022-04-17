<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// INSERT PROFILE PICTURE
function insertProfilePicture($profilePicture, $thirdPicture, $fourthPicture, $fifthPicture)
{
    $dbc = db_connex();
    try
    {
        $reqInsert = $dbc->prepare("INSERT INTO userPictures (profilePicture)
                                    VALUES (:profilePicture)");
        $reqInsert->bindValue(':profilePicture', $profilePicture, PDO::PARAM_STR);
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
        $reqInsert = $dbc->prepare("INSERT INTO userPictures (secondPicture, thirdPicture, fourthPicture, fifthPicture)
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