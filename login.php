<?php
define("navcheck", true);
require "nav.php";
?>
<link rel="stylesheet" href="css/register.css">
<title>Login</title>

<div class="container">
    <div class="div1">

    </div>
    <div clas="div2">
        <div class="formaDiv loginWidth">
            <div class="register">Login</div>
            <?php
                define("errorcheck",true);
                define("login",true);
                require "includes/errors.php";
            ?>
            <form action="includes/login.inc.php" method="POST">
                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                <input class="tekst1" type="text" name="uid" placeholder="Username/Email">
                <input class="tekst1" type="password" name="pwd" placeholder="Password">
                <a href="forgot-password.php" class="forgotPassword">Forgot password?</a>
                <button class="dugme1" type="submit" name="login-submit">Log in</button>
            </form>
            <form action="includes/discord-login.inc.php" method="POST">
                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                <button class="dugme1 discordDugme" type="submit" name="submit">
                    <img src="images/discordlogo.png" class="discordlogo" />Discord login
                </button>
            </form>
            <div class="donthaveanaccount">Don't have an account?</div>
            <!--<button class="dugme1" onclick='window.open("registration.php","_self");' name="login-submit">Register</button>-->
            <div class="donthaveanaccount"><a href="registration.php"  class="registerA">Click here!</a></div>
           

        </div>
    </div>

</div>



<?php
require "footer.php";
?>