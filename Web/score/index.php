<? 
//$ip  = $_SERVER['REMOTE_ADDR'];
//if($ip!="10.2.109.166"){ //10.4.60.61 arif->rmd
//print "<b>Error, Please contact administrator...</b>"; exit();
//} 
ini_set("display_errors", "On");

session_start();

require_once("modules/system_config.php"); 
require_once("lib/xajax/xajax.inc.php");
require_once("lib/functions_xajax.php");
require_once("modules/system_connection.PHP");   
require_once("modules/system_java.DAT");
require_once("modules/system_function.PHP");    
require_once("modules/system_inputnya.PHP");
require_once("modules/system_listdata.PHP");
require_once("modules/system_mainmenu.PHP");
require_once("modules/system_menu.PHP");
require_once("modules/system_cabang.PHP");
require_once("modules/system_viewlog.PHP");
#require_once("modules/system_simpan.PHP");
require_once("modules/system_endecrypttext.php");
require_once("modules/page_scoring_type.php");
require_once("modules/page_object_type.php");
require_once("modules/page_object_value.php");
require_once("modules/page_typecollateral.php");
require_once("modules/page_typecriteria.php");
require_once("modules/page_typeneraca.php");
require_once("modules/page_typeapplication.php");
require_once("modules/page_typeformula.php");
require_once("modules/page_infocif.php");
require_once("modules/page_scoringcriteria.php");
require_once("modules/page_scoringinfocif.php");
require_once("modules/page_scoringneraca.php");
require_once("modules/page_scoringapplication.php");
require_once("modules/page_scoringcollateral.php");
require_once("modules/page_scoringtypevalue.php");
require_once("modules/page_finformula.php");
require_once("modules/app_scoring.php");
require_once("modules/page_bus_min_scoring.php");
require_once("modules/report_scoring.php");
require_once("modules/page_price.php");
require_once("modules/page_verifikator.php");
require_once("modules/app_scoring_ver.php");
require_once("lib/class_cform.php");
require_once("lib/class_tgrid.php");
require_once("lib/class_dBase.php");




echo "<LINK rel='stylesheet' href='includes/page_main/validationEngine.jquery.css'>";
echo "<LINK rel='stylesheet' href='includes/page_main/template.css'>";
echo "<LINK rel='stylesheet' href='includes/page_main/style-tgrid.css'>";

echo "<script type='text/javascript' src='includes/page_main/jquery-1.6.min.js'></script>";
echo "<script type='text/javascript' src='includes/page_main/jquery.validationEngine-id.js'></script>";
echo "<script type='text/javascript' src='includes/page_main/jquery.validationEngine.js'></script>";
echo "<script type='text/javascript' src='includes/page_main/jquery_call.js'></script>";
echo "<script type='text/javascript' src='includes/page_main/calendarDateInput.js'></script>";
//echo "<script type=\"text/javascript\" src=\"includes/page_main/NumberFormat154.js\"></script>\n";
echo "<script type=\"text/javascript\" src=\"includes/page_main/number-functions.js\"></script>\n";
//echo "<script type=\"text/javascript\" src=\"includes/page_main/jquery-1.2.2.pack.js\"></script>\n";

echo "<LINK rel='stylesheet' href='includes/page_main/style.css'>";
echo "<title>".$pMainTitel."</title>";

LibDB_Connect();
//exit();
$COOK_USER_NAME     = $_SESSION["USER_NAME"];                        
$COOK_USERUNIT      = $_SESSION["USERUNIT"];
$COOK_USER_ID       = $_SESSION["USER_ID"];
$COOK_EMAIL         = $_SESSION["EMAIL"];
$COOK_BRANCH_ID     = $_SESSION["BRANCH_ID"];
$COOK_DIVISION_ID   = $_SESSION["DIVISION_ID"];
$COOK_USER_GROUP_ID = $_SESSION["USER_GROUP_ID"];
$COOK_USER_LOCATION = $_SESSION["LOCATION"];
$COOK_VERIFIKATOR   = $_SESSION["VERIFIKATOR"];
$_USER              = get_User();
//print_r($_USER);
//exit();
$_UNITNAME          = get_UnitName();
#$_TYPENAME          = get_TypeName();
#$_CNAME             = get_CourierName();
$_WILAYAH           = get_Wilayah();
$_ObjectType        = get_ObjectType();
$_CriteriaType      = get_CriteriaType();
$_NeracaType        = get_NeracaType();
$_ScoringType       = get_ScoringType();
$_InfoCIFType       = get_InfoCIFType();
$_ApplicationType   = get_ApplicationType();
$_CollateralType    = get_CollateralType();
$_FormulaType       = get_FormulaType();
$_FinFormulaType    = get_FinFormulaType();
$_ScoringValue      = get_ScoringValueType();
$_Month             = get_month();
$_VerWilayah        = getAllVerifikator_wilayah();
$cmd = GET_POST("cmd");        
//------------------------------------------------------------------------------
IF($COOK_USER_NAME=="" ){
  $stat = $_SESSION["STAT_LOGIN"];
  PRINT Login_Area($stat);
}
//------------------------------------------------------------------------------
IF($cmd=="login_cek"){
  $frm_USER_ID = GET_POST("frm_USER_ID");
  $frm_PASSWORD = GET_POST("frm_PASSWORD");
  $frm_USERUNIT = GET_POST("frm_USERUNIT");
  $frm_EMAIL = GET_POST("frm_EMAIL");
  Cek_Login($frm_USER_ID,$frm_PASSWORD,$frm_USERUNIT,$frm_EMAIL);
  SIMPAN_LOG("MASUK APLIKASI");

  $hsl = "<br><br><br><center><img src=\"includes/page_main/img/progress.gif\" border='0' alt='Tunggu sebentar lagi proses' >";
  $hsl .= "<br><br><b>Please Wait..........</b></center>";
  PRINT $hsl;
  PRINT "<meta http-equiv='refresh' content='0;url=index.php'>";
}
//------------------------------------------------------------------------------
//print $COOK_USER_NAME; exit();
IF($cmd=="" AND $COOK_USER_NAME!=""){
  $ISI = view_home($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_INFO" AND $COOK_USER_NAME!=""){
  $ISI = view_info($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
//------------------------------------------------------------------------------
IF($cmd=="CMD_CHG_PASS" AND $COOK_USER_NAME!=""){
  $ISI = Ganti_Password($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_CHG_PASS_save" AND $COOK_USER_NAME!=""){
  $ISI = SimpanGantiPassword($cmd);
  SIMPAN_LOG("UBAH PASSWORD");
  PRINT Awal_Html($cmd,$ISI);
  IF($msgDBUpdate==$ISI){
    PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_LOGOUT'>";
  }
}
//------------------------------------------------------------------------------
IF($cmd=="CMD_LOGOUT" AND $COOK_USER_NAME!=""){
  SIMPAN_LOG("KELUAR APLIKASI");
  session_unset();
  session_destroy();
  PRINT "<meta http-equiv='refresh' content='0;url=index.php'>";
}
//------------------------------------------------------------------------------
IF($cmd=="CMD_MENU" AND $COOK_USER_NAME!=""){
  $ISI = DAFTAR_MENU($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
//------------------------------------------------------------------------------
IF($cmd=="CMD_USER_GROUP" AND $COOK_USER_NAME!=""){
  $ISI = DAFTAR_USER_GROUP($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_GROUP_crt" AND $COOK_USER_NAME!=""){
  $ISI = INPUT_USER_GROUP($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_GROUP_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = SIMPAN_USER_GROUP($cmd);
  SIMPAN_LOG("SIMPAN USER GROUP");
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER_GROUP'>";
}
IF($cmd=="CMD_USER_GROUP_del" AND $COOK_USER_ID!=""){
  $xid = GET_POST("xid");
  $sqlnya = "SELECT * FROM [SYSTEM_USER_GROUP] WHERE USER_GROUP_ID='".$xid."'";
  $TempVal = Query_Data($sqlnya);
  $dt = "</b><br><br>NAMA GROUP USER : <b>".$TempVal[0]->USER_GROUP_NAME."</b><br>" ;

  $ISI = TanyaHapus_Data($cmd,$xid,"",$sqlnya,$dt);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_GROUP_del_ok" AND $COOK_USER_ID!=""){
  $xid = GET_POST("xid");
  $sqlnya = "UPDATE [SYSTEM_USER_GROUP] SET STATUS='99' WHERE USER_GROUP_ID='".$xid."'";
  $ISI = HapusData($sqlnya);
  SIMPAN_LOG("DELETE USER GROUP");
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER_GROUP'>";
}
//------------------------------------------------------------------------------
IF($cmd=="CMD_USER_GROUP_add" AND $COOK_USER_NAME!=""){
  $ISI = DAFTAR_ADDMenu($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_GROUP_add_crt" AND $COOK_USER_NAME!=""){
  $ISI = ADDMENU_in_GROUP($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_GROUP_add_crt_save" AND $COOK_USER_NAME!=""){
  $idgroup = GET_POST("idgroup");
  $ISI = SIMPAN_ADD_MENU($cmd);
  SIMPAN_LOG("ADD MENU USER GROUP");
  PRINT Awal_Html($cmd,$ISI);
  IF($ISI==$msgDBSave){
    PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER_GROUP_add&xid=".$idgroup."'>";
  }
}
IF($cmd=="CMD_USER_GROUP_add_del" AND $COOK_USER_ID!=""){
  $idgroup = GET_POST("idgroup");
  $idmenu = GET_POST("idmenu");

  $sqlnya = "SELECT * FROM SYSTEM_USER_GROUP WHERE USER_GROUP_ID='".$idgroup."'";
  $TempVal1 = Query_Data($sqlnya);
  $sqlnya = "SELECT * FROM SYSTEM_MENU WHERE MENU_ID='".$idmenu."'";
  $TempVal2 = Query_Data($sqlnya);
  
  $dt = "<b>".$TempVal2[0]->MENU_NAME."</b></b> from <b>".$TempVal1[0]->USER_GROUP_NAME."</b>";

  $ISI = TanyaHapus_Data2($cmd,$idgroup,$idmenu,"",$sqlnya,$dt);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_GROUP_add_del_ok" AND $COOK_USER_ID!=""){
  $idgroup = GET_POST("xid1");
  $idmenu = GET_POST("xid2");

  $sqlnya = "DELETE SYSTEM_MENU_USER_GROUP WHERE USER_GROUP_ID='".$idgroup."' AND MENU_ID='".$idmenu."'";
  $ISI = HapusData($sqlnya);
  SIMPAN_LOG("DELETE MENU USER GROUP");
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER_GROUP_add&xid=".$idgroup."'>";
}


//------------------------------------------------------------------------------
IF($cmd=="CMD_USER" AND $COOK_USER_NAME!=""){
  $ISI = DAFTAR_USER($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_crt" AND $COOK_USER_NAME!=""){
  $ISI = INPUT_USER($cmd);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = SIMPAN_USER($cmd);
  if($ISI=="error1"){
    $xid  = $_REQUEST[xid];
    print "<script>alert('Maaf, username yang anda masukkan sudah tersedia');</script>";
    PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER_crt&xid=$xid'>";    
  }else{
    SIMPAN_LOG("SIMPAN USER");
    PRINT Awal_Html($cmd,$ISI);
    PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER'>";
  }

}
IF($cmd=="CMD_USER_del" AND $COOK_USER_ID!=""){
  $xid = GET_POST("xid");
  $sqlnya = "SELECT * FROM [SYSTEM_USER] WHERE ID_USER='".$xid."'";
  $TempVal = Query_Data($sqlnya);
  $dt = "</b><br><br>NAMA USER : <b>".$TempVal[0]->NAME."</b><br>" ;

  $ISI = TanyaHapus_Data($cmd,$xid,"",$sqlnya,$dt);
  PRINT Awal_Html($cmd,$ISI);
}
IF($cmd=="CMD_USER_del_ok" AND $COOK_USER_ID!=""){
  $xid = GET_POST("xid");
  $sqlnya = "UPDATE [SYSTEM_USER] SET STATUS='99' WHERE ID_USER='".$xid."'";
  $ISI = HapusData($sqlnya);
  SIMPAN_LOG("DELETE USER");
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_USER'>";
}

//UnitKerja------------------------------------------------------------------------------
IF($cmd=="CMD_UNITKERJA" AND $COOK_USER_NAME!=""){
  $SEARCH = frm_searchcabang($cmd);
  $ISI = daftar_unitkerja($cmd);
  PRINT Awal_Html($cmd,$SEARCH."<BR>".$ISI);
}

IF($cmd=="CMD_UNITKERJA_search" AND $COOK_USER_NAME!=""){
  $cmd    =   "CMD_UNITKERJA";
  $SEARCH = frm_searchcabang($cmd);
  $ISI    = daftar_unitkerja($cmd);
  PRINT Awal_Html($cmd,$SEARCH."<BR>".$ISI);
}

IF($cmd=="CMD_UNITKERJA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_unitkerja($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITKERJA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = unitkerja_save($cmd);
  SIMPAN_LOG("SIMPAN UNIT KERJA");
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITKERJA_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_unitkerja($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITKERJA_update_save" AND $COOK_USER_NAME!=""){
  $ISI = unitkerja_update($cmd);
  SIMPAN_LOG("UPDATE UNIT KERJA");  
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITKERJA_delete" AND $COOK_USER_NAME!=""){
  $ISI = deleteRecord("ID_UNIT", $_REQUEST[xid] ,"DOC_UNIT","STATUS","99");
  SIMPAN_LOG("DELETE UNIT KERJA");
  PRINT Awal_Html($cmd,$ISI);
}

//UnitKerjaLocation------------------------------------------------------------------------------
IF($cmd=="CMD_UNITLOCATION" AND $COOK_USER_NAME!=""){
  $ISI = daftar_unitlocation($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITLOCATION_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_unitlocation($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITLOCATION_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_unitlocationadd($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITLOCATION_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_unitlocation($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITLOCATION_update_save" AND $COOK_USER_NAME!=""){
  $ISI = save_unitlocationupdate($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_UNITLOCATION_delete" AND $COOK_USER_NAME!=""){
  $ISI = deleteRecord("ID_UNITREGION", $_REQUEST[xid] ,"DOC_UNIT_REGION","STATUS","99");
  SIMPAN_LOG("DELETE UNIT KERJA");
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING TYPE------------------------------------------------------------------
IF($cmd=="CMD_SCORINGTYPE" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringtype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGTYPE_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringtype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGTYPE_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringtype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGTYPE_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringtype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGTYPE_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_scoringtype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGTYPE_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SCORING_TYPE", $_REQUEST[xid] ,"SCORING_TYPE","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//OBJECT TYPE------------------------------------------------------------------
IF($cmd=="CMD_OBJECTTYPE" AND $COOK_USER_NAME!=""){
  $ISI = daftar_objecttype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTTYPE_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_objecttype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTTYPE_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_objecttype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTTYPE_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_objecttype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTTYPE_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_objecttype($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTTYPE_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_OBJECT_TYPE", $_REQUEST[xid] ,"OBJECT_TYPE","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//OBJECT VALUE------------------------------------------------------------------
IF($cmd=="CMD_OBJECTVALUE" AND $COOK_USER_NAME!=""){
  $ISI = daftar_objectvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTVALUE_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_objectvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTVALUE_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_objectvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTVALUE_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_objectvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTVALUE_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_objectvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_OBJECTVALUE_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_OBJECT_VALUE", $_REQUEST[xid] ,"OBJECT_VALUE","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//COLLATERAL TYPE---------------------------------------------------------------
IF($cmd=="CMD_TYPECOLLATERAL" AND $COOK_USER_NAME!=""){
  $ISI = daftar_typecollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECOLLATERAL_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECOLLATERAL_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typecollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECOLLATERAL_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECOLLATERAL_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typecollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECOLLATERAL_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_COLL", $_REQUEST[xid] ,"TYPE_COLLATERAL","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//CRITERIA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPECRITERIA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_CRITERIA", $_REQUEST[xid] ,"TYPE_CRITERIA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//CRITERIA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPECRITERIA_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecriteriachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_child_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_update_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecriteriachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPECRITERIA_update_child_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typecriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

//CIF TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPEINFOCIF" AND $COOK_USER_NAME!=""){
  $ISI = daftar_typecif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEINFOCIF_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEINFOCIF_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typecif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEINFOCIF_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typecif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEINFOCIF_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typecif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEINFOCIF_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_INFOCIF", $_REQUEST[xid] ,"TYPE_INFOCIF","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//NERACA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPENERACA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_NERACA", $_REQUEST[xid] ,"TYPE_NERACA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//NERACA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPENERACA_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeneracachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_child_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_update_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeneracachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPENERACA_update_child_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typeneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING CRITERIA-----------------------------------------------------------------
IF($cmd=="CMD_SCORINGCRITERIA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringcriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGCRITERIA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringcriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGCRITERIA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringcriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGCRITERIA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SC_CRITERIA", $_REQUEST[xid] ,"SCORING_CRITERIA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING INFO CIF--------------------------------------------------------------
IF($cmd=="CMD_SCORINGINFOCIF" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringinfocif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGINFOCIF_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringinfocif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGINFOCIF_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringinfocif($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGINFOCIF_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SC_INFOCIF", $_REQUEST[xid] ,"SCORING_INFOCIF","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING NERACA--------------------------------------------------------------
IF($cmd=="CMD_SCORINGNERACA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGNERACA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGNERACA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGNERACA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SC_NERACA", $_REQUEST[xid] ,"SCORING_NERACA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//APPLICATION TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPEAPPLICATION" AND $COOK_USER_NAME!=""){
  $ISI = daftar_typeapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEAPPLICATION_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEAPPLICATION_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typeapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEAPPLICATION_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEAPPLICATION_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typeapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEAPPLICATION_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_APPLICATION", $_REQUEST[xid] ,"TYPE_APPLICATION","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING APPLICATION-----------------------------------------------------------
IF($cmd=="CMD_SCORINGAPPLICATION" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGAPPLICATION_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGAPPLICATION_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringapplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGAPPLICATION_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SC_APPLICATION", $_REQUEST[xid] ,"SCORING_APPLICATION","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//Trans aplikasi----------------------------------------------------------------
IF($cmd=="CMD_TRANSAPPLICATION" AND $COOK_USER_NAME!=""){
  $ISI = daftar_aplikasiscoring($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TRANSAPPLICATION_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_application($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TRANSAPPLICATION_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE"){
  $ISI = application_save($cmd);
  PRINT Awal_Html($cmd,$ISI[msg]);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TRANSAPPLICATION_crt&case=1&xid=$ISI[xid]'>";
}

IF($cmd=="CMD_TRANSAPPLICATION_update" AND $COOK_USER_NAME!="" AND $_REQUEST['case']=="1"){
  $ISI = frm_application($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TRANSAPPLICATION_update_save" AND $COOK_USER_NAME!=""){
  $ISI = application_update($cmd);
  PRINT Awal_Html($cmd,$ISI); 
}

IF($cmd=="CMD_TRANSAPPLICATION_update_save" AND $COOK_USER_NAME!="" AND $_REQUEST['action']=="SAVE & NEXT"){
  $ISI = application_update($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_crt&case=2&xid=$xid'>"; 
}

IF($cmd=="CMD_TRANSAPPLICATION_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  $ISI = application_update($cmd);
  PRINT Awal_Html($cmd,$ISI[msg]);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_crt&case=2&xid=$xid'>"; 
}

IF($cmd=="CMD_TRANSAPPLICATION_detail" AND $COOK_USER_NAME!="" AND $_REQUEST['case']=="1"){
  $ISI      = view_application($cmd);
  $coll     = daftar_appcollateral($cmd);
  $crit     = view_frmcriteria($cmd);
  $nerc     = view_frmneraca($cmd);
  $formula  = get_ScoringApplication($cmd);
  //$final    = module_hasilscoring($cmd);
  $final    = module_hasilscoring_ver($cmd);
  $memo     = list_ofMemo($cmd);
  $css .= "
      <style>
      @media print {
          img{display:none;}
      }        
      </style>
  ";  
  $fin      = Template_KotakPolos("Scoring Summary",$ISI."<br>".$coll."<br>".$nerc."<br>".$crit."<br>".$formula."<br>".$final."<br>".$memo);
  $fina     = Template_KotakPolos("Scoring Summary",$ISI.$coll.$nerc.$crit.$formula.$final.$memo);
  //$update_app = module_updateStatusApplication($_REQUEST[xid]); //ini diperlukan jangan dihapus
  if($_REQUEST[action]=="PRINT"){
     PRINT $css.$fina;
     PRINT "<script>window.print();</script>";
     #PRINT "<script>history.back();</script>";
  }else{
     PRINT Awal_Html($cmd,$fin);
  }
}

IF($cmd=="CMD_TRANSAPPLICATION_delete" AND $COOK_USER_NAME!=""){
  $ISI = deleteRecord("ID_BUS_APPLICATION", $_REQUEST[xid] ,"BUS_APPLICATION","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TRANSAPPLICATION_sent" AND $COOK_USER_NAME!=""){
  $ISI      = view_application($cmd);
  $coll     = daftar_appcollateral($cmd);
  $crit     = view_frmcriteria($cmd);
  $nerc     = view_frmneraca($cmd);
  $formula  = get_ScoringApplication($cmd);
  $final    = module_hasilscoring($cmd);
  $memo     = list_ofMemo($cmd)."<br>".frm_memo($cmd);
  $css .= "
      <style>
      @media print {
          img{display:none;}
      }        
      </style>
  ";  
  $fin      = Template_KotakPolos("Scoring Summary",$ISI."<br>".$coll."<br>".$nerc."<br>".$crit."<br>".$formula."<br>".$memo);
  //$fina     = Template_KotakPolos("Scoring Summary",$ISI.$coll.$nerc.$crit.$formula);
  //$update_app = module_updateStatusApplication($_REQUEST[xid]); //ini diperlukan jangan dihapus
  if($_REQUEST[action]=="PRINT"){
     PRINT $css.$fina;
     PRINT "<script>window.print();</script>";
     #PRINT "<script>history.back();</script>";
  }else{
     PRINT Awal_Html($cmd,$fin);
  }
}

IF($cmd=="CMD_TRANSAPPLICATION_sent_save" AND $COOK_USER_NAME!=""){
    $ISI  = save_memo($cmd);
    PRINT Awal_Html($cmd,$ISI);
    PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TRANSAPPLICATION'>"; 
}
//VERIIFIKATOR------------------------------------------------------------------
IF($cmd=="CMD_TRANSAPPLICATION_VER" AND $COOK_USER_NAME!=""){
  $ISI = daftar_aplikasiscoring_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TRANSAPPLICATION_VER_update" AND $COOK_USER_NAME!="" AND $_REQUEST['case']=="1"){
  $ISI = frm_application_ver($cmd); 
  $update = module_updateStatusApplication_ver($_REQUEST['xid'], '3'); 
  $update_pengajuan = module_updateStatusApplication($_REQUEST['xid'], '3');
  $update_verifikator = update_verifikatorId($_REQUEST['xid'], $COOK_USER_ID);     
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TRANSAPPLICATION_VER_update_save" AND $COOK_USER_NAME!=""){
  $ISI = application_update_ver($cmd);
  PRINT Awal_Html($cmd,$ISI); 
}

IF($cmd=="CMD_TRANSAPPLICATION_VER_update_save" AND $COOK_USER_NAME!="" AND $_REQUEST['action']=="SAVE & NEXT"){
  $ISI = application_update_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_VER_crt&case=2&xid=$xid'>"; 
}

IF($cmd=="CMD_BUSCOLLATERAL_VER_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_collapplication_ver($cmd);
  $ISI  .= "<br>".daftar_appcollateral_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSCOLLATERAL_VER_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="ADD"){
  $ISI = bus_collsave_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_VER_crt&case=2&xid=$xid'>";
}

IF($cmd=="CMD_BUSCOLLATERAL_VER_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  #$ISI = bus_collsave($cmd);
  #PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCRITERIA_VER_crt&case=3&xid=$xid'>";
}

IF($cmd=="CMD_BUSCOLLATERAL_VER_crt_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_BUS_COLL", $_REQUEST[xid] ,"BUS_COLLATERAL_VER","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
  print "<script>window.history.back();</script>";
  #PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_crt&case=2&xid=$_REQUEST[xid]'>";  
}

IF($cmd=="CMD_BUSCRITERIA_VER_crt" AND $COOK_USER_NAME!=""){
  $ISI = get_frmcriteria_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSCRITERIA_VER_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  $ISI = get_frmcriteria_save_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSNERACA_VER_crt&case=4&xid=$xid'>";   
}

IF($cmd=="CMD_BUSCRITERIA_VER_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="UPDATE"){
  $ISI = get_frmcriteria_update_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCRITERIA_VER_crt&case=4&xid=$xid'>";  
}

IF($cmd=="CMD_BUSNERACA_VER_crt" AND $COOK_USER_NAME!=""){
  $ISI = get_frmneraca_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSNERACA_VER_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  $ISI = get_frmneraca_save_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TRANSAPPLICATION_VER'>";   
}

IF($cmd=="CMD_BUSNERACA_VER_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="UPDATE"){
  $ISI = get_frmneraca_update_ver($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSNERACA_VER_crt&case=5&xid=$xid'>";  
}

IF($cmd=="CMD_TRANSAPPLICATION_VER_detail" AND $COOK_USER_NAME!="" AND $_REQUEST['case']=="1"){  
  $ISI      = "<form method=\"POST\"><table id=\"tablecontent\" style=\"margin-top:0;\"><tr><td class=\"tablecontentgrid\" valign=\"top\"><h3>Pengajuan</h3></td><td class=\"tablecontentgrid\"><h3>Verifikator</h3></td></tr><tr><td valign=\"top\">".view_application($cmd)."</td><td>".view_application_ver($cmd)."</td></tr>"; 
  $coll     = "<tr><td valign=\"top\">".daftar_appcollateral($cmd)."</td><td>".daftar_appcollateral_ver($cmd)."</td></tr>";  
  $crit     = "<tr><td>".view_frmcriteria($cmd)."</td><td>".view_frmcriteria_ver($cmd)."</td></tr>";  
  $nerc     = "<tr><td>".view_frmneraca($cmd)."</td><td>".view_frmneraca_ver($cmd)."</td></tr>";   //print "yan"; exit();
  $formula  = "<tr><td>".get_ScoringApplication($cmd)."</td><td>".get_ScoringApplication_ver($cmd)."</td></tr>";
  //$final    = module_hasilscoring($cmd);
  $final    = "";
  $memo     = "<tr><td>".list_ofMemo($cmd)."</td><td>".list_ofMemo($cmd)."</td></tr><tr><td colspan=\"2\"><input type=\"submit\" name=\"action\" value=\"PRINT\" class=\"button\"></td></tr></table></form>";
  $css .= "
      <style>
      @media print {
          img{display:none;}
          .button{display:none}
      }        
      </style>
  ";  
  $fin      = Template_KotakPolos("Scoring Summary",$ISI.$coll.$nerc.$crit.$formula.$final.$memo);
  $fina     = Template_KotakPolos("Scoring Summary",$ISI.$coll.$nerc.$crit.$formula.$final.$memo);
  //$update_app = module_updateStatusApplication($_REQUEST[xid]); //ini diperlukan jangan dihapus
  if($_REQUEST[action]=="PRINT"){
     PRINT $css.$fina;
     PRINT "<script>window.print();</script>";
     #PRINT "<script>history.back();</script>";
  }else{
     PRINT Awal_Html($cmd,$fin);
  }
}

IF($cmd=="CMD_TRANSAPPLICATION_VER_cetak" AND $COOK_USER_NAME!="" AND $_REQUEST['case']=="1"){ 
  $data     = module_getApplication_byid_ver($_REQUEST['xid']); 
  //print_r($data);
  $ISI      = view_application_ver($cmd);
  $coll     = daftar_appcollateral_ver($cmd);
  $crit     = view_frmcriteria_ver($cmd);
  $nerc     = view_frmneraca_ver($cmd);
  $formula  = get_ScoringApplication_ver($cmd);
  $stat     = $data['STATUS']+1;
  //print $data['APPLICATION_STATUS'];
  //if($data['STATUS']=='4'){
  $final    = module_hasilscoring_ver($cmd);
  //}else{
  //      $final    = "";
  //}

  //$final    = "";
  $memo     = list_ofMemo($cmd);
  $css .= "
      <style>
      @media print {
          img{display:none;}
      }        
      </style>
  ";  
  $fin      = Template_KotakPolos("Scoring Summary",$ISI."<br>".$coll."<br>".$nerc."<br>".$crit."<br>".$formula."<br>".$memo."<br><div style=\"page-break-before:always;\">".$final."<div>");
  $fina     = Template_KotakPolos("Scoring Summary",$ISI.$coll.$nerc.$crit.$formula.$memo."<div style=\"page-break-before:always;\">".$final."</div>");
  //$update_app = module_updateStatusApplication($_REQUEST[xid]); //ini diperlukan jangan dihapus
  if($data['STATUS']>"2"){
    $update   = module_updateStatusApplication_ver($_REQUEST['xid'], $stat); 
    $update_pengajuan = module_updateStatusApplication($_REQUEST['xid'], $stat);   
  }
  
  if($_REQUEST[action]=="PRINT"){
     PRINT $css.$fina;
     PRINT "<script>window.print();</script>";
     #PRINT "<script>history.back();</script>";
  }else{
     PRINT Awal_Html($cmd,$fin);
  }
}

//SCORING COLLATERAL------------------------------------------------------------
IF($cmd=="CMD_SCORINGCOLLATERAL" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringcollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGCOLLATERAL_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringcollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGCOLLATERAL_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringcollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGCOLLATERAL_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SC_COLLATERAL", $_REQUEST[xid] ,"SCORING_COLLATERAL","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//BUS COLLATERAL------------------------------------------------------------
IF($cmd=="CMD_BUSCOLLATERAL_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_collapplication($cmd);
  $ISI  .= "<br>".daftar_appcollateral($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSCOLLATERAL_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="ADD"){
  $ISI = bus_collsave($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_crt&case=2&xid=$xid'>";
}

IF($cmd=="CMD_BUSCOLLATERAL_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  #$ISI = bus_collsave($cmd);
  #PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCRITERIA_crt&case=3&xid=$xid'>";
}

IF($cmd=="CMD_BUSCOLLATERAL_crt_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_BUS_COLL", $_REQUEST[xid] ,"BUS_COLLATERAL","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
  print "<script>window.history.back();</script>";
  #PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCOLLATERAL_crt&case=2&xid=$_REQUEST[xid]'>";  
}

//BUS CRITERIA------------------------------------------------------------------
IF($cmd=="CMD_BUSCRITERIA_crt" AND $COOK_USER_NAME!=""){
  $ISI = get_frmcriteria($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSCRITERIA_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  $ISI = get_frmcriteria_save($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSNERACA_crt&case=4&xid=$xid'>";   
}

IF($cmd=="CMD_BUSCRITERIA_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="UPDATE"){
  $ISI = get_frmcriteria_update($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSCRITERIA_crt&case=4&xid=$xid'>";  
}

//BUS NERACA------------------------------------------------------------------
IF($cmd=="CMD_BUSNERACA_crt" AND $COOK_USER_NAME!=""){
  $ISI = get_frmneraca($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSNERACA_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="SAVE & NEXT"){
  $ISI = get_frmneraca_save($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TRANSAPPLICATION'>";   
}

IF($cmd=="CMD_BUSNERACA_crt_save" AND $COOK_USER_NAME!="" AND $_REQUEST[action]=="UPDATE"){
  $ISI = get_frmneraca_update($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_BUSNERACA_crt&case=5&xid=$xid'>";  
}

//FORMULA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPEFORMULA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_FORMULA", $_REQUEST[xid] ,"TYPE_FORMULA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//FORMULA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_TYPEFORMULA_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeformulachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_child_save" AND $COOK_USER_NAME!=""){
  $ISI = save_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_update_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_typeformulachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEFORMULA_update_child_save" AND $COOK_USER_NAME!=""){
  $ISI = update_typeformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

//BUS TYPE-----------------------------------------------------------------
IF($cmd=="CMD_BUSFORMULA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_busformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSFORMULA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_busformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSFORMULA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = frm_busformula_save($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSFORMULA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_BUS_FORMULA", $_REQUEST[xid] ,"BUS_FORMULA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//FORMULA SCORING TYPE----------------------------------------------------------
IF($cmd=="CMD_SCORINGFORMULA" AND $COOK_USER_NAME!=""){
  $ISI = get_ScoringApplication($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING TYPE VALUE------------------------------------------------------------
IF($cmd=="CMD_SCORINGVALUE" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGVALUE_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGVALUE_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGVALUE_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGVALUE_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_scoringvalue($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGVALUE_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SCORINGVALUE", $_REQUEST[xid] ,"TYPE_SCORINGVALUE","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//SCORING POINT-----------------------------------------------------------------
IF($cmd=="CMD_SCORINGPOINT" AND $COOK_USER_NAME!=""){
  $ISI = daftar_scoringpoint($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGPOINT_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringpoint($cmd);
  PRINT Awal_Html($cmd,$ISI);  
}

IF($cmd=="CMD_SCORINGPOINT_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_scoringpoint($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_SCORINGPOINT&id=$_REQUEST[id]'>";
}

IF($cmd=="CMD_SCORINGPOINT_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_scoringpoint($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_SCORINGPOINT_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_scoringpoint($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_SCORINGPOINT&id=$_REQUEST[id]'>";
}

IF($cmd=="CMD_SCORINGPOINT_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_SCORINGPOINT", $_REQUEST[xid] ,"BUS_SCORINGPOINT","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}
#print $cmd;
//FIN FORMULA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_FINFORMULA" AND $COOK_USER_NAME!=""){  
  $ISI = daftar_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_update_save" AND $COOK_USER_NAME!=""){
  $ISI = update_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_FINFORMULA", $_REQUEST[xid] ,"SCORING_FINFORMULA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//FORMULA TYPE-----------------------------------------------------------------
IF($cmd=="CMD_FINFORMULA_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_finformulachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_child_save" AND $COOK_USER_NAME!=""){
  $ISI = save_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_update_child" AND $COOK_USER_NAME!=""){
  $ISI = frm_finformulachild($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_FINFORMULA_update_child_save" AND $COOK_USER_NAME!=""){
  $ISI = update_finformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

//BUS TYPE-----------------------------------------------------------------
IF($cmd=="CMD_BUSFINFORMULA" AND $COOK_USER_NAME!=""){
  $ISI = daftar_busfinformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSFINFORMULA_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_busfinformula($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSFINFORMULA_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = frm_busfinformula_save($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_BUSFINFORMULA_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_BUS_FINFORMULA", $_REQUEST[xid] ,"BUS_FINFORMULA","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//BUS MIN SCORE-----------------------------------------------------------------
IF($cmd=="CMD_MINSCORE" AND $COOK_USER_NAME!=""){
  $ISI = list_min_scoring($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_MINSCORE_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_min_scoring($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_MINSCORE_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = save_min_score($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_MINSCORE_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_MIN_SCORING", $_REQUEST[xid] ,"BUS_MIN_SCORING","STATUS","99");
  PRINT Awal_Html($cmd,$ISI);
}

//BUS PRICE---------------------------------------------------------------------
IF($cmd=="CMD_TYPEPRICE" AND $COOK_USER_NAME!=""){
  $ISI = list_ofPrice($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEPRICE_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_typePrice($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEPRICE_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = typePrice_add($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TYPEPRICE'>";
}

IF($cmd=="CMD_TYPEPRICE_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_typePrice($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_TYPEPRICE_update_save" AND $COOK_USER_NAME!=""){
  $ISI = typePrice_update($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TYPEPRICE'>";
}

IF($cmd=="CMD_TYPEPRICE_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_PRICE", $_REQUEST['xid'] ,"TYPE_PRICE","STATUS","99"); 
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_TYPEPRICE'>";
}

//BUS VERIFIKATOR---------------------------------------------------------------
IF($cmd=="CMD_VERIFIKATOR" AND $COOK_USER_NAME!=""){
  $ISI = list_ofWilVerifikator($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_VERIFIKATOR_crt" AND $COOK_USER_NAME!=""){
  $ISI = frm_Verifikator($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_VERIFIKATOR_crt_save" AND $COOK_USER_NAME!=""){
  $ISI = verifikator_save($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_VERIFIKATOR'>";
}

IF($cmd=="CMD_VERIFIKATOR_update" AND $COOK_USER_NAME!=""){
  $ISI = frm_Verifikator($cmd);
  PRINT Awal_Html($cmd,$ISI);
}

IF($cmd=="CMD_VERIFIKATOR_update_save" AND $COOK_USER_NAME!=""){
  $ISI = verifikator_update($cmd);
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_VERIFIKATOR'>";
}

IF($cmd=="CMD_VERIFIKATOR_delete" AND $COOK_USER_NAME!="" AND $_REQUEST[xid]!=""){
  $ISI = deleteRecord("ID_VERIFIKATOR", $_REQUEST['xid'] ,"SYSTEM_VERIFIKATOR","STATUS","99"); 
  PRINT Awal_Html($cmd,$ISI);
  PRINT "<meta http-equiv='refresh' content='0;url=index.php?cmd=CMD_VERIFIKATOR'>";
}

//report------------------------------------------------------------------------
IF($cmd=="CMD_REPORT"){

  $ISI = get_rasiokeuangan_byscoring($cmd);
  #header("Content-Disposition: attachment; filename=\"test1.xls\""); 
  #header("Content-Type: application/vnd.ms-excel");  
  PRINT $ISI;
 
}


?>