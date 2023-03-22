<?php
session_start();


if (isset($_POST['logoutsubmit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        define("servcheck", true);
        require "serverinfo.inc.php";
        try {
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("use rejhwzqk_teamBuilder");
            $conn->beginTransaction();
            $stmt = $conn->prepare("DELETE FROM `logintokens` WHERE `userid`=:userid AND `token`=:token AND `ipadress`=:ipadress");
            if (isset($_COOKIE["loginToken"])) {
                $logtoken = explode("|", $_COOKIE["loginToken"]);
                $token = htmlspecialchars(strip_tags($logtoken[0]));
                $ipadress = htmlspecialchars(strip_tags($logtoken[1]));
                $userid = htmlspecialchars(strip_tags($logtoken[2]));
            }
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':ipadress', $ipadress);
            $stmt->bindParam(':userid', $userid);
            $stmt->execute();
            $conn->commit();
            unset($_COOKIE['loginToken']);
            setcookie('loginToken', null, -1, '/');
            session_unset();
            session_destroy();
        } catch (PDOException $error) {
            echo $error;
        }
    }
    else {
        echo "bad csrf token";
    }
} else {
    header("Location: ../index.php");
}


//
