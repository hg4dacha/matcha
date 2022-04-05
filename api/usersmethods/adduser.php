<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/sendmail.php");


function addUserInDatabase($lastname, $firstname,	$username,	$email,	$passwordUser, $passkey)
{
    $dbc = db_connex();
    $reqAddUser = $dbc->prepare("INSERT INTO users (lastname, firstname, username, email, passwordUser, passkey)
                                 VALUES (:lastname, :firstname, :username, :email, :passwordUser, :passkey)");
    try
    {
        $reqAddUser->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $reqAddUser->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $reqAddUser->bindValue(':username', $username, PDO::PARAM_STR);
        $reqAddUser->bindValue(':email', $email, PDO::PARAM_STR);
        $reqAddUser->bindValue(':passwordUser', $passwordUser, PDO::PARAM_STR);
        $reqAddUser->bindValue(':passkey', $passkey, PDO::PARAM_STR);
        $reqAddUser->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}

function addUser($userData)
{

    if ( (isset($userData->lastname) && !empty($userData->lastname)) &&
         (isset($userData->firstname) && !empty($userData->firstname)) &&
         (isset($userData->username) && !empty($userData->username)) &&
         (isset($userData->email) && !empty($userData->email)) &&
         (isset($userData->password) && !empty($userData->password)) &&
         (isset($userData->passwordConfirmation) && !empty($userData->passwordConfirmation))
       )
    {

        $lastname = htmlspecialchars($userData->lastname);
        $firstname = htmlspecialchars($userData->firstname);
        $username = htmlspecialchars($userData->username);
        $email = htmlspecialchars($userData->email);
        $password = htmlspecialchars($userData->password);
        $passwordConfirmation = htmlspecialchars($userData->passwordConfirmation);

        if ( preg_match("#^[a-zA-Z-]{1,30}$#", $lastname) &&
             preg_match("#^[a-zA-Z-]{1,30}$#", $firstname) &&
             preg_match("#^[a-zA-Z0-9_-]{1,15}$#", $username) &&
             (preg_match("#^.{5,255}$#", $email) && filter_var($email, FILTER_VALIDATE_EMAIL)) &&
             preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,255}$#", $password)
           )
        {
            if ( $password === $passwordConfirmation )
            {
                if ( checkEmailExistence(strtolower($email)) == 0 )
                {
                    if ( checkUsernameExistence(strtolower($username)) == 0 )
                    {

                        $lastname = ucfirst(strtolower($lastname));
                        $firstname = ucfirst(strtolower($firstname));
                        $email = strtolower($email);
                        $password = password_hash($password, PASSWORD_BCRYPT);
                        $subject = "Matcha - Bienvenue !";
                        $body = "".$username.", plus qu'une étape pour finaliser votre inscription !<br>
                        Cliquez sur le lien ci-dessous pour valider votre compte, vous<br>pourrez ensuite y accéder en vous connectant.";
                        $passkey = random_int(9547114, 735620051642661202).uniqid().random_int(635418, 866261402008688409);
                        $link = "http://localhost:8080/matcha/api/users/?username=".$username."&amp;passkey=".$passkey."";
                        
                        addUserInDatabase($lastname, $firstname, $username,	$email,	$password, $passkey);
                        sendmail($email, $subject, $username, $body, $link);

                    }
                    else
                    {
                        header("HTTP/1.1 500 reserved email");
                    }
                }
                else
                {
                    header("HTTP/1.1 500 reserved username");
                }
            }
            else
            {
                http_response_code(500);
            }
        }
        else
        {
            http_response_code(500);
        }
        
    }
    else
    {
        http_response_code(500);
    }

}


?>