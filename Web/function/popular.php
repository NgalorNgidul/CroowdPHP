<?php
$data = bacaHTML('prospect/popular');
$rows = json_decode($data);
?>

<div class="container_12">
    <div class="grid_12 wrap-title">
        <h2 class="common-title">Proyek <span class="fc-orange">Populer</span></h2>
        <!--<a class="be-fc-orange" href="?content=all-project">Lihat semua</a>-->
    </div>
    <div class="clear"></div>
    <div class="lst-popular-project clearfix" id="popular-project">
        <div class="clear clear-2col"></div>
    </div>
</div>
<script language="javascript"  type="text/javascript" src="js/popular.js"></script>