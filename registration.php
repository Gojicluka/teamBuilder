<?php
define("navcheck", true);
require "nav.php";
?>
<link rel="stylesheet" href="css/register.css">

<title>Register</title>

<div class="container">
    <div class="div1 registration">

    </div>
    <div clas="div2">
        <div class="formaDiv">
            <form action="includes/singup.inc.php" method="POST">
                <div class="register regPage">Register</div>
                <?php
                define("errorcheck", true);
                define("registration", true);
                require "includes/errors.php";
                ?>
                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                <input class="tekst1" type="text" name="uid" placeholder="Username">
                <input class="tekst1" type="text" name="mail" placeholder="E-mail">
                <input class="tekst1" type="password" name="pwd" placeholder="Password">
                <input class="tekst1" type="password" name="pwd-repeat" placeholder="Repeat Password">

                <button class="dugme1" type="submit" name="singup-submit">Register!</button>
            </form>
            <form action="includes/discord-login.inc.php" method="POST">
                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                <button class="dugme1 discordDugme" type="submit" name="submit">
                    <img src="images/discordlogo.png" class="discordlogo" />Discord login
                </button>
            </form>
        </div>
    </div>

</div>



<?php
require "footer.php";
?>