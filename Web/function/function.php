<?php
function logout(){
    $cookies = $_COOKIE['simbiosis'];
    setcookie("simbiosis",$cookies,time()-3600);
    header('location:index.php');
}