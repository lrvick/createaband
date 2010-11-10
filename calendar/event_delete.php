<?
require_once("includes/config.php");

$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$id=form_get("id");
$month=form_get("month");
$year=form_get("year");
$sql="select * from calendar_events where event_id='$id'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
$eve_listid=$row->event_para;
mysql_query("delete from event_list where even_id=$eve_listid");
mysql_query("delete from calendar_events where event_id=$id");

header("Location:calendar.php?mode=calendar&month=$month&year=$year");
exit;
?>