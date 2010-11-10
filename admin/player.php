<?
require('../data.php');
global $main_url,$site_title;
?>
<html>
<head>
<title><?=$site_title?></title>
<link href="<?=$main_url?>/styles/style.css" type="text/css" rel="stylesheet">
</head>
<body bgcolor="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="290" height="215" id="player" align="center">
	<param name="movie" value="player.swf">
	<param name="quality" value="high">
	<param name="bgcolor" value="#000000">
	<embed src="player.swf" quality="high" bgcolor="#3C64C0" width="290" height="215" name="player" align="center" type"application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
</object>
</center>
</body>
</html>