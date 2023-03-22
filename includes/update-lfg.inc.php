<?php
session_start();



$nizJezika = array();
//statement making
$where = "WHERE";
$brojacWhere = 0;
$activity = htmlspecialchars(strip_tags($_POST['filterActivity']));
if ($activity != "any") {
    $where .= " (`activity`='$activity' OR `activity`='Any')";
    $brojacWhere++;
}

$voicechat = htmlspecialchars(strip_tags($_POST['filterVoiceChat']));
if ($voicechat != "any") {
    if ($brojacWhere > 0) {
        $where .= " AND";
    }
    $where .= "`voicechat`='$voicechat' ";
    $brojacWhere++;
}

//jezici filter
if (htmlspecialchars(strip_tags($_POST['filterLanguage'])) == "all") {
    $where .= "";
} else {
    //mora ovako ne moze switchom
    if ($brojacWhere > 0) {
        $where .= " AND";
    }
    $brojacWhere++;
    $where .= " (";
    $jeziciniz = explode('|', htmlspecialchars(strip_tags($_POST['filterLanguage'])));
    for ($i = 0; $i < count($jeziciniz) - 1; $i++) {
        $jeziciniz[$i] = htmlspecialchars(strip_tags($jeziciniz[$i]));
        if (strpos(htmlspecialchars(strip_tags(($_POST['filterLanguage']))), $jeziciniz[$i]) != null || strpos(htmlspecialchars(strip_tags($_POST['filterLanguage'])), $jeziciniz[$i]) === 0) {
            $where .= " INSTR(languages,'$jeziciniz[$i]') > 0 ";
            if (((count($jeziciniz) - 1) - $i) != 1) {
                $where .= " OR ";
            }
        }
    }
    $where .= ")";
}
//ROLES
if (htmlspecialchars(strip_tags($_POST['filterRoles'])) != null) {
    if ($brojacWhere > 0) {
        $where .= " AND";
    }
    $brojacWhere++;
    $where .= "(";
    $rolesniz = explode('|', htmlspecialchars(strip_tags($_POST['filterRoles'])));
    for ($i = 0; $i < count($rolesniz) - 1; $i++) {
        $rolesniz[$i] = htmlspecialchars(strip_tags($rolesniz[$i]));
        if (strpos(htmlspecialchars(strip_tags($_POST['filterRoles'])), $rolesniz[$i]) != null || strpos(htmlspecialchars(strip_tags($_POST['filterRoles'])), $rolesniz[$i]) === 0) {
            $where .= " INSTR(roles,'$rolesniz[$i]') > 0 ";
            if (((count($rolesniz) - 1) - $i) != 1) {
                $where .= " OR ";
            }
        }
    }
    $where .= ")";
}

//roles


if (htmlspecialchars(strip_tags($_POST['type'])) == "teams") {
    if (htmlspecialchars(strip_tags($_POST['filterYourRank']) != "any")) {
        if ($brojacWhere > 0) {
            $where .= " AND";
        }
        $brojacWhere++;
        $yourrank = htmlspecialchars(strip_tags($_POST['filterYourRank']));
        $where .= " (`rankfrom`<=$yourrank AND `rankto`>=$yourrank )";
    }
} else if (htmlspecialchars(strip_tags($_POST['type'])) == "players") {
    if ($brojacWhere > 0) {
        $where .= " AND";
    }
    $brojacWhere++;
    $from = htmlspecialchars(strip_tags($_POST['filterRankFrom']));
    $to = htmlspecialchars(strip_tags($_POST['filterRankTo']));

    $where .= " `yourrank`>=$from AND `yourrank`<=$to ";
}



if (isset($_POST['submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        define("servcheck", true);
        require "serverinfo.inc.php";
        try {
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("use rejhwzqk_teamBuilder");
            //dude
            $type =htmlspecialchars(strip_tags($_POST['type']));
            //tranzakcija 
            if (htmlspecialchars(strip_tags($_POST['type'])) == "players") {
                $table = "`lfgplayers`";
            } else if (htmlspecialchars(strip_tags($_POST['type'])) == "teams") {
                $table = "`lfgteams`";
            }
            $stejtment = ("SELECT * FROM $table $where");
            $conn->beginTransaction();
            $stmt = $conn->prepare($stejtment);

            //$stmt->bindParam(':molim',$molim);
            $stmt->execute();
            $conn->commit();
            $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach (array_reverse($stmt->fetchAll()) as $k => $row) {
                $avatar = "";
                $discord = "/";
                $conn->beginTransaction();
                $stmt = $conn->prepare("SELECT * FROM users WHERE idUsers=:id");
                $stmt->bindParam(':id', $row['userId']);
                $stmt->execute();
                $conn->commit();
                $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                foreach ($stmt->fetchAll() as $k2 => $row2) {
                    if ($row2['avatarPreference'] == "regular") {
                        $avatar = "upload/" . $row2['avatar'];
                    } else if ($row2['avatarPreference'] == "discord") {
                        $avatar = 'https://cdn.discordapp.com/avatars/' . $row2['discordUserId'] . '/' . $row2['discordAvatar'];
                    }
                    if (isset($row2['discordUserId'])) {
                        $discord = $row2['username'] . '#' . $row2['discordTag'];
                    }
                }
                echo '
                <div class="lfgChild">
                        <div class="lfgTittle">' . $row['message'] . '</div>
                        <div class="lfgContainer">
                            <div class="lfgAvatar">
                                <!-- man plz fix -->
                                <img src="';
                echo $avatar;
                echo '" class="lfgAvatarImg" alt=""> ';
                if($type=="teams"){    
                    echo'<div class="Formular-tekst lfg-box playersneededtxt"style="text-align:center">Players needed:  ' . $row['numberOfPlayers'] . '</div>';
                }
                echo '
                            </div>';

                if($type=="teams"){
                            echo '<div class="lfgContainer2">
                            <div>
                                    <div class="Formular-tekst">Rank from:</div>
                                    <div class=';
                echo "'lfg-box ";
                echo ranksFunction($row['rankfrom']);

                echo '</div> </div>
                <div>
                <div class="Formular-tekst">Rank to:</div>
                <div class=';
                echo "'lfg-box ";
                echo ranksFunction($row['rankto']);;

                echo '</div> ';
            }else if($type=="players"){

                echo '<div class="lfgContainer2">
                <div class="lfgPlayersRank">
                        <div class="Formular-tekst">Rank:</div>
                        <div class=';
                        echo "'lfg-box ";
                        echo ranksFunction($row['yourrank']);
                         echo '</div>';
                }
                                echo '</div>
                                <div>
                                    <div class="Formular-tekst">Type:</div>
                                    <div class="lfg-box">' . $row['activity'] . '</div>
                                </div>
                                <div>
                                    <div class="Formular-tekst">Voice:</div>
                                    ';

                if ($row['voicechat'] == "true") {
                    echo '<div class="lfg-box miclfgGreen">Required';
                } else {
                    echo '<div class="lfg-box miclfgRed">Not required';
                }
                echo '</div>
                                </div>
                                
                                <div class="lfgJezici">
                                    <div class="Formular-tekst">Languages:</div>
                                    <div class="lfg-box">';
                if ($row['languages'] == "all") {
                    echo "All";
                } else {
                    echo jezikFunkcija($row['languages']);
                }
                echo '</div>
                                </div>
                                <div>
                                    <div class="Formular-tekst">Riot username:</div>
                                    <div class="lfg-box riotUsername" >' . $row['riotUsername'] . '</div>
                                </div>

                                <div>
                                    <div class="Formular-tekst">Discord:</div>
                                    <div class="lfg-box">';
                echo $discord;
                echo '</div>
                                </div>
                                <div class="playersneededgrid">
                                <div class="Formular-tekst">Players needed:</div>
                                <div class="lfg-box">' . $row['numberOfPlayers'] . '</div>
                                </div>
                                <div class="lfgRoles" >
                                    <div class="Formular-tekst">Roles needed:</div>
                                    <div class="lfg-box lfgrolesbox">';
                echo rolesFunkcija($row['roles']);
                echo '</div>
                                </div>';
                /*
                                echo'
                                <div class="playersneededgrid">
                                <div class="Formular-tekst">Players:</div>
                                <div class="lfg-box">'.$row['numberOfPlayers'].'</div>
                                </div>*/
                echo '
                            </div>
                        </div>
                    </div>
                
                ';
            }
        } catch (PDOException $error) {
            echo $where;
            echo "error";
        }
    } else {
        echo "bad csrf code";
    }
} else {
    echo ":( you are not supposed to be here :(";
}
function ranksFunction($input)
{
    switch ($input) {
        case "1":
            $output = "rankColorIron'><img src='images/teamsPlayers/Iron.png' class='flag'/>Iron";
            break;
        case "2":
            $output = "rankColorBronze'><img src='images/teamsPlayers/Bronze.png' class='flag'/>Bronze";
            break;
        case "3":
            $output = "rankColorSilver'><img src='images/teamsPlayers/Silver.png' class='flag'/>Silver";
            break;
        case "4":
            $output = "rankColorGold'><img src='images/teamsPlayers/Gold.png' class='flag'/>Gold";
            break;
        case "5":
            $output = "rankColorPlatinum'><img src='images/teamsPlayers/Platinum.png' class='flag'/>Platinum";
            break;
        case "6":
            $output = "rankColorDiamond'><img src='images/teamsPlayers/Diamond.png' class='flag'/>Diamond";
            break;
        case "7":
            $output = "rankColorImmortal'><img src='images/teamsPlayers/Immortal.png' class='flag'/>Immortal";
            break;
        case "8":
            $output = "rankColorRadiant'><img src='images/teamsPlayers/Radiant.png' class='flag'/>Radiant";
            break;
    }
    return $output;
}
function jezikFunkcija($input)
{
    $niz = explode("|", $input);
    $output = "";
    foreach ($niz as $xd) {

        switch ($xd) {
            case "SRB/BIH/HRV/MNE":
                $output .= '<img src="images/flags/serbia.png" class="flag" /><img src="images/flags/croatia.png" class="flag" /><img src="images/flags/bosnia.svg" class="flag" /><img src="images/flags/mne.svg" class="flag" />';
                break;
            case "ENG":
                $output .= '<img src="images/flags/eng.png" class="flag" />';
                break;
            case "SVN":
                $output .= '<img src="images/flags/svn.png" class="flag" />';
                break;
            case "ALB":
                $output .= '<img src="images/flags/alb.png" class="flag" />';
                break;
            case "BGR":
                $output .= '<img src="images/flags/bgr.png" class="flag" />';
                break;
            case "GRE":
                $output .= '<img src="images/flags/gre.svg" class="flag" />';
                break;
            case "ROM":
                $output .= '<img src="images/flags/rom.png" class="flag" />';
                break;
            case "MKD":
                $output .= '<img src="images/flags/mkd.png" class="flag" />';
                break;
        }
    }
    return $output;
}
function rolesFunkcija($input)
{
    $niz = explode('|', $input);
    $output =  "";
    $brojac = 0;
    foreach ($niz as $xd) {
        $output .= $xd;
        $brojac++;
        if (($brojac) != count($niz)) {
            $output .= ", ";
        }
    }
    return $output;
}
