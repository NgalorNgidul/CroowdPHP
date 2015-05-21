<?php

  function list_min_scoring($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ScoringType, $_ApplicationType, $_JPERMOHONAN, $COOK_USERUNIT, $_USER, $_UNITNAME;
    
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
     $tgrid->set_content(array("<b>Minimum Score</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM BUS_MIN_SCORING WHERE 1=1 $where";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM BUS_MIN_SCORING WHERE 1=1 $where AND ID_MIN_SCORING NOT IN(SELECT  TOP $curr_page  ID_MIN_SCORING FROM BUS_MIN_SCORING WHERE 1=1 $where)";
     #print $sql; 
     $query_pagging = sqlsrv_query($conn, $sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","180","","100"));
     $tgrid->set_header_align(array("center","center","center","center"));
     $tgrid->set_header(array("NO","SCORING TYPE","NILAI MINIMUM","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        #$detail= "<a href=\"index.php?cmd=".$cmd."_detail&case=1&xid=".$data[ID_MIN_SCORING]."\"><img src=\"includes/page_main/img/detail.png\" border=\"0\" width=\"15\"></a>";     
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&case=1&xid=".$data[ID_MIN_SCORING]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_MIN_SCORING]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("center","left","right","center")); 
        $tgrid->set_content_width(array("5","180","","100"));       
        $tgrid->set_content(array("$x",$_ScoringType[$data[ID_SCORING_TYPE]]."&nbsp;",$data[MIN_SCORING_VALUE]."&nbsp;",$detail."&nbsp;".($data[STATUS]!="2"?$edit:"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")."&nbsp;".($data[STATUS]!="2"?$delete:"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build(); 
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Minimum Score",$isi);  
  }
  
  function frm_min_scoring($cmd){
      global  $_ScoringType;
      if($_REQUEST[xid]!=""){

      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="scoringcollateral",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);               
      
      $input	 = inputSelect($name="scoringtype",$value=$_ScoringType,$scoringtype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Type",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="minvalue",$value=$_minvalue,$ext=array("onkeypress"=> "return disableEnter(this,event);", "size"=>"10","onkeyup"=>"onlynumeric(this)"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Minimum Score",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Minimum Score",$form);      
  }
  
  function save_min_score($cmd){
      global  $msgDBSave,  $msgDBError;
      $scoringtype          = $_REQUEST[scoringtype];
      $min_value            = $_REQUEST[minvalue];
      $id                   = getId("BUS_MIN_SCORING","ID_MIN_SCORING");
      $sql= " INSERT INTO BUS_MIN_SCORING (ID_MIN_SCORING,ID_SCORING_TYPE,MIN_SCORING_VALUE,STATUS)
              VALUES('$id','$scoringtype','$min_value','1')";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Minimum Score",$msgDBSave);
      }else{
         return Template_KotakPolos("Minimum Score",$msgDBError);
      }       
  }

?>
