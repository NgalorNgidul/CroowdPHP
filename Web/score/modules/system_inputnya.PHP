<script>
function func_unit()
{
  if(document.formID.frm_USERUNIT.value == "1")
  {
    document.getElementById("tr_DIVISION_ID").style.display = "";
    document.getElementById("tr_BRANCH_ID").style.display = "none";
  }
  else if(document.formID.frm_USERUNIT.value == "2")
  {
    document.getElementById("tr_DIVISION_ID").style.display = "none";
    document.getElementById("tr_BRANCH_ID").style.display = "";
  }
}

</script>

<?

Function Input_Loginnya(){
GLOBAL $HURUF;
$nmInput = Array();
$nmInput[0] = "frm_USER_ID";
$nmInput[1] = "frm_PASSWORD";
$nmInput[2] = "frm_USERUNIT";
$nmInput[3] = "frm_EMAIL";

$datanya .= BuatJavaScript_CekInputan($nmInput);

$datanya .= "<body onload='document.FORM_INPUT.frm_USER_ID.focus()' >";

$datanya .= "<form method='POST' action='index.php' name='FORM_INPUT'>
    <table style='border: 1px' border=0>

    <tr>
    <td bgcolor='white'><b>USER ID</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_USER_ID' size='15' maxlength='20' $HURUF></td></tr>

    <tr>
    <td bgcolor='white'><b>PASSWORD</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='password' name='frm_PASSWORD' size='15' maxlength='20' $HURUF></td>
    </tr>
    
    <tr><td colspan=3 align='center'>&nbsp;</td></tr>

    <tr>
    <td align=center colspan=3>
    <input type='image' border='0' name='imageFielda' src='includes/page_main/img/button_login.gif' alt='Login'>
    <input type='hidden' value='login_cek' name='cmd'>
    </td>
    </tr></table></form>";

RETURN $datanya;
}
//------------------------------------------------------------------------------
Function Ganti_Password($cmd){
GLOBAL $HURUF, $COOK_USER_ID;

$sqlnya = "SELECT * FROM [SYSTEM_USER] WHERE ID_USER='".$COOK_USER_ID."'";
$frm_USER_ID = TRIM(Hasilsqlnya($sqlnya,"USERNAME"));
$frm_USER_NAME = TRIM(Hasilsqlnya($sqlnya,"NAME"));

$datanya .= "
    <form id='formID' name='formID' method='GET' action='index.php'>
    <table style='border: 1px' border=0>";

$datanya .= "
    <tr>
    <td><b>NAMA USER</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_USER_NAME' size='30' maxlength='50' value='".$frm_USER_NAME."' disabled class='validate[required]'></td></tr>

    <tr>
    <td><b>USER ID</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='text' name='frm_USER_ID' size='30' maxlength='20' value='".$frm_USER_ID."' disabled class='validate[required]'></td></tr>

    <tr>
    <td><b>PASSWORD BARU</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='password' id='frm_PASSWORD1' name='frm_PASSWORD1' size='30' maxlength='20' class='validate[required]'></td>
    </tr>

    <tr>
    <td><b>PASSWORD BARU (ULANGI)</td>
    <td><b>&nbsp;:&nbsp;</b></td>
    <td><input type='password' name='frm_PASSWORD2' size='30' maxlength='20' class='validate[required,funcCall[checkPass]]'></td>
    </tr>

    <tr><td colspan=3 align='center'>&nbsp;</td></tr>

    <tr>
    <td align=center colspan=3>
    <input type='submit' class='submit' value='    SAVE    ' />
    <input type='hidden' value='".$cmd."_save' name='cmd'>
    <input type='hidden' value='".$frm_USER_ID."' name='frm_username'>
    </td></tr></table></form>";
RETURN Template_KotakPolos(":: GANTI PASSWORD",$datanya);
}
//------------------------------------------------------------------------------

?>
