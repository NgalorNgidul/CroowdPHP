<?
Function DAFTAR_MENU($cmd){
GLOBAL $JENIS_KARTU, $COOK_BRANCH_ID ;

  $DataView = Array();
  $DataTabel = Array();
  $DataViewCenter = Array();

  $DataView[0] = "NO.";
  $DataView[1] = "MENU";
  $DataView[2] = "TIPE";
  $DataView[3] = "STATUS";

  $DataTabel[0] = "MENU_NAME";
  $DataTabel[1] = "TYPE";
  $DataTabel[2] = "STATUS";

  $DataTabel[99] = "";

  $DataViewCenter[0] = "left";
  $DataViewCenter[1] = "left";
  $DataViewCenter[2] = "left";

  $KondAktif = "2";

  $JumArray = 3;
  $sqlnya = "SELECT * ".
            "FROM SYSTEM_MENU ".
            " ".
            "ORDER BY TYPE ASC ";
  
  //echo "<li>".$sqlnya;

  $JUDUL = ":: DAFTAR MENU" ;

  $ulData .= PageList_Menu($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDULx, $cmd);
  Return Template_KotakPolos($JUDUL,$ulData);
}
//------------------------------------------------------------------------------
Function PageList_Menu($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDUL, $cmd){
    GLOBAL $COOK_DIVISION_ID, $_STATUS;
    $ok_but = "<img src=\"includes/page_main/img/ok_lt_on.gif\" border='0' alt='ADD MENU' >";
    $edit_but = "<img src=\"includes/page_main/img/edit_on.gif\" border='0' alt='EDIT' >";
    $del_but = "<img src=\"includes/page_main/img/del_lt_on.gif\" border='0' alt='DELETED' >";
    $detail_but = "<img src=\"includes/page_main/img/det.gif\" border='0' alt='DELETED' >";
    
    $addcmd = $cmd."_add";
    $delcmd =  $cmd."_del";
    $editcmd = $cmd."_crt";
    $detcmd = $cmd."_vw";
    $ulData .= "<table border=1 width='100%' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#000000' height='18'>";

    $ulData .= "<tr>";
    $i=0;
    while( $i < Count($DataView) ){
        $ulData .= "<td align='center' bgcolor='#FCD315'><font face=verdana size=2><b>&nbsp;".$DataView[$i]."&nbsp;</b></font></td>";
        $i++;
    }
    $ulData .= "</tr>";

    //$warna=="#E5E5E5";
    $x=1;
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sqlnya);
    while($row  = sqlsrv_fetch_array($query)){

      if ($warna=="#E5E5E5"){$warna="#FFFFFF";} else {$warna="#E5E5E5";}
      $ulData .= "<tr>";
      $ulData .= "<td height='18' bgcolor='".$warna."' valign='top' align='left'><font face=verdana size=2>&nbsp;".$x.". &nbsp;</font></td>";

      $i=0;
      while($i<$JumArray){
          IF($KondAktif!="" AND $i == ($JumArray-1)){
            IF($row[$DataTabel[$i]]=="1"){$ulData .= "<td height='18' bgcolor='".$warna."' align='".$DataViewCenter[$i]."'><font face=verdana size=2>AKTIF</font></td>";}
            ELSE{$ulData .= "<td bgcolor='".$warna."' valign='top' align='center'><font color='red'>NON AKTIF</font></td>";}

          }ELSEIF($DataTabel[$i]=="USER_GROUP_ID"){
            $iSQL = "SELECT USER_GROUP_NAME FROM SYSTEM_USER_GROUP WHERE USER_GROUP_ID='".$row[$DataTabel[$i]]."' ";
            $iData = Query_Data($iSQL);
            $ulData .= "<td bgcolor='".$warna."' valign='top' align='left'><font>".$iData[0]->USER_GROUP_NAME."</font></td>";

          }ELSEIF($DataTabel[$i]=="MENU_ID"){
            $iSQL = "SELECT MENU_NAME FROM SYSTEM_MENU WHERE MENU_ID='".$row[$DataTabel[$i]]."' ";
            $iData = Query_Data($iSQL);
            $ulData .= "<td bgcolor='".$warna."' valign='top' align='left'><font>".$iData[0]->MENU_NAME."</font></td>";
          
          }ELSEIF($DataTabel[$i]=="USER_GROUP_MENU_ID"){
            $iSQL = "SELECT * FROM SYSTEM_USER_GROUP WHERE USER_GROUP_ID='".$row[$DataTabel[$i]]."' ";
            $iData = Query_Data($iSQL);
            $ulData .= "<td bgcolor='".$warna."' valign='top' align='left'><font>".$iData[0]->USER_GROUP_NAME."</font></td>";
          
          }ELSEIF($DataTabel[$i]=="BRANCH_ID"){
            $iSQL = "SELECT * FROM SYSTEM_BRANCH WHERE BRANCH_ID='".$row[$DataTabel[$i]]."' ";
            $iData = Query_Data($iSQL);
            $ulData .= "<td bgcolor='".$warna."' valign='top' align='left'><font>".$row[$DataTabel[$i]]." - ".$iData[0]->BRANCH_NAME."</font></td>";

          }ELSE{
            $ulData .= "<td bgcolor='".$warna."' valign='top' align='left'><font>".$row[$DataTabel[$i]]."</font></td>";
          }
          $i++;
      }
      IF($cmd=="CMD_REQUEST_NO" or $cmd=="CMD_REQUEST_NO_REJECT"){
              $ulData .= "<td align='left' valign='top'><a href='index.php?cmd=$detcmd&isview=1&xid=".trim($row[$DataTabel[99]])."'>".$detail_but."</a></td>";
      }
      
      IF($cmd=="CMD_EVENT")
      {
        IF($COOK_DIVISION_ID == "12")
        {
          $ulData .= "<td align='left' valign='top'><a href='index.php?cmd=$detcmd&isview=1&xid=".trim($row[$DataTabel[99]])."'>".$detail_but."</a></td>";
          $ulData .= "<td align='left'><a href='index.php?cmd=$editcmd&xid=".trim($row[$DataTabel[99]])."'>".$edit_but."</a></td>";
          $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&xid=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";  
        }
        else
        {
          $ulData .= "<td align='left' valign='top'><a href='index.php?cmd=$detcmd&isview=1&xid=".trim($row[$DataTabel[99]])."'>".$detail_but."</a></td>";
          $ulData .= "<td align='left'><a href='index.php?cmd=$editcmd&xid=".trim($row[$DataTabel[99]])."'>".$edit_but."</a></td>";
        }
          
      }
      IF($cmd=="CMD_RPT_REQ_print"){
              $ulData .= "<td align='left' valign='top'><a href='index.php?cmd=CMD_REQUEST_NO_REJECT_vw&isview=1&xid=".trim($row[$DataTabel[99]])."'>".$detail_but."</a></td>";
      }
      IF($cmd=="CMD_REQUEST_NO_vw"){
              $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&yid=".trim($row[$DataTabel[98]])."&xid=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }
      IF($cmd=="CMD_USER_GROUP"){
        $ulData .= "<td align='left'><a href='index.php?cmd=$addcmd&xid=".trim($row[$DataTabel[99]])."'>".$ok_but."</a></td>";
        $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&xid=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }
      IF($cmd=="CMD_USER_GROUP_add"){
        $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&idgroup=".trim($row[$DataTabel[98]])."&idmenu=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }
      IF($cmd=="CMD_FORMAT_NO_add"){
        $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&frm_FORMAT_ID=".trim($row[$DataTabel[98]])."&frm_USER_GROUP_ID=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }
      IF($cmd=="CMD_USER"){
        $ulData .= "<td align='left'><a href='index.php?cmd=$editcmd&xid=".trim($row[$DataTabel[99]])."'>".$edit_but."</a></td>";
        $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&xid=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }
      IF($cmd=="CMD_UTILITIES"){
        $ulData .= "<td align='left'><a href='index.php?cmd=$editcmd&xid=".trim($row[$DataTabel[99]])."'>".$edit_but."</a></td>";
        $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&xid=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }
      IF($cmd=="CMD_FORMAT_NO"){
        $ulData .= "<td align='left'><a href='index.php?cmd=$editcmd&xid=".trim($row[$DataTabel[99]])."'>".$edit_but."</a></td>";
        $ulData .= "<td align='left'><a href='index.php?cmd=$addcmd&xid=".trim($row[$DataTabel[99]])."'>".$ok_but."</a></td>";
        $ulData .= "<td align='left'><a href='index.php?cmd=$delcmd&xid=".trim($row[$DataTabel[99]])."'>".$del_but."</a></td>";
      }

      $ulData .= "</tr>";
      $x++;
    }

$ulData .= "</table>";
Return $ulData;
}
//------------------------------------------------------------------------------
Function DAFTAR_USER_GROUP($cmd){
GLOBAL $COOK_BRANCH_ID ;

  $DataView = Array();
  $DataTabel = Array();
  $DataViewCenter = Array();

  $DataView[0] = "NO.";
  $DataView[1] = "GROUP USER";
  $DataView[2] = "ADD";
  $DataView[3] = "DEL";

  $DataTabel[0] = "USER_GROUP_NAME";

  $DataTabel[99] = "USER_GROUP_ID";

  $DataViewCenter[0] = "left";

  $KondAktif = "";

  $JumArray = 1;
  $sqlnya = "SELECT * FROM SYSTEM_USER_GROUP WHERE USER_GROUP_ID <> '' AND STATUS = 1 ORDER BY USER_GROUP_NAME ASC ";
  
  //echo "<li>".$sqlnya;

  $JUDUL = ":: DAFTAR GROUP USER" ;

  $h = $cmd."_crt";
  $ulData = "<form method='POST' action='index.php'>".
            "<input type='submit' value='TAMBAH GROUP USER' name='B1'>".
            "<input type='hidden' value='$h' name='cmd'>".
            "</form>";

  $ulData .= PageList_Menu($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDULx, $cmd);
  Return Template_KotakPolos($JUDUL,$ulData);
}
//------------------------------------------------------------------------------
Function DAFTAR_ADDMenu($cmd){
GLOBAL $COOK_BRANCH_ID ;

  $DataView = Array();
  $DataTabel = Array();
  $DataViewCenter = Array();

  $DataView[0] = "NO.";
  $DataView[1] = "GROUP USER";
  $DataView[2] = "MENU";
  $DataView[3] = "DEL";
  
  $DataTabel[0] = "USER_GROUP_ID";
  $DataTabel[1] = "MENU_ID";

  $DataTabel[98] = "USER_GROUP_ID";
  $DataTabel[99] = "MENU_ID";

  $DataViewCenter[0] = "left";

  $KondAktif = "";

  $JumArray = 2;

  $IDGROUP = GET_POST("xid");
  $sqlnya = "SELECT * ".
            "FROM SYSTEM_MENU_USER_GROUP ".
            "WHERE USER_GROUP_ID='".$IDGROUP."' ".
            " ";
  
  //echo "<li>".$sqlnya;

  $JUDUL = ":: DAFTAR MENU USER" ;

  $h = $cmd."_crt";
  $ulData = "<form method='POST' action='index.php'>".
            "<input type='submit' value='  TAMBAH MENU  ' name='B1' class='submit'>".
            "<input type='hidden' value='$h' name='cmd'>".
            "<input type='hidden' value='".$IDGROUP."' name='idgroup'>".
            "</form>";

  $ulData .= PageList_Menu($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDULx, $cmd);
  Return Template_KotakPolos($JUDUL,$ulData);
}
//------------------------------------------------------------------------------
Function ADDMENU_in_GROUP($cmd){
GLOBAL $HURUF, $ANGKA, $LOCK_INPUT, $COOK_BRANCH_ID, $COOK_USER_GROUP_ID ;

$nmInput = Array();
$nmInput[0] = "frm_menu";
$datanya .= BuatJavaScript_CekInputan($nmInput);

  $idgroup = GET_POST("idgroup");
  $iSQL = "SELECT USER_GROUP_NAME FROM SYSTEM_USER_GROUP WHERE USER_GROUP_ID='".$idgroup."' ";
  $iData = Query_Data($iSQL);

$datanya .= "<form id='formID' method='GET' action='index.php'>
    <table style='border: 1px' border=0>

    <tr>
    <td><b>USER GROUP</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><b>".$iData[0]->USER_GROUP_NAME."</td></tr>

    <tr>
    <td><b>MENU</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><select size='1' name='frm_menu' class='validate[required]'>
    <option value=''>:: PILIH NAMA MENU ::</option>";

    $iSQL = "SELECT * FROM SYSTEM_MENU ".
            "WHERE MENU_ID NOT IN (SELECT MENU_ID FROM SYSTEM_MENU_USER_GROUP WHERE USER_GROUP_ID='".$idgroup."')".
            "ORDER BY TYPE, DESCRIPTION ASC ";
    $iData = Query_Data($iSQL);

    ForEach($iData as $iDat){
      $datanya .= "<option value='".$iDat->MENU_ID."'>".$iDat->MENU_NAME." ( ".$iDat->KET." )</option>";
    }

$datanya .= "
    </td></tr>

    <tr><td colspan=3 align='center'>&nbsp;</td></tr>

    <tr>
    <td align=center colspan=3>
    <input type='submit' class='submit' value='    SAVE    ' />
    <input type='hidden' value='".$cmd."_save' name='cmd'>
    <input type='hidden' value='".$idgroup."' name='idgroup'>
    </td>
    </tr></table></form>";

RETURN Template_KotakPolos(":: DATA MENU",$datanya);
}
//------------------------------------------------------------------------------
Function SIMPAN_ADD_MENU($cmd){
GLOBAL $COOK_BRANCH_ID, $COOK_USER_ID, $msgDBSave, $msgDBUpdate ;

  $idgroup = GET_POST("idgroup");
  $frm_menu = GET_POST("frm_menu");

  $iSQL = "SELECT COUNT(*) as JUM FROM SYSTEM_MENU_USER_GROUP WHERE USER_GROUP_ID='".$idgroup."' AND MENU_ID='".$frm_menu."' ";
  $iData = Query_Data($iSQL);

  IF($iData[0]->JUM==0){
    $sqlnya = "INSERT INTO SYSTEM_MENU_USER_GROUP (USER_GROUP_ID,MENU_ID) VALUES ".
              "('".$idgroup."','".$frm_menu."') ";
    $hasil = EXECUTE_QUERY($sqlnya);
    //echo "<li>".$sqlnya;
    $hsl = $msgDBSave;
  }ELSE{
    $hsl = "<b>!!! DATA TIDAK BISA DISIMPAN, MENU SUDAH ADA !!!</b>";
  }
  RETURN $hsl;
}
//------------------------------------------------------------------------------
Function INPUT_USER_GROUP($cmd){
GLOBAL $HURUF, $ANGKA, $LOCK_INPUT, $COOK_BRANCH_ID ;

$nmInput = Array();
$nmInput[0] = "frm_USER_GROUP_NAME";
$datanya .= BuatJavaScript_CekInputan($nmInput);

$datanya .= "<form id='formID' method='GET' action='index.php'>
    <table style='border: 1px' border=0>

    <tr>
    <td><b>NAMA GROUP USER</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_USER_GROUP_NAME' size='30' maxlength='50' value='".$frm_USER_GROUP_NAME."' class='validate[required]'></td></tr>

    <tr><td colspan=3 align='center'>&nbsp;</td></tr>

    <tr>
    <td align=center colspan=3>
    <input type='submit' class='submit' value='    SAVE    ' />
    <input type='hidden' value='".$cmd."_save' name='cmd'>
    <input type='hidden' value='".$xid."' name='xid'>
    </td>
    </tr></table></form>";

RETURN Template_KotakPolos(":: DATA GROUP USER",$datanya);
}
//------------------------------------------------------------------------------
Function SIMPAN_USER_GROUP($cmd){
GLOBAL $COOK_BRANCH_ID, $COOK_USER_ID, $msgDBSave, $msgDBUpdate ;

  $frm_USER_GROUP_NAME = GET_POST("frm_USER_GROUP_NAME");

  //$id=MD5(DATE("Ymd").DATE("His"));
  $id            = getId("SYSTEM_USER_GROUP","USER_GROUP_ID");
  $sqlnya = "INSERT INTO SYSTEM_USER_GROUP (USER_GROUP_ID, USER_GROUP_NAME, STATUS) VALUES ".
            "('$id','".$frm_USER_GROUP_NAME."','1') ";
  $hasil = EXECUTE_QUERY($sqlnya);
  $hsl = $msgDBSave;

  RETURN $hsl;
}
//------------------------------------------------------------------------------
Function DAFTAR_USER($cmd){
GLOBAL $JENIS_KARTU, $COOK_BRANCH_ID, $COOK_USER_GROUP_ID ;

  $DataView = Array();
  $DataTabel = Array();
  $DataViewCenter = Array();

  $DataView[0] = "NO.";
  $DataView[1] = "NAMA USER";
  $DataView[2] = "GROUP USER";
  $DataView[3] = "UNIT KERJA";
  $DataView[4] = "UNIT VERIFIKATOR";
  $DataView[5] = "USERNAME";
  $DataView[6] = "STATUS";
  $DataView[7] = "EDIT";
  $DataView[8] = "DEL";

  $DataTabel[0] = "NAME";
  $DataTabel[1] = "USER_GROUP_NAME";
  $DataTabel[2] = "UNIT_NAME";
  $DataTabel[3] = "VERIFIKATOR_NAME";  
  $DataTabel[4] = "USERNAME";
  $DataTabel[5] = "STATUS";

  $DataTabel[99] = "ID_USER";

  $DataViewCenter[0] = "left";
  $DataViewCenter[1] = "left";
  $DataViewCenter[2] = "left";
  $DataViewCenter[3] = "left";
  $DataViewCenter[4] = "center";
  $DataViewCenter[5] = "left";

  $KondAktif = "7";

  $JumArray = 6;
  if($COOK_USER_GROUP_ID!="1" && $COOK_USER_GROUP_ID!="20")
      $where  .= " AND D.USER_GROUP_ID <> 20";
  $sqlnya = "SELECT A.*, D.USER_GROUP_NAME, B.UNIT_NAME, E.VERIFIKATOR_NAME FROM [SYSTEM_USER] A
            LEFT JOIN [DOC_UNIT] B
              ON A.ID_UNIT=B.ID_UNIT
            LEFT JOIN [SYSTEM_USER_GROUP] D
              ON A.USER_GROUP_ID=D.USER_GROUP_ID
            LEFT JOIN [SYSTEM_VERIFIKATOR] E
              ON A.ID_VERIFIKATOR=E.ID_VERIFIKATOR              
            WHERE A.USER_GROUP_ID <> 1 AND A.STATUS <> 99 $where
            ORDER BY D.USER_GROUP_NAME, A.ID_USER ASC ";

  //echo "<li>".$sqlnya;

  $JUDUL = ":: DAFTAR USER" ;

  $h = $cmd."_crt";
  $ulData = "<form method='POST' action='index.php'>".
            "<input type='submit' value='  TAMBAH USER  ' name='B1' class='submit'>".
            "<input type='hidden' value='$h' name='cmd'>".
            "</form>";

  $ulData .= PageList_Menu($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDULx, $cmd);
  Return Template_KotakPolos($JUDUL,$ulData);
}
//------------------------------------------------------------------------------
Function INPUT_USER($cmd){
GLOBAL $HURUF, $ANGKA, $LOCK_INPUT, $COOK_BRANCH_ID, $_UNITNAME, $_STATUS, $COOK_USER_GROUP_ID ;

$nmInput = Array();
$nmInput[0] = "frm_USER_GROUP_ID";
$nmInput[1] = "frm_USER_NAME";
$nmInput[2] = "frm_USER_ID";
$nmInput[3] = "frm_PASSWORD";
$nmInput[4] = "frm_USERUNIT";
$nmInput[4] = "frm_BRANCH";
$nmInput[5] = "frm_VERIFIKATOR";
$datanya .= BuatJavaScript_CekInputan($nmInput);

$xid = GET_POST("xid");
$sel1=ARRAY();
$sel2=ARRAY();
$sel3=ARRAY();

IF($xid!=""){
  $iSQL = "SELECT * FROM [SYSTEM_USER] WHERE ID_USER='".$xid."' ";
  $iData = Query_Data($iSQL);

  $frm_USER_ID = $iData[0]->USERNAME;
  $frm_USER_NAME = $iData[0]->NAME;
  $frm_PASSWORD = $iData[0]->PASSWORD;
  $frm_USER_GROUP_ID[$iData[0]->USER_GROUP_ID]="selected";
  $frm_BRANCH_ID[$iData[0]->ID_UNIT]="selected";
  //$frm_DIVISION_ID = $iData[0]->DIVISION_ID;
  //$frm_BRANCH_ID = $iData[0]->BRANCH_ID;
  $frm_EMAIL = $iData[0]->EMAIL;
  $frm_NOTIF_EVENT[$iData[0]->NOTIF_EVENT]="selected";
  $frm_STATUS[$iData[0]->STATUS]="selected";
  $frm_VERIFIKATOR[$iData[0]->ID_VERIFIKATOR]="selected";
}

$datanya .= "<form id='formID' name='formID' method='GET' action='index.php'>
    <table style='border: 1px' border=0>";

$datanya .= "<tr>
    <td><b>User Group </td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><select size='1' name='frm_USER_GROUP_ID' class='validate[required]'>
    <option value=''>:: Select User Group ::</option>";

    if($COOK_USER_GROUP_ID!="1" && $COOK_USER_GROUP_ID!="20")
        $where  .= " AND USER_GROUP_ID <> 20";
    $iSQL = "SELECT * FROM [SYSTEM_USER_GROUP] WHERE USER_GROUP_ID <> 1 AND STATUS = '1' $where order by USER_GROUP_NAME";
    $iData = Query_Data($iSQL);
    $i=1;
    ForEach($iData as $iDat){
      $datanya .= "<option value='".$iDat->USER_GROUP_ID."' ".$frm_USER_GROUP_ID[$iDat->USER_GROUP_ID].">$i. ".$iDat->USER_GROUP_NAME."</option>";
    $i++;
    }

$datanya .= "
    </td></tr>";
    
$datanya .= "<tr>
    <td><b>Name User</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_USER_NAME' size='30' maxlength='50' value='".$frm_USER_NAME."' class='validate[required]'></td></tr>

    <tr>
    <td><b>User Id (Login)</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_USER_ID' size='30' maxlength='50' value='".$frm_USER_ID."' class='validate[required]'></td></tr>

    <tr>
    <td><b>Password (Login)</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='password' name='frm_PASSWORD' size='30' maxlength='50' value='".$frm_PASSWORD."' class='validate[required]'></td></tr>
    
    ";//<td><b>UNIT</td>
      //<td><b>&nbsp;:&nbsp;</b></td>
      //<td>
      //  <select name='frm_USERUNIT' onchange='func_unit()' class='validate[required]'>
      //  <option value=''>:: Select Unit ::</option>
      //  <option value='1' $selected1>1. Kantor Pusat</option>
      //  <option value='2' $selected2>2. Kantor Cabang</option>
      //  </select>
    //</td></tr>
    
$datanya .= "<tr id='tr_BRANCH_ID' style='$tr_BRANCH'>
    <td><b>Unit Kerja</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><select size='1' name='frm_BRANCH_ID' class='validate[required]'>
    <option value=''>:: Select Unit Kerja ::</option>";

    $iSQL = "SELECT * FROM SYSTEM_BRANCH ORDER BY BRANCH_ID ASC ";
    $iData = Query_Data($iSQL);
    $i=1;
    ForEach($_UNITNAME as $key => $iDat){
      $datanya .= "<option value='".$key."' ".$frm_BRANCH_ID[$key].">".$iDat."</option>";
    $i++;
    }

$datanya .= "
    </td></tr>";
    
$datanya  .= "
    <tr>
    <td><b>Verifikator</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><select size='1' name='frm_VERIFIKATOR'>
    ";
        unset($sql);
        $sql  = " SELECT * FROM [SYSTEM_VERIFIKATOR] WHERE STATUS<>'99'";
        $query  = mssql_query($sql);
        $datanya .= "<option value=''>:: Select Unit Verifikator ::</option>";
        while($data = mssql_fetch_array($query)){
            $datanya .= "<option value='".$data['ID_VERIFIKATOR']."' ".$frm_VERIFIKATOR[$data['$ID_VERIFIKATOR']].">".$data['VERIFIKATOR_NAME']."</option>";        
        }
    //<option value='1' ".$frm_STATUS[1].">1. ACTIVE</option>
    //<option value='0' ".$frm_STATUS[99].">2. NOT ACTIVE</option>
$datanya .="</select><i> Kosongkan jika bukan group VERIFIKATOR</i></td></tr>";
    
/*$datanya .= "<tr id='tr_DIVISION_ID' style='$tr_DIVISION'>
    <td><b>DIVISI</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><select name='frm_DIVISION_ID' class='validate[required]'>
        <option value=''>:: Select Division ::</option>";

        $iSQL = "SELECT DIVISION_ID, DIVISION_CODE, DIVISION_NAME FROM SYSTEM_DIVISION ORDER BY DIVISION_CODE ASC ";
        $iData = Query_Data($iSQL);
        
        $d = 1;
        ForEach($iData as $iDat){
          $datanya .= "<option value='".$iDat->DIVISION_ID."' ".$frm_DIVISION_ID[$iDat->DIVISION_ID].">$d. ".$iDat->DIVISION_CODE." - ".$iDat->DIVISION_NAME."</option>";
          $d++;
        }

$datanya .= "</select>
    </td></tr>";*/

$datanya .= "
    <tr>
    <td><b>Email</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_EMAIL' size='30' maxlength='50' value='".$frm_EMAIL."' class='validate[required,custom[email]]'></td></tr>".
    //<tr>
    //<td><b>NOTIFIKASI</td>
    //<td><b>&nbsp;:&nbsp;</b></td>
    //<td><select size='1' name='frm_NOTIF_EVENT'>
    //<option value='1' ".$frm_NOTIF_EVENT[1].">1. YES</option>
    //<option value='0' ".$frm_NOTIF_EVENT[0].">2. NO</option>
    //</td></tr>
    "<tr>
    <td><b>Status</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><select size='1' name='frm_STATUS'>
    <option value='1' ".$frm_STATUS[1].">1. ACTIVE</option>
    <option value='0' ".$frm_STATUS[99].">2. NOT ACTIVE</option>
    </td></tr>

    <tr><td colspan=3 align='center'>&nbsp;</td></tr>

    <tr>
    <td align=center colspan=3>
    <input type='submit' class='submit' value='    SAVE    ' />
    <input type='hidden' value='".$cmd."_save' name='cmd'>
    <input type='hidden' value='".$xid."' name='xid'>
    </td>
    </tr></table></form>";

RETURN Template_KotakPolos(":: DATA USER",$datanya);
}
//------------------------------------------------------------------------------
Function SIMPAN_USER($cmd){
GLOBAL $COOK_BRANCH_ID, $COOK_USER_ID, $msgDBSave, $msgDBUpdate ;

$xid = GET_POST("xid");
$frm_USER_ID = GET_POST("frm_USER_ID");
$frm_USER_NAME = GET_POST("frm_USER_NAME");
$frm_PASSWORD = GET_POST("frm_PASSWORD");
$frm_USER_GROUP_ID = GET_POST("frm_USER_GROUP_ID");
//$frm_DIVISION_ID = GET_POST("frm_DIVISION_ID");
$frm_BRANCH_ID = GET_POST("frm_BRANCH_ID");
//$frm_USERUNIT = GET_POST("frm_USERUNIT");
//IF($frm_USERUNIT == "2") 
//  $frm_DIVISION_ID = "";
//ELSE
//  $frm_BRANCH_ID = "";
$frm_EMAIL = GET_POST("frm_EMAIL");
//$frm_NOTIF_EVENT = GET_POST("frm_NOTIF_EVENT");
$frm_STATUS = GET_POST("frm_STATUS");
$frm_VERIFIKATOR = GET_POST("frm_VERIFIKATOR");


  IF($xid==""){
    $cek    = cek_username($frm_USER_ID);
    if($cek>0){
        $hsl = "error1";
    }else{
        $id     = getId("[SYSTEM_USER]","ID_USER");
        $sqlnya = "INSERT INTO [SYSTEM_USER] (ID_USER, USERNAME, USER_GROUP_ID, NAME, PASSWORD, EMAIL, ID_UNIT, STATUS, ID_VERIFIKATOR) VALUES ".
                  "('$id','".$frm_USER_ID."', '".$frm_USER_GROUP_ID."', '".$frm_USER_NAME."', '".$frm_PASSWORD."', '".$frm_EMAIL."', '".$frm_BRANCH_ID."', '".$frm_STATUS."','".$frm_VERIFIKATOR."')";
        //print $sqlnya;
        $hasil = EXECUTE_QUERY($sqlnya);
        $hsl = $msgDBSave ;
    }

  }ELSE{
    $cek    = "0";
    if($cek>0){
        $hsl = "error1";
    }else{
        $sqlnya = "UPDATE [SYSTEM_USER] SET USERNAME='".$frm_USER_ID."', USER_GROUP_ID='".$frm_USER_GROUP_ID."', NAME='".$frm_USER_NAME."', PASSWORD='".$frm_PASSWORD."', EMAIL='".$frm_EMAIL."', ID_UNIT='".$frm_BRANCH_ID."', STATUS='".$frm_STATUS."', ID_VERIFIKATOR='".$frm_VERIFIKATOR."' 
                  WHERE ID_USER='".$xid."'" ;
        #print  $sqlnya;
        $hasil = EXECUTE_QUERY($sqlnya);
        $hsl = $msgDBUpdate ;    
    }
  }
  RETURN $hsl;
}

function cek_username($username){
    $username = trim(strtolower($username));
    $sql  = " SELECT * FROM [SYSTEM_USER] WHERE USERNAME='$username' AND STATUS <>'99'";
    $query= mssql_query($sql);
    return mssql_num_rows($query);
}
//------------------------------------------------------------------------------

?>
