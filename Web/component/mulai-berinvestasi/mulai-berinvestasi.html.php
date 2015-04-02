<?php
if ($_COOKIE['simbiosis'] == null) {
    

?>
<div class="layout-2cols">
    <div class="content grid_8">
        <div class="single-page">
            <div class="wrapper-box box-post-comment">
                <h2 class="common-title">Mulai Berinvestasi</h2>
                <div class="box-white">

                    <?php
                    echo '<span style="color:red;font-weight:bold;">Maaf Anda harus melakukan sign in terlebih dahulu <a href="javascript:void(0);" onclick="popLogin();" class="sys_show_popup_login">klik disini ...</a></span>';
                    include 'component/register/register_new.html.php'
                    ;
                    ?>
                </div>
            </div><!--end: .box-list-comment -->
        </div>
    </div><!--end: .content -->

    <div class="clear"></div>
</div>
<?php } else { ?>
<?php
                    include 'component/mulai-berinvestasi/mulai-berinvestasi2.html.php'
                    ;
                    ?>
<?php } ?>
<script language="javascript"  type="text/javascript" src="component/mulai-berinvestasi/mulai-berinvestasi.js"></script>
