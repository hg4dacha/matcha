<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/sendmail.php");




function getIdAndToken($email)
{
    $dbc = db_connex();
    try {
        $reqGet = $dbc->prepare("SELECT id, token FROM users WHERE email = :email");
        $reqGet->bindValue(':email', $email, PDO::PARAM_STR);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}



function passwordOmission($data)
{
    if ( isset($data->email) && !empty($data->email) )
    {
        $email = htmlspecialchars($data->email);

        if ( preg_match("#^.{5,255}$#", $email) && filter_var($email, FILTER_VALIDATE_EMAIL) )
        {
            if ( checkEmailExistence(strtolower($email)) == 1 )
            {

                $email = strtolower($email);

                $idAndToken = getIdAndToken($email);
                $userid = $idAndToken[0];
                $token = $idAndToken[1];

                $subject = "Matcha - Nouveau mot de passe !";
                $body = "Votre demande de réinitialisation de mot de passe a été prise en compte.<br>
                        Cliquez sur le lien ci-dessous pour définir un nouveau mot de passe.<br>
                        <span
                            style='font-weight:normal;
                                color:#EA2027;'
                        >
                            (Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail)
                        </span>";
                
                $link = "http://localhost:3000/newpassword/".$userid."/".$token."";
                $linktext = ">>>>>RÉINITIALISER MOT DE PASSE<<<<<";

                sendmail($email, $subject, $body, $link, $linktext);

            }
            else
            {
                header("HTTP/1.1 409 invalid email");
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