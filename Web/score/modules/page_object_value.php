<?php
  function daftar_objectvalue($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ObjectType;
    
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
     $tgrid->set_content(array("<b>Daftar Object Value</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM OBJECT_TYPE WHERE 1=1 $where";
     $query  = mssql_query($sql);
     $jml_record  = mssql_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM OBJECT_VALUE WHERE 1=1 $where AND ID_OBJECT_VALUE NOT IN(SELECT  TOP $curr_page  ID_OBJECT_VALUE FROM OBJECT_VALUE WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = mssql_query($sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","","","","5"));
     $tgrid->set_header_align(array("center","center","center","center","center","center"));
     $tgrid->set_header(array("NO","OBJECT TYPE","OBJECT VALUE NAME","WIDTH","SOURCE","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=mssql_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_OBJECT_VALUE]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_OBJECT_VALUE]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","left","left","center")); 
        $tgrid->set_content_width(array("5","","","","","60"));       
        $tgrid->set_content(array("$x",$_ObjectType[$data[ID_OBJECT_TYPE]], $data[OBJECT_VALUE_NAME]."&nbsp;",$data[OBJECT_VALUE_WIDTH]."&nbsp;",$data[OBJECT_VALUE_SOURCE]."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Daftar Object Type",$isi);   
  }
  
  function frm_objectvalue($cmd){
      global  $_ObjectType;
      if($_REQUEST[xid]!=""){
        $data     = module_getobjectvalue_byid($_REQUEST[xid]);
        $nama     = $data[OBJECT_VALUE_NAME];
        $width    = $data[OBJECT_VALUE_WIDTH];
        $source   = $data[OBJECT_VALUE_SOURCE];
        $objecttype = $data[ID_OBJECT_TYPE];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="objectvalue",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]); 
      
      $input	 = inputSelect($name="objecttype",$value=$_ObjectType,$objecttype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Tipe",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                    
      
      $input	 = inputText($name="nama",$value=$nama,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nama Object",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="width",$value=$width,$ext=array("size"=>"5", "onkeypress"=> "return disableEnter(this,event);","suffix"=>"<span style=\"color:red;font-style:italic; font-size:10px;\"> ( kosongkan jika pilihan tipe => select )</span>"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Lebar",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="source",$value=$source,$ext=array("size"=>"50", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Source",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Object Value",$form);    
  }
  
  function save_objectvalue($cmd){
      global  $msgDBSave,  $msgDBError;
      $nama          = $_REQUEST[nama];
      $id            = getId("OBJECT_VALUE","ID_OBJECT_VALUE");
      $objecttype    = $_REQUEST[objecttype];
      $width         = $_REQUEST[width];
      $source        = $_REQUEST[source];
      $sql           = "  INSERT INTO OBJECT_VALUE(ID_OBJECT_VALUE, ID_OBJECT_TYPE,OBJECT_VALUE_NAME, OBJECT_VALUE_WIDTH, OBJECT_VALUE_SOURCE,STATUS)
                          VALUES('$id','$objecttype','$nama','$width','$source','1')";
      #print $sql;
      $query  = mssql_query($sql);
      if($query==1){
         return Template_KotakPolos("Object Value",$msgDBSave);
      }else{
         return Template_KotakPolos("Object Value",$msgDBError);
      }                        
  }
  
  function module_getobjectvalue_byid($id){
      $sql  = " SELECT * FROM OBJECT_VALUE WHERE ID_OBJECT_VALUE='$id'";
      $query= mssql_query($sql);
      return mssql_fetch_array($query);
  } 
  function update_objectvalue($cmd){
      global  $msgDBSave,  $msgDBError, $msgDBUpdate;
      $nama          = $_REQUEST[nama];
      $id            = $_REQUEST[xid];
      $objecttype    = $_REQUEST[objecttype];
      $width         = $_REQUEST[width];
      $source        = $_REQUEST[source];      
      $sql           = "  UPDATE OBJECT_VALUE SET ID_OBJECT_TYPE='$objecttype', OBJECT_VALUE_NAME= '$nama', OBJECT_VALUE_WIDTH='$width', OBJECT_VALUE_SOURCE='$source' WHERE ID_OBJECT_VALUE='$id' ";
      $query  = mssql_query($sql);
      if($query==1){
         return Template_KotakPolos("Object Value",$msgDBUpdate);
      }else{
         return Template_KotakPolos("Object Value",$msgDBError);
      }                        
  }  
   
?>
