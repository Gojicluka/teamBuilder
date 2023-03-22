<?php

//da
session_start();
//$conn->query("use teambuilder");
if (isset($_POST['singup-submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        define("servcheck", true);
        require "serverinfo.inc.php";
        try {
            //uspostavljanje konekcije
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //promenjive
            $greska = "";
            $username = htmlspecialchars(strip_tags($_POST['uid']));
            $email = htmlspecialchars(strip_tags($_POST['mail']));
            $pwd = htmlspecialchars(strip_tags($_POST['pwd']));
            $passwordrepeat = htmlspecialchars(strip_tags($_POST['pwd-repeat']));
            //Provera errora
            if (empty($username) || empty($email) || empty($pwd) || empty($passwordrepeat)) {
                header("Location: ../registracija.php?error=EmptyFields");
                exit();
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                header("Location: ../registracija.php?error=invalidmailoruser");
                exit();
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../registracija.php?error=invailidemail");
                exit();
            } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                header("Location: ../registracija.php?error=invaliduser");
                exit();
            } else if ($pwd !== $passwordrepeat) {
                header("Location: ../registracija.php?error=passworddoesnotmatch");
                exit();
            } else {
                //provera da li korisnik postoji
                $conn->query("use rejhwzqk_teamBuilder");
                $username = htmlspecialchars(strip_tags($username));
                $email = htmlspecialchars(strip_tags($email));
                $pwd = htmlspecialchars(strip_tags($pwd));
                $conn->beginTransaction();
                $stmt = $conn->prepare("SELECT `username` FROM `users` WHERE `username`=:username AND `type`=:tip OR `email`=:email");
                $tip = "regular";
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':tip', $tip);
                $stmt->execute();
                $conn->commit();
                $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $brojac = 0;
                foreach ($stmt->fetchAll() as $k => $row) {
                    $brojac++;
                }
                if ($brojac > 0) {
                    header("Location: ../registration.php?error=nameOrEmailAlreadyExists");
                } else {
                    $conn->beginTransaction();
                    //INSERT INTO users(uidUsers,emailUsers,pwdUsers,tipnaloga) VALUES (?,?,?,?)
                    $stmt = $conn->prepare("INSERT INTO `users`(`username`,`email`,`pwd`,`type`,`vkey`) VALUES (:username,:email2,:pwd,:tip,:vkey)");
                    $tip = 'regular';
                    $vkey = md5(time() . $u);
                    $stmt->bindParam(':username', $username);
                    $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $stmt->bindParam(':email2', $email);
                    $stmt->bindParam(':pwd', $hashedpwd);
                    $stmt->bindParam(':tip', $tip);
                    $stmt->bindParam(':vkey', $vkey);
                    $stmt->execute();
                    $conn->commit();

                    //send verification email
                    $to = $email;
                    $subject = "Email verification";
                    $message = "<a href='https://balkan.gg/lfg/teamBuilder/confirm-email.php?vkey=$vkey'>Register your account!</a>";
                    $headers = "From:noreply@balkan.gg" . "\r\n";
                    $headers = "Reply-To:noreply@balkan.gg\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    mail($to, $subject, $message, $headers);

                    //headers
                    header("Location: ../registration.php?success=true");
                    exit();
                }
            }
        } catch (PDOException $error) {
            header("Location: ../registration.php?error=sqlerror");
            exit();
        }
    } else {
        echo 'bad csrf token';
    }
} else {
    header("Location: ../registration.php");
    exit();
}
