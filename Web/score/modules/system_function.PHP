<script language="JavaScript">
 function openNewWindow(url) {
 popupWin = window.open(url, 'open_window', 'scrollbars, resizable, dependent, width=800, height=200, left=100, top=80')
 }


 function openNewWindow2(url) {
 popupWin = window.open(url, 'open_window', 'scrollbars, resizable, dependent, width=500, height=220, left=100, top=80')
 }
 </script>
<?
//------------------------------------------------------------------------------
Function Awal_Html($cmd,$ISI){
GLOBAL $pMainTitel, $msgDivisiDTI, $COOK_USERUNIT, $COOK_USER_NAME,$COOK_DIVISION_ID, $COOK_BRANCH_ID, $app_name, $_UNITNAME ;
$template1 = Array();
$replace1 = Array();
$nmFile = "includes/page_main/page.html";
//$pict = "<IMG src='includes/page_main/img/logobsm.jpg' border=0 cellPadding=0 cellSpacing=0>";

$template1[0] = "[--IMG1--]";
$template1[1] = "[--IMG2--]";
$template1[2] = "[--TITLE--]";
$template1[3] = "[--HEADER--]";
$template1[4] = "[--ISI1--]";
$template1[5] = "[--ISI2--]";
$template1[6] = "[--COPYRIGHT--]";

$replace1[0] = $pict ;
$replace1[1] = "<font class=\"header_top\">$app_name</font>";
$replace1[2] = $pMainTitel;
$replace1[3] = DATE("r")." [ $COOK_USER_NAME ] ".$_UNITNAME[$COOK_USERUNIT]; 
$replace1[4] = Sediakan_MenuNya($cmd);
$replace1[5] = $ISI;
$replace1[6] = $msgDivisiDTI;

RETURN Template_Formnya($template1,$replace1,$nmFile);
}

//------------------------------------------------------------------------------
Function SIMPAN_FILE($nmfolder,$newnmfile){
$iFILE=ARRAY();
$frm_file = $_FILES['frm_file']['tmp_name'];
$nama_file = $_FILES['frm_file']['name'];
  IF($nama_file!=""){
          //$itipe = strtolower(Ambil_Tipe_File($nama_file));
          //@copy("modules/lembur.xls", "xx.xls");
          @copy($frm_file, $nmfolder.$newnmfile.$itipe);
  }
  $iFILE[0]->TIPE=$itipe;
  $iFILE[0]->NAMA=$newnmfile;
  $iFILE[0]->FULLNAME=$newnmfile.$itipe;
  RETURN $iFILE ;
}
//------------------------------------------------------------------------------
Function TulisKeTextFile($isiText,$nmFile){
  $pFile = fopen($nmFile,"w");
  $pData = fwrite($pFile, $isiText);
  fclose($pFile);
}
//------------------------------------------------------------------------------
function MF_GetFile($pFileName){
	$pFile		= fopen($pFileName,"r");
	$pFileLine 	= "";
	while (!feof ($pFile)) $pFileLine .= fgets($pFile, 4096);
  fclose($pFile);
	return $pFileLine;
}
//------------------------------------------------------------------------------

Function BuatJavaScript_CekInputan_new($nmInput,$nmStyle){
$page = "<SCRIPT LANGUAGE=\"JAVASCRIPT\">
          function Trim(strTrim){	return RTrim(LTrim(strTrim));}
          function LTrim(strTrim){
            while( strTrim.indexOf(' ') == 0 ){ strTrim = strTrim.substring(1) }
            return strTrim;
          }
          function RTrim(strTrim){
          	while( strTrim.lastIndexOf(' ') == strTrim.length-1 && strTrim.length > 0 ){ strTrim = strTrim.substring(0,strTrim.length-1) }
          	return strTrim;
          }
          </SCRIPT>";

$page .= "<SCRIPT LANGUAGE=\"JAVASCRIPT\">";
$page .= "function cekInput(formnya){ nil=0; ";

$i=0;
WHILE($i < COUNT($nmInput)){
  $page .= "
  sname = new String();
  sname = '".$nmStyle[$i]."';
  uname = new String();
  uname = formnya.$nmInput[$i];

  if(sname == \"\")
  {
       ValName = Trim(formnya.$nmInput[$i].value) ;
       if ( ValName == \"\" )
       {
          alert (\"Maaf, data harus diisi!\");
          uname.value = ValName;
          uname.focus();
          return false;
       }
       else
       {
          nil = nil + 1;
       }
  }
  else if(document.getElementById(sname).style.display != \"none\")
  {
       ValName = Trim(formnya.$nmInput[$i].value) ;
       if ( ValName == \"\" )
       {
          alert (\"Maaf, data harus diisi!\");
          uname.value = ValName;
          uname.focus();
          return false;
       }
       else
       {
          nil = nil + 1;
       }
  }
  else
  {
    nil = nil + 1;
  }";
  $i++;
}

$page .= "if(nil == ".COUNT($nmInput)."){formnya.submit();}";
$page .= "}";
$page .= "</SCRIPT>";

RETURN $page ;
}
//------------------------------------------------------------------------------

Function BuatJavaScript_CekInputan($nmInput){
$page = "<SCRIPT LANGUAGE=\"JAVASCRIPT\">
          function Trim(strTrim){	return RTrim(LTrim(strTrim));}
          function LTrim(strTrim){
            while( strTrim.indexOf(' ') == 0 ){ strTrim = strTrim.substring(1) }
            return strTrim;
          }
          function RTrim(strTrim){
          	while( strTrim.lastIndexOf(' ') == strTrim.length-1 && strTrim.length > 0 ){ strTrim = strTrim.substring(0,strTrim.length-1) }
          	return strTrim;
          }
          </SCRIPT>";

$page .= "<SCRIPT LANGUAGE=\"JAVASCRIPT\">";
$page .= "function cekInput(formnya){ nil=0; ";

$i=0;
WHILE($i < COUNT($nmInput)){
  $page .= "
     uname = new String();
     uname = formnya.$nmInput[$i];

       ValName = Trim(formnya.$nmInput[$i].value) ;

       if ( ValName == \"\" )
       {
          alert (\"Maaf, data harus diisi!\");
          uname.value = ValName;
          uname.focus();
          return false;
       }
       else
       {
          nil = nil + 1;
       }
    ";
  $i++;
}

$page .= "if(nil == ".COUNT($nmInput)."){formnya.submit();}";
$page .= "}";
$page .= "</SCRIPT>";

RETURN $page ;
}

//------------------------------------------------------------------------------

Function SelTanggal($objname, $value)
{
  $nmbulan = Array();
  $nmbulan[0] = "Januari";
  $nmbulan[1] = "Februari";
  $nmbulan[2] = "Maret";
  $nmbulan[3] = "April";
  $nmbulan[4] = "Mei";
  $nmbulan[5] = "Juni";
  $nmbulan[6] = "Juli";
  $nmbulan[7] = "Agustus";
  $nmbulan[8] = "September";
  $nmbulan[9] = "Oktober";
  $nmbulan[10] = "November";
  $nmbulan[11] = "Desember";

  $pPage = "<select name='$objname' class='validate[required]'><option value=''>:: Pilih Bulan ::</option>";
  $i=0;
  while($i<count($nmbulan))
  {
    if(trim($value) == trim($nmbulan[$i]))
      $sel = "selected";
    else
      $sel = "";
    $pPage .= "<option value='".$nmbulan[$i]."' $sel>".($i+1).". ".$nmbulan[$i]."</option>";
    $i++;
  }

  $pPage .= "</select>";
  return $pPage;
}

Function SelTahun($objname, $value)
{
  $pPage = "<select name='$objname'><option value=''>:: Pilih Tahun ::</option>";
  $nyear = DATE("Y");
  for($i=2000;$i<=2030;$i++)
  {
    if($nyear == $i)
      $sel = "selected";
    else if($value == $i)
      $sel = "selected";
    else
      $sel = "";
    $pPage .= "<option value='$i' $sel>".$i."</option>";
  }

  $pPage .= "</select>";
  Return $pPage;
}

Function FormatTglnya($Datanya){
    if(strlen($Datanya)==8){
    $tahun = substr($Datanya,0,4);
    $bulan = substr($Datanya,4,2);
    $tgl = substr($Datanya,6,2);
    $hsl = $tgl."-".$bulan."-".$tahun;}
    return $hsl;
}

//------------------------------------------------------------------------------
Function Template_Formnya($template1,$replace1,$templatenya){
  $pPage = MF_GetFile($templatenya);
  $i=0;
  WHILE($i < COUNT($template1)){
    $pPage = str_replace($template1[$i],$replace1[$i],$pPage);
    $i++;
  }
  RETURN $pPage;
}
//------------------------------------------------------------------------------
Function Hasilsqlnya($sqlnya,$Fieldnya){
//  $hasil = EXECUTE_QUERY($sqlnya);
//  $row = mssql_fetch_array($hasil);
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$sqlnya);
  $row = sqlsrv_fetch_array($query);
  
  $d = $row[$Fieldnya];
RETURN $d;
}
//------------------------------------------------------------------------------
Function Cek_Login($frm_USER_ID,$frm_PASSWORD,$frm_USERUNIT,$frm_EMAIL){
  $sqlnya = "SELECT * FROM [SYSTEM_USER] WHERE
            USERNAME='".$frm_USER_ID."' AND
            PASSWORD='".$frm_PASSWORD."' AND
            STATUS='1' ";
  //print $sqlnya; exit();
  $par_USER_ID = TRIM(Hasilsqlnya($sqlnya,"USERNAME"));
  $par_PASSWORD = TRIM(Hasilsqlnya($sqlnya,"PASSWORD"));
  $par_UNIT = TRIM(Hasilsqlnya($sqlnya,"ID_UNIT"));

  $sql_unit = " SELECT * FROM DOC_UNIT WHERE ID_UNIT='$par_UNIT'";
  GLOBAL $connectionInfo, $SQLHost;
  $conn     = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query    = sqlsrv_query($conn,$sql_unit);
  $data     = sqlsrv_fetch_array($query);

  IF($par_USER_ID==$frm_USER_ID AND $par_PASSWORD==$frm_PASSWORD){
    $_SESSION["USER_NAME"] = TRIM(Hasilsqlnya($sqlnya,"NAME"));
    $_SESSION["USER_GROUP_ID"] = TRIM(Hasilsqlnya($sqlnya,"USER_GROUP_ID"));
    $_SESSION["USERUNIT"] = TRIM(Hasilsqlnya($sqlnya,"ID_UNIT"));
    $_SESSION["USER_ID"] = TRIM(Hasilsqlnya($sqlnya,"ID_USER"));
    $_SESSION["EMAIL"] = TRIM(Hasilsqlnya($sqlnya,"EMAIL"));
    $_SESSION["LOCATION"] = TRIM($data[UNIT_LOCATION]);
    $_SESSION["VERIFIKATOR"] = TRIM($data[ID_VERIFIKATOR]);
    //$_SESSION["BRANCH_ID"] = TRIM(Hasilsqlnya($sqlnya,"BRANCH_ID"));
    //$_SESSION["DIVISION_ID"] = TRIM(Hasilsqlnya($sqlnya,"DIVISION_ID"));
    $_SESSION["STAT_LOGIN"] = "";
  }ELSE{$_SESSION["STAT_LOGIN"]="SALAH";}
}
//------------------------------------------------------------------------------
Function Login_Area($stat){
  GLOBAL $msgDivisiDTI, $app_name;
  $template1 = Array();
  $replace1 = Array();

  //$gbr_1 = "<IMG src='includes/page_main/img/syariahmandiri.jpg' border=0 cellPadding=0 cellSpacing=0>";
  $gbr_2 = "<B><H3>$app_name</H3></B>";
  IF(empty($stat)){
  $gbr2 = "<IMG src='includes/page_main/img/Login_area.gif' border=0 cellPadding=0 cellSpacing=0 width='140' height='100'>";
  }ELSE{
    $gbr2 = "<IMG src='includes/page_main/img/Login_failed.gif' border=0 cellPadding=0 cellSpacing=0 width='140' height='100'>";
  }
  $foot = "<center>".$msgDivisiDTI."</center>";
  $page = "<table border='0'><tr><td align=''>".$gbr_1."</td><td align=''>".$gbr_2."</td></tr>";
  $page .= "<tr><td colspan=2 height=30 width=550>&nbsp;</td></tr>";
  $page .= "<tr><td align='center'>".$gbr2."</td><td align='center' valign='center'>".Input_Loginnya()."</td></tr>";
  $page .= "<tr><td colspan=2 height=50>&nbsp;</td></tr>";
  $page .= "<tr><td colspan=2>".$foot."</td></tr></table>";

  $templatenya = "includes/page_login/template_kertas.dat";
  $template1[0] = "[---JUDUL-FORM---]";
  $template1[1] = "[---TEMPAT-FORM---]";
  $replace1[0] = "";
  $replace1[1] = $page;
  $datanya = Template_Formnya($template1,$replace1,$templatenya);

  $x = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"100%\"><tr align='center'><td>";
  $x1 = "</td></tr></table>";
  RETURN $x.$datanya.$x1 ;
}
//------------------------------------------------------------------------------
Function TanyaHapus_Data($cmd,$ID,$nmFieldnya,$sqlnya,$datanya){
  IF($datanya=="")
  {
    $d = TRIM(Hasilsqlnya($sqlnya,$nmFieldnya)) ;
  }
  ELSE
  {
    $d = $datanya ;
  }
  $datanya = "<br>" ;
  $datanya .= "Are you sure you want to delete <b>".$d."</b> ?" ;
  $datanya .= "<br><br><br>" ;
  $datanya .= "<form method='POST' action='index.php'>" ;
  $datanya .= "<input type='hidden' value='".$cmd."_ok' name='cmd'>" ;
  $datanya .= "<input type='hidden' value='$ID' name='xid'>" ;
  $datanya .= "<input type='hidden' value='$_GET[No]' name='xNo'>" ;
  $datanya .= "<input type='hidden' value='$_GET[xcmd]' name='xcmd'>" ;
  $datanya .= "<input type='submit' value='DELETE' name='B1' style=\"border:1px solid black;\">" ;
  $datanya .= "&nbsp;&nbsp;&nbsp;<input type='button' value='CANCEL' name='B1' onClick=\"history.go(-1)\" style=\"border:1px solid black;\">" ;

  RETURN Template_KotakPolos(":: DELETE DATA",$datanya);
}
//------------------------------------------------------------------------------
Function TanyaHapus_Data2($cmd,$ID1,$ID2,$nmFieldnya,$sqlnya,$datanya){
  IF($datanya==""){
    $d = TRIM(Hasilsqlnya($sqlnya,$nmFieldnya)) ;
  }ELSE{$d = $datanya ;}
  $datanya = "<br>" ;
  $datanya .= "Are you sure you want to delete <b>".$d."</b> ?" ;
  $datanya .= "<br><br><br>" ;
  $datanya .= "<form method='POST' action='index.php'>" ;
  $datanya .= "<input type='hidden' value='".$cmd."_ok' name='cmd'>" ;
  $datanya .= "<input type='hidden' value='$ID1' name='xid1'>" ;
  $datanya .= "<input type='hidden' value='$ID2' name='xid2'>" ;
  $datanya .= "<input type='submit' value='DELETE' name='B1' style=\"border:1px solid black;\">" ;
  $datanya .= "&nbsp;&nbsp;&nbsp;<input type='button' value='CANCEL' name='B1' onClick=\"history.go(-1)\" style=\"border:1px solid black;\">" ;

  RETURN Template_KotakPolos(":: DELETE DATA",$datanya);
}
//------------------------------------------------------------------------------
Function Batas_TextArea($nilai){
  RETURN "onKeyPress='if(event.keyCode==34 || event.keyCode==39 || value.length>=".$nilai.") event.returnValue = false;'";
}
//------------------------------------------------------------------------------
Function Template_KotakKotak($JUDUL,$ISI){
  $template1 = Array();
  $replace1 = Array();
  $nmFile = "includes/page_main/Form2.html";
  $template1[0] = "[--JUDUL--]";
  $template1[1] = "[--ISI--]";
  $replace1[0] = $JUDUL;
  $replace1[1] = $ISI;
  RETURN Template_Formnya($template1,$replace1,$nmFile);
}
//------------------------------------------------------------------------------
Function Template_KotakPolos($JUDUL,$ISI){
  $template1 = Array();
  $replace1 = Array();
  $nmFile = "includes/page_main/form1.html";
  $template1[0] = "[--JUDUL--]";
  $template1[1] = "[--ISI--]";
  $replace1[0] = $JUDUL;
  $replace1[1] = $ISI;
  RETURN Template_Formnya($template1,$replace1,$nmFile);
}
//------------------------------------------------------------------------------
Function HapusData($sqlnya){
  GLOBAL $msgDataHapusOK ;
  $hasil = EXECUTE_QUERY($sqlnya);
  RETURN $msgDataHapusOK;
}
//------------------------------------------------------------------------------
Function TitleLinknya($title){
  RETURN "onMouseOver=\"window.status='".$title."';return true;\" onMouseOut=\"window.status='';return true;\" ";
}
//------------------------------------------------------------------------------
Function GET_POST($frm1){
  $frm_value = $_POST[$frm1];
  IF($frm_value==""){
    $frm_value = $_GET[$frm1];
  }
  RETURN $frm_value;
}
Function FormatTGL1($tgl){
  RETURN DATE("d-M-Y", strtotime($tgl));
}

Function FormatTGL2($tgl){

  $day = date('d', strtotime($tgl));
  $month = DATE("F", strtotime($tgl));
  $year = DATE("Y", strtotime($tgl));
  switch ($month)
  {
    case "January" :
    $month = "Januari";
    break;

    case "February" :
    $month = "Februari";
    break;

    case "February" :
    $month = "Februari";
    break;

    case "March" :
    $month = "Maret";
    break;

    case "May" :
    $month = "Mei";
    break;

    case "July" :
    $month = "Juli";
    break;

    case "August" :
    $month = "Agustus";
    break;

    case "October" :
    $month = "Oktober";
    break;

    case "December" :
    $month = "Desember";
    break;
  }

  $tgl = $day." ".$month." ".$year;
  RETURN $tgl;
}

Function FormatTGL_biasa($tgl){
  RETURN DATE("d-m-y", strtotime($tgl));
}
//------------------------------------------------------------------------------
Function Query_Data($sqlnya){
  $FieldName=Array();
  $dVal = ARRAY();
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $hasil = sqlsrv_query($conn,$sqlnya);
  //$hasil = EXECUTE_QUERY($sqlnya);
  $i=0;
  //while( $fieldNm = mssql_field_name($hasil) ){
/*  while( $fieldNm = sqlsrv_field_metadata($hasil) ){
    $FieldName[$i] = $fieldNm;
    $i++;
  }
*/  
  foreach(sqlsrv_field_metadata($hasil) as $fieldNm){
      //foreach($fieldNm as $name => $value){
          //print $value; 
          $FieldName[$i] = $fieldNm['Name']; 
          $i++;          
      //}
      
      
  }
  //print_r($FieldName) ; 
  
  $i=0;
  //while($row = mssql_fetch_array($hasil)){
  while($row = sqlsrv_fetch_array($hasil)){
    $x=0;
    
    WHILE( $x < COUNT($FieldName) ){
      //print $FieldName[$x]; exit();
      $dVal[$i]->$FieldName[$x] = $row[$FieldName[$x]];
      $x++;
    }
    $i++;
  }
  RETURN $dVal;
}
//------------------------------------------------------------------------------
Function Format_Angka($Nilai){
  $Nilai = number_format($Nilai,2,",",".");
  return $Nilai;
}
Function FormatJAM($jam){
  $temp .=  $jam[0].$jam[1].":";
  $temp .=  $jam[2].$jam[3].":";
  $temp .=  $jam[4].$jam[5];
  RETURN $temp;
}
//------------------------------------------------------------------------------
Function KALENDER($nmfrm,$nminptext){
  $KALENDER_val = "onClick=\"javascript:WindowKalender('includes/page_calender/calendar2.php?frmName=".$nmfrm."&fieldName=".$nminptext."&nextFieldName=".$nminptext."','IRUL')\" ";
  RETURN $KALENDER_val;
}
//------------------------------------------------------------------------------
Function MundurkanTanggal($ke){
  RETURN DATE("Ymd", mktime(0, 0, 0, DATE("m"), DATE("d")-$ke, DATE("Y")));
}
Function MundurkanBulan($ke){
  RETURN DATE("Ymd", mktime(0, 0, 0, DATE("m")-$ke, DATE("d"), DATE("Y")));
}
//------------------------------------------------------------------------------#7CDD80
Function GantiWarnaOnMouse($warna){
  $data = "style=\"background: ".$warna."\" onMouseOver=\"setPointer(this, 'over', '".$warna."', 'yellow', '#999999');\" onMouseOut=\"setPointer(this, 'out', '".$warna."', 'yellow', '#999999');\" ";
  RETURN $data;
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
Function GetBulan($Bulan){
  RETURN DATE("M", mktime(0, 0, 0, $Bulan, date("d"), date("Y")) );
}
//------------------------------------------------------------------------------
Function AmbilTanggalSaja($Data){
/*$Datanya = Array();
  $tahun = substr($Data,0,4);
  $bulan = substr($Data,4,2);
  $tgl = substr($Data,6,2);*/
  $Datanya[0] = DATE("m", strtotime($Data)); //$bulan;
  $Datanya[1] = DATE("d", strtotime($Data)); //$tgl;
  $Datanya[2] = DATE("Y", strtotime($Data)); //$tahun;
  RETURN $Datanya;
}
//------------------------------------------------------------------------------
Function HitungHari($datefrom1,$dateto1){
$datefrom = Array();
$dateto = Array();

$datefrom = AmbilTanggalSaja($datefrom1);
$dateto = AmbilTanggalSaja($dateto1);

$FROM1 = GetBulan($datefrom[0]);
$FROM2 = $datefrom[1];
$FROM3 = $datefrom[2];

$TGLFROM = $FROM1." ".$FROM2." ".$FROM3;
//echo "<li>".$TGLFROM;

$TO1 = GetBulan($dateto[0]);
$TO2 = $dateto[1];
$TO3 = $dateto[2];
$TGLTO = $TO1." ".$TO2." ".$TO3;
//echo "<li>".$TGLTO;

    $tstampfrom = strtotime($TGLFROM);
    $tstampto = strtotime($TGLTO);
    $datediff = $tstampto - $tstampfrom;
    $daysdiff = $datediff / 86400;
    if (round($daysdiff,0) > $daysdiff)
    {$numdays = round($daysdiff,0);}
    else
    {$numdays = round($daysdiff,0);}
    return $numdays;
}
//------------------------------------------------------------------------------
Function HitungHari_Kerja($datefrom1,$dateto1){
$Datanya = Array();

  $Jumlah_Hari = HitungHari($datefrom1,$dateto1);
  $Datanya = AmbilTanggalSaja($datefrom1);

  $i=0; $HLibur=0;
  WHILE($i < $Jumlah_Hari){
    $stat = DATE( "w", mktime(0, 0, 0, $Datanya[0], $Datanya[1]+$i, $Datanya[2]) ) ;
    $TGL = DATE( "Ymd", mktime(0, 0, 0, $Datanya[0], $Datanya[1]+$i, $Datanya[2]) ) ;
    $sqlnya = "SELECT COUNT(yyyymmdd) as JUM FROM TABEL_LIBUR WHERE yyyymmdd='".$TGL."' ";
    $iDAT = Query_Data($sqlnya);
    $stat1 = $iDAT[0]->JUM;
    IF( $stat==0 OR $stat==6 OR $stat1!=0 ){ $HLibur++; } // hari minggu; sabtu
    $i++;
  }

  IF($HLibur==""){$HLibur=0;}
  $TotHari = $Jumlah_Hari - $HLibur;
  IF($TotHari<0){$TotHari=0;}
RETURN $TotHari;
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
Function KasihNolNol($data,$jumDigit){
  $i=STRLEN($data); $temp="";
  WHILE($i<$jumDigit){
    $temp .= "0";
    $i++;
  }
  RETURN $temp.$data ;
}
//------------------------------------------------------------------------------
Function Ambil_Tipe_File($data){
  $i=0; $temp="";
  WHILE( $i < STRLEN($data) ){
    $hsl=(STRLEN($data)-$i);
    IF($data[$hsl]=="."){BREAK;}
    $i++;
  }
  $i=$hsl;
  WHILE( $i < STRLEN($data) ){
    $temp .= $data[$i];
    $i++;
  }
  RETURN $temp;
}
//------------------------------------------------------------------------------
Function SIMPAN_LOG($ket){
GLOBAL $COOK_USER_ID, $COOK_BRANCH_ID, $cmd, $COOK_USERUNIT ;
  $id = MD5(IP_USER().DATE("Ymd").DATE("His"));
  $iSQL = "INSERT INTO MtLOG (LogId, UserCode, BranchCode, CMD, Description, IPAddress, LogDate) VALUES ".
          "('".$id."', '".$COOK_USER_ID."', '".$COOK_USERUNIT."', '".$cmd."', '".$ket."', '".IP_USER()."', GETDATE())";
  //print $iSQL;
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$iSQL);  
  //$hasil = EXECUTE_QUERY($iSQL);
}
//------------------------------------------------------------------------------
Function GET_TOTAL_DATA($iSQL,$FIELD_ID,$iID){
  $iData = Query_Data($iSQL);$i=1;
  ForEach($iData as $iDATA){
    IF($iDATA->$FIELD_ID==$iID){$NIL=$i; BREAK;}
    $i++;
  }
  RETURN $NIL ;
}
//------------------------------------------------------------------------------
Function Convert_Excell_Word($tipe,$nmFile){
  IF($tipe=="excell"){$tipe="vnd.ms-excel";$ext="xls";}ELSE{$tipe="msword";$ext="doc";}
  header("Content-Type: application/".$tipe."");
  header("Content-Disposition: attachment; filename=".$nmFile.".".$ext." ");
  header("Pragma: no-cache");
  header("Expires: 0");
}
//------------------------------------------------------------------------------
Function Generate_Bulan($tipe){
  $data = Array();
  IF($tipe=="nama_bulan"){
    $data[1] = "Januari";
    $data[2] = "Februari";
    $data[3] = "Maret";
    $data[4] = "April";
    $data[5] = "Mei";
    $data[6] = "Juni";
    $data[7] = "Juli";
    $data[8] = "Agustus";
    $data[9] = "September";
    $data[10] = "Oktober";
    $data[11] = "Nopember";
    $data[12] = "Desember";
  }ELSE{
    $data[1] = "01";
    $data[2] = "02";
    $data[3] = "03";
    $data[4] = "04";
    $data[5] = "05";
    $data[6] = "06";
    $data[7] = "07";
    $data[8] = "08";
    $data[9] = "09";
    $data[10] = "10";
    $data[11] = "11";
    $data[12] = "12";
  }
  RETURN $data;
}
//------------------------------------------------------------------------------
Function Ambil_Nama_Bulan($i){
  $data = Array();
  $data["01"] = "Januari";
  $data["02"] = "Februari";
  $data["03"] = "Maret";
  $data["04"] = "April";
  $data["05"] = "Mei";
  $data["06"] = "Juni";
  $data["07"] = "Juli";
  $data["08"] = "Agustus";
  $data["09"] = "September";
  $data["10"] = "Oktober";
  $data["11"] = "Nopember";
  $data["12"] = "Desember";
RETURN $data[$i] ;
}
//------------------------------------------------------------------------------

Function Information_Data($cmd, $text, $url){

  $datanya = "<br>".$text."<br><br>";
  $datanya .= "<input type='button' value='     OK     ' name='B1' onClick='javascript:document.location=\"$url\";' style=\"border:1px solid black;\">" ;

  RETURN Template_KotakPolos("INFORMASI SISTEM",$datanya);
}

Function view_home($cmd)
{
  global $app_name, $app_version, $COOK_USER_GROUP_ID;

  $JUDUL = ":: HOME";
  $ulData .= "<table border='0' cellpadding='2' cellspacing='2' width='600' style='border-collapse: collapse' bordercolor='#FFFFFF' height='18'>";
  $ulData .= "<tr><td align='center' width='72px'><img src=\"includes/page_main/img/info.jpg\"></td><td align='left' valign=top nowrap>
  Welcome ... <BR><BR>
  You are using \"$app_name\" version $app_version.<BR>
  Please don't forget to do logout after using this application.<BR><BR>
  Thank You.

  </td></tr>";
  $ulData .= "</table>";
  Return Template_KotakPolos($JUDUL,$ulData);
}

Function view_info($cmd){
  global $app_name, $app_version, $app_develop, $right, $app_division;
  $ulData .= "<table border='0' cellpadding='5' cellspacing='0' width='600' style='border-collapse: collapse' bordercolor='#FFFFFF' height='18'>";
  $ulData .= "<tr>
              <td align='center' width='72px'>
                <img src=\"includes/page_main/img/info.jpg\">
              </td>
              <td align='left' valign=top nowrap>
                <table>
                <tr>
                <td>Application Name</td>
                <td>&nbsp;:&nbsp;</td>
                <td>$app_name</td>
                </tr>
                <tr>
                <td valign=top>Version</td>
                <td valign=top>&nbsp;:&nbsp;</td>
                <td>$app_version</td>
                </tr>
                <tr>
                <td valign=top>Development Team</td>
                <td valign=top>&nbsp;:&nbsp;</td>
                <td>$app_develop</td>
                </tr>
                <tr>
                <td valign=top>Division</td>
                <td valign=top>&nbsp;:&nbsp;</td>
                <td>$app_division</td>
                </tr>
                <tr>
                <td valign=top>Copyright</td>
                <td valign=top>&nbsp;:&nbsp;</td>
                <td>$right
                </td>
                </tr>
                </table>
              </td>
              </tr>";
  $ulData .= "</table>";
  RETURN Template_KotakPolos("INFORMASI SISTEM",$ulData);
}

function generate_code($numberid, $userid)
{
    $iSQL = "SELECT A.* FROM SEKRE_FORMAT A WHERE A.FORMAT_ID = '".$numberid."'";
    $iData = Query_Data($iSQL);
    $frm_FORMAT_TEXT = $iData[0]->FORMAT_TEXT;
    $frm_PYEAR = $iData[0]->PYEAR;
    $frm_PNUMBER_START = $iData[0]->PNUMBER_START;
    $frm_PNUMBER_END = $iData[0]->PNUMBER_END;
    $frm_PNUMBER_LAST = $iData[0]->PNUMBER_LAST;
    $frm_PNUMBER_DIGIT = $iData[0]->PNUMBER_DIGIT;


    $iSQL2 = "SELECT DIVISION_CODE, BRANCH_CODE FROM [SYSTEM_USER] A
              LEFT JOIN SYSTEM_DIVISION B
                ON A.DIVISION_ID = B.DIVISION_ID
              LEFT JOIN SYSTEM_BRANCH C
                ON A.BRANCH_ID = C.BRANCH_ID
              WHERE A.USER_ID = '".$userid."'";
    $iData2 = Query_Data($iSQL2);
    $frm_DIVISION_CODE = $iData2[0]->DIVISION_CODE;
    $frm_BRANCH_CODE = $iData[0]->BRANCH_CODE;

    if($frm_PNUMBER_LAST > $frm_PNUMBER_END)
    {
      echo "The Code can't generated, code has been used the maximum number of times!";
    }
    else
    {
      if($frm_PNUMBER_LAST >= $frm_PNUMBER_START)
        $no = $frm_PNUMBER_LAST+1;
      else
        $no = $frm_PNUMBER_START;

      $jum = $frm_PNUMBER_DIGIT;
      $lenangka = strlen($no);
      $needjum = $jum - $lenangka;
      $format_no = "";

      for($i=1;$i<=$needjum;$i++)
        $format_no .= "0";

      $format_no = $format_no.$no;
    }

    $Running_no = $format_no;
    $frm_FORMAT_TEXT = str_replace("PYEAR",$frm_PYEAR,$frm_FORMAT_TEXT);
    $frm_FORMAT_TEXT = str_replace("PNUMBER",$Running_no,$frm_FORMAT_TEXT);
    $frm_FORMAT_TEXT = str_replace("PDIVISION",$frm_DIVISION_CODE,$frm_FORMAT_TEXT);

    $sqlnya = "UPDATE SEKRE_FORMAT SET PNUMBER_LAST=".$format_no." WHERE FORMAT_ID=".$numberid."" ;
    $hasil = EXECUTE_QUERY($sqlnya);
    //$qry2 = "select descr, startno, endno, lastno, tagseparator, digit FROM ec_code WHERE numberid = ".$numberid."";
    //$res2=mysql_query($qry2) or die("Query Error : ".mysql_error());
    //if($res2)
    //{
      //$data2=mysql_fetch_row($res2);
      /*
      if($data2[3] > $data2[2])
      {
        echo "The Code can't generated, code has been used the maximum number of times!";
      }
      else
      {
        if($data2[3] >= $data[1])
          $no = $data2[3]+1;
        else
          $no = $data2[1];

        $jum = $data2[5];
        $lenangka = strlen($no);
        $needjum = $jum - $lenangka;
        $format_no = "";

        for($i=1;$i<=$needjum;$i++)
          $format_no .= "0";

        $format_no = $format_no.$no;
        $format_descr = $data2[0];
        if($format_descr=="")
          $format_date = "";
        else
          $format_date = date("mY");
        $format_separator = $data2[4];
      }

      if($type == 1)
        $format_code = $format_descr."".$format_separator."".$format_no."";
      else
        $format_code = $format_descr."".$format_separator."".$format_date."".$format_separator."".$format_no."";

      $qry3 = "update ec_code set lastno=".$format_no." WHERE numberid = ".$numberid."";
      $res3=mysql_query($qry3) or die("Query Error : ".mysql_error());
      */
    //}

  return $frm_FORMAT_TEXT;
}

Function SendEmail($to, $subject, $message)
{
  Global $mailfromAdmin;
  $mailfrom = $mailfromAdmin;
  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "From: ".$mailfrom."\r\n";

  if(mail($to, $subject, $message, $headers))
    $mailstat = 1;
  else
    $mailstat = 0;
  return $mailstat;
}
//------------------------------------------------------------------------------
function getId($table, $field){
    $sql    = " SELECT MAX($field) as jml_field FROM $table";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    $data  = sqlsrv_fetch_array($query);
    $id     = $data[jml_field]+1;

    return $id;
}

function getUserById($id){
   $sql = " SELECT * FROM SYSTEM_USER WHERE USER_ID='$id'";
   GLOBAL $connectionInfo, $SQLHost;
   $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
   $query = sqlsrv_query($conn,$sql);
   $data  = sqlsrv_fetch_array($query);
   return $data;
}

function get_User(){
   $sql = " SELECT * FROM [SYSTEM_USER] WHERE 1=1 AND STATUS<>'99' ORDER BY ID_USER ASC";
   GLOBAL $connectionInfo, $SQLHost;
   $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
   $query = sqlsrv_query($conn,$sql);
   while($data  = sqlsrv_fetch_array($query)){
       $dt[$data[ID_USER]] = $data[NAME];
   }
   
  /*$data  = new dBase();
   $query = $data->executeQuery($sql);
   print_r($query);
   while($dw  = $data->fetchArray($query)){
        $dt[$dw[ID_USER]] = $dw[NAME];
   }*/
   //print_r($dt);
   return $dt;
}

function deleteRecord($id_name, $id ,$table,$field,$status){
  global  $msgDBError, $msgDataHapusOK;
  $sql  = " UPDATE $table SET $field='$status' WHERE $id_name='$id'";
  //PRINT $sql;
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$sql);
  if($query==1){
     return Template_KotakPolos("DELETE DATA",$msgDataHapusOK);
  }else{
     return Template_KotakPolos("DELETE DATA",$msgDBError);
  }
}

function get_UnitName(){
  $sql  = " SELECT ID_UNIT, UNIT_CODE, UNIT_NAME FROM DOC_UNIT WHERE STATUS <> '99'";
   GLOBAL $connectionInfo, $SQLHost;
   $conn = sqlsrv_connect($SQLHost, $connectionInfo);
   $query = sqlsrv_query($conn,$sql);
   while($data  = sqlsrv_fetch_array($query)){
     $dt[$data[ID_UNIT]] = $data[UNIT_CODE]." - ".$data[UNIT_NAME];
  }
  return $dt;
}

function get_UnitDataById($id){
  $sql    = " SELECT * FROM DOC_UNIT WHERE AND ID_UNIT='$id' STATUS <> '99'";
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$sql);
  $data   = sqlsrv_fetch_array($query);
  return $data;
}

/*function get_TypeName(){
  $sql  = " SELECT ID_TYPE, TYPE_NAME FROM DOC_TYPE WHERE STATUS <> '99'";
  $query  = mssql_query($sql);
  while($data=mssql_fetch_array($query)){
     $dt[$data[ID_TYPE]] = $data[TYPE_NAME];
  }
  return $dt;
}
*/

/*function get_CourierName(){
  $sql  = " SELECT ID_COURIER, COURIER_NAME FROM DOC_COURIER WHERE STATUS <> '99'";
  $query  = mssql_query($sql);
  while($data=mssql_fetch_array($query)){
     $dt[$data[ID_COURIER]] = $data[COURIER_NAME];
  }
  return $dt;
}
*/

function get_Wilayah(){
  $sql    = " SELECT * FROM DOC_UNIT_REGION WHERE STATUS <> '99'";
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$sql);
  while($data = sqlsrv_fetch_array($query)){
    $dt[$data[ID_UNITREGION]]  = $data[REGION_CODE]." - ".$data[REGION_NAME];
  }
  return $dt;
}

Function SimpanGantiPassword($cmd){
GLOBAL $COOK_USER_ID, $msgDBSave, $msgDBUpdate ;

  $frm_USER_NAME = GET_POST("frm_username");
  $frm_PASSWORD1 = GET_POST("frm_PASSWORD1");
  $frm_PASSWORD2 = GET_POST("frm_PASSWORD2");

  IF($frm_password1==$frm_password2){
    $sqlnya = "UPDATE [SYSTEM_USER] SET USERNAME='".$frm_USER_NAME."', PASSWORD='".$frm_PASSWORD1."' WHERE ID_USER='".$COOK_USER_ID."'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sqlnya);
    #print $sqlnya; exit();
    $status = $msgDBUpdate;
  }ELSE{
    $status = "<br><br><b>::: PASSWORD TIDAK SAMA :::</b>";
  }
RETURN $status ;
}

//------------------------------------------------------------------------------

function get_ObjectType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM OBJECT_TYPE WHERE 1=1 $where";
    
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);    
    
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_OBJECT_TYPE]]  = $data[OBJECT_TYPE_NAME];
    }
    return $dt;
}

function get_CriteriaType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_CRITERIA WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_CRITERIA]]  = $data[CRITERIA_NAME].($data[PARENT_CRITERIA]=="0"?" (Parent) ":"");
    }
    return $dt;
}

function get_NeracaType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_NERACA WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_NERACA]]  = $data[NERACA_NAME].($data[PARENT_NERACA]=="0"?" <b>(Parent)</b> ":"");
    }
    return $dt;
}

function get_ScoringType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM SCORING_TYPE WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_SCORING_TYPE]]  = $data[SCORING_TYPE_NAME];
    }
    return $dt;
}

function get_InfoCIFType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_INFOCIF WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_INFOCIF]]  = $data[CIFINFO_NAME];
    }
    return $dt;
}

function get_ApplicationType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_APPLICATION WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_APPLICATION]]  = $data[APPLICATION_NAME];
    }
    return $dt;
}

function get_CollateralType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_COLLATERAL WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_COLL]]  = $data[COLL_NAME];
    }
    return $dt;
}

function gen_CollateralTypeByScoring($id){

    $where = "";
    $where .= "AND A.STATUS<>'99'";
    $sql  = " SELECT A.*, B.COLL_NAME FROM SCORING_COLLATERAL A LEFT JOIN TYPE_COLLATERAL B ON A.ID_COLL=B.ID_COLL WHERE A.ID_SCORING_TYPE='$id' $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_COLL]]  = $data[COLL_NAME];
    }
    return $dt;
}

function gen_CriteriaTypeByScoring($id){

    $where = "";
    $where .= "AND A.STATUS<>'99'";
    $sql  = " SELECT A.*, B.CRITERIA_NAME, B.PARENT_CRITERIA FROM SCORING_CRITERIA A LEFT JOIN TYPE_CRITERIA B ON A.ID_CRITERIA=B.ID_CRITERIA WHERE A.ID_SCORING_TYPE='$id' $where ORDER BY B.PARENT_CRITERIA";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[PARENT_CRITERIA]][$data[ID_CRITERIA]]  = $data[CRITERIA_NAME];
    }
    return $dt;
}

function  get_CriteriaByApp($id){
    $where  = "";
    $sql    = " SELECT * FROM BUS_ACCEPTANCE_CRITERIA WHERE ID_BUS_APPLICATION='$id'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_BUS_APPLICATION]][$data[ID_CRITERIA]]  = array("BUS_ACCEPTANCE_CRITERIA"=>$data[BUS_ACCEPTANCE_CRITERIA],"BUS_ACCEPTANCE_KET"=>$data[BUS_ACCEPTANCE_KET]);
    }
    return $dt;
}

function  get_CriteriaByApp_ver($id){
    $where  = "";
    $sql    = " SELECT * FROM BUS_ACCEPTANCE_CRITERIA_VER WHERE ID_BUS_APPLICATION='$id'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_BUS_APPLICATION]][$data[ID_CRITERIA]]  = array("BUS_ACCEPTANCE_CRITERIA"=>$data[BUS_ACCEPTANCE_CRITERIA],"BUS_ACCEPTANCE_KET"=>$data[BUS_ACCEPTANCE_KET]);
    }
    return $dt;
}

function gen_NeracaTypeByScoring($id){

    $where = "";
    $where .= "AND A.STATUS<>'99'";
    $sql  = " SELECT A.*, B.NERACA_NAME, B.PARENT_NERACA FROM SCORING_NERACA A LEFT JOIN TYPE_NERACA B ON A.ID_NERACA=B.ID_NERACA WHERE A.ID_SCORING_TYPE='$id' $where ORDER BY B.PARENT_NERACA";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[PARENT_NERACA]][$data[ID_NERACA]]  = $data[NERACA_NAME];
    }
    return $dt;
}

function  get_NeracaByApp($id){
    $where  = "";
    $sql    = " SELECT * FROM BUS_NERACA WHERE ID_BUS_APPLICATION='$id'";
    //print $sql;
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_BUS_APPLICATION]][$data[ID_NERACA]]  = array("BUS_NERACA_TAHUNAWAL"=>$data[BUS_NERACA_TAHUNAWAL],
                                                                "BUS_NERACA_TAHUNAKHIR"=>$data[BUS_NERACA_TAHUNAKHIR],
                                                                "BUS_NERACA_TAHUNJALAN"=>$data[BUS_NERACA_TAHUNJALAN],
                                                                "BUS_NERACA_VALUEAWAL"=>$data[BUS_NERACA_VALUEAWAL],
                                                                "BUS_NERACA_VALUEAKHIR"=>$data[BUS_NERACA_VALUEAKHIR],
                                                                "BUS_NERACA_VALUEJALAN"=>$data[BUS_NERACA_VALUEJALAN],
                                                                "BUS_NERACA_KETAWAL"=>$data[BUS_NERACA_KETAWAL],
                                                                "BUS_NERACA_KETAKHIR"=>$data[BUS_NERACA_KETAKHIR],
                                                                "BUS_NERACA_KETJALAN"=>$data[BUS_NERACA_KETJALAN],
                                                                "BUS_NERACA_MONJALAN"=>$data[BUS_NERACA_MONJALAN]);
    }

    return $dt;

}

function get_FormulaType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_FORMULA WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_FORMULA]]  = $data[FORMULA_NAME];
    }
    return $dt;
}

function get_FormulaByScoring($id_scoring_type){
   $sql = " SELECT A.FORMULA_NAME, A.FORMULA, B.* FROM TYPE_FORMULA A LEFT JOIN BUS_FORMULA B ON A.ID_FORMULA=B.ID_FORMULA
            WHERE A.ID_SCORING_TYPE='$id_scoring_type' AND B.STATUS<>'99' AND A.STATUS<>'99'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_FORMULA]][$data[ID_BUS_FORMULA]]["FORMULA_NAME"]    = $data[FORMULA_NAME];
      $dt[$data[ID_FORMULA]][$data[ID_BUS_FORMULA]]["FORMULA"]         = $data[FORMULA];
      $dt[$data[ID_FORMULA]][$data[ID_BUS_FORMULA]]["ID_SORT"]         = $data[ID_SORT];
      $dt[$data[ID_FORMULA]][$data[ID_BUS_FORMULA]]["ID_NERACA"]       = $data[ID_NERACA];
   }
   return $dt;
}

function get_ScoringValueType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM TYPE_SCORINGVALUE WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_SCORINGVALUE]]  = $data[SCORINGVALUE_NAME];
    }
    return $dt;
}

function module_updatecolcov($xid, $value, $total){
    $sql  = "UPDATE BUS_APPLICATION SET APPLICATION_COLCOV='$value', APPLICATION_LAGUNAN='$total' WHERE ID_BUS_APPLICATION='$xid'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
}

function get_FinFormulaType(){
    $where = "";
    $where .= "AND STATUS<>'99'";
    $sql  = " SELECT * FROM SCORING_FINFORMULA WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_FINFORMULA]]  = $data[FINFORMULA_NAME];
    }
    return $dt;
}

function get_ScoringParam_byIdScoringType($idTypeScoring){
    $where = "";
    $where .= "AND SV.STATUS<>'99'";
    $where .= "AND SP.STATUS<>'99'";
    $sql  = " SELECT SV.*, SP.* FROM TYPE_SCORINGVALUE SV LEFT JOIN BUS_SCORINGPOINT SP ON SV.ID_SCORINGVALUE=SP.ID_SCORINGVALUE WHERE 1=1 $where";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_SCORINGVALUE]][$data[ID_SCORINGPOINT]]  = array( "ID_SCORINGVALUE"       =>$data[ID_SCORINGVALUE],
                                                                    "SCORINGVALUE_NAME"     =>$data[SCORINGVALUE_NAME],
                                                                    "APPLICATION"           =>$data[APPLICATION],
                                                                    "NERACA"                =>$data[NERACA],
                                                                    "FORMULA"               =>$data[FORMULA],
                                                                    "COLLTYPE"              =>$data[COLLTYPE],
                                                                    "SCORINGPOINT_ATTRIBUT" =>$data[SCORINGPOINT_ATTRIBUT],
                                                                    "SCORINGPOINT_POINT"    =>$data[SCORINGPOINT_POINT]);
    }
    return $dt;
}

function get_FinFormulaByScoring($id_scoring_type){
   $sql = " SELECT A.FINFORMULA_NAME, A.FINFORMULA, B.* FROM SCORING_FINFORMULA A LEFT JOIN BUS_FINFORMULA B ON A.ID_FINFORMULA=B.ID_FINFORMULA
            WHERE A.ID_SCORING_TYPE='$id_scoring_type' AND B.STATUS<>'99' AND A.STATUS<>'99'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_FINFORMULA]][$data[ID_BUS_FINFORMULA]]["FINFORMULA_NAME"]            = $data[FINFORMULA_NAME];
      $dt[$data[ID_FINFORMULA]][$data[ID_BUS_FINFORMULA]]["FINFORMULA"]                 = $data[FINFORMULA];
      $dt[$data[ID_FINFORMULA]][$data[ID_BUS_FINFORMULA]]["ID_SORT"]                    = $data[ID_SORT];
      $dt[$data[ID_FINFORMULA]][$data[ID_BUS_FINFORMULA]]["ID_BUS_SCORINGPOINT"]        = $data[ID_BUS_SCORINGPOINT];
   }
   return $dt;
}

function module_updateStatusApplication($xid, $status){
  $sql    = " UPDATE BUS_APPLICATION SET STATUS='".$status."' WHERE ID_BUS_APPLICATION='$xid'";
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$sql);
  //print $sql; exit();
  return $query;
}

function module_updateStatusApplication_ver($xid, $status){
  $sql    = " UPDATE BUS_APPLICATION_VER SET STATUS='".$status."' WHERE ID_BUS_APPLICATION='$xid'";
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $query = sqlsrv_query($conn,$sql);

  return $query;
}

function get_month(){
    for($i=1;$i<=12;$i++){
        $m  = date("m", mktime(0,0,0,$i,1,1));
        $month[$m]  = date("F", mktime(0,0,0,$i,1,1));
    }
    return $month;
}

function getAllVerifikator_wilayah(){
    $sql    = " SELECT * FROM SYSTEM_VERIFIKATOR WHERE STATUS <>'99'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
        $dt[$data['ID_VERIFIKATOR']]  = $data['VERIFIKATOR_NAME'];
    }
    return $dt;
}

function insert_log_app_number($in){
    $sql  = " INSERT INTO LOG_APP_NUMBER (APP_NUMBER,STATUS,CREATED_BY,CREATED_TIMESTAMP)
              VALUES ('".$in['APP_NUMBER']."', '".$in['STATUS']."', '".$in['CREATED_BY']."', GETDATE())";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    //while($data = sqlsrv_fetch_array($query)){
    return $query;
}

?>