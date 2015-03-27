<?php
  function daftar_scoringvalue($cmd){
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
     $tgrid->set_content(array("<b>Scoring Parameter List</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM TYPE_SCORINGVALUE WHERE 1=1 $where";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM TYPE_SCORINGVALUE WHERE 1=1 $where AND ID_SCORINGVALUE NOT IN(SELECT  TOP $curr_page  ID_SCORINGVALUE FROM TYPE_SCORINGVALUE WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","5"));
     $tgrid->set_header_align(array("center","center","center"));
     $tgrid->set_header(array("NO","SCORING PARAMETER","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        $add   = "<a href=\"index.php?cmd=CMD_SCORINGPOINT&id=".$data[ID_SCORINGVALUE]."\"><img src=\"includes/page_main/img/ok_lt_on.gif\" border=\"0\"></a>";
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_SCORINGVALUE]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_SCORINGVALUE]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","center")); 
        $tgrid->set_content_width(array("5","","100"));       
        $tgrid->set_content(array("$x",$data[SCORINGVALUE_NAME]."&nbsp;",$add."&nbsp;".$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Scoring Parameter List",$isi);   
  }
  
  function frm_scoringvalue($cmd){
      global $_APPFIELD, $_NeracaType, $_FormulaType, $_ScoringType, $_CollType;
      if($_REQUEST[xid]!=""){
        $data           = module_getscoringvalue_byid($_REQUEST[xid]);
        $nama           = $data[SCORINGVALUE_NAME];
        $application    = $data[APPLICATION];
        $neraca         = $data[NERACA];
        $formula        = $data[FORMULA];
        $id_tipescoring = $data[ID_SCORING_TYPE];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="scoringvalue",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]); 
      
      $input	 = inputSelect($name="tipescoring",$value=$_ScoringType, $tipescoring,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Type",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                    
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Parameter Name",$ext=array("width"=>"180","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = "Pilih salah satu dari pilihan di bawah ini:";
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$input,$ext=array("class"=>"tablecontent","valign"=>"top","colspan"=>"2"));
      $row_id++;
      
      $input	 = inputSelect($name="application",$value=array(""=>"")+$_APPFIELD,$application,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Aplikasi",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="neraca",$value=array(""=>"")+$_NeracaType,$neraca,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Laporan Keuangan",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++; 
      
      $input	 = inputSelect($name="formula",$value=array(""=>"")+$_FormulaType,$formula,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Ratio Keuangan",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="colltype",$value=array(""=>"")+$_CollType,$colltype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Jenis Collateral",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Scoring Parameter",$form);    
  }
  
  function save_scoringvalue($cmd){
      global  $msgDBSave,  $msgDBError;
      $nama          = $_REQUEST[nama];
      $application   = $_REQUEST[application];
      $neraca        = $_REQUEST[neraca];
      $formula       = $_REQUEST[formula];
      $colltype      = $_REQUEST[colltype];
      $id_tipescoring = $_REQUEST[tipescoring];
      if($nama!=""){
          if($application!=""){
              if($neraca=="" && $formula=="" && $colltype==""){
                  $msg  = "1";
              }else{
                  $msg  = "0";
              }
          }elseif($neraca!=""){
              if($application=="" && $formula=="" && $colltype==""){
                  $msg  = "1";
              }else{
                  $msg  = "0";
              }      
          }elseif($formula!=""){
              if($application=="" && $neraca=="" && $colltype==""){
                  $msg  = "1";
              }else{
                  $msg  = "0";
              }      
          }elseif($colltype!=""){
              if($application=="" && $neraca=="" && $formula==""){
                  $msg  = "1";
              }else{
                  $msg  = "0";
              }      
          }
          if($msg=="1"){
            $id            = getId("TYPE_SCORINGVALUE","ID_SCORINGVALUE");
            $sql           = "  INSERT INTO TYPE_SCORINGVALUE(ID_SCORINGVALUE,SCORINGVALUE_NAME,STATUS, APPLICATION, NERACA, FORMULA, ID_SCORING_TYPE, COLLTYPE)
                                VALUES('$id','$nama','1','$application','$neraca','$formula','$id_tipescoring', '$colltype')";
            GLOBAL $connectionInfo, $SQLHost;
            $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
            $query = sqlsrv_query($conn,$sql);
            if($query){
               return Template_KotakPolos("Scoring Parameter",$msgDBSave);
            }else{
               return Template_KotakPolos("Scoring Parameter",$msgDBError);
            }       
          }else{
              return Template_KotakPolos("Scoring Parameter",$msgDBError);
          }      
      }else{
          return Template_KotakPolos("Scoring Parameter",$msgDBError."<br>..::: Semua field harus diisi :::..");
      }                       
  }
  
  function module_getscoringvalue_byid($id){
      $sql  = " SELECT * FROM TYPE_SCORINGVALUE WHERE ID_SCORINGVALUE='$id'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      return sqlsrv_fetch_array($query);
  } 
  function update_scoringvalue($cmd){
      global  $msgDBSave,  $msgDBError, $msgDBUpdate;
      $nama           = $_REQUEST[nama];
      $id             = $_REQUEST[xid];
      $application    = $_REQUEST[application];
      $neraca         = $_REQUEST[neraca];
      $formula        = $_REQUEST[formula];
      $colltype       = $_REQUEST[colltype];
      $id_tipescoring = $_REQUEST[tipescoring];
      if($application!=""){
          if($neraca=="" && $formula=="" && $colltype==""){
              $msg  = "1";
          }else{
              $msg  = "0";
          }
      }elseif($neraca!=""){
          if($application=="" && $formula=="" && $colltype==""){
              $msg  = "1";
          }else{
              $msg  = "0";
          }      
      }elseif($formula!=""){
          if($application=="" && $neraca=="" && $colltype==""){
              $msg  = "1";
          }else{
              $msg  = "0";
          }      
      }elseif($colltype!=""){
          if($application=="" && $neraca=="" && $formula==""){
              $msg  = "1";
          }else{
              $msg  = "0";
          }      
      }
      if($msg=="1"){
          $sql           = "  UPDATE TYPE_SCORINGVALUE SET ID_SCORING_TYPE='$id_tipescoring', SCORINGVALUE_NAME= '$nama', APPLICATION='$application', NERACA='$neraca', FORMULA='$formula', COLLTYPE='$colltype' WHERE ID_SCORINGVALUE='$id' ";
          GLOBAL $connectionInfo, $SQLHost;
          $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
          $query = sqlsrv_query($conn,$sql);
          if($query){
             return Template_KotakPolos("Scoring Parameter",$msgDBUpdate);
          }else{
             return Template_KotakPolos("Scoring Parameter",$msgDBError);
          }       
      }else{
          return Template_KotakPolos("Scoring Parameter",$msgDBError);
      }            
                       
  }
  
//------------------------------------------------------------------------------

  function daftar_scoringpoint($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ScoringValue;
    
     $addRecord =  "<form method='POST' action='index.php'>".
                   "<input type='submit' value='ADD' name='B1'>".
                   "<input type='hidden' value=".$cmd."_crt name='cmd'>".
                   "<input type='hidden' value='$_REQUEST[id]' name='id'>".
                   "</form>";     
     
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_content_align(array("left"));
     $tgrid->set_content(array($addRecord));
     $tgrid->set_content_align(array("center"));
     $tgrid->set_content(array("<b>Daftar Scoring Point</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";
     $where .= " AND ID_SCORINGVALUE = '$_REQUEST[id]'";             
     $sql    = " SELECT * FROM BUS_SCORINGPOINT WHERE 1=1 $where";
     $query  = mssql_query($sql);
     $jml_record  = mssql_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM BUS_SCORINGPOINT WHERE 1=1 $where AND ID_SCORINGPOINT NOT IN(SELECT  TOP $curr_page  ID_SCORINGPOINT FROM BUS_SCORINGPOINT WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = mssql_query($sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","","","5"));
     $tgrid->set_header_align(array("center","center","center","center","center"));
     $tgrid->set_header(array("NO","PARAMETER NAME","SCORING ATTRIBUT","SCORING POINT","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=mssql_fetch_array($query_pagging)){
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_SCORINGPOINT]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_SCORINGPOINT]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","left","center")); 
        $tgrid->set_content_width(array("5","","","","60"));       
        $tgrid->set_content(array("$x",$_ScoringValue[$data[ID_SCORINGVALUE]],$data[SCORINGPOINT_ATTRIBUT],$data[SCORINGPOINT_POINT]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Daftar Scoring Point",$isi);   
  }
  
function frm_scoringpoint($cmd){
      if($_REQUEST[xid]!=""){
        $data     = module_getscoringpoint_byid($_REQUEST[xid]);
        $nama     = $data[SCORINGVALUE_NAME];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="scoringvalue",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
      $cf->fhidden($name="id", $value=$_REQUEST[id]);               
      
      $input	 = inputText($name="attr",$value=$attr,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Attribut",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="point",$value=$point,$ext=array("size"=>"5", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Point",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Scoring Point",$form);    
  }
  
  function save_scoringpoint($cmd){
      global  $msgDBSave,  $msgDBError;
      $attribut          = $_REQUEST[attr];
      $point             = $_REQUEST[point];
      $id_scoringvalue   = $_REQUEST[id];
      if($attribut!="" && $point!=""){
          $id            = getId("BUS_SCORINGPOINT","ID_SCORINGPOINT");
          $sql           = "  INSERT INTO BUS_SCORINGPOINT(ID_SCORINGPOINT, ID_SCORINGVALUE, SCORINGPOINT_ATTRIBUT, SCORINGPOINT_POINT,STATUS)
                              VALUES('$id','$id_scoringvalue','$attribut','$point','1')";
         #print $sql;
          $query  = mssql_query($sql);
          if($query==1){
             return Template_KotakPolos("Scoring Point",$msgDBSave);
          }else{
             return Template_KotakPolos("Scoring Point",$msgDBError);
          }      
      }else{
          return Template_KotakPolos("Scoring Point",$msgDBError."<br>..::: Semua field harus diisi :::..");
      }
                        
  }
  
  function module_getscoringpoint_byid($id){
      $sql  = " SELECT * FROM BUS_SCORINGPOINT WHERE ID_SCORINGPOINT='$id'";
      $query= mssql_query($sql);
      return mssql_fetch_array($query);
  } 
  function update_scoringpoint($cmd){
      global  $msgDBSave,  $msgDBError, $msgDBUpdate;
      $attribut          = $_REQUEST[attr];
      $point             = $_REQUEST[point];
      $id_scoringvalue   = $_REQUEST[id];
      $id                = $_REQUEST[xid];
      if($attribut!="" && $point!=""){
          $sql               = "  UPDATE BUS_SCORINGPOINT SET SCORINGPOINT_ATTRIBUT= '$attribut', SCORINGPOINT_POINT='$point' WHERE ID_SCORINGVALUE='$id' ";
          $query  = mssql_query($sql);
          if($query==1){
             return Template_KotakPolos("Scoring Point",$msgDBUpdate);
          }else{
             return Template_KotakPolos("Scoring Point",$msgDBError);
          }       
      }else{
          return Template_KotakPolos("Scoring Point",$msgDBError."<br>..::: Semua field harus diisi :::..");
      }
                       
  } 
  
//------------------------------------------------------------------------------

       
   
?>
