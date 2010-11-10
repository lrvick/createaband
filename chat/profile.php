<? ini_set('error_reporting',7); import_request_variables("GP"); ?>
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

require('../data.php');
require('../functions.php');
sql_connect();
global $main_url,$base_path;
$mode=form_get("mode");
$act=form_get("act");
if(!empty($mode) or !empty($act))	{
	header("Location:$main_url/index.php?mode=$mode&act=$act&lng=$lng_id");
	exit;
}
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$sql_query="select mem_id from members where profilenam='$username'";
$mem_nam=sql_execute($sql_query,'get');
$mem_id=$mem_nam->mem_id;
header("Location:$main_url/index.php?mode=people_card&p_id=$mem_id&lng=$lng_id");
exit;
?>