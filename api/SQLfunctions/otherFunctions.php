<?php


// CHECK DATE FORMAT
function validateDate($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
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
        
            echo($decoded['address']['city_district']);
            echo($decoded['address']['state']);
            echo($decoded['address']['country']);
            if (  )

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