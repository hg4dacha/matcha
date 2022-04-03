<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// CHECK USERNAME EXISTENCE
function checkUsernameExistence($username)
{
    $dbc = db_connex();
    $reqCheck = $dbc->prepare("SELECT LOWER(username) FROM users WHERE LOWER(username)  = :username");
    try
    {
        $reqCheck->bindValue(':username', $username, PDO::PARAM_STR);
        $reqCheck->execute();
        return $reqCheck->rowCount();
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




// CHECK EMAIL EXISTENCE
function checkEmailExistence($email)
{
    $dbc = db_connex();
    $reqCheck = $dbc->prepare("SELECT email FROM users WHERE email  = :email");
    try
    {
        $reqCheck->bindValue(':email', $email, PDO::PARAM_STR);
        $reqCheck->execute();
        return $reqCheck->rowCount();
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


?>