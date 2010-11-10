<?php
if(isset($_GET["lng"]))
{
	$lng_id = $_GET["lng"];
}
else
{
	if(isset($_COOKIE["lang"]))
	{
		$lng_id = $_COOKIE["lang"];		
	}
	else
	{
		$lng_id = 0;	
	}
}

global $main_url;
$pack=form_get("pack");
$mem_id=form_get("mem_id");
$success=$main_url."/index.php?mode=paystat&screen=0&mem_id=$mem_id&lng=".$lng_id;
$fail=$main_url."/index.php?mode=paystat&screen=9&mem_id=$mem_id&lng=".$lng_id;
$sql="select * from member_package where package_id=$pack";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
$sql_query="select * from admin";
$res_mail=mysql_query($sql_query);
$row_mail=mysql_fetch_object($res_mail);
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="form1">
	<input type="hidden" name="cmd" value="_xclick-subscriptions">
	<input type="hidden" name="business" value="<?=$row_mail->paypal_mail?>">
	<input type="hidden" name="item_name" value="Annual Subscription">
	<input type="hidden" name="item_number" value="m">
	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="a3" value="<?=$row->package_amt?>">
	<input type="hidden" name="return" value="<?=$success?>">
	<input type="hidden" name="cancel_return" value="<?=$fail?>">
	<input type="hidden" name="p3" value="1">
	<input type="hidden" name="t3" value="Y">
	<input type="hidden" name="src" value="1">
	<input type="hidden" name="sra" value="1">
</form>
<script language="JavaScript1.2">
	document.form1.submit();
</script>
