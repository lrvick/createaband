<?
require('data.php');
require('functions.php');
sql_connect();
global $main_url,$cookie_url,$site_title;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$play=form_get("play");
$cat_alb=form_get("cat");
$tt=form_get("tt");
$sql_query="select * from songs where s_id='$play'";
$pl=sql_execute($sql_query,'get');
$sql_query="select * from musics where m_id='$cat_alb'";
$cat=sql_execute($sql_query,'get');
/* $time=time()+3600*24*365;
$tmp_song_album=cookie_get("song_album");
if(!empty($tmp_song_album))	SetCookie("song_album","",time()-10,"/",$cookie_url);
$tmp_song_sel=cookie_get("song_sel");
if(!empty($tmp_song_sel))	SetCookie("song_sel","",time()-10,"/",$cookie_url);
$tmp_song_tk=cookie_get("song_tk");
if(!empty($tmp_song_tk))	SetCookie("song_tk","",time()-10,"/",$cookie_url); */
SetCookie("song_album",$cat_alb,time()+300,"/",$cookie_url);
SetCookie("song_sel",$play,time()+300,"/",$cookie_url);
SetCookie("song_tk",$tt,time()+300,"/",$cookie_url);
?>
<html>
<head>
<title><?=$site_title?></title>
<link href="<?=$main_url?>/styles/style.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="290" height="215" align="center">
    <param name="movie" value="player.swf?tem=<? echo time(); ?>">
	<param name="quality" value="high">
	<param name="bgcolor" value="#CECFCE">
	<embed src="player.swf" quality="high" bgcolor="#CECFCE" width="290" height="215" align="center" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
	</object>
</center>
</body>
</html>
