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
        case "type":
            if((isset($data->genderChecked) && !empty($data->genderChecked)) &&
              (isset($data->orientationChecked) && !empty($data->orientationChecked))) {
                $genderChecked = $data->genderChecked;
                $orientationChecked = $data->orientationChecked;
                if(checkGender($genderChecked) === FALSE && checkOrientation($orientationChecked) === FALSE) {
                    userGenderTreatment($genderChecked, $userid);
                    userOrientationTreatment($orientationChecked, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "description":
            if(isset($data->description) && !empty($data->description)) {
                $description = htmlspecialchars($data->description);
                if(checkDescription($description) === FALSE) {
                    userDescriptionTreatment($description, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "tags":
            if(isset($data->userTags) && !empty($data->userTags)) {
                $userTags = $data->userTags;
                if(checkUserTags($userTags) === FALSE) {
                    userTagsTreatment($userTags, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "location":
            if(isset($data->userLocation) && !empty($data->userLocation)) {
                $userLocation = $data->userLocation;
                if(checkLocation($userLocation) === FALSE) {
                    userLocationTreatment($userLocation, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "password":
            if(isset($data->userPassword) && !empty($data->userPassword)) {
                $userPassword = $data->userPassword;
                if(checkPasswords($userPassword) === FALSE) {
                    userPasswordTreatment($userPassword, $userid);
                } else { http_response_code(400); }
            } else { http_response_code(400); }
        break;
        case "delete":
            if(isset($data->passwordAccountDeletion) && !empty($data->passwordAccountDeletion)) {
                $passwordAccountDeletion = $data->passwordAccountDeletion;
                accountDeletionTreatment($passwordAccountDeletion, $userid);
            } else { http_response_code(400); }
        break;
        default:
            http_response_code(400);
    }
}


?>