<?php
if (isset($_POST['singup-submit'])) {
    if (hash_equals($_SESSION['csrf'], htmlspecialchars(strip_tags($_POST['csrf'])))) {
        $to = htmlspecialchars(strip_tags($_POST['mail']));
        $subject = "Email verification";
        $message = "<a href='localhost/teamBuilder/confirm-email.php?vkey=$vkey'>Register your account!</a>";
        $headers = "From info@balkan.gg" . "\r\n";
        $headers = "Reply-To: info@balkan.gg\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to, $subject, $message, $headers);
    }
}
