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
$err_mess=form_get("err_mess");
if($act=='')	 events();
elseif($act=='create')	create_event();
elseif($act=='create_done')	create_done();
elseif($act=='viewevent')	viewevent();
elseif($act=='edevent')	mode_event();
elseif($act=='modev_done')	mode_done();
elseif($act=='more')	more();
elseif($act=='remeven')	remeven();
elseif($act=='publish')	publish();
elseif($act=='viewpic')	viewpic();

function 	publish()	{
	$mode=form_get("mode");
	$seid=form_get("seid");
	mysql_query("update event_list set even_active='Y' where even_id=$seid");
	mysql_query("update calendar_events set event_active='Y' where event_para=$seid");
	error_screen(33);
}

function events()	{
	
	global $lng_id;
	
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	//login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$dt=form_get("dt");
	$dis=array();
	$page=form_get("page");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	if(!empty($cat))	{
		$sql_eve="select * from event_list where even_cat='$cat' and even_active='Y' order by even_dt desc limit $start,20";
		$p_sql="select even_id from event_list where even_cat='$cat' and even_active='Y' order by even_dt desc";
		$p_url="index.php?mode=events&cat=$cat&lng=" . $lng_id;
	}	elseif(!empty($dt))	{
		$sql_eve="select * from event_list where even_stat='$dt' and even_active='Y' order by even_dt desc limit $start,20";
		$p_sql="select * from event_list where even_stat='$dt' and even_active='Y' order by even_dt desc";
		$p_url="index.php?mode=events&dt=$dt&lng=" . $lng_id;
	}	else	{
		$sql_eve="select * from event_list where even_active='Y' order by even_dt desc limit $start,20";
		$p_sql="select * from event_list where even_active='Y' order by even_dt desc";		
		$p_url="index.php?mode=events&lng=" . $lng_id;
	}
	$res_eve=mysql_query($sql_eve);
	if(!empty($cat))	{
  		$sql_query="select event_nam from event_cat where event_id=$cat";
		$cats=sql_execute($sql_query,'get');
		$sho="&nbsp;-->&nbsp;".$cats->event_nam;
	}
	show_header();
	?>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined body">
      <tr> 
        <td width="25%" valign="top" class="body lined"><table width="99%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              
          <td class="title"><font color="#000000"><?=LNG_SEARCH_BY_CAT?></font></td>
            </tr>
            <tr>
              <td height="74" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  
              <tr> 
                <td class="body action"> 
                  <blockquote> 
                    <p><a href="index.php?mode=events&act=create&cat=<?=$cat?>&lng=<?=$lng_id?>">
                    <font color="#0066CC"><b><br><?=LNG_ADD_NEW_EVENT?></b></font></a> | 
                    
                    <!--  -->
                    <a href="index.php?mode=events&act=edevent&cat=<?=$cat?>&lng=<?=$lng_id?>">
                    <font color="#0066CC"><b><?=LNG_MODIFY_EVENT?></b></font></a><b>&nbsp; </b></p>
                    <!--
                    <font color="#0066CC"><b><?=LNG_MODIFY_EVENT?></b></font><b>&nbsp; </b></p>
                    -->
                    <!--  -->
                    
                  </blockquote>
                  <ul>
                    <?php
		$sql_catlist="select * from event_cat";
		$res_catlist=mysql_query($sql_catlist);
		while($row_catlist=mysql_fetch_object($res_catlist))	{ 
				  		$sql_eno="select count(even_id) as nos from event_list where even_cat='$row_catlist->event_id' and even_active='Y'";
						$res_eno=mysql_query($sql_eno);
						if(mysql_num_rows($res_eno)) { 
	                        $row_eno=mysql_fetch_object($res_eno);
							$cat_no=$row_eno->nos;
							?>&nbsp; 
                    <li><a href="index.php?mode=events&cat=<?=$row_catlist->event_id?>&lng=<?=$lng_id?>"><?=$row_catlist->event_nam?></a> 
                      <?php echo " (".$cat_no.")</li>";
						}
		}
		?> 
                  </ul>
                  <p align="left"> 
                    <blockquote>
                      <?=LNG_ADVERTISE_HERE?>
                    </blockquote>
                  </p>
                </td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
        
    <td width="75%" valign="top" class="body lined">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              
          <td class="title">
            <div align="center">&nbsp;<font color="#000000"><?=LNG_SEARCH_EVENT_IN_NET?></font></div>
          </td>
            </tr>
            <tr>
              <td align="right" class="body">
			  <form action='index.php' method=post name='searchEvent'>
			  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="lined">
                  <tr> 
                      
                  <td align="center" valign="middle" class="body"> <br>
                    <input type=hidden name="act" value="events"><input type=hidden name="mode" value="search">
                        <?=LNG_KEYWORDS?>
                        <input name='keywords' type=text size="5">
                        <?=LNG_CATEGORY?>
                        <select name="RootCategory"><? events_cats(''); ?></select> <?=LNG_DEGREES?> <select name="degree">
				<option value="any"><?=LNG_ANYONE?>
				<option value="4"><?=LNG_WITHIN_4_DEG?>
				<option value="3"><?=LNG_WITHIN_3_DEG?>
				<option value="2"><?=LNG_WITHIN_2_DEG?>
				<option value="1"><?=LNG_A_FRIEND?>
				</select>
                    <br>
                    <br>
                    <br>
                    <?=LNG_DISTANCE?>
                    <select name="distance">
                          <option value="any"><?=LNG_ANY_DISTANCE?>
                          <option value="5"><?=LNG_5_MILES?>
                          <option value="10"><?=LNG_10_MILES?>
                          <option value="25"><?=LNG_25_MILES?>
                          <option value="100"><?=LNG_100_MILES?>
                        </select>
                        <?=LNG_FROM?>
                        <input type=text size=7 name=zip value='<?
                $sql_query="select zip from members where mem_id='$m_id'";
                $mem=sql_execute($sql_query,'get');
                echo $mem->zip;
                ?>'>
                      </td>
                  </tr>
                  <tr>
                    
                  <td align="center" valign="middle" class="body"> <br>
                    <input name="submit" type='submit' value='Search'>
                    </td>
                  </tr>
                </table></form></td>
            </tr>
            <tr> 
              
          <td align="right" class="body">&nbsp;</td>
            </tr>
            <?php if(!mysql_num_rows($res_eve))	{	?>
            <tr> 
              
          <td height="20" align="center" class="form-comment"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_NO_EVENTS_POSTED?></font></b></td>
            </tr>
            <?php } else { ?>
            <tr> 
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
              <tr valign="middle"> 
                <td width="22%" height="20" class="body"><strong>&nbsp;<font color="#0066CC"><?=LNG_EVENT?></font></strong></td>
                <td width="22%" height="20" class="body"><strong>&nbsp;<font color="#0066CC"><?=LNG_CATEGORY?></font></strong></td>
                <td width="15%" height="20" class="body"><strong>&nbsp;<font color="#0066CC"><?=LNG_START_DATE?></font></strong></td>
                <td width="17%" height="20" class="body"><strong>&nbsp;<font color="#0066CC"><?=LNG_END_DATE?></font></strong></td>
                <td width="13%" height="20" class="body"><strong>&nbsp;<font color="#0066CC"><?=LNG_LOCATION?></font></strong></td>
                <td width="11%" height="20" class="body"><strong>&nbsp;<font color="#0066CC"><?=LNG_VIEWS?></font></strong></td>
              </tr>
              <tr valign="top"> 
                <td height="20" colspan="6" class="body"> <hr width="100%" size="1" color="#C0C0C0"></td>
              </tr>
              <?php while($row_eve=mysql_fetch_object($res_eve))	{ ?>
              <?php
				  		$sql_cf="select event_nam from event_cat where event_id='$row_eve->even_cat'";
						$res_cf=mysql_query($sql_cf);
						$st=explode("-",$row_eve->even_stat);
						$stat=$st[1]."-".$st[2]."-".$st[0];
						$en=explode("-",$row_eve->even_end);
						$end=$en[1]."-".$en[2]."-".$en[0];
						if(strlen($row_eve->even_title)>30)	{
							$titl=substr($row_eve->even_title,0,30)."...";
						}	else	$titl=$row_eve->even_title;
				  ?>
              <tr> 
                <td class="body action">&nbsp;
				<a href="index.php?mode=events&act=viewevent&seid=<?=$row_eve->even_id?>&lng=<?=$lng_id?>"><?=stripslashes($titl)?></a></td>
                <td class="body action">
				<?php if(mysql_num_rows($res_cf)) { ?>
				<?php $row_cf=mysql_fetch_object($res_cf); ?>
				<a href="index.php?mode=events&cat=<?=$row_eve->even_cat?>&lng=<?=$lng_id?>"><?=stripslashes($row_cf->event_nam)?></a></td>
				<? } ?>
                <td class="body">&nbsp; 
                  <?=$stat?>
                </td>
                <td class="body">&nbsp; 
                  <?=$end?>
                </td>
                <td class="body">&nbsp; 
                  <?=stripslashes($row_eve->even_loc)?>
                </td>
                <td class="body">&nbsp; 
                  <?=$row_eve->even_hits?>
                </td>
              </tr>
              <?php } ?>
              <tr align="center"> 
                <td colspan="6" class="body"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
              </tr>
            </table></td>
            </tr>
            <?php } ?>
          </table></td>
      </tr>
    </table>
<?php
	show_footer();
}

function create_event()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	$cat=form_get("cat");
	$dt=form_get("dt");
	$sql_trcat="select * from event_cat order by event_nam";
	$res_trcat=mysql_query($sql_trcat);
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body lined">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="#" onClick="javascript:history.back(1);"><?=LNG_BACK?></a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      
                                  <td height="20" align="left" valign="middle" class="title"><font color="#000000">&nbsp;&nbsp;<?=LNG_NEW_EVENT?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>">
                                  <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></font></td>
                                    </tr>
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      
                                  <td height="21" align="center" valign="middle" class="form-comment"> 
                                    <?=ucwords($err_mess)?> 
                                    <div align="right">&nbsp;&nbsp; </div>
                                  </td>
                                    </tr>
                                    <?php	}	?>
                                    <tr> 
                                      <td align="left" valign="middle" class="body"> 
                                        <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                          
                                      <table width="75%" border="0" align="left" cellpadding="0" cellspacing="0">
                                        <tr> 
                                              
                                          <td class="body" width="33%">&nbsp;</td>
                                              
                                          <td width="67%">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_TITLE?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="tr_nam" type="text" id="tr_nam" size="30"></td>
                                            </tr>
                                            <?php if(empty($cat)) { ?>
                                            <tr> 
                                              
                                          <td class="body" height="30" width="33%">&nbsp;&nbsp;<?=LNG_CATEGORY?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <select name="cat" id="cat">
                                                  <?php if(mysql_num_rows($res_trcat)) {
													while($row_trcat=mysql_fetch_object($res_trcat)) { ?>
                                                  <option value="<?=$row_trcat->event_id?>"> 
                                                  <?=stripslashes($row_trcat->event_nam)?>
                                                  </option>
                                                  <?php	}	}	?>
                                                </select></td>
                                            </tr>
                                            <?php } ?>
                                            <tr> 
                                              
                                          <td width="33%" height="20" class="body">&nbsp;&nbsp;<?=LNG_DESCRIPTION?></td>
                                              
                                          <td width="67%" height="20"> 
                                            <textarea name="blogmatt" cols="30" rows="3" id="blogmatt"></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="events"> 
                                                <?php if(!empty($cat)) { ?>
                                                <input name="cat" type="hidden" id="cat" value="<?=$cat?>"> 
                                                <?php } ?>
                                                <input name="act" type="hidden" id="act" value="create_done"> 
                                                <input name="page" type="hidden" id="page" value="<?=$page?>"> 
                                              </td>
                                            </tr>
                                            <script language="JavaScript1.2">
function del()	{
	gfPop.fStartPop(document.form1.stat,Date);
}
function me()	{
	gfPop.fStartPop(document.form1.end,Date);
}
</script>
                                            <tr> 
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_START_DATE?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="stat" value="<?=$dt?>" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:del();return false;" HIDEFOCUS>
                                                <img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              
                                          <td height="33" class="body" width="33%">&nbsp;&nbsp;<?=LNG_END_DATE?></td>
                                              
                                          <td height="33" width="67%"> 
                                            <input name="end" value="" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:me();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_LOCATION?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="loc" type="text" id="loc" size="30"></td>
                                            </tr>
                                            <tr>
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_ZIP?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="zip" type="text" id="zip" size="30"></td>
                                            </tr>
                                            <tr> 
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_PHONE?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="phon" type="text" id="phon" size="30"></td>
                                            </tr>
                                            <tr> 
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_URL?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="url" type="text" id="url" size="30"></td>
                                            </tr>
                                            <tr> 
                                              
                                          <td height="30" class="body" width="33%">&nbsp;&nbsp;<?=LNG_IMAGE?></td>
                                              
                                          <td height="30" width="67%"> 
                                            <input name="photo" type="file" id="photo" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" colspan="2" align="center">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="<?=LNG_EVENT_PE?>"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"></td>
                                            </tr>
                                          </table>
                                        </form></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
<iframe width=168 height=175 name="gToday:normal:styles/agenda.js" id="gToday:normal:styles/agenda.js" src="styles/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<?php
	show_footer();
}

function create_done()	{
	global $main_url,$_FILES,$base_path,$system_mail,$site_namemail;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$page=form_get("page");
	$act=form_get("act");
	$sql_query="select * from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$blogmatt=form_get("blogmatt");
	$tr_nam=form_get("tr_nam");
	$stat=form_get("stat");
	$end=form_get("end");
	$phon=form_get("phon");
	$url=form_get("url");
	$loc=form_get("loc");
	$loc1=form_get("loc1");
	$zip=form_get("zip");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if(empty($tr_nam) or empty($stat) or empty($end) or empty($blogmatt) or empty($loc) or empty($zip))	{
		$matt=LNG_ENTER_DETAILS;
		$hed="index.php?mode=$mode&act=$act&cat=$cat&page=$page&err_mess=$matt&lng=" . $lng_id;
		$er_id=31;
	}	else	{
		$st=explode("/",$stat);
		$stat=$st[2]."-".$st[0]."-".$st[1];
		$en=explode("/",$end);
		$end=$en[2]."-".$en[0]."-".$en[1];
		$sql_ins="insert into event_list (even_own,even_cat,even_title,even_desc,even_stat,even_end,even_phon,even_url,even_loc,even_loc1,even_zip,even_dt) values (";
		$sql_ins.="$m_id,$cat,'".addslashes($tr_nam)."','".addslashes($blogmatt)."','".$stat."','".$end."','".addslashes($phon)."','".$url."','".addslashes($loc)."',' ','".$zip."',now())";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		$day=$st[1];
		$month=$st[0];
		$year=$st[2];
		$hour=$dhour=$minute=$dminute=0;
		$sql_inscal="insert into calendar_events (event_id,event_para,event_mem,event_day,event_month,event_year,event_time,event_title,event_desc,event_part,event_priority,event_access,event_dur,event_date,event_update)";
		$sql_inscal.="values ('',$prim,$m_id,'$day','$month','$year','$hour:$minute','$tr_nam','$blogmatt','$invite','$pri','$acc','$dhour:$dminute',now(),now())";
		mysql_query($sql_inscal);
		if($tmpfname!='')	{
			if($ftype=='image/bmp')	$p_type=".bmp";
			elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			move_uploaded_file($tmpfname,"events/".$newname.$p_type);
			$photo="events/".$newname.$p_type;
			$sql_img="update event_list set even_img='".$photo."' where even_id=".$prim;
			mysql_query($sql_img);
		}
		$matt=LNG_ENTRY_ADDED_LIST;
		$hed="index.php?mode=$mode&err_mess=$matt&lng=" . $lng_id;
		$er_id=32;
//		require('event_mail.php');
		$data=array();
		$data[0]=LNG_ACTIVATE_EVENT;
		$data[1]="<div class='content'>" . LNG_THANK_POST_SITE . "<br>" . LNG_CLICK_FOR_ACTIVATE . "&nbsp;&nbsp;<A href='".$main_url."/index.php?mode=$mode&act=publish&seid=$prim&lng=$lng_id' target=_new>".$tr_nam."</a><br>
				<b>" . LNG_DONT_DELETE_MSG . "</b><br><br>" . LNG_AUTO_GENERATE_MSG . "<br><br>" . LNG_THANK_PROMOTE_EVENT . "<br></div>";
		$sql_query="select * from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		$data[2]=$site_namemail;
		$data[3]=$system_mail;
		messages($mem->email,7,$data);
	}
error_screen($er_id);
//	show_screen($hed);
}

function mode_done()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$page=form_get("page");
	$act=form_get("act");
	$seid=form_get("seid");
	$blogmatt=form_get("blogmatt");
	$tr_nam=form_get("tr_nam");
	$stat=form_get("stat");
	$end=form_get("end");
	$phon=form_get("phon");
	$url=form_get("url");
	$loc=form_get("loc");
	$loc1=form_get("loc1");
	$zip=form_get("zip");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if(empty($tr_nam) or empty($stat) or empty($end) or empty($blogmatt) or empty($loc) or empty($zip))	{
		$matt=LNG_ENTER_DETAILS;
		$hed="index.php?mode=$mode&act=$act&cat=$cat&page=$page&err_mess=$matt&lng=" . $lng_id;
	}	else	{
		$st=explode("/",$stat);
		$stat=$st[2]."-".$st[0]."-".$st[1];
		$en=explode("/",$end);
		$end=$en[2]."-".$en[0]."-".$en[1];
		$sql_ins="update event_list set even_cat=$cat,even_title='".addslashes($tr_nam)."',even_desc='".addslashes($blogmatt)."',even_stat='".$stat."'";
		$sql_ins.=",even_end='".$end."',even_phon='".addslashes($phon)."',even_url='".$url."',even_loc='".addslashes($loc)."',even_loc1='".addslashes($loc1)."',even_zip='".$zip."' where even_id=$seid";
		mysql_query($sql_ins);
		$day=$st[1];
		$month=$st[0];
		$year=$st[2];
		$hour=$dhour=$minute=$dminute=0;
		mysql_query("update calendar_events set event_day='$day',event_month='$month',event_year='$year',event_time='$hour:$minute'
		,event_title='$tr_nam',event_desc='$blogmatt',event_dur='$dhour:$dminute',event_update=now() where event_para='$seid'");
		$prim=$seid;
		if($tmpfname!='')	{
			if($ftype=='image/bmp')	$p_type=".bmp";
			elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			move_uploaded_file($tmpfname,"events/".$newname.$p_type);
			$photo="events/".$newname.$p_type;
			$sql_img="update event_list set even_img='".$photo."' where even_id=".$prim;
			mysql_query($sql_img);
		}
		$matt=LNG_ENTRY_UPDATED_LIST;
		$hed="index.php?mode=$mode&act=edevent&seid=$seid&page=$page&err_mess=$matt&lng=" . $lng_id;
	}
	show_screen($hed);
}

function more()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$dis=array();
	$page=form_get("page");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	$sql_fcat="select * from event_cat where event_id=$cat";
	$res_fcat=mysql_query($sql_fcat);
	show_header();
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="100%" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    
                <td class="title">&nbsp;&nbsp;<?=LNG_EVENTS?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
                  </tr>
                  <tr> 
                    <td class="title">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                              <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <?php if(!mysql_num_rows($res_fcat)) { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body"><?=LNG_LIST_IS_EMPTY?></td>
                                    </tr>
                                    <?php } else { ?>
                                    <?php while($row_fcat=mysql_fetch_object($res_fcat))	{	?>
                                    <?php
											$sql_for="select * from event_list where even_cat'=$row_fcat->event_id' order by even_dt desc limit $start,20";
											$p_sql="select even_id from event_list where even_cat='$row_fcat->event_id' order by even_dt desc";
											$p_url="index.php?mode=forums&lng=" . $lng_id;
											$res_for=mysql_query($sql_for);
									?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="body"> 
                                        &nbsp;&nbsp;<u><b><?=stripslashes($row_fcat->event_nam)?></b></u></td>
                                    </tr>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" valign="middle" class="body"><a href="index.php?mode=<?=$mode?>&act=create&page=<?=$page?>&cat=<?=$row_fcat->event_id?>&lng=<?=$lng_id?>"><?=LNG_NEW_EVENT?></a>&nbsp;</td>
                                    </tr>
                                    <?php if(!mysql_num_rows($res_for)) { ?>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body"><?=LNG_NO_EVENTS_IN_CATEGORY?></td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" align="left" valign="middle"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <?php $chk=1; ?>
                                                <?php while($row_for=mysql_fetch_object($res_for))	{ ?>
                                                <tr> 
                                                  <td width="18%" valign="top" class="body"> 
                                                    <?=show_photo($row_for->even_own);?>
                                                    <br> 
                                                    <?=show_online($row_for->even_own);?>
                                                  </td>
                                                  <td width="56%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td class="body"><b> 
                                                          <?=stripslashes($row_for->even_title)?>
                                                          </b></td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body">&nbsp;-&nbsp; 
                                                          <?=LNG_START_DATE?>
                                                          <?=$row_for->even_stat?>
                                                          / <?=LNG_END_DATE?>
                                                          <?=$row_for->even_end?>
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td class="body">&nbsp;&nbsp;&nbsp;-&nbsp; 
                                                          <?=stripslashes($row_for->even_desc)?>
                                                        </td>
                                                      </tr>
                                                    </table></td>
                                                  <td width="26%" align="right" valign="top" class="body"> 
                                                    Posted On 
                                                    <?=format_date($row_for->even_dt)?>
                                                    &nbsp;&nbsp;<br>
													<a href="index.php?mode=events&act=viewevent&seid=<?=$row_for->even_id?>&page=<?=$page?>&lng=<?=$lng_id?>"><?=LNG_VIEW?></a>
                                                    <?php if($m_id==$row_for->even_own) { ?>
                                                    &nbsp;<a href="index.php?mode=events&act=edevent&seid=<?=$row_for->even_id?>&page=<?=$page?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>&nbsp;&nbsp;
                                                    <a href="index.php?mode=<?=$mode?>&act=remeven&seid=<?=$row_for->even_id?>&page=<?=$page?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a> 
                                                    <?php } ?>
													</td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <?php $chk++; ?>
                                                <?php } ?>
                                              </table></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <?php } ?>
                                    <?php }	?>
                                    <tr align="right">
                                      <td height="20" colspan="2" align="right" valign="middle"> 
                                        <? echo page_nums($p_sql,$p_url,$page,20); ?>&nbsp;
                                      </td>
                                    </tr>
                                    <?php } ?>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
<?php
	show_footer();
}

function remeven()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
	mysql_query("delete from event_list where even_id=$seid");
	mysql_query("delete from calendar_events where event_para=$seid");
	$matt=LNG_REMOVAL_COMPLETED;
	$hed="index.php?mode=events&err_mess=$matt&lng=" . $lng_id;
	show_screen($hed);
}

function viewevent()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
  	$sql="select * from event_list where even_id=$seid";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	$ev_hits=$row->even_hits+1;
	mysql_query("update event_list set even_hits=$ev_hits where even_id=$seid");
	$sql_cat="select event_nam from event_cat where event_id=$row->even_cat";
	$res_cat=mysql_query($sql_cat);
	$row_cat=mysql_fetch_object($res_cat);
	$st=explode("-",$row->even_stat);
	$stat=$st[1]."-".$st[2]."-".$st[0];
	$en=explode("-",$row->even_end);
	$end=$en[1]."-".$en[2]."-".$en[0];
	show_header();
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined body">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="100%" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td class="title"><strong>&nbsp;&nbsp;<a href="index.php?mode=events&lng=<?=$lng_id?>"><?=LNG_EVENTS?></a> &gt;&gt; 
					<a href="index.php?mode=events&cat=<?=$row->even_cat?>&lng=<?=$lng_id?>"><?=stripslashes($row_cat->event_nam)?></a> &gt;&gt; <?=LNG_VIEW_EVENT?></strong></td>
                  </tr>
                  <tr> 
                    <td class="body">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                              <tr>
                                <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <?php if(!mysql_num_rows($res)) { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body"><?=LNG_NO_ENTRY_FOUND_IN_EVENT_LIST?></td>
                                    </tr>
                                    <?php } else {
											if(empty($row->even_img))	$imgdis="<img src='./blog/noimage.jpg' width='100' height='100' border='0'>";
											else	$imgdis="<a href='index.php?mode=events&act=viewpic&seid=$seid&lng=$lng_id'><img src='./".$row->even_img."' width='100' height='100' border='0'></a>";
									?>
                                    <tr align="right"> 
                                      <td colspan="2" align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr> 
                                            <td width="5%" align="center" valign="middle">&nbsp;</td>
                                            <td width="87%" colspan="2">&nbsp;</td>
                                            <td width="8%" align="right" valign="top">&nbsp;</td>
                                          </tr>
                                          <tr> 
                                            <td>&nbsp;</td>
                                            <td class="body"><font size="5"><strong>
                                              <?=stripslashes($row->even_title)?>
                                              </strong></font><br> 
                                              <?=$ev_hits?>
                                             <?=LNG_VIEW_SINCE_POST_ON?>
                                              <?=format_date($row->even_dt)?>
                                              .<br><br>
                                              <table cellpadding="0" cellspacing="0" border="0" class="body">
                                                <tr valign="top"> 
                                                  <th width="92" align="left"><strong><?=LNG_START_DATE?> :<br>
                                                    <?=LNG_END_DATE?> :</strong></th>
                                                  <td width="250"> 
                                                    <?=$stat?>
                                                    <br> 
                                                    <?=$end?>
                                                    <a href="index.php?mode=events&dt=<?=$row->even_stat?>&lng=<?=$lng_id?>"><?=LNG_MORE_ON_THIS_DATE?></a> </td>
                                                </tr>
                                                <tr valign="top"> 
                                                  <th align="left">&nbsp;</th>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                <tr valign="top"> 
                                                  <th align="left"><?=LNG_LOCATION?> :</th>
                                                  <td> 
                                                    <?=stripslashes($row->even_loc)?>
                                                    <br> 
                                                    <?=stripslashes($row->even_loc11)?>
													<?php if(!empty($row->even_phon)) { ?>
													<br>
													<?=LNG_PH?> <?=stripslashes($row->even_phon)?>
													<?php } ?>
													<?php if(!empty($row->even_url)) { ?>
													<br>
													<?=LNG_URL?> :<?=stripslashes($row->even_url)?>
													<?php } ?>
                                                  </td>
                                                </tr>
                                                <tr valign="top">
                                                  <th align="left">&nbsp;</th>
                                                  <td>&nbsp;</td>
                                                </tr>
                                              </table>
                                              <br>
                                              <?=stripslashes($row->even_desc)?>
                                              <br><br>
                                              <table class="lined" cellpadding="0" cellspacing="0">
                                                <tr valign="top"> 
                                                  <td>
                                                    <?=show_photo($row->even_own);?><br>
                                                    <?=show_online($row->even_own);?>
                                                  </td>
                                                </tr>
                                              </table></td>
                                            <td align="center" valign="top" class="body">
                                              <?=$imgdis?>
											  <?php if($m_id==$row->even_own)	{	?>
                                              <br>
                                              <a href="index.php?mode=events&act=edevent&seid=<?=$seid?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a> / 
                                              <a href="index.php?mode=events&act=remeven&seid=<?=$seid?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>&nbsp;
											  <?php } ?>
										  </td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr> 
                                            <td align="center" valign="middle">&nbsp;</td>
                                            <td colspan="2">&nbsp;</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <?php }	?>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
<?php
	show_footer();
}

function mode_event()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	$cat=form_get("cat");
	$seid=form_get("seid");
  	$sql="select * from event_list where even_id=$seid";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	$sql_cat="select event_nam from event_cat where event_id=$row->even_cat";
	$res_cat=mysql_query($sql_cat);
	$row_cat=mysql_fetch_object($res_cat);
	$sql_trcat="select * from event_cat order by event_nam";
	$res_trcat=mysql_query($sql_trcat);
	$st=explode("-",$row->even_stat);
	$stat=$st[1]."/".$st[2]."/".$st[0];
	$en=explode("-",$row->even_end);
	$end=$en[1]."/".$en[2]."/".$en[0];
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body lined">
      <tr>
        <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title"><strong>&nbsp;&nbsp;<a href="index.php?mode=events&lng=<?=$lng_id?>"><?=LNG_EVENTS?></a> 
                                        &gt;&gt; <a href="index.php?mode=events&cat=<?=$row->even_cat?>&lng=<?=$lng_id?>"><?=stripslashes($row_cat->event_nam)?></a> &gt;&gt; <?=LNG_MODIFY_EVENT?></strong></td>
                                    </tr>
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <tr> 
                                      <td align="left" valign="middle" class="body"> 
                                        <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                          <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr> 
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_TITLE?></td>
                                              <td height="30"> <input name="tr_nam" type="text" id="tr_nam" value="<?=stripslashes($row->even_title)?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td class="body" height="30">&nbsp;&nbsp;<?=LNG_CATEGORY?></td>
                                              <td height="30"> <select name="cat" id="cat">
                                                  <?php if(mysql_num_rows($res_trcat)) {
													while($row_trcat=mysql_fetch_object($res_trcat)) { ?>
                                                  <?php if($row->even_cat==$row_trcat->event_id)	$selme=LNG_SELECTED;
													else	$selme="";	?>
                                                  <option value="<?=$row_trcat->event_id?>" <?=$selme?>> 
                                                  <?=stripslashes($row_trcat->event_nam)?>
                                                  </option>
                                                  <?php	}	}	?>
                                                </select></td>
                                            </tr>
                                            <tr> 
                                              <td width="44%" class="body">&nbsp;&nbsp;<?=LNG_DESCRIPTION?></td>
                                              <td width="56%"><textarea name="blogmatt" cols="35" rows="3" id="blogmatt"><?=stripslashes($row->even_desc)?></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="<?=$mode?>"> 
                                                <input name="seid" type="hidden" id="seid" value="<?=$seid?>"> 
                                                <input name="act" type="hidden" id="act" value="modev_done"> 
                                                <input name="page" type="hidden" id="page" value="<?=$page?>"> 
                                              </td>
                                            </tr>
                                            <script language="JavaScript1.2">
function del()	{
	gfPop.fStartPop(document.form1.stat,Date);
}
function me()	{
	gfPop.fStartPop(document.form1.end,Date);
}
</script>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_START_DATE?></td>
                                              <td height="30"> <input name="stat" value="<?=$stat?>" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:del();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_END_DATE?></td>
                                              <td height="30"> <input name="end" value="<?=$end?>" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:me();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_LOCATION?></td>
                                              <td height="30"><input name="loc" type="text" id="loc" value="<?=$row->even_loc?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_LOCATION_ADDRESS?></td>
                                              <td height="30"> <textarea name="loc1" cols="30" rows="3" id="loc1"><?=$row->even_loc1?></textarea></td>
                                            </tr>
                                            <tr>
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_ZIP?></td>
                                              <td height="30"><input name="zip" type="text" id="zip" value="<?=$row->even_zip?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_PHONE?></td>
                                              <td height="30"> <input name="phon" type="text" id="phon" value="<?=$row->even_phon?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_URL?></td>
                                              <td height="30"> <input name="url" type="text" id="url" value="<?=$row->even_url?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;<?=LNG_IMAGE?></td>
                                              <td height="30"> <input name="photo" type="file" id="photo" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="<?=LNG_EVENT_UPDATE_EVENT?>"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"></td>
                                            </tr>
                                          </table>
                                        </form></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
<iframe width=168 height=175 name="gToday:normal:styles/agenda.js" id="gToday:normal:styles/agenda.js" src="styles/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<?php
	show_footer();
}

function viewpic()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
  	$sql_query="select * from event_list where even_id=$seid";
	$pho=sql_execute($sql_query,'get');
	if(empty($pho->even_img))	$imgdis="<img src='./blog/noimage.jpg' border='0'>";
	else	$imgdis="<img src='./".$pho->even_img."' border='0'>";
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined">
  <tr>
    <td align="center"><?=$imgdis?></td>
  </tr>
  <tr>
    <td height="25" align="center" class="body"><a href="index.php?mode=events&act=viewevent&seid=<?=$seid?>&lng=<?=$lng_id?>"><?=LNG_BACK?></a></td>
  </tr>
</table>
<?
	show_footer();
}
?>
