<?
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


$act=form_get("act");
if(empty($act))	listinginfo();
elseif($act=='music')	music();
elseif($act=='delmusic')	delmusic();
elseif($act=='managesongs')	managesongs();
elseif($act=='delsongs')	delsongs();
elseif($act=='profile')	profile();
elseif($act=='basic')	basic();
elseif($act=='shows')	shows();
elseif($act=='delshows')	delshows();

function listinginfo()	{
	global $main_url,$lng_id;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$done=form_get("done");
	if(empty($done))	{
		$sql_query="select * from musicprofile where mem_id='$m_id'";
		$musicpro=sql_execute($sql_query,'get');
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_AZ?></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td height="20"></td></tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left"><table height="20" width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr align="center"> 
                      <td class="td-lined-top td-lined-right td-lined-left td-shade"><strong><?=LNG_MYPAGE_BZ?></strong></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=music&lng=<?=$lng_id?>"><?=LNG_MYPAGE_CZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=profile&lng=<?=$lng_id?>"><?=LNG_MUSIC_PROFILE?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=basic&lng=<?=$lng_id?>"><?=LNG_MYPAGE_DZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=shows&lng=<?=$lng_id?>"><?=LNG_MYPAGE_EZ?></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td valign="top" class="lined">
	<form method="post" action="index.php">
	    <table width="75%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
          <tr align="center"> 
            <td colspan="2" height="20" class="bold large"><?=LNG_MYPAGE_FZ?>: <span class="title-box"> 
              <?=$main_url?>/members/<? echo mem_profilenam($m_id); ?></span></td>
          </tr>
          <tr> 
            <td width="50%"><strong><?=LNG_MUSIC_BRAND_NAME?></strong></td>
            <td width="50%"><input type="text" name="bandnam" value="<?=stripslashes($musicpro->bandnam)?>"></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_G1?></strong></td>
            <td><select name="genre1">
                <? show_music_cat1($musicpro->genre1); ?>
              </select></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_G2?></strong></td>
            <td><select name="genre2">
                <? show_music_cat1($musicpro->genre2); ?>
              </select></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_G3?></strong></td>
            <td><select name="genre3">
                <? show_music_cat1($musicpro->genre3); ?>
              </select></td>
          </tr>
          <tr><td colspan="2" height="3">
		  <input type="hidden" name="mode" value="mypage">
		  <input type="hidden" name="done" value="done">
		  </td></tr>
          <tr align="center"> 
            <td colspan="2"><input type="submit" class="button" value=" <?=LNG_RIDEZ_MODIFY?> "></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?
		show_footer();
	}	else	{
		$bandnam=form_get("bandnam");
		$genre1=form_get("genre1");
		$genre2=form_get("genre2");
		$genre3=form_get("genre3");
		$sql_query="update musicprofile set bandnam='".addslashes($bandnam)."',genre1='$genre1',genre2='$genre2',genre3='$genre3' where mem_id='$m_id'";
		sql_execute($sql_query,'');
		$link="index.php?mode=mypage&lng=$lng_id";
		show_screen($link);
	}
}

function music()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	global $lng_id;
	$rec_id=form_get("rec_id");
	$done=form_get("done");
	if(empty($done))	{
		if(!empty($rec_id))	{
			$sql_query="select * from musics where m_id='$rec_id'";
			$music=sql_execute($sql_query,'get');
		}
		$page=form_get("page");
		if(empty($page))	$page=1;
		$start=($page-1)*20;
		$sql_query="select * from musics where m_own='$m_id' order by m_id desc limit $start,20";
		$p_sql="select m_id from musics where m_own='$m_id' order by m_id desc";
		$res=sql_execute($sql_query,'res');
		$p_url="index.php?mode=mypage&act=music&lng=$lng_id";
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_GZ?></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="20"></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="left"><table height="20" width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr align="center"> 
                      <td class="td-lined"><a href="index.php?mode=mypage&lng=<?=$lng_id?>"><?=LNG_MYPAGE_BZ?></a></td>
                      <td class="td-lined-top td-lined-right td-lined-left td-shade"><strong><?=LNG_MYPAGE_CZ?></strong></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=profile&lng=<?=$lng_id?>"><?=LNG_MUSIC_PROFILE?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=basic&lng=<?=$lng_id?>"><?=LNG_MYPAGE_DZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=shows&lng=<?=$lng_id?>"><?=LNG_MYPAGE_EZ?></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr> 
    <td valign="top" class="lined"> <form method="post" action="index.php" enctype="multipart/form-data">
        <table width="75%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
<? if(!empty($rec_id)) { ?>
		  <tr>
			<td align="right" colspan="2" style="padding-right: 7">[<a href="index.php?mode=mypage&act=music&lng=<?=$lng_id?>"><?=LNG_MYPAGE_HZ?></a>]</td>
		  </tr>
<? } ?>
          <tr> 
            <td width="50%"><strong><?=LNG_MYPAGE_IZ?></strong></td>
            <td width="50%" height="25"><input name="m_title" type="text"<? if(!empty($rec_id)) { ?> value="<?=stripslashes($music->m_title)?>"<? } ?>></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_AP?></strong></td>
            <td><input type="file" name="photo" size="20"></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_AYA?></strong></td>
            <td><textarea name="m_matt" cols="25" rows="3"><? if(!empty($rec_id)) { ?><?=stripslashes($music->m_matt)?><? } ?></textarea></td>
          </tr>
          <tr>
            <td colspan="2" height="3"> <input type="hidden" name="mode" value="mypage"> 
              <input type="hidden" name="act" value="music"> 
              <? if(!empty($rec_id)) { ?>
              <input type="hidden" name="rec_id" value="<?=$rec_id?>">
              <? } ?>
              <input type="hidden" name="done" value="done"> </td>
          </tr>
          <tr align="center"> 
            <td colspan="2"><input type="submit" class="button" value=" <? if(!empty($rec_id)) { ?><?=LNG_MYPAGE_MDS?><? } else { ?><?=LNG_MYPAGE_ATL?><? } ?> "></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr><td height="5"></td></tr>
<? if(mysql_num_rows($res)) { ?>
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_MAL?> &raquo;</td>
  </tr>
  <tr> 
    <td valign="top" class="lined">
        <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
<? while($row=mysql_fetch_object($res)) { ?>
<?
$sql_so="select count(s_id) as tot from songs where s_sec='$row->m_id'";
$songco=sql_execute($sql_so,'get');
?>
	      <tr> 
            <? if(!empty($row->photo_b_thumb)) { ?><td width="4%"><img src="<?=$row->photo_b_thumb?>" border="0"></td><td width="25%" valign="middle"><? } else { ?><td colspan="2" valign="middle"><? } ?>
            <strong><?=stripslashes($row->m_title)?></strong></td>
			<td width="55%"><?=stripslashes($row->m_matt)?></td>
          </tr>
		  <tr><td colspan="3" align="right" style="padding-right: 17">
		  [<a href="index.php?mode=mypage&act=music&rec_id=<?=$row->m_id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>]&nbsp;
		  [<a href="index.php?mode=mypage&act=delmusic&rec_id=<?=$row->m_id?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>]&nbsp;
		  [<a href="index.php?mode=mypage&act=managesongs&rec_id=<?=$row->m_id?>&lng=<?=$lng_id?>" title="Songs Count &raquo; <?=$songco->tot?>"><?=LNG_MYPAGE_CZ?></a>]</td></tr>
		  <tr><td colspan="3" height="1" class="title"></td></tr>
<? } ?>
        </table>
      </td>
  </tr>
  <tr> 
    <td height="20" align="right" class="body" style="padding-right: 12"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
<? } ?>
</table>
<?
		show_footer();
	}	else	{
		global $_FILES,$lng_id;
		$m_matt=form_get("m_matt");
		$m_title=form_get("m_title");
		$tmpfname=$_FILES['photo']['tmp_name'];
		$ftype=$_FILES['photo']['type'];
		$fsize=$_FILES['photo']['size'];
		if((empty($m_title)) || (empty($m_matt)))	{
			$link="index.php?mode=mypage&act=music&lng=$lng_id";
			if(!empty($rec_id))	$link.="&rec_id=$rec_id";
		}	else	{
			$now=time();
			if(!empty($tmpfname))	{
				if(!empty($rec_id))	{
					$sql_query="select * from musics where m_id='$rec_id'";
					$music=sql_execute($sql_query,'get');
					if(file_exists($music->photo))	@unlink($music->photo);
					if(file_exists($music->photo_thumb))	@unlink($music->photo_thumb);
					if(file_exists($music->photo_b_thumb))	@unlink($music->photo_b_thumb);
				}
				if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
				elseif($ftype=='image/gif')	$p_type=".gif";
				else	error_screen(9);
				$rand=rand(0,10000);
				$newname=md5($m_id.time().$rand);
				$newname_th=$newname."th";
				$newname_b_th=$newname."bth";
				$old="music/".$newname.$p_type;
				$thumb1="music/".$newname_th.".jpeg";
				$thumb2="music/".$newname_b_th.".jpeg";
				move_uploaded_file($tmpfname,"music/".$newname.$p_type);
				if($p_type==".jpeg")	$srcImage = ImageCreateFromJPEG( $old );
				elseif($p_type==".gif")	$srcImage = ImageCreateFromGIF( $old );
				$sizee=getimagesize($old);
				$srcwidth=$sizee[0];
				$srcheight=$sizee[1];
				//landscape
				if($srcwidth>$srcheight)	{
					$destwidth1=65;
					$rat=$destwidth1/$srcwidth;
					$destheight1=(int)($srcheight*$rat);
					$destwidth2=150;
					$rat2=$destwidth2/$srcwidth;
					$destheight2=(int)($srcheight*$rat2);
				}
				//portrait
				elseif($srcwidth<$srcheight)	{
					$destheight1=65;
					$rat=$destheight1/$srcheight;
					$destwidth1=(int)($srcwidth*$rat);
					$destheight2=150;
					$rat=$destheight2/$srcheight;
					$destwidth2=(int)($srcwidth*$rat);
				}
				//quadro
				elseif($srcwidth==$srcheight)	{
					$destwidth1=65;
					$destheight1=65;
					$destwidth2=150;
					$destheight2=150;
				}
				$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
				$destImage2 = ImageCreateTrueColor( $destwidth2, $destheight2);
				ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
				ImageCopyResized( $destImage2, $srcImage, 0, 0, 0, 0, $destwidth2, $destheight2, $srcwidth, $srcheight );
				if($p_type==".jpeg")	{
					ImageJpeg($destImage1, $thumb1, 80);
					ImageJpeg($destImage2, $thumb2, 80);
				}	elseif($p_type==".gif")	{
					ImageGif($destImage1, $thumb1, 80);
					ImageGif($destImage2, $thumb2, 80);
				}
				ImageDestroy($srcImage);
				ImageDestroy($destImage1);
				ImageDestroy($destImage2);
				//updating db
				$photo="music/".$newname.$p_type;
				$photo_b_thumb="music/".$newname_b_th.".jpeg";
				$photo_thumb="music/".$newname_th.".jpeg";
			}	else	{
				if(!empty($rec_id))	{
					$sql_query="select * from musics where m_id='$rec_id'";
					$music=sql_execute($sql_query,'get');
					$photo=$music->photo;
					$photo_b_thumb=$music->photo_b_thumb;
					$photo_thumb=$music->photo_thumb;
				}	else	{
					$photo="";
					$photo_b_thumb="";
					$photo_thumb="";
				}
			}
			if(empty($rec_id))	$sql_query="insert into musics (m_own,m_title,m_matt,photo,photo_thumb,photo_b_thumb,m_dt) values ('$m_id','".addslashes($m_title)."','".addslashes($m_matt)."','$photo','$photo_thumb','$photo_b_thumb','$now')";
			else	$sql_query="update musics set m_title='".addslashes($m_title)."',m_matt='".addslashes($m_matt)."',photo='$photo',photo_thumb='$photo_thumb',photo_b_thumb='$photo_b_thumb' where m_id='$rec_id'";
			sql_execute($sql_query,'');
			$link="index.php?mode=mypage&act=music&lng=$lng_id";
			if(!empty($rec_id))	$link.="&rec_id=$rec_id";
		}
		show_screen($link);
	}
}

function delmusic()	{
	$m_id=cookie_get("mem_id");
	global $lng_id;
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	$sql_query="select * from musics where m_id='$rec_id'";
	$music=sql_execute($sql_query,'get');
	if(file_exists($music->photo))	@unlink($music->photo);
	if(file_exists($music->photo_thumb))	@unlink($music->photo_thumb);
	if(file_exists($music->photo_b_thumb))	@unlink($music->photo_b_thumb);
	$sql_query="select * from songs where s_sec='$rec_id'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			if(file_exists($row->s_name))	@unlink($row->s_name);
		}
	}
	$sql_query="delete from songs where s_sec='$rec_id'";
	sql_execute($sql_query,'');
	$sql_query="delete from musics where m_id='$rec_id'";
	sql_execute($sql_query,'');
	$link="index.php?mode=mypage&act=music&lng=$lng_id";
	show_screen($link);
}

function managesongs()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	$son_id=form_get("son_id");
	global $lng_id;
	$done=form_get("done");
	if(empty($done))	{
		if(!empty($son_id))	{
			$sql_query="select * from songs where s_id='$son_id'";
			$song=sql_execute($sql_query,'get');
		}
		$sql_query="select * from musics where m_id='$rec_id'";
		$music=sql_execute($sql_query,'get');
		$sql_so="select count(s_id) as tot from songs where s_sec='$rec_id'";
		$songco=sql_execute($sql_so,'get');
		$page=form_get("page");
		if(empty($page))	$page=1;
		$start=($page-1)*20;
		$sql_query="select * from songs where s_sec='$rec_id' order by s_id desc limit $start,20";
		$p_sql="select s_id from songs where s_sec='$rec_id' order by s_id desc";
		$res=sql_execute($sql_query,'res');
		$p_url="index.php?mode=mypage&act=managesongs&rec_id=$rec_id&lng=$lng_id";
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_GZ?></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="20"></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="left"><table height="20" width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr align="center"> 
                      <td class="td-lined"><a href="index.php?mode=mypage&lng=<?=$lng_id?>"><?=LNG_MYPAGE_BZ?></a></td>
                      <td class="td-lined-top td-lined-right td-lined-left td-shade"><strong><?=LNG_MYPAGE_CZ?></strong></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=profile&lng=<?=$lng_id?>"><?=LNG_MUSIC_PROFILE?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=basic&lng=<?=$lng_id?>"><?=LNG_MYPAGE_DZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=shows&lng=<?=$lng_id?>"><?=LNG_MYPAGE_EZ?></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr> 
    <td valign="top" class="lined"> <form method="post" action="index.php" enctype="multipart/form-data">
        <table width="75%" border="0" cellspacing="2" cellpadding="2" align="center" class="body td-lined">
          <? if(!empty($son_id)) { ?>
          <tr> 
            <td align="right" colspan="2" style="padding-right: 7">[<a href="index.php?mode=mypage&act=managesongs&rec_id=<?=$rec_id?>&lng=<?=$lng_id?>"><?=LNG_MYPAGE_USS?></a>]</td>
          </tr>
          <? } ?>
          <tr valign="top"> 
            <td height="25" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
                <tr> 
				<? if(!empty($music->photo_b_thumb)) { ?><td valign="top"><img src="<?=$music->photo_b_thumb?>" border="0"></td><? } ?>
                  <td valign="middle" style="padding-left: 7;padding-right: 7">
				  <strong><?=stripslashes($music->m_title)?></strong><br>
				  <span style="padding-left: 7"><?=stripslashes($music->m_matt)?></span><br><br>
				  <div align="right">[<?=LNG_MYPAGE_NOF_SONGS?> &#8230; <?=$songco->tot?>]</div>
				  </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td width="50%"><strong><?=LNG_MYPAGE_SNAME?></strong></td>
            <td width="50%" height="25"><input name="s_title" type="text"<? if(!empty($son_id)) { ?> value="<?=stripslashes($song->s_title)?>"<? } ?>></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_MP3?></strong></td>
            <td><input type="file" name="song" size="20"></td>
          </tr>
          <tr> 
            <td colspan="2" style="padding-left: 7;padding-top: 5;padding-bottom: 5">
			<input name="autoplay" type="checkbox" value="y"<? if(!empty($son_id)) { ?><? echo checked($song->autoplay,"y"); ?><? } ?>>&nbsp;<?=LNG_MYPAGE_AUTO_PLAY?>
			</td>
          </tr>
          <tr> 
            <td colspan="2" height="3"> <input type="hidden" name="mode" value="mypage"> 
              <input type="hidden" name="act" value="managesongs"> 
              <input type="hidden" name="rec_id" value="<?=$rec_id?>"> 
              <? if(!empty($son_id)) { ?>
              <input type="hidden" name="son_id" value="<?=$son_id?>"> 
              <? } ?>
              <input type="hidden" name="done" value="done"> </td>
          </tr>
          <tr align="center"> 
            <td colspan="2"><input type="submit" class="button" value=" <? if(!empty($son_id)) { ?><?=LNG_MYPAGE_MDS?><? } else { ?><?=LNG_MYPAGE_ATL?><? } ?> "></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr><td height="5"></td></tr>
<? if(mysql_num_rows($res)) { ?>
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_SLIST?> &raquo;</td>
  </tr>
  <tr> 
    <td height="20" align="right" class="body" style="padding-right: 12"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
  <tr> 
    <td valign="top" class="lined">
<form action="index.php" method="post">
        <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
<? while($row=mysql_fetch_object($res)) { ?>
	      <tr> 
            <td><input type="checkbox" name="son_id[]" value="<?=$row->s_id?>"></td>
			<td><?=stripslashes($row->s_title)?></td>
			<td><? echo dis_filesize($row->s_name); ?>KB</td>
			<td><a href="index.php?mode=mypage&act=managesongs&rec_id=<?=$rec_id?>&son_id=<?=$row->s_id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a></td>
          </tr>
		  <tr><td colspan="4" height="1"></td></tr>
<? } ?>
		  <tr><td colspan="4" align="right" style="padding-right: 17">
		  <input type="hidden" name="mode" value="mypage">
		  <input type="hidden" name="rec_id" value="<?=$rec_id?>">
		  <input type="hidden" name="act" value="delsongs">
		  <input type="submit" name="submit" value="<?=LNG_MYPAGE_DSLL?>" class="button">
		  </td></tr>
        </table></form>
      </td>
  </tr>
<? } ?>
</table>
<?
		show_footer();
	}	else	{
		global $_FILES,$lng_id;
		$s_title=form_get("s_title");
		$autoplay=form_get("autoplay");
		if(empty($autoplay))	$autoplay="n";
		$tmpfname=$_FILES['song']['tmp_name'];
		$ftype=$_FILES['song']['type'];
		$fsize=$_FILES['song']['size'];
		if(empty($s_title))	{
			$link="index.php?mode=mypage&act=managesongs&rec_id=$rec_id&lng=$lng_id";
			if(!empty($son_id))	$link.="&son_id=$son_id&lng=$lng_id";
		}	elseif(!empty($son_id))	{
			if(empty($tmpfname))	{
				$link="index.php?mode=mypage&act=managesongs&rec_id=$rec_id";
				if(!empty($son_id))	$link.="&son_id=$son_id&lng=$lng_id";
			}
		}	else	{
			if($ftype=="audio/mpeg")	{
				if(!empty($son_id))	{
					$sql_query="select * from songs where s_id='$son_id'";
					$song=sql_execute($sql_query,'get');
					if(file_exists($song->s_name))	@unlink($song->s_name);
				}
				$rand=rand(0,10000);
				$newname=md5($m_id.time().$rand);
				move_uploaded_file($tmpfname,"music/songs/".$newname.".mp3");
				$filename="music/songs/".$newname.".mp3";
				$fp=fopen($filename,"r");
				fseek($fp,filesize($filename)-128);
				$f_size=number_format(filesize($filename)/1000,2);
				fclose($fp);
			}	else	{
				if(!empty($son_id))	{
					$sql_query="select * from songs where s_id='$son_id'";
					$song=sql_execute($sql_query,'get');
					$filename=$song->s_name;
					$f_size=$song->s_size;
				}	else	{
					$filename="";
					$f_size="";
				}
			}
			if(empty($son_id))	$sql_query="insert into songs (s_own,s_sec,s_title,s_name,s_size,autoplay) values ('$m_id','$rec_id','".addslashes($s_title)."','$filename','$f_size','$autoplay')";
			else	$sql_query="update songs set s_title='".addslashes($s_title)."',s_name='$filename',s_size='$f_size',autoplay='$autoplay' where s_id='$son_id'";
			sql_execute($sql_query,'');
			if(empty($son_id))	$prime=mysql_insert_id();
			else	$prime=$son_id;
			if($autoplay=='y')	{
				$sql_query="update songs set autoplay='n' where s_id<>'$prime' and s_own='$m_id'";
				sql_execute($sql_query,'');
			}
			$link="index.php?mode=mypage&act=managesongs&rec_id=$rec_id";
			if(!empty($son_id))	$link.="&son_id=$son_id&lng=$lng_id";
		}
		if(!empty($son_id))	{
			$sql_query="update songs set s_title='".addslashes($s_title)."',autoplay='$autoplay' where s_id='$son_id'";
			sql_execute($sql_query,'');
			if($autoplay=='y')	{
				$sql_query="update songs set autoplay='n' where s_id<>'$son_id' and s_own='$m_id'";
				sql_execute($sql_query,'');
			}
		}
		show_screen($link);
	}
}

function delsongs()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	global $lng_id;
	$son_id=form_get("son_id");
	foreach($son_id as $id)	{
		$sql_query="select * from songs where s_id='$id'";
		$song=sql_execute($sql_query,'get');
		if(file_exists($song->s_name))	@unlink($song->s_name);		
		$sql_query="delete from songs where s_id='$id'";
		sql_execute($sql_query,'');
	}
	$link="index.php?mode=mypage&act=managesongs&rec_id=$rec_id&lng=$lng_id";
	show_screen($link);
}

function profile()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$done=form_get("done");
	if(empty($done))	{
		$sql_query="select * from musicprofile where mem_id='$m_id'";
		$pro=sql_execute($sql_query,'get');
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_EDT_M_PRO?></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="20"></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="left"><table height="20" width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr align="center"> 
                      <td class="td-lined"><a href="index.php?mode=mypage&lng=<?=$lng_id?>"><?=LNG_MYPAGE_BZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=music&lng=<?=$lng_id?>"><?=LNG_MYPAGE_CZ?></a></td>
                      <td class="td-lined-top td-lined-right td-lined-left td-shade"><strong><?=LNG_MUSIC_PROFILE?></strong></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=basic&lng=<?=$lng_id?>"><?=LNG_MYPAGE_DZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=shows&lng=<?=$lng_id?>"><?=LNG_MYPAGE_EZ?></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr> 
    <td valign="top" class="lined"> <form method="post" action="index.php" enctype="multipart/form-data">
        <table width="75%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
          <tr> 
            <td width="50%"><strong><?=LNG_MYPAGE_HEADLINE?>:</strong></td>
            <td width="50%" height="25"><input name="headline" type="text" value="<?=stripslashes($pro->headline)?>"></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MUSIC_BAND_BIO?>:</strong></td>
            <td><textarea name="bandbio" cols="25" rows="3"><?=stripslashes($pro->bandbio)?></textarea></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_PROFILE_BND_MEM?>:</strong><br><span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
            <td><textarea name="bandmembers" cols="25" rows="3"><?=stripslashes($pro->bandmembers)?></textarea></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_PROFILE_INFLU?>:</strong><br><span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
            <td><textarea name="influences" cols="25" rows="3"><?=stripslashes($pro->influences)?></textarea></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_PROFILE_SND_LIKE?>:</strong><br><span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
            <td><textarea name="soundslike" cols="25" rows="3"><?=stripslashes($pro->soundslike)?></textarea></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_PROFILE_RCD_LVL?>:</strong></td>
            <td><input name="recordlabel" type="text" value="<?=stripslashes($pro->recordlabel)?>"></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_AAA?>:</strong></td>
            <td><select name="labeltype">
				<option value="None" <? echo selected("None",$pro->labeltype); ?>><?=LNG_MYPAGE_NONE?></option>
				<option value="Major" <? echo selected("Major",$pro->labeltype); ?>><?=LNG_MYPAGE_MAJOR?></option>
				<option value="Indie" <? echo selected("Indie",$pro->labeltype); ?>><?=LNG_MYPAGE_INDIE?></option>
				<option value="Self-Produced" <? echo selected("Self-Produced",$pro->labeltype); ?>><?=LNG_MYPAGE_SPFF?></option>
			</select>
			</td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_UR_PF?>:</strong></td>
            <td><textarea name="styles" cols="25" rows="3"><?=stripslashes($pro->styles)?></textarea></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_MYPAGE_UBB?>:</strong><br><span class="orangebody"><?=LNG_MYPAGE_NOTE?>.</span></td>
            <td><input type="file" name="photo" size="20"></td>
          </tr>
          <tr>
            <td colspan="2" height="3"> <input type="hidden" name="mode" value="mypage"> 
              <input type="hidden" name="act" value="profile"> 
              <input type="hidden" name="done" value="done"> </td>
          </tr>
          <tr align="center"> 
            <td colspan="2"><input type="submit" class="button" value="<?=LNG_MYPAGE_MDS?>"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
<?
		show_footer();
	}	else	{
		global $_FILES;
		$headline=form_get("headline");
		$bandbio=form_get("bandbio");
		$bandmembers=form_get("bandmembers");
		$influences=form_get("influences");
		$soundslike=form_get("soundslike");
		$recordlabel=form_get("recordlabel");
		$labeltype=form_get("labeltype");
		$styles=form_get("styles");
		$tmpfname=$_FILES['photo']['tmp_name'];
		$ftype=$_FILES['photo']['type'];
		$fsize=$_FILES['photo']['size'];
		if(!empty($tmpfname))	{
			$sql_query="select banner from musicprofile where mem_id='$m_id'";
			$bann=sql_execute($sql_query,'get');
			if(file_exists($bann->banner))	@unlink($bann->banner);
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old="music/".$newname.$p_type;
			$thumb1="music/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,$old);
			if($p_type==".jpeg")	$srcImage = ImageCreateFromJPEG( $old );
			elseif($p_type==".gif")	$srcImage = ImageCreateFromGIF( $old );
			$sizee=getimagesize($old);
			$srcwidth=$sizee[0];
			$srcheight=$sizee[1];
			$destwidth1=450;
			$destheight1=220;
			$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
			ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
			if($p_type==".jpeg")	ImageJpeg($destImage1, $thumb1, 80);
			elseif($p_type==".gif")	ImageGif($destImage1, $thumb1, 80);
			ImageDestroy($srcImage);
			ImageDestroy($destImage1);
			if(file_exists($old))	@unlink($old);
			//updating db
			$photo_thumb="music/".$newname_th.".jpeg";
		}	else	{
			$sql_query="select banner from musicprofile where mem_id='$m_id'";
			$bann=sql_execute($sql_query,'get');
			$photo_thumb=$bann->banner;
		}
		$sql_query="update musicprofile set headline='".addslashes($headline)."',bandbio='".addslashes($bandbio)."',bandmembers='".addslashes($bandmembers)."',influences='".addslashes($influences)."',soundslike='".addslashes($soundslike)."',recordlabel='".addslashes($recordlabel)."',labeltype='".addslashes($labeltype)."',styles='".addslashes($styles)."',banner='$photo_thumb' where mem_id='$m_id'";
		sql_execute($sql_query,'');
		$link="index.php?mode=mypage&act=profile&lng=$lng_id";
		show_screen($link);
	}
}

function basic()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$done=form_get("done");
	if(empty($done))	{
		$sql_query="select * from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		$sql_query="select * from rapzones order by rapzone";
		$res=sql_execute($sql_query,'res');
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_EPBI?></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="20"></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="left"><table height="20" width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr align="center"> 
                      <td class="td-lined"><a href="index.php?mode=mypage&lng=<?=$lng_id?>"><?=LNG_MYPAGE_BZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=music&lng=<?=$lng_id?>"><?=LNG_MYPAGE_CZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=profile&lng=<?=$lng_id?>"><?=LNG_MUSIC_PROFILE?></a></td>
                      <td class="td-lined-top td-lined-right td-lined-left td-shade"><strong><?=LNG_MYPAGE_DZ?></strong></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=shows&lng=<?=$lng_id?>"><?=LNG_MYPAGE_EZ?></a></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr> 
    <td valign="top" class="lined"> <form method="post" action="index.php">
        <table width="75%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
          <tr> 
            <td width="50%"><strong><?=LNG_COUNTRY?>:</strong></td>
            <td width="50%" height="25"><select name="country"><? country_drop(stripslashes($mem->country)); ?></select></td>
          </tr>
          <tr> 
            <td width="50%"><strong><?=LNG_MYPAGE_RPZONE?>:</strong></td>
            <td width="50%" height="25"><select name="rapzone">
			<?
				echo "<option value=\"All\"".selected("All",$mem->rapzone)."><?=LNG_MYPAGE_ALL?></option>";
				if(mysql_num_rows($res))	{
					while($row=mysql_fetch_object($res))	{
						echo "<option value='".stripslashes($row->rapzone)."'";
						echo selected(stripslashes($row->rapzone),$mem->rapzone);
						echo ">".stripslashes($row->rapzone)."</option>";
					}
				}
			?></select></td>
          </tr>
          <tr> 
            <td width="50%"><strong><?=LNG_MYPAGE_ZIPCODE?>:</strong></td>
            <td width="50%" height="25"><input type="text" name="zip" value="<?=stripslashes($mem->zip)?>"></td>
          </tr>
          <tr>
            <td colspan="2" height="3"> <input type="hidden" name="mode" value="mypage"> 
              <input type="hidden" name="act" value="basic"> 
              <input type="hidden" name="done" value="done"> </td>
          </tr>
          <tr align="center"> 
            <td colspan="2"><input type="submit" class="button" value="<?=LNG_MYPAGE_MDS?>"></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
<?
		show_footer();
	}	else	{
		$country=form_get("country");
		$rapzone=form_get("rapzone");
		$zip=form_get("zip");
		$sql_query="update members set country='".addslashes($country)."',rapzone='".addslashes($rapzone)."',zip='".addslashes($zip)."' where mem_id='$m_id'";
		sql_execute($sql_query,'');
		$link="index.php?mode=mypage&act=basic&lng=$lng_id";
		show_screen($link);
	}
}

function shows()	{
	$m_id=cookie_get("mem_id");
	global $lng_id;
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	$done=form_get("done");
	if(empty($done))	{
		if(!empty($rec_id))	{
			$sql_query="select * from shows where id='$rec_id'";
			$show=sql_execute($sql_query,'get');
			if(!empty($show->showdate))	{
				$sdate=date("m/d/Y",$show->showdate);
				$hr=date("h",$show->showdate);
				$mins=date("i",$show->showdate);
				$ampm=date("a",$show->showdate);
				$secs=date("s",$show->showdate);
				$venue=$show->venue;
				$cost=$show->cost;
				$address=$show->address;
				$city=$show->city;
				$state=$show->state;
				$country=$show->country;
				$zip=$show->zip;
				$description=$show->description;
			}	else	{
				$sdate=date("m/d/Y");
				$hr=date("h");
				$mins=date("i");
				$ampm=date("a");
				$secs=date("s");
				$venue="";
				$cost="";
				$address="";
				$city="";
				$state="";
				$country="";
				$zip="";
				$description="";
			}
		}	else	{
			$sdate=date("m/d/Y");
			$hr=date("h");
			$mins=date("i");
			$ampm=date("a");
			$secs=date("s");
		}
		$page=form_get("page");
		if(empty($page))	$page=1;
		$start=($page-1)*20;
		$sql_query="select * from shows where mem_id='$m_id' order by id desc limit $start,20";
		$p_sql="select id from shows where mem_id='$m_id' order by id desc";
		$res=sql_execute($sql_query,'res');
		$p_url="index.php?mode=mypage&act=shows&lng=$lng_id";
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_EPNEW?></td>
  </tr>
  <tr> 
    <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="20"></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="left"><table height="20" width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr align="center"> 
                      <td class="td-lined"><a href="index.php?mode=mypage&lng=<?=$lng_id?>"><?=LNG_MYPAGE_BZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=music&lng=<?=$lng_id?>"><?=LNG_MYPAGE_CZ?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=profile&lng=<?=$lng_id?>"><?=LNG_MUSIC_PROFILE?></a></td>
                      <td class="td-lined"><a href="index.php?mode=mypage&act=basic&lng=<?=$lng_id?>"><?=LNG_MYPAGE_DZ?></a></td>
                      <td class="td-lined-top td-lined-right td-lined-left td-shade"><strong><?=LNG_MYPAGE_EZ?></strong></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr> 
    <td valign="top" class="lined"> <form method="post" action="index.php" name="form1">
        <table width="75%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
          <? if(!empty($rec_id)) { ?>
          <tr> 
            <td align="right" colspan="4" style="padding-right: 7">[<a href="index.php?mode=mypage&act=shows&lng=<?=$lng_id?>"><?=LNG_MYPAGE_NEWSHOW?></a>]</td>
          </tr>
          <? } ?>
          <script language="JavaScript1.2">
function del()	{
	gfPop.fStartPop(document.form1.sdate,Date);
}
</script>
          <tr> 
            <td width="14%"><strong><?=LNG_MYPAGE_SHOW_DATE?>:</strong></td>
            <td width="35%"><input name="sdate" value="<?=$sdate?>" size="15" onfocus="this.blur()" readonly> 
              <a href="javascript:void(0)" onclick="javascript:del();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
            <td width="16%" height="25" style="padding-left: 10"><strong><?=LNG_MYPAGE_STT?>:</strong></td>
            <td width="35%"> <select name="hr">
                <? echo hr($hr); ?> 
              </select>
				&nbsp;:&nbsp;<select name="mins">
                <? echo mins($mins); ?> 
              </select>
				&nbsp;&nbsp;&nbsp;<select name="secs">
                <? echo mins($secs); ?> 
              </select></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_SHOWS_VENUE?>:</strong>&nbsp;&nbsp;<span class="orangebody"><?=LNG_LISTING_REQUIRED?></span></td>
            <td height="25" colspan="2"><input type="text" name="venue" value="<?=stripslashes($venue)?>"></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_SHOWS_COST?>:</strong></td>
            <td height="25" colspan="2"><input type="text" name="cost" size="7" value="<?=stripslashes($cost)?>"></td>
          </tr>
          <tr>
            <td colspan="2"><strong><?=LNG_MYPAGE_ADR?>:</strong></td>
            <td height="25" colspan="2"><input type="text" name="address" value="<?=stripslashes($address)?>"></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_CITY?>:</strong></td>
            <td height="25" colspan="2"><input type="text" name="city" value="<?=stripslashes($city)?>"></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_STATE?>:</strong></td>
            <td height="25" colspan="2"><input type="text" name="state" value="<?=stripslashes($state)?>"></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_COUNTRY?>:</strong></td>
            <td height="25" colspan="2"><select name="country"><? country_drop($country); ?></select></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_MYPAGE_ZIPCODE?>:</strong></td>
            <td height="25" colspan="2"><input type="text" name="zip" value="<?=stripslashes($zip)?>"></td>
          </tr>
          <tr> 
            <td colspan="2"><strong><?=LNG_DESCRIPTION?>:</strong></td>
            <td height="25" colspan="2"><textarea name="description" cols="25" rows="3"><?=stripslashes($description)?></textarea></td>
          </tr>
          <tr> 
            <td colspan="4" height="3"> <input type="hidden" name="mode" value="mypage"> 
              <input type="hidden" name="act" value="shows"> 
              <? if(!empty($rec_id)) { ?>
              <input type="hidden" name="rec_id" value="<?=$rec_id?>"> 
              <? } ?>
              <input type="hidden" name="done" value="done"> </td>
          </tr>
          <tr align="center"> 
            <td colspan="4"><input type="submit" class="button" value=" <? if(!empty($rec_id)) { ?><?=LNG_MYPAGE_MDS?><? } else { ?><?=LNG_MYPAGE_ATL?><? } ?> "></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr><td height="5"></td></tr>
<? if(mysql_num_rows($res)) { ?>
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MYPAGE_ASHOWS?> &raquo;</td>
  </tr>
  <tr> 
    <td valign="top">
        <table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" class="body">
		  <tr><td colspan="3" height="1" class="title"></td></tr>
<? while($row=mysql_fetch_object($res)) { ?>
	      <tr> 
            <td style="paddinf-left: 5">
			<strong><? echo date("D M j G:i:s Y",$row->showdate); ?> - <?=stripslashes($row->venue)?></strong> <? if(!empty($row->cost)) { ?>{<?=stripslashes($row->cost)?>}<? } ?><br>
			<? if(!empty($row->address)) { ?><?=stripslashes($row->address)?>, <? } ?><? if(!empty($row->city)) { ?><?=stripslashes($row->city)?><br><? } ?>
			<? if(!empty($row->state)) { ?><?=stripslashes($row->state)?>, <? } ?><? if(!empty($row->country)) { ?><?=stripslashes($row->country)?> <? } ?><? if(!empty($row->zip)) { ?>- <?=stripslashes($row->zip)?><? } ?><br>
			<span style="padding-left: 17"><?=stripslashes($row->description)?></span>
			</td>
          </tr>
		  <tr><td align="right" style="padding-right: 17">
		  [<a href="index.php?mode=mypage&act=shows&rec_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>]&nbsp;
		  [<a href="index.php?mode=mypage&act=delshows&rec_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>]</td></tr>
		  <tr><td colspan="3" height="1" class="title"></td></tr>
<? } ?>
        </table>
      </td>
  </tr>
  <tr> 
    <td height="20" align="right" class="body" style="padding-right: 12"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
<? } ?>
</table>
<iframe width=168 height=175 name="gToday:normal:styles/agenda.js" id="gToday:normal:styles/agenda.js" src="styles/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
<?
		show_footer();
	}	else	{
		$sdate=form_get("sdate");
		$hr=form_get("hr");
		$mins=form_get("mins");
		$secs=form_get("secs");
		$venue=form_get("venue");
		$cost=form_get("cost");
		$address=form_get("address");
		$city=form_get("city");
		$state=form_get("state");
		$country=form_get("country");
		$zip=form_get("zip");
		$description=form_get("description");
		$tmp=split("/",$sdate);
		$m=$tmp[0];
		$d=$tmp[1];
		$y=$tmp[2];
		$showdate=mktime($hr,$mins,$secs,$m,$d,$y);
		$chkdate=mktime(0,0,0,$m,$d,$y);
		$chkdate1=mktime(0,0,0,date("m"),date("d"),date("Y"));
		if((empty($venue)) || (empty($sdate)) || ($chkdate<$chkdate1))	{
			$link="index.php?mode=mypage&act=shows";
			if(!empty($rec_id))	$link.="&rec_id=$rec_id&lng=$lng_id";
		}	else	{
			$now=time();
			if(empty($rec_id))	$sql_query="insert into shows (mem_id,showdate,venue,cost,address,city,state,country,zip,description,date) values ('$m_id','$showdate','".addslashes($venue)."','".addslashes($cost)."','".addslashes($address)."','".addslashes($city)."','".addslashes($state)."','".addslashes($country)."','".addslashes($zip)."','".addslashes($description)."','$now')";
			else	$sql_query="update shows set showdate='$showdate',venue='".addslashes($venue)."',cost='".addslashes($cost)."',address='".addslashes($address)."',city='".addslashes($city)."',state='".addslashes($state)."',country='".addslashes($country)."',zip='".addslashes($zip)."',description='".addslashes($description)."' where id='$rec_id'";
			sql_execute($sql_query,'');
			$link="index.php?mode=mypage&act=shows";
			if(!empty($rec_id))	$link.="&rec_id=$rec_id&lng=$lng_id";
		}
		show_screen($link);
	}
}

function delshows()	{
	$m_id=cookie_get("mem_id");
	global $lng_id;
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	$sql_query="delete from shows where id='$rec_id'";
	sql_execute($sql_query,'');
	$link="index.php?mode=mypage&act=shows&lng=$lng_id";
	show_screen($link);
}
?>
