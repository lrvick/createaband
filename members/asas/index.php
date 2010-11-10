<?php
 
will be considered as the violation of the copyright laws */ 


if(isset($_GET["lng"]))
{
	$lng_id = $_GET["lng"];
}
else
{
	$lng_id = 0;
}

$chr=$_SERVER['PHP_SELF'];
$chr_me=explode("/",$chr);
$chr_co=count($chr_me);
$pnam=$chr_me[$chr_co-2];
if(!empty($pnam))	$hed="Location:../index.php?seid=$pnam&lng=$lng_id";
else	$hed="Location:../../index.php";
header($hed);
exit;
?>