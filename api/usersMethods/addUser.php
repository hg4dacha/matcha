<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");


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
            "message" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        print_r($error);
    }

}

function addUser($userData)
{
    $lastname = $userData->lastname;
    $firstname = $userData->firstname;
    $username = $userData->username;
    $email = $userData->email;
    $password = $userData->password;
    $passwordConfirmation = $userData->passwordConfirmation;

    addUserInDatabase($lastname, $firstname,	$username,	$email,	$password);
}


?>