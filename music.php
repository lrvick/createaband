<?php
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
if(empty($act))	 songs();
elseif($act=='direct')	direct();
elseif($act=='songlist')	songlist();
elseif($act=='top')	topalbs();

function songs()	{
	
	global $lng_id;
	
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	//login_test($m_id,$m_pass);
	show_header();
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="46%" valign="top"><form action="index.php?lng=<?=$lng_id?>" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td class="title" width="98%" align="left" style="padding-right: 12"><?=LNG_MUSIC_SRC_ARTIST?></td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="homelined">
          <tr align="center"> 
            <td height="3" colspan="2"></td>
          </tr>
          <tr> 
            <td width="37%" height="20" style="padding-left: 5"><?=LNG_KEYWORDS?>:</td>
            <td width="63%" height="20"><input name="key" type="text"></td>
          </tr>
          <tr> 
            <td width="37%" height="20" style="padding-left: 5"><?=LNG_CATEGORY?>:</td>
            <td width="63%" height="20"><select name="search_term">
                <option value=""><?=LNG_MUSIC_SELECT?></option>
                <option value="bandname"><?=LNG_MUSIC_BRAND_NAME?></option>
                <option value="bandbio"><?=LNG_MUSIC_BAND_BIO?></option>
                <option value="bandmembers"><?=LNG_PROFILE_BND_MEM?></option>
                <option value="influences"><?=LNG_PROFILE_INFLU?></option>
                <option value="soundslike"><?=LNG_PROFILE_SND_LIKE?></option>
              </select></td>
          </tr>
          <tr align="center"> 
            <td height="20" colspan="2">&#8212;&#8212;&#8212;&#8212;&#8212;&nbsp;&nbsp;And/Or&nbsp;&nbsp;&#8212;&#8212;&#8212;&#8212;&#8212;</td>
          </tr>
          <tr> 
            <td width="37%" height="20" style="padding-left: 5"><?=LNG_MUSIC_GRENE?> :</td>
            <td width="63%" height="20"><select name="m_cat">
                <? echo show_music_cat(0); ?></select></td>
          </tr>
          <tr> 
            <td width="37%" height="20" style="padding-left: 5"><?=LNG_LOCATION?> :</td>
            <td width="63%" height="20">
            	<select name="country">
            	<?
            		//echo "<br>>> " . $m_id;
            		//echo "<br>>>>> " . show_flag($m_id);

            		 country_drop(show_flag($m_id)); ?>
            	</select>
            </td>
          </tr>
          <tr align="center"> 
            <td height="20" colspan="2" style="padding-left: 5"> 
              <input name="act" type="hidden" value="music"> <input name="mode" type="hidden" value="search"> 
              <input type="submit" class="button" name="Submit" value="<?=LNG_SEARCH?>"></td>
          </tr>
          <tr align="center"> 
            <td height="10" colspan="2"></td>
          </tr>
        </table>
      </form>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td class="title" width="98%" align="left" style="padding-right: 12"><?=LNG_MUSIC_RECENT_ALBUM?></td>
          </tr>
        </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="4" class="homelined">
        <tr align="center"> 
          <td height="3"></td>
        </tr>
        <tr> 
          <td style="padding-left: 5" valign="top"><? echo recent_album(); ?></td>
        </tr>
        <tr align="center"> 
          <td height="10"></td>
        </tr>
      </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td height="15" colspan="2"></td></tr>
          <tr> 
            <td class="title" width="98%" align="left" style="padding-right: 12"><?=LNG_MUSIC_COOL_ALBUM?></td>
          </tr>
        </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="4" class="homelined">
        <tr align="center"> 
          <td height="3"></td>
        </tr>
        <tr> 
          <td style="padding-left: 5" valign="top"><? echo cool_album(); ?></td>
        </tr>
        <tr align="center"> 
          <td height="10"></td>
        </tr>
      </table>
	  </td>
    <td width="54%" valign="top" align="right" style="padding-left: 7">
	<table width="450" border="0" cellspacing="0" cellpadding="0">
	<tr><td class="title" align="left" width="98%" style="padding-right: 12"><?=LNG_MUSIC_FEAT_ARTIST?></td>
        </tr>
	</table>
	  <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td valign="top" align="center" class="lined"><? echo fetaured_art(); ?></td>
        </tr>
	  </table>
	<table width="450" border="0" cellspacing="0" cellpadding="0">
	<tr><td height="20"></td></tr>
	<tr><td class="title" height="20" align="left" width="98%" style="padding-right: 12"><?=LNG_TOP_ALBUM?></td></tr>
	</table>
	  <table width="450" border="0" cellspacing="0" cellpadding="0" class="homelined">
        <tr> 
          <td valign="top" align="center" class="lined"><? echo show_top(); ?></td>
        </tr>
	  </table>
	</td>
  </tr>
</table>
<?
	show_footer();
}
function show_top()	{
	
	global $lng_id;
	
	$m_id=cookie_get("mem_id");
	$sql_query="select * from musics where top_alb='y' limit 0,10";
	$res=sql_execute($sql_query,'res');
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<?
	if(mysql_num_rows($res))	{
		$s=0;
		while($son=mysql_fetch_object($res))	{ 
			if($s==0)	{
?>
	<tr>
<?
			}
?>
	<td align="center" width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="dark body bodytip" style="padding: 5">
	<tr><td>
	<? if(!empty($son->photo_thumb)) { ?><img src="<?=$son->photo_thumb?>" border="0" align="left"><span style="padding-left: 5"><? } ?>
	<a href="index.php?mode=music&act=songlist&mu_id=<?=$son->m_id?>&lng=<?=$lng_id?>"><strong><?=stripslashes($son->m_title)?></strong></a><br>
	<? echo musical_genre($son->m_own); ?>
	<? if(!empty($son->photo_b_thumb)) { ?></span><? } ?>
	</td></tr>
	</table></td>
<?
			$s++;
			if($s==2)	{
?>
				</tr>
<?
				$s=0;
			}
		}
	}
?>
</table>
<?
}

function direct()	{
	
	global $lng_id;
	
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$page=form_get("page");
	if(empty($page))	$page=1;
	$instr=form_get("instr");
	$m_cat=form_get("m_cat");
	$m_title=form_get("m_title");
	$start=($page-1)*20;
	if((!empty($instr))|| ($instr=='#'))	$sql_1=" where m_title like '".$instr."%'";
	$sql_query="select * from musics".$sql_1;
	$p_sql="select m_id from musics".$sql_1;
	if(!empty($instr))	{
		if(!empty($m_cat))	{
			$sql_cat="select mem_id from musicprofile where genre1='$m_cat' or genre2='$m_cat' or genre3='$m_cat'";
			$res_cat=sql_execute($sql_cat,'res');
			if(mysql_num_rows($res_cat))	{
				while($row_cat=mysql_fetch_object($res_cat))	{
					$ins_cat.=" or m_own='$row_cat->mem_id'";
				}
				$ins_cat=ltrim($ins_cat,' or ');
				$ins_cat=rtrim($ins_cat,' or ');
				$sql_query.=" and (".$ins_cat.")";
				$p_sql.=" and (".$ins_cat.")";
			}
		}
		if(!empty($m_title))	{
			$sql_query.=" and m_title='".addslashes($m_title)."'";
			$p_sql.=" and m_title='".addslashes($m_title)."'";
		}
	}	else	{
		if(!empty($m_cat))	{
			$sql_cat="select mem_id from musicprofile where genre1='$m_cat' or genre2='$m_cat' or genre3='$m_cat'";
			$res_cat=sql_execute($sql_cat,'res');
			if(mysql_num_rows($res_cat))	{
				while($row_cat=mysql_fetch_object($res_cat))	{
					$ins_cat.=" or m_own='$row_cat->mem_id'";
				}
				$ins_cat=ltrim($ins_cat,' or ');
				$ins_cat=rtrim($ins_cat,' or ');
				$sql_query.=" and (".$ins_cat.")";
				$p_sql.=" and (".$ins_cat.")";
			}
			if(!empty($m_title))	{
				$sql_query.=" and m_title='".addslashes($m_title)."'";
				$p_sql.=" and m_title='".addslashes($m_title)."'";
			}
		}	else	{
			if(!empty($m_title))	{
				$sql_query.=" where m_title='".addslashes($m_title)."'";
				$p_sql.=" where m_title='".addslashes($m_title)."'";
			}
		}
	}
	$sql_query.=" limit $start,20";
	$res=sql_execute($sql_query,'res');
	$p_url="index.php?mode=music&act=direct&instr=$instr&m_cat=$m_cat&m_title=$m_title&lng=$lng_id";
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="padded-6">
  <tr> 
    <td class="title" height="25" style="padding-left: 7"><?=LNG_MUSIC_DIRECT?></td>
  </tr>
  <tr> 
    <td height="3"></td>
  </tr>
  <tr> 
    <td align="center" valign="top">
	<form action="index.php" method="post">
	    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
          <tr> 
            <td align="center"></td>
          </tr>
          <tr> 
            <td height="20" align="center"> <a href="index.php?mode=music&act=direct&instr=a&lng=<?=$lng_id?>"><?=LNG_MUSIC_A?></a> 
              <a href="index.php?mode=music&act=direct&instr=b&lng=<?=$lng_id?>"><?=LNG_MUSIC_B?></a> <a href="index.php?mode=music&act=direct&instr=c&lng=<?=$lng_id?>"><?=LNG_MUSIC_C?></a> 
              <a href="index.php?mode=music&act=direct&instr=d&lng=<?=$lng_id?>"><?=LNG_MUSIC_D?></a> <a href="index.php?mode=music&act=direct&instr=e&lng=<?=$lng_id?>"><?=LNG_MUSIC_E?></a> 
              <a href="index.php?mode=music&act=direct&instr=f&lng=<?=$lng_id?>"><?=LNG_MUSIC_F?></a> <a href="index.php?mode=music&act=direct&instr=g&lng=<?=$lng_id?>"><?=LNG_MUSIC_G?></a> 
              <a href="index.php?mode=music&act=direct&instr=h&lng=<?=$lng_id?>"><?=LNG_MUSIC_H?></a> <a href="index.php?mode=music&act=direct&instr=i&lng=<?=$lng_id?>"><?=LNG_MUSIC_I?></a> 
              <a href="index.php?mode=music&act=direct&instr=j&lng=<?=$lng_id?>"><?=LNG_MUSIC_J?></a> <a href="index.php?mode=music&act=direct&instr=k&lng=<?=$lng_id?>"><?=LNG_MUSIC_K?></a> 
              <a href="index.php?mode=music&act=direct&instr=l&lng=<?=$lng_id?>"><?=LNG_MUSIC_L?></a> <a href="index.php?mode=music&act=direct&instr=m&lng=<?=$lng_id?>"><?=LNG_MUSIC_M?></a> 
              <a href="index.php?mode=music&act=direct&instr=n&lng=<?=$lng_id?>"><?=LNG_MUSIC_N?></a> <a href="index.php?mode=music&act=direct&instr=o&lng=<?=$lng_id?>"><?=LNG_MUSIC_O?></a> 
              <a href="index.php?mode=music&act=direct&instr=p&lng=<?=$lng_id?>"><?=LNG_MUSIC_P?></a> <a href="index.php?mode=music&act=direct&instr=q&lng=<?=$lng_id?>"><?=LNG_MUSIC_Q?></a> 
              <a href="index.php?mode=music&act=direct&instr=r&lng=<?=$lng_id?>"><?=LNG_MUSIC_R?></a> <a href="index.php?mode=music&act=direct&instr=s&lng=<?=$lng_id?>"><?=LNG_MUSIC_S?></a> 
              <a href="index.php?mode=music&act=direct&instr=t&lng=<?=$lng_id?>"><?=LNG_MUSIC_T?></a> <a href="index.php?mode=music&act=direct&instr=u&lng=<?=$lng_id?>"><?=LNG_MUSIC_U?></a> 
              <a href="index.php?mode=music&act=direct&instr=v&lng=<?=$lng_id?>"><?=LNG_MUSIC_V?></a> <a href="index.php?mode=music&act=direct&instr=w&lng=<?=$lng_id?>"><?=LNG_MUSIC_W?></a> 
              <a href="index.php?mode=music&act=direct&instr=x&lng=<?=$lng_id?>"><?=LNG_MUSIC_X?></a> <a href="index.php?mode=music&act=direct&instr=y&lng=<?=$lng_id?>"><?=LNG_MUSIC_Y?></a> 
              <a href="index.php?mode=music&act=direct&instr=z&lng=<?=$lng_id?>"><?=LNG_MUSIC_Z?></a> <a href="index.php?mode=music&act=direct&instr=#&lng=<?=$lng_id?>"><?=LNG_MUSIC_#?></a> 
            </td>
          </tr>
          <tr> 
            <td height="20" align="center" valign="middle">
			<strong><?=LNG_MUSIC_GENERE?>:</strong> <select name="m_cat"><? echo show_music_cat($m_cat); ?></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="hidden" name="mode" value="music"><input type="hidden" name="act" value="direct"><input type="hidden" name="instr" value="<?=$instr?>">
			<strong><?=LNG_MUSIC_BRAND_NAME?>:</strong> <input name="m_title" type="text" value="<?=stripslashes($m_title)?>">&nbsp;&nbsp;<input name="Search" value="<?=LNG_SEARCH?>" type="submit"></td>
          </tr>
        </table>
	</form>
	</td>
  </tr>
<? if(mysql_num_rows($res)) { ?>
  <tr>
    <td class="body" style="padding-left: 7"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top">
<table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr class="lined"> 
          <td height="25" width="15%" class="title" style="padding-left: 7"><?=LNG_ARTIST?></td>
          <td height="25" width="36%" class="title">&nbsp;</td>
          <td height="25" width="49%" class="title" style="padding-left: 7"><?=LNG_MUSIC_GENERE?></td>
        </tr>
<? while($row=mysql_fetch_object($res)) { ?>
        <tr>
          <td class="lined body" align="center" style="padding-left: 3;padding-top: 10;padding-bottom: 10"><? echo show_photo($row->m_own); ?></td>
          <td class="lined body" style="padding-left: 3;padding-top: 10;padding-bottom: 10"><a href="index.php?mode=music&act=songlist&mu_id=<?=$row->m_id?>&lng=<?=$lng_id?>"><?=stripslashes($row->m_title)?></a></td>
          <td class="lined body" style="padding-left: 3;padding-top: 10;padding-bottom: 10"><? echo musical_genre($row->m_own); ?></td>
        </tr>
<? } ?>
        <tr><td colspan="3" height="3"></td></tr>
      </table>
	</td>
  </tr>
  <tr>
    <td class="body" style="padding-left: 7"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
<? } ?>
</table>
<?
	show_footer();
}

function songlist()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mu_id=form_get("mu_id");
	$sql_query="select * from musics where m_id='$mu_id'";
	$muc=sql_execute($sql_query,'get');
	if(!empty($muc->photo_b_thumb))	$img_dis="<img src='$muc->photo_b_thumb' border='0'>";
	else	$img_dis="";
	$sql_query="select count(s_id) as cou from songs where s_sec='$mu_id'";
	$co=sql_execute($sql_query,'get');
	$sql_query="select * from songs where s_sec='$mu_id'";
	$res=sql_execute($sql_query,'res');
	$num=sql_execute($sql_query,'num');
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
  <tr> 
    <td class="title" height="20" style="padding-left: 12"><?=LNG_MUSIC_ALB_DETAILS?> &raquo; <?=stripslashes($muc->m_title)?></td>
  </tr>
  <tr><td height="7"></td></tr>
  <tr> 
    <td align="center" valign="top"><table width="75%" border="0" cellpadding="0" cellspacing="0" class="lined body">
        <? if($num==0)	{ ?>
        <tr> 
          <td align="center"><?=LNG_MUSIC_NO_SONG_ALBUM?></td>
        </tr>
        <? } else { ?>
        <tr> 
          <td align="center">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
		  <tr><td align="center" valign="top">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr> 
                      <td colspan="2" align="left" valign="middle"> 
                        <?=$img_dis?>
                      </td>
                      <td colspan="2" valign="top" style="padding-left: 10">
						<font size="4"><?=stripslashes($muc->m_title)?></font><br>
						<? echo musical_genre($muc->m_own); ?><br>
						<strong><?=LNG_ARTIST?>:</strong> <? echo show_online($muc->m_own); ?><br>
						<strong><?=LNG_COMMENTS?>:</strong><br>
						<?=stripslashes($muc->m_matt)?>
                        </td>
                    </tr>
                    <tr><td colspan="4" height="3" class="title"></td></tr>
                    <tr><td colspan="4" align="right" style="padding-right: 7"><?=$co->cou?> <?=LNG_MUSIC_SONGS?></td></tr>
                    <tr> 
                      <td height="1"></td>
                      <td width="7%" height="1"></td>
                      <td width="44%" height="1"></td>
                      <td width="45%" height="1"></td>
                    </tr>
                    <tr><td colspan="4" align="center">
					<? echo play_song($mu_id); ?>
					</td></tr>
                    <tr><td colspan="4" height="5"></td></tr>
                  </table>
			</td></tr></table>
			</td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
  <tr><td height="5"></td></tr>
 </table>
<?
	show_footer();
}

function topalbs()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$sql_query="select * from musics where top_alb='y'";
	$res=sql_execute($sql_query,'res');
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="title" height="20" style="padding-left: 12"><?=LNG_TOP_ALBUM?></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
<tr> 
  <td valign="top" align="center" class="lined">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<?
	if(mysql_num_rows($res))	{
		$s=0;
		while($son=mysql_fetch_object($res))	{ 
			if($s==0)	{
?>
	<tr>
<?
			}
?>
	<td align="center" width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="dark body bodytip" style="padding: 5">
	<tr><td>
	<? if(!empty($son->photo_b_thumb)) { ?><img src="<?=$son->photo_b_thumb?>" border="0" align="left"><span style="padding-left: 5"><? } ?>
	<a href="index.php?mode=music&act=songlist&mu_id=<?=$son->m_id?>&lng=<?=$lng_id?>"><strong><?=stripslashes($son->m_title)?></strong></a><br>
	<? echo musical_genre($son->m_own); ?>
	<? if(!empty($son->photo_b_thumb)) { ?></span><? } ?>
	</td></tr>
	</table></td>
<?
			$s++;
			if($s==2)	{
?>
				</tr>
<?
				$s=0;
			}
		}
	}
?>
</table>
  </td>
</tr>
</table>
<?
	show_footer();
}


/*
//showing country drop-down list
function country_drop($val)	
{
	if(empty($val))	
	{
		$val=LNG_US;
	}
	
	$country=array(LNG_AFGAN,LNG_ALBANIA,LNG_ALGERIA,LNG_AS,LNG_ANDORRA,LNG_ANGOLA,LNG_ANGUILIA,LNG_ANTERTICA,LNG_AB,LNG_ARGENTINA,LNG_ARMENIA,LNG_ARUBA,LNG_AI,LNG_AUSTRALIA,LNG_AUSTRIA,LNG_AZ,LNG_BAHAMAS,LNG_BAHRAIN,LNG_BANGLADESH,LNG_BARBADOS,LNG_BELARUS,LNG_BELGIUM,LNG_BELIZE,LNG_BENIN,LNG_BERMUDA,LNG_BHUTAN,LNG_BOLIVIA,LNG_BOTSWANA,LNG_BI,LNG_BRAZIL,LNG_BD,LNG_BULGARIA,LNG_B_FASO,LNG_BURUNDI,LNG_CAMBODIA,LNG_CAMEROON,LNG_CANADA,LNG_CVI,LNG_CI,LNG_CHAD,LNG_CHILE,LNG_CHINA,LNG_C_ILAND,LNG_COLOMBIA,LNG_COMOROS,LNG_CRO,LNG_COOK_I,LNG_COSTA_RICA,LNG_COTE_D_IVOIRE,LNG_CROATIA,LNG_CYPRUS,LNG_CZECH,LNG_DENMARK,LNG_DJBOUTI,LNG_DOMINICA,LNG_DOMINICAN,LNG_EAST_TIMOR,LNG_ECUADOR,LNG_EGYPT,LNG_EL_SALVA,LNG_EQ_GUINEA,LNG_ERITREA,LNG_ESTONIA,LNG_ETHIOP,LNG_FALKAN_IS,LNG_FAROE,LNG_FIJI,LNG_FINLAND,LNG_FRANCE,LNG_FRENCHG,LNG_FRENCHP,LNG_GABON,LNG_GAMBIA,LNG_GEORGIA,LNG_GERMANY,LNG_GHANA,LNG_GIBRA,LNG_GREECE,LNG_GREENLND,LNG_GRENADA,LNG_GUADE,LNG_GUAM,LNG_GAUTE,LNG_GUERNSEY,LNG_GUINEA,LNG_GUINEAB,LNG_GUYANA,LNG_HAITI,LNG_HONDU,LNG_HK,LNG_HUNGARY,LNG_ICELAND,LNG_INDIA,LNG_INDONES,LNG_IRAN,LNG_IRELAND,LNG_ISLEMAN,LNG_ISRAEL,LNG_ITALY,LNG_JAMAICA,LNG_JAPAN,LNG_JERSEY,LNG_JORDAN,LNG_KAZAK,LNG_KENYA,LNG_KIRIBA,LNG_KORIA_REP,LNG_KUWAIT,LNG_KYRGY,LNG_LAOS,LNG_LAT,LNG_LEBANON,LNG_LESOTHO,LNG_LIBERIA,LNG_LIBYA,LNG_LIECHT,LNG_LIHU,LNG_LUXEM,LNG_MACAU,LNG_MACEDONIA,LNG_MADAGASCAR,LNG_MALAWI,LNG_MALAY,LNG_MALDIVES,LNG_MALI,LNG_MALTA,LNG_MARSHAL_IS,LNG_MARTINI,LNG_MAURITANIA,LNG_MAURI,LNG_MAYOTTE_IS,LNG_MEXICO,LNG_MICRONESIA,LNG_MOLDOVA,LNG_MONACO,LNG_MONGOL,LNG_MONTS,LNG_MOROCO,LNG_MOZAMBQ,LNG_MYANMAR,LNG_NAMBIA,LNG_NAURU,LNG_NEPAL,LNG_NETH,LNG_NETH_ANTI,LNG_NEWCALE,LNG_NEWZEA,LNG_NICAR,LNG_NIGER,LNG_NIGERIA,LNG_NIUE,LNG_NORFOLK_IS,LNG_NORWAY,LNG_OMAN,LNG_PAKI,LNG_PALAU,LNG_PANAMA,LNG_PAPUA,LNG_PARAGUAY,LNG_PERU,LNG_PHILIPS,LNG_PITC_IS,LNG_POLAND,LNG_PORTUGAL,LNG_PUERTO_RICO,LNG_QATAR,LNG_REUNION_IS,LNG_ROMANIA,LNG_RUSS_FED,LNG_RAWANDA,LNG_SAINTHELENA,LNG_SAINTLUCIA,LNG_SANMARINO,LNG_SARAB,LNG_SENGAL,LNG_SEYCHELL,LNG_SIERA_LE,LNG_SPORE,LNG_SLOV_REP,LNG_SOLVE,LNG_SOLO_IL,LNG_SOMALIA,LNG_SAFRICA,LNG_SGEORGIA,LNG_SPAIN,LNG_LANKA,LNG_SURINAM,LNG_SVALB,LNG_SWAZI,LNG_SWEDEN,LNG_SWITZ,LNG_SYRIA,LNG_TAIWAN,LNG_TAJIK,LNG_TANZ,LNG_THAI,LNG_TOGO,LNG_TOKELAU,LNG_TONGAI,LNG_TUNISI,LNG_TURKEY,LNG_TURKMS,LNG_TUVALU,LNG_UGND,LNG_UKRN,LNG_UK,LNG_USA,LNG_URUGUA,LNG_UZBEK,LNG_VANUA,LNG_VATI,LNG_VENEZ,LNG_VIET,LNG_WSHARA,LNG_WSAMO,LNG_YEMEN,LNG_YUGO,LNG_ZAMB,LNG_ZIMB);
	
	//$country = array('india','china');
	
	//for($i=0; $i<=count($country)-1; $i++)	
	foreach ($country as $var)
	{
?>		
		<option value="<?=$var?>" <?=getSelected($var,$val)?> > <?=$var?> </option>
<?
	}
}
*/

?>
