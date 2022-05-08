<?php



require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/functions/checkCompleteProfileData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/functions/formattedCompleteProfileData.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");




function profileCompletedValidate($userid)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET profileCompleted = TRUE WHERE id = :userid");
        $reqUpdate->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqUpdate->execute();
    }
    catch(PDOException $e)
    {
        $error = [
            "error" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        return ($error);
    }
}



function completeUserData($data, $userid)
{

    if ( (isset($data->profilePicture) && !empty($data->profilePicture)) &&
         (isset($data->userPictures) && !empty($data->userPictures)) &&
         (isset($data->dateSelected) && !empty($data->dateSelected)) &&
         (isset($data->genderChecked) && !empty($data->genderChecked)) &&
         (isset($data->orientationChecked) && !empty($data->orientationChecked)) &&
         (isset($data->userLocation) && !empty($data->userLocation)) &&
         (isset($data->userTags) && !empty($data->userTags)) &&
         (isset($data->description) && !empty($data->description))
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
        

        // CHECK USER LOCATION
        $userLocation = $data->userLocation;
        $userLocationError = checkLocation($userLocation);


        // CHECK USER TAGS
        $userTags = $data->userTags;
        $userTagsError = checkUserTags($userTags);


        // CHECK DESCRIPTION
        $description = htmlspecialchars($data->description);
        $descriptionError = checkDescription($description);


        if ( $profilePictureError === FALSE && $userPicturesError === FALSE &&
             $dateSelectedError === FALSE && $genderCheckedError === FALSE &&
             $orientationCheckedError === FALSE && $userLocationError === FALSE &&
             $userTagsError === FALSE && $descriptionError === FALSE
           )
        {
            $registrationValidated = registrationValidatedCheck($userid);

            if ( $registrationValidated[0] == TRUE )
            {
                formattedProfilePicture($profilePicture, $userid, 'insert');
                userPicturesTreatment($userPictures, $userid);
                userBirthdateTreatment($dateSelected, $userid);
                userGenderTreatment($genderChecked, $userid);
                userOrientationTreatment($orientationChecked, $userid);
                userLocationTreatment($userLocation, $userid);
                userTagsTreatment($userTags, $userid);
                userDescriptionTreatment($description, $userid);
                profileCompletedValidate($userid);
                updateUserConnection(TRUE, date(DATE_ATOM), $userid);
                http_response_code(200);
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