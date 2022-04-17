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


        $secondPicture_base64 = null;
        if ( ($secondPicture !== false) && (strpos($secondPicture, "data:image/png;base64,") !== false) )
        {
            $secondPicture_base64 = str_replace('data:image/png;base64,', '', $secondPicture);
        }
        else if ( ($secondPicture !== false) && (strpos($secondPicture, "data:image/jpeg;base64,") !== false) )
        {
            $secondPicture_base64 = str_replace('data:image/jpeg;base64,', '', $secondPicture);
        }
        else if ( ($secondPicture !== false) && (strpos($secondPicture, "data:image/jpg;base64,") !== false) )
        {
            $secondPicture_base64 = str_replace('data:image/jpg;base64,', '', $secondPicture);
        }


        $thirdPicture_base64 = null;
        if ( ($thirdPicture !== false) && (strpos($thirdPicture, "data:image/png;base64,") !== false) )
        {
            $thirdPicture_base64 = str_replace('data:image/png;base64,', '', $thirdPicture);
        }
        else if ( ($thirdPicture !== false) && (strpos($thirdPicture, "data:image/jpeg;base64,") !== false) )
        {
            $thirdPicture_base64 = str_replace('data:image/jpeg;base64,', '', $thirdPicture);
        }
        else if ( ($thirdPicture !== false) && (strpos($thirdPicture, "data:image/jpg;base64,") !== false) )
        {
            $thirdPicture_base64 = str_replace('data:image/jpg;base64,', '', $thirdPicture);
        }


        $fourthPicture_base64 = null;
        if ( ($fourthPicture !== false) && (strpos($fourthPicture, "data:image/png;base64,") !== false) )
        {
            $fourthPicture_base64 = str_replace('data:image/png;base64,', '', $fourthPicture);
        }
        else if ( ($fourthPicture !== false) && (strpos($fourthPicture, "data:image/jpeg;base64,") !== false) )
        {
            $fourthPicture_base64 = str_replace('data:image/jpeg;base64,', '', $fourthPicture);
        }
        else if ( ($fourthPicture !== false) && (strpos($fourthPicture, "data:image/jpg;base64,") !== false) )
        {
            $fourthPicture_base64 = str_replace('data:image/jpg;base64,', '', $fourthPicture);
        }


        $fifthPicture_base64 = null;
        if ( ($fifthPicture !== false) && (strpos($fifthPicture, "data:image/png;base64,") !== false) )
        {
            $fifthPicture_base64 = str_replace('data:image/png;base64,', '', $fifthPicture);
        }
        else if ( ($fifthPicture !== false) && (strpos($fifthPicture, "data:image/jpeg;base64,") !== false) )
        {
            $fifthPicture_base64 = str_replace('data:image/jpeg;base64,', '', $fifthPicture);
        }
        else if ( ($fifthPicture !== false) && (strpos($fifthPicture, "data:image/jpg;base64,") !== false) )
        {
            $fifthPicture_base64 = str_replace('data:image/jpg;base64,', '', $fifthPicture);
        }



        if ( ((base64_decode($secondPicture_base64, true) === false) && $secondPicture !== FALSE) &&
             ((base64_decode($thirdPicture_base64, true) === false) && $thirdPicture !== FALSE) &&
             ((base64_decode($fourthPicture_base64, true) === false) && $fourthPicture !== FALSE) &&
             ((base64_decode($fifthPicture_base64, true) === false) && $fifthPicture !== FALSE)
           )
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
            else if (isset($decoded['address']['city_district'])) { $reqCity = $decoded['address']['city']; }
            else if (isset($decoded['address']['town'])) { $reqCity = $decoded['address']['city']; }
            $reqState = $decoded['address']['state'];
            $reqCountry = $decoded['address']['country'];

            if ( ($city == $reqCity) && ($state == $reqState) && ($country == $reqCountry) )
            {
                if ( $country == "Tunisie" )
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