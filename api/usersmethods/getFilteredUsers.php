<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");




function getFilteredUsers($userid, $minAge, $maxAge, $minPop, $maxPop, $minGap, $maxGap, $minTag, $maxTag)
{
    if ( is_numeric($minAge) && is_numeric($maxAge) && is_numeric($minPop) && is_numeric($maxPop) &&
         is_numeric($minGap) && is_numeric($maxGap) && is_numeric($minTag) && is_numeric($maxTag) )
    {
        $minAge = intval($minAge);
        $maxAge = intval($maxAge);

        $minPop = intval($minPop);
        $maxPop = intval($maxPop);

        $minGap = intval($minGap);
        $maxGap = intval($maxGap);
        
        $minTag = intval($minTag);
        $maxTag = intval($maxTag);

        if ( $minAge >= 18 && $maxAge <= 99 &&
             $minPop >= 0 && $maxPop <= 5000 &&
             $minGap >= 0 && $maxGap <= 1000 &&
             $minTag >= 0 && $maxTag <= 5 )
        {
            $userInfo = getUserInfo($userid);

            if ( $userInfo["registrationValidated"] == true )
            {
                if ( $userInfo["connectionStatue"] == true )
                {
                    if ( $userInfo["profileCompleted"] == true )
                    {
                        $birthdate = $userInfo["birthdate"];
                        $gender = $userInfo["gender"];
                        $maleOrientation = $userInfo["maleOrientation"];
                        $femaleOrientation = $userInfo["femaleOrientation"];
                        $popularity = $userInfo["popularity"];
                        $lat = $userInfo["lat"];
                        $lng = $userInfo["lng"];
                        $tag1 = $userInfo["tag1"];
                        $tag2 = $userInfo["tag2"];
                        $tag3 = $userInfo["tag3"];
                        $tag4 = $userInfo["tag4"];
                        $tag5 = $userInfo["tag5"];

                        if ( $gender === "MALE" && $maleOrientation == FALSE && $femaleOrientation == TRUE || $gender === "FEMALE" && $maleOrientation == TRUE && $femaleOrientation == FALSE )
                        {
                            // $results = getOppositeGenderUsers(
                            //     $userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng, $tag1, $tag2, $tag3, $tag4, $tag5
                            // );
                            // echo(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                            http_response_code(200);
                        }
                        elseif ( $gender === "MALE" && $maleOrientation == TRUE && $femaleOrientation == TRUE || $gender === "FEMALE" && $maleOrientation == TRUE && $femaleOrientation == TRUE )
                        {
                            // $results = getUsersForUser($gender);
                            // echo(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                            http_response_code(200);
                        }
                        elseif ( $gender === "MALE" && $maleOrientation == TRUE && $femaleOrientation == FALSE || $gender === "FEMALE" && $maleOrientation == FALSE && $femaleOrientation == TRUE )
                        {
                            // $results = getUsersForUser($gender);
                            // echo(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                            http_response_code(200);
                        }
                    }
                    else {
                        header("HTTP/1.1 400 incomplete profile");
                    }
                }
                else {
                    header("HTTP/1.1 400 disconnect");
                }
            }
            else {
                header("HTTP/1.1 400 invalid registration");
            }
        }
        else {
            header("HTTP/1.1 400 invalid options");
        }
    }
    else
    {
        header("HTTP/1.1 400 invalid options");
    }
}


?>