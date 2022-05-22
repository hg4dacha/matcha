<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");





function getUsers($userid)
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
                    $results = getOppositeGenderUsers(
                        $userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng, $tag1, $tag2, $tag3, $tag4, $tag5
                    );
                    echo(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                    http_response_code(200);
                }
                elseif ( $gender === "MALE" && $maleOrientation == TRUE && $femaleOrientation == TRUE || $gender === "FEMALE" && $maleOrientation == TRUE && $femaleOrientation == TRUE )
                {
                    $results = getBothGenderUsers(
                        $userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng, $tag1, $tag2, $tag3, $tag4, $tag5
                    );
                    echo(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                    http_response_code(200);
                }
                elseif ( $gender === "MALE" && $maleOrientation == TRUE && $femaleOrientation == FALSE || $gender === "FEMALE" && $maleOrientation == FALSE && $femaleOrientation == TRUE )
                {
                    $results = getSameGenderUsers(
                        $userid, $birthdate, $gender, $maleOrientation, $femaleOrientation, $popularity, $lat, $lng, $tag1, $tag2, $tag3, $tag4, $tag5
                    );
                    echo(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
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


?>