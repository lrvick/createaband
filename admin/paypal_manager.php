<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
$err_mess=form_get("err_mess");
if($act=='')	paypal_manage();
elseif($act=='save')	save();

function paypal_manage()	{
	global $main_url,$base_path;
	$adsess=form_get("adsess");
	$mode=form_get("mode");
	admin_test($adsess);
	show_ad_header($adsess);
	$sql_query="select * from admin";
	$mail=sql_execute($sql_query,'get');
?>
<form action="admin.php" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined padded-6">
    <tr> 
      <td class='lined title'>Admin: Paypal E-mail Manager</td>
    </tr>
    <tr>
      <td align="center" valign="middle">&nbsp;</td>
    </tr>
    <tr> 
      <td align="center">&nbsp;
        <input name="mode" type="hidden" id="mode" value="paypal_manager"> <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>"> 
        <input name="act" type="hidden" id="act" value="save"></td>
    </tr>
    <tr> 
      <td align="center"><input name="paypal" type="text" value="<?=$mail->paypal_mail?>" size="30"></td>
    </tr>
    <tr> 
      <td align="center">&nbsp;</td>
    </tr>
    <tr align="right"> 
      <td><input name="Submit" type="submit" id="Submit" value="Save Mail ID"></td>
    </tr>
  </table>
</form>
<?php
	show_footer();
}
function save()	{
	global $main_url,$base_path;
	$adsess=form_get("adsess");
	$mode=form_get("mode");
	admin_test($adsess);
	$paypal=form_get("paypal");
	mysql_query("update admin set paypal_mail='$paypal'");
	paypal_manage();
}
?>