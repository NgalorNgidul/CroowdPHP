<div class="layout-2cols">
    <div class="content grid_12">
        <div class="single-page">
            <div class="wrapper-box box-post-comment">
                <h2 class="common-title"></h2>
                <div class="box-white" style="text-align: justify;text-justify: inter-word;">
                    <?php
                    if ($response == '') {
                        echo 'Terima Kasih anda sudah melakukan pendaftarann, redirect halaman klik <a href='.'>disini</a>';
                        echo "<script>setTimeout(\"location.href = '?content=" . $_GET['content'] . "';\",5000);</script>";
                    } else {
                        echo 'Gagal Melakukan Pendaftaran, redirect halaman klik <a href='.'>disini</a>';
                        echo "<script>setTimeout(\"location.href = '?content=" . $_GET['content'] . "';\",5000);</script>";
                    }
                    ?>
                </div>
            </div>
        </div><!--end: .box-list-comment -->
    </div>
</div><!--end: .content -->

<div class="clear"></div>
</div>