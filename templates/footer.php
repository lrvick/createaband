</div>
<?
global $main_url,$site_title,$site_name,$cookie_url,$ban_fwidth,$ban_fheight;


if(isset($_GET["lng"]))
{
	$lng_id = $_GET["lng"];
}
else
{
	$lng_id = 0;
}

$ban_fwidth1=$ban_fwidth+50;
$ban_fheight1=$ban_fheight+7;
$sts=check_banorcod('f');
?>
<? if($sts=='b') { ?><? echo f_banners(); ?><? } else { ?><? echo dis_cod('f',$ban_fwidth,$ban_fheight); ?><? } ?>
<div align="center" style="position:relative; padding: 5;" class="copyright">
    	<br><br><br>
    	<a href="<?=$main_url?>/index.php?mode=about&lng=<?=$lng_id?>" class="bottom-links"><?=LNG_ABOUT?></a>&nbsp;<b>&nbsp;</b>&nbsp;|&nbsp;&nbsp;&nbsp;
    	<a href="<?=$main_url?>/index.php?mode=terms&lng=<?=$lng_id?>" class="bottom-links"><?=LNG_TERMS?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    	<a href="<?=$main_url?>/index.php?mode=privacy&lng=<?=$lng_id?>" class="bottom-links"><?=LNG_PRIVACY?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    	<a href="<?=$main_url?>/index.php?mode=contact&lng=<?=$lng_id?>" class="bottom-links"><?=LNG_CONTACT?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    	<a href="<?=$main_url?>/index.php?mode=advertise&lng=<?=$lng_id?>" class="bottom-links"><?=LNG_ADVERTISE?></a>&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    	<a href="<?=$main_url?>/index.php?mode=faq&lng=<?=$lng_id?>" class="bottom-links"><?=LNG_FAQ?></a>
    	
    </div>
<div align="center" class="copyright"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_COPY_RIGHT?></font></div>
</div>