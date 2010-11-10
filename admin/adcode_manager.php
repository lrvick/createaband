<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if(empty($act))	ad_header();

function ad_header()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$type=form_get("type");
	$done=form_get("done");
	if(empty($done))	{
		$sql_query="select * from ad_code where type='$type'";
		$cod=sql_execute($sql_query,'get');
		switch($type)	{
			case 'h':
				$hed="Header";
				break;
			case 'f':
				$hed="Footer";
				break;
			case 'm':
				$hed="Main Page";
				break;
			case 'o':
				$hed="Other";
				break;
		}
		show_ad_header($adsess);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;Admin : Advertise Code For <?=$hed?></td>
  </tr>
  <tr> 
    <td height="5"></td>
  </tr>
  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td valign="top"><table border="0" cellspacing="3" cellpadding="3" class="body">
              <tr> 
                <td class="action"><a href="admin.php?mode=adcode_manager&type=h&adsess=<?=$adsess?>">For 
                  Header</a></td>
                <td class="action"><a href="admin.php?mode=adcode_manager&type=f&adsess=<?=$adsess?>">For 
                  Footer</a></td>
                <td class="action"><a href="admin.php?mode=adcode_manager&type=m&adsess=<?=$adsess?>">For 
                  Main Page</a></td>
                <td class="action"><a href="admin.php?mode=adcode_manager&type=o&adsess=<?=$adsess?>">For 
                  Other</a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top"><form method="post" action="admin.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="3"></td>
          </tr>
          <tr> 
            <td align="center"><textarea name="adv_code" cols="35" rows="4" id="adv_code"><?=stripslashes($cod->adv_code)?></textarea></td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <tr> 
            <td align="center"><span class="orangebody">Check if need to dispaly this advertisement, otherwise banners will be displayed</span><br>
              <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>">
              <input name="type" type="hidden" id="type" value="<?=$type?>">
              <input name="done" type="hidden" id="done" value="done">
              <input name="mode" type="hidden" id="mode" value="adcode_manager">
              <input name="banorcod" type="checkbox" id="banorcod" value="c"<? echo checked($cod->banorcod,"c"); ?>></td>
          </tr>
          <tr>
            <td height="3"></td>
          </tr>
          <tr>
            <td align="center"><input type="submit" name="Submit" value=" Update "></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?
		show_footer();
	}	else	{
		$adv_code=form_get("adv_code");
		$banorcod=form_get("banorcod");
		if(empty($banorcod))	$banorcod='b';
		$sql_query="update ad_code set adv_code='".addslashes($adv_code)."',banorcod='$banorcod' where type='$type'";
		sql_execute($sql_query,'');
		$link="admin.php?mode=adcode_manager&type=$type&adsess=$adsess";
		show_screen($link);
	}
}
?>