<?php

// https://randomuser.me/api/?results=500&nat=fr&gender=male&inc=name,email&exc=gender,login,registered,dob,phone,cell,id,picture,nat,location
// https://geo.api.gouv.fr/departements/93/communes?fields=code,nom,region,centre

require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



function getBothGenderUsersWithOptions(
    $userid, $gender, $maleOrientation, $femaleOrientation, $lat, $lng, $tag1, $tag2, $tag3,
    $tag4, $tag5, $minAge, $maxAge, $minPop, $maxPop, $minGap, $maxGap, $minTag, $maxTag
) {
    $dbc = db_connex();
    try
    {
        $request = $dbc->prepare(
            "SELECT usr.id AS userid, username, birthdate, popularity, lat, lng, thumbnail
            FROM (
               SELECT *, ROUND(SQRT( POW(111.5 * (lat - :lat), 2) + POW(111.5 * (:lng - lng) * COS(lat / 57.3), 2) ), 0) AS distance,
               TIMESTAMPDIFF(YEAR, birthdate, CURRENT_DATE()) AS age_diff,
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
            WHERE usr.distance BETWEEN :minGap AND :maxGap
            AND usr.age_diff BETWEEN :minAge AND :maxAge
            AND popularity BETWEEN :minPop AND :maxPop
            AND (usr.first_tag_match + usr.second_tag_match + usr.third_tag_match + usr.fourth_tag_match + usr.fifth_tag_match) BETWEEN :minTag AND :maxTag
            AND usr.id != :userid
            AND registrationValidated = 1 AND profileCompleted = 1
            AND (gender = :gender OR gender != :gender)
            AND maleOrientation = :maleOrientation
            AND femaleOrientation = :femaleOrientation
            AND usr.id NOT IN (SELECT blocked FROM blocked WHERE blocker = :userid)
            AND usr.id NOT IN (SELECT blocker FROM blocked WHERE blocked = :userid)
            ORDER BY usr.distance
            LIMIT 90
        ");
        $request->bindValue(':userid', $userid, PDO::PARAM_INT);
        $request->bindValue(':gender', $gender, PDO::PARAM_STR);
        $request->bindValue(':maleOrientation', $maleOrientation, PDO::PARAM_STR);
        $request->bindValue(':femaleOrientation', $femaleOrientation, PDO::PARAM_STR);
        $request->bindValue(':lat', $lat, PDO::PARAM_STR);
        $request->bindValue(':lng', $lng, PDO::PARAM_STR);
        $request->bindValue(':tag1', $tag1, PDO::PARAM_STR);
        $request->bindValue(':tag2', $tag2, PDO::PARAM_STR);
        $request->bindValue(':tag3', $tag3, PDO::PARAM_STR);
        $request->bindValue(':tag4', $tag4, PDO::PARAM_STR);
        $request->bindValue(':tag5', $tag5, PDO::PARAM_STR);
        $request->bindValue(':minAge', $minAge, PDO::PARAM_INT);
        $request->bindValue(':maxAge', $maxAge, PDO::PARAM_INT);
        $request->bindValue(':minPop', $minPop, PDO::PARAM_INT);
        $request->bindValue(':maxPop', $maxPop, PDO::PARAM_INT);
        $request->bindValue(':minGap', $minGap, PDO::PARAM_INT);
        $request->bindValue(':maxGap', $maxGap, PDO::PARAM_INT);
        $request->bindValue(':minTag', $minTag, PDO::PARAM_INT);
        $request->bindValue(':maxTag', $maxTag, PDO::PARAM_INT);

        $request->execute();
        return $request->fetchAll();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}






// $result = getBothGenderUsersWithOptions(
//     1173, "MALE", TRUE, TRUE, 47.5201, 4.4457, "photographie", "jeuxVideo", "nature", "intello", "social",
//     20, 25, 1000, 5000, 200, 6000, 1, 5
// );

// $i = 0;
// while($i !== count($result))
// {
//     var_dump($result[$i]);
//     echo('<br/>');
//     echo('<br/>');
//     $i++;
// }





?>