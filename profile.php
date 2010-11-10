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

global $main_url;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$p_id=form_get("p_id");
$sql_query="select * from members where mem_id='$p_id'";
$mem=sql_execute($sql_query,'get');
$sql_query="select * from profiles where mem_id='$p_id'";
$pro=sql_execute($sql_query,'get');
$sql_query="select * from musicprofile where mem_id='$p_id'";
$musicpro=sql_execute($sql_query,'get');
show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="36%" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="3">
              <tr> 
                <td colspan="2" style="padding-left: 5"> <strong><? echo musical_band($p_id); ?></strong><br> 
                  <span class="small"><? echo musical_genre($p_id); ?></span>
                </td>
              </tr>
              <tr> 
                <td width="50%" align="center"><? echo show_profile_photo($p_id); ?><br><? echo show_online($p_id); ?>
                </td>
                <td width="50%" class="small" valign="middle" style="padding-left: 7">
				"<?=stripslashes($musicpro->headline)?>"<br><br>
				<? echo show_location($p_id); ?><br><>=LNG_PROFILE_ZONE?>: <?=stripslashes($mem->rapzone)?><br><br>
				<?=LNG_PROFILE_PV?>: <? echo show_views($p_id); ?><br>
				<?=LNG_PROFILE_LAST_LGIN?>: <? echo show_visit_like("m/d/Y",$p_id); ?>
				</td>
              </tr>
              <tr>
                <td width="50%" class="body" style="padding-left: 25"> <? echo photo_album_link($p_id); ?></td>
                <td class="small">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="height: 20"></td>
              </tr>
            </table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
				<td class="hometitle" width="98%" style="padding-left: 7"><b><?=LNG_WHT_CAN_U_DO?></b></td>
				<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
			  <tr> 
				<td valign="top">
<?
if($m_id!=$p_id)	{
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"4\" cellpadding=\"4\" class=\"body\">";
	$sql_link="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
	$res=sql_execute($sql_link,'res');
	echo "<tr>";
	if(!mysql_num_rows($res))	{
		echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=bmarks&pro=add&sec_id=$p_id&type=member&lng=$lng_id'>" . LNG_BOOKMARKS . "</a></td>";
	}	else	{
		$bmr=sql_execute($sql_link,'get');
		echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id&lng=$lng_id'>" . LNG_PROFILE_UN_BK_MARK . "</a></td>";
	}
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=messages&act=compose&rec_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_SM . "</a></td>";
	echo "</tr>";
	$sql_link="select * from network where mem_id='$m_id' and frd_id='$p_id'";
	$res=sql_execute($sql_link,'res');
	echo "<tr>";
	if(mysql_num_rows($res))	{
		echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=friends&pro=remove&frd_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_RFR . "</a></td>";
	}	else	{
		$bmr=sql_execute($sql_link,'get');
		echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=friends&pro=add&frd_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_ADD_FRIND . "</a></td>";
	}
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=intro&p_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_MK_INTRO . "</a></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=invite_tribe&p_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_ITG . "</a></td>";
	$sql_query="select ignore_list from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$ignore=split("\|",$mem->ignore_list);
	$ignore=if_empty($ignore);
	if($ignore!='')	{
		$status=0;
		foreach($ignore as $ign)	{
			if($ign==$p_id)	{
				$status=1;
				break;
			}
		}//foreach
	}	else	$status=0;
	if($status==0)	{
		echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=ignore&pro=add&p_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_ADD_IGNORE_LST . "</a></td>";
	}	elseif($status==1)	{
		echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=ignore&pro=del&p_id=$p_id&lng=$lng_id'>" . LNG_PROFILE_RFG . "</a></td>";
	}
	echo "</tr>";
	echo "</table>";
}	else	{
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"4\" cellpadding=\"4\" class=\"body\">";
	echo "<tr><td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=profile&pro=edit&lng=$lng_id'>" . LNG_EDIT_PROFILE . "</a></td>";
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=bmarks&lng=$lng_id'>" . LNG_PROFILE_EDT_BMARK . "</a></td></tr>";
	echo "<tr><td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=ignore&lng=$lng_id'>" . LNG_PROFILE_EDT_I_LST . "</a></td>";
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=listings&lng=$lng_id'>" . LNG_PROFILE_UR_LSTING . "</a></td></tr>";
	echo "<tr><td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=friends&lng=$lng_id'>" . LNG_YOUR_FRIENDS . "</a></td>";
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=listing&act=create&lng=$lng_id'>" . LNG_PROFILE_CRT_LISTING . "</a></td></tr>";
	echo "<tr><td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=messages&act=inbox&lng=$lng_id'>" . LNG_PROFILE_MSG_CNTR . "</a></td>";
	echo "<td style=\"padding-left: 3\"><font size=\"3\" color=\"#FFFFFF\"><strong>&raquo;</strong></font>&nbsp;<a href='index.php?mode=user&act=inv&lng=$lng_id'>" . LNG_INVITE_A_FRIEND . "</a></td></tr>";
	echo "</table>";
}
?>
				</td>
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr><td height="15"></td></tr>
			  <tr>
				<td class="hometitle" height="20" width="98%" style="padding-left: 7"><? echo ucwords(name_header($p_id,$m_id)); ?>'<?=LNG_PROFILE_GENERAL_INFO?></td>
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="5" cellpadding="3" class="homelined">
              <tr> 
                <td valign="top" width="40%"><strong><?=LNG_PROFILE_MS?></strong></td>
                <td valign="top" width="60%"><? echo member_since_like("F j, Y g:i a",$p_id); ?></td>
              </tr>
              <tr> 
                <td valign="top"><strong><?=LNG_PROFILE_BND_WEBSITE?></strong></td>
                <td valign="top"><?=$pro->website?></td>
              </tr>
              <tr> 
                <td valign="top"><strong><?=LNG_PROFILE_BND_MEM?></strong></td>
                <td valign="top"><?=stripslashes($musicpro->bandmembers)?></td>
              </tr>
              <tr> 
                <td valign="top"><strong><?=LNG_PROFILE_INFLU?></strong></td>
                <td valign="top"><?=stripslashes($musicpro->influences)?></td>
              </tr>
              <tr> 
                <td valign="top"><strong><?=LNG_PROFILE_SND_LIKE?></strong></td>
                <td valign="top"><?=stripslashes($musicpro->soundslike)?></td>
              </tr>
              <tr> 
                <td valign="top"><strong><?=LNG_PROFILE_RCD_LVL?></strong></td>
                <td valign="top"><?=stripslashes($musicpro->recordlabel)?></td>
              </tr>
              <tr> 
                <td valign="top"><strong><?=LNG_PROFILE_RCD_TLVL?></strong></td>
                <td valign="top"><?=stripslashes($musicpro->labeltype)?></td>
              </tr>
            </table>
			</td>
          <td width="64%" valign="top" style="padding-left: 5">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr><td height="15"></td></tr>
              <tr> 
                <td align="right" style="padding-right: 7"><? echo auto_play($p_id); ?></td>
              </tr>
              <tr><td height="15"></td></tr>
              <tr>
                <td align="right" style="padding-right: 7" class="body">[<a href="<?=$main_url?>/blog/<? echo mem_profilenam($p_id); ?>"><strong><?=LNG_PROFILE_RCD_VIEW_A_BLG?></strong></a>]</td>
              </tr>
              <tr>
                <td valign="top"><? echo show_blogs($p_id,3); ?></td>
              </tr>
			  <? if(!empty($pro->about)) { ?>
              <tr><td height="5"></td></tr>
              <tr>
                <td class="hometitle" height="20" style="padding-left: 7"><?=LNG_ABOUT?> <? echo ucwords(name_header($p_id,$m_id)); ?></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td align="justify" class="body" style="padding-left: 10"><?=stripslashes($pro->about)?></td>
              </tr>
			  <? } ?>
              <tr><td height="5"></td></tr>
              <tr>
                <td class="hometitle" height="20" style="padding-left: 7"><? echo ucwords(name_header($p_id,$m_id)); ?>'<?=LNG_PROFILE_FRND?></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td valign="top"><? echo my_friends($p_id,''); ?></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td class="hometitle" height="20" style="padding-left: 7"><?=LNG_LISTINGS_FROM?> <? echo ucwords(name_header($p_id,$m_id)); ?> & <?=LNG_FRIENDS?></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td valign="top" class="body"><? echo show_listings("inprofile",$p_id,''); ?></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td class="hometitle" height="20" style="padding-left: 7"><?=LNG_PROFILE_TST_FOR?> <? echo ucwords(name_header($p_id,$m_id)); ?></td>
              </tr>
              <tr><td height="5"></td></tr>
              <tr>
                <td valign="top" class="body"><? echo show_testimonials($p_id,$m_id); ?></td>
              </tr>
			  <?
			  	$sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
				$num=sql_execute($sql_query,'num');
				if(($num!=0) && ($p_id!=$m_id))	{
			  ?> 
              <tr><td height="5"></td></tr>
              <tr>
                <td valign="top" class="body" style="padding-left: 12">
				<strong><?=LNG_PROFILE_TELL_OTHER?> <? echo ucwords(name_header($p_id,$m_id)); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" onClick="window.location='index.php?mode=user&act=tst&p_id=<?=$p_id?>&lng=<?=$lng_id?>'" value="<?=LNG_WRITE_TESTIMONIAL?>">
				</td>
              </tr>
			  <? } ?>
            </table>
		  </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?
show_footer();
?>
