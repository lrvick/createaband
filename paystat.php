<?php
$mem_id=form_get("mem_id");
$screen=form_get("screen");
if($screen==0)	{
	mysql_query("update members set pay_stat='Y' where mem_id=$mem_id");
	complete_screen(0);
}	elseif($screen==9)	complete_screen(9);
elseif($screen==10)	{
	mysql_query("update members set pay_stat='Y' where mem_id=$mem_id");
	complete_screen(10);
}	elseif($screen==11)	complete_screen(11);
?>
