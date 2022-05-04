<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



function primaryUserData($userid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare("SELECT lastname, firstname, username, email FROM users WHERE id  = :userid");
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





// function userProfileData($userid)
// {
//     $dbc = db_connex();
//     try
//     {
//         $reqSelect = $dbc->prepare("SELECT lastname, firstname, username, email, birthdate, gender, maleOrientation, femaleOrientation, locationUser, tags, descriptionUser FROM users WHERE id  = :userid");
//         $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
//         $reqSelect->execute();
//         return $reqSelect->fetch();
//     }
//     catch(PDOException $e)
//     {
//         $error = [
//             "error" => $e->getMessage(),
//             "code" => $e->getCode()
//         ];
//         return ($error);
//     }
// }

function userProfileData($userid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare("SELECT lastname, firstname, username, email, birthdate, gender, maleOrientation,
        femaleOrientation, locationUser, tags, descriptionUser, profilePicture, secondPicture, thirdPicture, fourthPicture,
        fifthPicture FROM users LEFT JOIN pictures ON users.id = pictures.userid WHERE users.id  = :userid");
        
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



?>