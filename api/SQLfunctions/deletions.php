<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");


// DELETE USER
function deleteUser($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare("DELETE FROM users WHERE id = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE USER PICTURES
function deleteUserPictures($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare("DELETE FROM pictures WHERE userid = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE ACCOUNT MESSAGES
function deleteAccountMessages($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM messages WHERE triggerID = :userid OR receiverID = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE ACCOUNT LIKES
function deleteAccountLikes($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM likes WHERE liker = :userid OR liked = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE ACCOUNT BLOCKED
function deleteAccountBlocked($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM blocked WHERE blocker = :userid OR blocked = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE ACCOUNT NOTIFICATIONS
function deleteAccountNotifications($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM notifications WHERE triggerID = :userid OR receiverID = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE ACCOUNT HISTORY
function deleteAccountHistory($userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM history WHERE visitor = :userid OR profileVisited = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE LIKE
function deleteExistingLike($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare("DELETE FROM likes WHERE liker = :currentUserid AND liked = :userid");
        $reqDelete->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE BLOCKED
function deleteBlocked($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare("DELETE FROM blocked WHERE blocker = :currentUserid AND blocked = :userid");
        $reqDelete->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE MESSAGES
function deleteAllUserMessages($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM messages WHERE userid = :currentUserid AND
            ((triggerID = :currentUserid AND receiverID = :userid) OR (triggerID = :userid AND receiverID = :currentUserid))");
        $reqDelete->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE NOTIFICATION
function deleteUserNotification($userid, $notificationId)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM notifications WHERE id = :notificationId AND receiverID = :userid");
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->bindValue(':notificationId', $notificationId, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE HISTORY
function deleteHistory($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM history WHERE visitor = :currentUserid AND profileVisited = :userid");
        $reqDelete->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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





// DELETE FAVORITE
function deleteUserFavorite($currentUserid, $userid)
{
    $dbc = db_connex();
    try
    {
        $reqDelete = $dbc->prepare(
            "DELETE FROM likes WHERE liker = :currentUserid AND liked = :userid");
        $reqDelete->bindValue(':currentUserid', $currentUserid, PDO::PARAM_INT);
        $reqDelete->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqDelete->execute();
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