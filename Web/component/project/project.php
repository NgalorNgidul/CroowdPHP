<?php

$id = $_GET['id'];
$data = getJAVA('api/prospect/'.$id);
$rows = json_decode($data);

include 'component/'.$_GET['content'].'/'.$_GET['content'].'.html.php';


?>