
<div class="layout-2cols">
    <div class="content grid_8">
        <div class="single-page">
            <div class="wrapper-box box-post-comment">
                <h2 class="common-title">Cari Pinjaman</h2>
                <div class="box-white">
                    <?php
                    if ($_COOKIE['simbiosis'] == null && $_GET['bungapilih'] != null) {
                        echo '<span style="color:red;font-weight:bold;">Maaf Anda harus melakukan sign in terlebih dahulu</span>';
                    }
                    ?>
                    <form id="loan-form" class="clearfix" action="#" onsubmit="return sendButton();">
                        <p class="rs pb30">offers low rate loans with no early repayment fees..</p>
                        <div class="form form-post-comment">
                            <div class="left-input">
                                <label for="txt_get_loan">
                                    <input id="txt_get_loan" type="text" name="loan" 
                                           class="txt fill-width txt-name" style="text-align: right;font-size: 16px;font-weight: bold;" 
                                           onkeyup="itemTerm();" value="<?= 1000000; ?>"/>
                                    <span style="color: red;" id="messagefieldmax">maximum money 100,000,000 IDR</span>

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
                                            <th>APR</th>
                                            <th>Montly Cost</th>
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

                                <input type="submit" class="btn btn-blue btn-submit-comment" id="buttonsend" style="color:white;" value="Get a Quote">
                            </p>
                        </div>

                        <input type="hidden" name="termpilih" id="termpilih" value="" />
                        <input type="hidden" name="bungapilih" id="bungapilih" value="" />
                        <input type="hidden" name="perbulanpilih" id="perbulanpilih" value="" />
                    </form>
                </div>
            </div><!--end: .box-list-comment -->
        </div>
    </div><!--end: .content -->
    <div class="sidebar grid_4">
        <div class="box-gray">
            <h3 class="title-box">Contact info</h3>
            <p class="rs description pb20">Pellentesque laoreet sapien id lacus luctus non fringilla elit lobortis. Fusce augue diam, tempor posuere pharetra sed, feugiat non sapien.</p>
            <p class="rs pb20">
                <span class="fw-b">Address</span>: 111 lorem St. 5th Floor,
                Ipsum City, MA 00001
            </p>
            <p class="rs pb20">
                <span class="fw-b">Phone</span>: +1 (555) 55-55-555
                (9AM - 6PM EST)
            </p>
            <p class="rs pb20">
                <span class="fw-b">Email</span>: <a href="mailto:info@megadrupal.com" class="be-fc-orange">info@megadrupal.com</a>
            </p>
        </div>
    </div><!--end: .sidebar -->
    <div class="clear"></div>
</div>

<script language="javascript"  type="text/javascript" src="component/cari-pinjaman/cari-pinjaman.js"></script>
