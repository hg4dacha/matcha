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





function getUserData($userid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT lastname, firstname, username, email, lat, lng, profilePicture AS thumbnail
            FROM users LEFT JOIN pictures ON users.id = pictures.userid WHERE users.id  = :userid");
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
        $reqGet = $dbc->prepare(
            "SELECT birthdate, gender, maleOrientation, femaleOrientation, popularity, registrationValidated, profileCompleted,
            connectionStatue, lat, lng, tag1, tag2, tag3, tag4, tag5 FROM users WHERE id = :userid"
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






// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-. //
// -.-.-.-.-.-.-.-.-.- USERS RECOVERY -.-.-.-.-.-.-.-.-.- //
// -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-. //

function getOppositeGenderUsers(
    $userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng, $tag1, $tag2, $tag3, $tag4, $tag5
) {
    $dbc = db_connex();
    try
    {
        $request = $dbc->prepare(
            "SELECT usr.id AS userid, username, birthdate, popularity, lat, lng, thumbnail
            FROM (
               SELECT *, ROUND(SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance,
               TIMESTAMPDIFF(YEAR, :birthdate, birthdate) AS age_diff,
               (CASE
                    WHEN tag1 = :tag1 THEN 1
                    WHEN tag2 = :tag1 THEN 1
                    WHEN tag3 = :tag1 THEN 1
                    WHEN tag4 = :tag1 THEN 1
                    WHEN tag5 = :tag1 THEN 1 ELSE 0
                END) AS first_tag_match,
                (CASE
                    WHEN tag1 = :tag2 THEN 1
                    WHEN tag2 = :tag2 THEN 1
                    WHEN tag3 = :tag2 THEN 1
                    WHEN tag4 = :tag2 THEN 1
                    WHEN tag5 = :tag2 THEN 1 ELSE 0
                END) AS second_tag_match,
                (CASE
                    WHEN tag1 = :tag3 THEN 1
                    WHEN tag2 = :tag3 THEN 1
                    WHEN tag3 = :tag3 THEN 1
                    WHEN tag4 = :tag3 THEN 1
                    WHEN tag5 = :tag3 THEN 1 ELSE 0
                END) AS third_tag_match,
                (CASE
                    WHEN tag1 = :tag4 THEN 1
                    WHEN tag2 = :tag4 THEN 1
                    WHEN tag3 = :tag4 THEN 1
                    WHEN tag4 = :tag4 THEN 1
                    WHEN tag5 = :tag4 THEN 1 ELSE 0
                END) AS fourth_tag_match,
                (CASE
                    WHEN tag1 = :tag5 THEN 1
                    WHEN tag2 = :tag5 THEN 1
                    WHEN tag3 = :tag5 THEN 1
                    WHEN tag4 = :tag5 THEN 1
                    WHEN tag5 = :tag5 THEN 1 ELSE 0
                END) AS fifth_tag_match
                FROM users
            ) usr
            LEFT JOIN (
                SELECT *, profilePicture AS thumbnail FROM pictures
            ) pct
            ON usr.id = pct.userid
            WHERE usr.distance BETWEEN 0 AND 200
            AND usr.age_diff BETWEEN -5 AND 5
            AND popularity BETWEEN :popularity - 3000 AND :popularity + 3000
            AND (usr.first_tag_match + usr.second_tag_match + usr.third_tag_match + usr.fourth_tag_match + usr.fifth_tag_match) BETWEEN 0 AND 5
            AND usr.id != :userid
            AND registrationValidated = 1 AND profileCompleted = 1
            AND gender != :gender AND maleOrientation != :maleOrientation
            AND femaleOrientation != :femaleOrientation
            AND usr.id NOT IN (SELECT blocked FROM blocked WHERE blocker = :userid)
            AND usr.id NOT IN (SELECT blocker FROM blocked WHERE blocked = :userid)
            ORDER BY usr.distance
            LIMIT 90
        ");
        $request->bindValue(':userid', $userid, PDO::PARAM_INT);
        $request->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
        $request->bindValue(':gender', $gender, PDO::PARAM_STR);
        $request->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_STR);
        $request->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_STR);
        $request->bindValue(':popularity', $popularity, PDO::PARAM_STR);
        $request->bindValue(':lat', $lat, PDO::PARAM_STR);
        $request->bindValue(':lng', $lng, PDO::PARAM_STR);
        $request->bindValue(':tag1', $tag1, PDO::PARAM_STR);
        $request->bindValue(':tag2', $tag2, PDO::PARAM_STR);
        $request->bindValue(':tag3', $tag3, PDO::PARAM_STR);
        $request->bindValue(':tag4', $tag4, PDO::PARAM_STR);
        $request->bindValue(':tag5', $tag5, PDO::PARAM_STR);
        $request->execute();
        return $request->fetchAll();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}







?>