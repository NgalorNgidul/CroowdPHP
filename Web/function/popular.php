<?php
$data = bacaHTML('api/prospect/popular');
$rows = json_decode($data);
?>

<div class="container_12">
    <div class="grid_12 wrap-title">
        <h2 class="common-title">Proyek Populer</h2>
        <a class="be-fc-orange" href="category.html">Lihat semua</a>
    </div>
    <div class="clear"></div>
    <div class="lst-popular-project clearfix">
        <?php
        for ($i = 0; $i < count($rows); $i++) {
            ?>
            <div class="grid_3">
                <div class="project-short sml-thumb">
                    <div class="top-project-info">
                        <div class="content-info-short clearfix">
                            <a href="?content=project&title=<?= $rows[$i]->title;?>" class="thumb-img">
                                <?php
                                if ($rows[$i]->picture == null) {
                                    $srcimg = 'images/no-image.png';
                                } else {
                                    $srcimg = $rows[$i]->picture;
                                }
                                ?>
                                <img src="<?=$srcimg;?>" alt="$TITLE" width="292" height="204">
                            </a>
                            <div class="wrap-short-detail">
                                <h3 class="rs acticle-title"><a class="be-fc-orange" href="?content=project&title=<?= $rows[$i]->title;?>"><?= $rows[$i]->title; ?></a></h3>
                                <p class="rs tiny-desc">oleh <a href="profile.html" class="fw-b fc-gray be-fc-orange"><?= $rows[$i]->ownerName; ?></a></p>
                                <p class="rs title-description"><?= $rows[$i]->shortDescription; ?></p>
                                <p class="rs project-location">
                                    <i class="icon iLocation"></i>
                                    <?= $rows[$i]->location; ?>, <?= $rows[$i]->province; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-project-info clearfix">
                        <div class="line-progress">
                            <div class="bg-progress">
                                <span  style="width: 50%"></span>
                            </div>
                        </div>
                        <div class="group-fee clearfix">
                            <div class="fee-item">
                                <p class="rs lbl">Inv</p>
                                <span class="val">50%</span>
                            </div>
                            <div class="sep"></div>
                            <div class="fee-item">
                                <p class="rs lbl">Nilai</p>
                                <span class="val">Rp <?= amountToStr($rows[$i]->principal); ?></span>
                            </div>
                            <div class="sep"></div>
                            <div class="fee-item">
                                <p class="rs lbl">Hari</p>
                                <span class="val">25</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end: .grid_3 > .project-short-->
            <?php
        }
        ?>
        <div class="clear clear-2col"></div>

    </div>
</div>
