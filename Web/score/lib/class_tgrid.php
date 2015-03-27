<?
class tgrid
{
	function tgrid()
	{
		$this->content_action	= "";
		$this->content_row 		= 1;
		$this->content_col		= 0;
	}
	function set_form($method="post",$action="")
	{
		$this->form = "<form method=\"$method\" action=\"$action\">";
	}
	function set_hidden($name,$value)
	{
		$this->hidden .= "<input type=\"hidden\" name=\"$name\" value=\"$value\">\n";
	}
	function set_table($width="100%",$border="0",$cellspacing="1",$cellpadding="0")
	{
		$this->table  = "<table width=\"$width\" border=\"$border\" cellspacing=\"$cellspacing\" cellpadding=\"$cellpadding\">\n";
	}
	function set_header_align($data)
	{
		$this->header_align = $data;
	}	
	function set_header_width($data)
	{
		$this->header_width = $data;
	}
	function set_header_class($data)
	{
		$this->header_class = $data;
	}	
	function set_header($data)
	{
		$this->header .= "<tr>\n";
		$y = 1;
		for($x=0;$x<count($data);$x++)
		{
			if(strlen($data[$x]) < 1)
			{
				$y++;
			}
			else
			{
        		$this->header .= "<td";
        		if($this->header_class[$x])	$this->header .= " class=\"".$this->header_class[$x]."\"";
        		else							$this->header .= " class=\"tableheader\"";         		
        		if($y>1)					$this->header .= " colspan=\"$y\" ";
        		if($this->header_align[$x])	$this->header .= " align=\"".$this->header_align[$x]."\"";	
        		if($this->header_width[$x])	$this->header .= " width=\"".$this->header_width[$x]."\"";        		
        		$this->header .= " valign=\"middle\">$data[$x]</td>\n";
       		
        		$y = 1;
			}
		}
		$this->header_cols = count($data);
        $this->header .= "</tr>\n";
	}

	function set_footer_align($data)
	{
		$this->footer_align = $data;
	}	
	function set_footer_width($data)
	{
		$this->footer_width = $data;
	}
	
	function set_footer($data)
	{
		$this->footer .= "<tr>\n";
		$y = 1;
		for($x=0;$x<count($data);$x++)
		{
			if(strlen($data[$x]) < 1)
			{
				$y++;
			}
			else
			{
        		$this->footer .= "<td class=\"tableheader\"";
        		if($y>1)					$this->footer .= " colspan=\"$y\" ";
        		if($this->footer_align[$x])	$this->footer .= " align=\"".$this->footer_align[$x]."\"";	
        		if($this->footer_width[$x])	$this->footer .= " width=\"".$this->footer_width[$x]."\"";        		
        		$this->footer .= " valign=\"middle\">$data[$x]</td>\n";
        		$y = 1;
			}
		}
		$this->header_cols = count($data);
        $this->footer .= "</tr>\n";
	}	
	
	function set_content_align($data)
	{
		$this->content_align = $data;
	}
	
	function set_content_rowspan($data)
	{
		$this->content_rowspan = $data;
	}
  
	function set_content_width($data)
	{
		$this->content_width = $data;
	}  	
	
	function set_content_class($data)
	{
		$this->content_class = $data;
	}
	function set_content_form($method="post",$action="")
	{
		$this->set_content_form = "<form method=\"$method\" action=\"$action\">";
	}
	function set_content($data)
	{
		#if($this->content_row%2 == 0) 	$bgcolor = "";
		#else							
		//$bgcolor = "#DAD1FE";
		$bgcolor = "#FFF";
		if($this->set_content_form)	$this->content .= "$this->set_content_form";
		$this->content .= "<tr bgcolor=\"$bgcolor\" onMouseover=\"this.bgColor='#CCCCCC'\" onMouseout=\"this.bgColor='$bgcolor'\">\n";
		$y = 1;
		for($x=0;$x<count($data);$x++)
		{
			if(strlen($data[$x]) < 1)
			{
				$y++;
			}
			else
			{
        		$this->content .= "<td";
        		if($y>1)						$this->content .= " colspan=\"$y\"";
        		if($this->content_rowspan[$x])  $this->content .= " rowspan=\"".$this->content_rowspan[$x]."\"";
        		if($this->content_width[$x])  $this->content .= " width=\"".$this->content_width[$x]."\"";
        		if($this->content_align[$x])	$this->content .= " align=\"".$this->content_align[$x]."\"";
        		if($this->content_class[$x])	$this->content .= " class=\"".$this->content_class[$x]."\"";
        		else							$this->content .= " class=\"tablecontentgrid\"";
        		$this->content .= " valign=\"top\">$data[$x]</td>\n";
        		$y = 1;
			}
		}
		$this->content .= "</tr>\n";
        if($this->set_content_form)	$this->content .= "</form>";
        $this->content_row++;
        $this->content_col = count($data);
	}
	function set_content2($data)
	{
		if($this->content_row%2 == 0) 	$bgcolor = "#FFFFFF";
		else							$bgcolor = "";
		
		if($this->set_content_form)	$this->content .= "$this->set_content_form";
		$this->content .= "<tr bgcolor=\"$bgcolor\" onMouseover=\"this.bgColor='#CCCCCC'\" onMouseout=\"this.bgColor='$bgcolor'\">\n";
		$y = 1;
		for($x=0;$x<count($data);$x++)
		{
			if(strlen($data[$x]) < 1)
			{
				$y++;
			}
			else
			{
        		$this->content .= "<td";
        		if($y>1)						$this->content .= " colspan=\"$y\"";
        		if($this->content_align[$x])	$this->content .= " align=\"".$this->content_align[$x]."\"";
        		if($this->content_class[$x])	$this->content .= " class=\"".$this->content_class[$x]."\"";
        		else							$this->content .= " class=\"tablecontentgrid2\"";
        		$this->content .= " valign=\"top\"><i>$data[$x]</i></td>\n";
        		$y = 1;
			}
		}
		$this->content .= "</tr>\n";
        if($this->set_content_form)	$this->content .= "</form>";
        $this->content_col = count($data);
	}
	
	function set_action_header($name)
	{
		$this->content_action_header = "<td align=\"right\"  class=\"tableheaderaction\">$name</td>";
	}
	function set_action_link($name,$link,$width)
	{
		if($this->content_action != "")	$this->content_action .= "<td width=\"5\" align=\"center\" class=\"tableheaderaction\">|</td>";
		$this->content_action .= "<td width=\"$width\" align=\"right\" class=\"tableheaderaction\"><a href=\"$link\" onmouseover=\"Tip('<strong>$name</strong>')\" onmouseout=\"UnTip()\">$name</a></td>\n";
	}
		
	function set_submit($name,$value)
	{
		$this->submit	.= "<tr>\n";
		$this->submit	.= "<td colspan=\"".$this->content_col."\" align=\"left\">\n";
		$this->submit	.= "<input type=\"submit\" name=\"$name\" value=\"$value\">\n";
		$this->submit	.= "</td>\n";
		$this->submit	.= "</tr>\n";
	}
	function set_nav($total_record,$curr_page,$total_row_per_page="0")
	{
		global $_MAX_REC_PER_PAGE;
		if($total_row_per_page > 0) $_MAX_REC_PER_PAGE = $total_row_per_page;
		if($curr_page <1)	$curr_page = 1;
		$tota_page = ceil($total_record/$_MAX_REC_PER_PAGE);
		if($total_record < 1)	$total_record = 0;
		
		$mini_page = 1;
		$prev_page = $curr_page - 1;
		$next_page = $curr_page + 1;
		$maxi_page = $tota_page;
		
		if($prev_page <= $mini_page)	$prev_page = $mini_page;
		if($next_page >= $maxi_page)	$next_page = $maxi_page;
		
		parse_str($_SERVER['QUERY_STRING'],$qoutput);
		
		

		$this->nav  = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		#if($total_record > $_MAX_REC_PER_PAGE)	$this->nav .= "<form method=\"GET\" action=\"?".$_SERVER['QUERY_STRING']."\">\n";
		if($total_record > $_MAX_REC_PER_PAGE)	$this->nav .= "<form method=\"GET\">\n";		
		$clean_query_string = "";
		foreach($qoutput as $key=>$val)
		{
			$this->nav .= "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";	
			if($key != "page")
			{
				$clean_query_string .= "$key=$val&";
			}
		}
		$this->nav .= "<tr>\n";
		$this->nav .= "<td class=\"tableheader\" width=\"250\">Found ".number_format($total_record,0)." record(s)</td>\n";
		if($total_record > $_MAX_REC_PER_PAGE)
		{
			$this->nav .= "<td class=\"tableheader\" align=\"center\">\n";
			$this->nav .= "<a href=\"?".$clean_query_string."page=$mini_page\"><<</a>\n";
			$this->nav .= "&nbsp;&nbsp;&nbsp;&nbsp;\n";
			$this->nav .= "<a href=\"?".$clean_query_string."page=$prev_page\"><</a>\n";
			$this->nav .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".number_format($curr_page,0)." of ".number_format($tota_page,0)."&nbsp;&nbsp;&nbsp;&nbsp;\n";
			$this->nav .= "<a href=\"?".$clean_query_string."page=$next_page\">></a>\n";
			$this->nav .= "&nbsp;&nbsp;&nbsp;&nbsp;\n";
			$this->nav .= "<a href=\"?".$clean_query_string."page=$maxi_page\">>></a>\n";
			$this->nav .= "</td>\n";

			$this->nav .= "<td class=\"tableheader\" width=\"250\" align=\"right\">\n";
			$this->nav .= "<select name=\"page\">\n";
			for($x=1;$x<=$maxi_page;$x++)
			{
				if($_GET[page] == $x)	$this->nav .= "<option value=\"$x\" selected>$x</option>\n";
				else					$this->nav .= "<option value=\"$x\">$x</option>\n";
			}
			$this->nav .= "</select>\n";
			$this->nav .= "<input type=\"submit\" value=\"Jump to Page\">\n";
			$this->nav .= "</td>\n";
		}
		$this->nav .= "</tr>\n";
		if($total_record > $_MAX_REC_PER_PAGE)	$this->nav .= "</form>\n";
		$this->nav .= "</table>\n";
	}
	function build($lebar="100%")
	{
		$this->out  = "";
		if($this->content_action != "")
		{
			$this->out	.= "<table width=\"$lebar\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"tableaction\">\n";	
			$this->out	.= "<tr>\n";
			$this->out	.= $this->content_action_header;
			$this->out	.= $this->content_action;
			$this->out	.= "</tr>\n";
			$this->out	.= "</table>\n";
		}
		$this->out  .= "<table width=\"$lebar\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        $this->out .= "<tr><td class=\"\">\n";
			$this->out .= $this->table;
			if($this->form)		$this->out .= "$this->form";
			if($this->hidden)	$this->out .= "$this->hidden";
	        $this->out .= $this->header;
	        $this->out .= $this->content;
	        $this->out .= $this->footer;
	        if($this->submit && $this->content)	$this->out .= $this->submit;
	        if($this->form)		$this->out .= "</form>";
	        $this->out .= "</table>\n";
	        $this->out .= $this->nav;        
        $this->out .= "</td></tr>\n";
        $this->out .= "</table>\n";
		return $this->out;
		
		
	}
	function build_write()
	{
		$this->out  = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        $this->out .= "<tr><td class=\"tableborder\">\n";
			$this->out .= $this->table;
			if($this->form)		$this->out .= "$this->form";
			if($this->hidden)	$this->out .= "$this->hidden";
	        $this->out .= $this->header;
	        $this->out .= $this->content;
	        if($this->submit && $this->content)	$this->out .= $this->submit;
	        if($this->form)		$this->out .= "</form>";
	        $this->out .= "</table>\n";
	        $this->out .= $this->nav;        
        $this->out .= "</td></tr>\n";
        $this->out .= "</table>\n";
		return $this->out;
	}
}
?>