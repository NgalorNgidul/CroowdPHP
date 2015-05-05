<?php

function ipconfig() {
    //  $ipconfig = 'http://www.croowd.co.id/';
    $ipconfig = 'http://api.croowd.co.id/';
    return $ipconfig;
}

function logout() {
    $cookies = $_COOKIE['simbiosis'];
    setcookie("simbiosis", $cookies, time() - 3600);
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

function bacaRest($url) {
    $ipconfig = ipconfig();
    $ip = $ipconfig . '' . $url;
    // setting CURL
    $data = curl_init();
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $ip);

    // menjalankan CURL untuk membaca isi file
    $hasil = curl_exec($data);
    curl_close($data);

    return $hasil;
}

function bacaHTML($url) {
    /* 	require_once 'configuration.php';
      $cekIPS	= $db->Execute("SELECT * FROM ipConfig");
      // inisialisasi CURL

      $ip		= $cekIPS->fields['ipAddr'].''.$url;
     */
    $ipconfig = ipconfig();
    $ip = $ipconfig . '' . $url;
    $data = curl_init();
    // setting CURL
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $ip);

    // menjalankan CURL untuk membaca isi file
    $hasil = curl_exec($data);
    curl_close($data);
    return $hasil;
}

function getJAVA($url) {
    /*  require_once 'configuration.php';
      $getQuery = "SELECT * FROM ipConfig";
      $getResult = @mysql_query($getQuery);
      $getRow = @mysql_fetch_array($getResult); */
    // inisialisasi CURL
    $ipconfig = ipconfig();
    $ip = $ipconfig . '' . $url;
    $data = curl_init();
//    $ip = $getRow['ipAddr'] . '' . $url;
//	echo $ip;
    // setting CURL
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $ip);

    // menjalankan CURL untuk membaca isi file
    $hasil = curl_exec($data);
    curl_close($data);
    return json_decode($hasil);
}

function getDATA($url) {
    /*   require_once 'configuration.php';
      $getQuery = "SELECT * FROM ipConfig";
      $getResult = @mysql_query($getQuery);
      $getRow = @mysql_fetch_array($getResult); */
    // inisialisasi CURL
    $data = curl_init();
    $ipconfig = ipconfig();
    $ip = $ipconfig . '' . $url;
    //   $ip = $getRow['ipAddr'] . '' . $url;
    // setting CURL
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $ip);

    // menjalankan CURL untuk membaca isi file
    $hasil = curl_exec($data);
    curl_close($data);
    return $hasil;
}

function sendPOSTDATA($url, $content) {
    $ipconfig = ipconfig();
    $ip = $ipconfig . '' . $url;
    $ch = curl_init($ip);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/Json"));

    $json_response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($status != 200) {
        //   die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
        echo 'Gagal Melakukan Pendaftaran';
        echo "<script>setTimeout(\"location.href = '?content=" . $_GET['content'] . "';\",5000);</script>";
    } else {


        curl_close($ch);

        $response = json_decode($json_response, true);
        return $response;
    }
}
