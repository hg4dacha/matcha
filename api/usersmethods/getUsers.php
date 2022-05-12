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
                $tags = $userInfo["tags"];
                $popularity = $userInfo["popularity"];
                $lat = $userInfo["lat"];
                $lng = $userInfo["lng"];
            
            
                if ( $gender === "MALE" && $maleOrientation == FALSE && $femaleOrientation == TRUE || $gender === "FEMALE" && $maleOrientation == TRUE && $femaleOrientation == FALSE )
                {
                    // $results = getUsersForUser($gender);
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
            http_response_code(400);
        }
    }
    else {
        http_response_code(400);
    }

}


?>