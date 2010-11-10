<?
require('../data.php');
require('../functions.php');
sql_connect();

global $main_url;	
$seid=form_get("seid");
$sql_query="select mem_id from members where profilenam='$seid'";
$mem=sql_execute($sql_query,'get');
$link="$main_url/index.php?mode=profile&p_id=$mem->mem_id";
show_screen($link);
?>