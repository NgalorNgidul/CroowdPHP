<?php
if ($_COOKIE['simbiosis'] == null) {
    

?>
<div class="layout-2cols">
    <div class="content grid_8">
        <div class="single-page">
            <div class="wrapper-box box-post-comment">
                <h2 class="common-title">Mulai Berinvestasi</h2>
                <div class="box-white">
		    <h4 class="rs title-box">Untuk investor</h4>
                    <p class="rs">Untuk menjadi investor pada Croowd anda cukup mengisi nama lengkap dan alamat email. Selanjutnya kami akan mengirimkan email untuk memvalidasi data anda.</p>
                    <?php
                    include 'component/register/register_new.html.php'
                    ;
                    ?>
                </div>
            </div><!--end: .box-list-comment -->
        </div>
    </div><!--end: .content -->
    <div class="sidebar grid_4">
        <div class="box-gray">
            <h3 class="title-box">Kontak</h3>
            <p class="rs description pb20">Hubungi kami untuk keterangan lainnya di</p>
            <p class="rs pb20">
                <span class="fw-b">Alamat</span>: PT. DIGI LARAS PROSPERINDO, Epicentrum Walk Office Suite 7th Floor Unit 0709A, Jl. H R Rasuna Said, Jakarta 12960
            </p>
            <p class="rs pb20">
                <span class="fw-b">Telp</span>: +62 (21) 55-55-555
                (09.00 - 15.00)
            </p>
            <p class="rs pb20">
                <span class="fw-b">Email</span>: <a href="mailto:info@croowd.co.id" class="be-fc-orange">info@croowd.co.id</a>
            </p>
        </div>
    </div><!--end: .sidebar -->
    <div class="clear"></div>
</div>

    <div class="clear"></div>
</div>
<?php } else { ?>
<?php
                    include 'component/mulai-berinvestasi/mulai-berinvestasi2.html.php'
                    ;
                    ?>
<?php } ?>

<script language="javascript"  type="text/javascript" src="component/mulai-berinvestasi/mulai-berinvestasi.js"></script>
