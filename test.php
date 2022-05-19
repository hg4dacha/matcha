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





// function getUsers($userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng)
// {
//     $dbc = db_connex();
//     try
//     {
//         $request = $dbc->prepare(
//             "SELECT usr.id AS userid, username, birthdate, popularity, lat, lng, age_diff, distance, thumbnail
//             FROM (
//                SELECT *, ROUND(SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance,
//                TIMESTAMPDIFF(YEAR, :birthdate, birthdate) AS age_diff FROM users
//             ) usr
//             LEFT JOIN (
//                 SELECT *, profilePicture AS thumbnail FROM pictures
//             ) pct
//             ON usr.id = pct.userid
//             WHERE usr.distance <= 100
//             AND usr.age_diff BETWEEN -5 AND 5
//             AND popularity BETWEEN :popularity - 3000 AND :popularity + 3000
//             AND usr.id != :userid
//             AND registrationValidated = 1 AND profileCompleted = 1
//             AND gender != :gender AND maleOrientation != :maleOrientation
//             AND femaleOrientation != :femaleOrientation
//             ORDER BY usr.distance
//             LIMIT 90
//         ");
//         $request->bindValue(':userid', $userid, PDO::PARAM_INT);
//         $request->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);
//         $request->bindValue(':lat', $lat, PDO::PARAM_STR);
//         $request->bindValue(':lng', $lng, PDO::PARAM_STR);
//         $request->bindValue(':gender', $gender, PDO::PARAM_STR);
//         $request->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_STR);
//         $request->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_STR);
//         $request->bindValue(':popularity', $popularity, PDO::PARAM_STR);
//         $request->execute();
//         return $request->fetchAll();
//     }
//     catch(PDOException $e)
//     {
//         // header("HTTP/1.1 500 database");
//         print_r($e);
//     }
// }


// age_diff, distance, first_tag_match, second_tag_match, third_tag_match, fourth_tag_match, fifth_tag_match


function getOppositeGenderUsers(
    $userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng, $tag1, $tag2, $tag3, $tag4, $tag5
) {
    $dbc = db_connex();
    try
    {
        $request = $dbc->prepare(
            "SELECT usr.id AS userid, username, birthdate, popularity, lat, lng, thumbnail, currentUserLat, currentUserLng
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
                END) AS fifth_tag_match,
                (SELECT lat FROM users WHERE id = :userid) AS currentUserLat,
                (SELECT lng FROM users WHERE id = :userid) AS currentUserLng
                FROM users
            ) usr
            LEFT JOIN (
                SELECT *, profilePicture AS thumbnail FROM pictures
            ) pct
            ON usr.id = pct.userid
            WHERE usr.distance BETWEEN 0 AND 100
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






$result = getOppositeGenderUsers(1173, "1989-12-15T13:17:03+01:00", "FEMALE", TRUE, FALSE, 4320, 47.5201, 4.4457, "photographie", "jeuxVideo", "nature", "intello", "social");

$i = 0;
while($i !== count($result))
{
    print_r($result[$i]);
    echo('<br/>');
    echo('<br/>');
    $i++;
}
// print_r($result);





?>