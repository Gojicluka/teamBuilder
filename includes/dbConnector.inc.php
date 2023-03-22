<?php
define("servcheck",true);
require "../serverinfo.inc.php";


try{
    $conn = new PDO("mysql:host=$server;",$user,$pass);
    $conn ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "konekcija uspesno uspostavljena";
    $conn->query("use rejhwzqk_teamBuilder");

}catch(PDOException $error)
{
    echo "Greska".$error->getMessage(); 
}