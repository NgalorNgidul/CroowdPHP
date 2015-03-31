<?php
function logout(){
    $cookies = $_COOKIE['simbiosis'];
    setcookie("simbiosis",$cookies,time()-3600);
    header('location:index.php');
}

function amountToStr($amount) {
    return ($amount == "-") ? $amount : number_format($amount, 0, ".", ",");
}

function strToAmount($amount) {
    $uang = explode(',', $amount);
    for ($i = 0; $i < count($uang); $i++) {
        $money .= $uang[$i];
    }
    return $money;
}