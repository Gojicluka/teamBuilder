<?php
define("navcheck", true);
require "nav.php";
?>
</head>
<link rel="stylesheet" href="css/index.css">
<title>Balkan.gg/lfg</title>
<body>
    <IMG src="images/index1.png" class="pocetniImg" style=""></IMG>
    <IMG src="images/index2.png" class="normalanImg imgBlue" style=""></IMG>
    <IMG src="images/index3.png" class="normalanImg imgRed" style=""></IMG> 
    
    <div class="container">
        <div class="div1" style="">
            
            <div class="imageContainer">
                <img class="sage" src="images/agents/sage.png" alt="" />
                <div class="imgtxt playerstxt" onclick="window.open('players.php','_self');"> Players</div>
            </div>
        </div>
        <div class="div2">
            
            <div class="imageContainer" >
                <img class="omen"src="images/agents/group.png" style="" />
                <div class="imgtxt teamstxt" onclick="window.open('teams.php','_self');">Teams</div>
            </div>
        </div>

    </div>
</body>
<script>
    $(document).ready(function() {
        $(".playerstxt").hover(function() {
            $('.sage').addClass("agentHover");
            $('.div1').addClass('bgRedHover');
            $('.playerstxt').addClass("playerstxtHover");
            $('.imgRed').addClass("imgopacity1");
        },function() {
            $('.sage').removeClass("agentHover");
            $('.playerstxt').removeClass("playerstxtHover");
            $('.imgRed').removeClass("imgopacity1");
            $('.div1').removeClass('bgRedHover');
        });
        $(".teamstxt").hover(function() {
            $('.omen').addClass("agentHover");
            $('.teamstxt').addClass("teamstxtHover");
            $('.imgBlue').addClass("imgopacity1");
            $('.div2').addClass('bgBlueHover');
        },function() {
            $('.omen').removeClass("agentHover");
            $('.teamstxt').removeClass("teamstxtHover");
            $('.imgBlue').removeClass("imgopacity1");
            $('.div2').removeClass('bgBlueHover');
        })
    })
    function proveri(what)
    {
        if(what=="add")
        {
            $(".div1").addClass("bgBlue");
            $(".playerstxt").addClass("bgRed");
            $(".div2").addClass("bgRed");
            $(".teamstxt").addClass("bgBlue");
            $('.aNav').addClass("navHoverBlue");
            $('.buttonNav').addClass("bgBlue");
        }else if (what=="remove")
        {
            $(".div1").removeClass("bgBlue");
            $(".playerstxt").removeClass("bgRed");
            $(".div2").removeClass("bgRed");
            $(".teamstxt").removeClass("bgBlue");
            $('.aNav').removeClass("navHoverBlue");
            $('.buttonNav').removeClass("bgBlue");
        }

    }
</script>