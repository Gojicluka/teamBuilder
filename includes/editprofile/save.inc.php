<?php
session_start();
if ($_POST['submit']) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {

        $bio =  htmlspecialchars(strip_tags($_POST['bio']));
        $locationUser = htmlspecialchars(strip_tags($_POST['location']));
        $avatar = "";
        $pref = htmlspecialchars(strip_tags($_POST['avatarPreference']));
        define("servcheck", true);
        require "../serverinfo.inc.php";

        try {
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("use rejhwzqk_teamBuilder");

            if (isset($_FILES['file']['name'])) {
                if ($_FILES['file']['name'] != '') {
                    $test = explode(".", $_FILES['file']['name']);
                    $extension = end($test);
                    while (true) {
                        $name = rand(10000, 100000000) . '.' . $extension;
                        $location = '../../upload/' . $name;
                        if (!file_exists($name)) {
                            break;
                        }
                    }
                    $location2 = "upload/$name";

                    $conn->beginTransaction();
                    $userid = $_SESSION['userid'];
                    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `idUsers`=:userid2");
                    $stmt->bindParam(':userid2', $userid);
                    $stmt->execute();
                    $conn->commit();
                    $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $brojac = 0;
                    foreach ($stmt->fetchAll() as $k => $row) {
                        if ($row['avatar'] != "default.jpg") {
                            unlink("../../upload/" . $row['avatar']);
                        }
                        $avatar = $name;
                    }

                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                    //delete file
                }
            } else {
                $avatar = "";
            }

            $conn->beginTransaction();
            
            if ($avatar != "" || $bio != "" || $locationUser != "" || ($pref != "" && $pref == "Discord" || $pref == "Regular")) {
                $check = "";
                if ($avatar != "") {
                    $check .= " avatar=:avatar ";
                    if ($bio != "" || $locationUser != ""||($pref != "" && $pref == "Discord" || $pref == "Regular")) {
                        $check .= ",";
                    }
                    $_SESSION['userAvatar'] = $avatar;
                }
                if ($bio != "") {
                    $check .= " bio=:bio ";
                    if ($locationUser != ""||($pref != "" && $pref == "Discord" || $pref == "Regular")) {
                        $check .= ",";
                    }
                    $_SESSION['bio'] = $bio;
                }
                if ($locationUser != "") {
                    $check .= " location=:loc ";
                    if ($pref != "" && $pref == "Discord" || $pref == "Regular") {
                        $check .= ",";
                    }
                    $_SESSION['location'] = $locationUser;
                }
                if ($pref != "" && $pref == "Discord" || $pref == "Regular") {
                    $check .= " avatarPreference=:pref ";
                    $pref=strtolower($pref);
                    $_SESSION['avatarpreference'] = $pref;
                    
                }
                $stmt = $conn->prepare("UPDATE users SET $check WHERE `idUsers`=:useridxd ");
                if ($avatar != "") {
                    $stmt->bindParam(':avatar', $avatar);
                }
                if ($bio != "") {
                    $stmt->bindParam(':bio', $bio);
                }
                if ($locationUser != "") {
                    $stmt->bindParam(':loc', $locationUser);
                }
                if ($pref != "" && $pref == "discord" || $pref == "regular") {
                    $stmt->bindParam(':pref', $pref);
                }
                $stmt->bindParam(':useridxd', $_SESSION['userid']);
                $stmt->execute();
                $conn->commit();
                echo "Success|Save complete!";
                if($avatar!=""){echo "|".$avatar;}
                


            }else{

            }
        } catch (PDOException $error) {
            echo "Error|Server error.";
        }
    }
} else {
    echo "Error:bad csrf token";
}
