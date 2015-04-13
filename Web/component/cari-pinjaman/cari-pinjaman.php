
<!--<script language="javascript"  type="text/javascript" src="component/cari-pinjaman/cari-pinjaman.js"></script>-->
<?php
if ($_GET['kirim'] == 'kirim') {
    $url = "registration/create";
//    $content = 'name=' . $_POST['name'] . '&email=' . $_POST['email']. '&invest=0'. '&principal=' . $_GET['value']. '&tenor=' . $_GET['term'];
    $content = '{"name":"' . $_POST['name'] . '","email":"' . $_POST['email'] . '","invest":0,"principal":' . $_POST['principal'] . ',"tenor":' . $_POST['tenor'] . '}';
    $response = sendPOSTDATA($url, $content);
    if ($response == '') {
        echo 'Terima Kasih anda sudah melakukan pendaftaran';
        echo "<script>setTimeout(\"location.href = '?content=" . $_GET['content'] . "';\",5000);</script>";
    } else {
        echo 'Gagal Melakukan Pendaftaran';
        echo "<script>setTimeout(\"location.href = '?content=" . $_GET['content'] . "';\",5000);</script>";
    }
} else {

    include 'component/' . $_GET['content'] . '/' . $_GET['content'] . '.html.php';
}
?>


