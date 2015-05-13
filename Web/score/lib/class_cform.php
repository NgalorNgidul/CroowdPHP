<?
class cform
{
	function cform()
    {
    }

	function start($name,$method,$ext)
	{
		#echo $name.$method;
		#exit;
		#
		# example 
		# input ---------------------
		#	$cform->start($name="name",$method="method",array(	"action"		=> "controller.php",
		#														"target" 		=> "_self",
		#														"enctype" 		=> "multipart/form-data"));
		#
		# output --------------------
		# <form		id=\"rates\"
		#			name=\"rates\"
		#			method=\"method\"
		#			action=\"controller.php\"
		#			target=\"_self\"
		#			enctype=\"multipart/form-data\"> 
		#
			
		$_name		= "";
		$_method	= "POST";
		$_ext		= "";
		
		if($name != "")		$_name		= "id=\"$name\" name=\"$name\"";
		if($method)	
			$_method	= "method=\"$method\"";
		else
			$_method	= "method=\"POST\"";
			
		if(count($ext) > 0 && $ext != "")
		{
			foreach($ext as $key=>$value)
			{
				$_ext	.= "$key=\"$value\" ";
			}
		}
		$this->start = "<form $_name $_method $_target $_ext>\n";
	}
	
	# TAMBAHAN DR RONALD
	function set_header_list($data)
	{
		$this->set_header_list[col]		= count($data)-1;
		$this->set_header_list[data]	= $data;
	}

	function set_content_list($data)
	{
		$this->set_content_list[col]	= count($data)-1;
		$this->set_content_list[data]	= $data;
	}

	function fhidden($name,$value)
	{
		#
		# example 
		# input ---------------------
		#	$cform->fhidden($name="rates",$value=number_format($DATA[rates],2));
		#
		# output --------------------
		# <input 	type=\"hidden\" 
		#			id=\"rates\"
		#			name=\"rates\"
		#			value=\"".number_format($DATA[rates],2)."\">
		#
		
		$_name	= "";
		$_value	= "";
		
		if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
		if($value != "") 	$_value	= "value=\"$value\"";
		
		$this->fhidden .= "<input type=\"hidden\" $_name $_value>\n";	
	}
	
	function set_row($row_id,$ext)
	{
		$_ext		= "";
		if(count($ext) > 0 && $ext != "")
		{
			foreach($ext as $key=>$value)
			{
				$_ext	.= "$key=\"$value\" ";
			}
		}
	
		$this->set_row[$row_id] = "$_ext";
	}
	
	function set_hiddenrow($row_id,$ext)
	{
		$_ext				= "";
		if(count($ext) > 0 && $ext != "")
		{
			foreach($ext as $key=>$value)
			{
				$_ext	.= "$key=\"$value\" ";
			}
		}	
		$this->set_hiddenrow[$row_id] = "<div $_ext>&nbsp;</div>\n";
	}
	
	function set_col_header($row_id,$text,$ext)
	{
		$_ext		= "";
		if(count($ext) > 0 && $ext != "")
		{
			foreach($ext as $key=>$value)
			{
				$_ext	.= "$key=\"$value\" ";
			}
		}
		$this->set_col_header[$row_id][data] = $text;
		$this->set_col_header[$row_id][prop] = $_ext;
	}
	
	function set_col_content($row_id,$data,$ext)
	{
		$_ext		= "";
		if(count($ext) > 0 && $ext != "")
		{
			foreach($ext as $key=>$value)
			{
				$_ext	.= "$key=\"$value\" ";
			}
		}
		$this->set_col_content[$row_id][data] = $data;
		$this->set_col_content[$row_id][prop] = $_ext;	
	}
	
	function finish()
	{
		print "<TABLE  width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		print $this->start;
		print $this->fhidden;
		print "<TBODY>";
		for($x=1;$x<=count($this->set_row);$x++)
		{
			print "<TR ".$this->set_row[$x]." id='tr_$x'>\n";
			print "\t<TD ".$this->set_col_header[$x][prop]." id='td1_$x'>".$this->set_col_header[$x][data]."</TD>\n";
			print "\t<TD ".$this->set_col_content[$x][prop]." id='td2_$x'>".$this->set_col_content[$x][data]."</TD>\n";
			print "</TR>\n";
			if($this->set_hiddenrow[$x] != "")	print $this->set_hiddenrow[$x];
		}
		print "</TBODY>";
		print "</form>";
		print "</TABLE >\n";
	}
	
	function finishnew()
	{
	  $table  ="";
		$table  .= "<TABLE  width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$table  .= $this->start;
		$table  .= $this->fhidden;
		$table  .= "<TBODY>";
		for($x=1;$x<=count($this->set_row);$x++)
		{
			$table  .= "<TR ".$this->set_row[$x]." id='tr_$x'>\n";
			$table  .= "\t<TD ".$this->set_col_header[$x][prop]." id='td1_$x'>".$this->set_col_header[$x][data]."</TD>\n";
			$table  .= "\t<TD ".$this->set_col_content[$x][prop]." id='td2_$x'>".$this->set_col_content[$x][data]."</TD>\n";
			$table  .= "</TR>\n";
			if($this->set_hiddenrow[$x] != "")	print $this->set_hiddenrow[$x];
		}
		$table  .= "</TBODY>";
		$table  .= "</form>";
		$table  .= "</TABLE >\n";
		
		return $table;
	}	

	function finish2()
	{
		print "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		print $this->start;
		print $this->fhidden;
		for($x=1;$x<=count($this->set_row);$x++)
		{
			print "<tr ".$this->set_row[$x].">\n";
			print "\t<td ".$this->set_col_header[$x][prop].">".$this->set_col_header[$x][data]."</td>\n";
			print "\t<td ".$this->set_col_content[$x][prop].">".$this->set_col_content[$x][data]."</td>\n";
			print "</tr>\n";
		#	if($this->set_hiddenrow[$x] != "")	print $this->set_hiddenrow[$x];
		}
		print "</table>\n";
	}

	function finishList()
	{
		print "<center>";
		print "<table id=\"dataTable\" width=\"100%\" bordercolor=\"#999999\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n";
		//print $this->start;
		//print $this->fhidden;
		print "<tr  bgcolor=\"#CCFFFF\">\n";
		for($i=0;$i<=$this->set_header_list[col];$i++)
		{
			print "\t<td><strong>".$this->set_header_list[data][$i]."</strong></td>\n";
		}
		print "</tr>\n";
		
		//for($i=0;$i<=$this->set_header_list[col];$i++)
		//{
		print "<tr>\n";
		for($x=0;$x<=$this->set_content_list[col];$x++)
		{
			print "\t<td>".$this->set_content_list[data][$x]."</td>\n";
		}
		print "</tr>\n";
		//}
			//if($this->set_hiddenrow[$x] != "")	print $this->set_hiddenrow[$x];
		
		print "</table>\n";
		print "</center>";

	}
}
######################################################################
#collection of function
function inputPassword($name,$value,$ext)
{		
	$_name	= "";
	$_value	= "";
	$_ext	= "";
	$readonly	= "";
	
	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if($value != "") 	$_value	= "value=\"$value\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")				$_ext		.= "$key=\"$value\" ";
		}
	}
	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly $key";
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out	.= "<input type=\"password\" $_name $_value $_ext $readonly>";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}
function inputText($name,$value,$ext)
{		
	$_name		= "";
	$_value		= "";
	$_ext		= "";
	$readonly	= "";

	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if($value != "") 	$_value	= "value=\"$value\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")				$_ext		.= "$key=\"$value\" ";
			#echo $key."---".$value;
		}
	}
#	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly $key";
	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly";
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out	.= "<input type=\"text\" $_name $_value $_ext $readonly>";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}
function inputHidden($name,$value,$ext)
{		
	$_name		= "";
	$_value		= "";
	$_ext		= "";
	$readonly	= "";

	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if($value != "") 	$_value	= "value=\"$value\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")				$_ext		.= "$key=\"$value\" ";
		}
	}
	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly";
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out	.= "<input type=\"hidden\" $_name $_value $_ext $readonly>";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}
function inputSubmit($name,$value,$ext)
{
	$_name	= "";
	$_value	= "";
	$_ext	= "";

	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if($value != "") 	$_value	= "value=\"$value\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix")				$_ext	.= "$key=\"$value\" ";
		}
	}
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out	.= "<input type=\"submit\" $_name $_value $_ext>";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}
function inputButton($name,$value,$ext,$types="button")
{
	$_name	= "";
	$_value	= "";
	$_ext	= "";
#	$_types	= "button";

	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if($value != "") 	$_value	= "value=\"$value\"";
#	if($_types != "") 	$_value	= "value=\"$value\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix")				$_ext	.= "$key=\"$value\" ";
		}
	}
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out	.= "<input type=\"$types\" $_name $_value $_ext>";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}

function inputTextArea($name,$value,$ext)
{
	$_name		= "";
	$_ext		= "";
	$readonly	= "";
	
	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$values)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")				$_ext		.= "$key=\"$values\" ";
		}
	}
	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly $key";
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out 	.= "<textarea $_name $_ext $readonly>$value</textarea>";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}
function inputRadio($name,$data,$value,$ext)
{
#	echo "AAAAAAAAAAAAA".print_r($data);
	$_name	= "";
	$_value	= "";
	$_ext	= "";
	$_id	= "";

	if($name != "") 	$_name	= "name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$values)
		{
			if($key != "prefix" && $key != "suffix")				$_ext	.= "$key=\"$values\" ";
		}
	}
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	foreach($data as $key2 => $values2)
	{
	#	$_id 		= "id=\"".$name."_".$key2."\"";
		$_id 		= "id=\"".$name."\"";
		$_value		= "value=\"$key2\"";
		if($value == "$key2")	$out 	.= "<input type=\"radio\" $_name $_id $_value $_ext checked> $values2 &nbsp;&nbsp;";
		else					$out 	.= "<input type=\"radio\" $_name $_id $_value $_ext> $values2 &nbsp;&nbsp;";
	}
	return $out;
}

function inputRadioTable($name,$data,$value,$ext)
{
	$_name	= "";
	$_value	= "";
	$_ext	= "";
	$_id	= "";

	if($name != "") 	$_name	= "name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$values)
		{
			if($key != "prefix" && $key != "suffix")				$_ext	.= "$key=\"$values\" ";
		}
	}
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out	 = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	$out	.= "<tr>\n";
	foreach($data as $key2 => $values2)
	{
		$_id 		= "id=\"$name_$x\"";
		$_value		= "value=\"$key2\"";
		if($value == "$key2")	$out 	.= "<td width=\"100\" class=\"tablecontent\" ><input type=\"radio\" $_name $_id $_value $_ext checked>$values2</td>";
		else					$out 	.= "<td width=\"100\" class=\"tablecontent\" ><input type=\"radio\" $_name $_id $_value $_ext>$values2</td>";
	}
	$out	.= "</tr>\n";
	$out	.= "</table>\n";
	return $out;
}

function inputSelect($name,$data,$value,$ext)
{
	$_name		= "";
	$_ext		= "";
	$readonly	= "";	

	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$values)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")				$_ext		.= "$key=\"$values\" ";
		}
	}
	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly $key";
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out .= "<select $_name $_ext $readonly>\n";
#	print_r($data);
	foreach($data as $a=>$b)
	{
		if($ext[show_key] == "1")	$b 	  = "$a - $b";
		if($value == $a)			$out .= "<option value=\"$a\" selected>$b</option>\n";
		else						$out .= "<option value=\"$a\">$b</option>\n";
	}
	$out .= "</select>\n";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}

function inputSelectRange($name,$sdata,$edata,$default,$ext)
{
	$_name		= "";
	$_ext		= "";	
	$readonly	= "";
	
	if($name != "") 	$_name	= "id=\"$name\" name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")				$_ext		.= "$key=\"$value\" ";
		}
	}
	if($ext[readonly] == "yes")	$readonly 	 = "class=\"readonly\" readonly $key";
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$out .= "<select $_name $_ext $readonly>\n";
	if($sdata > $edata)
	{
		for($x=$sdata;$x<=$edata;$x--)
		{
			if($x < 10)	$y = "0".$x;
			else		$y = $x;
			
			if($default == $x)			$out .= "<option value=\"$y\" selected>$y</option>\n";
			else						$out .= "<option value=\"$y\">$y</option>\n";
		}
	}
	else
	{
		for($x=$sdata;$x<=$edata;$x++)
		{
			if($x < 10)	$y = "0".$x;
			else		$y = $x;
			
			if($default == $x)			$out .= "<option value=\"$x\" selected>$y</option>\n";
			else						$out .= "<option value=\"$x\">$y</option>\n";
		}	
	}
	$out .= "</select>\n";
	if($ext[suffix] != "")	$out .= "$ext[suffix]";
	return $out;
}
								
function inputDate($datename,$required,$dateformat="DD-MON-YYYY",$defaultvalue) #DateName, Required*, DateFormat*, DefaultDate*
{	
	$elment  = "";
	if($datename)		$elment  = "'$datename'";
	if($required)		$elment .= ",'$required'";
	if($dateformat)		$elment .= ",'$dateformat'";
	if($defaultvalue)	$elment .= ",'$defaultvalue'";
	$out 		= "<script>DateInput($elment);</script>";
	return $out;
}

function inputFile($name,$ext)
{		
	$_name			= "";
	$_value			= "";
	$_ext			= "";
	$readonly		= "";
	$_default_ext	= array("size"=>"20");
	$ext			= array_merge($_default_ext, $ext);

	if($name != "") 	$_ext	.= "id=\"$name\" name=\"$name\" ";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$value)
		{
			if($key != "prefix" && $key != "suffix" && $key != "readonly")	$_ext		.= "$key=\"$value\" ";
		}
	}
	if($ext[readonly] == "yes")	$_ext 	 	.= "class=\"readonly\" readonly";
	
	if($ext[prefix] != "")		$out 		 = "$ext[prefix]";
	$out	.= "<input type=\"file\" $_ext>";
	if($ext[suffix] != "")		$out 		.= "$ext[suffix]";
	return $out;
}
# SINGLE 
function inputCheckBox($name,$value,$data,$ext)
{
	$_name	= "";
	$_value	= "";
	$_ext	= "";
	$_id	= "";

	if($name != "") 	$_name	= "name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$values)
		{
			if($key != "prefix" && $key != "suffix")				$_ext	.= "$key=\"$values\" ";
		}
	}
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$_id 		= "id=\"$name\"";
	$_value		= "value=\"$value\"";
	if($value == $data)		$out 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext checked> $values2 &nbsp;";
	else					$out 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext> $values2 &nbsp;";
#	foreach($data as $key2 => $values2)
#	{
#		$_id 		= "id=\"$name_$x\"";
#		$_value		= "value=\"$key2\"";
#		if($value == "$key2")	$out 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext checked title=\"$values2\"> $values2 &nbsp;";
#		else					$out 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext title=\"$values2\"> $values2 &nbsp;";
#	}
	if($ext[suffix] != "")		$out 		.= "$ext[suffix]";
	return $out;
}
# PAKAI DATA ARRAY
function inputCheckBoxData($name,$data,$value,$ext)
{
	$_name	= "";
	$_value	= "";
	$_ext	= "";
	$_id	= "";

#	if($name != "") 	$_name	= "name=\"$name\"";
	if(count($ext) > 0 && $ext != "")
	{
		foreach($ext as $key=>$values)
		{
			if($key != "prefix" && $key != "suffix")				$_ext	.= "$key=\"$values\" ";
		}
	}
	if($ext[prefix] != "")	$out = "$ext[prefix]";
	$tmp = "";
	$out = "";
	$x = 1;
	$out .= "<table border=0 cellpadding=0 cellspacing=0>";
	foreach($data as $key2 => $values2)
	{
		$_name 		= "name=\"".$name."_$x\"";
		$_id 		= "id=\"".$name."_$x\"";
		$_value		= "value=\"$key2\"";
#echo ($x%3);
#echo ($x%3)."<br>";
		if($x%3 == 1)
		{
			$tmp .=  "<tr>";
			$tmp .=  "<td class=\"tablecontent\" nowrap>";
			if(in_array($key2,$value))	$tmp 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext checked title=\"$values2\"> $values2 &nbsp;";
			else						$tmp 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext title=\"$values2\"> $values2 &nbsp;";
			$tmp .=  "</td>";
		}
	#	if($x%3 == 2)
		else
		{
			$tmp3 .= $tmp;
			$tmp3 .=  "<td class=\"tablecontent\" nowrap>";
			if(in_array($key2,$value))	$tmp3 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext checked title=\"$values2\"> $values2 &nbsp;";
			else						$tmp3 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext title=\"$values2\"> $values2 &nbsp;";
			$tmp3 .=  "</td>";
			$tmp = "";
		}
		if($x%3 == 0)
		{
			$tmp2 .= $tmp3;
			$tmp2 .=  "<td class=\"tablecontent\" nowrap>";
			if(in_array($key2,$value))	$tmp2 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext checked title=\"$values2\"> $values2 &nbsp;";
			else						$tmp2 	.= "<input type=\"checkbox\" $_name $_id $_value $_ext title=\"$values2\"> $values2 &nbsp;";
			$tmp2 .=  "</td>";
			$tmp2 .=  "</tr>";
		}
		$x++;
	}
#	$out .= $tmp2;
	$out .= $tmp3;
	$out .= $tmp;
	$out .=  "</table>";
	return $out;
}

/*
######################################################################
$cf = new cform();
$cf->start($name="name",$method="method",array(	"action"		=> "controller.php",
												"target" 		=> "_self",
												"enctype" 		=> "multipart/form-data"));
$cf->fhidden($name="rates",$value="val");

$cf->set_row($row_id="1",$ext=array(	"class" 		=> "tr_row",
                                        "onmouseover"	=> "change_color",
                                        "onmouseout"	=> "change_color"));
    $data	 = inputText($name="rates",$value=number_format(100000,0),$ext=array(	"size"			=> "12",
																					"class" 		=> "css",
																					"prefix"		=> "USD ",
																					"suffix"		=> " ,-&nbsp;&nbsp;&nbsp;"));																			                                        
    $cf->set_col_header($row_id="1",$text="Uang 1",$ext=array(	"width"	=> "150",
                                                                "class"	=> "content_header"));                                                                                    
    $cf->set_col_content($row_id="1",$data,$ext=array(	"width"	=> "500",
                                                        "class" => "content_content"));
                                                            
$cf->set_row($row_id="2",$ext=array(	"class" 		=> "tr_row",
                                        "onmouseover"	=> "change_color",
                                        "onmouseout"	=> "change_color"));
    $data	= inputText($name="rates",$value=number_format(100000,0),$ext=array(	"size"			=> "12",
																					"class" 		=> "css",
																					"prefix"		=> "USD ",
																					"suffix"		=> " ,-&nbsp;&nbsp;&nbsp;")); 
    $cf->set_col_header($row_id="2",$text="Uang 2",$ext=array(	"width"	=> "150",
                                                                "class"	=> "content_header"));                                                                                    
    $cf->set_col_content($row_id="2",$data,$ext=array(		"width"	=> "500",
                                                        	"class" => "content_content"));
															
$cf->set_row($row_id="3",$ext=array(	"class" 		=> "tr_row",
                                        "onmouseover"	=> "change_color",
                                        "onmouseout"	=> "change_color"));
	$data	 = inputRadio($name="radio",$value=array("Yes","No"),$ext=array("prefix" => "Radio"));  
    $cf->set_col_header($row_id="3",$text="Uang 3",$ext=array(	"width"	=> "150",
                                                                "class"	=> "content_header"));                                                                                    
    $cf->set_col_content($row_id="3",$data,$ext=array(		"width"	=> "500",
                                                        	"class" => "content_content"));
$cf->set_row($row_id="4",$ext=array(	"class" 		=> "tr_row",
                                        "onmouseover"	=> "change_color",
                                        "onmouseout"	=> "change_color"));
	$select = array("JKT" => "JAKARTA",
					"SBY" => "SURABAYA");
	$data  	= inputSelect($name="select",$select,$default,$ext=array("prefix" => ""));                                     
    $cf->set_col_header($row_id="4",$text="Uang 4",$ext=array(	"width"	=> "150",
                                                                "class"	=> "content_header"));                                                                                    
    $cf->set_col_content($row_id="4",$data,$ext=array(		"width"	=> "500",
                                                        	"class" => "content_content"));

$cf->set_row($row_id="5",$ext=array(	"class" 		=> "tr_row",
                                        "onmouseover"	=> "change_color",
                                        "onmouseout"	=> "change_color"));
	$data  	= inputTextArea($name="textarea",$value="text",$ext=array(	"suffix" 	=> "test",
																		"cols"		=> "39",
																		"rows"		=> "9"));
    $cf->set_col_header($row_id="5",$text="Uang 4",$ext=array(	"width"	=> "150",
                                                                "class"	=> "content_header",
																"valign" => "top"));                                                                                    
    $cf->set_col_content($row_id="5",$data,$ext=array(		"width"		=> "500",
                                                        	"class" 	=> "content_content",
															"valign" 	=> "top"));														
$cf->finish();         
*/                               
?>
