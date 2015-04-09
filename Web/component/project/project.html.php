<?php
$data = bacaHTML('api/prospect/popular');
$rows = json_decode($data);
?>
<?php
for ($i = 0; $i < count($rows); $i++) {
    if ($rows[$i]->title == $_GET['title']) {
        ?>
        <div class="layout-2cols">
            <div class="content grid_8">
                <div class="project-detail">
                    <?php include './component/project/project-slide.php'; ?>
                    <?php include './component/project/project-desc.php'; ?>
                </div>
            </div><!--end: .content -->
            <?php include './component/project/project-left.php'; ?>
            <div class="clear"></div>
        </div>
        <?php
    }
}

?>