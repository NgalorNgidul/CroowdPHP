
<!--<script language="javascript"  type="text/javascript" src="component/cari-pinjaman/cari-pinjaman.js"></script>-->
<?php
if ($_GET['kirim'] == 'kirim') {
    $url = "registration/create";
//    $content = 'name=' . $_POST['name'] . '&email=' . $_POST['email']. '&invest=1';
    $content = '{"name":"' . $_POST['name'] . '","email":"' . $_POST['email'] . '","invest":1}';

//    {“name”:”nama_lengkap”,”email”:”alamat_email”}
    //   echo $_POST['name'].','.$_POST['email'];
    $response = sendPOSTDATA($url, $content);

    //   echo $response;
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


