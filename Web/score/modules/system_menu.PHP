<?

//------------------------------------------------------------------------------
Function Sediakan_MenuNya($cmd){
GLOBAL $COOK_USER_GROUP_ID, $KET_MENU, $BUTTON_KIRI, $BUTTON_KANAN ;

$Page = "	<link rel=\"StyleSheet\" href=\"includes/page_tree/dtree.css\" type=\"text/css\" />
	<script type=\"text/javascript\" src=\"includes/page_tree/dtree.js\"></script>

  <div class='dtree'>
  <script type='text/javascript'>
  <!-- 
  d = new dTree('d');";

$temp = Menu_Utama($cmd);
$Page .= $temp[1][0];

  IF($COOK_USER_GROUP_ID!=""){

    $sqlnya1 = "SELECT * FROM SYSTEM_MENU_USER_GROUP A
                INNER JOIN SYSTEM_MENU B
                ON A.MENU_ID=B.MENU_ID
                WHERE A.USER_GROUP_ID='".$COOK_USER_GROUP_ID."' AND B.STATUS=1 
                ORDER BY B.TYPE, B.SORT_NO  ASC ";
    $Val = Query_Data($sqlnya1);
    print_r($Val); exit();
    $i=$temp[1][1];
    FOREACH($Val AS $DATAVAL){
        $sqlnya = "SELECT * FROM SYSTEM_MENU WHERE MENU_ID='".$DATAVAL->MENU_ID."' ORDER BY TYPE, SORT_NO ASC ";
        $HslTemp = Query_Data($sqlnya);
  
        $link = "index.php?cmd=".$HslTemp[0]->MENU_COMMAND ;
        $ket = $HslTemp[0]->MENU_NAME;
  
        IF($KET_MENU[$DATAVAL->TYPE]!=$stat_Temp1){
          $Page .= "d.add(".($i+1).",0,'".$KET_MENU[$DATAVAL->TYPE]."',''); ";
          $i++;
          $temp_tree = $i;
        }
        $Page .= "d.add(".($i+1).",".$temp_tree.",'".$ket."','".$link."');";
  
        $stat_Temp1 = $KET_MENU[$DATAVAL->TYPE];
        $i++;
    }
  }

$Page .= "document.write(d);
 //-->
</script></div>";

  $MENU = "<table border=0>";
  $MENU .= "<tr><td>".$BUTTON_KIRI."&nbsp;&nbsp;&nbsp;&nbsp;".$BUTTON_KANAN."</td></tr>";
  $MENU .= "<tr><td><hr></td></tr>";  
  $MENU .= "<tr><td>".$Page."</td></tr>";
  $MENU .= "<tr><td height='100%'>&nbsp;</td></tr>";
  
  
  
  $MENU .= "</table>";

  $JUDUL = ":: TASK TO DO";
  $ISI = $MENU;
RETURN Template_KotakPolos($JUDUL,$ISI);
//RETURN $ISI ;
}
//------------------------------------------------------------------------------
Function Menu_Utama($cmd){
GLOBAL $COOK_USER_GROUP_ID, $KET_MENU;
$Page=Array();

  $Page[1][0] .= "d.add(0,-1,'MAIN MENU');";
  $Page[1][0] .= "d.add(1,0,'".$KET_MENU[0]."',''); ";

  $link = "index.php";
  $Page[1][0] .= "d.add(2,1,'HOME','".$link."'); ";
  $link = "index.php?cmd=CMD_INFO";
  $Page[1][0] .= "d.add(3,1,'INFO','".$link."'); ";
  $link = "index.php?cmd=CMD_CHG_PASS";
  $Page[1][0] .= "d.add(4,1,'GANTI PASSWORD','".$link."'); ";

  $link = "index.php?cmd=CMD_LOGOUT";
  $Page[1][0] .= "d.add(5,1,'LOGOUT','".$link."'); ";
  $Page[1][1] = 6;

RETURN $Page;
}
//------------------------------------------------------------------------------

?>
