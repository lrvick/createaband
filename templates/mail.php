<?php
global $main_url,$site_namemail;
$matter="<table width='511' cellpadding='1' cellspacing='0' style='border:1px outset #000000; padding:2; border-collapse: collapse; font-family:Verdana; font-size:8pt' bordercolor='#636563'><tr><td colspan='2' valign='top' bgcolor='#F75D08'><a href='$main_url'><img src='$main_url/images/logo.jpg' border='0'></a></td></tr><tr><td height='20' align='center' colspan='2'><span style='text-decoration:none;font-family:arial,sans-serif,helvetica;font-size:12px'><strong>$subject</strong></span></td></tr><tr><td width='69' valign='top'>&nbsp;</td><td valign='top' width='441'><table width='100%' cellpadding='5' cellspacing='0' border='0'><tr><td valign='top' style='font-family: arial,sans-serif,helvetica;font-size: 12px'><p>$wel</p><p>$body</p><p>$thn<br><a href='$main_url'>$main_url</a></p><p><?=LNG_MAIL_MSG?>$site_namemail.</p></td></tr></table></td></tr></table>";
?>