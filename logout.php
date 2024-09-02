<?php
    session_start();
    setcookie("logout",0,time()+3);
    setcookie("login",1,time()-3600);
    session_destroy();
    header("location:login.php");
?>