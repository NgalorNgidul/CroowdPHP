<h2 class="rs project-title"><?= $rows[$i]->title; ?></h2>
<p class="rs post-by">by <a href="#"><?= $rows[$i]->ownerName; ?></a></p>
<div class="project-short big-thumb">
    <div class="top-project-info">
        <div class="content-info-short clearfix">
            <div class="thumb-img">
                <div class="rslides_container">
                    <?php
                                if ($rows[$i]->picture == null) {
                                    $srcimg = 'images/no-image.png';
                                } else {
                                    $srcimg = $rows[$i]->picture;
                                }
                                ?>
                    <ul class="rslides" id="slider1">
                        <li><img  width="552" height="411"  src="<?=$srcimg;?>" alt=""></li>
                        <li><img width="552" height="411"  src="<?=$srcimg;?>" alt=""></li>
                        <li><img width="552" height="411" src="<?=$srcimg;?>" alt=""></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!--end: .top-project-info -->
    <div class="bottom-project-info clearfix">
        <div class="project-progress sys_circle_progress" data-percent="87">
            <div class="sys_holder_sector"></div>
        </div>
        <div class="group-fee clearfix">
            <div class="fee-item">
                <p class="rs lbl">Bankers</p>
                <span class="val">270</span>
            </div>
            <div class="sep"></div>
            <div class="fee-item">
                <p class="rs lbl">Pledged</p>
                <span class="val">Rp <?= amountToStr($rows[$i]->principal); ?></span>
            </div>
            <div class="sep"></div>
            <div class="fee-item">
                <p class="rs lbl">Days Left</p>
                <span class="val">25</span>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>