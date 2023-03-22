<?php
define("navcheck", true);
require "nav.php";

?>
</head>
<title>Forgot password</title>
<body>
    <link rel="stylesheet" href="css/register.css">
    <div class="container">
        <div class="div1">

        </div>
        <div class="div2">
            <div class="formaDiv">
                <form action="includes/reset-request.inc.php" method="POST" style="margin-top:40vh;">
                <div class="donthaveanaccount" style="font-family:valorant;">Forgot password?</div>
                    <?php
                        define("errorcheck",true);
                        define("forgot-password",true);
                        require "includes/errors.php";
                    ?>
                    <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                    <input class="tekst1" type="text" name="email" placeholder="Email">
                    <button class="dugme1" type="submit" name="reset-submit" style="font-size:20px;">Send</button> <br>
                </form>
            </div>
        </div>
    </div>
</body>


<?php
require "footer.php";
?>