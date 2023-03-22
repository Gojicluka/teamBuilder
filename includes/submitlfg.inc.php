<?php
session_start();

if (isset($_POST['submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        define("servcheck", true);
        require "serverinfo.inc.php";
        try {
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("use rejhwzqk_teamBuilder");
            //timecreated
            $timecreated = date("U");;
            //strip tags
            $activity = htmlspecialchars(strip_tags($_POST['activity']));
            $languages = htmlspecialchars(strip_tags($_POST['languages']));
            $voice = htmlspecialchars(strip_tags($_POST['voice']));
            $riotUsername = htmlspecialchars(strip_tags($_POST['riotUsername']));
            $message  = htmlspecialchars(strip_tags($_POST['message']));
            $roles = htmlspecialchars(strip_tags($_POST['roles']));
            $roles2 = explode('|',$roles);

            foreach($roles2 as $role){
                switch($role){
                    case "Support":break;
                    case "In-game Leader":break;
                    case "Entry Fragger":break;
                    case "Lurker":break;
                    case "Reacon":break;
                    case "Crowd Control";break;
                }
            }
            if(strlen($riotUsername)>20||strlen($message)>100||!isset($riotUsername)||!isset($riotUsername)){
                exit();
            }
            if ($roles == null) {
                $roles = "Support|In-game Leader|Entry Fragger|Lurker|Reacon|Crowd Control";
            }
            /*Porveravanje da li user ima vec postavljen lfg*/
           
            $conn->beginTransaction();
            if (htmlspecialchars(strip_tags($_POST['type'])) == "players") {
                 
                $stmt = $conn->prepare("SELECT `userid` FROM `lfgplayers` WHERE `userid`=:userid");
            }else if (htmlspecialchars(strip_tags($_POST['type'])) == "teams") {
                $stmt = $conn->prepare("SELECT `userid` FROM `lfgpteams` WHERE `userid`=:userid");
            }
            
            $stmt->bindParam(':userid', $_SESSION['userid']);
            $stmt->execute();
            $conn->commit();
            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($stmt->fetchAll() as $k => $row) {
                
                $conn->beginTransaction();
                if (htmlspecialchars(strip_tags($_POST['type'])) == "players") {
                    $stmt = $conn->prepare("DELETE FROM `lfgplayers` WHERE `userid`=:userid");
                }else if (htmlspecialchars(strip_tags($_POST['type'])) == "teams") {
                    $stmt = $conn->prepare("DELETE FROM `lfgteams` WHERE `userid`=:userid");
                }
                $stmt->bindParam(':userid', $_SESSION['userid']);
                $stmt->execute();
                $conn->commit();
            }




            /*----------------------------------------------------------------------------*/ 
            
            //tranzakcija 
            $conn->beginTransaction();
            if (htmlspecialchars(strip_tags($_POST['type'])) == "players") {
                $yourRank = htmlspecialchars(strip_tags($_POST['yourRank']));
                if(!is_numeric($yourRank)){
                    exit();
                }
                $sql = "INSERT INTO `lfgplayers`(`userid`,`activity`,`languages`,`voicechat`,
            `yourrank`,`riotUsername`,`message`,`discordNameAndTag`,`timecreated`,`roles`) 
            VALUES (:userid,:activity,:languages,:voicechat,:yourrank,:riotUsername,:message1,
            :discordNameAndTag,:timecreated,:roles)";
            } else if (htmlspecialchars(strip_tags($_POST['type'])) == "teams") {
                $numberOfPlayers = htmlspecialchars(strip_tags($_POST['numberOfPlayers']));
                $rankFrom = htmlspecialchars(strip_tags($_POST['rankFrom']));
                $rankTo = htmlspecialchars(strip_tags($_POST['rankTo']));
                if(!is_numeric($rankFrom)||!is_numeric($rankTo)){
                    exit();
                }
                if($rankFrom>$rankTo){
                    $pom=$rankFrom;
                    $rankFrom=$rankTo;
                    $rankTo=$pom;
                }
                $sql = "INSERT INTO `lfgteams`(`userid`,`activity`,`numberOfPlayers`,`languages`,`voicechat`
            ,`rankfrom`,`rankto`,`riotUsername`,`message`,`discordNameAndTag`,`timecreated`,`roles`) 
            VALUES (:userid,:activity,:numberOfPlayers,:languages,:voicechat,:rankfrom,:rankto,:riotUsername,:message1,
            :discordNameAndTag,:timecreated,:roles)";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userid', $_SESSION['userid']);
            $stmt->bindParam(':activity', $activity);

            $stmt->bindParam(':languages', $languages);
            $stmt->bindParam(':voicechat', $voice);
            if (htmlspecialchars(strip_tags($_POST['type'])) == "players") {
                $stmt->bindParam(':yourrank', $yourRank);
            } else if (htmlspecialchars(strip_tags($_POST['type'])) == "teams") {
                $stmt->bindParam(':numberOfPlayers', $numberOfPlayers);
                $stmt->bindParam(':rankfrom', $rankFrom);
                $stmt->bindParam(':rankto', $rankTo);
            }
            $stmt->bindParam(':riotUsername', $riotUsername);
            $stmt->bindParam(':message1', $message);
            if (isset($_SESSION['discordtag'])) {
                $discordNameAndTag = $_SESSION['username'] . "#" . $_SESSION['discordtag'];
            } else {
                $discordNameAndTag = null;
            }
            $stmt->bindParam(':discordNameAndTag', $discordNameAndTag);
            $stmt->bindParam(':timecreated', $timecreated);
            $stmt->bindParam(':roles', $roles);

            $stmt->execute();
            $conn->commit();
            echo '<div class="lfgposted" >

                Lfg Posted. 
            </div>';
        } catch (PDOException $error) {
        }
    } else {
        echo "bad csrf code";
    }
} else {
   
}
