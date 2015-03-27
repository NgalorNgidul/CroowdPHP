<?php
  function daftar_scoringtype($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE;
    
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
     $tgrid->set_content(array("<b>Scoring Type List</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM SCORING_TYPE WHERE 1=1 $where";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM SCORING_TYPE WHERE 1=1 $where AND ID_SCORING_TYPE NOT IN(SELECT  TOP $curr_page  ID_SCORING_TYPE FROM SCORING_TYPE WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","5"));
     $tgrid->set_header_align(array("center","center","center"));
     $tgrid->set_header(array("NO","SCORING TYPE","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_SCORING_TYPE]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_SCORING_TYPE]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","center")); 
        $tgrid->set_content_width(array("5","","60"));       
        $tgrid->set_content(array("$x",$data[SCORING_TYPE_NAME]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Scoring Type List",$isi);   
  }
  
  function frm_scoringtype($cmd){
      if($_REQUEST[xid]!=""){
        $data     = module_getscoringtype_byid($_REQUEST[xid]);
        $nama     = $data[SCORING_TYPE_NAME];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="scoringtype",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);               
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Type Name",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Scoring Type",$form);    
  }
  
  function save_scoringtype($cmd){
      global  $msgDBSave,  $msgDBError;
      $nama          = $_REQUEST[nama];
      if($nama!=""){
          $id            = getId("SCORING_TYPE","ID_SCORING_TYPE");
          $sql           = "  INSERT INTO SCORING_TYPE(ID_SCORING_TYPE,SCORING_TYPE_NAME,STATUS)
                              VALUES('$id','$nama','1')";
          GLOBAL $connectionInfo, $SQLHost;
          $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
          $query = sqlsrv_query($conn,$sql);
          if($query){
             return Template_KotakPolos("Scoring Type",$msgDBSave);
          }else{
             return Template_KotakPolos("Scoring Type",$msgDBError);
          }       
      }else{
           return Template_KotakPolos("Scoring Type",$msgDBError."<br>..::: Semua field harus diisi :::..");
      }                       
  }
  
  function module_getscoringtype_byid($id){
      $sql  = " SELECT * FROM SCORING_TYPE WHERE ID_SCORING_TYPE='$id'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      return sqlsrv_fetch_array($query);
  } 
  function update_scoringtype($cmd){
      global  $msgDBSave,  $msgDBError, $msgDBUpdate;
      $nama          = $_REQUEST[nama];
      $id            = $_REQUEST[xid];
      $sql           = "  UPDATE SCORING_TYPE SET SCORING_TYPE_NAME= '$nama' WHERE ID_SCORING_TYPE='$id' ";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Scoring Type",$msgDBUpdate);
      }else{
         return Template_KotakPolos("Scoring Type",$msgDBError);
      }                        
  }  
   
?>
