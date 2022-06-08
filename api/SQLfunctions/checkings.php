<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// CHECK ID EXISTENCE
function checkIDExistence($id)
{
    $dbc = db_connex();
    try
    {
        $reqCheck = $dbc->prepare("SELECT id FROM users WHERE id  = :id");
        $reqCheck->bindValue(':id', $id, PDO::PARAM_INT);
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



// CHECK REGISTRATION VALIDATED
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





// CHECK USER CONNECTION STATUE
function connectionStatueCheck($id)
{
    $dbc = db_connex();
    try
    {
        $reqCheck = $dbc->prepare("SELECT connectionStatue FROM users WHERE id  = :id");
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





function checkUserBlocking($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqGet = $dbc->prepare(
            "SELECT id FROM blocked WHERE blocker = :userid AND blocked = :currentUserid"
        );
        $reqGet->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqGet->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}






function checkCurrentUserBlocking($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqGet = $dbc->prepare(
            "SELECT id FROM blocked WHERE blocker = :currentUserid AND blocked = :userid"
        );
        $reqGet->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqGet->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqGet->execute();
        return $reqGet->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}






// CHECK USER LIKE PROFILE
function profileLiked($userid, $profileid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id FROM likes WHERE liker = :userid AND liked = :profileid");
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->bindValue(':profileid', $profileid, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->fetch();
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






// CHECK PROFILE LIKE USER
function currentUserLiked($userid, $profileid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id FROM likes WHERE liked = :userid AND liker = :profileid");
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->bindValue(':profileid', $profileid, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->fetch();
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





// CHECK PROFILE VISITED
function getVisitedProfile($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id, visitDate FROM history WHERE visitor = :currentUserid AND profileVisited = :userid"
        );
        $reqSelect->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->fetch();
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





// CHECK NOTIFICATION DELETION RIGHTS
function checkNotificationDeletionRights($userid, $notificationId)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id FROM notifications WHERE id = :notificationId AND receiverID = :userid"
        );
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->bindValue(':notificationId', $notificationId, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->rowCount();
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





// CHECK HISTORY
function checkHistory($userid, $profileid)
{
    $dbc = db_connex();
    try
    {
        $reqSelect = $dbc->prepare(
            "SELECT id FROM history WHERE visitor = :userid AND profileVisited = :profileid");
        $reqSelect->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqSelect->bindValue(':profileid', $profileid, PDO::PARAM_INT);
        $reqSelect->execute();
        return $reqSelect->rowCount();
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