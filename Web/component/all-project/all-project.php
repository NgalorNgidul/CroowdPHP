
<?php

if (isset($_GET['more']) && $_GET['more'] != null) {
    $data = bacaHTML('prospect/find/' . $_GET['parameter']);
    // $rows = json_decode($data);
    //  include 'component/' . $_GET['content'] . '/list-search.php';
    echo $data;
    //  echo 10;
} else {

    include 'component/' . $_GET['content'] . '/' . $_GET['content'] . '.html.php';
    ?>


    <script language="javascript"  type="text/javascript" src="component/search-proyek/search-proyek.js"></script>

<?php } ?>