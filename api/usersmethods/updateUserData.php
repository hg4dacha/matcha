<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/functions/checkCompleteProfileData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/functions/formattedCompleteProfileData.php");



function updateUserData($data, $userid, $object)
{
    switch($object)
    {
        case "picture":
            if(isset($data->profilePicture) && !empty($data->profilePicture)) {
                $profilePicture = $data->profilePicture;
                if(checkProfilePicture($profilePicture) === FALSE) {
                    formattedProfilePicture($profilePicture, $userid);
                    http_response_code(200);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "pictures":

        break;
        case "primary":
            
        break;
        case "birthdate":
            
        break;
        case "gender":
    
        break;
        case "orientation":

        break;
        case "description":

        break;
        case "tags":

        break;
        case "location":

        break;
        case "password":

        break;
        case "delete":

        break;
        default:
            http_response_code(400);
    }
}


?>