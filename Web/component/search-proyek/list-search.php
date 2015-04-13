<div class="list-project-result" id="list-search-ajax">
    <?php
    for ($i = 0; $i < count($rows); $i++) {
        ?>
        <div class="project-short larger">
            <div class="top-project-info">
                <div class="content-info-short clearfix">
                    <a class="thumb-img" href="#">
                        <img alt="$TITLE" src="<?= $rows[$i]->smallImage; ?>">
                    </a>
                    <div class="wrap-short-detail">
                        <h3 class="rs acticle-title"><a href="#" class="be-fc-orange"><?= $rows[$i]->title; ?></a></h3>
                        <p class="rs tiny-desc">oleh <a class="fw-b fc-gray be-fc-orange" href="#"><?= $rows[$i]->ownerName; ?></a> in <span class="fw-b fc-gray"><?= $rows[$i]->location; ?>, <?= $rows[$i]->province; ?></span></p>
                        <p class="rs title-description"><?= $rows[$i]->shortDescription; ?></p>
                    </div>
                    <p class="rs clearfix comment-view">
                        <a class="fc-gray be-fc-orange" href="#">75 comments</a>
                        <span class="sep">|</span>
                        <a class="fc-gray be-fc-orange" href="#">378 views</a>
                    </p>
                </div>
            </div>
            <div class="bottom-project-info clearfix">
                <div class="project-progress sys_circle_progress" data-percent="<?= $rows[$i]->pledgedPersentage;?>">
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
                        <span class="val">Rp. <?= $rows[$i]->pledged; ?></span>
                    </div>
                    <div class="sep"></div>
                    <div class="fee-item">
                        <p class="rs lbl">Hari Tersisa</p>
                        <span class="val"><?= $rows[$i]->remainingDay; ?></span>
                    </div>
                </div>
                <a href="#" class="btn btn-red btn-buck-project">Buck this project</a>
                <div class="clear"></div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
$(function () {
    progress();
});
</script>