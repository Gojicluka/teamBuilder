<?php
session_start();
if (isset($_POST['reset-submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        //promenjive za resetovbanje
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $url = "balkan.gg/lfg/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
        $expires = date("U") + 1800;
        $email = $_POST["email"];
        //konektovanje
        define("servcheck", true);
        require "serverinfo.inc.php";


        try {
            $conn = new PDO("mysql:host=$server;", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->query("use rejhwzqk_teamBuilder");
            //brisanje tokena ako postoji
            $conn->beginTransaction();
            $email = htmlspecialchars(strip_tags($email));
            $stmt = $conn->prepare("DELETE FROM `pwdReset` WHERE `pwdResetEmail`=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $conn->commit();
            //insertovanje tokena
            $conn->beginTransaction();
            $hashedToken = password_hash(bin2hex($token), PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO `pwdReset`(`pwdResetEmail`,`pwdResetSelector`,`pwdResetToken`,`pwdResetExpires`) VALUES(:pwdemail,:selector,:token,:expire)");
            $selector = htmlspecialchars(strip_tags($selector));
            $token = bin2hex($token);
            $expires = htmlspecialchars(strip_tags($expires));
            $stmt->bindParam(':pwdemail', $email);
            $stmt->bindParam(':selector', $selector);
            $stmt->bindParam(':token', $hashedToken);
            $stmt->bindParam(':expire', $expires);
            $stmt->execute();
            $conn->commit();

            $to = $email;

            //promeni ime sajta 
            $subject = "Reset your password";

            $message = "<p>We got a request for reseting your password"
                . "Click on the link bellow</p>";
            $message .= '<br><a href="' . $url . '">' . $url . "</a>";

            $headers = "From:<noreply@balkan.gg>\r\n";
            $headers = "Content-type: text/html\r\n";

            mail($to, $subject, $message, $headers);
            echo "vajb";
            header("Location: ../forgot-password.php?success=true");
            exit();
        } catch (PDOException $error) {
            echo "Greska" . $error->getMessage();
            header("Location: ../forgot-password.php?error=sqlerror");
        }
    } else {
        echo "bad csrf token";
    }
} else {
    header("Location: ../index.php");
}
