<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/sendmail.php");


function addUserInDatabase($lastname, $firstname,	$username,	$email,	$passwordUser)
{
    $dbc = db_connex();
    $reqAddUser = $dbc->prepare("INSERT INTO users (lastname, firstname, username, email, passwordUser)
                                 VALUES (:lastname, :firstname, :username, :email, :passwordUser)");
    try
    {
        $reqAddUser->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $reqAddUser->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $reqAddUser->bindValue(':username', $username, PDO::PARAM_STR);
        $reqAddUser->bindValue(':email', $email, PDO::PARAM_STR);
        $reqAddUser->bindValue(':passwordUser', $passwordUser, PDO::PARAM_STR);
        $reqAddUser->execute();
    }
    catch(PDOException $e)
    {
        $error = [
            "error" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        return ($error);
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

        $lastname = $userData->lastname;
        $firstname = $userData->firstname;
        $username = $userData->username;
        $email = $userData->email;
        $password = $userData->password;
        $passwordConfirmation = $userData->passwordConfirmation;

        if ( preg_match("#^[a-zA-Z-]{1,30}$#", $lastname) &&
             preg_match("#^[a-zA-Z-]{1,30}$#", $firstname) &&
             preg_match("#^[a-zA-Z0-9_-]{1,15}$#", $username) &&
             (preg_match("#^.{5,255}$#", $email) && filter_var($email, FILTER_VALIDATE_EMAIL)) &&
             preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,255}$#", $password)
           )
        {
            if ( $password === $passwordConfirmation )
            {
                if ( checkUsernameExistence(strtolower($username)) == 0 &&
                     checkEmailExistence(strtolower($email)) == 0
                   )
                {
                    $lastname = ucfirst(strtolower($lastname));
                    $firstname = ucfirst(strtolower($firstname));
                    $email = strtolower($email);
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    addUserInDatabase($lastname, $firstname, $username,	$email,	$password);
                    $subject = "Matcha - Bienvenue !";
                    sendmail($email, $subject, $username);
                }
            }
        }
        
    }
    
}


?>