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
                    formattedProfilePicture($profilePicture, $userid, 'update');
                    http_response_code(200);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "pictures":
            if(isset($data->userPictures) && !empty($data->userPictures)) {
                $userPictures = $data->userPictures;
                if(checkUserPictures($userPictures) === FALSE) {
                    userPicturesTreatment($userPictures, $userid);
                    http_response_code(200);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "primary":
            if(isset($data->usersPersonalInformation) && !empty($data->usersPersonalInformation)) {
                $userInfo = $data->usersPersonalInformation;
                if(checkUserInfo($userInfo) === FALSE) {
                    userInfoTreatment($userInfo, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "birthdate":
            if(isset($data->dateSelected) && !empty($data->dateSelected)) {
                $dateSelected = htmlspecialchars($data->dateSelected);
                if(checkAge($dateSelected) === FALSE) {
                    userBirthdateTreatment($dateSelected, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
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