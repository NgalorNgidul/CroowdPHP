<?php
  function daftar_scoringinfocif($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ScoringType, $_InfoCIFType;
    
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
     $tgrid->set_content(array("<b>Daftar Scoring Info CIF</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM SCORING_INFOCIF WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM SCORING_INFOCIF WHERE 1=1 $where AND ID_SC_INFOCIF NOT IN(SELECT  TOP $curr_page  ID_SC_INFOCIF FROM SCORING_INFOCIF WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","","5"));
     $tgrid->set_header_align(array("center","center","center","center"));
     $tgrid->set_header(array("NO","TIPE SCORING","TIPE INFO CIF","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_INFOCIF]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_SC_INFOCIF]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("center","left","left","center")); 
        $tgrid->set_content_width(array("5","","","30"));       
        $tgrid->set_content(array("$x",$_ScoringType[$data[ID_SCORING_TYPE]]."&nbsp;",$_InfoCIFType[$data[ID_INFOCIF]]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Daftar Scoring Info CIF",$isi);   
  }
  
   function frm_scoringinfocif($cmd){
      global  $_ScoringType, $_InfoCIFType;
      if($_REQUEST[xid]!=""){
        $data     = module_gettypecif_byid($_REQUEST[xid]);
        $nama     = $data[CIFINFO_NAME];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="scoringinfocif",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);               
      
      $input	 = inputSelect($name="scoringtype",$value=$_ScoringType,$scoringtype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Tipe Scoring",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="criteriatype",$value=$_InfoCIFType,$criteriatype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Tipe Info CIF",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Scoring Info CIF",$form);    
  }   
  
  function save_scoringinfocif($cmd){
      global  $msgDBSave,  $msgDBError;
      $scoringtype          = $_REQUEST[scoringtype];
      $criteriatype          = $_REQUEST[criteriatype];
      $id            = getId("SCORING_INFOCIF","ID_SC_INFOCIF");
      $sql           = "  INSERT INTO SCORING_INFOCIF(ID_SC_INFOCIF,ID_INFOCIF,ID_SCORING_TYPE,STATUS)
                          VALUES('$id','$criteriatype','$scoringtype','1')";
      #print $sql;
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Scoring Info CIF",$msgDBSave);
      }else{
         return Template_KotakPolos("Scoring Info CIF",$msgDBError);
      }                        
  }    
?>