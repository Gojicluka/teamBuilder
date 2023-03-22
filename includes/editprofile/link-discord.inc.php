<?php
session_start();
if (isset($_SESSION['username'])) {
    if (hash_equals($_SESSION['csrf'], @htmlspecialchars(strip_tags($_POST['csrf']))) || hash_equals($_SESSION['csrf'], @$_SESSION['csrf2'])) {
        @$_SESSION['csrf2'] = htmlspecialchars(strip_tags($_POST['csrf']));
        if (isset($_POST['submit']) || isset($_GET['code'])) {

            //discord promenjivew
            $client_id = "730438543763046462";
            $client_secret = "btN82V3_bsiN_cdeAC9aeOccFG6mimI_";
            $redirect_url = "https://balkan.gg/lfg/teamBuilder/includes/editprofile/link-discord.inc.php";
            $scope = "identify";
            $url = "https://discord.com/api/oauth2/authorize?client_id=" . $client_id . "&redirect_uri=http%3A%2F%2Flocalhost%2FteamBuilder%2Fincludes%2Feditprofile%2Flink-discord.inc.php&response_type=code&scope=$scope";
            $url = "https://discord.com/api/oauth2/authorize?client_id=" . $client_id . "&redirect_uri=https%3A%2F%2Fbalkan.gg%2Flfg%2FteamBuilder%2Fincludes%2Feditprofile%2Flink-discord.inc.php&response_type=code&scope=$scope";
            $tokenURL = 'https://discord.com/api/oauth2/token';
            $apiURLBase = 'https://discord.com/api/users/@me';
            if (!isset($_GET["code"])) {
                $_SESSION['state'] = bin2hex(random_bytes(5));
                @$url .= "&state=" . strval($_SESSION['state']);
                header("Location: $url");
            }



            if (isset($_GET["code"])) {
                if ($_SESSION['state'] == $_GET['state']) {
                    $redirect_uri = "https://balkan.gg/lfg/teamBuilder/includes/editprofile/link-discord.inc.php";
                    $token_request = "https://discordapp.com/api/oauth2/token";

                    $token = curl_init();

                    curl_setopt_array($token, array(
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_URL => $token_request,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => array(
                            "grant_type" => "authorization_code",
                            "client_id" => "730438543763046462",
                            "client_secret" => "btN82V3_bsiN_cdeAC9aeOccFG6mimI_",
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
                        $_SESSION['discordusername'] = $user->username;
                        $_SESSION['discordtag'] = $user->discriminator;
                        $_SESSION['discordid'] = $user->id;
                        $_SESSION['discordavatar'] = $user->avatar;
                        $_SESSION['discordlinked'] = "true";

                        sql();

                        header("Location: ../../editprofile.php?success=true");
                    }
                }
            }
        } else {
            echo "no submit :(";
        }
    } else {
        echo "bad csrf token";
    }
} else {
    echo "not logged in";
}

function sql()
{
    define("servcheck", true);
    require "../serverinfo.inc.php";


    try {
        $conn = new PDO("mysql:host=$server;", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->query("use rejhwzqk_teamBuilder");
        $userid = htmlspecialchars(strip_tags($_SESSION['discordid']));
        $conn->beginTransaction();
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `discordUserId`=:userid");
        $tip = "discord";
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $conn->commit();
        $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brojac = 0;
        foreach ($stmt->fetchAll() as $k => $row) {
            $brojac++;
            header("Location: ../../editprofile.php?error=discordAccountSelectedIsAlreadyLinkedToAnotherAccount");
            exit();
        }
        if ($brojac == 0) {
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE `users` SET `discordusername`=:discordusername , `discordAvatar`=:avatar , `discordTag`=:discordtag,`discordUserId`=:discordid,`discordLinked`=:discordlinked WHERE `idUsers`=:idusers");
            $stmt->bindParam(':discordid', $_SESSION['discordid']);
            $stmt->bindParam(':discordtag', $_SESSION['discordtag']);
            $stmt->bindParam(':avatar', $_SESSION['discordavatar']);
            $stmt->bindParam(':idusers', $_SESSION['userid']);
            $stmt->bindParam(':discordusername', $_SESSION['discordusername']);
            $stmt->bindParam(':discordlinked', $_SESSION['discordlinked']);
            $stmt->execute();
            $conn->commit();
        }
    } catch (PDOException $error) {
        echo "Greska" . $error->getMessage();
    }
}
