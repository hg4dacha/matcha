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
//             "SELECT *, SQRT( POW(69.1 * (lat - :lat), 2) + POW(69.1 * (:lng - lng) * COS(lat / 57.3), 2) ) AS distance
//             FROM users WHERE registrationValidated = 1 AND profileCompleted = 1 AND id != :userid AND gender != :gender AND
//             maleOrientation != :maleOrientation AND femaleOrientation != :femaleOrientation AND
//             users.id_user IN (SELECT id_user FROM tags WHERE tag = ? OR tag = ? OR tag = ?) AND
//             users.id_user NOT IN (SELECT id_blocked FROM black_list WHERE id_blocker = ?) ORDER BY distance LIMIT 90"
//         );
//         // $request->execute(array($latitude, $longitude, $id_user, $gender, $breed, $tag, $tag2, $tag3, $id_user));
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
//         header("HTTP/1.1 500 database");
//     }
// }

// function getUsers($userid, $lat, $lng, $gender, $maleOrientation, $femaleOrientation)
// {
//     $dbc = db_connex();
//     try
//     {
//         $request = $dbc->prepare(
//             "SELECT id, username, birthdate, popularity, lat, lng, distance
//             FROM (
//                SELECT *, ROUND( SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance FROM users
//             ) d
//             WHERE d.distance < 10000
//             AND id != :userid
//             AND registrationValidated = 1 AND profileCompleted = 1
//             AND gender != :gender AND maleOrientation != :maleOrientation
//             AND femaleOrientation != :femaleOrientation
//             ORDER BY d.distance
//             LIMIT 5
//         ");
//         // $request->execute(array($latitude, $longitude, $id_user, $gender, $breed, $tag, $tag2, $tag3, $id_user));
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
//         header("HTTP/1.1 500 database");
//     }
// }


// function getUsers($userid, $lat, $lng, $gender, $maleOrientation, $femaleOrientation)
// {
//     $dbc = db_connex();
//     try
//     {
//         $request = $dbc->prepare(
//             "SELECT id AS userid, username, birthdate, popularity, lat, lng, distance
//             FROM (
//                SELECT *, ROUND( SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance FROM users
//             ) d
//             WHERE d.distance < 10000
//             AND id != :userid
//             AND registrationValidated = 1 AND profileCompleted = 1
//             AND gender != :gender AND maleOrientation != :maleOrientation
//             AND femaleOrientation != :femaleOrientation
//             ORDER BY d.distance
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


function getUsers($userid, $lat, $lng, $gender, $maleOrientation, $femaleOrientation)
{
    $dbc = db_connex();
    try
    {
        $request = $dbc->prepare(
            "SELECT users.id AS userid, username, birthdate, popularity, lat, lng, distance
            FROM (
               SELECT *, ROUND( SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance FROM users
            ) d
            IN (
                SELECT users.id, profilePicture AS thumbnail FROM users
                LEFT JOIN pictures ON users.id = pictures.userid
            )
            WHERE d.distance < 10000
            AND users.id != :userid
            AND users.registrationValidated = 1 AND users.profileCompleted = 1
            AND users.gender != :gender AND users.maleOrientation != :maleOrientation
            AND users.femaleOrientation != :femaleOrientation
            ORDER BY d.distance
            LIMIT 1
        ");
        $request->bindValue(':userid', $userid, PDO::PARAM_INT);
        $request->bindValue(':lat', $lat, PDO::PARAM_STR);
        $request->bindValue(':lng', $lng, PDO::PARAM_STR);
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




$result = getUsers(497, 48.8589, 2.3470, "MALE", FALSE, TRUE);
print_r($result);





?>