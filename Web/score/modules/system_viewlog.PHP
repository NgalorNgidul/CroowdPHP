<?
Function VIEW_LOG($cmd){
GLOBAL $JENIS_KARTU, $COOK_BRANCH_ID ;

  $DataView = Array();
  $DataTabel = Array();
  $DataViewCenter = Array();

  $DataView[0] = "No";
  $DataView[1] = "User";
  $DataView[2] = "Cabang";
  $DataView[3] = "Keterangan";
  $DataView[4] = "Tanggal";
  $DataView[5] = "Jam";
  $DataView[6] = "IP";

  $DataTabel[0] = "USER_ID";
  $DataTabel[1] = "BRANCH_ID";
  $DataTabel[2] = "KET";
  $DataTabel[3] = "TGL";
  $DataTabel[4] = "JAM";
  $DataTabel[5] = "IP";

  $DataTabel[99] = "";

  $DataViewCenter[0] = "left";
  $DataViewCenter[1] = "left";
  $DataViewCenter[2] = "left";
  $DataViewCenter[3] = "left";
  $DataViewCenter[4] = "left";
  $DataViewCenter[5] = "left";

  $KondAktif = "";

  $JumArray = 6;
  $sqlnya = "SELECT * ".
            "FROM TABEL_LOG ".
            "WHERE TGL='".DATE("Ymd")."' ".
            "ORDER BY JAM DESC ";

  //echo "<li>".$sqlnya;

  $JUDUL = "VIEW LOG" ;

  $ulData .= PageList_Cabang_LOG($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDUL, $cmd);
  Return Template_KotakPolos($JUDUL,$ulData);
}
//------------------------------------------------------------------------------
Function PageList_Cabang_LOG($sqlnya, $JumArray, $DataView, $DataTabel, $DataViewCenter, $KondAktif, $JUDUL, $cmd){
GLOBAL $STAT_CAB;
    
    $ulData="";

    $ulData .= "<table border='0' cellpadding='2' cellspacing='2' style='border-collapse: collapse' bordercolor='#FFFFFF' height='18'>";

    $ulData .= "<tr>";
    $i=0;
    while( $i < Count($DataView) ){
        $ulData .= "<td align='center' bgcolor='#FCD315'><font face=verdana size=2><b>&nbsp;".$DataView[$i]."&nbsp;</b></font></td>";
        $i++;
    }
    $ulData .= "</tr>";

    $x=1;
    $hasil = EXECUTE_QUERY($sqlnya);
    while($row = mssql_fetch_array($hasil)){

      if ($warna=="#E5E5E5"){$warna="#D5D5D5";} else {$warna="#E5E5E5";}
      $ulData .= "<tr>";
      $ulData .= "<td bgcolor='".$warna."' align='center'><font>&nbsp;".$x.". &nbsp;</font></td>";

      $i=0;
      while($i<$JumArray){
          IF($KondAktif!="" AND $i == ($JumArray-1)){
            IF($row[$DataTabel[$i]]=="1"){$ulData .= "<td height='18' bgcolor='".$warna."' align='".$DataViewCenter[$i]."'><font face=verdana size=2>AKTIF</font></td>";}
            ELSE{$ulData .= "<td bgcolor='".$warna."' align='center'><font color='red'>NON AKTIF</font></td>";}

          }ELSEIF($DataTabel[$i]=="BRANCH_ID"){
            $iSQL = "SELECT * FROM SYSTEM_BRANCH WHERE BRANCH_ID='".$row[$DataTabel[$i]]."'";
            $iData = Query_Data($iSQL);
            $ulData .= "<td bgcolor='".$warna."' align='$DataViewCenter[$i]'><font>".$iData[0]->BRANCH_ID." - ".$iData[0]->NAMA."</font></td>";

          }ELSEIF($DataTabel[$i]=="TGL"){
            $ulData .= "<td bgcolor='".$warna."' align='$DataViewCenter[$i]'><font>".FormatTGL($row[$DataTabel[$i]])."</font></td>";

          }ELSEIF($DataTabel[$i]=="USER_ID"){
            $iSQL = "SELECT * FROM [SYSTEM_USER] WHERE USER_ID='".$row[$DataTabel[$i]]."'";
            $iData = Query_Data($iSQL);
            $ulData .= "<td bgcolor='".$warna."' align='$DataViewCenter[$i]'><font>".$iData[0]->NAMA."</font></td>";

          }ELSE{
            $ulData .= "<td bgcolor='".$warna."' align='$DataViewCenter[$i]'><font>".$row[$DataTabel[$i]]."</font></td>";
          }
          $i++;
      }

      $ulData .= "</tr>";
      $x++;
    }

$ulData .= "</table>";
Return $ulData;
}
//------------------------------------------------------------------------------





?>
