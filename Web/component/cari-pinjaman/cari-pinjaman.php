
<!--<script language="javascript"  type="text/javascript" src="component/cari-pinjaman/cari-pinjaman.js"></script>-->
<?php
if($_GET['kirim']=='kirim'){
    $url = "prospek/save";
    $content = 'name=' . $_POST['name'] . '&email=' . $_POST['email']. '&invest=0'. '&principal=' . $_GET['value']. '&tenor=' . $_GET['term'];
//    $response = sendPOSTDATA($url,$content);
//    echo $response;
    
    echo 'Terima Kasih anda sudah melakukan pendaftaran';
   // header( "refresh:5;location:?content=".$_GET['content']."" );
    echo "<script>setTimeout(\"location.href = '?content=".$_GET['content']."';\",5000);</script>";
} else {

include 'component/'.$_GET['content'].'/'.$_GET['content'].'.html.php';

}
?>

 
