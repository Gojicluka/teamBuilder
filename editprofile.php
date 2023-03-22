<?php
define("navcheck", true);
require "nav.php";

?>
</head>
<link rel="stylesheet" href="css/editprofile.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- NE ZABORAVI DA DODAS CSRF TOKEN ZA BILO STA RADIS -->
<script src="js/scrolling.js"></script>
<title>Edit profile</title>
<body>
    <div class="container">
        
        <div class="div2">
        <div class="pushdown2"></div>
            <div class="formaDiv ">
                <?php if (isset($_SESSION['userid'])) { ?>
                    <div class="info">
                        <div class="innerInfo" style="position:relative;">
                            <div class="i1">
                                <img class='yourAvatar' src='' id='slika'/>
                                <label class=" custom-file-upload">
                                    <input type="file" type="file" name="image" id="file" />
                                    Change Avatar 
                                </label>
                                <?php if($_SESSION['type']=="discord"||$_SESSION['discordlinked']=="true"){?>
                                <br> Preference <br>
                                <button class="avatarToggle" id="avatarPreference">Regular</button>
                                <?php } ?>
                            </div>
                            <div class="i2">
                                <div class="tekst2" style="float:left;">Bio</div>
                                <div style="float:right;" id="infoError" class=""></div>
                                <textarea class="tekst1" id="bio" placeholder="Bio" rows="2" value="" style="margin-bottom:30px;"><?php echo $_SESSION['bio']; ?></textarea>
                                <div class="tekst2">Location</div>
                                <input class="tekst1" placeholder="Location" id="location" value="<?php echo $_SESSION['location']; ?>">
                            </div>
                        </div>
                        <button class="dugme1 sejv" type="submit" id="save-submit" name="save-submit" style="">Save!</button>
                    </div>
                    <?php
                    if (@$_SESSION['type'] != "discord") {
                    ?>
                        <br>
                        <div class="username">
                            <div style="float:left;" class="tekst2">Change your username:</div>
                            <div style="float:right;" id="usernameError" class=""></div>
                            <input class="tekst1" type="textarea" id="Username" name="username" placeholder="New username">
                            <input class="tekst1" type="password" id="usernamepassword" name="old-password" placeholder="Password">
                            <button class="dugme1" type="submit" id="username-submit" style="">Change username</button>
                        </div>
                        <div class="password">
                            <div style="float:left;" class="tekst2">Change your password:</div>
                            <div style="float:right;" id="passwordError" class=""></div>
                            <input class="tekst1" type="password" id="oldpassword" placeholder="Old password">
                            <input class="tekst1" type="password" id="newpassword" placeholder="New password">
                            <input class="tekst1" type="password" id="newpasswordrepeat" placeholder="New password repeat">
                            <button class="dugme1" type="submit" id="password-submit" style="">Change password</button>
                        </div>
                        <?php if($_SESSION['type']=="regular"){ ?>
                            <?php if($_SESSION['discordlinked']=="true"){ echo "<div class='tekst2'>If you changed something about your discord account, please relink.</div>";}?>
                        <form action="includes/editprofile/link-discord.inc.php" method="POST">
                            <input type="hidden" name="csrf" value="<?php echo $csrf; ?>">
                            <button class="dugme1 discordDugme" type="submit" name="submit" style="">
                                <img src="images/discordlogo.png" class="discordlogo" />Link discord
                            </button>
                        </form>
                        <?php } ?>
                    <?php
                    } else if (@$_SESSION['type'] != "regular") {
                    ?>
                        Discord account linked
                    <?php
                        echo $_SESSION['username'] . "#" . $_SESSION['discordtag'];
                    }
                    ?>
                <?php } else {
                    echo "<div style='text-align:center;' class='loginplease'>Log in please</div>";
                } ?>
            </div>
        </div>
    </div>

    
</body>
<script>
    var voicechat = false;
    var disLinked = <?php if(isset($_SESSION['discorduserid'])){echo "true";}else{echo "false";}?>;

    function checkPreference(promena = false) {
        if (promena == false) {
            
            pref = <?php if ($_SESSION['avatarpreference'] == "regular") {
                            echo 'true';
                        } else {
                            echo 'false';
                        } ?>;
        }
        else if(promena==true)
        {
            if(promena=="regular"){pref=true;}else if(promena=="discord"){pref=false;}
        }
        if (pref == true) {
            document.getElementById('slika').src = "upload/<?php echo $_SESSION['userAvatar']?>";
            $("#avatarPreference").removeClass("avatarToggleDiscord");
            if(disLinked==true){
                document.getElementById("avatarPreference").innerHTML = "Regular";
            }
        } else if(pref==false)
        {
            document.getElementById('slika').src = "https://cdn.discordapp.com/avatars/<?php echo @$_SESSION['discorduserid'] ?>/<?php echo  @$_SESSION['discordAvatar'] ?>";
            $("#avatarPreference").addClass("avatarToggleDiscord");
            document.getElementById("avatarPreference").innerHTML = "Discord";
        }
    }
    

    $(document).ready(function() {
        checkPreference();
        $("#avatarPreference").click(function() {
            var element = document.getElementById("avatarPreference");
            element.classList.toggle("avatarToggleDiscord");
            if (element.innerHTML == "Regular") {
                element.innerHTML = "Discord";
                document.getElementById('slika').src = "https://cdn.discordapp.com/avatars/<?php echo @$_SESSION['discorduserid'] ?>/<?php echo  @$_SESSION['discordAvatar'] ?>";
            } else if (element.innerHTML == "Discord") {
                element.innerHTML = "Regular";
                if(tmpInUse==false)
                {
                    document.getElementById('slika').src = "upload/<?php echo $_SESSION['userAvatar']?>";
                }else
                {
                    document.getElementById('slika').src = "upload/tmp/"+tmpData;
                }
                
            }
        })

        var loginCondition = <?php if (isset($_SESSION['username'])) {
                                    echo 'true';
                                } else {
                                    echo 'false';
                                } ?>;
        var tmpInUse = false;
        var tmpData="";
        //IMAGE TEMP
        $(document).on('change', "#file", function() {
            $("#avatarPreference").removeClass("avatarToggleDiscord");
            if(disLinked==true){
                document.getElementById("avatarPreference").innerHTML = "Regular";
            }
            
            tmpInUse= true;
            var form_data = new FormData();
            var image = document.getElementById("file").files[0];
            var image_name = image.name;
            var image_extension = image.name.split('.').pop().toLowerCase();
            var image_size = image.size;
            if (jQuery.inArray(image_extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid image");
                return;
            } else if (image_size > 2000000) {
                alert("Image too big");
                return;
            }
            form_data.append("file", image);
            form_data.append('csrf', "<?php echo $csrf ?>");
            form_data.append('submit', true);
            $.ajax({
                url: "includes/editprofile/imgtmp.inc.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {},
                success: function(data) {
                    document.getElementById('slika').src = "upload/tmp/" + data;
                    tmpData=data;
                    //$("#container").html(data);
                }
            });
        });




        $("#save-submit").click(function() {
            var form_data = new FormData();
            var imgPresent= false;
            //ukoliko je nedfeinisan fajl
            if (typeof document.getElementById("file").files[0] !== 'undefined') {
                var image = document.getElementById("file").files[0];
                var image_name = image.name;
                var image_extension = image.name.split('.').pop().toLowerCase();
                var image_size = image.size;
                if (jQuery.inArray(image_extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Invalid image");
                    return;
                } else if (image_size > 2000000) {
                    alert("Image too big");
                    return;
                }
                form_data.append("file", image);
                imgPresent=true;
            } else {
                form_data.append("file", "");
            }
            form_data.append('bio', document.getElementById('bio').value);
            form_data.append('location', document.getElementById('location').value);
            form_data.append('csrf', "<?php echo $csrf ?>");
            form_data.append('submit', true);
            if(disLinked==true){
                form_data.append('avatarPreference', document.getElementById('avatarPreference').innerText);
            }else{
                form_data.append('avatarPreference',"Regular")
            }
            

            if (loginCondition == true) {
                $.ajax({
                    url: "includes/editprofile/save.inc.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(data) {
                        console.log(data)
                        var response = data.split("|");
                        if(response[0]=="Error"){
                            $("#infoError").addClass("error");
                            $("#infoError").removeClass("success");
                            $("#infoError").html(response[1])
                        }else if(response[0]=="Success"){
                            $("#infoError").removeClass("error");
                            $("#infoError").addClass("success");
                            $("#infoError").html(response[1])
                        }
                        
                        if(imgPresent){document.getElementById('slika').src = "upload/" + response[2];}
                        
                    }
                });
            } else if (loginCondition == false) {
                
            }
        });
        //passwordSubmit------------------------------------------------------------------
        $("#password-submit").click(function() {
            var form_data = new FormData();

            form_data.append('newpassword', document.getElementById('newpassword').value);
            form_data.append('newpasswordrepeat', document.getElementById('newpasswordrepeat').value);
            form_data.append('oldpassword', document.getElementById('oldpassword').value);
            form_data.append('csrf', "<?php echo $csrf ?>");
            form_data.append('submit', true);
            if (loginCondition == true) {
                $.ajax({
                    url: "includes/editprofile/changepassword.inc.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(data) {
                        var response = data.split("|");
                        if(response[0]=="Error"){
                            $("#passwordError").addClass("error");
                            $("#passwordError").removeClass("success");
                            $("#passwordError").html(response[1])
                        }else if(response[0]=="Success"){
                            $("#passwordError").removeClass("error");
                            $("#passwordError").addClass("success");
                            $("#passwordError").html(response[1])
                        }
                    }
                });
            } else if (loginCondition == false) {
                
            }
        });
        //username submit------------------------------------------------------------------
        $("#username-submit").click(function() {
            var form_data = new FormData();

            form_data.append('username', document.getElementById('Username').value);
            form_data.append('password', document.getElementById('usernamepassword').value);
            form_data.append('csrf', "<?php echo $csrf ?>");
            form_data.append('submit', true);
            if (loginCondition == true) {
                $.ajax({
                    url: "includes/editprofile/changeusername.inc.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(data) {
                        var response = data.split("|");
                        if(response[0]=="Error"){
                            $("#usernameError").addClass("error");
                            $("#usernameError").removeClass("success");
                            $("#usernameError").html(response[1])
                        }else if(response[0]=="Success"){
                            $("#usernameError").removeClass("error");
                            $("#usernameError").addClass("success");
                            $("#usernameError").html(response[1])
                        }
                    }
                });
            } else if (loginCondition == false) {
                
            }
        });
    });
</script>
<?php
require "footer.php";
?>