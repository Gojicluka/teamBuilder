<?php
if (!defined('navcheck')) {
    exit('use the site like a normal human being :)');
}
session_start();
define("logincheck", true);
require "includes/checkLogin.inc.php";
$key = bin2hex(random_bytes(32));
$csrf = hash_hmac("sha256", 'random string bura http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '', $key);
$_SESSION['csrf'] = $csrf;

?>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<head>
<meta charset="utf-8">
    <meta property="og:image" content="images/logo.png" />
    <meta property="og:url" content="Balkan.gg/lfg" />
    <meta property="og:title" content="Balkan.gg/lfg"/>
    <meta property="og:description" content="Balkan.gg/lfg" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/mobile/mobNav.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">

    
</head>

<body onresize="funkcijaZaSliku();">
    <header id="header">
        <img class="logo logoMain" src="images/logo.png" alt="">
        <img class="logo burger-icon" src="images/burger-icon.png" style="grid-area:n1;" alt="">
        <nav class="nav mobile-show">
            <ul class="nav_links" style="grid-area:n2;">
                <div style="opacity:0;" class="xxxx">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</div>
                <li class="liNav "><a class="aNav navPrvi navHoverRed" href="players.php">Find players</a></li>
                <hr class="navHr">
                <li class="liNav"><a class="aNav navHoverRed" href="teams.php">Find teams</a></li>
                <hr class="navHr">
                <!--<li class="liNav"><a class="aNav navTreci navHoverRed" href="#">About us</a></li> <hr class="navHr">-->

            </ul>
        </nav>
        <?php if (isset($_SESSION['userid'])) { ?>
            <div class="dropdown cta" style="grid-area:n3;">
                <?php if ($_SESSION['avatarpreference'] == "regular") {
                    echo '<img src="upload/' . $_SESSION['userAvatar'] . '" alt="" class="avatar" id="navavatar">';
                } else if ($_SESSION['avatarpreference'] == "discord") {
                    echo '<img src="https://cdn.discordapp.com/avatars/' . $_SESSION['discorduserid'] . '/' . $_SESSION['discordAvatar'] . '" alt="" class="avatar" id="navavatar">';
                }

                ?>

                <div class="dropdown-content">

                    <a href="editprofile.php">Edit profile</a>
                    <a href="javascript:void(0)" class="logout">Log out</a>
                </div>
            </div>
        <?php } else { ?>
            <a class="cta nav" href="login.php"><button class="buttonNav" onclick="">LOGIN</button></a>
        <?php } ?>
    </header>
    <hr style="background-color:rgba(0,0,0,0);border:none;">
    <script>
        function promeniBoju() {
            root = document.documentElement;
            root.style.setProperty('--button-color', 'black');
        }
    </script>
    <div class="pushdown"></div>
</body>
<script>
    var mobileclicked=false;
    var mobilnividew=false;
    funkcijaZaSliku();
    function funkcijaZaSliku() {
        if (window.innerWidth < 691&&mobileclicked==false) {
            $(".dropdown").css("display", "none");
            
            mobilnividew=true;
        } else {
            $(".dropdown").css("display", "block");
            mobilnividew=false
        }
    }

    $(".burger-icon").on("click", function() {
        if ($(".nav").hasClass("mobile-hide")) {
            $(".nav").removeClass("mobile-hide");
            $(".nav").addClass("mobile-show");
            $(".dropdown").css("display", "block");
            mobileclicked=true;
        } else {
            mobileclicked=false;
            $(".nav").addClass("mobile-hide");
            $(".nav").removeClass("mobile-show");
            $(".dropdown").css("display", "none");
        }

    });
    if ($(window).width() <= 690) {
        $(".nav").addClass("mobile-hide")
    }
    $(window).resize(function() {
        if ($(this).width() <= 690) {
            $(".nav").addClass("mobile-hide")
        } else if ($(this).width() >= 690) {
            $(".nav").removeClass("mobile-hide")
        }
    });
    $(document).ready(function() {
        var loggedin = <?php if (isset($_SESSION['userid'])) {
                            echo "true";
                        } else {
                            echo "false";
                        } ?>;
        if (loggedin) {
            $("header").addClass("headerLogged");
        }
        $(".dropdown").hover(
            () => { //hover
                $('.dropdown-content').css("display", "block");
                $(".dropdown-content").removeClass("dropdownOut");
                $(".dropdown-content").addClass("dropdownIn");
                $(".dropdown-content a").addClass("textdropdown1");
                $(".dropdown-content a").removeClass("textdropdown2");
            },
            () => { //out
                $(".dropdown-content a").addClass("textdropdown2");
                $(".dropdown-content a").removeClass("textdropdown1");
                $(".dropdown-content").addClass("dropdownOut");
                setTimeout(function() {
                    $(".dropdown-content").removeClass("dropdownIn");
                    $('.dropdown-content').css("display", "none");
                }, 200);
            }
        );
        $(".logout").click(function() {
            var form_data = new FormData();
            form_data.append('csrf', "<?php echo $csrf ?>");
            form_data.append('logoutsubmit', true);

            $.ajax({
                url: "includes/logout.inc.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {},
                success: function(data) {
                    window.open("login.php", "_self")
                }
            });
        });
    });
</script>