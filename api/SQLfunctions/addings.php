<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");





function addNewLike($liker, $liked)
{
    $dbc = db_connex();
    try
    {
        $reqAddLike = $dbc->prepare(
            "INSERT INTO likes (liker, liked)
             VALUES (:liker, :liked)"
        );
        $reqAddLike->bindValue(':liker', $liker, PDO::PARAM_INT);
        $reqAddLike->bindValue(':liked', $liked, PDO::PARAM_INT);
        $reqAddLike->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}





function addNewNotification($notificationType, $age, $notificationDate, $triggerID, $receiverID)
{
    $dbc = db_connex();
    try
    {
        $reqAddNotif = $dbc->prepare(
            "INSERT INTO notifications (notificationType, age, notificationDate, triggerID, receiverID)
             VALUES (:notificationType, :age, :notificationDate, :triggerID, :receiverID)"
        );
        $reqAddNotif->bindValue(':notificationType', $notificationType, PDO::PARAM_STR);
        $reqAddNotif->bindValue(':age', $age, PDO::PARAM_STR);
        $reqAddNotif->bindValue(':notificationDate', $notificationDate, PDO::PARAM_STR);
        $reqAddNotif->bindValue(':triggerID', $triggerID, PDO::PARAM_INT);
        $reqAddNotif->bindValue(':receiverID', $receiverID, PDO::PARAM_INT);
        $reqAddNotif->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}





function addHistory($visitor, $profileVisited, $visitDate)
{
    $dbc = db_connex();
    try
    {
        $reqAddHistory = $dbc->prepare(
            "INSERT INTO history (visitor, profileVisited, visitDate)
             VALUES (:visitor, :profileVisited, :visitDate)"
        );
        $reqAddHistory->bindValue(':visitor', $visitor, PDO::PARAM_INT);
        $reqAddHistory->bindValue(':profileVisited', $profileVisited, PDO::PARAM_INT);
        $reqAddHistory->bindValue(':visitDate', $visitDate, PDO::PARAM_STR);
        $reqAddHistory->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}





function addBlocked($blocker, $blocked)
{
    $dbc = db_connex();
    try
    {
        $reqAddBlocked = $dbc->prepare(
            "INSERT INTO blocked (blocker, blocked)
             VALUES (:blocker, :blocked)"
        );
        $reqAddBlocked->bindValue(':blocker', $blocker, PDO::PARAM_INT);
        $reqAddBlocked->bindValue(':blocked', $blocked, PDO::PARAM_INT);
        $reqAddBlocked->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}





function addNewMessage($userid, $triggerID,	$receiverID, $messageText, $messageDate)
{
    $dbc = db_connex();
    try
    {
        $reqAddMessage = $dbc->prepare(
            "INSERT INTO messages (userid, triggerID, receiverID, messageText, messageDate)
             VALUES (:userid, :triggerID, :receiverID, :messageText, :messageDate)"
        );
        $reqAddMessage->bindValue(':userid', $userid, PDO::PARAM_INT);
        $reqAddMessage->bindValue(':triggerID', $triggerID, PDO::PARAM_INT);
        $reqAddMessage->bindValue(':receiverID', $receiverID, PDO::PARAM_INT);
        $reqAddMessage->bindValue(':messageText', $messageText, PDO::PARAM_STR);
        $reqAddMessage->bindValue(':messageDate', $messageDate, PDO::PARAM_STR);
        $reqAddMessage->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}



?>