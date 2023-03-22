<?php

$fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (!defined('errorcheck')) {
    exit('ok man have a nice day now! :)');
}else if(defined("login"))
{
    switch(true)
    {
        case stristr($fullUrl,"error=alreadyLoggedIn"):
            echo '<div class="error">Already logged in.</div>';break;
        case stristr($fullUrl,"error=EmptyFields"):
            echo '<div class="error">Empty fields.</div>';break;
        case stristr($fullUrl,"error=pwdWrong"):
            echo '<div class="error">Password is wrong.</div>';break;
        case stristr($fullUrl,"error=badUsername"):
            echo '<div class="error">Username does not exist.</div>';break;
        case stristr($fullUrl,"error=databaseconnectionerror"):
            echo '<div class="error">Server error.</div>';break;
        case stristr($fullUrl,"success=passwordreset"):
            echo '<div class="error success">Password was reset.</div>';break;
        case stristr($fullUrl,"success=emailconfirmed"):
            echo '<div class="error success">Account verified.</div>';break;
            default:break;
    }
}else if(defined("create-new-password"))
{
    switch(true)
    {
        case stristr($fullUrl,"error=fieldsempty"):
            echo '<div class="error">Empty fields.</div>';break;
        case stristr($fullUrl,"error=pwdnotsame"):
            echo '<div class="error">Passwords do not match.</div>';break;
        case stristr($fullUrl,"error=emailnotpresent"):
            echo '<div class="error">Bad email.</div>';break;
        case stristr($fullUrl,"error=badToken"):
            echo '<div class="error">Bad token.</div>';break;
            default:break;
    }
}else if(defined("forgot-password"))
{
    switch(true)
    {
        case stristr($fullUrl,"error=sqlError"):
            echo '<div class="error">Server error.</div>';break;
        case stristr($fullUrl,"success=true"):
            echo '<div class="error success">Email sent.</div>';break;
            default:break;
    }
}
else if(defined("registration"))
{
    switch(true)
    {
        case stristr($fullUrl,"error=EmptyFields"):
            echo '<div class="error">Empty fields.</div>';break;
        case stristr($fullUrl,"error=invalidmailoruser"):
            echo '<div class="error">Email or username is not valid.</div>';break;
        case stristr($fullUrl,"error=invailidemail"):
            echo '<div class="error">Email not valid.</div>';break;
        case stristr($fullUrl,"error=passworddoesnotmatch"):
            echo '<div class="error">Passwords do not match.</div>';break;
        case stristr($fullUrl,"error=invaliduser"):
            echo '<div class="error">Username not valid.</div>';break;
        case stristr($fullUrl,"error=nameOrEmailAlreadyExists"):
            echo '<div class="error">Username or email already exists.</div>';break;
        case stristr($fullUrl,"error=sqlError"):
            echo '<div class="error">Server error.</div>';break;
        case stristr($fullUrl,"success=true"):
            echo '<div class="error success">Confirmation email sent.</div>';break;
            default:break;
    }
}


