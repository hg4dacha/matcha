<?php



// CHECK PROFILE PICTURE
function checkProfilePicture($profilePicture)
{
    if ( isset($profilePicture->profilePicture) && !empty($profilePicture->profilePicture) )
    {
        $profilePicture = htmlspecialchars($profilePicture->profilePicture);
        if (base64_decode($profilePicture, true) === false)
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

        if ( ((base64_decode($secondPicture, true) === false) || $secondPicture == FALSE) &&
             ((base64_decode($thirdPicture, true) === false) || $thirdPicture == FALSE) &&
             ((base64_decode($fourthPicture, true) === false) || $fourthPicture == FALSE) &&
             ((base64_decode($fifthPicture, true) === false) || $fifthPicture == FALSE)
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







// CHECK DATE FORMAT
function validateDate($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function checkDate($dateSelected)
{
    $dateSelected = date(DATE_ATOM, strtotime($dateSelected));
    if (validateDate($dateSelected, DateTime::ATOM))
    {
        $dateSelectedError = FALSE;
    }
    else
    {
        $dateSelectedError = TRUE;
    }
}







// CHECK GENDER
function checkGender($genderChecked)
{
    if ( (isset($genderChecked->maleGender) && !empty($genderChecked->maleGender)) &&
         (isset($genderChecked->femaleGender) && !empty($genderChecked->femaleGender))
       )
    {
        $maleGender = htmlspecialchars($genderChecked->maleGender);
        $femaleGender = htmlspecialchars($genderChecked->femaleGender);

        if ( is_bool($maleGender) && is_bool($femaleGender) )
        {
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
    else
    {
        return TRUE;
    }
}







// CHECK ORIENTATION
function checkOrientation($orientationChecked)
{
    if ( (isset($orientationChecked->maleOrientation) && !empty($orientationChecked->maleOrientation)) &&
         (isset($orientationChecked->femaleOrientation) && !empty($orientationChecked->femaleOrientation))
       )
    {
        $maleOrientation = htmlspecialchars($orientationChecked->maleOrientation);
        $femaleOrientation = htmlspecialchars($orientationChecked->femaleOrientation);

        if ( is_bool($maleOrientation) && is_bool($femaleOrientation) )
        {
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
        $descriptionError = FALSE;
    }
    else
    {
        $descriptionError = TRUE;
    }
}







// TAGS DATA
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

// CHECK USER TAGS
function checkUserTags($userTags)
{
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
            else if (isset($decoded['address']['city_district'])) { $reqCity = $decoded['address']['city']; }
            else if (isset($decoded['address']['town'])) { $reqCity = $decoded['address']['city']; }
            $reqState = $decoded['address']['state'];
            $reqCountry = $decoded['address']['country'];

            if ( ($city == $reqCity) && ($state == $reqState) && ($country == $reqCountry) )
            {
                if ( $city == "France" )
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



?>