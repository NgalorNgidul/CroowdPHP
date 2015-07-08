<?php
    $data = NULL;
    $rows = json_decode($data);
?>

<div class="container_12 lst-popular-project clearfix" style="margin-top: 20px;">
    <!--    <div class="grid_12 wrap-title">
            <h3 class="common-title">Semua <span class="fc-orange">Project</span></h3>
        </div>-->
    <div class="clear"></div>
    <div class="grid_9">
        <div class="clearfix" id="all-project">
            
        </div>
        <div class="clearfix" style="margin: auto;width: 40%">
            <ul class="simple-pagination light-theme" id="all-paging">
                <li id="0"><a href="#">First</a></li>
                <li id="0"><a href="#">1</a></li>
                <li id="20"><a href="#">2</a></li>
                <li id="22"><a href="#">3</a></li>
                <li id="23"><a href="#">4</a></li>
                <li id="24"><a href="#">5</a></li>
                <li id="24"><a href="#">Last</a></li>
            </ul>
        </div>
    </div>
    <div class="grid_3 clearfix">
        <nav class="lst-category">
            <h2 class="title-welcome rs">Kategori</h2><br/>
            <?php include"function/list-category.php"; ?> 
            <p class="rs view-all-category">
                <a href="#category" id="category" class="be-fc-orange">+ Lihat semua kategori</a>
            </p>
        </nav>
    </div>
    <div class="clear clear-2col"></div>
</div>
<script language="javascript"  type="text/javascript" src="component/all-project/all-project.js"></script>
