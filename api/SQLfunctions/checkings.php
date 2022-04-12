<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// CHECK USERNAME EXISTENCE
function checkUsernameExistence($username)
{
    $dbc = db_connex();
    try
    {
        $reqCheck = $dbc->prepare("SELECT LOWER(username) FROM users WHERE LOWER(username)  = :username");
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
    try
    {
        $reqCheck = $dbc->prepare("SELECT email FROM users WHERE email  = :email");
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



// CHECK COMPLETED PROFILE
function registrationValidatedCheck($id)
{
    $dbc = db_connex();
    try
    {
        $reqCheck = $dbc->prepare("SELECT registrationValidated FROM users WHERE id  = :id");
        $reqCheck->bindValue(':id', $id, PDO::PARAM_INT);
        $reqCheck->execute();
        return $reqCheck->fetch();
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




// CHECK COMPLETED PROFILE
function completedProfileCheck($id)
{
    $dbc = db_connex();
    try
    {
        $reqCheck = $dbc->prepare("SELECT profileCompleted FROM users WHERE id  = :id");
        $reqCheck->bindValue(':id', $id, PDO::PARAM_INT);
        $reqCheck->execute();
        return $reqCheck->fetch();
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