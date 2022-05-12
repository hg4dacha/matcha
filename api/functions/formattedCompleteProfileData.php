<?php




require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/gettings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");




function formattedProfilePicture($profilePicture, $userid, $action)
{
    if ( isset($profilePicture->profilePicture) && !empty($profilePicture->profilePicture) )
    {
        $profilePicture = htmlspecialchars($profilePicture->profilePicture);
        
        if ( strpos($profilePicture, "data:image/png;base64,") !== false ) {
            $profilePicture = str_replace('data:image/png;base64,', '', $profilePicture);
        } else if ( strpos($profilePicture, "data:image/jpeg;base64,") !== false ) {
            $profilePicture = str_replace('data:image/jpeg;base64,', '', $profilePicture);
        } else if ( strpos($profilePicture, "data:image/jpg;base64,") !== false ) {
            $profilePicture = str_replace('data:image/jpg;base64,', '', $profilePicture);
        }

        $profilePicture = base64_decode($profilePicture);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $profilePicture, FILEINFO_MIME_TYPE);
        $pictureID = $userid.uniqid();

        if ( $mime_type == 'image/jpeg' )
        {
            $picturePath = 'http://localhost:8080/matcha/api/pictures/'.$pictureID.'.jpeg';
            $newPicture = imagecreatefromstring($profilePicture);
            imagejpeg($newPicture, '/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.jpeg');
            imagedestroy($newPicture);
            chmod('/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.jpeg', 0777);
        }
        else
        {
            $picturePath = 'http://localhost:8080/matcha/api/pictures/'.$pictureID.'.png';
            $newPicture = imagecreatefromstring($profilePicture);
            imagepng($newPicture, '/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.png');
            imagedestroy($newPicture);
            chmod('/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.png', 0777);
        }

        if ( $action === 'insert' ) {
            insertProfilePicture($userid, $picturePath);
        }
        elseif ( $action === 'update' ) {
            $allUserPictures = getAllUserPictures($userid);
            $profilePictureName = explode('/', $allUserPictures['profilePicture']);
            $profilePictureName = $profilePictureName[(count($profilePictureName)) - 1];
            if(file_exists($_SERVER['DOCUMENT_ROOT']."/matcha/api/pictures/".$profilePictureName)) {
                unlink($_SERVER['DOCUMENT_ROOT']."/matcha/api/pictures/".$profilePictureName);
            }
            updateProfilePicture($userid, $picturePath);
        }
    }
}






function formattedPicture($userid, $picture, $pictureNumber)
{
    $allUserPictures = getAllUserPictures($userid);
    if($allUserPictures[$pictureNumber] !== NULL) {
        $profilePictureName = explode('/', $allUserPictures[$pictureNumber]);
        $profilePictureName = $profilePictureName[(count($profilePictureName)) - 1];
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/matcha/api/pictures/".$profilePictureName)) {
            unlink($_SERVER['DOCUMENT_ROOT']."/matcha/api/pictures/".$profilePictureName);
        }
    }

    if ( $picture == FALSE )
    {
        updatePictureNull($userid, $pictureNumber);
        return;
    }
    else
    {
        $picture = htmlspecialchars($picture);
        
        if ( strpos($picture, "data:image/png;base64,") !== false ) {
            $picture = str_replace('data:image/png;base64,', '', $picture);
        } else if ( strpos($picture, "data:image/jpeg;base64,") !== false ) {
            $picture = str_replace('data:image/jpeg;base64,', '', $picture);
        } else if ( strpos($picture, "data:image/jpg;base64,") !== false ) {
            $picture = str_replace('data:image/jpg;base64,', '', $picture);
        }

        $picture = base64_decode($picture);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $picture, FILEINFO_MIME_TYPE);
        $pictureID = $userid.uniqid();

        if ( $mime_type == 'image/jpeg' )
        {
            $picturePath = 'http://localhost:8080/matcha/api/pictures/'.$pictureID.'.jpeg';
            $newPicture = imagecreatefromstring($picture);
            imagejpeg($newPicture, '/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.jpeg');
            imagedestroy($newPicture);
            chmod('/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.jpeg', 0777);
        }
        else
        {
            $picturePath = 'http://localhost:8080/matcha/api/pictures/'.$pictureID.'.png';
            $newPicture = imagecreatefromstring($picture);
            imagepng($newPicture, '/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.png');
            imagedestroy($newPicture);
            chmod('/opt/lampp/htdocs/matcha/api/pictures/'.$pictureID.'.png', 0777);
        }

        updateUserPictures($userid, $pictureNumber, $picturePath);
    }
}

function userPicturesTreatment($userPictures, $userid)
{
    if ( isset($userPictures->secondPicture) &&
         isset($userPictures->thirdPicture) &&
         isset($userPictures->fourthPicture) &&
         isset($userPictures->fifthPicture)
       )
    {
        $secondPicture = htmlspecialchars($userPictures->secondPicture);
        $thirdPicture = htmlspecialchars($userPictures->thirdPicture);
        $fourthPicture = htmlspecialchars($userPictures->fourthPicture);
        $fifthPicture = htmlspecialchars($userPictures->fifthPicture);


        formattedPicture($userid, $secondPicture, "secondPicture");
        formattedPicture($userid, $thirdPicture, "thirdPicture");
        formattedPicture($userid, $fourthPicture, "fourthPicture");
        formattedPicture($userid, $fifthPicture, "fifthPicture");
    }
}







function userBirthdateTreatment($dateSelected, $userid)
{
    $dateSelected = date(DATE_ATOM, strtotime($dateSelected));
    updateUserBirthdate($userid, $dateSelected);
}





function userGenderTreatment($genderChecked, $userid)
{
    if ( isset($genderChecked->maleGender) && isset($genderChecked->femaleGender) )
    {
        $maleGender = filter_var(htmlspecialchars($genderChecked->maleGender), FILTER_VALIDATE_BOOLEAN);
        $femaleGender = filter_var(htmlspecialchars($genderChecked->femaleGender), FILTER_VALIDATE_BOOLEAN);

        if ( $maleGender == TRUE )
        {
            updateUserGender($userid, "MALE");
        }
        else if ( $femaleGender == TRUE )
        {
            updateUserGender($userid, "FEMALE");
        }
    }
}





function userOrientationTreatment($orientationChecked, $userid)
{
    if ( isset($orientationChecked->maleOrientation) && isset($orientationChecked->femaleOrientation) )
    {
        $maleOrientation = filter_var(htmlspecialchars($orientationChecked->maleOrientation), FILTER_VALIDATE_BOOLEAN);
        $femaleOrientation = filter_var(htmlspecialchars($orientationChecked->femaleOrientation), FILTER_VALIDATE_BOOLEAN);

        if ( $maleOrientation == TRUE || $femaleOrientation == TRUE )
        {
            updateUserOrientation($userid, $maleOrientation, $femaleOrientation);
        }
    }
}





function userLocationTreatment($userLocation, $userid)
{
        $lat = htmlspecialchars($userLocation->lat);
        $lng = htmlspecialchars($userLocation->lng);
        $userLocation = json_encode($userLocation, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        updateUserLocation($userid, $userLocation, $lat, $lng);
}





function userTagsTreatment($userTags, $userid)
{
        $userTags = json_encode($userTags);
        updateUserTags($userid, $userTags);
}





function userDescriptionTreatment($description, $userid)
{
        updateUserDescription($userid, $description);
}





function userInfoTreatment($userInfo, $userid)
{
    $lastname = htmlspecialchars($userInfo->lastname);
    $firstname = htmlspecialchars($userInfo->firstname);
    $username = htmlspecialchars($userInfo->username);
    $email = htmlspecialchars($userInfo->email);

    $userData = userProfileData($userid);
    
    if($userData['username'] !== $username) {
        if (checkUsernameExistence(strtolower($username)) != 0) {
            header("HTTP/1.1 409 reserved username");
            exit;
        }
    }

    if($userData['email'] !== $email) {
        if (checkEmailExistence(strtolower($email)) != 0) {
            header("HTTP/1.1 409 reserved email");
            exit;
        }
    }

    updateUserInfo($userid, $lastname, $firstname, $username, $email);
}






function userPasswordTreatment($userPassword, $userid)
{
    $currentPassword = htmlspecialchars($userPassword->currentPassword);
    $newPassword = htmlspecialchars($userPassword->newPassword);

    $passwordDatabase = getPasswordById($userid);

    if(password_verify($currentPassword, $passwordDatabase[0]))
    {
        $newPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        updateUserPassword($userid, $newPassword);
    }
    else
    {
        header("HTTP/1.1 400 incorrect password");
    }
}





//___________________________/!\DELETE USER ACCOUNT /!\_________________________
//______________________________________________________________________________
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/deletions.php");

function deletePictureFromFolder($picture)
{
    if(!isset($picture)) {
        return;
    }
    else {
        $profilePictureName = explode('/', $picture);
        $profilePictureName = $profilePictureName[(count($profilePictureName)) - 1];
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/matcha/api/pictures/".$profilePictureName)) {
            unlink($_SERVER['DOCUMENT_ROOT']."/matcha/api/pictures/".$profilePictureName);
        }
        else {
            return;
        }
    }
}


function accountDeletionTreatment($password, $userid)
{
    $passwordDatabase = getPasswordById($userid);

    if(password_verify($password, $passwordDatabase[0]))
    {
        $allUserPictures = getAllUserPictures($userid);
        deletePictureFromFolder($allUserPictures['profilePicture']);
        deletePictureFromFolder($allUserPictures['secondPicture']);
        deletePictureFromFolder($allUserPictures['thirdPicture']);
        deletePictureFromFolder($allUserPictures['fourthPicture']);
        deletePictureFromFolder($allUserPictures['fifthPicture']);

        deleteUser($userid);
        deleteUserPictures($userid);
        //delete notif and other tables...

        if(isset($_COOKIE['REFRESH_TOKEN']) && !empty($_COOKIE['REFRESH_TOKEN'])) {
            unset($_COOKIE['REFRESH_TOKEN']);
        }
        setcookie('REFRESH_TOKEN', '', time() - 10, '/', NULL, false, true);
        http_response_code(200);
    }
    else
    {
        header("HTTP/1.1 400 incorrect password");
    }
}



?>