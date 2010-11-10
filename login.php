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
if($act=='')	do_log_in();
elseif($act=='logout')	do_log_out();
elseif($act=='news')	fullstory();
elseif($act=='home')	home_page();
elseif($act=='menu_err')	menu_error();
elseif($act=='menu_up')	menu_up();
elseif($act=='form')	login_form();

function login_form()	{
	
	global $lng_id;
   
	show_header();
	
?>
<table width="100%" class='body'>
<tr>
    <td class='lined title'><font color="#000000"><?=LNG_LOGIN_ML?></font></td>
  </tr>
<tr>
    <td class='lined padded-6' height="221"> 
      <form action='index.php?lng=<?=$lng_id?>' method='post'>
        <?=LNG_LOGIN_EMAIL_PASS?> <br>
        <?=LNG_LOGIN_REG_FREE?> <a href="http://www.teendating.tv/index.php?mode=join&lng=<?=$lng_id?>"><?=LNG_LOGIN_CLK_HERE?></a><br>
        <br>
        <br>
        <br>
        <table align=center class='body' width="404">
          <tr>
            <td width="22" height="38">&nbsp;</td>
            <td width="179" height="38"><b><?=LNG_EMAIL?></b></td>
            <td width="181" height="38"> 
              <input type='text' name='email' size="20" value="<? echo cookie_get("mem_unam"); ?>">
            </td>
          </tr>
          <tr>
            <td width="22" height="32">&nbsp;</td>
            <td width="179" height="32"><b><?=LNG_PASSWORD?></b></td>
            <td width="181" height="32"> 
              <input type='password' name='password' size="20" value="<? echo cookie_get("mem_upass"); ?>">
            </td>
          </tr>
          <tr>
            <td width="22" height="34">&nbsp;</td>
            <td width="179" height="34"><?php if(cookie_get("rem_mem")=="Y") { ?> 
              <input type="checkbox" name="remember" value="ON" checked>
              <?php } else { ?>
              <input type="checkbox" name="remember" value="ON">
              <?php } ?> 
              <input type='hidden' name='mode' value='login'>
            </td>
            <td width="181" height="34"><?=LNG_LOGIN_REM_ME?></td>
          </tr>
          <tr>
            <td width="22" height="39">&nbsp;</td>
            <td width="179" height="39"><a href='index.php?mode=forgot&lng=<?=$lng_id?>'><b><?=LNG_LOGIN_FOR_GOT?></b></a></td>
            <td width="181" height="39"> 
              <input type='submit' value='<?=LNG_LOGIN_SIGN_IN?>'>
            </td>
          </tr>
        </table>
        </form>
</td></tr>
</table>
<?
	show_footer();
}//function

function do_log_in()	{
	global $lng_id;
	
	global $main_url,$cookie_url,$PHPSESSID;
	if($PHPSESSID!='')	{
		if(session_unset($PHPSESSID))	{
			session_destroy($PHPSESSID);
		}//if
	}//if
	$email=form_get("email");
	$password=form_get("password");
	$rem=form_get("remember");
	//crypting pass and checking
	$crypass=md5($password);
	$sql_query="select * from members where email='$email'";
	$mem=sql_execute($sql_query,'get');
	//if pass is incorrect
	if($mem->password!=$crypass)	error_screen(0);
	//if user is banned
	elseif($mem->ban=='y')	error_screen(8);
	//if user payment is not success
	elseif($mem->mem_stat=='P')	{
		if($mem->pay_stat=='N')	error_screen(34);
	}
	//if account is verified
	elseif($mem->verified!='y')	error_screen(16);
	//if user want to be remembered
	if($rem!='1')	$time=time()+3600*24;
	else	$time=time()+3600*24*365;
	//for remember function
	if($rem=="ON")	{
		SetCookie("rem_mem","Y",$time,"/",$cookie_url);
		SetCookie("mem_unam",$email,$time,"/",$cookie_url);
		SetCookie("mem_upass",$password,$time,"/",$cookie_url);
	}	else	{
		SetCookie("rem_mem","N",$time,"/",$cookie_url);
		SetCookie("mem_unam","",$time,"/",$cookie_url);
		SetCookie("mem_upass","",$time,"/",$cookie_url);
	}
	//setting cookies and updating db
	$sql_type="select * from member_package where package_id='$mem->mem_acc'";
	$res_type=mysql_query($sql_type);
	$type=mysql_fetch_object($res_type);
	SetCookie("mem_list",$type->package_list,$time,"/",$cookie_url);
	SetCookie("mem_grop",$type->package_grp,$time,"/",$cookie_url);
	SetCookie("mem_eve",$type->package_eve,$time,"/",$cookie_url);
	SetCookie("mem_blog",$type->package_blog,$time,"/",$cookie_url);
	SetCookie("mem_chat",$type->package_chat,$time,"/",$cookie_url);
	SetCookie("mem_forum",$type->package_forum,$time,"/",$cookie_url);
	SetCookie("mem_phot",$type->package_nphot,$time,"/",$cookie_url);
	SetCookie("mem_type",$mem->mem_stat,$time,"/",$cookie_url);
	SetCookie("mem_pnam",$mem->profilenam,$time,"/",$cookie_url);
	SetCookie("mem_acc",$mem->mem_acc,$time,"/",$cookie_url);
	SetCookie("mem_id",$mem->mem_id,$time,"/",$cookie_url);
	SetCookie("mem_pass",$mem->password,$time,"/",$cookie_url);
	SetCookie("mem_em",$mem->email,$time,"/",$cookie_url);
	SetCookie("mem_fn",$mem->fname,$time,"/",$cookie_url);
	SetCookie("mem_fn",$mem->fname,$time,"/",$cookie_url);
	$now=time();
	$sql_query="update members set online='on',visit='$mem->current',current='$now',history='' where mem_id='$mem->mem_id'";
	sql_execute($sql_query,'');
	$sql_query="update stats set day_sgnin=day_sgnin+1,week_sgnin=week_sgnin+1,month_sgnin=month_sgnin+1";
	sql_execute($sql_query,'');
	$link="index.php?mode=login&act=home&lng=".$lng_id;
	
	show_screen($link);
}

function do_log_out()	{
	global $main_url,$cookie_url;
	$m_id=cookie_get("mem_id");
	$name=cookie_get("mem_em");
	$m_rem=cookie_get("rem_mem");
	$sql_query="update members set online='off' where mem_id='$m_id'";
	sql_execute($sql_query,'');
	$sql_query="delete from chat_users where name='$name'";
	sql_execute($sql_query,'');
	$sql_query="delete from chat_messages where name='$name'";
	sql_execute($sql_query,'');
	//deleting cookies and redirecting to main page
	if($m_rem!="Y")	{
		SetCookie("mem_unam","",time()-10,"/",$cookie_url);
		SetCookie("mem_upass","",time()-10,"/",$cookie_url);
		SetCookie("rem_mem","",time()-10,"/",$cookie_url);
	}
	SetCookie("mem_id","",time()-10,"/",$cookie_url);
	SetCookie("mem_pass","",time()-10,"/",$cookie_url);
	SetCookie("mem_em","",time()-10,"/",$cookie_url);
	SetCookie("mem_list","",time()-10,"/",$cookie_url);
	SetCookie("mem_grop","",time()-10,"/",$cookie_url);
	SetCookie("mem_eve","",time()-10,"/",$cookie_url);
	SetCookie("mem_blog","",time()-10,"/",$cookie_url);
	SetCookie("mem_chat","",time()-10,"/",$cookie_url);
	SetCookie("mem_forum","",time()-10,"/",$cookie_url);
	SetCookie("mem_phot","",time()-10,"/",$cookie_url);
	SetCookie("mem_type","",time()-10,"/",$cookie_url);
	SetCookie("mem_acc","",time()-10,"/",$cookie_url);
	SetCookie("mem_fn","",time()-10,"/",$cookie_url);
	SetCookie("mem_pnam","",time()-10,"/",$cookie_url);
	show_screen($main_url);
}

function home_page()	{
	global $main_url,$base_path,$lng_id;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$sql_query="select * from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$tribes=split("\|",$mem->tribes);
	$tribes=if_empty($tribes);
	show_header();
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
      
    <td width=302 align=center valign=top height="1167"> <!--LEFT TABLE STARTS HERE--> 
      <table border=0 width=299 cellpadding=5 cellspacing=5>
        <tr>
					<td>
						
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr>
								
                <td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_photo($m_id); ?><br><? show_online($m_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="medlinks">
                      
                    <li><a href="index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_LOGIN_VIEW_PROFILE?></a></font></b></font> 
                    <li><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_LOGIN_MANG_PIC?></a></b></font>
                    <li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"><?=LNG_LOGIN_ACC_SET?></a></b></font>
                    </ul>
								</td>
							</tr>
							<tr>
								<td colspan=2 class="main-text"><b><?=LNG_PROFILE_PV?></b>: <? show_views($m_id); ?><?=LNG_LOGIN_VIEW_ON_U?>
            					<? show_views_visit($m_id); ?><?=LNG_LOGIN_SINCE?> <? show_visit($m_id); ?></td>
							</tr>
							<tr>
								<td colspan=2 align=right class="body"><a href="index.php?mode=login&act=logout&lng=<?=$lng_id?>"><?=LNG_LOGOUT?></a></td>
							</tr>
							<tr>
								<td align=center colspan=2><img src="images/orange-dot.gif" alt="" border=0 width=260 height=1></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td align="center"><table width="100%" class="body">
				<tr><td class="title"><?=LNG_LOGIN_ACT_ITM?></td></tr>
				<tr><td><table cellpadding="2" cellspacing="2" class="body" border="0">
              <? echo show_action($m_id); ?></table></tr>
				</table></td></tr>
				<tr>
				<td>
						
            <table border=0 width=98% cellpadding=2 cellspacing=2>
              <tr>
								
                <td class="title"><?=LNG_LOGIN_EVNT_CAL?></td>
							</tr>
							<tr>
								
                  <td height="139"> 
                    <div align="center">
                     <? require_once 'calendar/mini/cal.php'; ?>
                    </div>
                  </td>
							</tr>
							<tr>
							<? $cal_link=$main_url."/calendar"; ?>
								<td align=right class="body"><a href=<? echo $cal_link ?>><?=LNG_LOGIN_AE?></a></td>
							</tr>
							<tr>
								<td align=center><img src="images/orange-dot.gif" alt="" border=0 width=260 height=1></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					
          <td height="677"> 
            <table border=0 width=278 cellpadding=0 cellspacing=0 align="center">
              <tr> 
                <td><b><img src="images/right-top-border.gif" alt="" border=0 width=277 height=21></b></td>
              </tr>
              <tr> 
                <td align=center valign="top" background="images/advertising-bg.gif" height="596"> 
                  <table border=0 cellpadding=2 cellspacing=2 class="body">
                    <tr class="main-text"> 
                      <td colspan="2" class="bold" style="padding-left: 11"><?=LNG_WHT_CAN_U_DO?></td>
                    </tr>
                    <tr class="main-text"> 
                      <td colspan="2" style="padding-left: 17" height="534"><?=LNG_LOGIN_AE_PROFILE?>
                        <ul>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=profile&amp;pro=edit&amp;type=basic&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=profile&amp;pro=edit&amp;type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=profile&amp;pro=edit&amp;type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=profile&amp;pro=edit&amp;type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=profile&amp;pro=edit&amp;type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                        </ul>
                        <?=LNG_LOGIN_MET_NEW_FRND?> 
                        <ul>
                          <li><a href="index.php?mode=user&act=inv&lng=<?=$lng_id?>"><?=LNG_LOGIN_SND_INVT?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=search&amp;act=browse&lng=<?=$lng_id?>"><?=LNG_LOGIN_BROS_NET?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=search&lng=<?=$lng_id?>"><?=LNG_LOGIN_SRC_A_FRND?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=friends&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_CURR_FRND?></a></li>
                          <li><a href="http://www.teendating.tv/index.php?mode=user&amp;act=intro&amp;p_id=3&lng=<?=$lng_id?>"><?=LNG_MAKE_INTROD?></a></li>
                        </ul>
                        <p><?=LNG_LOGIN_CURR_SET?></p>
                        <ul>
                          <li><a href="index.php?mode=user&act=inv_db&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_INVT_HIST?></a></li>
                          <li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"><?=LNG_MY_BOOKMARKS?></a></li>
                          <li><a href="index.php?mode=listing&act=all&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_CLAS?></a></li>
                          <li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_IGN_LST?></a></li>
                          <li><a href="index.php?mode=events&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_EVENTS?></a></li>
                          <li><a href="index.php?mode=rates&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_RAT?></a></li>
                          <li><a href="index.php?mode=tribe&lng=<?=$lng_id?>"><?=ucwords(LNG_MY_GROUPS)?></a></li>
                          <li><a href="index.php?mode=blogs&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_BLOGS?></a></li>
                          <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"><?=LNG_LOGIN_MY_EMAIL?></a></li>
                        </ul>
                        </td>
                    </tr>
                    <tr> 
                      <td colspan="2" height="1" class="line"></td>
                    </tr>
                    <tr class="main-text"> 
                      <td colspan="2" style="padding-left: 17"> 
                        <div align="center"><?=LNG_LOGIN_U_ARE_HERE?></div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td height="2"><img src="images/advertising-bototm.gif" alt="" border=0 width=276 height=24></td>
              </tr>
            </table>
          </td>
				</tr>
			</table>
			
        
      <!--LEFT TABLE ENDS HERE--> <br>
      </td>
		
      
    <td width=2 background="images/dot-line.gif" height="1167"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      
    <td width=424 align=center valign=top height="1167"> <!--CENTER TABLE STARTS HERE--> 
      <table border=0 width=420 cellpadding=5 cellspacing=5 height="328">
        <tr>
					<td class="heading"><?=LNG_NEWS?></td>
				</tr>
				<tr>
					<td class="main-text" valign="top"><? echo show_news(); ?></td>
				</tr>
				<tr>
					<td align=right>&nbsp;</td>
				</tr>
				<tr>
					<td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
				</tr>
				<tr>
					<td class="heading"><?=LNG_LOGIN_NEW_MEMBER?></td>
				</tr>
				<tr>
					<td class="main-text" align=center>
					<table border=0 width=100% cellpadding=2 cellspacing=2 align="right">
				<?
				$sql_query="select * from members order by joined desc limit 0,12";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==4)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
				</table>
				</td>
				</tr>
				<tr>
					<td align=right class="body"><a href="index.php?mode=search&lng=<?=$lng_id?>"><?=LNG_LOGIN_SRC_MEMBER?></a></td>
				</tr>
				<tr>
					<td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
				</tr>
				<tr>
					<td class="heading"><?=LNG_LOGIN_MY_FRND?></td>
				</tr>
				
        <tr valign="bottom"> 
          <td class="main-text" align=center height="19"> <br>
            <table border=0 width=100%><tr><td colspan="2" align="right"><? show_friends_deg($m_id,"12","6","1","all"); ?></td></tr>
				
				<tr>
                <td>&nbsp;</td>
								<td colspan="3" align="right" class="body"><a href="index.php?mode=user&act=friends_view&pro=1&lng=<?=$lng_id?>"><?=LNG_LOGIN_VIEW_ALL?></a></td>
							</tr>
						</table>
					
            <br>
            <br>
          </td>
				</tr>
			</table>
        
      <table border=0 width=415 cellpadding=5 cellspacing=5>
        <tr> 
          <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
        </tr>
      </table>
      <br>
        
      <table border=0 width=424 cellpadding=0 cellspacing=0>
        <tr> 
          <td height="23" width="1">&nbsp;</td>
          <td height="23" width="10">&nbsp;</td>
          <td height="23" width="10">&nbsp;</td>
          <td height="23" width="421"> 
            <div align="left" class="heading"> <?=LNG_LOGIN_BROS_TEL_NET?></div>
          </td>
        </tr>
        <tr> 
          <td align=center width="1">&nbsp;</td>
          <td align=center width="10">&nbsp;</td>
          <td align=center width="10">&nbsp;</td>
          <td align=center width="421"> 
            <table border=0 cellpadding=2 cellspacing=2 width="394">
              <tr valign="top"> 
                <td class="main-text"> 
                  <li><a href="index.php?mode=people_card&p_id=<?=$m_id?>&act=artist&lng=<?=$lng_id?>"><strong><?=LNG_LOGIN_ART_MUSI?></strong></a></li>
					 <table border=0 width=100% cellpadding=2 cellspacing=2>
				<?
				$sql_query="select * from musicprofile where bandnam <>'' order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==3)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
				<tr><td colspan="3" align="right" class="body"><a href="index.php?mode=search&act=browse&sec=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_MORE?></a></td></tr>
				</table>
                  <li><a href="index.php?mode=people_card&p_id=<?=$m_id?>&act=model&lng=<?=$lng_id?>"><strong><?=LNG_MODEL?></strong></a></li>
                   <table border=0 width=100% cellpadding=2 cellspacing=2>
				<?
				$sql_query="select * from models where height <>'' and weight <>'' order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==3)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
				<tr><td colspan="3" align="right" class="body"><a href="index.php?mode=search&act=browse&sec=model&lng=<?=$lng_id?>"><?=LNG_LOGIN_MORE?></a></td></tr>
				</table>
                  <li><a href="index.php?mode=people_card&p_id=<?=$m_id?>&act=actor&lng=<?=$lng_id?>"><strong><?=LNG_ACTORS?></strong> 
                    </a></li>
                 <table border=0 width=100% cellpadding=2 cellspacing=2>
				<?
				$sql_query="select * from actors where height <>'' and weight <>'' order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==3)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
				<tr><td colspan="3" align="right" class="body"><a href="index.php?mode=search&act=browse&sec=actor&lng=<?=$lng_id?>"><?=LNG_LOGIN_MORE?></a></td></tr>
				</table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td width="1">&nbsp;</td>
          <td width="10">&nbsp;</td>
          <td width="10">&nbsp;</td>
          <td width="421">&nbsp;</td>
        </tr>
      </table>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      
    <td width=2 background="images/dot-line.gif" height="1167"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      
    <td width=255 align=center valign=top height="1167"> <!--RIGHT TOP TABLE STARTS HERE--> 
      <!--RIGHT TOP TABLE ENDS HERE--> <!--RIGHT MIDDLE TABLE STARTS HERE--> <br>
			<!--RIGHT MIDDLE TABLE ENDS HERE-->
			
			<!--RIGHT BOTTOM TABLE STARTS HERE-->
			<table border=0 width=195 cellpadding=0 cellspacing=0>
				<tr>
					<td><img src="images/my-network.gif" alt="" border=0 width=195 height=40></td>
				</tr>	
				<tr>
					
          <td align=center valign="top" background="images/advertising-bg.gif"> 
            <table border=0 cellpadding=2 cellspacing=2>
			<tr class="main-text"> 
			<td colspan="2" class="bold" style="padding-left: 11"><?=LNG_LOGIN_PEOPLE?></td>
			</tr>
			<tr class="main-text"> 
			  <td colspan="2" style="padding-left: 17"> <? echo count_network($m_id,"1","num"); ?> 
				<a href="index.php?mode=user&act=friends_view&pro=1&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
				(1&deg;)<br> <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
				<?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br> <? echo count_network($m_id,"3","num"); ?> 
				<a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
				<?=LNG_LOGIN_3_DEG_AWAY?><br> <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
				<?=LNG_LOGIN_4_DEG_AWAY?> </td>
			</tr>
			<tr> 
			  <td colspan="2" height="1" class="line"></td>
			</tr>
			<tr class="main-text"> 
			  <td colspan="2" style="padding-left: 17"> <? echo count_network($m_id,"all","num"); ?> 
				<a href="index.php?mode=user&act=friends_view&pro=all&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PERSON?></b></a> 
				<?=LNG_LOGIN_IN_MY_NET?> </td>
			</tr>
						</table>
					</td>
				</tr>				
				<tr>
					<td><img src="images/advertising-bototm.gif" alt="" border=0 width=195 height=24></td>
				</tr>				
			</table>
      <br>
      <table border=0 width=191 cellpadding=0 cellspacing=0>
        <tr> 
          <td><b><img src="images/right-top-border.gif" alt="" border=0 width=196 height=21></b></td>
        </tr>
        <tr> 
          <td align=center valign="top" background="images/advertising-bg.gif" height="113"> 
            <div align="center">
              <table border=0  cellpadding=1 cellspacing=1>
                <tr> 
                  <td class="main-text" background="images/advertising-bg.gif"><?=LNG_LOGIN_TOTAL_MEM?> :</td>
                  <td class="main-text"><? 
				$Jsql="select count(*) as mcnt from members where online ='on'";
				$Jrow=sql_execute($Jsql,'get');
				echo $Jrow->mcnt;
				?> </td>
                </tr>
                <tr> 
                  <td class="main-text" background="images/advertising-bg.gif"><?=LNG_LOGIN_TOTAL_GUEST?> :</td>
                  <td class="main-text">0</td>
                </tr>
                <tr background="images/advertising-bg.gif"> 
                  <td class="main-text" colspan=2><?=LNG_LOGIN_FIND_OUT_FROM?></td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2><b><?=LNG_LOGIN_LIVE_CHAT?>:</b></td>
                </tr>
                <tr> 
                  <td class="main-text" background="images/advertising-bg.gif"><?=LNG_LOGIN_MEM_CHT_NOW?>:</td>
                  <td class="main-text">
				  <?
				  $ssql="select count(*) as jn from chat_users";
				  $J=sql_execute($ssql,'get');
				  echo $J->jn;
				  ?>
				  </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
        <tr> 
          <td height="2"><img src="images/advertising-bototm.gif" alt="" border=0 width=195 height=24></td>
        </tr>
      </table>
      <br>
      <table border=0 width=191 cellpadding=0 cellspacing=0>
        <tr> 
          <td><b><img src="images/right-top-border.gif" alt="" border=0 width=196 height=21></b></td>
        </tr>
        <tr> 
          <td align=center valign="top" background="images/advertising-bg.gif" height="110"> 
            <table border=0 cellpadding=2 cellspacing=2 align="center" height="120">
              <tr class="main-text" valign="top"> 
                <td colspan="2" style="padding-left: 17" height="56"> 
                  <?=LNG_LOGIN_U_ARE_HERE?>
                  <br>
                  <br>
                  <br>
                </td>
              </tr>
            </table>
            
           <?=LNG_LOGIN_U_ARE_HERE?>
          </td>
        </tr>
        <tr> 
          <td height="2"><img src="images/advertising-bototm.gif" alt="" border=0 width=195 height=24></td>
        </tr>
      </table>
      <blockquote>&nbsp; </blockquote>
                  </td>
	</tr>
</table>
<?
show_footer();
}

//views on user since last visit
function show_views_visit($m_id){
$sql_query="select views,visit from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$views=split("\|",$mem->views);
$views=if_empty($views);
$views_visit=array();
if($views!=''){
foreach ($views as $view){
 if($view>=$mem->visit){
  array_push($views_visit,$view);
 }
 }
 }
$num=count($views_visit);
echo $num;
}

//showing when user visited site last time
function show_visit($m_id){
$sql_query="select visit from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$visit=date("m/d",$mem->visit);
echo $visit;
}

//showing action items
function show_action($m_id){
	$sql_query1="select mes_id,frm_id from messages_system where type='friend' and mem_id='$m_id'";
	$num1=sql_execute($sql_query1,'num');
    $num2=mes_num($m_id);
    $sql_query3="select from_id,tst_id from testimonials where mem_id='$m_id' and stat='w'";
    $num3=sql_execute($sql_query3,'num');
    $sql_query4="select mes_id,frm_id,special from messages_system where type='trb_inv' and mem_id='$m_id'";
    $num4=sql_execute($sql_query4,'num');
    $sql_query5="select mes_id,frm_id,special from messages_system where type='trb_req' and mem_id='$m_id'";
    $num5=sql_execute($sql_query5,'num');

    //if there are tribe requests
    if($num5!=0){

	    $res=sql_execute($sql_query5,'res');
        while($frd=mysql_fetch_object($res)){

            $sql_query67="select name from tribes where trb_id='$frd->special'";
            $trb=sql_execute($sql_query67,'get');

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($frd->frm_id,$m_id);echo " wants to join $trb->name.";
            echo "<span class='action'><a href='index.php?mode=messages&act=view_trb_req&trb_req_id=$frd->mes_id&lng=$lng_id'>".LNG_VIEW."</a></span>";
            echo "</td>";

        }//while

    }//if
    //if there are tribe invitations
    if($num4!=0){

	    $res=sql_execute($sql_query4,'res');
        while($frd=mysql_fetch_object($res)){

            $sql_query="select name from tribes where trb_id='$frd->special'";
            $trb=sql_execute($sql_query,'get');

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($frd->frm_id,$m_id);echo " has invited you to join $trb->name.";
            echo "<span class='action'><a href='index.php?mode=messages&act=view_trb_inv&trb_inv_id=$frd->mes_id&lng=$lng_id'>".LNG_VIEW."</a></span>";
            echo "</td>";

        }//while

    }//if
    //new messages
    if($num2!=0){

        echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
		echo LNG_LOGIN_U_HAVE; 
		echo mes_num($m_id);
		echo " ".LNG_LOGIN_NEW_MSG_INBOX."<span class='action'><a href='index.php?mode=messages&act=inbox&lng=$lng_id'>".LNG_VIEW."</a></span>";
        echo "</td>";

    }//if
    //friendship invitations
	if($num1!=0){

	    $res=sql_execute($sql_query1,'res');
        while($frd=mysql_fetch_object($res)){

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
			$jql="select gender from members where mem_id='$frd->frm_id'";
			$jg=sql_execute($jql,'get');
			if($jg->gender=='m')	{
            echo name_header($frd->frm_id,$m_id);
            echo " ".LNG_LOGIN_INVITE_YOU_TO_JOIN;
			} else  {
			echo name_header($frd->frm_id,$m_id);
			echo " ".LNG_LOGIN_INVITE_YOU_TO_HJOIN;
			}
            echo "<span class='action'><a href='index.php?mode=messages&act=view_inv&inv_id=$frd->mes_id&lng=$lng_id'>".LNG_VIEW."</a></span>";
            echo "</td>";

        }//while

	}//if
    //testimonal needs approval
    if($num3!=0){

        $res2=sql_execute($sql_query3,'res');
        while($tst=mysql_fetch_object($res2)){

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($tst->from_id,$m_id);
            echo " ".LNG_LOGIN_W_TEST;
            echo "<span class='action'><a href='index.php?mode=messages&act=view_tst&tst_id=$tst->tst_id&lng=$lng_id'>".LNG_VIEW."</a></span>";
            echo "</td>";

        }//while

    }//if
if (($num1==0) && ($num2==0)&& ($num3==0)&& ($num4==0)&& ($num5==0)) echo "<span align='center'><b>".LNG_LOGIN_NO_ACT."</b></span>";
}//function
function menu_error(){
 error_screen(35);
}//function
function menu_up(){
 error_screen(36);
}//function

function show_news()	{
	$m_id=cookie_get("mem_id");
	$sql_query="select rapzone from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$sql_query="select * from news where rapzone='$mem->rapzone' or rapzone ='all' order by id desc";
	$res_mails=sql_execute($sql_query,'res');
	if(mysql_num_rows($res_mails)) {
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
  <?php $chk=1; ?>
  <?php while($row_mails=mysql_fetch_object($res_mails))	{
		if(!empty($row_mails->photo_thumb))	$img_dis="<img src='$row_mails->photo_thumb' border='0'>";
		else	$img_dis="";	
  ?>
  <tr> 
  	<td valign="top" align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <? 
		  if ($img_dis!="") { ?>
		  <td width="17%" height="25" valign="top" class="body" rowspan="4"><?=$img_dis?></td> <? } ?>
          <td width="83%" valign="top" class="body"><b> 
            <?=stripslashes($row_mails->title)?>
            </b></td>
        </tr>
        <tr> 
          <td colspan="2" class="body"><b> 
            <?=show_memnam($row_mails->own)?>
            </b>&nbsp;Posted on 
            <?=format_date($row_mails->dt)?>
            &nbsp;&nbsp; </td>
        </tr>
        <tr> 
          <td height="25" colspan="2" class="body"><b><?=LNG_RAPZONE_SOURCE?> :</b> 
            <?=stripslashes($row_mails->source)?>
          </td>
        </tr>
        <tr> 
          <td height="25" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class="body"><b><?=LNG_RAPZONE_LNK?> :</b> <a href="<?=$row_mails->link?>" target="_blank"> 
                  <?=$row_mails->link?>
                  </a> </td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2"> <table width="97%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class="body"> <? echo substr(stripslashes($row_mails->matt),0,100); ?>...&nbsp;<span style="valign :bottom"><a href="index.php?mode=login&act=news&typ=l&seid=<?=$row_mails->id?>&lng=<?=$lng_id?>"><img src="images/more.gif" alt="" border=0></a></span> &nbsp;&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
	  </tr>
	  <tr> 
		<td colspan="5" height="10"></td>
	  </tr>
	  <?php $chk++; ?>
	  <?php } ?>
	</table>
<?php
	}
}

function show_global_news()	{
	$m_id=cookie_get("mem_id");
	$sql_query="select rapzone from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$sql_query="select * from headlines where rapzone='$mem->rapzone' or rapzone='all' order by id desc";
	$res_mails=sql_execute($sql_query,'res');
	if(mysql_num_rows($res_mails)) {
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="hometitle" style="padding-left: 7" height="20"><?=LNG_LOGIN_GLOBAL_NEWS?></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
<?php $chk=1; ?>
<?php while($row_mails=mysql_fetch_object($res_mails))	{
	if(!empty($row_mails->photo_thumb))	$img_dis="<img src='$row_mails->photo_thumb' border='0'>";
	else	$img_dis="";	
?>
<tr> 
<? if ($img_dis!="") { ?>
<td valign="top">
  <?=$img_dis?>
</td> 
<td valign="top" align="left">
  <? } else { ?>
<td colspan="2" valign="middle" align="left">
<? } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
	  <td height="25" valign="top" class="body"><b> 
		<?=stripslashes($row_mails->title)?>
		</b></td>
	</tr>
	<tr> 
	  <td class="body"><b> 
		<?=show_memnam($row_mails->own)?>
		</b>&nbsp;Posted on 
		<?=format_date($row_mails->dt)?>
		&nbsp;&nbsp; 
	  </td>
	</tr>
	<tr> 
	  <td height="25" class="body"><b><?=LNG_RAPZONE_SOURCE?> :</b> 
		<?=stripslashes($row_mails->source)?>
	  </td>
	</tr>
	<tr> 
	  <td height="25"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr> 
			<td class="body"><b><?=LNG_RAPZONE_LNK?> :</b> 
			  <a href="<?=$row_mails->link?>" target="_blank"> 
			  <?=$row_mails->link?>
			  </a> </td>
		  </tr>
		</table></td>
	</tr>
	<tr> 
	  <td>&nbsp;</td>
	</tr>
	<tr> 
	  <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr> 
			<td class="body"> <? echo substr(stripslashes($row_mails->matt),0,200); ?>...&nbsp;<a href="index.php?mode=login&act=news&typ=g&seid=<?=$row_mails->id?>&lng=<?=$lng_id?>"><?=LNG_RAPZONE_FULL_STORY?></a> &nbsp;&nbsp;</td>
		  </tr>
		</table></td>
	</tr>
  </table></td>
</tr>
<tr> 
<td colspan="5" height="10"></td>
</tr>
<?php $chk++; ?>
<?php } ?>
</table>
<?php
	}
}

function fullstory()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	show_header();
	$typ=form_get("typ");
	$seid=form_get("seid");
	if($typ=='l')	$sql_query="select * from news where id='$seid'";
	else	$sql_query="select * from headlines where id='$seid'";
	$row=sql_execute($sql_query,'get');
	if(!empty($row->photo))	$img_dis="<img src='$row->photo' border='0'>";
	else	$img_dis="";
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="80%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp; 
<?=stripslashes($row->title)?>
</td>
  </tr>
<tr> 
    <td align="left" valign="top"> &nbsp;&nbsp; 
      <?=$img_dis?>
    </td>
  </tr>
  <tr> 
	<td></td>
  </tr>
  <tr> 
	<td align="left" valign="top" class="body"><table width="100%">
              <tr> 
                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_POSTED_BY?></b> 
                  <?=show_memnam($row->own)?>
                  <?=LNG_ON?> 
                  <?=format_date($row->dt)?>
                </td>
              </tr>
              <tr> 
                <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_RAPZONE_SOURCE?> :</b> 
                  <?=stripslashes($row->source)?>
                </td>
              </tr>
              <tr> 
                <td width="79%" class="body"><table width="80%" align="center">
                    <tr> 
                      <td class="body"><strong><?=LNG_RAPZONE_TEXT?> :</strong> 
                        <?=stripslashes($row->matt)?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_RAPZONE_PG_LNK?> :</b> <a href="<?=$row->link?>" target="_blank"> 
                  <?=$row->link?>
                  </a> </td>
              </tr>
              <tr> 
                <td colspan="3" align="center">&nbsp;</td>
              </tr>
            </table></td>
              </tr>
            </table></td>
  </tr></table></td><td width="10%" valign="top"><?=LNG_LOGIN_U_ARE_HERE?></td></tr></table>
<?
	show_footer();
}

function show_bullet($id)	{
	$sql_query="select * from bulletin where mem_id='$id' order by date desc limit 0,3";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
			echo "<tr><td class='dark header1 post-color1' colspan='2'>".LNG_LOGIN_MY_RECENT_BULT."</td></tr><tr><td colspan='2' class='padded-6'><table class='body lined' width='100%'>";
		while($row=mysql_fetch_object($res))	{
			echo "<tr><td class='body action'><a href='index.php?mode=bulletin&act=view&b_id=$row->id&lng=$lng_id'>".stripslashes($row->subj)."</a></td><td class='body'>".date("m/d/Y h:i A",$row->date)."</td></tr>";
		}
			echo "<tr><td align='right' colspan='2' class='body action'>[ <a href='index.php?mode=bulletin&act=mem_bullets&rec_id=$id&lng=$lng_id'>".LNG_LOGIN_VIEW_MY_B."</a> ]&nbsp;</td></tr></table></td></tr>";

	}
}
?>
