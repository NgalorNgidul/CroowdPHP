<?
  function daftar_unitkerja($cmd){
     global $COOK_USER_ID, $_UNITLOCATION, $_WILAYAH, $_MAX_REC_PER_PAGE, $_VerWilayah;
     
     //$cmd = $cmd."_crt";
     $addRecord =  "<form method='POST' action='index.php'>".
                   "<input type='submit' value='ADD' name='B1'>".
                   "<input type='hidden' value=".$cmd."_crt name='cmd'>".
                   "</form>";     
     
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_content_align(array("left"));
     $tgrid->set_content(array($addRecord));
     $tgrid->set_content_align(array("center"));
     $tgrid->set_content(array("<b>Daftar Unit Kerja</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99"; 
     if($_REQUEST[kode]!="")
      $where  .= " AND UNIT_CODE LIKE '%".trim($_REQUEST[kode])."%'";
     if($_REQUEST[nama]!="")
      $where  .= " AND UNIT_NAME LIKE '%".trim($_REQUEST[nama])."%'";       
     $sql    = " SELECT * FROM DOC_UNIT WHERE 1=1 $where";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM DOC_UNIT WHERE 1=1 $where AND ID_UNIT NOT IN(SELECT  TOP $curr_page  ID_UNIT FROM DOC_UNIT WHERE 1=1 $where ORDER BY UNIT_LOCATION, ID_UNIT) ORDER BY UNIT_LOCATION, ID_UNIT";
     #print  $sql_pagging;
     $query_pagging = sqlsrv_query($conn,$sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","","","","",""));
     $tgrid->set_header_align(array("center","center","center","center","center","center","center","center"));
     $tgrid->set_header(array("NO","KODE","UNIT KERJA","ALAMAT","LOKASI","WILAYAH", "VERIFIKATOR","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;     
     while($data=sqlsrv_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_UNIT]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_UNIT]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","left","left","left","left","center"));        
        $tgrid->set_content(array("$x",$data[UNIT_CODE],$data[UNIT_NAME]."&nbsp;",$data[UNIT_ADDRESS]."&nbsp;",$_UNITLOCATION[$data[UNIT_LOCATION]],$_WILAYAH[$data[ID_UNITREGION]]."&nbsp;",$_VerWilayah[$data[ID_VERIFIKATOR]]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Daftar Unit Kerja",$isi);    
  }
  
  function frm_unitkerja($cmd){
      global  $_UNITLOCATION, $_WILAYAH, $_VerWilayah;
      if($_REQUEST[xid]!=""){
        $data     = module_getunitkerjabyid($_REQUEST[xid]);
        $kode     = $data[UNIT_CODE];
        $nama     = $data[UNIT_NAME];
        $alamat   = $data[UNIT_ADDRESS];
        $location = $data[UNIT_LOCATION];
        $wilayah  = $data[UNIT_REGION];
      }
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="unitkerja",$method="POST",array(	"action"		=> "index.php",
                                      									"target" 		=> "_self",
                                      									"enctype" 		=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
      
      $input	 = inputText($name="kode",$value=$kode,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Kode",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("onkeypress"=> "return disableEnter(this,event);", "size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nama",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;               
      
      $input	 = inputTextArea($name="alamat",$value=$alamat,$ext=array("cols"=>"50", "rows"=>"5"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Alamat",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="location",$value=$_UNITLOCATION, $location,$ext=array(""=>""));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Lokasi",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="verifikator",$value=array(""=>"")+$_VerWilayah, $verifikator,$ext=array(""=>""));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Verifikator",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;      
      
      $input	 = inputSelect($name="wilayah",$value=$_WILAYAH, $wilayah,$ext=array(""=>""));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Wilayah",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                     
      
      $input	 = inputSubmit($name="action",$value="SAVE",$ext=array("size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent",valign=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array());
      $row_id++;       	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Unit Kerja",$form);    
  }
  
  function unitkerja_save($cmd){
    global  $msgDBSave, $msgDBError;
    $id            = getId("DOC_UNIT","ID_UNIT");
    $unit_code     = $_REQUEST[kode];
    $unit_name     = $_REQUEST[nama];
    $unit_address  = $_REQUEST[alamat];
    $unit_location = $_REQUEST[location];
    $unit_region   = $_REQUEST[wilayah];
    $id_verifikator= $_REQUEST[verifikator];
    $cek_name      = $unit_name;
    if($cek_name>0){
      return Template_KotakPolos("Unit Kerja","Maaf, Nama unit kerja yang anda masukkan telah tersedia");
    }else{
      if($id!="" && $unit_code!="" && $unit_name!="" && $unit_address!="" && $unit_location!=""){
        $sql           = " INSERT INTO DOC_UNIT (ID_UNIT, UNIT_CODE, UNIT_NAME, UNIT_ADDRESS, UNIT_LOCATION, STATUS, ID_UNITREGION, ID_VERIFIKATOR)
                           VALUES('$id', '$unit_code','$unit_name','$unit_address','$unit_location','1','$unit_region','$id_verifikator')";
        GLOBAL $connectionInfo, $SQLHost;
        $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
        $query = sqlsrv_query($conn,$sql);
        if($query){
           return Template_KotakPolos("Unit Kerja",$msgDBSave);
        }else{
           return Template_KotakPolos("Unit Kerja",$msgDBError);
        }    
      }else{
        return Template_KotakPolos("Unit Kerja",$msgDBError."<hr><span style=\"color:red\">..::: Semua field harus diisi :::..
  </font>");
      }    
    }
  }
  
  function cek_unitkerjaname($name){
      $name = trim(strtolower($name));
      $sql  = " SELECT * FROM DOC_UNIT WHERE UNITNAME='$name'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      return sqlsrv_num_rows($query);  
  }
  
  function module_getunitkerjabyid($id){
    $sql  = "SELECT * FROM DOC_UNIT WHERE ID_UNIT='$id'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    $data  = sqlsrv_fetch_array($query);
    return $data;
  }
  
  function unitkerja_update($cmd){
    global  $msgDBSave, $msgDBError, $msgDBUpdate;
    $id            = $_REQUEST[xid];;
    $unit_code     = $_REQUEST[kode];
    $unit_name     = $_REQUEST[nama];
    $unit_address  = $_REQUEST[alamat];
    $unit_location = $_REQUEST[location];
    $unit_region   = $_REQUEST[wilayah];
    $id_verifikator= $_REQUEST[verifikator];
    if($id!="" && $unit_code!="" && $unit_name!="" && $unit_address!="" && $unit_location!=""){
      $sql           = " UPDATE DOC_UNIT SET UNIT_CODE='$unit_code', UNIT_NAME='$unit_name', UNIT_ADDRESS='$unit_address', UNIT_LOCATION='$unit_location', ID_UNITREGION='$unit_region', ID_VERIFIKATOR='$id_verifikator' WHERE ID_UNIT='$id'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Unit Kerja",$msgDBUpdate);
      }else{
         return Template_KotakPolos("Unit Kerja",$msgDBError);
      }    
    }else{
      return Template_KotakPolos("Unit Kerja",$msgDBError."<hr><span style=\"color:red\">..::: Semua field harus diisi :::..
</font>");
    }

  }
  
  function daftar_unitlocation($cmd){
     global $COOK_USER_ID, $_UNITLOCATION, $_MAX_REC_PER_PAGE;
     
     //$cmd = $cmd."_crt";
     $addRecord =  "<form method='POST' action='index.php'>".
                   "<input type='submit' value='ADD' name='B1'>".
                   "<input type='hidden' value=".$cmd."_crt name='cmd'>".
                   "</form>";     
     
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_content_align(array("left"));
     $tgrid->set_content(array($addRecord));
     $tgrid->set_content_align(array("center"));
     $tgrid->set_content(array("<b>Unit Wilayah Kerja</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";        
     $sql    = " SELECT * FROM DOC_UNIT_REGION WHERE 1=1 $where";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM DOC_UNIT_REGION WHERE 1=1 $where AND ID_UNITREGION NOT IN(SELECT  TOP $curr_page  ID_UNITREGION FROM DOC_UNIT_REGION WHERE 1=1 $where ) ";
     #print  $sql_pagging;
     $query_pagging = sqlsrv_query($conn,$sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","",""));
     $tgrid->set_header_align(array("center","center","center","center"));
     $tgrid->set_header(array("NO","KODE","Unit Wilayah Kerja","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;     
     while($data=sqlsrv_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_UNITREGION]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_UNITREGION]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","left","left","center"));        
        $tgrid->set_content(array("$x",$data[REGION_CODE],$data[REGION_NAME]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Unit Wilayah Kerja",$isi);    

  }
  
  function frm_unitlocation($cmd){
      if($_REQUEST[xid]!=""){
        $data = get_unitlocationbyid($_REQUEST[xid]);
        $kode = $data[REGION_CODE];
        $nama = $data[REGION_NAME];
      }
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="unitkerjalocation",$method="POST",array(	 "action"		=> "index.php",
                                      									           "target" 		=> "_self",
                                      									           "enctype" 		=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
      
      $input	 = inputText($name="kode",$value=$kode,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Kode Unit Location",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("onkeypress"=> "return disableEnter(this,event);", "size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nama Unit Location",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;               
         
      $input	 = inputSubmit($name="action",$value="SAVE",$ext=array("size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent",valign=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array());
      $row_id++;       	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Unit Wilayah Kerja",$form);  
  } 
  
  function save_unitlocationadd($cmd){
    global  $msgDBSave, $msgDBError;
    $id            = getId("DOC_UNIT_REGION","ID_UNITREGION");
    $unit_code     = $_REQUEST[kode];
    $unit_name     = $_REQUEST[nama];
    if($unit_code!="" && $unit_name!=""){
        $sql           = " INSERT INTO DOC_UNIT_REGION (ID_UNITREGION, REGION_CODE, REGION_NAME, STATUS)
                           VALUES('$id','$unit_code','$unit_name','1')";
        #print $sql;
        GLOBAL $connectionInfo, $SQLHost;
        $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
        $query = sqlsrv_query($conn,$sql);
        if($query){
           return Template_KotakPolos("Unit Wilayah Kerja",$msgDBSave);
        }else{
           return Template_KotakPolos("Unit Wilayah Kerja",$msgDBError);
        }    
    }else{
        return Template_KotakPolos("Unit Wilayah Kerja",$msgDBError."<br>..::: Semua field harus diisi :::..");
    }
  } 
  
  function get_unitlocationbyid($id){
    $sql    = " SELECT * FROM DOC_UNIT_REGION WHERE ID_UNITREGION='$id'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    $data   = sqlsrv_fetch_array($query);
    return $data;
  }
  
  function save_unitlocationupdate($cmd){
    global  $msgDBSave, $msgDBError, $msgDBUpdate;
    $unit_code     = $_REQUEST[kode];
    $unit_name     = $_REQUEST[nama];
    $sql           = " UPDATE DOC_UNIT_REGION SET REGION_CODE='$unit_code', REGION_NAME='$unit_name'
                       WHERE ID_UNITREGION='$_REQUEST[xid]'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    if($query){
       return Template_KotakPolos("Unit Wilayah Kerja",$msgDBUpdate);
    }else{
       return Template_KotakPolos("Unit Wilayah Kerja",$msgDBError);
    } 
  }
  
  function frm_searchcabang($cmd){
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="unitkerjalocation",$method="POST",array(	 "action"		=> "index.php",
                                      									           "target" 		=> "_self",
                                      									           "enctype" 		=> "multipart/form-data"));
      
      $cmd  = $cmd."_search";
      $cf->fhidden($name="cmd", $value="$cmd");
      
      $input	 = inputText($name="kode",$value=$kode,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Kode",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("onkeypress"=> "return disableEnter(this,event);", "size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Unit Kerja",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;               
         
      $input	 = inputSubmit($name="action",$value="SEARCH",$ext=array("size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent",valign=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array());
      $row_id++;       	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Pencarian",$form);  
  }
?>
