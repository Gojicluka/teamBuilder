<?php
/*Promeni kod kada napravis databazu*/

session_start();
//$conn->query("use teambuilder");
if (isset($_POST['login-submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        define("servcheck", true);
        require "serverinfo.inc.php";
        try {
            //uspostavljanje konekcije
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "konekcija uspesno uspostavljena";
            //promenjive
            $greska = "";
            $mailuid = htmlspecialchars(strip_tags($_POST['uid']));
            $pwd = htmlspecialchars(strip_tags($_POST['pwd']));
            //Provera errora
            if (isset($_SESSION['username'])) {
                header("Location: ../login.php?error=alreadyLoggedIn");
                exit();
            } else if (empty($mailuid) || empty($pwd)) {
                header("Location: ../login.php?error=EmptyFields");
                exit();
            } else {
                //provera da li korisnik postoji
                $conn->query("use rejhwzqk_teamBuilder");
                $mailuid = htmlspecialchars(strip_tags($mailuid));
                $pwd = htmlspecialchars(strip_tags($pwd));
                $conn->beginTransaction();
                $stmt = $conn->prepare("SELECT * FROM `users` WHERE (lower(`username`) LIKE lower(:username)) OR (lower(`email`) LIKE lower(:email)) AND `type`=:tip   ");
                $tip = "regular";
                $stmt->bindParam(':username', $mailuid);
                $stmt->bindParam(':email', $mailuid);
                $stmt->bindParam(':tip', $tip);
                $stmt->execute();
                $conn->commit();
                $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $brojac = 0;
                foreach ($stmt->fetchAll() as $k => $row) {
                    $pwdcheck = password_verify($pwd, $row['pwd']);
                    if ($pwdcheck == true) {
                        if ($row['confirmed'] == 'false') {
                            header("Location: ../resend-email.php");
                            exit();
                        } else if ($row['confirmed'] == 'true') {
                            $_SESSION['userid'] = $row['idUsers'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['type'] = $row['type'];
                            $_SESSION['userAvatar']=$row['avatar'];
                            $_SESSION['bio']=$row['bio'];
                            $_SESSION['location']=$row['location'];
                            $_SESSION['discordlinked']=$row['discordLinked'];
                            $_SESSION['avatarpreference']=$row['avatarPreference'];
                            if($_SESSION['discordlinked']=='true')
                            {
                                $_SESSION['discordAvatar']=$row['discordAvatar'];
                                $_SESSION['discordtag']=$row['discordTag'];
                                $_SESSION['discorduserid']=$row['discordUserId'];
                            }
                            //creating login token
                            $token = md5(time() . rand() . $_SESSION['username']);
                            $ipadress = $_SERVER['REMOTE_ADDR'];
                            $useridtoken = $_SESSION['userid'];
                            setcookie("loginToken", $token . "|" . $ipadress . "|" . $useridtoken, time() + (86400 * 30), "/");
                            $conn->beginTransaction();
                            $stmt = $conn->prepare("INSERT INTO `logintokens`(`userid`,`token`,`ipadress`) VALUES(:userid,:token,:ipadress)");
                            $tip = "regular";
                            $stmt->bindParam(':userid', $_SESSION['userid']);
                            $stmt->bindParam(':token', $token);
                            $stmt->bindParam(':ipadress', $ipadress);
                            $stmt->execute();
                            $conn->commit();
                            //exiting
                            header("Location: ../players.php");
                            exit();
                        }
                    } else {
                        header("Location: ../login.php?error=pwdWrong");
                        exit();
                    }
                }
                header("Location: ../login.php?error=badUsername");
                exit();
            }
        } catch (PDOException $error) {
            header("Location: ../login.php?error=databaseconnectionerror");
            exit();
        }
    } else {
        echo "bad csrf token";
    }
} else {
    header("Location: ../login.php");
    exit();
}
