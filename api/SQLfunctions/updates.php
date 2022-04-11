<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");



// UPDATE CONNECTION
function updateUserConnection($connectionStatue, $lastConnection, $userID)
{
    $dbc = db_connex();
    try
    {
        $reqUpdate = $dbc->prepare("UPDATE users SET connectionStatue = :connectionStatue, lastConnection = :lastConnection WHERE id = :userID");
        $reqUpdate->bindValue(':connectionStatue', $connectionStatue, PDO::PARAM_BOOL);
        $reqUpdate->bindValue(':lastConnection', $lastConnection, PDO::PARAM_STR);
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_INT);
        $reqUpdate->execute();
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