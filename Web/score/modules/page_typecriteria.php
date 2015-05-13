<?php
  function daftar_typecriteria($cmd){
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
     $tgrid->set_content(array("<b>RISK ACCEPTANCE CRITERIA</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM TYPE_CRITERIA WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM TYPE_CRITERIA WHERE 1=1 $where AND ID_CRITERIA NOT IN(SELECT  TOP $curr_page  ID_CRITERIA FROM TYPE_CRITERIA WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("","5"));
     $tgrid->set_header_align(array("center","center"));
     $tgrid->set_header(array("CRITERIA",""));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_CRITERIA]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        #$delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_CRITERIA]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        #$tgrid->set_content_align(array("left","left","center")); 
        #$tgrid->set_content_width(array("5","","60"));       
        #$tgrid->set_content(array("$x",$data[CRITERIA_NAME]."&nbsp;",$edit."&nbsp;".$delete));
        #$x++;
        $data_r[$data[ID_CRITERIA]] = array("ID_CRITERIA"=>"$data[ID_CRITERIA]","CRITERIA_NAME"=>"$data[CRITERIA_NAME]","PARENT_CRITERIA"=>"$data[PARENT_CRITERIA]");
     }
     $tgrid->set_content_width("100%");
     $tgrid->set_content(array("","",generate_tree_list($data_r,"0","0",$cmd)));     
     #$isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("RISK ACCEPTANCE CRITERIA LIST",$isi);   
  }
  
  function frm_typecriteria($cmd){
      if($_REQUEST[xid]!=""){
        $data     = module_gettypecriteria_byid($_REQUEST[xid]);
        $nama     = $data[CRITERIA_NAME];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="typecriteria",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);               
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Criteria Name",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Criteria Name",$form);    
  }
  
  function save_typecriteria($cmd){
      global  $msgDBSave,  $msgDBError;
      $nama          = $_REQUEST[nama];
      $parent        = ($_REQUEST['parent']!=""?$_REQUEST['parent']:"0");
      $id            = getId("TYPE_CRITERIA","ID_CRITERIA");
      $sql           = "  INSERT INTO TYPE_CRITERIA(ID_CRITERIA,CRITERIA_NAME, PARENT_CRITERIA,STATUS)
                          VALUES('$id','$nama','$parent','1')";
      #print $sql;
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Criteria Name",$msgDBSave);
      }else{
         return Template_KotakPolos("Criteria Name",$msgDBError);
      }                        
  }
  
  function frm_typecriteriachild($cmd){
      #exit("###");
      global  $_CriteriaType;
      if($_REQUEST[xid]!=""){
        $data     = module_gettypecriteria_byid($_REQUEST[xid]);
        $nama     = $data[CRITERIA_NAME];
        $parent   = $data[PARENT_CRITERIA];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="typecriteria",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
      
      $input	 = inputSelect($name="parent",$value=$_CriteriaType,$parent,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Parent",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                    
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Criteria Name",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Criteria Name",$form);    
  }  
  
  function module_gettypecriteria_byid($id){
      $sql  = " SELECT * FROM TYPE_CRITERIA WHERE ID_CRITERIA='$id'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      return sqlsrv_fetch_array($query);
  } 
  function update_typecriteria($cmd){
      global  $msgDBSave,  $msgDBError, $msgDBUpdate;
      $nama          = $_REQUEST[nama];
      $id            = $_REQUEST[xid];
      $parent        = ($_REQUEST['parent']!=""?$_REQUEST['parent']:"0");
      $sql           = "  UPDATE TYPE_CRITERIA SET CRITERIA_NAME= '$nama', PARENTS_CRITERIA='$parent' WHERE ID_CRITERIA='$id' ";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Criteria Name",$msgDBUpdate);
      }else{
         return Template_KotakPolos("Criteria Name",$msgDBError);
      }                        
  }
  
  function generate_tree_list($array, $parent = "0", $level = "0", $cmd)
  { 
    global  $_CriteriaType;
    $x=1; 
    $has_children = false;
    #print_r($array);
    foreach($array as $key => $value)
    {
      if ($value['PARENT_CRITERIA'] == $parent) 
      { 
      
        $add    = "<a href=\"index.php?cmd=".$cmd."_child&xid=$value[ID_CRITERIA]\"><img src=\"includes/page_main/img/add.png\" border=\"0\" width=\"20\"></a>"; 
        $update = "<a href=\"index.php?cmd=".$cmd."_update".($value[PARENT_CRITERIA]!="0"?"_child":"")."&xid=$value[ID_CRITERIA]\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>"; 
        $delete = "<a href=\"index.php?cmd=".$cmd."_delete&xid=$value[ID_CRITERIA]\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        
        if ($has_children === false)
        {
          $has_children = true;  
          $level++;
        }        
                                          
        if($value[PARENT_CRITERIA]=="0"){
          $dt .= "<table width=\"100%\" ><tr><td class=\"tableheader\">".$_CriteriaType[$value['ID_CRITERIA']]."&nbsp;</td><td class=\"tableheader\" width=\"100\" align=\"center\">".$add."&nbsp;".$update."&nbsp;".$delete."&nbsp;".$select."</td></tr></table>";
        #   $dt .= $value[CRITERIA_NAME];
        }else{
          $dt .= "<table width=\"100%\" ><tr><td class=\"tablecontentgrid\">".str_repeat('<b><style=\"font-size:16px;\">&#9634;&nbsp;</style></b>',$level)."&nbsp;".$value['CRITERIA_NAME']."</td><td class=\"tablecontentgrid\" align=\"right\" width=\"100\">".($_REQUEST[cmd]!="CMD_SUBKATEGORI_search"?$add."&nbsp;".$update."&nbsp;".$delete:"&nbsp;".$select)."</td></tr></table>";
          $x++;
        }

        #$dt .= $value[PARENT_CRITERIA]."&nbsp;".$parent."<br>";
        #$select = "<a href=\"#\" onclick=\"sendpicker('$value[serial]','".$_SUBKATEGORIN[$value[serial]]."')\"><img src=\"PAGE/image/add.png\" border=\"0\" width=\"20\"></a>";
        
        $dt .= generate_tree_list($array, $key, $level, $cmd);                          

      }
       
    }
  
    return $dt;
  
  }
      
   
?>
