<?
require('data.php');
require('functions.php');
sql_connect();

$visit=cookie_get("visit");
$m_id=cookie_get("mem_id");

$mode=form_get("mode");
$now=time();

$sql_query="select updated from stats";
$res=sql_execute($sql_query,'res');
if(!mysql_num_rows($res))	{
	$sql_query="insert into stats (day_sgnin,week_sgnin,month_sgnin,day_vis,week_vis,month_vis,day_sgns,week_sgns,month_sgns,vis,updated) values ('0','0','0','0','0','0','0','0','0','','$now')";
	sql_execute($sql_query,'');
	$sql_query="select updated from stats";
	$stats=sql_execute($sql_query,'get');
}	else	$stats=sql_execute($sql_query,'get');

$day_of_week=date("w");
$month_start=mktime(0,0,0,date("m"),1,date("Y"));
$week_start=mktime(0,0,0,date("m"),date("d")-$day_of_week,date("Y"));
$day_start=mktime(0,0,0,date("m"),date("d"),date("Y"));

if($stats->updated<=$month_start)	{
	$sql_query="update stats set month_sgnin='0',month_vis='0',updated='$now'";
	sql_execute($sql_query,'');
}
if($stats->updated<=$week_start)	{
	$sql_query="update stats set week_sgnin='0',week_vis='0',updated='$now'";
	sql_execute($sql_query,'');
}
if($stats->updated<=$day_start)	{
	$sql_query="update stats set day_sgnin='0',day_vis='0',vis='',updated='$now'";
	sql_execute($sql_query,'');
}

$day=24*3600;

if($now-$visit>=$day)	{
	$sql_query="update stats set day_vis=day_vis+1,week_vis=week_vis+1,month_vis=month_vis+1,vis=concat(vis,'|$now')";
	sql_execute($sql_query,'');
	SetCookie("visit",$now,time()+60*60*24,"/",$cookie_url);
}//if


if($mode != "")
{
	check($mode);
}
else
{
	$mode = "main";
	check($mode);
}
?>
