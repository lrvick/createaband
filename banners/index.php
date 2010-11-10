<?php
require('../data.php');
require('../functions.php');
sql_connect();

$sql_query="select ip from ips";
$res=mysql_query($sql_query);
$ip_co=sql_execute($sql_query,'num');
$ip_def=$ip->ip;
$sh=0;
$ho=0;
$cur_ip=$_SERVER["REMOTE_ADDR"];

while($ips=mysql_fetch_object($res))	{
	if($cur_ip==$ips->ip)	$sh=1;
}

$sql_query="select * from banners where b_id='$seid'";
$row=sql_execute($sql_query,'get');
$clkd=split("\|",$row->b_clkips);
$all=count($clkd);
for($i=1; $i<=$all-1; $i++)	{
	if($clkd[$i]==$cur_ip)	$ho=1;
}

if($sh==0)	mysql_query("update banners set b_clks=b_clks+1,b_clkips=concat(b_clkips,'|$cur_ip') where b_id='$seid'");
if($ho==0)	mysql_query("update banners set b_clks=b_clks+1,b_clkips=concat(b_clkips,'|$cur_ip') where b_id='$seid'");
header("Location:".$url);
exit;
?>