<?php
function list_ofWilVerifikator($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ScoringType;
    
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
     $tgrid->set_content(array("<b>Wilayah Verifikator</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM SYSTEM_VERIFIKATOR WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM SYSTEM_VERIFIKATOR WHERE 1=1 $where AND ID_VERIFIKATOR NOT IN(SELECT  TOP $curr_page  ID_VERIFIKATOR FROM SYSTEM_VERIFIKATOR WHERE 1=1 $where)";
     //print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("","5"));
     $tgrid->set_header_align(array("center","center","center","center"));
     $tgrid->set_header(array("No","Nama","Alamat","ACT"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data['ID_VERIFIKATOR']."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data['ID_VERIFIKATOR']."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","center")); 
        $tgrid->set_content_width(array("5","",""));       
        $tgrid->set_content(array($x, $data['VERIFIKATOR_NAME'],$data['VERIFIKATOR_ADDRESS']."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
        //$data_r[$data[ID_FORMULA]] = array("ID_FORMULA"=>"$data[ID_FORMULA]","FORMULA_NAME"=>"$data[FORMULA_NAME]","PARENT_FORMULA"=>"$data[PARENT_FORMULA]","FORMULA"=>"$data[FORMULA]");
     }
     $isi   .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi   .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Wilayah Verifikator",$isi);
}

  function frm_Verifikator($cmd){
      global $_ScoringType;
      if($_REQUEST[xid]!=""){
        $data             = get_verifikatorByid($_REQUEST[xid]);
        $vname            = $data['VERIFIKATOR_NAME'];
        $alamat           = nl2br($data['VERIFIKATOR_ADDRESS']);
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="Verifikator",$method="POST",array(  "action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST['xid']);                     
      
      $input	 = inputText($name="vname",$value=$vname,$ext=array("size"=>"30", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nama",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;    
      
      $input	 = inputTextArea($name="alamat",$value=$alamat,$ext=array("cols"=>"50", "rows"=>"5", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Alamat",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Wilayah Verifikator",$form);    
  }
  
  function verifikator_save($cmd){
      global  $msgDBSave, $msgDBError, $COOK_USER_ID;
      $nama     = $_REQUEST['vname'];
      $address  = $_REQUEST['alamat'];
      
      $sql      = " INSERT INTO SYSTEM_VERIFIKATOR (VERIFIKATOR_NAME, VERIFIKATOR_ADDRESS, STATUS, CREATED_BY, CREATED_TIMESTAMP)
                                            VALUES ('".$nama."', '".$address."', '1', '".$COOK_USER_ID."', GETDATE())";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
            return Template_KotakPolos("Wilayah Verifikator",$msgDBSave);
      }else{
            return Template_KotakPolos("Wilayah Verifikator",$msgDBError);
      }                                            
  }
  
  function verifikator_update($cmd){
      global  $msgDBSave, $msgDBError, $COOK_USER_ID;
      $nama     = $_REQUEST['vname'];
      $address  = $_REQUEST['alamat'];
      $id       = $_REQUEST['xid'];
      $sql      = " UPDATE SYSTEM_VERIFIKATOR SET VERIFIKATOR_NAME='".$nama."', VERIFIKATOR_ADDRESS='".$address."' WHERE ID_VERIFIKATOR='".$id."'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
            return Template_KotakPolos("Wilayah Verifikator",$msgDBSave);
      }else{
            return Template_KotakPolos("Wilayah Verifikator",$msgDBError);
      }                                            
  }  
  
  function  get_verifikatorByid($id){
      $sql    = " SELECT * FROM SYSTEM_VERIFIKATOR WHERE ID_VERIFIKATOR='".$id."'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      $data   = sqlsrv_fetch_array($query);
      return $data; 
  }
  
  //MEMO------------------------------------------------------------------------
  
  function frm_memo($cmd){
      global $_ScoringType;

      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="memo",$method="POST",array(  "action"		=> "index.php",
                                      							 "target" 	=> "_self",
                                      							 "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST['xid']);                     
      
      $input	 = inputTextArea($name="memo",$value=$memo,$ext=array("cols"=>"50", "rows"=>"5", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Memo",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;    
      
      $input	 = inputSubmit($name="action",$value="SEND",$ext=array("size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent",valign=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array());
      $row_id++;       	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Memo",$form);   
  }
  
  function save_memo($cmd){
      global  $COOK_USER_ID, $msgDBSave, $msgDBError;
      $id             = $_REQUEST['xid'];
      $memo           = $_REQUEST['memo'];
      if($memo!=""){
          $sql            = "exec SP_COPY_APPLICATION ".$id;
          GLOBAL $connectionInfo, $SQLHost;
          $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
          $query = sqlsrv_query($conn,$sql);
          $update_status  = module_updateStatusApplication($id, '2');
          $update_status  = module_updateStatusApplication_ver($id, '2');
          unset($sql);
          unset($query);
          $sql            = " INSERT INTO BUS_MEMO (ID_BUS_APPLICATION, MEMO, STATUS, CREATED_BY, CREATED_TIMESTAMP)
                              VALUES('".$id."', '".$memo."', '1', '".$COOK_USER_ID."', GETDATE())";
          $query          = sqlsrv_query($sql); 
          if($query==1){
                return Template_KotakPolos("Memo",$msgDBSave);
          }else{
                return Template_KotakPolos("Memo",$msgDBError);
          }       
      }else{
          return Template_KotakPolos("Memo",$msgDBError."<br>Memo tidak boleh KOSONG");
      }          
  }
  
function list_ofMemo($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ScoringType, $_USER;
     
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     
     $where .= " AND STATUS <> 99 AND ID_BUS_APPLICATION='".$_REQUEST['xid']."'";       
     $sql    = " SELECT * FROM BUS_MEMO WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM BUS_MEMO WHERE 1=1 $where AND ID_MEMO NOT IN(SELECT  TOP $curr_page  ID_MEMO FROM BUS_MEMO WHERE 1=1 $where)";
     #print $sql; 
     $query_pagging = sqlsrv_query($conn, $sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("","5"));
     $tgrid->set_header_align(array("center","center","center","center"));
     $tgrid->set_header(array("No","User","Memo","Date"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data['ID_VERIFIKATOR']."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data['ID_VERIFIKATOR']."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","center")); 
        $tgrid->set_content_width(array("5","",""));       
        $tgrid->set_content(array($x, $_USER[$data['CREATED_BY']],nl2br($data['MEMO'])."&nbsp;",date("d M Y", strtotime($data['CREATED_TIMESTAMP']))));
        $x++;
        //$data_r[$data[ID_FORMULA]] = array("ID_FORMULA"=>"$data[ID_FORMULA]","FORMULA_NAME"=>"$data[FORMULA_NAME]","PARENT_FORMULA"=>"$data[PARENT_FORMULA]","FORMULA"=>"$data[FORMULA]");
     }
     $isi   .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi   .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("List of Memo",$isi);
}  
?>
