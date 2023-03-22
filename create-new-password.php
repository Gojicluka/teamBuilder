<?php
define("navcheck", true);
require "nav.php";

?>
<link rel="stylesheet" href="css/register.css">
<title>Create new password</title>
<html>
<div class="container">
    <div class="div1"></div>
    <div class="div2">
        <div class="formaDiv">

            <?php
            $selector = @$_GET['selector'];
            $validator = @$_GET['validator'];

            if (empty($selector) || empty($validator)) {
                echo "<div class='donthaveanaccount'>Validation failed</div>";
            } else if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
            ?>
                <form action="includes/reset-password.inc.php" method="POST">
                    <div class="donthaveanaccount" style="font-family:valorant;">Reset password</div>
                    <?php
                    define("errorcheck", true);
                    define("create-new-password", true);
                    require "includes/errors.php";
                    ?>
                    <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                    <input type="hidden" name="selector" value="<?php echo $selector ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator ?>">
                    <input type="password" class="tekst1" name="pwd" placeholder="Enter new password">
                    <input type="password" class="tekst1" name="pwd-repeat" placeholder="Repeat password">
                    <button type="submit" class="dugme1" name="reset-password-submit" style='font-size:25px;'>Reset password</button>
                </form>
            <?php
            }
            ?>
        </div>

    </div>
</div>

</html>

<?php
require "footer.php";
?>