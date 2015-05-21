<?php

$id = $_GET['id'];
$data = bacaRest('member/get/'.$id);
//var_dump($data);
$rows = json_decode($data, TRUE);
//$rows = array();

include 'component/'.$_GET['content'].'/'.$_GET['content'].'.html.php';


?>