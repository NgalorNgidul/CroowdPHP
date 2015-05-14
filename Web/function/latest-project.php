<?php
$data = bacaHTML('prospect/popular');
$rows = json_decode($data);
?>

<div class="container_12 home-discover-friends" style="padding:30px 0px 50px 0px !important;">
    <div class="grid_12 wrap-title">
        <h2 class="common-title" style="float:left">Proyek <span class="fc-orange">Terbaru</span></h2>
        <a class="be-fc-orange" href="?content=all-project" style="float:right;margin-top: 10px !important">Lihat semua</a>
    </div>
    <div class="clear"></div>
    <div class="lst-popular-project clearfix" style="margin:0px 0px -50px 0px !important;">
        <?php
        for ($i = 0; $i < count($rows); $i++) {
            ?>
            <div class="grid_3">
                <div class="project-short sml-thumb">
                    <div class="top-project-info">
                        <div class="content-info-short clearfix">
                            <a href="?content=project&id=<?= $rows[$i]->id;?>" class="thumb-img">
                                <?php
                                if ($rows[$i]->smallImage == null) {
                                    $srcimg = 'images/no-image.png';
                                } else {
                                    $srcimg = $rows[$i]->smallImage;
                                }
                                ?>
                                <img src="<?=$srcimg;?>" alt="$TITLE" width="292" height="204">
                            </a>
                            <div class="wrap-short-detail">
                                <h3 class="rs acticle-title"><a class="be-fc-orange" href="?content=project&id=<?= $rows[$i]->id;?>"><?= $rows[$i]->title; ?></a></h3>
                                <p class="rs tiny-desc">oleh <a href="?content=profile&id=<?= $rows[$i]->ownerId;?>" class="fw-b fc-gray be-fc-orange"><?= $rows[$i]->ownerName; ?></a></p>
                                <!--<p class="rs title-description"><?= $rows[$i]->shortDescription; ?></p>-->
                                <p class="rs project-location">
                                    <i class="icon iLocation"></i>
                                    <?= $rows[$i]->location; ?>, <?= $rows[$i]->province; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end: .grid_3 > .project-short-->
            <?php
        }
        ?>
        <div class="clear"></div>
    </div>
</div><!--end: .home-discover-friends -->