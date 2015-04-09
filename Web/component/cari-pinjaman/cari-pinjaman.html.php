
<div class="layout-2cols">
    <div class="content grid_8">
        <div class="single-page">
            <div class="wrapper-box box-post-comment">
                <h2 class="common-title">Cari Pinjaman</h2>
                <div class="box-white">
                    <?php
                    if ($_COOKIE['simbiosis'] == null && $_GET['term'] != null && $_GET['value'] != null) {
                      //  echo '<span style="color:red;font-weight:bold;">Maaf Anda harus melakukan sign in terlebih dahulu</span>';
                    
                        
                         include 'component/register/register_new.html.php';
                    } else {
                    ?>
                    <form id="loan-form" class="clearfix" action="#" onsubmit="return sendButton();">
                        <p class="rs pb30">Croowd menawarkan pinjaman dengan prinsip syariah (Murabahah) dan menawarkan marjin yang kecil. Masukkan kebutuhan dana untuk proyek anda pada field di bawah ini.</p>
                        <div class="form form-post-comment">
                            <div class="left-input">
                                <label for="txt_get_loan">
                                    <input id="txt_get_loan" type="text" name="loan" 
                                           class="txt fill-width txt-name" style="text-align: right;font-size: 16px;font-weight: bold;" 
                                           onkeyup="itemTerm();" value="<?= 1000000; ?>"/>
                                    <span style="color: red;" id="messagefieldmax">jumlah maksimal Rp 100,000,000</span>

                                </label>
                            </div>
                            <div class="right-input">
                                <h2> IDR </h2>


                            </div>
                            <div class="clear"></div>
                            <div id="customers" class="editor-content">

                                <table style="width: 100%;" class="table">
                                    <thead>
                                        <tr>
                                            <th>Term</th>
                                            <th>Marjin</th>
                                            <th>Angsuran</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemTerm">

                                    </tbody>
                                </table>
                                <input type="hidden" id="totalitem" value="5"/>

                            </div>
                            <br />
                            <p class="rs ta-r clearfix">
                                <span id="response"></span>

                                <input type="submit" class="btn btn-blue btn-submit-comment" id="buttonsend" style="color:white;" value="Kirim">
                            </p>
                        </div>

                        <input type="hidden" name="termpilih" id="termpilih" value="" />
                        <input type="hidden" name="bungapilih" id="bungapilih" value="" />
                        <input type="hidden" name="perbulanpilih" id="perbulanpilih" value="" />
                    </form>
                    <?php } ?>
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

<script language="javascript"  type="text/javascript" src="component/cari-pinjaman/cari-pinjaman.js"></script>
