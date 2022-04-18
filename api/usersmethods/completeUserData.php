<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/functions/checkCompleteProfileData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/functions/formattedCompleteProfileData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");



function completeUserData($data)
{

    if ( (isset($data->profilePicture) && !empty($data->profilePicture)) &&
         (isset($data->userPictures) && !empty($data->userPictures)) &&
         (isset($data->dateSelected) && !empty($data->dateSelected)) &&
         (isset($data->genderChecked) && !empty($data->genderChecked)) &&
         (isset($data->orientationChecked) && !empty($data->orientationChecked)) &&
         (isset($data->description) && !empty($data->description)) &&
         (isset($data->userTags) && !empty($data->userTags)) &&
         (isset($data->userLocation) && !empty($data->userLocation))
       )
    {
        // CHECK PROFILE PICTURE
        $profilePicture = $data->profilePicture;
        $profilePictureError = checkProfilePicture($profilePicture);


        // CHECK USER PICTURES
        $userPictures = $data->userPictures;
        $userPicturesError = checkUserPictures($userPictures);

    
        // CHECK DATE
        $dateSelected = htmlspecialchars($data->dateSelected);
        $dateSelectedError = checkAge($dateSelected);


        // CHECK GENDER
        $genderChecked = $data->genderChecked;
        $genderCheckedError = checkGender($genderChecked);


        // CHECK ORIENTATION
        $orientationChecked = $data->orientationChecked;
        $orientationCheckedError = checkOrientation($orientationChecked);


        // CHECK DESCRIPTION
        $description = htmlspecialchars($data->description);
        $descriptionError = checkDescription($description);


        // CHECK USER TAGS
        $userTags = $data->userTags;
        $userTagsError = checkUserTags($userTags);


        // CHECK USER LOCATION
        $userLocation = $data->userLocation;
        $userLocationError = checkLocation($userLocation);


        if ( $profilePictureError === FALSE && $userPicturesError === FALSE &&
             $dateSelectedError === FALSE && $genderCheckedError === FALSE &&
             $orientationCheckedError === FALSE && $descriptionError === FALSE &&
             $userTagsError === FALSE && $userLocationError === FALSE
           )
        {
            $registrationValidated = registrationValidatedCheck(62);

            if ( $registrationValidated[0] == TRUE )
            {
                formattedProfilePicture($profilePicture);
            }
            else
            {
                http_response_code(400);
            }
        }
        else
        {
            http_response_code(400);
        }
    }
    else
    {
        http_response_code(400);
    }
}


?>