<?php
    $data = NULL;
    $rows = json_decode($data);
?>

<div class="container_12 lst-popular-project clearfix" style="margin-top: 20px;">
    <!--    <div class="grid_12 wrap-title">
            <h3 class="common-title">Semua <span class="fc-orange">Project</span></h3>
        </div>-->
    <div class="clear"></div>
    <div class="grid_9" id="all-project">
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
