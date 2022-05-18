<?php

// https://randomuser.me/api/?results=500&nat=fr&gender=male&inc=name,email&exc=gender,login,registered,dob,phone,cell,id,picture,nat,location
// https://geo.api.gouv.fr/departements/93/communes?fields=code,nom,region,centre

require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// function getUsers($userid, $lat, $lng, $gender, $maleOrientation, $femaleOrientation)
// {
//     $dbc = db_connex();
//     try
//     {
//         $request = $dbc->prepare(
//             "SELECT usr.id AS userid, username, birthdate, popularity, lat, lng, distance, thumbnail
//             FROM (
//                SELECT *, ROUND( SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance FROM users
//             ) usr
//             LEFT JOIN (
//                 SELECT *, profilePicture AS thumbnail FROM pictures
//             ) pct
//             ON usr.id = pct.userid
//             WHERE usr.distance < 10000
//             AND usr.id != :userid
//             AND registrationValidated = 1 AND profileCompleted = 1
//             AND gender != :gender AND maleOrientation != :maleOrientation
//             AND femaleOrientation != :femaleOrientation
//             ORDER BY usr.distance
//             LIMIT 1
//         ");
//         $request->bindValue(':userid', $userid, PDO::PARAM_INT);
//         $request->bindValue(':lat', $lat, PDO::PARAM_STR);
//         $request->bindValue(':lng', $lng, PDO::PARAM_STR);
//         $request->bindValue(':gender', $gender, PDO::PARAM_STR);
//         $request->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_STR);
//         $request->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_STR);
//         $request->execute();
//         return $request->fetchAll();
//     }
//     catch(PDOException $e)
//     {
//         // header("HTTP/1.1 500 database");
//         print_r($e->message);
//     }
// }





function getUsers($userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $lat, $lng)
{
    $dbc = db_connex();
    try
    {
        $request = $dbc->prepare(
            "SELECT usr.id AS userid, username, birthdate, popularity, lat, lng, distance, thumbnail
            FROM (
               SELECT *, ROUND(SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance FROM users
            ) usr
            LEFT JOIN (
                SELECT *, profilePicture AS thumbnail FROM pictures
            ) pct
            ON usr.id = pct.userid
            WHERE usr.distance < 10000
            AND DATEDIFF(year, :birthdate, birthdate) > 20
            AND usr.id != :userid
            AND registrationValidated = 1 AND profileCompleted = 1
            AND gender != :gender AND maleOrientation != :maleOrientation
            AND femaleOrientation != :femaleOrientation
            ORDER BY usr.distance
            LIMIT 1
        ");
        $request->bindValue(':userid', $userid, PDO::PARAM_INT);
        $request->bindValue(':lat', $lat, PDO::PARAM_STR);
        $request->bindValue(':lng', $lng, PDO::PARAM_STR);
        $request->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
        $request->bindValue(':gender', $gender, PDO::PARAM_STR);
        $request->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_STR);
        $request->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_STR);
        $request->execute();
        return $request->fetchAll();
    }
    catch(PDOException $e)
    {
        // header("HTTP/1.1 500 database");
        print_r($e->message);
    }
}






$result = getUsers(497, "1996-09-29T11:44:44+02:00", "MALE", FALSE, TRUE, 48.8589, 2.3470);
print_r($result);





?>