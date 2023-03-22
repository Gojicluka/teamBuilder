<?php
session_start();
if (!isset($_SESSION['username'])) {
    if (hash_equals($_SESSION['csrf'], @htmlspecialchars(strip_tags($_POST['csrf']))) || hash_equals($_SESSION['csrf'], @$_SESSION['csrf2'])) {
        @$_SESSION['csrf2'] = htmlspecialchars(strip_tags($_POST['csrf']));
        if (isset($_POST['submit']) || isset($_GET['code'])) {

            $client_id = "";
            $client_secret = "";
            $redirect_url = "https://balkan.gg/lfg/includes/discord-login.inc.php";
            $scope = "identify%20email";
            $url = "https://discord.com/api/oauth2/authorize?client_id=" . $client_id . "&redirect_uri=https%3A%2F%2Fbalkan.gg%2Flfg%2Fincludes%2Fdiscord-login.inc.php&response_type=code&scope=$scope";
            $tokenURL = 'https://discord.com/api/oauth2/token';
            $apiURLBase = 'https://discord.com/api/users/@me';

            if (!isset($_GET["code"])) {
                $_SESSION['state'] = bin2hex(random_bytes(5));
                @$url .= "&state=" . strval($_SESSION['state']);
                header("Location: $url");
            }



            if (isset($_GET["code"])) {
                if ($_SESSION['state'] == $_GET['state']) {
                    $redirect_uri = "https://balkan.gg/lfg/includes/discord-login.inc.php";
                    $token_request = "https://discordapp.com/api/oauth2/token";

                    $token = curl_init();

                    curl_setopt_array($token, array(
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_URL => $token_request,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => array(
                            "grant_type" => "authorization_code",
                            "client_id" => "",
                            "client_secret" => "",
                            "redirect_uri" => $redirect_uri,
                            "code" => $_GET["code"]
                        )
                    ));
                    curl_setopt($token, CURLOPT_RETURNTRANSFER, true);

                    $resp = json_decode(curl_exec($token));
                    var_dump($resp);
                    curl_close($token);

                    if (isset($resp->access_token)) {
                        $access_token = $resp->access_token;

                        $info_request = "https://discordapp.com/api/users/@me";

                        $info = curl_init();
                        curl_setopt_array($info, array(
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_URL => $info_request,
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Bearer {$access_token}"
                            ),
                            CURLOPT_RETURNTRANSFER => true
                        ));

                        $user = json_decode(curl_exec($info));
                        curl_close($info);
                        $_SESSION['username'] = $user->username;
                        $_SESSION['discordusername']=$user->username;
                        $_SESSION['discordtag'] = $user->discriminator;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['discorduserid'] = $user->id;
                        $_SESSION['discordAvatar'] = $user->avatar;
                        $_SESSION['type'] = "discord";

                        sql();
                        header("Location: ../index.php?success=true");
                        exit();
                    }
                }
            }
        } else {
            echo "You are not meant to be here :)";
            header("Location: ../index.php");
        }
    } else {
        echo "Bad csrf token";
    }
} else {
    header("Location: ../login.php?error=alreadyLoggedIn");
}




//sql code for registering discord users
function sql()
{
    define("servcheck", true);
    require "serverinfo.inc.php";
    //$conn->query("use teambuilder");

    try {
        $conn = new PDO("mysql:host=$server;", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "konekcija uspesno uspostavljena";
        $conn->query("use rejhwzqk_teamBuilder");
        //select code ------------------------------
        $userid = htmlspecialchars(strip_tags($_SESSION['discorduserid']));
        $conn->beginTransaction();
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `discordUserId`=:userid AND (`type`=:tip OR `discordLinked`=:discordlinked)");
        $tip = "discord";
        $disLinked = "true";
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':tip', $tip);
        $stmt->bindParam(':discordlinked', $disLinked);
        $stmt->execute();
        $conn->commit();
        $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brojac = 0;
        foreach ($stmt->fetchAll() as $k => $row) {
            $brojac++;
            $_SESSION['userid'] = $row['idUsers'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['userAvatar'] = $row['avatar'];
            $_SESSION['bio'] = $row['bio'];
            $_SESSION['location'] = $row['location'];
            $_SESSION['discordlinked'] = $row['discordLinked'];
            $_SESSION['avatarpreference'] = $row['avatarPreference'];
            if ($row['discordAvatar'] != $_SESSION['discordAvatar'] || $row['email'] != $_SESSION['email'] || $row['discordTag'] != $_SESSION['discordtag'] || $row['username'] != $_SESSION['username']) {
                $conn->beginTransaction();
                $stmt = $conn->prepare("UPDATE `users` SET `username`=:username , `discordAvatar`=:avatar , `discordTag`=:discordtag,`email`=:email,`discordUsername`=:discordusername  WHERE `idUsers`=:idusers");
                $stmt->bindParam(':username', $_SESSION['username']);
                $stmt->bindParam(':email', $_SESSION['email']);
                $stmt->bindParam(':discordtag', $_SESSION['discordtag']);
                $stmt->bindParam(':avatar', $_SESSION['discordAvatar']);
                $stmt->bindParam(':idusers', $_SESSION['userid']);
                $stmt->bindParam(':discordusername', $_SESSION['discordusername']);
                $stmt->execute();
                $conn->commit();
            }
        }
        if ($brojac == 0) {
            $conn->beginTransaction();
            $avatar = htmlspecialchars(strip_tags($_SESSION['discordAvatar']));
            $tag = htmlspecialchars(strip_tags($_SESSION['discordtag']));
            $email = htmlspecialchars(strip_tags($_SESSION['email']));
            $username = htmlspecialchars(strip_tags($_SESSION['username']));
            $stmt = $conn->prepare("INSERT INTO `users`(`username`,`email`,`discordAvatar`,`discordUserId`,`discordTag`,`type`,`confirmed`,`avatarPreference`,`discordUsername`) VALUES (:username,:email,:avatar,:userid2,:tag,:tip,:confirmed,:avatarpreference,:discordusername)");
            $tip = "discord";
            $confirmed = 'true';
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':avatar', $avatar);
            $stmt->bindParam(':tag', $tag);
            $stmt->bindParam(':userid2', $userid);
            $stmt->bindParam(':tip', $tip);
            $stmt->bindParam(':confirmed', $confirmed);
            $stmt->bindParam(':discordusername', $username);
            $avatarpref = "discord";
            $stmt->bindParam(':avatarpreference', $avatarpref);
            $stmt->execute();
            $conn->commit();
            //logovanje nakon registrovanja
            $conn->beginTransaction();
            $stmt = $conn->prepare("SELECT * FROM `users` WHERE `discordUserId`=:userid AND `type`=:tip");
            $tip = "discord";
            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':tip', $tip);
            $stmt->execute();
            $conn->commit();
            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $brojac = 0;
            foreach ($stmt->fetchAll() as $k => $row) {
                $_SESSION['userid'] = $row['idUsers'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['type'] = $row['type'];
                $_SESSION['userAvatar'] = $row['avatar'];
                $_SESSION['bio'] = $row['bio'];
                $_SESSION['location'] = $row['location'];
                $_SESSION['discordlinked'] = $row['discordLinked'];
                $_SESSION['avatarpreference'] = $row['avatarPreference'];
            }
        }
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
    } catch (PDOException $error) {
        echo "Greska" . $error->getMessage();
    }
}
