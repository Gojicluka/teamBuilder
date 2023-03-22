<?php
session_start();
if (isset($_POST['reset-password-submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        $selector = htmlspecialchars(strip_tags($_POST["selector"]));
        $validator = htmlspecialchars(strip_tags($_POST["validator"]));
        $pwd = htmlspecialchars(strip_tags($_POST['pwd']));
        $passwordRepeat = htmlspecialchars(strip_tags($_POST['pwd-repeat']));

        if (empty($pwd) || empty($passwordRepeat)) {
            header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=fieldsempty");
            exit();
        } else if ($pwd != $passwordRepeat) {
            header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=pwdnotsame");
            exit();
        }

        $currentDate = date("U");

        //sql code posle ovoga
        define("servcheck", true);
        require "serverinfo.inc.php";


        try {

            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "konekcija uspesno uspostavljena";
            $conn->query("use rejhwzqk_teamBuilder");
            $conn->beginTransaction();
            $stmt = $conn->prepare("SELECT * from `pwdReset` WHERE `pwdResetSelector`=:selector AND `pwdResetExpires` >= :expires LIMIT 1");
            $selector = htmlspecialchars(strip_tags($selector));
            $stmt->bindParam(':selector', $selector);
            $stmt->bindParam(':expires', $currentDate);
            //dodaj na ? vidi sta treba
            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $conn->commit();
            $brojac = 0;
            foreach ($stmt->fetchAll() as $k => $row) {
                $brojac++;
                $tokenBin = $validator;
                //$tokenBin = password_hash($validator, PASSWORD_DEFAULT);
                echo "<br>" . $tokenBin . "</br>";
                echo "<br>" . $row["pwdResetToken"] . "</br>";
                $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
                //token check loll
                if ($tokenCheck == true) {
                    $tokenEmail = $row["pwdResetEmail"];
                    $conn->beginTransaction();
                    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `email`=:email AND `type`=:tip");
                    $tip = 'regular';
                    $stmt->bindParam(':email', $tokenEmail);
                    $stmt->bindParam(':tip', $tip);
                    $stmt->execute();
                    $conn->commit();
                    $res2 = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($stmt->fetchAll() as $k2 => $row2) {
                        $conn->beginTransaction();
                        $stmt = $conn->prepare("UPDATE `users` SET `pwd`=:pwd WHERE `email`=:email2 AND `type`=:tip2");
                        $newPwdHash = password_hash($pwd, PASSWORD_DEFAULT);
                        $stmt->bindParam(':pwd', $newPwdHash);
                        $stmt->bindParam(':tip2', $tip);
                        $stmt->bindParam(':email2', $tokenEmail);
                        $stmt->execute();
                        $conn->commit();
                        $conn->beginTransaction();
                        $stmt = $conn->prepare("DELETE FROM `pwdReset` WHERE `pwdResetEmail`=:email3");
                        $stmt->bindParam(':email3', $tokenEmail);
                        $stmt->execute();
                        $conn->commit();
                        header("Location: ../login.php?success=passwordreset");
                        exit();
                    }
                    header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=emailnotpresent");
                    exit();
                } else {
                    header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=badToken");
                    exit();
                }
            }
        } catch (PDOException $error) {
            echo "Greska" . $error->getMessage();
            header("Location: ../create-new-password.php?selector=$selector&validator=$validator&error=sqlError");
            exit();
        }
    } else {
        echo "bad csrf token";
    }
} else {
    header("Location: ../index.php");
}
