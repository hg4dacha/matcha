<?php




require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/updates.php");




function formattedProfilePicture($profilePicture)
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
        $userID = 63;
        $pictureID = $userID.uniqid();

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

        insertProfilePicture($userID, $picturePath);
    }
}






function formattedPicture($userID, $picture, $pictureNumber)
{
    if ( $picture == FALSE )
    {
        updatePictureNull($userID, $pictureNumber);
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
        $pictureID = $userID.uniqid();

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

        insertUserPictures($userID, $pictureNumber, $picturePath);
    }
}

function userPicturesTraitement($userPictures)
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

        $userID = 63;

        formattedPicture($userID, $secondPicture, "secondPicture");
        formattedPicture($userID, $thirdPicture, "thirdPicture");
        formattedPicture($userID, $fourthPicture, "fourthPicture");
        formattedPicture($userID, $fifthPicture, "fifthPicture");
    }
}



?>