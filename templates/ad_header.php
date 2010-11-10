<?
global $main_url,$site_title,$cookie_url,$ban_hwidth,$ban_hheight;
$sts=check_banorcod('h');
$ban_hwidth1=$ban_hwidth+50;
$ban_hheight1=$ban_hheight+12;
$sql_query="select * from news_ticker";
$news=sql_execute($sql_query,'get');
$scrol=stripslashes($news->body);

?>
<br>
<p align="right" class="lngSel">
<?

$lng_name = "english;french;spanish";
$total_lng = explode(";", $lng_name);

for($i=0; $i<count($total_lng); $i++)
{
	if($i==0)
	{		
	?>
		<a href="<?=$currPage?><?=$i?>"><?=ucfirst($total_lng[$i])?></a>&nbsp;
	<?
	}
	else
	{
	?>
		|&nbsp;<a href="<?=$currPage?><?=$i?>"><?=ucfirst($total_lng[$i])?></a>&nbsp;
	<?
	}
}

if(isset($_GET["lng"]))
{
	$lng_id = $_GET["lng"];
}
else
{
	if(isset($_COOKIE["lang"]))
	{
		$lng_id = $_COOKIE["lang"];		
	}
	else
	{
		$lng_id = 0;	
	}
}

?>	
</p>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined" >
  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
        <tr> 
          <td align="left" valign="top" ><img src="<?=$main_url?>/images/logo.gif"></td>
          <td width="635" align="left" valign="middle" > 
            <? if($sts=='b') { ?>
            <? echo h_banners(); ?> 
            <? } else { ?>
            <? echo dis_cod('h',$ban_hwidth,$ban_hheight); ?> 
            <? } ?>
          </td>
        </tr>
      </table>
</td>
  </tr>
  <tr> 
    <td valign="top">
	<table width="100%" border="0" cellspacing="2" cellpadding="2" >
        <tr> 
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=users_manager&adsess=<?=$adsess?>"><?=LNG_USERS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=tribes_manager&adsess=<?=$adsess?>"><?=LNG_GROUPS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=forums_manager&adsess=<?=$adsess?>"><?=LNG_FORUMS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=blogs_manager&adsess=<?=$adsess?>"><?=LNG_BLOGS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=events_manager&adsess=<?=$adsess?>"><?=LNG_EVENTS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=package_manager&adsess=<?=$adsess?>"><?=LNG_PACKAGE?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=news&adsess=<?=$adsess?>"><?=LNG_NEWS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=musics_manager&adsess=<?=$adsess?>"><?=LNG_MUSIC?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=banner_manager&adsess=<?=$adsess?>"><?=LNG_BANNER?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=help_manager&adsess=<?=$adsess?>"><?=LNG_HELP?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=tips_manager&adsess=<?=$adsess?>"><?=LNG_TIPS?></a></b></td>
        </tr>
      </table>
	</td>
  </tr>
  <tr> 
    <td height="1" ></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2" >
        <tr> 
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=listings_manager&adsess=<?=$adsess?>"><?=LNG_CLASSIFIEDS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=paypal_manager&adsess=<?=$adsess?>"><?=LNG_PAYPAL_ID?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=ip_manager&adsess=<?=$adsess?>"><?=LNG_IP_MANAGER?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=chatroom_manager&adsess=<?=$adsess?>"><?=LNG_CHAT_ROOMS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=admin_feedback&adsess=<?=$adsess?>"><?=LNG_CLASSIFIED_FEEDBACKS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=statistics&adsess=<?=$adsess?>"><?=LNG_STATISTICS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=shows_manager&adsess=<?=$adsess?>"><?=LNG_SHOWS?></a></b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="1" ></td>
  </tr>
  <tr>
    <td valign="top" align="right"><table border="0" cellspacing="2" cellpadding="2" width="100%" bgcolor="#639ACE">
        <tr> 
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=m_listings_manager&adsess=<?=$adsess?>"><?=LNG_MUSIC_CLASSIFIEDS_CATEGORIES?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=industries&adsess=<?=$adsess?>"><?=LNG_INDUSTRIES?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=m_forums_manager&adsess=<?=$adsess?>"><?=LNG_MUSIC_FORUMS?></a></b></td>
          <td align="center" class="mainlink bold" style="padding: 3"><b><a href="<?=$main_url?>/admin.php?mode=admin_login&act=logout&adsess=<?=$adsess?>"><?=LNG_LOGOUT?></a></b></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="1"></td>
  </tr>
</table>
