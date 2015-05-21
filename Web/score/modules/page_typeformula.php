<?php
  function daftar_typeformula($cmd){
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
     $tgrid->set_content(array("<b>Rumus Rasio Keuangan</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM TYPE_FORMULA WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM TYPE_FORMULA WHERE 1=1 $where AND ID_FORMULA NOT IN(SELECT  TOP $curr_page  ID_FORMULA FROM TYPE_FORMULA WHERE 1=1 $where)";
     #print $sql; 
     $query_pagging = sqlsrv_query($conn, $sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("","5"));
     $tgrid->set_header_align(array("center","center"));
     $tgrid->set_header(array("Rumus",""));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_FORMULA]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        #$delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_FORMULA]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        #$tgrid->set_content_align(array("left","left","center")); 
        #$tgrid->set_content_width(array("5","","60"));       
        #$tgrid->set_content(array("$x",$data[FORMULA_NAME]."&nbsp;",$edit."&nbsp;".$delete));
        #$x++;
        $data_r[$data[ID_FORMULA]] = array("ID_FORMULA"=>"$data[ID_FORMULA]","FORMULA_NAME"=>"$data[FORMULA_NAME]","PARENT_FORMULA"=>"$data[PARENT_FORMULA]","FORMULA"=>"$data[FORMULA]");
     }
     $tgrid->set_content_width("100%");
     $tgrid->set_content(array("","",generate_tree_listformula($data_r,"0","0",$cmd)));     
     #$isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Rumus Rasio Keuangan List",$isi);   
  }
  
  function frm_typeformula($cmd){
      global $_ScoringType;
      if($_REQUEST[xid]!=""){
        $data     = module_gettypeformula_byid($_REQUEST[xid]);
        $nama     = $data[FORMULA_NAME];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="typeformula",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
      
      $input	 = inputSelect($name="scoringtype",$value=$_ScoringType,$scoringtype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Type",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                       
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Rumus",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Rumus Rasio Keuangan",$form);    
  }
  
  function save_typeformula($cmd){
      global  $msgDBSave,  $msgDBError;
      $nama          = $_REQUEST[nama];
      $parent        = ($_REQUEST['parent']!=""?$_REQUEST['parent']:"0");
      $rumus         = $_REQUEST[rumus];
      $scoring_type  = $_REQUEST[scoringtype];
      $id            = getId("TYPE_FORMULA","ID_FORMULA");
      $sql           = "  INSERT INTO TYPE_FORMULA(ID_FORMULA,FORMULA_NAME, PARENT_FORMULA,STATUS,ID_SCORING_TYPE,FORMULA)
                          VALUES('$id','$nama','$parent','1','$scoring_type','$rumus')";
      #print $sql;
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Rumus Rasio Keuangan",$msgDBSave);
      }else{
         return Template_KotakPolos("Rumus Rasio Keuangan",$msgDBError);
      }                        
  }
  
  function frm_typeformulachild($cmd){
      global  $_FormulaType, $_ScoringType;
      if($_REQUEST[xid]!=""){
        $data     = module_gettypeformula_byid($_REQUEST[xid]);
        $nama     = $data[FORMULA_NAME];
        $parent   = ($data[PARENT_FORMULA]!="0"?$data[PARENT_FORMULA]:$_REQUEST[xid]);
        $rumus    = $data[FORMULA];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="typeformula",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
      
      $input	 = inputSelect($name="scoringtype",$value=$_ScoringType,$scoringtype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Type",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;      
      
      $input	 = inputSelect($name="parent",$value=$_FormulaType,$parent,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Parent",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                    
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Rumus Name",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="rumus",$value=$rumus,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);","suffix"=>"<b>e.g.:</b> ( &lsaquo;1&rsaquo; + &lsaquo;2&rsaquo; ) / &lsaquo;3&rsaquo;"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Rumus",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Rumus Rasio Keuangan",$form);    
  }  
  
  function module_gettypeformula_byid($id){
      $sql  = " SELECT * FROM TYPE_FORMULA WHERE ID_FORMULA='$id'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      return sqlsrv_fetch_array($query);
  } 
  function update_typeformula($cmd){
      global  $msgDBSave,  $msgDBError, $msgDBUpdate;
      $nama          = $_REQUEST[nama];
      $id            = $_REQUEST[xid];
      $parent        = ($_REQUEST['parent']!=""?$_REQUEST['parent']:"0");
      $scoringtype   = $_REQUEST[scoringtype];
      $rumus         = $_REQUEST[rumus];
      $sql           = "  UPDATE TYPE_FORMULA SET FORMULA_NAME= '$nama', PARENT_FORMULA='$parent', ID_SCORING_TYPE='$scoringtype', FORMULA='$rumus' WHERE ID_FORMULA='$id' ";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Rumus Rasio Keuangan",$msgDBUpdate);
      }else{
         return Template_KotakPolos("Rumus Rasio Keuangan",$msgDBError);
      }                        
  }
  
  function generate_tree_listformula($array, $parent = "0", $level = "0", $cmd)
  { 
    global  $_FormulaType;
    $x=1; 
    $has_children = false;
    #print_r($array);
    foreach($array as $key => $value)
    {
      if ($value['PARENT_FORMULA'] == $parent) 
      { 
      
        $add    = "<a href=\"index.php?cmd=".$cmd."_child&xid=$value[ID_FORMULA]\"><img src=\"includes/page_main/img/add.png\" border=\"0\" width=\"20\"></a>"; 
        $update = "<a href=\"index.php?cmd=".$cmd."_update".($value[PARENT_FORMULA]!="0"?"_child":"")."&xid=$value[ID_FORMULA]\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>"; 
        $delete = "<a href=\"index.php?cmd=".$cmd."_delete&xid=$value[ID_FORMULA]\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        
        if ($has_children === false)
        {
          $has_children = true;  
          $level++;
        }        
                                          
        if($value[PARENT_FORMULA]=="0"){
          $dt .= "<table width=\"100%\" ><tr><td class=\"tableheader\">".$_FormulaType[$value['ID_FORMULA']]."&nbsp;</td><td class=\"tableheader\" width=\"100\" align=\"center\">".$add."&nbsp;".$update."&nbsp;".$delete."&nbsp;".$select."</td></tr></table>";
        #   $dt .= $value[FORMULA_NAME];
        }else{
          $dt .= "<table width=\"100%\" ><tr><td class=\"tablecontentgrid\">".str_repeat('<b><style=\"font-size:16px;\">&#9634;&nbsp;</style></b>',$level)."&nbsp;".$value['FORMULA_NAME']."</td><td class=\"tablecontentgrid\" width=\"300\" align=\"right\">".$value[FORMULA]."&nbsp;</td><td class=\"tablecontentgrid\" align=\"right\" width=\"100\">".($_REQUEST[cmd]!="CMD_SUBKATEGORI_search"?$add."&nbsp;".$update."&nbsp;".$delete:"&nbsp;".$select)."</td></tr></table>";
          $x++;
        }

        #$dt .= $value[PARENT_FORMULA]."&nbsp;".$parent."<br>";
        #$select = "<a href=\"#\" onclick=\"sendpicker('$value[serial]','".$_SUBKATEGORIN[$value[serial]]."')\"><img src=\"PAGE/image/add.png\" border=\"0\" width=\"20\"></a>";
        
        $dt .= generate_tree_listformula($array, $key, $level, $cmd);                          

      }
       
    }
  
    return $dt;
  
  }
  
  function daftar_busformula($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_FormulaType, $_NeracaType;
    
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
     $tgrid->set_content(array("<b>Parameter Rasio Keuangan</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM BUS_FORMULA WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM BUS_FORMULA WHERE 1=1 $where AND ID_BUS_FORMULA NOT IN(SELECT  TOP $curr_page  ID_BUS_FORMULA FROM BUS_FORMULA WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","","","5"));
     $tgrid->set_header_align(array("center","center","center","center","center"));
     $tgrid->set_header(array("NO","Rumus Name","Parameter ke","Nama Parameter","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_INFOCIF]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_BUS_FORMULA]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","left","center")); 
        $tgrid->set_content_width(array("5","","","60"));       
        $tgrid->set_content(array("$x",$_FormulaType[$data[ID_FORMULA]]."&nbsp;",$data[ID_SORT]."&nbsp;",$_NeracaType[$data[ID_NERACA]]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Parameter Rasio Keuangan",$isi);   
  }
  
  function frm_busformula($cmd){
      global $_FormulaType, $_NeracaType;
      if($_REQUEST[xid]!=""){
        $data     = module_gettypeformula_byid($_REQUEST[xid]);
        $nama     = $data[FORMULA_NAME];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="busformula",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);               
      
      $input	 = inputSelect($name="tipeformula",$value=$_FormulaType, $tipeformula,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Rumus Name",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="tipeneraca",$value=$_NeracaType, $tipeneraca,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Parameter Name (from Laporan Keuangan)",$ext=array("width"=>"280","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      //$input	 = inputText($name="prefix",$value=$prefix,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);","maxlength"=>"1"));
      //$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      //$cf->set_col_header($row_id,$text="Prefix",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      //$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      //$row_id++; 
      
      //$input	 = inputText($name="suffix",$value=$suffix,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);","maxlength"=>"1"));
      //$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      //$cf->set_col_header($row_id,$text="Suffix",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      //$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      //$row_id++;                   
      
      //$input	 = inputText($name="opr",$value=$opr,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);","maxlength"=>"1"));
      //$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      //$cf->set_col_header($row_id,$text="Operator",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      //$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      //$row_id++;       
      
      $input	 = inputSubmit($name="action",$value="SAVE",$ext=array("size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent",valign=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array());
      $row_id++;       	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Parameter Rasio Keuangan",$form);    
  }
  
  function frm_busformula_save($cmd){
      global  $msgDBSave,  $msgDBError;
      $tipeformula          = $_REQUEST[tipeformula];
      $tipeneraca           = $_REQUEST[tipeneraca];
      $id_sort              = get_SortFormula($tipeformula);
      $cek                  = cek_FormulaParam($tipeformula);
      if($id_sort<=$cek){
        $id            = getId("BUS_FORMULA","ID_BUS_FORMULA");
        $sql           = "  INSERT INTO BUS_FORMULA(ID_BUS_FORMULA, ID_FORMULA, ID_NERACA, ID_SORT, STATUS)
                            VALUES('$id','$tipeformula','$tipeneraca','$id_sort','1')";
        #print $cek;
        GLOBAL $connectionInfo, $SQLHost;
        $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
        $query = sqlsrv_query($conn,$sql);
        if($query){
           return Template_KotakPolos("Parameter Rasio Keuangan",$msgDBSave);
        }else{
           return Template_KotakPolos("Parameter Rasio Keuangan",$msgDBError);
        }         
      }else{
          return Template_KotakPolos("Parameter Rasio Keuangan",$msgDBError.", Parameter melebihi formula yang ada");
      }
  }
  
  function get_SortFormula ($id_formula){
      $sql    = " SELECT MAX(ID_SORT) AS LAST_RECORD FROM BUS_FORMULA WHERE ID_FORMULA='$id_formula' AND STATUS<>'99'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      $data   = sqlsrv_mssql_fetch_array($query);
      
      $id     = $data[LAST_RECORD]+1;
      return $id;
  }
  
  function cek_FormulaParam($id_formula){
      $sql    = " SELECT * FROM TYPE_FORMULA WHERE ID_FORMULA='$id_formula'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      $data   = sqlsrv_fetch_array($query);
      
      $formula= $data[FORMULA];
      $param  = explode("<",$formula);
      $jml    = count($param)-1;
      return $jml;  
  }
      
   
?>
