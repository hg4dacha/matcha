<?php



// CHECK DATE FORMAT
function validateDate($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
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



function completeUserData($data)
{

    if ( (isset($data->profilePicture) && !empty($data->profilePicture)) &&
         (isset($data->dateSelected) && !empty($data->dateSelected)) &&
         (isset($data->genderChecked) && !empty($data->genderChecked)) &&
         (isset($data->orientationChecked) && !empty($data->orientationChecked)) &&
         (isset($data->description) && !empty($data->description)) &&
         (isset($data->userTags) && !empty($data->userTags)) &&
         (isset($data->userLocation) && !empty($data->userLocation))
       )
    {
        $profilePicture = $data->profilePicture;

    
        // CHECK DATE
        $dateSelected = htmlspecialchars($data->dateSelected);
        $dateSelectedError = NULL;
        $dateSelected = date(DATE_ATOM, strtotime($dateSelected));
        if (validateDate($dateSelected, DateTime::ATOM))
        {
            $dateSelectedError = FALSE;
        }
        else
        {
            $dateSelectedError = TRUE;
        }


        // CHECK GENDER
        $genderChecked = $data->genderChecked;
        $genderCheckedError = NULL;
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
                    $genderCheckedError = FALSE;
                }
                else
                {
                    $genderCheckedError = TRUE;
                }
            }
            else
            {
                $genderCheckedError = TRUE;
            }
        }
        else
        {
            $genderCheckedError = TRUE;
        }


        // CHECK ORIENTATION
        $orientationChecked = $data->orientationChecked;
        $orientationCheckedError = NULL;
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
                    $orientationCheckedError = FALSE;
                }
                else
                {
                    $orientationCheckedError = TRUE;
                }
            }
            else
            {
                $orientationCheckedError = TRUE;
            }
        }
        else
        {
            $orientationCheckedError = TRUE;
        }


        // CHECK DESCRIPTION
        $description = htmlspecialchars($data->description);
        $descriptionError = NULL;
        if ($description != '' && strlen($description) <= 650)
        {
            $descriptionError = FALSE;
        }
        else
        {
            $descriptionError = TRUE;
        }


        // CHECK USER TAGS
        $userTags = $data->userTags;
        $userTagsError = NULL;
        if ( count($userTags) == 5 )
        {
            $tag1 = htmlspecialchars($userTags[0]);
            $tag2 = htmlspecialchars($userTags[1]);
            $tag3 = htmlspecialchars($userTags[2]);
            $tag4 = htmlspecialchars($userTags[3]);
            $tag5 = htmlspecialchars($userTags[4]);
            if ( in_array($tag1, $tagsData) && in_array($tag2, $tagsData) &&
                 in_array($tag3, $tagsData) && in_array($tag4, $tagsData) &&
                 in_array($tag4, $tagsData)
               )
            {
                $userTagsError = FALSE;
            }
            else
            {
                $userTagsError = TRUE;
            }
        }
        else
        {
            $userTagsError = TRUE;
        }


        // CHECK USER LOCATION
        $userLocation = $data->userLocation;
        $userLocationError = NULL;
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
                
            }
            else
            {
                $userLocationError = TRUE;
            }
        }
        else
        {
            $userLocationError = TRUE;
        }


    }
    else
    {
        http_response_code(400);
    }
}


?>