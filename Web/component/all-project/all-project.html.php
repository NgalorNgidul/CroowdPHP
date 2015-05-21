<?php
$data = bacaHTML('prospect/popular');
$rows = json_decode($data);
?>

<div class="container_12 lst-popular-project clearfix" style="margin-top: 20px;">
    <!--    <div class="grid_12 wrap-title">
            <h3 class="common-title">Semua <span class="fc-orange">Project</span></h3>
        </div>-->
    <div class="clear"></div>
    <div class="grid_9">
        <div class="grid_12 wrap-title">
            <h3 class="common-title" style="margin-bottom: 10px;">Semua <span class="fc-orange">Project</span></h3>
        </div>
        <?php
        for ($i = 0; $i < 3; $i++) {
            ?>
            <div class="grid_4">
                <div class="project-short sml-thumb">
                    <div class="top-project-info">
                        <div class="content-info-short clearfix">
                            <a href="?content=project&id=<?= $rows[$i]->id; ?>" class="thumb-img">
                                <?php
                                if ($rows[$i]->smallImage == null) {
                                    $srcimg = 'images/no-image.png';
                                } else {
                                    $srcimg = $rows[$i]->smallImage;
                                }
                                ?>
                                <img src="<?= $srcimg; ?>" alt="$TITLE" width="292" height="204" style="height:135px !important;width:204px !important">
                            </a>
                            <div class="wrap-short-detail">
                                <h3 class="rs acticle-title"><a class="be-fc-orange" href="?content=project&id=<?= $rows[$i]->id; ?>"><?= $rows[$i]->title; ?></a></h3>
                                <p class="rs tiny-desc">oleh <a href="?content=profile&id=<?= $rows[$i]->ownerId; ?>" class="fw-b fc-gray be-fc-orange"><?= $rows[$i]->ownerName; ?></a></p>
                                <!--<p class="rs title-description"><?= $rows[$i]->shortDescription; ?></p>-->
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
                                <span  style="width: <?= $rows[$i]->pledgedPersentage; ?>%"></span>
                            </div>
                        </div>
                        <div class="group-fee clearfix">
                            <div class="fee-item">
                                <p class="rs lbl">Inv</p>
                                <span class="val"><?= $rows[$i]->pledgedPersentage; ?>%</span>
                            </div>
                            <div class="sep"></div>
                            <div class="fee-item">
                                <p class="rs lbl">Target</p>
                                <span class="val">Rp <?= amountToStr($rows[$i]->principal); ?></span>
                            </div>
                            <div class="sep"></div>
                            <div class="fee-item">
                                <p class="rs lbl">Hari</p>
                                <span class="val"><?= $rows[$i]->remainingDay; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end: .grid_3 > .project-short-->
            <?php
        }
        ?>
    </div>
    <div class="grid_3 clearfix">
        <nav class="lst-category">
            <h2 class="title-welcome rs">Category</h2><br/>
            <?php include"function/list-category.php"; ?> 
            <p class="rs view-all-category">
                <a href="#category" id="category" class="be-fc-orange">+ View all categories</a>
            </p>
        </nav>
    </div>
    <div class="clear clear-2col"></div>
</div>
