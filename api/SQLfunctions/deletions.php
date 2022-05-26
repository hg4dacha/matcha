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



?>