<?php
function list_ofPrice($cmd){
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
     $tgrid->set_content(array("<b>Rumus Price (Margin / Anuitas)</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";       
     $sql    = " SELECT * FROM TYPE_PRICE WHERE 1=1 $where";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM TYPE_PRICE WHERE 1=1 $where AND ID_PRICE NOT IN(SELECT  TOP $curr_page  ID_PRICE FROM TYPE_PRICE WHERE 1=1 $where)";
     #print $sql; 
     $query_pagging = sqlsrv_query($conn, $sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("","5"));
     $tgrid->set_header_align(array("center","center","center","center","center","center","center","center","center","center"));
     $tgrid->set_header(array("No","Scoring Type","Logika X", "Nilai X", "Logika Y", "Nilai Y", "Kategori Rating", "Price", "Collateral","ACT"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data['ID_PRICE']."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data['ID_PRICE']."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","right","left","right","left","right","center","center")); 
        $tgrid->set_content_width(array("5","",""));       
        $tgrid->set_content(array($x, $_ScoringType[$data['ID_BUS_APPLICATION']],$data['FIRST_LOGIC']."&nbsp;",$data['FIRST_VALUE']."&nbsp;",$data['SECOND_LOGIC']."&nbsp;",$data['SECOND_VALUE']."&nbsp;",$data['RATE_CATEGORY']."&nbsp;",$data['PRICE_CATEGORY']."&nbsp;",$data['COLLATERAL']."&nbsp;",$edit."&nbsp;".$delete));
        $x++;
        //$data_r[$data[ID_FORMULA]] = array("ID_FORMULA"=>"$data[ID_FORMULA]","FORMULA_NAME"=>"$data[FORMULA_NAME]","PARENT_FORMULA"=>"$data[PARENT_FORMULA]","FORMULA"=>"$data[FORMULA]");
     }
     $isi   .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi   .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Rumus Price (Margin / Anuitas)",$isi);
}

  function frm_typePrice($cmd){
      global $_ScoringType;
      if($_REQUEST[xid]!=""){
        $data             = get_typeOfPriceByid($_REQUEST[xid]);
        $scoringtype      = $data['ID_BUS_APPLICATION'];
        $first_logic      = $data['FIRST_LOGIC'];
        $first_value      = $data['FIRST_VALUE'];
        $second_logic     = $data['SECOND_LOGIC'];
        $second_value     = $data['SECOND_VALUE'];
        $rate_category    = $data['RATE_CATEGORY'];
        $price_category   = $data['PRICE_CATEGORY'];
        $collateral       = $data['COLLATERAL'];
      }
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="typePrice",$method="POST",array(  "action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST['xid']);
      
      $input	 = inputSelect($name="scoringtype",$value=$_ScoringType,$scoringtype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Scoring Type",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;                       
      
      $input	 = inputText($name="first_logic",$value=$first_logic,$ext=array("size"=>"5", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Logika (X)",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;    
      
      $input	 = inputText($name="first_value",$value=$first_value,$ext=array("size"=>"10", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nilai (X)",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;    

      $input	 = inputText($name="second_logic",$value=$second_logic,$ext=array("size"=>"5", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Logika (Y)",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;    
      
      $input	 = inputText($name="second_value",$value=$second_value,$ext=array("size"=>"10", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nilai (Y)",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;  
      
      $input	 = inputText($name="rate_category",$value=$rate_category,$ext=array("size"=>"30", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Kategori Rating",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;         
      
      $input	 = inputText($name="price_category",$value=$price_category,$ext=array("size"=>"30", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Price",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputText($name="collateral",$value=$collateral,$ext=array("size"=>"30", "onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Collateral",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
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
      return Template_KotakPolos("Rumus Price (Margin / Anuitas)",$form);    
  }
  
  function typePrice_add($cmd){
      global  $msgDBSave,  $msgDBError;
      $first_logic    = $_REQUEST['first_logic'];
      $second_logic   = $_REQUEST['second_logic'];
      $first_value    = $_REQUEST['first_value'];
      $second_value   = $_REQUEST['second_value'];
      $rate_category  = $_REQUEST['rate_category'];
      $price_category = $_REQUEST['price_category'];
      $id_scoring     = $_REQUEST['scoringtype'];
      $collateral     = $_REQUEST['collateral'];
      
      $sql    = " INSERT INTO TYPE_PRICE  (ID_BUS_APPLICATION, FIRST_LOGIC, SECOND_LOGIC, FIRST_VALUE, SECOND_VALUE, RATE_CATEGORY, PRICE_CATEGORY, STATUS, CREATED_BY, CREATED_TIMESTAMP, COLLATERAL)
                              VALUES      ('".$id_scoring."', '".$first_logic."','".$second_logic."', '".$first_value."', '".$second_value."', '".$rate_category."', '".$price_category."', '1', '1', GETDATE(),'".$collateral."')";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
            return Template_KotakPolos("Rumus Price (Margin / Anuitas)",$msgDBSave);
      }else{
            return Template_KotakPolos("Rumus Price (Margin / Anuitas)",$msgDBError);
      }
  }
  
  function typePrice_update($cmd){
      global  $msgDBSave,  $msgDBError;
      $first_logic    = $_REQUEST['first_logic'];
      $second_logic   = $_REQUEST['second_logic'];
      $first_value    = $_REQUEST['first_value'];
      $second_value   = $_REQUEST['second_value'];
      $rate_category  = $_REQUEST['rate_category'];
      $price_category = $_REQUEST['price_category'];
      $id_scoring     = $_REQUEST['scoringtype'];
      $collateral     = $_REQUEST['collateral'];
      
      $sql    = " UPDATE      TYPE_PRICE SET ID_BUS_APPLICATION = '".$id_scoring."',
                                             FIRST_LOGIC = '".$first_logic."', 
                                             SECOND_LOGIC = '".$second_logic."', 
                                             FIRST_VALUE = '".$first_value."', 
                                             SECOND_VALUE = '".$second_value."', 
                                             RATE_CATEGORY = '".$rate_category."', 
                                             COLLATERAL = '".$collateral."'
                  WHERE ID_PRICE='".$_REQUEST['xid']."'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
            return Template_KotakPolos("Rumus Price (Margin / Anuitas)",$msgDBSave);
      }else{
            return Template_KotakPolos("Rumus Price (Margin / Anuitas)",$msgDBError);
      }
  }  
  
  function get_typeOfPriceByid($id){
        $sql    = " SELECT * FROM TYPE_PRICE WHERE ID_PRICE='".$id."'";
        GLOBAL $connectionInfo, $SQLHost;
        $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
        $query = sqlsrv_query($conn,$sql);
        $data   = sqlsrv_fetch_array($query);
        return $data;
  }
  
  function cek_priceByScoringId($id, $value){
      $sql    = " SELECT * FROM TYPE_PRICE WHERE ID_BUS_APPLICATION='".$id."' AND STATUS <> '99' ORDER BY FIRST_LOGIC ASC";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      while($data=sqlsrv_fetch_array($query)){
          $rumus_satu  = $value.$data['FIRST_LOGIC'].$data['FIRST_VALUE'];
          //print $rumus_satu;
          $rumus_dua   = $value.$data['SECOND_LOGIC'].$data['SECOND_VALUE'];
          if(eval('return '.$rumus_satu.';')) $rm_satu  = "true";
            else  $rm_satu  ="false";
          if(eval('return '.$rumus_dua.';')) $rm_dua  = "true";
            else  $rm_satu  ="false";
          //print $rumus_satu.$rm_satu."#".$rumus_dua.$rm_dua."<br>";
          if($rm_satu=="true" && $rm_dua=="true") $price=$data['PRICE_CATEGORY']."<br>Collateral Coverage Minimum: ".$data['COLLATERAL'];         
      }
      return $price;
  }
?>
