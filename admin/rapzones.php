<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
$err_mess=form_get("err_mess");
if($act=='')	rapzone_manage();
elseif($act=='save')	save();
elseif($act=='del')	del();

function rapzone_manage()	{
	global $main_url,$base_path;
	$adsess=form_get("adsess");
	$mode=form_get("mode");
	admin_test($adsess);
	$sql_query="select * from rapzones";
	$res=sql_execute($sql_query,'res');
	show_ad_header($adsess);
?>
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined padded-6">
  <tr> 
    <td colspan="2" class='lined title'>Admin: Rapzone Manager</td>
  </tr>
  <tr> 
 <form name="rap" action="admin.php" method="post">
 	<input type="hidden" name="mode" value="rapzones">
 	<input type="hidden" name="act" value="del">
	<input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>">
    <td width="48%" align="right" valign="top" class="body">Existing Rapzones &nbsp;&nbsp;</td>
    <td width="52%" align="left" valign="middle"><select name="zones">
	    <option value="all" selected>all</option>
	<?	while($row_mails=mysql_fetch_object($res))	{ ?>
	  <option value="<?=$row_mails->rapzone?>"><?=$row_mails->rapzone?></option>
	  <? } ?>
      </select>&nbsp;<input type="submit" name="rap" value="Delete Zone"> </td>
</form>
  </tr>
  <form action="admin.php" method="post">
    <tr> 
      <td colspan="2" align="center">&nbsp; <input name="mode" type="hidden" id="mode" value="rapzones"> 
        <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>"> <input name="act" type="hidden" id="act" value="save"></td>
    </tr>
    <tr> 
      <td align="right" valign="top" class="body">Add New Rapzone&nbsp;&nbsp;</td>
      <td align="left"> 
        <input name="rapzone" type="text" id="rapzone"  size="30"> 
        &nbsp; <input name="Submit" type="submit" id="Submit" value="Add Rapzone"></td>
    </tr>
  </form>
  <tr> 
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr align="right"> 
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<?php
	show_footer();
}
function save()	{
	global $main_url,$base_path;
	$adsess=form_get("adsess");
	$mode=form_get("mode");
	admin_test($adsess);
	$rapzone=form_get("rapzone");
	$sql= "insert into rapzones (rapzone) values ('$rapzone')";
	sql_execute($sql,'');
	//mysql_query("insert into rapzones (rapzone) values ('$rapzone')");
	rapzone_manage();
}

function del() {
	global $main_url,$base_path;
	$adsess=form_get("adsess");
	$mode=form_get("mode");
	admin_test($adsess);
$zn=form_get("zones");
mysql_query("delete from rapzones where rapzone='$zn'");
	rapzone_manage();
} 
?>