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
            $picturePath = '/opt/lampp/htdocs/matcha/api/userImages/'.$pictureID.'.jpeg';
            $newPicture = imagecreatefromstring($profilePicture);
            imagejpeg($newPicture, $picturePath);
            imagedestroy($newPicture);
            chmod('/opt/lampp/htdocs/matcha/api/userImages/'.$pictureID.'.jpeg', 0777);
        }
        else
        {
            $picturePath = '/opt/lampp/htdocs/matcha/api/userImages/'.$pictureID.'.png';
            $newPicture = imagecreatefromstring($profilePicture);
            imagepng($newPicture, $picturePath);
            imagedestroy($newPicture);
            chmod('/opt/lampp/htdocs/matcha/api/userImages/'.$pictureID.'.png', 0777);
        }

        insertProfilePicture($userID, $picturePath);
    }
}



?>