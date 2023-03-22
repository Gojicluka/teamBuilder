<?php
define("navcheck", true);
require "nav.php";

?>
</head>
<link rel="stylesheet" href="css/register.css">
<title>Confirm Email</title>
<body>
    <div class="container">
        <div class="div1">
        </div>
        <div class="div2">
            <div class="formaDiv" style="margin-top:35vh">
               
                <?php
                if (isset($_GET['vkey'])) {
                    $server = "localhost:3309";
                    $user = "root";
                    $pass = "";
                    $dBName = "teambuilder";
                    //

                    try {
                        $conn = new PDO("mysql:host=$server;", $user, $pass);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $conn->query("use rejhwzqk_teamBuilder");
                        $vkey = htmlspecialchars(strip_tags($_GET['vkey']));
                        $conn->beginTransaction();
                        $stmt = $conn->prepare("SELECT `confirmed`,`vkey` FROM `users` WHERE `confirmed`=:confirmed AND `vkey`=:vkey LIMIT 1");
                        $confirmed = 'false';
                        $stmt->bindParam(':confirmed', $confirmed);
                        $stmt->bindParam(':vkey', $vkey);
                        $brojac = 0;
                        $stmt->execute();
                        $conn->commit();
                        $res = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $brojac = 0;
                        foreach ($stmt->fetchAll() as $k => $row) {
                            $brojac++;
                        }
                        if ($brojac > 0) {
                            $conn->beginTransaction();
                            $stmt = $conn->prepare("UPDATE `users`SET `confirmed`=:confirmed2 WHERE `vkey`=:vkey2 LIMIT 1");
                            $confirmed = 'true';
                            $stmt->bindParam(':confirmed2', $confirmed);
                            $stmt->bindParam(':vkey2', $vkey);
                            $stmt->execute();
                            $conn->commit();
                            echo ' <div class="register" style="color:var(--main-color);">Success</div>
                            <div class="donthaveanaccount" style="font-family:valorant;">Your account is confirmed now</div>';
                            header("Location: login.php?success=emailconfirmed");
                            exit();
                        } else {
                            echo ' <div class="register" style="color:var(--main-color);">Failed</div>
                            <div class="donthaveanaccount" style="font-family:valorant;">bad code</div>';
                        }
                    } catch (PDOException $error) {
                        //echo "Greska" . $error->getMessage();
                    }
                } else {
                    header("Location: index.php");
                    exit();
                }
                ?>
            </div>
        </div>
    </div>
</body>
<?php
require "footer.php";
?>