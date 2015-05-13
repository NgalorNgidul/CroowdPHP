<?php include"function/header-banner.php"; ?>

<!--end: #home-slider -->
<div class="home-feature-category">
    <div class="container_12 clearfix">
        <div class="grid_8 marked-category">
            <?php include "function/latest-news.php"; ?>
        </div><!--end: .marked-category -->
        <div class="grid_4 left-lst-category">
            <div class="wrap-lst-category">
                <h3 class="title-welcome rs">Welcome to Croowdfunding!</h3>
                <p class="description rs">Pellentesque laoreet sapien id lacus luctus non fringilla elit lobortis. Fusce augue diam, tempor posuere pharetra sed, feugiat non sapien.</p>
                <nav class="lst-category">
                    <?php include"function/list-category.php"; ?> 
                    <p class="rs view-all-category">
                        <a href="#category" id="category" class="be-fc-orange">+ View all categories</a>
                    </p>
                </nav><!--end: .lst-category -->
            </div>  
        </div><!--end: .left-lst-category --> 
        <div class="clear"></div>
    </div>
</div><!--end: .home-feature-category -->

<div class="home-popular-project">
    <?php include "function/popular.php"; ?>
</div><!--end: .home-popular-project -->
<?php include "function/latest-project.php"; ?>
<!--end: .additional-info-line -->