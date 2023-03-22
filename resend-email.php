<?php
define("navcheck", true);
require "nav.php";
?>
<title>Resend email</title>
<link rel="stylesheet" href="css/register.css">
<div class="container">
    <div class="div1">

    </div>
    <div class="div2">
        <form action="includes/resend-email.inc.php" method="POST" class="formaDiv" style="margin-top:35vh">
            <div class="donthaveanaccount" style="font-family:valorant;">Your email is not confirmed.</div>
            <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
            <input class="tekst1" type="text" name="mail" placeholder="E-mail">
            <button class="dugme1" type="submit" name="resend-submit">Resend email</button>
        </form>
    </div>
</div>




<?php
require "footer.php";
?>