<!DOCTYPE html>
<?php
define("navcheck", true);
require "nav.php";
?>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/teamsPlayers/slajd.css" />
    <link rel="stylesheet" type="text/css" href="css/teamsPlayers/dropovi.css" />
    <link rel="stylesheet" type="text/css" href="css/teamsPlayers/content.css" />
    <link rel="stylesheet" type="text/css" href="css/teamsPlayers/novopoz.css" />

    <link rel="stylesheet" href="css/players.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    

    <script src='js/scrolling.js'></script>
    <script>var typeoffile="teams";</script>
    <script src="js/teamsPlayers/languagedrop.js"></script>
</head>
<title>Find Teams</title>
<body onload="showCheckboxes();showCheckboxes2();showCheckboxes3() ;showCheckboxes4();  showRanks(); showRanks2();">
    <!--NAV, SLIDE AND TITLE-->
    <div class='mainContainer'>
        <div class="slikeContainer" style="position:relative;">



            <div id="slike">
                <img class="sld" src="images/teamsPlayers/006.png" id="prvi" style="" />
            </div>
        </div>
        <div class="glavniContainer">

            <div class="mainTekst">Find Teams</div>
            <!--FILTEERI-->

            <div class="glavniContainer2">

                <div class="containerFilteriLfg">
                    <div class="filteriTekst" style="border-top-left-radius:15px;border-top-right-radius:15px;">Filters</div>
                    <div class="filteri" style="border-bottom-left-radius:15px;border-bottom-right-radius:15px;">
                        <div>
                            <div class="Formular-tekst">Type of player</div>
                            <select name="" id="activityFilter" class="tekst1" onchange="updateLfg();">
                                <option value="any">Any</option>
                                <option value="Competititve">Competitive</option>
                                <option value="Casual">Casual</option>
                            </select>
                        </div>
                        <div>
                            <div class="Formular-tekst">Filter by your rank</div>
                            <div style="position:relative" id="rankDrop3">
                                <div class="drop-down3">
                                    <select name="options3" id="yourRankFilter">
                                        <option class="any" value="any" style="text-align:center;">
                                            Any
                                        </option>
                                        <option class="iron" value="1" style="background-image:url('images/teamsPlayers/Iron.png');">
                                            <img src="images/teamsPlayers/Iron.png" alt="">Iron
                                        </option>
                                        <option class="bronze" value="2" style="background-image:url('images/teamsPlayers/Bronze2.png');">
                                            Bronze
                                        </option>
                                        <option class="silver" value="3" style="background-image:url('images/teamsPlayers/Silver.png');">
                                            Silver
                                        </option>
                                        <option class="gold" value="4" style="background-image:url('images/teamsPlayers/Gold.png');">
                                            Gold
                                        </option>
                                        <option class="platinum" value="5" style="background-image:url('images/teamsPlayers/Platinum.png');">
                                            Platinum
                                        </option>
                                        <option class="diamond" value="6" style="background-image:url('images/teamsPlayers/Diamond.png');">
                                            Diamond
                                        </option>
                                        <option class="immortal" value="7" style="background-image:url('images/teamsPlayers/Immortal.png');">
                                            Immortal
                                        </option>
                                        <option class="radiant" value="8" style="background-image:url('images/teamsPlayers/Radiant.png');">
                                            Radiant
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="Formular-tekst">Microphone</div>
                            <select name="" id="voiceFilter" class="tekst1" onchange="updateLfg();">
                                <option value="any">Any</option>
                                <option value="true">Required</option>
                                <option value="false">Not required</option>
                            </select>
                        </div>
                        <div style="position:relative;" id="jezikDrop3">
                            <div class="languageDrop languageDrop3">
                                <div class="Formular-tekst">Languages:</div>
                                <div class="languageSel" onclick="showCheckboxes3()">
                                    <select id="meh">
                                        <option selected hidden>Select languages</option>
                                    </select>
                                    <div class="overSelect3"></div>
                                </div>
                                <div id="languages3">
                                    <label for="cFilter">
                                        <input type="checkbox" type="checkbox" id="cFilter" value="ALL" onchange="updateLfg();">
                                        ALL
                                    </label>
                                    <label for="scb2">
                                        <input type="checkbox" id="scb2" name="jeziciFilter" value="SRB/BIH/HRV/MNE" onchange="updateLfg();">
                                        <img src="images/flags/serbia.png" class="flag" />SRB/<img src="images/flags/croatia.png" class="flag" />CRO/
                                        <img src="images/flags/bosnia.svg" class="flag" />BIH/<img src="images/flags/mne.svg" class="flag" />MNE
                                    </label>
                                    <label for="eng2">
                                        <input type="checkbox" id="eng2" name="jeziciFilter" value="ENG" onchange="updateLfg();">
                                        <img src="images/flags/eng.png" class="flag" />ENG
                                    </label>
                                    <label for="svn2">
                                        <input type="checkbox" id="svn2" name="jeziciFilter" value="SVN" onchange="updateLfg();">
                                        <img src="images/flags/svn.png" class="flag" />SVN
                                    </label>
                                    <label for="alb2">
                                        <input type="checkbox" id="alb2" name="jeziciFilter" value="ALB" onchange="updateLfg();">
                                        <img src="images/flags/alb.png" class="flag" />ALB
                                    </label>
                                    <label for="bgr2">
                                        <input type="checkbox" id="bgr2" name="jeziciFilter" value="BGR" onchange="updateLfg();">
                                        <img src="images/flags/bgr.png" class="flag" />BGR
                                    </label>
                                    <label for="gre2">
                                        <input type="checkbox" id="gre2" name="jeziciFilter" value="GRE" onchange="updateLfg();">
                                        <img src="images/flags/gre.svg" class="flag" />GRE
                                    </label>
                                    <label for="rom2">
                                        <input type="checkbox" id="rom2" name="jeziciFilter" value="ROM" onchange="updateLfg();">
                                        <img src="images/flags/rom.png" class="flag" />ROM
                                    </label>
                                    <label for="mkd2">
                                        <input type="checkbox" id="mkd2" name="jeziciFilter" value="MKD" onchange="updateLfg();">
                                        <img src="images/flags/mkd.png" class="flag" />MKD
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div style="position:relative;" id="jezikDrop4">
                            <div class="languageDrop languageDrop3">
                                <div class="Formular-tekst">Your needed</div>
                                <div class="languageSel" onclick="showCheckboxes4()">
                                    <select>
                                        <option selected hidden>Select Roles</option>
                                    </select>
                                    <div class="overSelect4"></div>
                                </div>
                                <div id="languages4">
                                    <input type="checkbox" id="rolechecker" style="display:none;">
                                    <label for="sup2">
                                        <input type="checkbox" id="sup2" name="rolesFilter" checked value="Support" onchange="updateLfg();">
                                        Support
                                    </label>
                                    <label for="ing2">
                                        <input type="checkbox" id="ing2" name="rolesFilter" checked value="In-game Leader" onchange="updateLfg();">
                                        In-game Leader
                                    </label>
                                    <label for="efg2">
                                        <input type="checkbox" id="efg2" name="rolesFilter" checked value="Entry Fragger" onchange="updateLfg();">
                                        Entry Fragger
                                    </label>
                                    <label for="lurk2">
                                        <input type="checkbox" id="lurk2" name="rolesFilter" checked value="Lurker" onchange="updateLfg();">
                                        Lurker
                                    </label>
                                    <label for="rea2">
                                        <input type="checkbox" id="rea2" name="rolesFilter" checked value="Reacon" onchange="updateLfg();">
                                        Reacon
                                    </label>
                                    <label for="cc2">
                                        <input type="checkbox" id="cc2" name="rolesFilter" checked value="Crowd Control" onchange="updateLfg();">
                                        Crowd Control
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--LFG POSTS-->

                    <div class="lfgs" id="lfg">
                    </div>
                </div>



                <!--FORMULAR-->


                <div class="formular">
                    <div class="formularTekstina" style="border-top-left-radius:15px;border-top-right-radius:15px;">Post lfg</div>
                    <?php if (isset($_SESSION['userid'])) { ?>
                        <div id="formularContainer">
                            <div class="formularContainer" style="border-bottom-left-radius:15px;border-bottom-right-radius:15px;">
                                <div>
                                    <div class="Formular-tekst">Type of player :</div>
                                    <select name="" id="activity" class="tekst1">
                                        <option value="Any">Any</option>
                                        <option value="Competititve">Competitive</option>
                                        <option value="Casual">Casual</option>
                                    </select>
                                </div>
                                <div>
                                    <div class="Formular-tekst">Players needed :</div>
                                    <select name="" id="players" class="tekst1">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div>
                                    <div style="position:relative;" id="jezikDrop1">
                                        <div class="languageDrop">
                                            <div class="Formular-tekst">Languages :</div>
                                            <div class="languageSel" onclick="showCheckboxes()">
                                                <select>
                                                    <option selected hidden>Select languages</option>
                                                </select>
                                                <div class="overSelect1"></div>
                                            </div>
                                            <div id="languages">
                                                <label for="c1">
                                                    <input type="checkbox" type="checkbox" id="c1" value="ALL">
                                                    ALL
                                                </label>
                                                <label for="scb">
                                                    <input type="checkbox" id="scb" name="jezici" value="SRB/BIH/HRV/MNE">
                                                    <img src="images/flags/serbia.png" class="flag" />SRB/<img src="images/flags/croatia.png" class="flag" />CRO/
                                                    <img src="images/flags/bosnia.svg" class="flag" />BIH/<img src="images/flags/mne.svg" class="flag" />MNE
                                                </label>
                                                <label for="eng">
                                                    <input type="checkbox" id="eng" name="jezici" value="ENG">
                                                    <img src="images/flags/eng.png" class="flag" />ENG
                                                </label>
                                                <label for="svn">
                                                    <input type="checkbox" id="svn" name="jezici" value="SVN">
                                                    <img src="images/flags/svn.png" class="flag" />SVN
                                                </label>
                                                <label for="alb">
                                                    <input type="checkbox" id="alb" name="jezici" value="ALB">
                                                    <img src="images/flags/alb.png" class="flag" />ALB
                                                </label>
                                                <label for="bgr">
                                                    <input type="checkbox" id="bgr" name="jezici" value="BGR">
                                                    <img src="images/flags/bgr.png" class="flag" />BGR
                                                </label>
                                                <label for="gre">
                                                    <input type="checkbox" id="gre" name="jezici" value="GRE">
                                                    <img src="images/flags/gre.svg" class="flag" />GRE
                                                </label>
                                                <label for="rom">
                                                    <input type="checkbox" id="rom" name="jezici" value="ROM">
                                                    <img src="images/flags/rom.png" class="flag" />ROM
                                                </label>
                                                <label for="mkd">
                                                    <input type="checkbox" id="mkd" name="jezici" value="MKD">
                                                    <img src="images/flags/mkd.png" class="flag" />MKD
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="marginTopFormular"></div>

                                <div>
                                    <div class="Formular-tekst">Microphone :</div>
                                    <select id="voicechat" class="tekst1">
                                        <option value="true">Required</option>
                                        <option value="false">Not Required</option>
                                    </select>
                                </div>

                                <div style="margin-bottom:50px;" style="">
                                    <div class="Formular-tekst">From :</div>
                                    <div style="position:relative" id="rankDrop1">
                                        <div class="drop-down">
                                            <select name="options" id="rankFrom">
                                                <option class="iron" value="1" style="background-image:url('images/teamsPlayers/Iron.png');">
                                                    Iron
                                                </option>
                                                <option class="bronze" value="2" style="background-image:url('images/teamsPlayers/Bronze2.png');">
                                                    Bronze
                                                </option>
                                                <option class="silver" value="3" style="background-image:url('images/teamsPlayers/Silver.png');">
                                                    Silver
                                                </option>
                                                <option class="gold" value="4" style="background-image:url('images/teamsPlayers/Gold.png');">
                                                    Gold
                                                </option>
                                                <option class="platinum" value="5" style="background-image:url('images/teamsPlayers/Platinum.png');">
                                                    Platinum
                                                </option>
                                                <option class="diamond" value="6" style="background-image:url('images/teamsPlayers/Diamond.png');">
                                                    Diamond
                                                </option>
                                                <option class="immortal" value="7" style="background-image:url('images/teamsPlayers/Immortal.png');">
                                                    Immortal
                                                </option>
                                                <option class="radiant" value="8" style="background-image:url('images/teamsPlayers/Radiant.png');">
                                                    Radiant
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="marginBottomFormular"></div>
                                <div>
                                    <div class="Formular-tekst">To :</div>
                                    <div style="position:relative" id="rankDrop2">
                                        <div class="drop-down2">
                                            <select name="options2" id="rankTo">
                                                <option class="iron2" value="1" style="background-image:url('images/teamsPlayers/Iron.png');">
                                                    Iron
                                                </option>
                                                <option class="bronze2" value="2" style="background-image:url('images/teamsPlayers/Bronze2.png');">
                                                    Bronze
                                                </option>
                                                <option class="silver2" value="3" style="background-image:url('images/teamsPlayers/Silver.png');">
                                                    Silver
                                                </option>
                                                <option class="gold2" value="4" style="background-image:url('images/teamsPlayers/Gold.png');">
                                                    Gold
                                                </option>
                                                <option class="platinum2" value="5" style="background-image:url('images/teamsPlayers/Platinum.png');">
                                                    Platinum
                                                </option>
                                                <option class="diamond2" value="6" style="background-image:url('images/teamsPlayers/Diamond.png');">
                                                    Diamond
                                                </option>
                                                <option class="immortal2" value="7" style="background-image:url('images/teamsPlayers/Immortal.png');">
                                                    Immortal
                                                </option>
                                                <option class="radiant2" value="8" style="background-image:url('images/teamsPlayers/Radiant.png');">
                                                    Radiant
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="marginBottomFormular"></div>
                                <div>
                                    <div class="Formular-tekst">Riot username :</div>
                                    <input type="text" id="riotUsername" maxlength="20" class="tekst1"> <br>
                                </div>
                                <div>
                                    <div style="position:relative;" id="jezikDrop2">
                                        <div class="languageDrop languageDrop2">
                                            <div class="Formular-tekst">Roles needed :</div>
                                            <div class="languageSel" onclick="showCheckboxes2()">
                                                <select>
                                                    <option selected hidden>Select Roles</option>
                                                </select>
                                                <div class="overSelect1"></div>
                                            </div>
                                            <div id="languages2">
                                                <label for="sup">
                                                    <input type="checkbox" id="sup" name="roles" checked value="Support">
                                                    Support
                                                </label>
                                                <label for="ing">
                                                    <input type="checkbox" id="ing" name="roles" checked value="In-game Leader">
                                                    In-game Leader
                                                </label>
                                                <label for="efg">
                                                    <input type="checkbox" id="efg" name="roles" checked value="Entry Fragger">
                                                    Entry Fragger
                                                </label>
                                                <label for="lurk">
                                                    <input type="checkbox" id="lurk" name="roles" checked value="Lurker">
                                                    Lurker
                                                </label>
                                                <label for="rea">
                                                    <input type="checkbox" id="rea" name="roles" checked value="Reacon">
                                                    Reacon
                                                </label>
                                                <label for="cc">
                                                    <input type="checkbox" id="cc" name="roles" checked value="Crowd Control">
                                                    Crowd Control
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="marginTopFormular"></div>
                                <div class="messagegrid">
                                    <div class="Formular-tekst">Message :</div>
                                    <textarea class="tekst1" id="message" maxlength="100" rows="1"></textarea>
                                </div>
                                <div class="submitgrid">
                                    <button class="dugme1" id="submit" name="lfg-submit">Submit LFG</button>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="pleaselogin">
                            <br>
                            In order to post a lfg you need to have an account. <br><br>
                            <a href="login.php"><button class="dugme1PleaseLogin">Login</button></a>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
<script>
    var voicechat = false;

    function updateLfg() {
        $("#lfg").load("includes/update-lfg.inc.php", {
            filterActivity: document.getElementById("activityFilter").value,
            filterYourRank: document.getElementById("yourRankFilter").value,
            filterVoiceChat: document.getElementById("voiceFilter").value,
            filterLanguage: checkboxFunkcija(document.getElementsByName("jeziciFilter"), document.getElementById('cFilter'), "jezici"),
            filterRoles: checkboxFunkcija(document.getElementsByName('rolesFilter'), document.getElementById('rolechecker'), "roles"),
            submit: true,
            type: "teams",
            csrf: "<?php echo $csrf ?>"
        });
    }
    $(document).ready(function() {
        window.onresize = function(event) {

        }
        jQuery('.drop-down3 .select-list3 span').on('click', function() {
            updateLfg();
        });
        updateLfg()
        //for submit
        $("#submit").click(function() {
            if (document.getElementById('message').value == "" || document.getElementById('riotUsername').value == "") {
                alert("Please don't leave any fields empty");
            } else {
                //konekcija
                var loginCondition = <?php if (isset($_SESSION['username'])) {
                                            echo 'true';
                                        } else {
                                            echo 'false';
                                        } ?>;
                if (loginCondition == true) {
                    $("#formularContainer").load("includes/submitlfg.inc.php", {
                        activity: document.getElementById("activity").value,
                        numberOfPlayers: document.getElementById("players").value,
                        languages: checkboxFunkcija(document.getElementsByName("jezici"), document.getElementById('c1'), "jezici"),
                        voice: document.getElementById('voicechat').value,
                        rankFrom: document.getElementById("rankFrom").value,
                        rankTo: document.getElementById("rankTo").value,
                        riotUsername: document.getElementById("riotUsername").value,
                        message: document.getElementById("message").value,
                        roles: checkboxFunkcija(document.getElementsByName('roles'), document.getElementById('rolechecker'), "roles"),
                        submit: 'true',
                        type: "teams",
                        csrf: "<?php echo $csrf ?>"
                    }, function() {
                        console.log("mhm");
                        updateLfg();
                    });

                } else if (loginCondition == false) {

                }
            }
        });
        //for 
        //22 ranks


        setInterval(updateLfg, 20000);



    });

    function checkboxFunkcija(niz, all, funkcija) {
        var nizZaVracanje = "";
        var brojac = 0;
        if (!all.checked || funkcija == "roles") {
            for (var i = 0; i < niz.length; i++) {
                if (niz[i].checked == true) {
                    nizZaVracanje += niz[i].value + "|";
                    brojac++;
                }
            }
        } else {
            nizZaVracanje = "all";
        }
        if (brojac == 0 && funkcija == "jezici") {
            nizZaVracanje = "all";
        }
        return nizZaVracanje;


    }
</script>