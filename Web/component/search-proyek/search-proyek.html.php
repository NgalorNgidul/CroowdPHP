<div class="layout-2cols">
    <div class="content grid_12">
        <div class="search-result-page">
            <div class="top-lbl-val">
                <h3 class="common-title">Menemukan / <span class="fc-orange">Mencari</span></h3>
                <div class="count-result">
                    <span class="fw-b fc-black" id="recordall"></span> Hasil Pencarian dari “<span class="fw-b fc-black"><?=$_GET['parameter'];?></span>”
                </div>
                <div class="confirm-search">Apakah Anda mencari proyek-proyek di <a class="fw-b be-fc-orange" href="#"><?=$_GET['parameter'];?></a>?</div>
            </div>
            <span id="listsearchjax">
                
            </span>
            
            <input type="hidden" value="10" id="totalitem" />
            <input type="hidden" value="0" id="previtem" />
            <input type="hidden" value="3" id="nextitem" />
            <p class="rs ta-c">
                <a href="javascript:void(0);" onclick="listItem(3);" class="btn btn-black btn-load-more" id="showmoreresults">Show more projects</a>
            </p>
        </div><!--end: .search-result-page -->
    </div><!--end: .content -->
    <?php // include 'component/search-proyek/sidebar.php'; ?>
    <div class="clear"></div>
</div>