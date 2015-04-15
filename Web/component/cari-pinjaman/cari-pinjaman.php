
<!--<script language="javascript"  type="text/javascript" src="component/cari-pinjaman/cari-pinjaman.js"></script>-->
<?php
if ($_GET['kirim'] == 'kirim') {
    $url = "registration/create";
//    $content = 'name=' . $_POST['name'] . '&email=' . $_POST['email']. '&invest=0'. '&principal=' . $_GET['value']. '&tenor=' . $_GET['term'];
    $content = '{"name":"' . $_POST['name'] . '","email":"' . $_POST['email'] . '","invest":0,"principal":' . $_POST['principal'] . ',"tenor":' . $_POST['tenor'] . '}';
    $response = sendPOSTDATA($url, $content);
    include 'component/register/sukses-register.html.php';
} else {

    include 'component/' . $_GET['content'] . '/' . $_GET['content'] . '.html.php';
}
?>


