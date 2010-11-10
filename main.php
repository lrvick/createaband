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


show_header();
?><title><?=LNG_MAIN_MSG_A?></title>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="314" align="center" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
        <? if(main_mems('featured','m')!='') { ?>
        <tr> 
          <td class="title"><?=LNG_MAIN_F_MEM?></td>
        </tr>
        <tr valign="top"> 
          <td align="center"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center"> 
                <? if(main_mems('featured','m')!='') { ?>
                <td align="center" valign="top">
                  <span class="mail-text"><? echo show_photo(main_mems('featured','m')); ?><br><? echo name_header(main_mems('featured','m'),''); ?> - <? echo show_age(main_mems('featured','m')); ?></span><br></td>
                <? } ?>
              </tr>
            </table></td>
        </tr>
        <? } ?>
        <? if(main_mems('model','m')!='') { ?>
        <tr> 
          <td class="title"><?=LNG_SEARCH_MODELS?></td>
        </tr>
        <tr valign="top"> 
          <td align="center"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center"> 
                <? if(main_mems('model','m')!='') { ?>
                <td align="center" valign="top">
                  <span class="mail-text"><? echo show_m_photo(main_mems('model','m')); ?><br><? echo name_header(main_mems('model','m'),''); ?> - <? echo show_age(main_mems('model','m')); ?></span><br></td>
                <? } ?>
              </tr>
            </table></td>
        </tr>
        <? } ?>
        <? if(main_mems('musian','m')!='') { ?>
        <tr> 
          <td class="title"><?=LNG_MAIN_AX?></td>
        </tr>
        <tr valign="top"> 
          <td align="center"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center"> 
                <? if(main_mems('musian','m')!='') { ?>
                <td align="center" valign="top">
                  <span class="mail-text"><? echo show_photo(main_mems('musian','m')); ?><br><? echo name_header(main_mems('musian','m'),''); ?> - <? echo show_age(main_mems('musian','m')); ?></span><br></td>
                <? } ?>
              </tr>
            </table></td>
        </tr>
        <? } ?>
        <? if(main_mems('actacts','m')!='') { ?>
        <tr> 
          <td class="title"><?=LNG_ACTORS?></td>
        </tr>
        <tr valign="top"> 
          <td align="center"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center"> 
                <? if(main_mems('actacts','m')!='') { ?>
                <td align="center" valign="top">
                  <span class="mail-text"><? echo show_a_photo(main_mems('actacts','m')); ?><br><? echo name_header(main_mems('actacts','m'),''); ?> - <? echo show_age(main_mems('actacts','m')); ?></span><br></td>
                <? } ?>
              </tr>
            </table></td>
        </tr>
        <? } ?>
      </table></td>
    <td width="464" align="center" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
        <tr> 
          <td class="heading"><b><font face="Arial, Helvetica, sans-serif" size="3"><?=LNG_MAIN_WELCOME?></font></b></td>
        </tr>
        <tr> 
          <td class="main-text" valign="top" align="justify" height="288"> 
            <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><?=LNG_MAIN_STNAME?></b> 
              <?=LNG_MAIN_BX?>: 
              </font></p>
            <table width="89%" border="0" height="120" align="center">
              <tr> 
                <td height="106" width="51%" valign="top"> 
                  <p></p>
                  <ul>
                    <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#003366"><?=LNG_MAIN_CX?></font></b></font></li>
                    <li><font ><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_DX?></font></b></font></li>
                    <li><font ><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_EX?></font></b></font></li>
                    <li><font ><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_FX?></font></b></font></li>
                    <li><font ><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_GX?></font></b></font></li>
                    <li> 
                      <div align="left"><font ><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_HX?></font></b></font></div>
                    </li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_IX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_JX?></font></b></font></li>
                  </ul>
                  </td>
                <td height="106" width="49%" valign="top"> 
                  <ul>
                    <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#003366"><?=LNG_MAIN_KX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_LX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_MX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_NX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_OX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_PX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_QX?></font></b></font></li>
                    <li><font><b><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_RX?></font></b></font></li>
                  </ul>
                </td>
              </tr>
            </table>
            <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_MAIN_SX?>. <b><br>
              <br>
              <?=LNG_MAIN_TX?>. <a href="index.php?mode=join&lng=<?=$lng_id?>"><?=LNG_MAIN_UX?></a>!</b></font></p>
          </td>
        </tr>
		<? echo home_events(6); ?><? echo home_news(1); ?>
        <tr> 
          <td align="center"><div align="center"><? echo m_banners(); ?></div></td>
        </tr>
      </table></td>
    <td width="226" align="center" valign="top"><form>
	<table width="95%" align="center" cellpadding="0" cellspacing="0" class="lined" >
	<tr> 
    <td colspan="2" class="title"><?=LNG_LOGIN?></td>
    </tr>
	<tr><td>
	<table width="100%">
        <tr> 
          <td class="body"><?=LNG_EMAIL?></td>
          <td class="body"><input type="text" name="email2" size="10" class="istyle"></td>
        </tr>
        <tr> 
          <td class="body"><?=LNG_PASSWORD?></td>
          <td class="body"><input type="Password" name="password2" size="10" class="istyle"> 
            <input type="hidden" name="mode" value="login"></td>
        </tr>
        <tr> 
          <td colspan="2" class="body" align="right"><a href="index.php?mode=forgot&lng=<?=$lng_id?>"><?=LNG_MAIN_XX?>?</a></td>
        </tr>
        <tr> 
          <td colspan="2" class="body" align="center"><input type="submit" name="Submit" value="  <?=LNG_LOGIN?>  "></td>
        </tr>
      </table></td></tr></table><br> <table width="100%" height="400"><tr><td valign="middle" align="center" class="body"><?=LNG_MAIN_YX?></td></tr></table>
      </form>
    </td>
        </tr>
        <tr background="images/right-bg.gif">
          <td align="center"><table width="75%" border="0" height="264">
              <tr> 
                <td height="2">&nbsp;</td>
              </tr>
              <tr valign="top"> 
                <td height="306"> <div align="center"> 
                    <script language="Javascript"></script>
                  </div></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td align="center"><table border="0" width="195" cellpadding="0" cellspacing="0">
              <tr> 
                <td><img src="images/advertising-top.gif" alt="" border=0 width=195 height=40></td>
              </tr>
              <tr> 
                <td align=center height="107"> <br> <br> <?=LNG_ADVERTISE_HERE?> <br> <br> <br> <br> <br></td>
              </tr>
              <tr> 
                <td height="2">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?
show_footer();

function music_cats()	{
	
	global $lng_id;
	
	$sql_query="select * from m_categories order by name limit 0,10";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
	<td class="hometitle" width="98%" style="padding-left: 7"><?=LNG_MUSIC_GRENE?></td>
	<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
	<? while($row=mysql_fetch_object($res)) { ?>
	<tr>
	  <td height="15" class="action">&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=music&act=cat&m_cat_id=<?=$row->m_cat_id?>&lng=<?=$lng_id?>">
		<?=stripslashes($row->name)?>
	  </a></td>
	</tr>
	<? } ?>
	<tr>
	  <td height="15" class="action">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_MORE?>...</a></td>
	</tr>
  </table>
    <?
	}
}

function feat_music()	{
	$sql_query="select * from musics where top_alb='y'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
	<td class="hometitle" width="98%" style="padding-left: 7"><?=LNG_MAIN_ZX?></td>
	<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
  <? while($row=mysql_fetch_object($res)) { ?>
  <tr align="center"> 
    <td class="padded-6"><strong>
      <?=stripslashes($row->m_title)?>
      </strong></td>
  </tr>
  <tr> 
    <td align="left" valign="top" style="padding-left: 3;padding-right: 3">
    <? if(!empty($row->photo_b_thumb)) { ?><img src="<?=$row->photo_b_thumb?>" border="0" align="left"><span style="padding-left: 3"><br><? } ?>
      <?=stripslashes($row->m_matt)?>
	<? if(!empty($row->photo_b_thumb)) { ?></span><? } ?>  
    </td>
  </tr>
  <? } ?>
</table>
<?
	}
}

function feat_mmem()	{
	$sql_query="select mem_id from members where ban='n' and verified='y' and featured='y' and gender='m'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$mem=sql_execute($sql_query,'get');
		echo show_profile_photo($mem->mem_id);
		echo "<br>";
		echo show_online($mem->mem_id);
	}
}


function feat_fmem()	{
	$sql_query="select mem_id from members where ban='n' and verified='y' and featured='y' and gender='f'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$mem=sql_execute($sql_query,'get');
		echo show_profile_photo($mem->mem_id);
		echo "<br>";
		echo show_online($mem->mem_id);
	}
}

function feat_grp()	{
	$sql_query="select * from tribes where feat='y'";
	$res_query=mysql_query($sql_query);
	if(mysql_num_rows($res_query))	{
		$row=mysql_fetch_object($res_query);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
	<td class="hometitle" width="98%" style="padding-left: 7"><?=LNG_MAIN_ZXA?></td>
	<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
  <tr>
    <td align="center">
	<strong><?=stripslashes($row->name)?></strong><br>
    <? echo show_tribe_home($row->trb_id); ?></td>
  </tr>
	<tr align="center"> 
	  <td height="10" colspan="2"></td>
	</tr>
</table>
<?
	}
}

function feat_blog()	{
	$sql_query="select * from blogs group by blog_own order by blog_dt desc limit 0,10";
	$res_query=mysql_query($sql_query);
	if(mysql_num_rows($res_query))	{
		$sp=0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
	<td class="hometitle" width="98%" style="padding-left: 7"><?=LNG_MAIN_ZXB?></td>
	<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
  <? while($row=mysql_fetch_object($res_query)) { ?>
  <? if($sp==0) { ?>
  <tr>
    <? } ?>
    <td><? echo date("m/d/Y h:i A",$row->blog_dt); ?>&nbsp;&nbsp;-&nbsp;&nbsp;<? echo blog_own($row->blog_own); ?></td>
    <? $sp++; ?>
    <? if($sp==2) { ?>
  </tr>
  <? $sp=0; ?>
  <? } ?>
  <? } ?>
</table>
<?
	}
}

function cool_alb()	{
	$sql_query="select * from musics where cool_alb='y'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$muc=sql_execute($sql_query,'get');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
	<td class="hometitle" width="98%" style="padding-left: 7"></=LNG_MAIN_ZXC?></td>
	<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="homelined">
  <tr>
    <td align="center"><? if(!empty($muc->photo_b_thumb)) { ?>
        <br>
        <img src="<?=$muc->photo_b_thumb?>" border="0">
        <? } ?>
        <br>
        <strong>
        <?=stripslashes($muc->m_matt)?>
      </strong><br></td>
  </tr>
  <tr>
    <td height="3"></td>
  </tr>
</table>
</div>
<?
	}
}
?>
