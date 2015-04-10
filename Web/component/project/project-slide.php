<h2 class="rs project-title"><?= $data->title; ?></h2>
<p class="rs post-by">oleh <a href="#"><?= $data->ownerName; ?></a></p>
<div class="project-short big-thumb">
    <div class="top-project-info">
        <div class="content-info-short clearfix">
            <div class="thumb-img">
                <div class="rslides_container">
                    <?php
                                if ($rows[$i]->picture == null) {
                                    $srcimg = 'images/no-image.png';
                                } else {
                                    $srcimg = $data->smallImage;
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
        <div class="project-progress sys_circle_progress" data-percent="<?= $data->pledgedPersentage; ?>">
            <div class="sys_holder_sector"></div>
        </div>
        <div class="group-fee clearfix">
            <div class="fee-item">
                <p class="rs lbl">Investor</p>
                <span class="val">270</span>
            </div>
            <div class="sep"></div>
            <div class="fee-item">
                <p class="rs lbl">Terkumpul</p>
                <span class="val">Rp <?= amountToStr($data->principal); ?></span>
            </div>
            <div class="sep"></div>
            <div class="fee-item">
                <p class="rs lbl">Hari Tersisa</p>
                <span class="val"><?= $data->remainingDay; ?></span>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>