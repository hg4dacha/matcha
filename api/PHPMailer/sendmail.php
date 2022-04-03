<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/lib/PHPMailer/src/Exception.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/lib/PHPMailer/src/PHPMailer.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/lib/PHPMailer/src/SMTP.php");


function sendmail($mailadress, $subject, $username)
{
    $mail = new PHPMailer(true);

    try
    {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'camagru042@gmail.com';
        $mail->Password   = '240urgamac';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->setFrom('ne_pas_repondre@matcha.com', 'Matcha Administrator');
        $mail->addAddress($mailadress);
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'/matcha/api/PHPMailer/logo.png', 'logo');
        $mail->Subject = $subject;
        $mail->Body    = "
        <div>
            <img src='cid:logo' alt='logo'
                style='display:block;
                    margin-left:auto;
                    margin-right:auto;
                    width:25%;'
            >
            <br>
            <br>
            <p
                style='color:#227093;
                       font-weight:400;
                       font-size:17px;
                       border:0;'
            >
                ".$username.", plus qu'une étape pour finaliser votre inscription !
                <br>
                Cliquez sur le lien ci-dessous pour valider votre compte, vous<br>pourrez ensuite y accéder en vous connectant.
                <br>
                <br>
                <a 
                    style='color:#0095f6;
                           font-weight:bold;
                           font-size:16px;'
                    href='http://localhost:8080/camagru/controller/registr_confirm.php?idCTRL=&amp;usn=&amp;keyID='
                >
                    >>>>>VALIDER MON COMPTE<<<<<
                </a>
            </p>
            <br>
            <br>
            <br>
            <br>
            <p
                style='color:#b33939;
                    font-weight:bold;
                    font-size:13px;
                    border:0;'
            >
                _____________________________
                <br>
                © 2022 MATCHA BY HG4DACHA
                <br>
                ********Tous droits réservés********
            </p>
        </div>";
        $mail->send();
        // for more information : https://github.com/PHPMailer/PHPMailer
    }
    catch (Exception $e)
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


?>