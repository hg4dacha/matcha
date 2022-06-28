<?php



// CHECK PROFILE PICTURE
function checkProfilePicture($profilePicture)
{
    if ( isset($profilePicture->profilePicture) && !empty($profilePicture->profilePicture) )
    {
        $profilePicture = htmlspecialchars($profilePicture->profilePicture);

        if ( strpos($profilePicture, "data:image/png;base64,") !== false )
        {
            $picture_base64 = str_replace('data:image/png;base64,', '', $profilePicture);
        }
        else if ( strpos($profilePicture, "data:image/jpeg;base64,") !== false )
        {
            $picture_base64 = str_replace('data:image/jpeg;base64,', '', $profilePicture);
        }
        else if ( strpos($profilePicture, "data:image/jpg;base64,") !== false )
        {
            $picture_base64 = str_replace('data:image/jpg;base64,', '', $profilePicture);
        }
        else
        {
            return TRUE;
        }

        if (base64_decode($picture_base64, true) === false)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else
    {
        return TRUE;
    }
}







// CHECK USER PICTURES
function checkUserPicturesValidity($picture)
{
    $picture_base64 = NULL;

    if ( $picture == FALSE )
    {
        return FALSE;
    }
    else if ( ($picture !== FALSE) && (strpos($picture, "data:image/png;base64,") !== false) )
    {
        $picture_base64 = str_replace('data:image/png;base64,', '', $picture);
        if (base64_decode($picture_base64, true) === false)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else if ( ($picture !== FALSE) && (strpos($picture, "data:image/jpeg;base64,") !== false) )
    {
        $picture_base64 = str_replace('data:image/jpeg;base64,', '', $picture);
        if (base64_decode($picture_base64, true) === false)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else if ( ($picture !== FALSE) && (strpos($picture, "data:image/jpg;base64,") !== false) )
    {
        $picture_base64 = str_replace('data:image/jpg;base64,', '', $picture);
        if (base64_decode($picture_base64, true) === false)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else
    {
        // $matches;
        preg_match('/[^.]+\.[^.]+$/', $picture, $matches);
        if ( count($matches) === 0 )
        {
            return TRUE;
        }
        else if ( (strpos($picture, ".png") !== false) ||
                  (strpos($picture, ".jpeg") !== false) ||
                  (strpos($picture, ".jpg") !== false)
                )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}

function checkUserPictures($userPictures)
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

        $secondPictureCheck =  checkUserPicturesValidity($secondPicture);
        $thirdPictureCheck =  checkUserPicturesValidity($thirdPicture);
        $fourthPictureCheck =  checkUserPicturesValidity($fourthPicture);
        $fifthPictureCheck =  checkUserPicturesValidity($fifthPicture);

        if ( $secondPictureCheck === FALSE && $thirdPictureCheck === FALSE &&
             $fourthPictureCheck === FALSE && $fifthPictureCheck === FALSE )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}







// CHECK DATE FORMAT
function validateDate($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function checkAge($dateSelected)
{
    $dateSelected = date(DATE_ATOM, strtotime($dateSelected));
    if (validateDate($dateSelected, DateTime::ATOM))
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}







// CHECK GENDER
function checkGender($genderChecked)
{
    if ( isset($genderChecked->maleGender) && isset($genderChecked->femaleGender) )
    {
        $maleGender = filter_var(htmlspecialchars($genderChecked->maleGender), FILTER_VALIDATE_BOOLEAN);
        $femaleGender = filter_var(htmlspecialchars($genderChecked->femaleGender), FILTER_VALIDATE_BOOLEAN);

        if ( $maleGender != $femaleGender )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    else
    {
        return TRUE;
    }
}







// CHECK ORIENTATION
function checkOrientation($orientationChecked)
{
    if ( isset($orientationChecked->maleOrientation) && isset($orientationChecked->femaleOrientation) )
    {
        $maleOrientation = filter_var(htmlspecialchars($orientationChecked->maleOrientation), FILTER_VALIDATE_BOOLEAN);
        $femaleOrientation = filter_var(htmlspecialchars($orientationChecked->femaleOrientation), FILTER_VALIDATE_BOOLEAN);

        if ( $maleOrientation == TRUE || $femaleOrientation == TRUE )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    else
    {
        return TRUE;
    }
}







// CHECK DESCRIPTION
function checkDescription($description)
{
    if ($description != '' && strlen($description) <= 650)
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}







// CHECK USER TAGS
function checkUserTags($userTags)
{
    $tagsData = [
        "food", "science", "intello", "coding", "dodo", "bio", "geek", "vegan",
        "artiste", "meditation", "paresse", "fitness", "aventure", "timide", "marketing",
        "fastfood", "intelligence", "humour", "cool", "highTech", "globetrotting", "histoire",
        "shopping", "nature", "sport", "football", "literature", "math", "action", "faitsDivers",
        "decouverte", "cinema", "musique", "actualite", "politique", "social", "etudes",
        "cuisine", "humanitaire", "animaux", "environnement", "jeuxVideo", "peinture", "dessin",
        "ecriture", "lecture", "photographie", "chasse", "randonnee", "marche", "plage", "detente",
        "automobile", "couture", "innovation", "terroir", "informatique", "marathon", "blogging"
    ];

    if ( count($userTags) == 5 )
    {
        $tag1 = htmlspecialchars($userTags[0]);
        $tag2 = htmlspecialchars($userTags[1]);
        $tag3 = htmlspecialchars($userTags[2]);
        $tag4 = htmlspecialchars($userTags[3]);
        $tag5 = htmlspecialchars($userTags[4]);
        if ( in_array($tag1, $tagsData) && in_array($tag2, $tagsData) && in_array($tag3, $tagsData)
             && in_array($tag4, $tagsData) && in_array($tag5, $tagsData) )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    else
    {
        return TRUE;
    }
}







// CHECK LOCATION
function checkLocation($userLocation)
{

    if ( (isset($userLocation->lat) && !empty($userLocation->lat)) && 
         (isset($userLocation->lng) && !empty($userLocation->lng)) &&
         (isset($userLocation->city) && !empty($userLocation->city)) &&
         (isset($userLocation->state) && !empty($userLocation->state)) &&
         (isset($userLocation->country) && !empty($userLocation->country))
       )
    {
        $lat = htmlspecialchars($userLocation->lat);
        $lng = htmlspecialchars($userLocation->lng);
        $city = htmlspecialchars($userLocation->city);
        $state = htmlspecialchars($userLocation->state);
        $country = htmlspecialchars($userLocation->country);

        if ( is_numeric($lat) && is_numeric($lng) )
        {
            
            $latitude = $lat;
            $longitude = $lng;
            $ch = curl_init();
            $url = "https://nominatim.openstreetmap.org/reverse?email=camagru042@gmail.com&lat=".$latitude."&lon=".$longitude."&format=json&accept-language=fr-FR";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if($e = curl_error($ch))
            {
                echo $e;
            }
            else
            {
                $decoded = json_decode($response, true);
            }
        
            if (isset($decoded['address']['city'])) { $reqCity = $decoded['address']['city']; }
            else if (isset($decoded['address']['city_district'])) { $reqCity = $decoded['address']['city_district']; }
            else if (isset($decoded['address']['town'])) { $reqCity = $decoded['address']['town']; }
            $reqState = $decoded['address']['state'];
            $reqCountry = $decoded['address']['country'];

            if ( ($city == $reqCity) && ($state == $reqState) && ($country == $reqCountry) )
            {
                if ( $country == "France" )
                {
                    return FALSE;
                }
                else
                {
                    return TRUE;
                }
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return TRUE;
        }
    }
    else
    {
        return TRUE;
    }
}




// CHECK USER INFO
function checkUserInfo($userInfo)
{
    if ( (isset($userInfo->lastname) && !empty($userInfo->lastname)) &&
         (isset($userInfo->firstname) && !empty($userInfo->firstname)) &&
         (isset($userInfo->username) && !empty($userInfo->username)) &&
         (isset($userInfo->email) && !empty($userInfo->email))
       )
    {
        $lastname = htmlspecialchars($userInfo->lastname);
        $firstname = htmlspecialchars($userInfo->firstname);
        $username = htmlspecialchars($userInfo->username);
        $email = htmlspecialchars($userInfo->email);

        if ( preg_match("#^[a-zA-Z-]{1,30}$#", $lastname) &&
             preg_match("#^[a-zA-Z-]{1,30}$#", $firstname) &&
             preg_match("#^[a-zA-Z0-9_-]{1,15}$#", $username) &&
             (preg_match("#^.{5,255}$#", $email) && filter_var($email, FILTER_VALIDATE_EMAIL))
           )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    else
    {
        return TRUE;
    }
}





// CHECK PASSWORDS
function checkPasswords($userPassword)
{
    if((isset($userPassword->currentPassword) && !empty($userPassword->currentPassword)) &&
       (isset($userPassword->newPassword) && !empty($userPassword->newPassword)) &&
       (isset($userPassword->newPasswordConfirmation) && !empty($userPassword->newPasswordConfirmation)))
    {
        $currentPassword = htmlspecialchars($userPassword->currentPassword);
        $newPassword = htmlspecialchars($userPassword->newPassword);
        $newPasswordConfirmation = htmlspecialchars($userPassword->newPasswordConfirmation);

        if(preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,255}$#", $currentPassword) &&
           preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,255}$#", $newPassword) &&
           preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,255}$#", $newPasswordConfirmation))
        {
            if($newPassword === $newPasswordConfirmation)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return TRUE;
        }
    }
    else
    {
        return TRUE;
    }
}



?>