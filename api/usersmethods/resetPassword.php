<?php


require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/configuration/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/SQLfunctions/checkings.php");
require_once($_SERVER['DOCUMENT_ROOT']."/matcha/api/PHPMailer/sendmail.php");




function getTokenByID($id)
{
    $dbc = db_connex();
    try {
        $reqCtrl = $dbc->prepare("SELECT token FROM users WHERE id = :id");
        $reqCtrl->bindValue(':id', $id, PDO::PARAM_STR);
        $reqCtrl->execute();
        return $reqCtrl->fetch();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}

function changePassword($userID, $newPassword)
{
    $dbc = db_connex();
    try {
        $reqUpdate = $dbc->prepare("UPDATE users SET passwordUSer = :newPassword WHERE id = :userID");
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_STR);
        $reqUpdate->bindValue(':newPassword', $newPassword, PDO::PARAM_STR);
        $reqUpdate->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}

function updateToken($userID, $token)
{
    $dbc = db_connex();
    try {
        $reqUpdate = $dbc->prepare("UPDATE users SET token = :token WHERE id = :userID");
        $reqUpdate->bindValue(':userID', $userID, PDO::PARAM_STR);
        $reqUpdate->bindValue(':token', $token, PDO::PARAM_STR);
        $reqUpdate->execute();
    }
    catch(PDOException $e)
    {
        header("HTTP/1.1 500 database");
    }
}



function resetPassword($data)
{
    if ( (isset($data->userID) && !empty($data->userID)) &&
         (isset($data->token) && !empty($data->token)) &&
         (isset($data->newPassword) && !empty($data->newPassword)) &&
         (isset($data->newPasswordConfirm) && !empty($data->newPasswordConfirm))
       )
    {

        $userID = htmlspecialchars($data->userID);
        $token = htmlspecialchars($data->token);
        $newPassword = htmlspecialchars($data->newPassword);
        $newPasswordConfirm = htmlspecialchars($data->newPasswordConfirm);

        if ( is_numeric($userID) )
        {
            $tokenFromdatabse = getTokenByID($userID);

            if ( $tokenFromdatabse[0] == $token)
            {
                if ( $newPassword == $newPasswordConfirm )
                {

                    $password = password_hash($newPassword, PASSWORD_BCRYPT);
                    $newToken = random_int(9547114, 735620051642661202).uniqid().random_int(635418, 866261402008688409);

                    changePassword($userID, $password);
                    updateToken($userID, $newToken);

                }
                else
                {
                    header("HTTP/1.1 409 error password");
                }
            }
            else
            {
                http_response_code(400);
            }
        }
        else
        {
            http_response_code(400);
        }
    }
}


?>