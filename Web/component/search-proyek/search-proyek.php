
<?php

if($_GET['more']!=null){
    echo 10;
} else {

include 'component/'.$_GET['content'].'/'.$_GET['content'].'.html.php';


?>

 
<script language="javascript"  type="text/javascript" src="component/search-proyek/search-proyek.js"></script>

<?php } ?>