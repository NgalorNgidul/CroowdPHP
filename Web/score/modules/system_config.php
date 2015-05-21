<?php

define('dbName', 'SCORING_APP');
define('dbUser', 'sa');
define('dbPass', 'admin');
define('dbHost', '10.2.109.166,1433');

$SQLDBName          = "hudanet_score";
$SQLUser            = "hudan_db";
$SQLPass            = "hud4n_db";
//$SQLUser            = "ba_scoringapp";
//$SQLPass            = "ba_scoringapp123!";
//$SQLHost            = "10.2.109.166,1433";
//$SQLHost            = "10.1.30.13";
$SQLHost            = "10.57.58.2\SQL2012,779";

$connectionInfo = array( "Database"=>$SQLDBName, "UID"=>$SQLUser, "PWD"=>$SQLPass );

//ini_set("SMTP", "10.1.50.20");
//ini_set("smtp_port", 25);

$app_name     = "SMALL BUSINESS SCORING";
$app_version  = "Ver 1.0";
$pMainTitel   = "..::: $app_name $app_version :::..";
$app_develop  = "Yan Achsri";
$msgDBSave    = "<b>..::: Data Sudah Disimpan :::..<b>";
$msgDBUpdate  = "<b>..::: Data Sudah TerUpdate :::..<b>";
$msgDBNotFind = "<b>..::: Maaf Data Tidak Ditemukan :::..<b>";
$msgDBError = "<b>..::: Maaf Data Tidak Tersimpan :::..<b>";
$msgDataHapusOK = "<b>..::: Data Terhapus :::..</b>";
$msgDivisiDTI = "<font color='#999999' size='1'>| <a href=''>Home</a> | $app_name ";
$msgDivisiDTI .= "<b>Copyright © 2013 $app_version</b></font>";
$right = "artascore.com";
$mailfromAdmin = "admin@bsm.co.id";
$app_division = "artascore.com";

$ANGKA_KOMA = "onKeyPress=\"if (event.keyCode > 57 || event.keyCode < 46 || event.keyCode == 47) event.returnValue = false;\"";
$ANGKA = "onKeyPress=\"if (event.keyCode > 58 || event.keyCode < 47) event.returnValue = false; \" onFocus=\"this.select();\"";
$HURUF = "onKeyPress=\"if(event.keyCode==34 || event.keyCode==39) event.returnValue = false;\"";
$LOCK_INPUT = "onKeyDown=\"event.returnValue = false;\"";
$LOCK_CLICK = "onClick=\"event.returnValue = false;\"";

$BUTTON_KIRI = "<a href='javascript:history.go(-1)'><img src=\"includes/page_main/img/button_back.gif\" border='0' alt='<<< Back'></a>" ;
$BUTTON_KANAN = "<a href='javascript:history.go(+1)'><img src=\"includes/page_main/img/button_forward.gif\" border='0' alt='Forward >>>'></a>" ;
$BUTTON_BACK = $BUTTON_KIRI;

$Title_Link = "onMouseOver=\"window.status='Click me';return true;\" onMouseOut=\"window.status='';return true;\" ";

//------------------------------------------------------------------------------

$STAT_CAB=ARRAY();
$STAT_CAB[1]="CABANG";
$STAT_CAB[2]="KCP";
$STAT_CAB[3]="KKAS";
$STAT_CAB[9]="ADMIN";
$STAT_CAB[99]=3;

$KET_MENU = ARRAY();
$KET_MENU[0] = "CONTROL";
$KET_MENU[1] = "SETUP";
$KET_MENU[7] = "COLLATERAL";
$KET_MENU[2] = "RISK ACCEPTANCE CRITERIA";
$KET_MENU[3] = "LAPORAN KEUANGAN";
$KET_MENU[4] = "RASIO KEUANGAN";
$KET_MENU[5] = "APLIKASI";
$KET_MENU[6] = "RUMUS SCORING";
$KET_MENU[8] = "MINIMUM SCORE";
$KET_MENU[9] = "PRICE";
$KET_MENU[10]= "VERIFIKATOR";
#$KET_MENU[2] = "PENOMORAN DOKUMEN";
#$KET_MENU[3] = "PROTOKOLER";
#$KET_MENU[4] = "REIMBURSEMENT";
#$KET_MENU[5] = "AGENDA DOA PAGI";
#$KET_MENU[6] = "EVENT CABANG";
#$KET_MENU[7] = "MEMBERSHIP";

$_UNITLOCATION   = array("0001"=>"1. Kantor Pusat","0002"=>"2. Kantor Cabang","0003"=>"3. Kantor Cabang Pembantu","0004"=>"4. Kantor Kas");
$_EMAILEVENTPUSAT  = "alamatemail@bsm.co.id";
$_MAX_REC_PER_PAGE  = 10;

$_STATUS  = array("1"=>"AKTIF", "2"=>"SENT", "3"=>"VERIFIED", "99"=>"DELETE");
//status 4 kalo nilainya udah keluar

$_JPERMOHONAN = array("1"=>"Baru","2"=>"Penambahan","3"=>"Perpanjangan","4"=>"Review diskon margin");

$_PENDIDIKAN  = array("1"=>"SD/Sederajat","2"=>"SMP/Sederajat","3"=>"SMA/Sederajat","4"=>"Diploma","5"=>"S1","6"=>"S2","7"=>"S3");

$_BADANUSAHA  = array("1"=>"Perorangan","2"=>"CV/Firma","3"=>"PT","4"=>"Koperasi","5"=>"Program KUR Non-Linkage","6"=>"Lainnya");

$_YATIDAK     = array("1"=>"YA","2"=>"TIDAK");

$_LAMAHUB     = array("1"=>"BARU","2"=>"< 1 TAHUN","3"=>"1 - 2 TAHUN","4"=>"2 - 3 TAHUN","5"=>"3 - 4 TAHUN","6"=>"4 - 5 TAHUN","7"=>"> 5 TAHUN");

$_NERACAKET   = array("1"=>"Audited","2"=>"Inhouse");


$_APPFIELD    = array(
                  "APPLICATION_NUMBER"=>"Nomor Aplikasi",
                  "APPLICATION_AONAME"=>"Nama Lengkap AO",
                  "APPLICATION_CABANG"=>"Cabang",
                  "APPLICATION_CIFNO"=>"No. CIF Pemohon",
                  "APPLICATION_DATE"=>"Tanggal Permohonan",
                  "APPLICATION_JENIS"=>"Jenis Permohonan",
                  "APPLICATION_CIFNAME"=>"Nama Pemohon",
                  "APPLICATION_BADANHUKUM"=>"Badan Usaha",
                  "APPLICATION_USIA"=>"Usia Pemilik / Direkur (Key Person)",
                  "APPLICATION_PENDIDIKAN"=>"Pendidikan Terakhir Pemilik/Direkur",
                  "APPLICATION_TELEPON"=>"Telepon",
                  "APPLICATION_JUSAHA"=>"Jenis Usaha",
                  "APPLICATION_JMLKARYAWAN"=>"Jumlah Karyawan",
                  "APPLICATION_ALAMAT"=>"Alamat",
                  "APPLICATION_LUSAHA"=>"Lama Usaha",
                  "APPLICATION_LAMAHUB"=>"Lama Berhubungan dengan BSM",
                  "APPLICATION_OTHERFINANCE"=>"Memiliki Pembiayaan di Bank Lain",
                  "APPLICATION_TENOR"=>"Jangka Waktu Pembiayaan",
                  "APPLICATION_PLAFOND"=>"Plafond Pembiayaan",
                  "APPLICATION_LAGUNAN"=>"Total Nilai Likuidasi Agunan",
                  "APPLICATION_COLCOV"=>"Colateral Coverage"
                );
$min_skor = "462";

$_CollType      = array("0001"=>"Agunan Utama",
                        "0002"=>"Agunan Tambahan");


?>
