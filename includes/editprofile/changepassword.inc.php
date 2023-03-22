<?php
define("servcheck",true);
require "../serverinfo.inc.php";
session_start();
if ($_POST['submit'] == true) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
    if (htmlspecialchars(strip_tags($_POST['newpassword'])) == htmlspecialchars(strip_tags($_POST['newpasswordrepeat']))) {
        try {
            
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("use rejhwzqk_teamBuilder");
            $conn->beginTransaction();
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE `idUsers`=:userid");
            $stmt->bindParam(':userid', $_SESSION['userid']);
            $stmt->execute();
            $conn->commit();
            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($stmt->fetchAll() as $k => $row) {
                
                $pwdcheck = password_verify(htmlspecialchars(strip_tags($_POST['oldpassword'])), $row['pwd']);
                if ($pwdcheck == true) {
                    $pwdhash = password_hash(htmlspecialchars(strip_tags($_POST['newpassword'])), PASSWORD_DEFAULT);
                    $conn->beginTransaction();
                    $stmt = $conn->prepare("UPDATE `users` SET `pwd`=:pwd WHERE `idUsers`=:userid");
                    $stmt->bindParam(':userid', $_SESSION['userid']);
                    $stmt->bindParam(':pwd', $pwdhash);
                    $stmt->execute();
                    $conn->commit();
                    echo "Success|Success!";
                } else {
                    echo 'Error|Wrong password';
                }
            }
            
        } catch (PDOException $error) {
            echo "Error|Server error";
        }
    } else {
        echo 'Error|The old passwords do not match';
    }
}
else
{
    echo "get out";
}
} else {
    echo "please exit";
}
