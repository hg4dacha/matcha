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





function getAllUserPictures($userid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare("SELECT profilePicture, secondPicture, thirdPicture, fourthPicture, fifthPicture FROM pictures WHERE userid  = :userid");
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





function getPasswordById($userid)
{
    $dbc = db_connex();
    try
    {
        $reqGet = $dbc->prepare("SELECT passwordUser FROM users WHERE id = :userid");
        $reqGet->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}





function getUserInfo($userid)
{
    $dbc = db_connex();
    try
    {
        $reqGet = $dbc->prepare("SELECT birthdate, gender, maleOrientation, femaleOrientation, tags, popularity, lat, lng, registrationValidated, profileCompleted, connectionStatue
                                 FROM users WHERE id = :userid"
        );
        $reqGet->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}





function getUsersForUser($gender)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT users.id AS userid, username, birthdate, popularity, lat, lng, profilePicture AS thumbnail
            FROM users LEFT JOIN pictures ON users.id = pictures.userid WHERE users.gender = :gender
            AND users.registrationValidated = 1 AND users.profileCompleted = 1 ORDER BY RAND() LIMIT 90"
        );
        $reqSelect->bindValue(':gender', $gender, PDO::PARAM_STR);
        $reqSelect->execute();
        return $reqSelect->fetchAll();
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





function dashboardData($userid)
{
    $dbc = db_connex();
    try
    {
        $reqGet = $dbc->prepare(
            "SELECT username, popularity, profilePicture AS thumbnail
             FROM users LEFT JOIN pictures ON users.id = pictures.userid WHERE users.id = :userid"
        );
        $reqGet->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}




?>