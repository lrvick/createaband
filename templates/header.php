<? 
global $main_url,$site_title,$cookie_url,$ban_hwidth,$ban_hheight;
$ban_hwidth1=$ban_hwidth+50;
$ban_hheight1=$ban_hheight+12;
$m_id=cookie_get("mem_id");
$m_acc=cookie_get("mem_acc");
$mem_list=cookie_get("mem_list");
$mem_grop=cookie_get("mem_grop");
$mem_eve=cookie_get("mem_eve");
$mem_blog=cookie_get("mem_blog");
$mem_chat=cookie_get("mem_chat");
$mem_forum=cookie_get("mem_forum");
$mem_forum=cookie_get("mem_forum");
$mode=form_get("mode");
$sts=check_banorcod('h');
$sql_query="select * from news_ticker";
$news=sql_execute($sql_query,'get');
$scrol=stripslashes($news->body);
?>
<div align="right" class="lngSel">
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

?></div>	

    <div align="center" style="max-width:775px;">
<? //if($sts=='b') { ?><? echo h_banners(); ?>
<? //} else { ?>
<? //echo dis_cod('h',$ban_hwidth,$ban_hheight); ?>
<? // } ?>

         <div class="mainlink" align="center" style="height:25px;">
          	<img src="<?=$main_url?>/images/logo.jpg" width="775px" align="middle"><br>
          	
          	
          	          	
          	<a href="<?=$main_url?>/index.php?mode=login&act=home&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_HOME?></a> 
            | <a href="<?=$main_url?>/chat/" class="mainlink bold"><?=LNG_CHAT?></a> 
            
            <? if(!empty($m_id)) { ?>| <a href="index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_MY_PROFILE?></a><? } else { ?><? } ?>
            
            | <a href="<?=$main_url?>/index.php?mode=search&act=browse&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_BROWSE?></a> 
            
            | <a href="<?=$main_url?>/index.php?mode=search&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_SEARCH?></a>
            
            <? if(!empty($m_id)) { ?>| <a href="<?=$main_url?>/index.php?mode=user&act=inv&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_INVITE?></a> <? } else { ?><? } ?>
            
            <? if(!empty($m_id)) { ?>| <a href="<?=$main_url?>/index.php?mode=messages&act=inbox&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_MAIL?></a> <? } else { ?><? } ?>
            
            <? if(!empty($m_id)) { ?>| <a href="<?=$main_url?>/index.php?mode=blogs&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_BLOG?></a> <? } else { ?><? } ?>
            
            <? if(!empty($m_id)) { ?>| <a href="<?=$main_url?>/index.php?mode=forums&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_FORUM?></a> <? } else { ?><? } ?>
            
            | <a href="<?=$main_url?>/index.php?mode=news&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_NEWS?></a>
           
            <? if(!empty($m_id)) { ?>| <a href="<?=$main_url?>/index.php?mode=tribe&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_GROUPS?></a><? } else { ?><? } ?>
            
            | <a href="<?=$main_url?>/index.php?mode=events&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_EVENTS?></a>
            
            | <a href="<?=$main_url?>/index.php?mode=music&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_MUSIC?></a> 
            
            | <a href="<?=$main_url?>/index.php?mode=listing&act=all&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_CLASSIFIEDS?></a> 
            
            | <? if(!empty($m_id)) { ?><a href="/index.php?mode=login&act=logout&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_LOGOUT?></a><? } else { ?><a href="index.php?mode=login&act=form&lng=<?=$lng_id?>" class="mainlink bold"><?=LNG_LOGIN?></a><? } ?>
          </div>

<? if(($mode=='music') || ($mode=='profile') || ($mode=='m_listings') || ($mode=='m_forums') || ($mode=='shows') || (($mode=='search') && ($act=='music'))) { ?>

        <a href="<?=$main_url?>/index.php?mode=mypage&lng=<?=$lng_id?>"><?=LNG_MUSIC_PROFILE?></a> 
      | <a href="<?=$main_url?>/index.php?mode=music&act=direct&lng=<?=$lng_id?>"><?=LNG_DIRECTORY?></a> 
      | <a href="<?=$main_url?>/index.php?mode=search&act=music&lng=<?=$lng_id?>"><?=LNG_SEARCH?></a> | 
      <a href="<?=$main_url?>/index.php?mode=m_forums&lng=<?=$lng_id?>"><?=LNG_MUSIC_FORUMS?></a> | 
      <a href="<?=$main_url?>/index.php?mode=m_listings&act=all&lng=<?=$lng_id?>"><?=LNG_MUSIC_CLASSIFIED?></a> | 
      <a href="<?=$main_url?>/index.php?mode=shows&lng=<?=$lng_id?>"><?=LNG_SHOWS?></a> 
      | <a href="<?=$main_url?>/index.php?mode=music&act=top&lng=<?=$lng_id?>"><?=LNG_TOP_ALBUM?></a></td>
  <? } ?>
  
  <div style="position:relative; width:770px; top:100px;">
