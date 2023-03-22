<?php

session_start();
if ($_POST['submit'] == true) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        try {
            define("servcheck", true);
            require "../serverinfo.inc.php";
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
                $pwdcheck = password_verify(htmlspecialchars(strip_tags($_POST['password'])), $row['pwd']);
                if ($pwdcheck == true) {
                    $conn->beginTransaction();
                    $username = htmlspecialchars(strip_tags($_POST['username']));
                    $stmt = $conn->prepare("UPDATE `users` SET `username`=:username WHERE `idUsers`=:userid");
                    $stmt->bindParam(':userid', $_SESSION['userid']);
                    $stmt->bindParam(':username', $username);
                    $stmt->execute();
                    $conn->commit();
                    echo 'Success|Success!';
                } else {
                    echo 'Error|Wrong password';
                }
            }
        } catch (PDOException $error) {
            echo 'Error|Server error';
        }
    } else {
        echo "you are not welcome here intruder :)";
    }
} else {
    echo "please exit";
}
