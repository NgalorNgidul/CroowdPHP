<?php
  function daftar_aplikasiscoring_ver($cmd){
     global $_STATUS, $COOK_VERIFIKATOR, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_ScoringType, $_ApplicationType, $_JPERMOHONAN, $COOK_USERUNIT, $_USER, $_UNITNAME;
     
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     //print $COOK_USER_ID;
     
     if($COOK_USER_ID!="1" || $COOK_USER_ID!="4" || $COOK_USER_ID!="5")
        $where .= "AND A.APPLICATION_CABANG = '$COOK_USERUNIT'";
     
     $where .= " AND (A.STATUS >= 2 OR A.STATUS <= 4)";       
     $sql    = " SELECT A.* FROM BUS_APPLICATION_VER A LEFT JOIN [DOC_UNIT] B ON A.APPLICATION_CABANG=B.ID_UNIT
                 WHERE 1=1 $where AND B.ID_VERIFIKATOR='".$COOK_VERIFIKATOR."'";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE A.* FROM 
                      BUS_APPLICATION_VER A 
                      LEFT JOIN [DOC_UNIT] B ON A.APPLICATION_CABANG=B.ID_UNIT                      
                      WHERE 1=1 $where
                      AND B.ID_VERIFIKATOR='".$COOK_VERIFIKATOR."' 
                      AND A.ID_BUS_APPLICATION NOT IN(SELECT  TOP $curr_page  a.ID_BUS_APPLICATION FROM BUS_APPLICATION_VER a LEFT JOIN [DOC_UNIT] b ON a.APPLICATION_CABANG=b.ID_UNIT WHERE 1=1 $where AND b.ID_VERIFIKATOR='".$COOK_VERIFIKATOR."' )";
     //print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql_pagging);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","180","","200","200","","","","100"));
     $tgrid->set_header_align(array("center","center","center","center","center","center","center","center","center"));
     $tgrid->set_header(array("NO","SCORING TYPE","NOMOR APPLICATION","NAMA LENGKAP AO","CABANG","NAMA PEMOHON","TANGGAL PERMOHONAN","HASIL SCORING","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        $min_scoring  = get_min_scoringbyType($data[ID_SCORING_TYPE]);
        $ket          = ($data['APPLICATION_FINSCORE']>=$min_scoring?"Direkomendasikan":"Tidak Direkomendasikan");      
        $detail= "<a href=\"index.php?cmd=".$cmd."_detail&case=1&xid=".$data[ID_BUS_APPLICATION]."\"><img src=\"includes/page_main/img/detail.png\" border=\"0\" width=\"15\"></a>"; 
        $cetak= "<a href=\"index.php?cmd=".$cmd."_cetak&case=1&xid=".$data[ID_BUS_APPLICATION]."\" onclick=\"return confirmResult();\">Result</a>";    
        $edit  = "<a href=\"index.php?cmd=".$cmd."_update&case=1&xid=".$data[ID_BUS_APPLICATION]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_BUS_APPLICATION]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("center","left","left","left","left","left","center","left","center")); 
        $tgrid->set_content_width(array("5","180","","200","200","","","","100"));       
        $tgrid->set_content(array("$x",$_ScoringType[$data[ID_SCORING_TYPE]]."&nbsp;",$data[APPLICATION_NUMBER]."&nbsp;", $_USER[$data[APPLICATION_AONAME]]."&nbsp;", $_UNITNAME[$data[APPLICATION_CABANG]]."&nbsp;", $data[APPLICATION_CIFNAME]."&nbsp;", date("d-M-Y", strtotime($data[APPLICATION_DATE]))."&nbsp;", $ket."&nbsp;", $detail."&nbsp;".($data[STATUS]<="3"?$edit:"&nbsp;")."&nbsp;".$cetak));
        $x++;
     }
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build(); 
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Verifikator Application List",$isi);     
  }
  
   function frm_application_ver($cmd){
      global  $_ScoringType, $_JPERMOHONAN, $_BADANUSAHA, $_PENDIDIKAN, $_YATIDAK, $_LAMAHUB, $_UNITNAME, $COOK_USERUNIT, $_USER, $COOK_USER_ID;
      #print $_USER[$COOK_USER_ID];
      $status = "";
      $cabang = ($cabang!=""?$cabang:$COOK_USERUNIT);
      $aoname = ($aoname!=""?$aoname:$COOK_USER_ID);
      if($_REQUEST[xid]!=""){
        $data            = module_getApplication_byid_ver($_REQUEST[xid]);
        $scoringtype     = $data[ID_SCORING_TYPE];
        $nomor           = $data[APPLICATION_NUMBER];
        $aoname          = $data[APPLICATION_AONAME];
        $cabang          = $data[APPLICATION_CABANG];
        $nocif           = $data[APPLICATION_CIFNO];
        $tanggal         = $data[APPLICATION_DATE];
        $jpermohonan     = $data[APPLICATION_JENIS];
        $namecif         = $data[APPLICATION_CIFNAME];
        $badanusaha      = $data[APPLICATION_BADANHUKUM];
        $usia            = $data[APPLICATION_USIA];
        $pendidikan      = $data[APPLICATION_PENDIDIKAN];
        $telepon         = $data[APPLICATION_TELEPON];
        $jusaha          = $data[APPLICATION_JUSAHA];
        $jkaryawan       = $data[APPLICATION_JMLKARYAWAN];
        $alamat          = $data[APPLICATION_ALAMAT];
        $lusaha          = $data[APPLICATION_LUSAHA];
        $tenor           = $data[APPLICATION_TENOR];
        $plafond         = number_format($data[APPLICATION_PLAFOND]);
        $nlikuidasi      = number_format($data[APPLICATION_LAGUNAN]);
        $colcov          = $data[APPLICATION_COLCOV];
        $lhub            = $data[APPLICATION_LAMAHUB];
        $otherfinancing  = $data[APPLICATION_OTHERFINANCE];
        $status          = $data[STATUS];        
      }
      
      if($status<"4" && $status!="99"){
          $nomor      = ($_REQUEST[xid]!=""?$data[APPLICATION_NUMBER]:generate_NumberApp());
          $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
          $row_id = 1;
          $cf = new cform();
          $cf->start($name="application",$method="POST",array("action"		=> "index.php",
                                          									  "target" 		=> "_self",
                                          									  "enctype" 	=> "multipart/form-data"));
          
          $cmd  = $cmd."_save";
          $cf->fhidden($name="cmd", $value="$cmd");
          $cf->fhidden($name="xid", $value=$_REQUEST[xid]);           
          
          $input	 = inputSelect($name="scoringtype",$value=$_ScoringType,$scoringtype,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Scoring Type",$ext=array("width"=>"300","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $input	 = inputText($name="nomor",$value=$nomor,$ext=array("size"=>"10","onkeypress"=> "return disableEnter(this,event);","disabled"=>"disabled"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Nomor Aplikasi",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $cf->fhidden($name="nomor", $value=$nomor);    
          
          #$input	 = inputText($name="aoname",$value=$aoname,$ext=array("size"=>"50","onkeypress"=> "return disableEnter(this,event);"));
          #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          #$cf->set_col_header($row_id,$text="Nama Lengkap AO",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
          #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          #$row_id++; 

          $input	 = inputSelect($name="aoname",$value=$_USER, $aoname,$ext=array("onkeypress"=> "return disableEnter(this,event);", "disabled"=>"disabled"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Nama Lengkap AO",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          $cf->fhidden($name="aoname", $value=$aoname);
          
          #$input	 = inputText($name="cabang",$value=$cabang,$ext=array("size"=>"30","onkeypress"=> "return disableEnter(this,event);"));
          #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          #$cf->set_col_header($row_id,$text="Cabang",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
          #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          #$row_id++;
          
          $input	 = inputSelect($name="cabang",$value=$_UNITNAME, $cabang,$ext=array("onkeypress"=> "return disableEnter(this,event);", "disabled"=>"disabled"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Cabang",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          $cf->fhidden($name="cabang", $value=$cabang);          
          
          $input	 = inputText($name="nocif",$value=$nocif,$ext=array("size"=>"30","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="No. CIF Pemohon",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $_REQUEST['tanggal'] = (!$_REQUEST['tanggal']?date("Y-m-d"):$_REQUEST['tanggal']);
          $input   = inputDate("tanggal","true",$dateformat="YYYY-MM-DD",$_REQUEST[tanggal]);
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Tanggal Permohonan",$ext=array("width"=>"","class"	=> "tablecontent",valign=>"top","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;                                  
          
          $input	 = inputSelect($name="jpermohonan",$value=$_JPERMOHONAN,$jpermohonan,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Jenis Permohonan",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;  
          
          $input	 = inputText($name="namecif",$value=$namecif,$ext=array("size"=>"50","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Nama Pemohon",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;  
          
          $input	 = inputSelect($name="badanusaha",$value=$_BADANUSAHA,$badanusaha,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Badan Usaha",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++; 
          
          $input	 = inputText($name="usia",$value=$usia,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Usia Pemilik / Direktur (Key Person)",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;                    
          
          $input	 = inputSelect($name="pendidikan",$value=$_PENDIDIKAN,$pendidikan,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Pendidikan Terakhir Pemilik / Direktur ",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $input	 = inputText($name="telepon",$value=$telepon,$ext=array("size"=>"30","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Fixed phone",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));          
          $row_id++;             
          
          $input	 = inputText($name="jusaha",$value=$jusaha,$ext=array("size"=>"50","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Jenis Usaha",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;      
          
          $input	 = inputText($name="jkaryawan",$value=$jkaryawan,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Jumlah Karyawan",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $input	 = inputTextArea($name="alamat",$value=$alamat,$ext=array("cols"=>"50","rows"=>"5","onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Alamat",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;            
          
          $input	 = inputText($name="lusaha",$value=$lusaha,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);","suffix"=>" <i><span style=\"font-size:10px;\">tahun</span></i> "));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Lama Usaha",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $input	 = inputText($name="tenor",$value=$tenor,$ext=array("size"=>"5","onkeypress"=> "return disableEnter(this,event);","suffix"=>" <i><span style=\"font-size:10px;\">bulan</span></i> "));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Jangka Waktu Pembiayaan",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;            
          
          $input	 = inputText($name="plafond",$value=$plafond,$ext=array("size"=>"30","onkeypress"=> "return disableEnter(this,event);","suffix"=>" <i><span style=\"font-size:10px;\">(Rp)</span></i> ", "onblur"=>"aformat(this)", "onfocus"=>"cformat(this)"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Plafond Pembiayaan",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;            
          
          $input	 = inputText($name="nlikuidasi",$value=$nlikuidasi,$ext=array("disabled"=>"disabled","size"=>"30","onkeypress"=> "return disableEnter(this,event);","suffix"=>" <i><span style=\"font-size:10px;\">(Rp)</span></i> ", "onblur"=>"aformat(this)", "onfocus"=>"cformat(this)"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Nilai Likuidasi Agunan",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;
          
          $input	 = inputText($name="colcov",$value=$colcov,$ext=array("disabled"=>"disabled","size"=>"30","onkeypress"=> "return disableEnter(this,event);","suffix"=>" <i><span style=\"font-size:10px;\">(%)</span></i> "));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Colateral Coverage",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++; 
          
          $input	 = inputSelect($name="lhub",$_LAMAHUB,$lhub,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Lama Berhubungan dengan BSM",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;      
          
          $input	 = inputSelect($name="otherfinancing",$_YATIDAK,$otherfinancing,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="Pembiayaan di Bank Lain",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
          $row_id++;                
          
          if($_REQUEST[xid]==""){
              $input	 = inputSubmit($name="action",$value="SAVE",$ext=array("size"=>"50"));
          }else{
              $input	 = inputSubmit($name="action",$value="SAVE & NEXT",$ext=array("prefix"=>"&nbsp;","size"=>"50"));
          }
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent","valign"=>"top"));
          $cf->set_col_content($row_id,$input,$ext=array());
          $row_id++;       	
          
          $form .= "<div id=\"tablecontent\">"; 
          $form .= $cf->finishnew();                                     									
          $form .= "</div>";      
      }else{
          $row_id = 1;
          $cf = new cform();
          $cf->start($name="application",$method="POST",array("action"		=> "index.php",
                                          									  "target" 		=> "_self",
                                          									  "enctype" 	=> "multipart/form-data"));      
          $input	 = "Maaf aplikasi telah dinilai";
          $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
          $cf->set_col_header($row_id,$text=$input,$ext=array("class"	=> "infodesc","valign"=>"top","colspan"=>"2"));
          #$cf->set_col_content($row_id,$input,$ext=array());
          $row_id++;       	
          
          $form .= "<div id=\"tablecontent\">"; 
          $form .= $cf->finishnew();                                     									
          $form .= "</div>";       
      }

      return Template_KotakPolos("Application Verifikasi",$form);    
  } 
  
   function view_application_ver($cmd){
      global  $_ScoringType, $_JPERMOHONAN, $_BADANUSAHA, $_PENDIDIKAN, $_YATIDAK, $_LAMAHUB, $_UNITNAME;
      if($_REQUEST[xid]!=""){
        $data            = module_getApplication_byid_ver($_REQUEST[xid]);
        $scoringtype     = $data[ID_SCORING_TYPE];
        $nomor           = $data[APPLICATION_NUMBER];
        $aoname          = $data[APPLICATION_AONAME];
        $cabang          = $data[APPLICATION_CABANG];
        $nocif           = $data[APPLICATION_CIFNO];
        $tanggal         = $data[APPLICATION_DATE];
        $jpermohonan     = $data[APPLICATION_JENIS];
        $namecif         = $data[APPLICATION_CIFNAME];
        $badanusaha      = $data[APPLICATION_BADANHUKUM];
        $usia            = $data[APPLICATION_USIA];
        $pendidikan      = $data[APPLICATION_PENDIDIKAN];
        $telepon         = $data[APPLICATION_TELEPON];
        $jusaha          = $data[APPLICATION_JUSAHA];
        $jkaryawan       = $data[APPLICATION_JMLKARYAWAN];
        $alamat          = $data[APPLICATION_ALAMAT];
        $lusaha          = $data[APPLICATION_LUSAHA];
        $tenor           = $data[APPLICATION_TENOR];
        $plafond         = number_format($data[APPLICATION_PLAFOND]);
        $nlikuidasi      = number_format($data[APPLICATION_LAGUNAN]);
        $colcov          = $data[APPLICATION_COLCOV];
        $lhub            = $data[APPLICATION_LAMAHUB];
        $otherfinancing  = $data[APPLICATION_OTHERFINANCE];
      }
      #$nomor      = generate_NumberApp();
      $id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="application",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);           
      
      #$input	 = $_ScoringType[$scoringtype];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Tipe Aplikasi",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;
      
      #$input	 = $nomor;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Nomor Aplikasi",$ext=array("width"=>"","class"	=> "tablecontentgrid","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top","class"	=> "tablecontentgrid"));     
      #$row_id++;
      
      $cf->fhidden($name="nomor", $value=$nomor);    
      
      #$input	 = $aoname;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Nama Lengkap AO",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++; 
      
      #$input	 = $cabang;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Cabang",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;
      
      #$input	 = $nocif;
      $input	 = "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">";
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Nomor Aplikasi</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$nomor."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">&nbsp;</td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">&nbsp;</td>";
      $input	 .= "</tr>";
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">No. CIF Pemohon</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$nocif."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Lama Usaha<span class=\"infodesc\">&nbsp;(Tahun)</span></td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$lusaha."</td>";
      $input	 .= "</tr>";
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Nama Pemohon</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$namecif."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Jangka Waktu Pembiayaan<span class=\"infodesc\">&nbsp;(Bulan)</span></td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$tenor."</td>";
      $input	 .= "</tr>";
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Alamat</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".nl2br($alamat)."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Plafond Pembiayaan<span class=\"infodesc\">&nbsp;(Rp)</span></td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$plafond."</td>";
      $input	 .= "</tr>";
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Fixed phone</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$telepon."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Total Nilai Likuidasi Agunan<span class=\"infodesc\">&nbsp;(Rp)</span></td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$nlikuidasi."</td>";
      $input	 .= "</tr>";
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Jenis Usaha</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$jusaha."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Collateral Coverage <span class=\"infodesc\">&nbsp;(%)</span></td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$colcov."</td>";
      $input	 .= "</tr>";      
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Cabang</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$_UNITNAME[$cabang]."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Pendidikan terakhir pemilik</td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$_PENDIDIKAN[$pendidikan]."</td>";
      $input	 .= "</tr>"; 
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Jenis Permohonan</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$_JPERMOHONAN[$jpermohonan]."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Jumlah karyawan</td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$jkaryawan."</td>";
      $input	 .= "</tr>"; 
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Badan Usaha</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$_BADANUSAHA[$badanusaha]."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Lama berhubungan dengan BSM</td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$_LAMAHUB[$lhub]."</td>";
      $input	 .= "</tr>"; 
      $input	 .= "<tr>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">Usia pemilik</td>";
      $input	 .= "<td width=\"200\" class=\"tablecontentgrid\">".$usia."</td>";
      $input	 .= "<td width=\"250\" class=\"tablecontentgrid\">Pembiayaan di bank lain</td>";
      $input	 .= "<td width=\"\" align=\"left\" class=\"tablecontentgrid\">".$_YATIDAK[$otherfinancing]."</td>";
      $input	 .= "</tr>";                             
      $input	 .= "</table>";
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="No. CIF Pemohon",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_header($row_id,$input,$ext=array("valign"=>"top", "colspan"=>"","class"	=> "tablecontent"));
      $row_id++;      
           
      #$_REQUEST['tanggal'] = (!$_REQUEST['tanggal']?date("Y-m-d"):$_REQUEST['tanggal']);
      #$input   = $_REQUEST[tanggal];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Tanggal Permohonan",$ext=array("width"=>"250","class"	=> "tablecontent",valign=>"top","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;                                  
      
      #$input	 = $_JPERMOHONAN[$jpermohonan];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Jenis Permohonan",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;  
      
      #$input	 = $namecif;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Nama Pemohon",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;  
      
      #$input	 = $_BADANUSAHA[$badanusaha];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Badan Usaha",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++; 
      
      #$input	 = $usia;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Usia Pemilik / Direktur (Key Person)",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #row_id++;                    
      
      #$input	 = $_PENDIDIKAN[trim($pendidikan)];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Pendidikan Terakhir Pemilik / Direktur ",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;

      #$input	 = nl2br($alamat);
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Alamat",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;  
      
      #$input	 = $telepon;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Telepon",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));          
      #$row_id++;             
      
      #$input	 = $jusaha;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Jenis Usaha",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;      
      
      #$input	 = $jkaryawan;
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Jumlah Karyawan",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;          
      
      #$input	 = $lusaha." <i><span style=\"font-size:10px;\">(Bulan)</span></i>";
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Lama Usaha",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;
      
      #$input	 = $tenor." <i><span style=\"font-size:10px;\">(Tahun)</span></i> ";
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Jangka Waktu Pembiayaan",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;            
      
      #$input	 = number_format($plafond)." <i><span style=\"font-size:10px;\">(Rp)</span></i> ";
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Plafond Pembiayaan",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;            
      
      #$input	 = number_format($nlikuidasi)." <i><span style=\"font-size:10px;\">(Rp)</span></i> ";
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Nilai Likuidasi Agunan",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;
      
      #$input	 = $colcov." <i><span style=\"font-size:10px;\">(%)</span></i> ";
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Colateral Coverage",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++; 
      
      #$input	 = $_LAMAHUB[trim($lhub)];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Lama Berhubungan dengan BSM",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;      
      
      #$input	 = $_YATIDAK[trim($otherfinancing)];
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="Pembiayaan di Bank Lain",$ext=array("width"=>"250","class"	=> "tablecontent","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      #$row_id++;                    	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Informasi Umum Nasabah",$form);    
  }  
  
  function module_getApplication_byid_ver($id){
      $sql  = " SELECT * FROM BUS_APPLICATION_VER WHERE ID_BUS_APPLICATION='$id'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      return sqlsrv_fetch_array($query);
  } 
  
  function application_update_ver($cmd){
      global  $msgDBSave,  $msgDBError;
      $scoringtype           = $_REQUEST[scoringtype];
      $app_number            = $_REQUEST[nomor];
      $app_aoname            = $_REQUEST[aoname];
      $app_cabang            = $_REQUEST[cabang];
      $app_cif_no            = $_REQUEST[nocif];
      $app_date              = $_REQUEST[tanggal];
      $app_jenis             = $_REQUEST[jpermohonan];
      $app_jenis             = $_REQUEST[jpermohonan];
      $app_cifname           = $_REQUEST[namecif];
      $app_badanusaha        = $_REQUEST[badanusaha];
      $app_usia              = $_REQUEST[usia];
      $app_pendidikan        = $_REQUEST[pendidikan];
      $app_telepon           = $_REQUEST[telepon];
      $app_jusaha            = $_REQUEST[jusaha];
      $app_jkaryawan         = $_REQUEST[jkaryawan];
      $app_alamat            = $_REQUEST[alamat];
      $app_lusaha            = $_REQUEST[lusaha];
      $app_tenor             = $_REQUEST[tenor];
      $app_plafond           = str_replace(",","",$_REQUEST[plafond]);
      $app_nlikuidasi        = ($_REQUEST[nlikuidasi]!=""?str_replace(",","",$_REQUEST[nlikuidasi]):"0");
      $app_colcov            = number_format($_REQUEST[colcov]);
      $app_lhub              = $_REQUEST[lhub];
      $app_otherfinance      = $_REQUEST[otherfinancing];      
      $id            = $_REQUEST[xid];
      $sql           = "  UPDATE BUS_APPLICATION_VER SET  ID_SCORING_TYPE='$scoringtype',
                                                          APPLICATION_NUMBER='$app_number',
                                                          APPLICATION_AONAME='$app_aoname',
                                                          APPLICATION_CABANG='$app_cabang',
                                                          APPLICATION_CIFNO='$app_cif_no',
                                                          APPLICATION_DATE='$app_date',
                                                          APPLICATION_JENIS='$app_jenis',
                                                          APPLICATION_CIFNAME='$app_cifname', 
                                                          APPLICATION_BADANHUKUM='$app_badanusaha', 
                                                          APPLICATION_USIA='$app_usia',
                                                          APPLICATION_PENDIDIKAN='$app_pendidikan', 
                                                          APPLICATION_TELEPON='$app_telepon', 
                                                          APPLICATION_JUSAHA='$app_jusaha',
                                                          APPLICATION_JMLKARYAWAN='$app_jkaryawan', 
                                                          APPLICATION_ALAMAT='$app_alamat', 
                                                          APPLICATION_LUSAHA='$app_lusaha',
                                                          APPLICATION_LAMAHUB='$app_lhub', 
                                                          APPLICATION_OTHERFINANCE='$app_otherfinance', 
                                                          APPLICATION_TENOR='$app_tenor',
                                                          APPLICATION_PLAFOND='$app_plafond', 
                                                          APPLICATION_LAGUNAN='$app_nlikuidasi', 
                                                          APPLICATION_COLCOV='$app_colcov'                                                      
                          WHERE ID_BUS_APPLICATION='$id'";
      #print $sql; exit();
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      if($query){
         return Template_KotakPolos("Application Verifikasi",$msgDBSave);
      }else{
         return Template_KotakPolos("Application Verifikasi",$msgDBError);
      } 
  }
  
 function daftar_appcollateral_ver($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE, $_CollateralType, $_CollType;
     $app  = module_getApplication_byid_ver($_REQUEST[xid]);
     $app_plafond           = $app[APPLICATION_PLAFOND];
    
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_content_align(array("left"));
     $tgrid->set_content(array($addRecord));
     $tgrid->set_content_align(array("center"));
     $tgrid->set_content(array("<b>Daftar Collateral</b>"));
     $isi .= $tgrid->build();
     
     $where .= " AND STATUS <> 99";
     $where .= " AND ID_BUS_APPLICATION='$_REQUEST[xid]'";       
     $sql    = " SELECT * FROM BUS_COLLATERAL_VER WHERE 1=1 $where";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE * FROM BUS_COLLATERAL_VER WHERE 1=1 $where AND ID_BUS_COLL NOT IN(SELECT  TOP $curr_page  ID_BUS_COLL FROM BUS_COLLATERAL_VER WHERE 1=1 $where)";
     #print $sql_pagging; 
     $query_pagging = sqlsrv_query($conn, $sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("5","","","",""));
     $tgrid->set_header_align(array("center","center","center","center","center"));
     $tgrid->set_header(array("No","Collateral","Jenis Collateral","Nilai","&nbsp;"));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
          
     while($data=sqlsrv_fetch_array($query_pagging)){
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_NERACA]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        $delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_BUS_COLL]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        $tgrid->set_content_align(array("left","left","left","right","center")); 
        $tgrid->set_content_width(array("5","","","","60"));       
        $tgrid->set_content(array("$x",$_CollateralType[$data[ID_COLL]]."&nbsp;",$_CollType[$data[COLL_TYPE]]."&nbsp;",number_format($data[COLL_VALUE])."&nbsp;",($_REQUEST[cmd]=="CMD_TRANSAPPLICATION_detail"?"&nbsp;":($_REQUEST[cmd]=="CMD_TRANSAPPLICATION_VER_detail"?"&nbsp;":($_REQUEST[cmd]=="CMD_TRANSAPPLICATION_VER_cetak"?"&nbsp;":$delete)))));
        $x++;
        $total  +=  $data[COLL_VALUE];
     }

          
     $isi .= $tgrid->set_nav($jml_record,"$_GET[page]");    
     $isi .= $tgrid->build();
     $colcov  = ($total/$app_plafond)*100;
     $update_colcov = module_updatecolcov_ver($_REQUEST[xid], $colcov, $total);
     $isi .= "<table width=\"100%\"><tr><td class=\"tablecontentgrid\"><b>Collateral Coverage: </b>".number_format($colcov,2)."%</td></tr></table>";
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Daftar Collateral",$isi); 
 }
 
function module_updatecolcov_ver($xid, $value, $total){
    $sql  = "UPDATE BUS_APPLICATION_VER SET APPLICATION_COLCOV='$value', APPLICATION_LAGUNAN='$total' WHERE ID_BUS_APPLICATION='$xid'";
    #print $sql;
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
} 

 function frm_collapplication_ver($cmd){
      global $_CollType;
      $app  = module_getApplication_byid_ver($_REQUEST[xid]);
      $coll = gen_CollateralTypeByScoring($app[ID_SCORING_TYPE]);
      
      #if($_REQUEST[xid]!=""){
      #  $data     = module_gettypeapplication_byid($_REQUEST[xid]);
      #  $nama     = $data[APPLICATION_NAME];
      #}
      #$id_unit    = ($id_unit!=""?$id_unit:$COOK_USERUNIT);
      $row_id = 1;
      $cf = new cform();
      $cf->start($name="collateral",$method="POST",array("action"		=> "index.php",
                                      									  "target" 		=> "_self",
                                      									  "enctype" 	=> "multipart/form-data"));
      
      $cmd  = $cmd."_save";
      $cf->fhidden($name="cmd", $value="$cmd");
      $cf->fhidden($name="xid", $value=$_REQUEST[xid]);               
      
      $input	 = inputSelect($name="collateral",$value=$coll,$collateral,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Collateral",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;
      
      $input	 = inputSelect($name="jcoll",$value=$_CollType,$jcoll,$ext=array("onkeypress"=> "return disableEnter(this,event);"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Jenis Collateral",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;      
      
      $input	 = inputText($name="nilai",$value=$nilai, $ext=array("size"=>"30", "onkeypress"=> "return disableEnter(this,event);","suffix"=>" (Rp)", "onblur"=>"aformat(this)", "onfocus"=>"cformat(this)"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="Nilai",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
      $row_id++;      
      
      $input	 = inputSubmit($name="action",$value="ADD",$ext=array("size"=>"50","suffix"=>"&nbsp;"));
      $input	 .= inputSubmit($name="action",$value="SAVE & NEXT",$ext=array("size"=>"50"));
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent",valign=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array());
      $row_id++;       	
      
      $form .= "<div id=\"tablecontent\">"; 
      $form .= $cf->finishnew();                                     									
      $form .= "</div>";
      return Template_KotakPolos("Application Collateral",$form);      
 }
 
 function bus_collsave_ver($cmd){
    global  $msgDBSave,  $msgDBError;
    $id_coll          = $_REQUEST[collateral];
    $nilai            = str_replace(",","",$_REQUEST[nilai]);
    $id               = getId("BUS_COLLATERAL","ID_BUS_COLL");
    $id_app           = $_REQUEST[xid];
    $jcoll            = $_REQUEST[jcoll];
    $cek_jcoll        = cek_jcoll_ver($id_app, '0001');
    if($jcoll=="0001"){
      if($cek_jcoll<=0){
          $sql           = "  INSERT INTO BUS_COLLATERAL_VER(ID_BUS_COLL,ID_COLL,ID_BUS_APPLICATION,COLL_VALUE,STATUS, COLL_TYPE)
                              VALUES('$id','$id_coll','$id_app','$nilai','1','$jcoll')";
          #print $sql;
          if($nilai!=""){
            $query  = mssql_query($sql);
            if($query==1){
               return Template_KotakPolos("Application Coll",$msgDBSave);
            }else{
               return Template_KotakPolos("Application Coll",$msgDBError);
            }
          }else{
             return Template_KotakPolos("Application Coll",$msgDBSave);
          }     
      }else{
          return Template_KotakPolos("Application Coll",$msgDBError."<br>Primary Collateral hanya boleh 1(satu)");
      }    
    }else{
        $sql           = "  INSERT INTO BUS_COLLATERAL_VER(ID_BUS_COLL,ID_COLL,ID_BUS_APPLICATION,COLL_VALUE,STATUS, COLL_TYPE)
                            VALUES('$id','$id_coll','$id_app','$nilai','1','$jcoll')";
        #print $sql;
        if($nilai!=""){
          GLOBAL $connectionInfo, $SQLHost;
          $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
          $query = sqlsrv_query($conn,$sql);
          if($query){
             return Template_KotakPolos("Application Coll",$msgDBSave);
          }else{
             return Template_KotakPolos("Application Coll",$msgDBError);
          }
        }else{
           return Template_KotakPolos("Application Coll",$msgDBSave);
        }     
    }
 } 
 
 function cek_jcoll_ver($xid, $jcoll){
      $sql    = " SELECT * FROM BUS_COLLATERAL_VER WHERE ID_BUS_APPLICATION='$xid' AND COLL_TYPE='$jcoll' AND STATUS <>'99'";
      GLOBAL $connectionInfo, $SQLHost;
      $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
      $query = sqlsrv_query($conn,$sql);
      $row    = sqlsrv_num_rows($query);
      
      return $row;
 } 
 
 function get_frmcriteria_ver($cmd){
    global  $_CriteriaType, $_YATIDAK;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria     = gen_CriteriaTypeByScoring($app[ID_SCORING_TYPE]);
    $dataCriteria = get_CriteriaByApp_ver($_REQUEST[xid]);
    //print_r($dataCriteria);
    
    $row_id = 1;
    $cf = new cform();
    $cf->start($name="criteria",$method="POST",array( "action"		=> "index.php",
                                  									  "target" 		=> "_self",
                                  									  "enctype" 	=> "multipart/form-data"));
    
    $cmd  = $cmd."_save";
    $cf->fhidden($name="cmd", $value="$cmd");
    $cf->fhidden($name="xid", $value=$_REQUEST[xid]); 
    $yatidak  = "yatidak_";
    $ket      = "ket_";
    foreach($criteria as $cparents=>$vparents){
      $input	 = "<b>".$_CriteriaType[$cparents]."</b>";
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text=$input."<hr>",$ext=array("width"=>"100%","class"	=> "tablecontent infoheader","valign"=>"top","colspan"=>"2"));
      $row_id++;
      $input	 = "<b>Terpenuhi&nbsp;&nbsp;</b>";      
      $input	 .= "<b>Keterangan (Jika Tidak Terpenuhi)</b>";      
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text="&nbsp;",$ext=array("width"=>"100","class"	=> "tablecontent","valign"=>"top"));
      $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top","class"=>"tablecontent"));
      $row_id++;           
      foreach($vparents as $ckey=>$cvalue){
        $ket      = $ket.$ckey;
        $yatidak  = $yatidak.$ckey;
        $yatidak  = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_CRITERIA"];
        $ket      = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_KET"];
        #print $ket;
        $input	 = inputSelect($name="yatidak_".$ckey,$value=$_YATIDAK, $yatidak, $ext=array("onkeypress"=> "return disableEnter(this,event);","suffix"=>"&nbsp;&nbsp;&nbsp;"));      
        $input	 .= inputText($name="ket_".$ckey,$value=$ket, $ext=array("size"=>"30", "onkeypress"=> "return disableEnter(this,event);"));      
        $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
        $cf->set_col_header($row_id,$text="$cvalue",$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
        $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top"));
        $row_id++;      
      }

    }
    
    $input	 = inputSubmit($name="action",$value="UPDATE",$ext=array("size"=>"50","suffix"=>"&nbsp;"));
    $input	 .= inputSubmit($name="action",$value="SAVE & NEXT",$ext=array("size"=>"50"));
    $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
    $cf->set_col_header($row_id,$text=$input,$ext=array("class"	=> "tablecontent","valign"=>"top", "colspan"=>"2", "align"=>"center"));
    #$cf->set_col_content($row_id,$input,$ext=array("colspan"=>"2"));
    $row_id++;       	
    
    $form .= "<div id=\"tablecontent\">"; 
    $form .= $cf->finishnew();                                     									
    $form .= "</div>";
    return Template_KotakPolos("Risk Acceptance Criteria",$form);        
 }
 
 function view_frmcriteria_ver($cmd){
    global  $_CriteriaType, $_YATIDAK;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria     = gen_CriteriaTypeByScoring($app[ID_SCORING_TYPE]);
    $dataCriteria = get_CriteriaByApp_ver($_REQUEST[xid]);
    #print_r($dataCriteria);
    
    $row_id = 1;
    $cf = new cform();
    $cf->start($name="criteria",$method="POST",array( "action"		=> "index.php",
                                  									  "target" 		=> "_self",
                                  									  "enctype" 	=> "multipart/form-data"));
    
    $cmd  = $cmd."_save";
    $cf->fhidden($name="cmd", $value="$cmd");
    $cf->fhidden($name="xid", $value=$_REQUEST[xid]); 
    $yatidak  = "yatidak_";
    $ket      = "ket_";
    #print_r($_CriteriaType); exit();
    foreach($criteria as $cparents=>$vparents){          
      foreach($vparents as $ckey=>$cvalue){
          $yatidak  = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_CRITERIA"];
          $msg[$cparents]      .= trim($yatidak).",";    
      }     
    }
    #print_r($kets);
    foreach($criteria as $cparents=>$vparents){
      $dt = explode(",",substr($msg[$cparents],0,-1));
      if(in_array("2",$dt)){
          $mss[$cparents]  = "Tidak Terpenuhi";      
      }else{
          $mss[$cparents]  = "Terpenuhi";
      }
      #print_r($cparents)."<br>";
      $input	 = $_CriteriaType[$cparents];
      $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      $cf->set_col_header($row_id,$text=$input,$ext=array("width"=>"80%","class"	=> "tablecontentgrid","valign"=>"top"));
      $cf->set_col_content($row_id,$text=$mss[$cparents],$ext=array("width"=>"20%","class"	=> "tablecontentgrid","valign"=>"top","align"=>"right"));
      $row_id++;
      #$input	 = "<table width=\"100%\"><tr><td width=\"100\"><b>Terpenuhi</b>";      
      #$input	 .= "</td><td><b>Keterangan</b></td></tr></table>";      
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text="&nbsp;",$ext=array("width"=>"100","class"	=> "tablecontentgrid","valign"=>"top"));
      #$cf->set_col_content($row_id,$input,$ext=array("valign"=>"top","class"=>"tablecontentgrid"));
      #$row_id++;           
/*      foreach($vparents as $ckey=>$cvalue){
        $ket      = $ket.$ckey;
        $yatidak  = $yatidak.$ckey;
        $yatidak  = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_CRITERIA"];
        $ket      = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_KET"];
        #print $ket;
        $input	 = "<table width=\"100%\"><tr><td width=\"100\">".$_YATIDAK[trim($yatidak)];      
        $input	 .= "</td><td>".$ket."</td></tr></table>";      
        $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
        $cf->set_col_header($row_id,$text="$cvalue",$ext=array("width"=>"100","class"	=> "tablecontentgrid","valign"=>"top"));
        $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top", "class"=>"tablecontentgrid"));
        $row_id++;      
      }
*/
    }     	
    
    $form .= "<div id=\"tablecontent\">"; 
    $form .= $cf->finishnew();                                     									
    $form .= "</div>";
    return Template_KotakPolos("Risk Acceptance Criteria",$form);        
 }
 
  function  get_frmcriteria_save_ver($cmd){
    global  $_CriteriaType, $_YATIDAK, $msgDBSave, $msgDBError;;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria     = gen_CriteriaTypeByScoring($app[ID_SCORING_TYPE]);
    $dataCriteria = get_CriteriaByApp_ver($_REQUEST[xid]);
    foreach($criteria as $cparents=>$vparents){        
      foreach($vparents as $ckey=>$cvalue){
         $yatidak  = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_CRITERIA"];
         $ket      = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_KET"];      
         $id       = getId("BUS_ACCEPTANCE_CRITERIA_VER","ID_BUS_ACCEPTANCE");
         if(count($yatidak)=="0" && count($ket)=="0"){
           $sql      = " INSERT INTO BUS_ACCEPTANCE_CRITERIA_VER (ID_BUS_ACCEPTANCE,ID_BUS_APPLICATION,ID_CRITERIA,BUS_ACCEPTANCE_CRITERIA,BUS_ACCEPTANCE_KET)
                         VALUES('$id','$_REQUEST[xid]','$ckey','".$_REQUEST["yatidak_".$ckey]."','".$_REQUEST["ket_".$ckey]."')";
            GLOBAL $connectionInfo, $SQLHost;
            $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
            $query = sqlsrv_query($conn,$sql);         
         }else{
           $sql = " UPDATE BUS_ACCEPTANCE_CRITERIA_VER SET BUS_ACCEPTANCE_CRITERIA='".$_REQUEST["yatidak_".$ckey]."',
                                                       BUS_ACCEPTANCE_KET='".$_REQUEST["ket_".$ckey]."'
                    WHERE ID_BUS_APPLICATION='$_REQUEST[xid]' AND ID_CRITERIA='$ckey'";
            GLOBAL $connectionInfo, $SQLHost;
            $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
            $query = sqlsrv_query($conn,$sql);        
         }

      }
    }
    return Template_KotakPolos("Risk Acceptance Criteria",$msgDBSave);         
 }
 
  function  get_frmcriteria_update_ver($cmd){
    global  $_CriteriaType, $_YATIDAK, $msgDBUpdate;
    $app      = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria = gen_CriteriaTypeByScoring($app[ID_SCORING_TYPE]);
    foreach($criteria as $cparents=>$vparents){        
      foreach($vparents as $ckey=>$cvalue){
         $sql = " UPDATE BUS_ACCEPTANCE_CRITERIA_VER SET BUS_ACCEPTANCE_CRITERIA='".$_REQUEST["yatidak_".$ckey]."',
                                                     BUS_ACCEPTANCE_KET='".$_REQUEST["ket_".$ckey]."'
                  WHERE ID_BUS_APPLICATION='$_REQUEST[xid]' AND ID_CRITERIA='$ckey'"; //print $sql; exit();
         GLOBAL $connectionInfo, $SQLHost;
         $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
         $query = sqlsrv_query($conn,$sql);
      }
    }
    return Template_KotakPolos("Risk Acceptance Criteria",$msgDBUpdate);         
 }
 
 function get_frmneraca_ver($cmd){
    global  $_NeracaType, $_NERACAKET, $_Month;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria     = gen_NeracaTypeByScoring($app[ID_SCORING_TYPE]);
    $dataCriteria = get_NeracaByApp_ver($_REQUEST[xid]);
    #print_r($dataCriteria); exit();
    
    $row_id = 1;
    $cf = new cform();
    $cf->start($name="neraca",$method="POST",array(   "action"		=> "index.php",
                                  									  "target" 		=> "_self",
                                  									  "enctype" 	=> "multipart/form-data"));
    
    $cmd  = $cmd."_save";
    $cf->fhidden($name="cmd", $value="$cmd");
    $cf->fhidden($name="xid", $value=$_REQUEST[xid]);
    
    foreach($criteria as $cparents=>$vparents){       
      foreach($vparents as $ckey=>$cvalue){
        
        $ketawal          = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_KETAWAL"];
        $ketakhir         = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_KETAKHIR"];
        $ketjalan         = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_KETJALAN"];
        $tahunawal        = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_TAHUNAWAL"];
        $tahunakhir       = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_TAHUNAKHIR"];
        $tahunjalan       = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_TAHUNJALAN"];
        $monjalan         = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_MONJALAN"];
        #print $tahunjalan;            
      }
    }     

    #$input	 = "<b>".$_NeracaType[$cparents]."</b>";
    if(count($tahunawal)=="0" && count($tahunakhir)=="0" && count($tahunjalan)=="0"){
        $disable  = "disabled";
    }else{
        $disable  = "";
    }
    $tahun  = "<table width=\"100%\" border=\"0\">";
    $tahun  .= "<tr>";
    $tahun  .= "<td width=\"200\">".inputSelectRange($name="tahunawal",date("Y")-5,date("Y")+5,$tahunawal, $ext=array("suffix"=>"2 tahun terakhir","onkeypress"=> "return disableEnter(this,event);"))."</td>";    
    $tahun  .= "<td width=\"200\">".inputSelectRange($name="tahunakhir",date("Y")-5,date("Y")+5,$tahunakhir, $ext=array("suffix"=>"1 tahun terakhir","onkeypress"=> "return disableEnter(this,event);"))."</td>";
    $tahun  .= "<td>".inputSelectRange($name="tahunjalan",date("Y")-5,date("Y")+5,$tahunjalan, $ext=array("suffix"=>"Tahun berjalan","onkeypress"=> "return disableEnter(this,event);"))."</td>";
    $tahun  .= "</tr>";
    $tahun  .= "<tr>";
    $tahun  .= "<td>".inputSelect($name="ketawal",$_NERACAKET,$ketawal, $ext=array("suffix"=>"Keterangan","onkeypress"=> "return disableEnter(this,event);"))."</td>";
    $tahun  .= "<td>".inputSelect($name="ketakhir",$_NERACAKET,$ketakhir, $ext=array("suffix"=>"Keterangan","onkeypress"=> "return disableEnter(this,event);"))."</td>";
    #$tahun  .= "<td>".inputSelect($name="ketjalan",$_NERACAKET,$ketjalan, $ext=array("suffix"=>"Keterangan","onkeypress"=> "return disableEnter(this,event);"))."</td>";
    $tahun  .= "<td>".inputSelect($name="monjalan",$_Month,$monjalan, $ext=array("suffix"=>"","onkeypress"=> "return disableEnter(this,event);"))."</td>";
    $tahun  .= "</tr>";    
    $tahun  .= "</table>";      
    $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
    $cf->set_col_header($row_id,$text="&nbsp;",$ext=array("width"=>"150","class"	=> "tablecontent","valign"=>"bottom"));
    $cf->set_col_content($row_id,$tahun,$ext=array("valign"=>"top", "class"	=> "tablecontent"));
    $row_id++; 

    foreach($criteria as $cparents=>$vparents){
      #$input	 = "<b>".$_NeracaType[$cparents]."</b>";
      #$tahun  = "&nbsp;";      
      #$cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
      #$cf->set_col_header($row_id,$text=$input."<hr>",$ext=array("width"=>"","class"	=> "tablecontent infoheader","valign"=>"top"));
      #$cf->set_col_content($row_id,$tahun."<hr>",$ext=array("valign"=>"top", "class"	=> "tablecontent infoheader"));
      #$row_id++;         
      foreach($vparents as $ckey=>$cvalue){
        
        $ketawal          = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_KETAWAL"];
        $ketakhir         = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_KETAKHIR"];
        $ketjalan         = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_KETJALAN"];
        $tahunawal        = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_TAHUNAWAL"];
        $tahunakhir       = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_TAHUNAKHIR"];
        $tahunjalan       = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_TAHUNJALAN"];
        $nilaiawal        = number_format($dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_VALUEAWAL"]);
        $nilaiakhir       = number_format($dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_VALUEAKHIR"]);
        $nilaijalan       = number_format($dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_VALUEJALAN"]);
        $monjalan         = $dataCriteria[$_REQUEST[xid]][$ckey]["BUS_NERACA_MONJALAN"];
        #print $ket;
        #$input	 = "<table><tr><td width=\"200\">".inputSelect($name="ket_".$ckey,$_NERACAKET,$ket, $ext=array("suffix"=>"Ket<br>","onkeypress"=> "return disableEnter(this,event);"))."</td></tr></table>";        
        #$input	 .= "<table><tr><td width=\"200\">".inputSelectRange($name="tahunawal_".$ckey,date("Y")-5,date("Y")+5,$tahunawal, $ext=array("suffix"=>"Tahun Sebelumnya &nbsp;","onkeypress"=> "return disableEnter(this,event);"));
        #$input	 .= "</td><td>".inputText($name="nilaiawal_".$ckey,$nilaiawal, $ext=array("suffix"=>"&nbsp;Nilai Sebelumnya<br>","onkeypress"=> "return disableEnter(this,event);"))."</td></tr></table>";      
        #$input	 .= "<table><tr><td width=\"200\">".inputSelectRange($name="tahunakhir_".$ckey,date("Y")-5,date("Y")+5,$tahunakhir, $ext=array("suffix"=>"Tahun Sekarang &nbsp;","onkeypress"=> "return disableEnter(this,event);"));
        #$input	 .= "</td><td>".inputText($name="nilaiakhir_".$ckey,$nilaiakhir, $ext=array("suffix"=>"&nbsp;Nilai Sekarang<br>","onkeypress"=> "return disableEnter(this,event);"))."</td></tr></table>";        
        
        $cf->fhidden($name="ketawal_".$ckey, $value=$_REQUEST[ketawal]);
        $cf->fhidden($name="ketakhir_".$ckey, $value=$_REQUEST[ketakhir]);
        $cf->fhidden($name="ketjalan_".$ckey, $value=$_REQUEST[ketjalan]);
        $cf->fhidden($name="tahunawal_".$ckey, $value=$_REQUEST[tahunawal]);
        $cf->fhidden($name="tahunakhir_".$ckey, $value=$_REQUEST[tahunakhir]);
        $cf->fhidden($name="tahunjalan_".$ckey, $value=$_REQUEST[tahunjalan]); 
        $cf->fhidden($name="monjalan_".$ckey, $value=$_REQUEST[monjalan]);       
        
        $input  = "<table width=\"100%\" border=\"0\">";
        $input  .= "<tr>";
        $input  .= "<td width=\"200\">".inputText($name="nilaiawal_".$ckey,$nilaiawal, $ext=array("suffix"=>"","onkeypress"=> "return disableEnter(this,event);", "onblur"=>"aformat(this)", "onfocus"=>"cformat(this)"))."</td>";        
        $input  .= "<td width=\"200\">".inputText($name="nilaiakhir_".$ckey,$nilaiakhir, $ext=array("suffix"=>"","onkeypress"=> "return disableEnter(this,event);", "onblur"=>"aformat(this)", "onfocus"=>"cformat(this)"))."</td>";
        $input  .= "<td>".inputText($name="nilaijalan_".$ckey,$nilaijalan, $ext=array("suffix"=>"","onkeypress"=> "return disableEnter(this,event);", "onblur"=>"aformat(this)", "onfocus"=>"cformat(this)"))."</td>";        
        $input  .= "</tr>";
        $input  .= "</table>";
                    
        $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
        $cf->set_col_header($row_id,$text=$cvalue,$ext=array("width"=>"","class"	=> "tablecontent","valign"=>"top"));
        $cf->set_col_content($row_id,$input,$ext=array("valign"=>"top", "class"	=> "tablecontent"));
        $row_id++;      
      }

    }
    
    $input	 = inputSubmit($name="action",$value="UPDATE",$ext=array("size"=>"50", "suffix"=>"&nbsp;", $disable=>$disable));
    $input	 .= inputSubmit($name="action",$value="SAVE & NEXT",$ext=array("size"=>"50"));
    $cf->set_row($row_id,$ext=array("class"	=> "tablecontent"));
    $cf->set_col_header($row_id,$text="",$ext=array("class"	=> "tablecontent","valign"=>"top"));
    $cf->set_col_content($row_id,$input,$ext=array());
    $row_id++;       	
    
    $form .= "<div id=\"tablecontent\">"; 
    $form .= $cf->finishnew();                                     									
    $form .= "</div>";
    return Template_KotakPolos("Laporan Keuangan",$form); 
 }
 
function  get_NeracaByApp_ver($id){
    $where  = "";
    $sql    = " SELECT * FROM BUS_NERACA_VER WHERE ID_BUS_APPLICATION='$id'";
    #print $sql;
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){
      $dt[$data[ID_BUS_APPLICATION]][$data[ID_NERACA]]  = array("BUS_NERACA_TAHUNAWAL"=>$data[BUS_NERACA_TAHUNAWAL],
                                                                "BUS_NERACA_TAHUNAKHIR"=>$data[BUS_NERACA_TAHUNAKHIR],
                                                                "BUS_NERACA_TAHUNJALAN"=>$data[BUS_NERACA_TAHUNJALAN],
                                                                "BUS_NERACA_VALUEAWAL"=>$data[BUS_NERACA_VALUEAWAL],
                                                                "BUS_NERACA_VALUEAKHIR"=>$data[BUS_NERACA_VALUEAKHIR],
                                                                "BUS_NERACA_VALUEJALAN"=>$data[BUS_NERACA_VALUEJALAN],
                                                                "BUS_NERACA_KETAWAL"=>$data[BUS_NERACA_KETAWAL],
                                                                "BUS_NERACA_KETAKHIR"=>$data[BUS_NERACA_KETAKHIR],
                                                                "BUS_NERACA_KETJALAN"=>$data[BUS_NERACA_KETJALAN],
                                                                "BUS_NERACA_MONJALAN"=>$data[BUS_NERACA_MONJALAN]);
    } 
    
    return $dt;
      
}  
 
  function view_frmneraca_ver($cmd){
     global $_STATUS, $COOK_USER_ID, $_MAX_REC_PER_PAGE;
     $app          = module_getApplication_byid_ver($_REQUEST[xid]);  
     $dataCriteria = get_NeracaByApp_ver($_REQUEST[xid]);                 
     
     $where = "";
     $isi   = "";
     $isi   .= "<div id=\"tablecontent\">";
     #$where .= " AND STATUS <> 99"; 
     $where .= " AND A.STATUS <> 99 AND B.STATUS <> 99 AND B.ID_SCORING_TYPE='".$app[ID_SCORING_TYPE]."'"; 
     #$where .= " AND ID_SCORING_TYPE='$app[ID_SCORING_TYPE]'";      
     $sql    = " SELECT A.* FROM TYPE_NERACA A LEFT JOIN SCORING_NERACA B ON A.ID_NERACA=B.ID_NERACA  WHERE 1=1 $where ORDER BY A.PARENT_NERACA";
     GLOBAL $connectionInfo, $SQLHost;
     $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
     $query = sqlsrv_query($conn,$sql);
     $jml_record  = sqlsrv_num_rows($query);
     if($_GET[page] < 1)	$_GET[page] = 1;
  	   $curr_page = ($_GET[page] - 1) * $_MAX_REC_PER_PAGE;     
     $sql_pagging = " SELECT TOP $_MAX_REC_PER_PAGE A.* FROM TYPE_NERACA A LEFT JOIN SCORING_NERACA B ON A.ID_NERACA=B.ID_NERACA  WHERE 1=1 $where AND A.ID_NERACA NOT IN(SELECT  TOP $curr_page  A.ID_NERACA FROM TYPE_NERACA A LEFT JOIN SCORING_NERACA B ON A.ID_NERACA=B.ID_NERACA  WHERE 1=1 $where)";
     #print $sql; 
     $query_pagging = sqlsrv_query($sql);
     $tgrid 	= new tgrid();
     $tgrid->set_table();
     $tgrid->set_header_width(array("","5"));
     $tgrid->set_header_align(array("center","center"));
     $tgrid->set_header(array("Parameter",""));
     $x=(($_GET[page]-1)*$_MAX_REC_PER_PAGE) + 1;
     #print_r($sql_pagging); exit();     
     while($data=sqlsrv_fetch_array($query_pagging)){
     #print_r($data); exit();
        #$edit  = "<a href=\"index.php?cmd=".$cmd."_update&xid=".$data[ID_NERACA]."\"><img src=\"includes/page_main/img/edit_on.gif\" border=\"0\"></a>";
        #$delete= "<a href=\"index.php?cmd=".$cmd."_delete&xid=".$data[ID_NERACA]."\"><img src=\"includes/page_main/img/del_lt_on.gif\" onclick=\"return confirmDelete();\" border=\"0\"></a>";
        #$tgrid->set_content_align(array("left","left","center")); 
        #$tgrid->set_content_width(array("5","","60"));       
        #$tgrid->set_content(array("$x",$data[NERACA_NAME]."&nbsp;",$edit."&nbsp;".$delete));
        #$x++;
        $data_r[$data[ID_NERACA]] = array("ID_NERACA"=>"$data[ID_NERACA]","NERACA_NAME"=>"$data[NERACA_NAME]","PARENT_NERACA"=>"$data[PARENT_NERACA]", "LEVEL"=>"$data[LEVELS]");
     }
     #print_r($data_r);
     $tgrid->set_content_width("100%");
     $tgrid->set_content(array("","",generate_tree_listneraca_view_ver($data_r,"0","0",$cmd)));     
     #$isi .= $tgrid->set_nav($jml_record,"$_GET[page]");
     $isi .= $tgrid->build();
     $isi   .= "</div>"; 
     
     return  Template_KotakPolos("Parameter Laporan Keuangan List",$isi);
 }
 
  function generate_tree_listneraca_view_ver($array, $parent = "0", $level = "0", $cmd)
  { 
    #print_r(count($array));exit();
    global  $_NeracaType;
    $dataCriteria = get_NeracaByApp_ver($_REQUEST[xid]);
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);     
    #print_r($dataCriteria);exit();
    foreach($dataCriteria as $dataCrit){
        foreach($dataCrit as $kcrit=>$vcrit){
            $data_C["BUS_NERACA_TAHUNAWAL"]                   =  $vcrit["BUS_NERACA_TAHUNAWAL"];
            $data_C["BUS_NERACA_TAHUNAKHIR"]                  =  $vcrit["BUS_NERACA_TAHUNAKHIR"];
            $data_C["BUS_NERACA_TAHUNJALAN"]                  =  $vcrit["BUS_NERACA_TAHUNJALAN"];
            $data_V[$vcrit["BUS_NERACA_TAHUNAWAL"]][$kcrit]   =  $vcrit["BUS_NERACA_VALUEAWAL"];
            $data_V[$vcrit["BUS_NERACA_TAHUNAKHIR"]][$kcrit]  =  $vcrit["BUS_NERACA_VALUEAKHIR"];
            $data_V[$vcrit["BUS_NERACA_TAHUNJALAN"]][$kcrit]  =  $vcrit["BUS_NERACA_VALUEJALAN"];
        }
    }
    #print_r($data_V);
    #exit();
    $x=1; 
    $total_array  = count($array);
    #print  $total_array;
    $has_children = false;
    #print_r($array); exit();
    foreach($data_C as $tahun){
    
        foreach($array as $key => $value)
        {       
            #$x++;#print $parent."&&&".$value["PARENT_NERACA"];
            #print $x;
            if(($parent!=$value["PARENT_NERACA"] && $parent!="0")){
              #print "<br>###";
              $id   = $parent;
              for($i=1;$i<$level;$i++){
                $sql    = " SELECT * FROM TYPE_NERACA WHERE ID_NERACA='$id'";
                $query  = sqlsrv_query($conn, $sql);
                $datas  = sqlsrv_fetch_array($query);
                
                #if($datas["PARENT_NERACA"]!="0" && $id!=$datas["PARENT_NERACA"])
                #  print "<b>Total ".$datas["NERACA_NAME"]."#".$datas["PARENT_NERACA"]."</b><br>";
                $new_array[$datas["ID_NERACA"]]    = array("ID_NERACA"=>$datas["ID_NERACA"],
                                                           "NERACA_NAME"=>$datas["NERACA_NAME"],
                                                           "PARENT_NERACA"=>$datas["PARENT_NERACA"]);
                #if($id_neraca!=$datas["ID_NERACA"])
                    #print $id."%%".$datas["PARENT_NERACA"]."<br>";
                    $total_value[$tahun][$x][$id] = $total_value[$tahun][$x][$datas["ID_NERACA"]];                                                                                      
                    $total_value[$tahun][$x][$datas["PARENT_NERACA"]] += $total_value[$tahun][$x][$id];
                    #print $datas["NERACA_NAME"]."#".$total_value[$x][$datas["ID_NERACA"]]."<br>"; 
                                                                    
                #print $datas["NERACA_NAME"]."**".$total_value[$datas["ID_NERACA"]]."<BR>";
                $id     = $datas["PARENT_NERACA"];
                $id_neraca  = $datas["ID_NERACA"];
              }
              #print "####<br>";
              $x++;
            } 
            $new_array[$value["ID_NERACA"]]    = array("ID_NERACA"=>$value["ID_NERACA"],
                                               "NERACA_NAME"=>$value["NERACA_NAME"],
                                               "PARENT_NERACA"=>$value["PARENT_NERACA"]);            
            
            
            
            #if($id_data!=$value["ID_NERACA"]){
                $total_value[$tahun][$x][$value["ID_NERACA"]] = $data_V[$tahun][$value["ID_NERACA"]];
                $total_value[$tahun][$x][$value["PARENT_NERACA"]] += $total_value[$tahun][$x][$value["ID_NERACA"]];        
            #}
            #print $value["NERACA_NAME"]."##".$total_value[$x][$value["ID_NERACA"]]."<br>"; 
            
            $parent = $value["PARENT_NERACA"];
            $id_data= $value["ID_NERACA"];
            $level  = $value["LEVEL"];
                 
    
            #$dt .= $value[PARENT_NERACA]."&nbsp;".$parent."<br>";
            #$select = "<a href=\"#\" onclick=\"sendpicker('$value[serial]','".$_SUBKATEGORIN[$value[serial]]."')\"><img src=\"PAGE/image/add.png\" border=\"0\" width=\"20\"></a>";
            
            #$dt .= generate_tree_listneraca_view($array, $key, $level, $cmd);  
           
        }
        #print_r($x); exit();
       # if($x==$total_array){
              $id   = $parent;
              
              for($i=1;$i<$level;$i++){ 
                $sql    = " SELECT * FROM TYPE_NERACA WHERE ID_NERACA='$id'";
                $query  = sqlsrv_query($conn, $sql);
                $datas  = sqlsrv_fetch_array($query);
                $new_array[$datas["ID_NERACA"]]    = array("ID_NERACA"=>$datas["ID_NERACA"],
                                                           "NERACA_NAME"=>$datas["NERACA_NAME"],
                                                           "PARENT_NERACA"=>$datas["PARENT_NERACA"]);
                #if($id_neraca!=$datas["ID_NERACA"])                                                   
                $total_value[$tahun][$x][$id] = $total_value[$tahun][$x][$datas["ID_NERACA"]];
                #print $sql."<br>";                                                                                      
                $total_value[$tahun][$x][$datas["PARENT_NERACA"]] += $total_value[$tahun][$x][$id];
                #print $datas["NERACA_NAME"]."#".$total_value[$x][$datas["ID_NERACA"]]."<br>";
                $id  = $datas["PARENT_NERACA"];                                                
              }    
       } 
              
    #}
    //foreach($total_value as $tv){
    //   foreach($tv as $ktv=>$ctv){
    //       $asap[$ktv]  += $ctv;
    //   }
    //}
    foreach($total_value as $tahun=>$jml){
      foreach($jml as $tv){
         foreach($tv as $ktv=>$ctv){
             $asap[$tahun][$ktv]  += $ctv;
         }
      }
    }
        
    
    #foreach($total_value as $thn=>$atv){
       #print_r($tv);
       #foreach($atv as $ktv=>$vtv){
       #   foreach($vtv as $in_neraca=>$vneraca){
       #       $asap[$x][$in_neraca]+=$vneraca;
       #   }
       #}
    #} 
    #print_r($asap);exit();
    #$total_value  = $total_value+$total_values;
    #print_r($asap);exit();
    ksort($new_array);
    ksort($asap);
    #print_r($new_array);exit();
    $dt = generate_tree_listneraca_test_ver($new_array, "0", "0", $cmd, $asap);
    return $dt;
  
  }
  
  function generate_tree_listneraca_test_ver($array, $parent = "0", $level = "0", $cmd, $total_value)
  { 
    global  $_NeracaType, $_NERACAKET, $_Month;
    $dataCriteria = get_NeracaByApp_ver($_REQUEST[xid]);
    #print_r($array); exit();
    foreach($dataCriteria as $dataCrit){
        foreach($dataCrit as $kcrit=>$vcrit){
            $data_C["BUS_NERACA_TAHUNAWAL"]                   =  $vcrit["BUS_NERACA_TAHUNAWAL"];
            $data_C["BUS_NERACA_TAHUNAKHIR"]                  =  $vcrit["BUS_NERACA_TAHUNAKHIR"];
            $data_C["BUS_NERACA_TAHUNJALAN"]                  =  $vcrit["BUS_NERACA_TAHUNJALAN"];
            $data_KET["1"]                                    = trim($dataCriteria[$_REQUEST[xid]][$kcrit]["BUS_NERACA_KETAWAL"]);
            $data_KET["2"]                                    = trim($dataCriteria[$_REQUEST[xid]][$kcrit]["BUS_NERACA_KETAKHIR"]);
            $data_KET["3"]                                    = trim($dataCriteria[$_REQUEST[xid]][$kcrit]["BUS_NERACA_KETJALAN"]);
            $data_KET["4"]                                    = trim($dataCriteria[$_REQUEST[xid]][$kcrit]["BUS_NERACA_MONJALAN"]);
        }
    }    
    #print_r($data_KET);exit();
    $x=1; 
    $has_children = false;             #print_r($array);
    foreach($array as $key => $value)
    { //print $value[PARENT_NERACA]."###".$key."<br>";  
      if ($value['PARENT_NERACA'] == $parent) 
      {                   
        if ($has_children === false)
        {
          $has_children = true;  
          $level++;
        }                
                                          
        if($value[PARENT_NERACA]=="0"){ 
          $dt .= "<table width=\"100%\" >";
          $dt .= "<tr><td class=\"tableheader\">&nbsp;</td>";
          foreach($data_C as $tahun){
              $dt .= "<td class=\"tableheader\" width=\"100\" align=\"center\">".$tahun."</td>";          
          }
          $dt .= "</tr>"; 
          $dt .= "<tr><td class=\"tablecontentgrid\">&nbsp;</td>";
          $t  =1;
          foreach($data_C as $tahun){
              $dt .= "<td class=\"tablecontentgrid\" width=\"100\" align=\"center\">".($data_KET[$t]!=""?$_NERACAKET[$data_KET[$t]]:$_Month[$data_KET["4"]])."</td>";
              $t++;          
          }
          $dt .= "</tr>";                   
          $dt .= "<tr><td class=\"tableheader\">".$_NeracaType[$value['ID_NERACA']]."&nbsp;</td>";
          foreach($data_C as $tahun){
              $dt .= "<td class=\"tableheader\" width=\"100\" align=\"right\">".number_format($total_value[$tahun][$value['ID_NERACA']])."</td>";          
          }
          $dt .= "</tr></table>";
        #   $dt .= $value[NERACA_NAME];
        }else{  
          $dt .= "<table width=\"100%\" ><tr><td class=\"tablecontentgrid\">".str_repeat('<b><style=\"font-size:16px;\">&#9634;&nbsp;</style></b>',$level)."&nbsp;".$value['NERACA_NAME']."</td>";
          foreach($data_C as $tahun){
              $dt .= "<td class=\"tablecontentgrid\" align=\"right\" width=\"100\">".number_format($total_value[$tahun][$value['ID_NERACA']])."</td>";
          }
          $dt .= "</tr></table>";
          $x++;
        }        
        $dt .= generate_tree_listneraca_test_ver($array, $key, $level, $cmd, $total_value);                          

      }
       
    }
  
    return $dt;
  
  }
  
 function  get_frmneraca_save_ver($cmd){
    global  $_NeracaType, $msgDBSave, $msgDBError;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria     = gen_NeracaTypeByScoring($app[ID_SCORING_TYPE]);
    $dataCriteria = get_NeracaByApp_ver($_REQUEST[xid]);
    $where .= " AND A.STATUS <> 99 AND B.STATUS <> 99 AND B.ID_SCORING_TYPE='".$app[ID_SCORING_TYPE]."'"; 
    #print_r($dataCriteria); exit();
    $sql    = " SELECT A.* FROM TYPE_NERACA A LEFT JOIN SCORING_NERACA B ON A.ID_NERACA=B.ID_NERACA  WHERE 1=1 $where ORDER BY A.PARENT_NERACA";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){ 
      $data_r[$data[ID_NERACA]] = array("ID_NERACA"=>"$data[ID_NERACA]","NERACA_NAME"=>"$data[NERACA_NAME]","PARENT_NERACA"=>"$data[PARENT_NERACA]", "LEVEL"=>"$data[LEVELS]");
    }
    #print_r($data_r);
    
    foreach($data_r as $key => $value)
    {       
        if(($parent!=$value["PARENT_NERACA"] && $parent!="0")){
          #print "<br>###";
          $id   = $parent;
          for($i=1;$i<$level;$i++){
            $sql    = " SELECT * FROM TYPE_NERACA WHERE ID_NERACA='$id'";
            $query  = sqlsrv_query($conn, $sql);
            $datas  = sqlsrv_fetch_array($query);
            
            $new_array[$datas["ID_NERACA"]]    = array("ID_NERACA"=>$datas["ID_NERACA"],
                                                       "NERACA_NAME"=>$datas["NERACA_NAME"],
                                                       "PARENT_NERACA"=>$datas["PARENT_NERACA"]);
    
            $total_value[$x][$id]["AWAL"] = $total_value[$x][$datas["ID_NERACA"]]["AWAL"];
            $total_value[$x][$id]["AKHIR"] = $total_value[$x][$datas["ID_NERACA"]]["AKHIR"];
            $total_value[$x][$id]["JALAN"] = $total_value[$x][$datas["ID_NERACA"]]["JALAN"];                                                                                       
            $total_value[$x][$datas["PARENT_NERACA"]]["AWAL"] += $total_value[$x][$id]["AWAL"];
            $total_value[$x][$datas["PARENT_NERACA"]]["AKHIR"] += $total_value[$x][$id]["AKHIR"];
            $total_value[$x][$datas["PARENT_NERACA"]]["JALAN"] += $total_value[$x][$id]["JALAN"];
    
            $id     = $datas["PARENT_NERACA"];
            $id_neraca  = $datas["ID_NERACA"];
          }
          $x++;
        } 
        $new_array[$value["ID_NERACA"]]    = array("ID_NERACA"=>$value["ID_NERACA"],
                                           "NERACA_NAME"=>$value["NERACA_NAME"],
                                           "PARENT_NERACA"=>$value["PARENT_NERACA"]);            
        #print $value["ID_NERACA"]."<br>";
        $total_value[$x][$value["ID_NERACA"]]["AWAL"] = str_replace(",","",$_REQUEST["nilaiawal_".$value["ID_NERACA"]]);
        $total_value[$x][$value["ID_NERACA"]]["AKHIR"] = str_replace(",","",$_REQUEST["nilaiakhir_".$value["ID_NERACA"]]);
        $total_value[$x][$value["ID_NERACA"]]["JALAN"] = str_replace(",","",$_REQUEST["nilaijalan_".$value["ID_NERACA"]]);
        $total_value[$x][$value["PARENT_NERACA"]]["AWAL"] += $total_value[$x][$value["ID_NERACA"]]["AWAL"];
        $total_value[$x][$value["PARENT_NERACA"]]["AKHIR"] += $total_value[$x][$value["ID_NERACA"]]["AKHIR"];
        $total_value[$x][$value["PARENT_NERACA"]]["JALAN"] += $total_value[$x][$value["ID_NERACA"]]["JALAN"];        
        
        $parent = $value["PARENT_NERACA"];
        $id_data= $value["ID_NERACA"];
        $level  = $value["LEVEL"]; 
       
    }
    $id   = $parent;
          
    for($i=1;$i<$level;$i++){ 
      $sql    = " SELECT * FROM TYPE_NERACA WHERE ID_NERACA='$id'";
      $query  = mssql_query($sql);
      $datas  = mssql_fetch_array($query);
      $new_array[$datas["ID_NERACA"]]    = array("ID_NERACA"=>$datas["ID_NERACA"],
                                                 "NERACA_NAME"=>$datas["NERACA_NAME"],
                                                 "PARENT_NERACA"=>$datas["PARENT_NERACA"]);
      #if($id_neraca!=$datas["ID_NERACA"])                                                   
      $total_value[$x][$id]["AWAL"] = $total_value[$x][$datas["ID_NERACA"]]["AWAL"];
      $total_value[$x][$id]["AKHIR"] = $total_value[$x][$datas["ID_NERACA"]]["AKHIR"];
      $total_value[$x][$id]["JALAN"] = $total_value[$x][$datas["ID_NERACA"]]["JALAN"];
      #print $sql."<br>";                                                                                      
      $total_value[$x][$datas["PARENT_NERACA"]]["AWAL"] += $total_value[$x][$id]["AWAL"];
      $total_value[$x][$datas["PARENT_NERACA"]]["AKHIR"] += $total_value[$x][$id]["AKHIR"];
      $total_value[$x][$datas["PARENT_NERACA"]]["JALAN"] += $total_value[$x][$id]["JALAN"];
      #print $datas["NERACA_NAME"]."#".$total_value[$x][$datas["ID_NERACA"]]."<br>";
      $id  = $datas["PARENT_NERACA"];                                                
    }
    
    foreach($total_value as $tv){
      foreach($tv as $ktv=>$vtv){ 
         $dt[$ktv]["AWAL"]   +=  $vtv["AWAL"];
         $dt[$ktv]["AKHIR"]  +=  $vtv["AKHIR"];
         $dt[$ktv]["JALAN"]  +=  $vtv["JALAN"];
         $dt[$ktv]["TAWAL"]   = $_REQUEST["tahunawal"];
         $dt[$ktv]["TAKHIR"]  = $_REQUEST["tahunakhir"];
         $dt[$ktv]["TJALAN"]  = $_REQUEST["tahunjalan"];
         $dt[$ktv]["KAWAL"]   = $_REQUEST["ketawal"];
         $dt[$ktv]["KAKHIR"]  = $_REQUEST["ketakhir"];
         $dt[$ktv]["MJALAN"]  = $_REQUEST["monjalan"];
      }
    }
    
    foreach($dt as $kdt=>$vdt){
       $tahunawal[$kdt]        = $dataCriteria[$_REQUEST[xid]][$kdt]["BUS_NERACA_TAHUNAWAL"];
       $id                     = getId("BUS_NERACA_VER","ID_BUS_NERACA");
       if(count($tahunawal[$kdt])=="0"){
         $sql      = " INSERT INTO BUS_NERACA_VER(ID_BUS_NERACA,ID_BUS_APPLICATION,ID_NERACA,BUS_NERACA_TAHUNAWAL,BUS_NERACA_TAHUNAKHIR, BUS_NERACA_TAHUNJALAN, BUS_NERACA_VALUEAWAL,BUS_NERACA_VALUEAKHIR,BUS_NERACA_VALUEJALAN,BUS_NERACA_KETAWAL,BUS_NERACA_KETAKHIR,BUS_NERACA_KETJALAN, BUS_NERACA_MONJALAN)
                       VALUES('$id','$_REQUEST[xid]','$kdt','".$vdt["TAWAL"]."','".$vdt["TAKHIR"]."','".$vdt["TJALAN"]."','".$vdt["AWAL"]."','".$vdt["AKHIR"]."','".$vdt["JALAN"]."','".$vdt["KAWAL"]."','".$vdt["KAKHIR"]."','".$vdt["KJALAN"]."','".$vdt["MJALAN"]."')";
         #print $sql."<br>"."<br>"; //exit();
         $query    = sqlsrv_query($sql);         
       }
       else{
           get_frmneraca_update_ver($cmd);
       }        
    }
    
    #print_r($dt); 
    #exit();    
         
    return Template_KotakPolos("Laporan Keuangan",$msgDBSave);         
 }
 
  function  get_frmneraca_update_ver($cmd){
    global  $_NeracaType, $msgDBSave, $msgDBError,$msgDBUpdate;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $criteria     = gen_NeracaTypeByScoring($app[ID_SCORING_TYPE]);
    $dataCriteria = get_NeracaByApp_ver($_REQUEST[xid]);
    $where .= " AND A.STATUS <> 99 AND B.STATUS <> 99 AND B.ID_SCORING_TYPE='".$app[ID_SCORING_TYPE]."'"; 
    #print_r($dataCriteria); exit();
    $sql    = " SELECT A.* FROM TYPE_NERACA A LEFT JOIN SCORING_NERACA B ON A.ID_NERACA=B.ID_NERACA  WHERE 1=1 $where ORDER BY A.PARENT_NERACA";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data = sqlsrv_fetch_array($query)){ 
      $data_r[$data[ID_NERACA]] = array("ID_NERACA"=>"$data[ID_NERACA]","NERACA_NAME"=>"$data[NERACA_NAME]","PARENT_NERACA"=>"$data[PARENT_NERACA]", "LEVEL"=>"$data[LEVELS]");
    }
    #print_r($data_r);
    
    foreach($data_r as $key => $value)
    {       
        if(($parent!=$value["PARENT_NERACA"] && $parent!="0")){
          #print "<br>###";
          $id   = $parent;
          for($i=1;$i<$level;$i++){
            $sql    = " SELECT * FROM TYPE_NERACA WHERE ID_NERACA='$id'";
            $query  = sqlsrv_query($conn, $sql);
            $datas  = sqlsrv_fetch_array($query);
            
            $new_array[$datas["ID_NERACA"]]    = array("ID_NERACA"=>$datas["ID_NERACA"],
                                                       "NERACA_NAME"=>$datas["NERACA_NAME"],
                                                       "PARENT_NERACA"=>$datas["PARENT_NERACA"]);
    
            $total_value[$x][$id]["AWAL"] = $total_value[$x][$datas["ID_NERACA"]]["AWAL"];
            $total_value[$x][$id]["AKHIR"] = $total_value[$x][$datas["ID_NERACA"]]["AKHIR"];
            $total_value[$x][$id]["JALAN"] = $total_value[$x][$datas["ID_NERACA"]]["JALAN"];                                                                                       
            $total_value[$x][$datas["PARENT_NERACA"]]["AWAL"] += $total_value[$x][$id]["AWAL"];
            $total_value[$x][$datas["PARENT_NERACA"]]["AKHIR"] += $total_value[$x][$id]["AKHIR"];
            $total_value[$x][$datas["PARENT_NERACA"]]["JALAN"] += $total_value[$x][$id]["JALAN"];
    
            $id     = $datas["PARENT_NERACA"];
            $id_neraca  = $datas["ID_NERACA"];
          }
          $x++;
        } 
        $new_array[$value["ID_NERACA"]]    = array("ID_NERACA"=>$value["ID_NERACA"],
                                           "NERACA_NAME"=>$value["NERACA_NAME"],
                                           "PARENT_NERACA"=>$value["PARENT_NERACA"]);            
        #print $value["ID_NERACA"]."<br>";
        $total_value[$x][$value["ID_NERACA"]]["AWAL"] = str_replace(",","",$_REQUEST["nilaiawal_".$value["ID_NERACA"]]);
        $total_value[$x][$value["ID_NERACA"]]["AKHIR"] = str_replace(",","",$_REQUEST["nilaiakhir_".$value["ID_NERACA"]]);
        $total_value[$x][$value["ID_NERACA"]]["JALAN"] = str_replace(",","",$_REQUEST["nilaijalan_".$value["ID_NERACA"]]);
        $total_value[$x][$value["PARENT_NERACA"]]["AWAL"] += $total_value[$x][$value["ID_NERACA"]]["AWAL"];
        $total_value[$x][$value["PARENT_NERACA"]]["AKHIR"] += $total_value[$x][$value["ID_NERACA"]]["AKHIR"];
        $total_value[$x][$value["PARENT_NERACA"]]["JALAN"] += $total_value[$x][$value["ID_NERACA"]]["JALAN"];        
        
        $parent = $value["PARENT_NERACA"];
        $id_data= $value["ID_NERACA"];
        $level  = $value["LEVEL"]; 
       
    }
    $id   = $parent;
          
    for($i=1;$i<$level;$i++){ 
      $sql    = " SELECT * FROM TYPE_NERACA WHERE ID_NERACA='$id'";
      $query  = sqlsrv_query($conn, $sql);
      $datas  = sqlsrv_fetch_array($query);
      $new_array[$datas["ID_NERACA"]]    = array("ID_NERACA"=>$datas["ID_NERACA"],
                                                 "NERACA_NAME"=>$datas["NERACA_NAME"],
                                                 "PARENT_NERACA"=>$datas["PARENT_NERACA"]);
      #if($id_neraca!=$datas["ID_NERACA"])                                                   
      $total_value[$x][$id]["AWAL"] = $total_value[$x][$datas["ID_NERACA"]]["AWAL"];
      $total_value[$x][$id]["AKHIR"] = $total_value[$x][$datas["ID_NERACA"]]["AKHIR"];
      $total_value[$x][$id]["JALAN"] = $total_value[$x][$datas["ID_NERACA"]]["JALAN"];
      #print $sql."<br>";                                                                                      
      $total_value[$x][$datas["PARENT_NERACA"]]["AWAL"] += $total_value[$x][$id]["AWAL"];
      $total_value[$x][$datas["PARENT_NERACA"]]["AKHIR"] += $total_value[$x][$id]["AKHIR"];
      $total_value[$x][$datas["PARENT_NERACA"]]["JALAN"] += $total_value[$x][$id]["JALAN"];
      #print $datas["NERACA_NAME"]."#".$total_value[$x][$datas["ID_NERACA"]]."<br>";
      $id  = $datas["PARENT_NERACA"];                                                
    }
    
    foreach($total_value as $tv){
      foreach($tv as $ktv=>$vtv){ 
         $dt[$ktv]["AWAL"]   +=  $vtv["AWAL"];
         $dt[$ktv]["AKHIR"]  +=  $vtv["AKHIR"];
         $dt[$ktv]["JALAN"]  +=  $vtv["JALAN"];
         $dt[$ktv]["TAWAL"]   = $_REQUEST["tahunawal"];
         $dt[$ktv]["TAKHIR"]  = $_REQUEST["tahunakhir"];
         $dt[$ktv]["TJALAN"]  = $_REQUEST["tahunjalan"];
         $dt[$ktv]["KAWAL"]   = $_REQUEST["ketawal"];
         $dt[$ktv]["KAKHIR"]  = $_REQUEST["ketakhir"];
         $dt[$ktv]["MJALAN"]  = $_REQUEST["monjalan"];
      }
    }
    
    foreach($dt as $kdt=>$vdt){
       $sql = " UPDATE BUS_NERACA_VER SET BUS_NERACA_TAHUNAWAL  ='".$vdt["TAWAL"]."',
                                      BUS_NERACA_TAHUNAKHIR ='".$vdt["TAKHIR"]."',
                                      BUS_NERACA_TAHUNJALAN ='".$vdt["TJALAN"]."',
                                      BUS_NERACA_VALUEAWAL  ='".str_replace(",","",$vdt["AWAL"])."',
                                      BUS_NERACA_VALUEAKHIR ='".str_replace(",","",$vdt["AKHIR"])."',
                                      BUS_NERACA_VALUEJALAN ='".str_replace(",","",$vdt["JALAN"])."',
                                      BUS_NERACA_KETAWAL    ='".$vdt["KAWAL"]."',
                                      BUS_NERACA_KETAKHIR   ='".$vdt["KAKHIR"]."',
                                      BUS_NERACA_KETJALAN   ='".$vdt["KJALAN"]."',
                                      BUS_NERACA_MONJALAN   ='".$vdt["MJALAN"]."'
                WHERE ID_BUS_APPLICATION='$_REQUEST[xid]' AND ID_NERACA='$kdt'";
       #print $sql."<br>"."<br>"; //exit();
       $query = sqlsrv_query($conn, $sql);         
    }
    
    #print_r($dt); 
    #exit();    
         
    return Template_KotakPolos("Laporan Keuangan",$msgDBUpdate);         
 }
 
 function get_ScoringApplication_ver($cmd){
    global  $_FormulaType,$_NERACAKET, $_Month;
    $app          = module_getApplication_byid_ver($_REQUEST[xid]);
    $bus_formula  = get_FormulaByScoring($app[ID_SCORING_TYPE]);
    $neraca       = get_NeracaValuebyAppYear_ver($_REQUEST[xid]);
    $ketneraca    = get_NeracaKetbyAppYear_ver($_REQUEST[xid]);
    #print_r($neraca);
    foreach($neraca as $tahun){
        foreach($tahun as $thn=>$vneraca){
            $year[$thn] = $thn;
        }
    }
    foreach($ketneraca as $ket){
        foreach($ket as $thn=>$vketneraca){
            $kt[$thn] = trim($vketneraca);
        }
    } 
    #print_r($kt);   
    $form .= "<div id=\"tablecontent\">"; 
    $form .= "<table width=\"100%\">";
    $form .= "<tr><td class=\"tableheader\" rowspan=\"2\">RASIO KEUANGAN</td>";
    foreach($year as $yr){
      $form .= "<td class=\"tableheader\" align=\"right\">$yr</td>";
    }
    $form .= "</tr>";
    $form .= "<tr>";
    foreach($year as $yr){
      $form .= "<td class=\"tableheader\" align=\"right\">".$_NERACAKET[$kt[$yr]].$_Month[$kt[$yr]]."</td>";
    }
    $form .= "</tr>";        
    foreach($bus_formula as $id_formula=>$vbusformula){
        foreach($vbusformula as $kfrm=>$frm){ 
           foreach($year as $yr){
               $rumus[$id_formula][$yr]             = $frm[FORMULA];
               $dt[$id_formula][$yr][$frm[ID_SORT]] = $frm[ID_NERACA];
           }
        }
        foreach($dt[$id_formula] as $key=>$val){
           foreach($val as $kval=>$vl){
              $str_awal  = trim("<".$kval.">");
              $neraca[$vl][$key]  = abs(($neraca[$vl][$key]!=""?$neraca[$vl][$key]:"0"));
              $rumus[$id_formula][$key]       = str_replace($str_awal,$neraca[$vl][$key],$rumus[$id_formula][$key]); 
              
           }
        }
        $form .= "<tr><td class=\"tablecontentgrid\">".$_FormulaType[$id_formula]."</td>";
        foreach($year as $yr){
            $rms[$yr]   = eval('return '.$rumus[$id_formula][$yr].';'); 
            $form .= "<td class=\"tablecontentgrid\" align=\"right\">".number_format($rms[$yr],2)."</td>";
        }
        $form .= "</tr>";
    }
    $form .= "</table>";
    $form .= "</div>";    
    #print_r($dt);
/*   
    #print_r($bus_formula); exit();
    $form .= "<div id=\"tablecontent\">"; 
    $form .= "<table width=\"100%\">";
    $form .= "<tr><td class=\"tableheader\">PARAMETER</td><td class=\"tableheader\">HASIL</td></tr>";
    foreach($bus_formula as $id_formula=>$vbusformula){
        foreach($vbusformula as $kfrm=>$frm){ 
            #print_r($kfrm)."<br>";            
            $fr[$id_formula]                 = $frm[FORMULA];
            $dt[$id_formula][$frm[ID_SORT]]  = $frm[ID_NERACA]; 
        }
        #print_r($dt[$id_formula]);//exit();
        $rumus[$id_formula]  = $fr[$id_formula]; 
        foreach($dt[$id_formula] as $key=>$val){
           $str_awal  = trim("<".$key.">");
           $rumus[$id_formula] = str_replace("$str_awal",$neraca[$val],$rumus[$id_formula]);  
        }
        $id_sort              = get_SortFormula($id_formula)-1;
        $cek                  = cek_FormulaParam($id_formula);
        $hasil                = eval('return '.$rumus[$id_formula].';');         
        #print $_FormulaType[$id_formula].$rumus[$id_formula]."<br>";
        $form .= "<tr><td class=\"tablecontentgrid\">".$_FormulaType[$id_formula]."</td><td class=\"tablecontentgrid\" align=\"right\">".($id_sort==$cek?number_format($hasil,2):"&nbsp;")."</td></tr>";          
    }
    $form .= "</table>";
    $form .= "</div>";*/ 
    return Template_KotakPolos("Resume Rasio Keuangan",$form); 
 }
 
 function get_NeracaValuebyApp_ver($app_id){
    $sql    = " SELECT * FROM BUS_NERACA_VER WHERE ID_BUS_APPLICATION='$app_id'"; 
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data=sqlsrv_fetch_array($query)){
        $dt[$data[ID_NERACA]] = $data[BUS_NERACA_VALUEAKHIR];    
    } 
    return $dt;
 }
 
 function get_NeracaValuebyAppYear_ver($app_id){
    $sql    = " SELECT A.* FROM BUS_NERACA_VER A 
                LEFT JOIN TYPE_NERACA B ON B.ID_NERACA=A.ID_NERACA
                WHERE A.ID_BUS_APPLICATION='$app_id' AND B.STATUS<>'99'";
    #print $sql; 
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data=sqlsrv_fetch_array($query)){
        $dt[$data[ID_NERACA]][$data[BUS_NERACA_TAHUNAWAL]]  = $data[BUS_NERACA_VALUEAWAL];
        $dt[$data[ID_NERACA]][$data[BUS_NERACA_TAHUNAKHIR]] = $data[BUS_NERACA_VALUEAKHIR];
        $dt[$data[ID_NERACA]][$data[BUS_NERACA_TAHUNJALAN]] = $data[BUS_NERACA_VALUEJALAN];
        #$dt[$data[ID_NERACA]][$data[BUS_NERACA_MONJALAN]]   = $data[BUS_NERACA_MONJALAN];
        #$dt[$data[ID_NERACA]][$data[BUS_NERACA_KETAWAL]]    = $data[BUS_NERACA_KETAWAL];
        #$dt[$data[ID_NERACA]][$data[BUS_NERACA_KETAKHIR]]   = $data[BUS_NERACA_KETAKHIR];
             
    } 
    return $dt;
 }
 
 function get_NeracaKetbyAppYear_ver($app_id){
    $sql    = " SELECT A.* FROM BUS_NERACA_VER A 
                LEFT JOIN TYPE_NERACA B ON B.ID_NERACA=A.ID_NERACA
                WHERE A.ID_BUS_APPLICATION='$app_id' AND B.STATUS<>'99'";
    #print $sql; 
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    while($data=sqlsrv_fetch_array($query)){
        $dt[$data[ID_NERACA]][$data[BUS_NERACA_TAHUNAWAL]]  = $data[BUS_NERACA_KETAWAL];
        $dt[$data[ID_NERACA]][$data[BUS_NERACA_TAHUNAKHIR]] = $data[BUS_NERACA_KETAKHIR];
        $dt[$data[ID_NERACA]][$data[BUS_NERACA_TAHUNJALAN]] = $data[BUS_NERACA_MONJALAN];
        #$dt[$data[ID_NERACA]][$data[BUS_NERACA_MONJALAN]]   = $data[BUS_NERACA_MONJALAN];
        #$dt[$data[ID_NERACA]][$data[BUS_NERACA_KETAWAL]]    = $data[BUS_NERACA_KETAWAL];
        #$dt[$data[ID_NERACA]][$data[BUS_NERACA_KETAKHIR]]   = $data[BUS_NERACA_KETAKHIR];
             
    } 
    return $dt;
 }
 
  function module_hasilscoring_ver($cmd){
       global $min_skor, $_CriteriaType, $_YATIDAK, $_USER,$_FormulaType;
       $app          = module_getApplication_byid_ver($_REQUEST[xid]);
       $hsl_akhir    = get_ScoringParam_byIdScoringType($app[ID_SCORING_TYPE]);
       $rumus_final  = get_FinFormulaByScoring($app[ID_SCORING_TYPE]);
       $criteria     = gen_CriteriaTypeByScoring($app[ID_SCORING_TYPE]);
       $dataCriteria = get_CriteriaByApp_ver($_REQUEST[xid]);
       $min_scoring  = get_min_scoringbyType($app[ID_SCORING_TYPE]);
       $min_skor     = $min_scoring;       
       //print_r($app);
       
       foreach($hsl_akhir as $hsl_idscoringpoint){
          foreach($hsl_idscoringpoint as $hsl){
              #print_r($hsl);
              list($rawal,$rakhir)      = explode("a",$hsl[SCORINGPOINT_ATTRIBUT]);
              #print trim($hsl[NERACA])."##".trim($hsl[APPLICATION])."##".trim($hsl[FORMULA])."<br>";          
              if((trim($hsl[NERACA])!="")){
                  unset($sql);
                  unset($data);
                  unset($param1);
                  unset($param2);                  
                  $sql          = " SELECT * FROM BUS_NERACA_VER WHERE ID_NERACA='$hsl[NERACA]' AND ID_BUS_APPLICATION='$_REQUEST[xid]'";
                  #print $sql;
                  GLOBAL $connectionInfo, $SQLHost;
                  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
                  $query = sqlsrv_query($conn,$sql);
                  $data         = sqlsrv_fetch_array($query);
                  $value_awal   = $data[BUS_NERACA_VALUEAWAL];
                  $value_akhir  = $data[BUS_NERACA_VALUEAKHIR];
                  
                  $param1       = eval('return '.$rawal.$value_akhir.';');
                  $param2       = eval('return '.$value_akhir.$rakhir.';');
                  
                  if($rawal!="" && $rakhir!=""){
                      if($param1 and $param2){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                  
                  }elseif($awal=="" && $rakhir!=""){
                      if($param2){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point_neraca  = 0;
                      }                      
                  }elseif($awal!="" && $rakhir==""){
                      if($param1){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                  
                  }else{
                     $point[$hsl[ID_SCORINGVALUE]]  = 0;
                  }

                           
              }elseif(trim($hsl[APPLICATION])!=""){
                  unset($sql);
                  unset($data);
                  unset($param1);
                  unset($param2);                  
                  $sql          = " SELECT $hsl[APPLICATION] AS NILAI FROM BUS_APPLICATION_VER WHERE ID_BUS_APPLICATION='$_REQUEST[xid]'";
                  GLOBAL $connectionInfo, $SQLHost;
                  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
                  $query = sqlsrv_query($conn,$sql);
                  $data         = sqlsrv_fetch_array($query);
                  $nilai_hasil  = $data[NILAI];
                  $param1       = eval('return '.$rawal.$nilai_hasil.';');
                  $param2       = eval('return '.$nilai_hasil.$rakhir.';');
                  
                  if($rawal!="" && $rakhir!=""){
                      if($param1 and $param2){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                  
                  }elseif($awal=="" && $rakhir!=""){
                      if($param2){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                      
                  }elseif($awal!="" && $rakhir==""){
                      if($param1){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                  
                  }else{
                     $point[$hsl[ID_SCORINGVALUE]]  = 0;
                  }                  
                                                  
              }elseif(trim($hsl[FORMULA])!=""){
                  unset($data);
                  unset($param1);
                  unset($param2);              
                  $bus_formula  = get_FormulaByScoring($app[ID_SCORING_TYPE]);
                  $neraca       = get_NeracaValuebyApp($_REQUEST[xid]);
                 
                  #print_r($bus_formula); exit();
                  foreach($bus_formula as $id_formula=>$vbusformula){
                      foreach($vbusformula as $kfrm=>$frm){
                          #print_r($kfrm)."<br>";            
                          $fr[$id_formula]                 = $frm[FORMULA];
                          $dt[$id_formula][$frm[ID_SORT]]  = $frm[ID_NERACA];
                      }
                      #print_r($fr[$id_formula])."<br>";//exit();
                      $rumus[$id_formula]  = $fr[$id_formula];
                      foreach($dt[$id_formula] as $key=>$val){
                         $str_awal  = trim("<".$key.">");
                         $rumus[$id_formula] = str_replace("$str_awal",abs($neraca[$val]),$rumus[$id_formula]);
                         #print $_FormulaType[$id_formula]."###".$rumus[$id_formula]."<br>";  
                      }
                      #$id_sort                     = get_SortFormula($id_formula)-1;
                      #$cek                         = cek_FormulaParam($id_formula);
                      $hasil_formula                = eval('return '.$rumus[$hsl[FORMULA]].';');         
                      #print $_FormulaType[$id_formula].$rumus[$id_formula]."<br>";          
                  }
                 # print $rawal.$hasil_formula."#".$hasil_formula.$rakhir;
                 # print $hasil_formula."<br>";
                  $param1       = eval('return '.$rawal.$hasil_formula.';');
                  $param2       = eval('return '.$hasil_formula.$rakhir.';');
                  #print $rawal.$hasil_formula.$rakhir."<br>";
                  if($rawal!="" && $rakhir!=""){
                      if($param1 and $param2){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                  
                  }elseif($awal=="" && $rakhir!=""){
                      if($param2){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                      
                  }elseif($awal!="" && $rakhir==""){
                      if($param1){
                         $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                      }else{
                         $point[$hsl[ID_SCORINGVALUE]]  = 0;
                      }                  
                  }else{
                     $point[$hsl[ID_SCORINGVALUE]]  = 0;
                  }                                    
                               
              }elseif(trim($hsl[COLLTYPE])!=""){
                    $sql    = " SELECT SUM(TC.COLL_SCOR) AS JML_POINT FROM BUS_COLLATERAL_VER BC
                                LEFT JOIN TYPE_COLLATERAL TC ON BC.ID_COLL=TC.ID_COLL WHERE BC.COLL_TYPE='$hsl[COLLTYPE]' AND BC.ID_BUS_APPLICATION='$_REQUEST[xid]' AND BC.STATUS='1'";
                    GLOBAL $connectionInfo, $SQLHost;
                    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
                    $query = sqlsrv_query($conn,$sql);
                    $data   = sqlsrv_fetch_array($query);
                    $nilai_hasil  = $data[JML_POINT];
                    #print $sql;
                    $param1       = eval('return '.$rawal.$nilai_hasil.';');
                    $param2       = eval('return '.$nilai_hasil.$rakhir.';');
                    
                    if($rawal!="" && $rakhir!=""){
                        if($param1 and $param2){
                           $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                        }else{
                           $point[$hsl[ID_SCORINGVALUE]]  = 0;
                        }                  
                    }elseif($awal=="" && $rakhir!=""){
                        if($param2){
                           $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                        }else{
                           $point[$hsl[ID_SCORINGVALUE]]  = 0;
                        }                      
                    }elseif($awal!="" && $rakhir==""){
                        if($param1){
                           $point[$hsl[ID_SCORINGVALUE]]  = $hsl[SCORINGPOINT_POINT]; break;
                        }else{
                           $point[$hsl[ID_SCORINGVALUE]]  = 0;
                        }                  
                    }else{
                       $point[$hsl[ID_SCORINGVALUE]]  = 0;
                    }                     
              }          
          }
       }
      #print_r($point); 
      foreach($rumus_final as $id_finformula=>$vbusfinformula){
          foreach($vbusfinformula as $finkfrm=>$finfrm){
              #print_r($finkfrm)."<br>";            
              $fr[$id_finformula]                    = $finfrm[FINFORMULA];
              $dt[$id_finformula][$finfrm[ID_SORT]]  = $finfrm[ID_BUS_SCORINGPOINT];
          }
          #print_r($dt[$id_finformula]);//exit();
          $finrumus[$id_finformula]  = $fr[$id_finformula];
          #print   $finrumus[$id_finformula];
          foreach($dt[$id_finformula] as $finkey=>$finval){
             #print "###".$finval;
             $finstr_awal  = trim("<".$finkey.">");
             $finrumus[$id_finformula] = str_replace($finstr_awal,$point[$finval],$finrumus[$id_finformula]);  
          }
          #$id_sort                     = get_SortFormula($id_formula)-1;
          #$cek                         = cek_FormulaParam($id_formula);
          #print "####".$finrumus[$id_finformula];
          $hasil_finformula                = eval('return '.$finrumus[$id_finformula].';');
          #print "Nilai Akhir: ".$hasil_finformula."<br># Rumus".$finrumus[$id_finformula];

          if($app['STATUS']>2){
              $update_finscore                 = update_finscore_ver($hasil_finformula,$_REQUEST[xid]);
              $hasil_finformula                = get_finscore($_REQUEST[xid]); //print $app['STATUS']."###";          
              if($hasil_finformula >= $min_skor)
                  $msg    = "<div id=\"tablecontent\"><table width=\"100%\"><tr><td class=\"tablecontentgrid\" align=\"center\"><span class=\"infoheader\"><h2>Direkomendasikan</h2></span></td></tr></table></div>";
              else
                  $msg    = "<div id=\"tablecontent\"><table width=\"100%\"><tr><td class=\"tablecontentgrid\" align=\"center\"><span class=\"infoheader\"><h2>Tidak Direkomendasikan</h2></span></td></tr></table></div>";        
              #print $_FormulaType[$id_formula].$rumus[$id_formula]."<br>"; 
              #$msg  .=  $finrumus[$id_finformula]."=".$hasil_finformula;                  
          }else{
              $msg = "";
          }
      }
    //print $hasil_finformula;
    if($app['STATUS']>2){
        if($hasil_finformula >= $min_skor){
        $price  = cek_priceByScoringId($app['ID_SCORING_TYPE'], $hasil_finformula);
        $msg    .= "<div id=\"tablecontent\"><table width=\"100%\"><tr><td class=\"tablecontentgrid\" align=\"center\"><span class=\"infoheader\"><h2>Price ".$price."</h2></span></td></tr></table></div>";        
        }else{
        $msg    .= "";
        }
    }else{
        $msg    .= "";
    }  
    foreach($criteria as $cparents=>$vparents){          
      foreach($vparents as $ckey=>$cvalue){
          $yatidak[$cparents][$ckey]  = array("value"=>$dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_CRITERIA"],"keterangan"=>$dataCriteria[$_REQUEST[xid]][$ckey]["BUS_ACCEPTANCE_KET"]);   
      }     
    }
    #print_r($yatidak);
    $msg  .=  "<div id=\"tablecontent\"><table width=\"100%\"><tr><td class=\"tablecontentgrid\" align=\"left\"><b>Catatan:</b></td></tr></table></div>";
    foreach($yatidak as $pkey=>$pvalue){       
        foreach($pvalue as $ckey=>$cvalue){
            if(trim($cvalue['value'])=="2")
            {
                #$msg  .= "<br>".$_CriteriaType[$ckey].$_YATIDAK[trim($cvalue)];
                $msg  .= "<div id=\"tablecontent\"><table width=\"100%\"><tr><td class=\"tablecontentgrid\" align=\"left\"><b>".$_CriteriaType[$ckey]."</b></td><td class=\"tablecontentgrid\" align=\"center\" width=\"200\"><b>".$cvalue['keterangan']."&nbsp;</b></td><td class=\"tablecontentgrid\" align=\"center\" width=\"200\"><b>Tidak Terpenuhi</b></td></tr></table></div>";
            }        
        }
    }
    $msg  .= "<div id=\"tablecontent\"><table width=\"100%\" cellspacing=\"0\" border=\"0\"><tr><td class=\"tablecontentgrid\" align=\"center\">Kepala Cabang<br><br><br><br><br>(.............................................)</td><td class=\"tablecontentgrid\" align=\"center\">Otorisator<br><br><br><br><br>(.............................................)</td><td class=\"tablecontentgrid\" align=\"center\">Verifikator<br><br><br><br><br>".$_USER[$app['ID_VERIFIKATOR']]."</td><td class=\"tablecontentgrid\" align=\"center\" width=\"300\">BBO/RBO<br><br><br><br><br>".$_USER[$app[APPLICATION_AONAME]]."</td></tr></table></div>";
    
    $form = "<br>";
    $form .= "
        <style>
        @media print {
            #action{display:none;}
        }        
        </style>
    ";
    $form .= "<form method=\"POST\" action=\"\">";
    $form .= "<table width=\"100%\"><tr><td><input type=\"submit\" id=\"action\" name=\"action\" value=\"PRINT\" size=\"50\" ><!--&nbsp;<input type=\"submit\" id=\"action\" name=\"action\" value=\"BACK\" size=\"50\" onclick=\"<script>history.back(-1)</script>\">--></td></tr></table>";      
    $form .= "</form>";   
    return Template_KotakPolos("Hasil Skoring",$msg.$form); 
 } 
 
  function update_finscore_ver($value,$id_app){
    $select       = " SELECT * FROM BUS_APPLICATION_VER WHERE ID_BUS_APPLICATION='$id_app'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$select);
    $data         = sqlsrv_fetch_array($query_select);
    if($data[APPLICATION_FINSCORE]=="" || $data[APPLICATION_FINSCORE]=="0"){
      $sql    = " UPDATE BUS_APPLICATION_VER SET APPLICATION_FINSCORE='$value' WHERE ID_BUS_APPLICATION='$id_app';";
      $sql    .= " UPDATE BUS_APPLICATION SET APPLICATION_FINSCORE='$value' WHERE ID_BUS_APPLICATION='$id_app';";
      $query  = sqlsrv_query($conn, $sql);
      return "ok";    
    }
    else{
      return "ko";
    }

 }
 
 function update_verifikatorId($app, $ver_id){
    $sql    = " UPDATE BUS_APPLICATION_VER SET ID_VERIFIKATOR='".$ver_id."' WHERE ID_BUS_APPLICATION='".$app."'";
    GLOBAL $connectionInfo, $SQLHost;
    $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
    $query = sqlsrv_query($conn,$sql);
    return $query;
 }             
       
?>