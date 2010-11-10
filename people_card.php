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
if($act==''){
 basics_profile();
}
elseif($act=='pers'){
 personal_profile();
}
elseif($act=='prof'){
 professional_profile();
}
elseif($act=='model'){
 model_profile();
}
elseif($act=='actor'){
 actor_profile();
}
elseif($act=='music'){
 music_profile();
}
elseif($act=='friends'){
 profile_friends("1");
}
elseif($act=='network'){
 profile_friends("all");
}

//showing friends of viewed person
function profile_friends($deg)	{
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$p_id=form_get("p_id");
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center class='body'>";
       if($deg=='1'){
       show_friends_deg($p_id,"10","5","$page","1");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($p_id,"friends","$page","10");
       }
       elseif($deg=='all'){
       show_friends_deg($p_id,"10","5","$page","all");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($p_id,"friendsall","$page","10");
       }
       echo "</td>
       </table>";
       show_footer();
}//function

//showing basics prodile
function basics_profile()	{
	
	global $lng_id;
	
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
//login_test($m_id,$m_pass);
if($m_id!=$p_id)	{
	$sql_query="update members set visitcount=visitcount+1 where mem_id='$p_id'";
	sql_execute($sql_query,'');
}
//updating user history of surfing the site
if($m_id!=''){
  $sql_query="select history from members where mem_id='$m_id'";
  $mem=sql_execute($sql_query,'get');
  $hist=split("\|",$mem->history);
  $hist=if_empty($hist);
  if($hist==''){
    $hist[]='';
  }
  $adding="index.php?mode=people_card&p_id=$p_id&lng=$lng_id";
 
  if(!in_array($adding,$hist)){
  $addon="|$adding|".name_header($p_id,$m_id);
  if(count($hist)>=10){
     for($i=2;$i<count($hist);$i++){
         $line.=$hist[$i]."|";
     }//for
     $line.=$addon;
     $sql_query="update members set history='$line' where mem_id='$m_id'";
  }//if
  else {
  $sql_query="update members set history=concat(history,'$addon') where mem_id='$m_id'";
  }//else
  sql_execute($sql_query,'');
  }//if
}//if
$now=time();
//updatin viewed person value 'views on you'
$sql_query="update members set views=concat(views,'|$now') where mem_id='$p_id'";
//sql_execute($sql_query,'');
show_header();
?>
<table border=0 width="100%" cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
    <tr>
		
      <td width=297 align=center valign=top height="577"> <!--LEFT TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
				<tr>
					<td>
						<table border=0 width=100% cellpadding=2 cellspacing=2>
							<tr>
								<td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_profile_photo($p_id); ?><br><? show_online($p_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="main-text">
                      
                    <li><a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($p_id,"1","num"); ?> 
                      <?=LNG_FRIENDS?></a></li>
                      
                    <li><a href="index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($m_id,"all","num"); ?> 
                      <?=LNG_PEOCARD_IN_NET?></a></li>
                      
                    <li><a href="index.php?mode=login&act=home&lng=<?=$lng_id?>"><?=LNG_HOME?></a></li>
                    </ul>
						</td>
							</tr>
							<tr>
								
                  <td colspan=2 class="main-text"><b><?=LNG_PROFILE_MS?></b>: <? echo member_since($p_id); ?> </td>
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
				
          <tr valign="top"> 
            <td> 
              <table border=0 cellpadding=2 cellspacing=2>
                <form name="#">
                  <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                  <tr> 
                    <td class="main-text" align=right>
                      <div align="left"><b><?=LNG_PEOCARD_MY_PROFILE?></b></div>
                    </td>
                    <td>&nbsp; </td>
                    <td> 
                      <div align="right"> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan=3 height="148"><b>
                      <ul class="main-text">
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=pers&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=prof&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                      </ul></b>
                    </td>
                  </tr>
                </form>
              </table>
            </td>
				</tr>
          <tr valign="top"> 
            <td height="197" align="left"> 
                <table border=0 cellpadding=2 cellspacing=2>
                  <form name="#">
                    <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                    <tr> 
                      <td class="main-text" align=right> 
                        <div align="left"><b><?=LNG_PEOCARD_WHT_CAN_I_DO?></b></div>
                      </td>
                      <td width="63"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" align="top" class="main-text">
					<b><ul class="main-text">
  <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
<li><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member&lng=<?=$lng_id?>"> 
        <?=LNG_BOOKMARKS?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
	<li><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PROFILE_UN_BK_MARK?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <li><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_SEND?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_A_MSG?> </a></li><br>
    <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
<li><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_REMOVE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_FROM_FRND?> </a></li><br>
    <?
           }
           else {
           ?>
<li><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_ADD?> <? echo name_header($p_id,$m_id); ?> <?=LNG_AS_A_FRIEND?> </a></li><br>
    <?
           }
           ?>
<li><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> <?=LNG_PROFILE_MK_INTRO?> </a></li><br>
<li><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_TO_GROUP?> </a></li><br>
    <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
<li><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } elseif($status==1){ ?>
<li><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_UN_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <?
        }
        else {
        //if user is viewing his own profile
        ?>
<li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_UR_PROFILE?> 
        </a></li><br>
<li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_BOOKMARK?> </a></li><br>
<li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_IGNORE_LIST?> </a></li><br>
<li><a href="index.php?mode=listing&act=myads&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_YOUR_LISTING?> </a></li><br>
<li><a href="index.php?mode=user&act=friends&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_FRIEND?> </a></li><br>
                      <li><a href="index.php?mode=listing&act=create&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_CRET_CLSS?></a></li>
                      <br>
                      <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_EMAIL?> </a></li>
    <?
        }
        ?>
</ul></b>
         </td>
         </tr>
         </form>
   </table>
            </td>
				</tr>
<tr><td align="center"><table border=0 cellpadding=2 cellspacing=2>
              <form name="#">
                <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
                <tr> 
                  <td class="main-text" align=right> <?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2 height="148" valign="top" align="center"><?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
              </form>
            </table></td></tr>				
			</table>
			
        <!--LEFT TABLE ENDS HERE--> <br>
        <br>
      </td>
		
      <td width=2 background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <!--CENTER TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
          <tr> 
            <td class="heading"><?=LNG_PEOCARD_BASIC_PROFILE?></td>
          </tr>
          <tr valign="top"> 
            <td class="main-text"> 
              <table border="0" width="100%" cellpadding="2" cellspacing="2" class="main-text">
              <tr class="main-text"> 
                <td valign="top">
				<? show_profile($p_id,"basic"); ?>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_LISTINGS_FROM?> <? echo name_header($p_id,$m_id); ?> &amp; <?=LNG_FRIENDS?></td>
          </tr>
          <tr> 
            
          <td align=center valign="top" class="main-text"> 
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr class="main-text"> 
                <td valign="top" class="main-text"> 
                  <? show_listings("inprofile",$p_id,''); ?>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_PROFILE_TST_FOR?> <? echo name_header($p_id,$m_id); ?></td>
          </tr>
          <tr> 
            <td class="main-text" align=center> 
              <table border=0 width=100% cellpadding=2 cellspacing=2>
                <tr class="main-text"> 
                  <td  class="main-text"> <? show_testimonials($p_id,$m_id); ?>
                  </td>
                  <td align=right>&nbsp;</td>
                </tr>
				<tr><td colspan="2" align="center"><?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id&lng=$lng_id\"' value='.".LNG_WRITE_TESTIMONIAL.".'>";
          }
        ?></td></tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      <td background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <br>
        <table border=0 cellpadding=5 cellspacing=5>
          <tr valign="top"> 
            
          <td height="179"> 
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
                        <a href="index.php?mode=user&act=friends_view&pro=1&lng=<?=$lng_id?>"><b><?=strtolower(LNG_FRIENDS)?></b></a> 
                        (1&deg;)<br>
                        <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
                        <?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br>
                        <? echo count_network($m_id,"3","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
                        <?=LNG_LOGIN_3_DEG_AWAY?><br>
                        <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
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
          </td>
          </tr>
          <tr valign="top"> 
            
          <td height="224"> 
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
            <div align="center"></div>
              <div align="center"></div>
            </td>
          </tr>
        </table>
      </td>
	</tr>
</table>
<? 
show_footer();
}

function personal_profile(){
global $main_url;
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table border=0 width="100%" cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
    <tr>
		
      <td width=297 align=center valign=top height="577"> <!--LEFT TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
				<tr>
					<td>
						<table border=0 width=100% cellpadding=2 cellspacing=2>
							<tr>
								<td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_profile_photo($p_id); ?><br><? show_online($p_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="main-text">
                      
                    <li><a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($p_id,"1","num"); ?> 
                      <?=LNG_FRIENDS?></a></li>
                      
                    <li><a href="index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($m_id,"all","num"); ?> 
                      <?=LNG_PEOCARD_IN_NET?></a></li>
                      
                    <li><a href="index.php?mode=login&act=home&lng=<?=$lng_id?>"><?=LNG_HOME?></a></li>
                    </ul>
						</td>
							</tr>
							<tr>
								
                  <td colspan=2 class="main-text"><b><?=LNG_PROFILE_MS?></b>: <? echo member_since($p_id); ?> </td>
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
				
          <tr valign="top"> 
            <td> 
              <table border=0 cellpadding=2 cellspacing=2>
                <form name="#">
                  <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                  <tr> 
                    <td class="main-text" align=right>
                      <div align="left"><b><?=LNG_PEOCARD_MY_PROFILE?></b></div>
                    </td>
                    <td>&nbsp; </td>
                    <td> 
                      <div align="right"> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan=3 height="148"><b>
                      <ul class="main-text">
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=pers&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=prof&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                      </ul></b>
                    </td>
                  </tr>
                </form>
              </table>
            </td>
				</tr>
          <tr valign="top"> 
            <td height="197" align="left"> 
                <table border=0 cellpadding=2 cellspacing=2>
                  <form name="#">
                    <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                    <tr> 
                      <td class="main-text" align=right> 
                        <div align="left"><b><?=LNG_PEOCARD_WHT_CAN_I_DO?></b></div>
                      </td>
                      <td width="63"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" align="top" class="main-text">
					<b><ul class="main-text">
  <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
<li><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member&lng=<?=$lng_id?>"> 
        <?=LNG_BOOKMARKS?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
	<li><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PROFILE_UN_BK_MARK?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <li><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_SEND?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_A_MSG?> </a></li><br>
    <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
<li><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_REMOVE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_FROM_FRND?> </a></li><br>
    <?
           }
           else {
           ?>
<li><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        Add <? echo name_header($p_id,$m_id); ?> <?=LNG_AS_A_FRIEND?> </a></li><br>
    <?
           }
           ?>
<li><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> <?=LNG_PROFILE_MK_INTRO?> </a></li><br>
<li><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_TO_GROUP?> </a></li><br>
    <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
<li><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } elseif($status==1){ ?>
<li><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_UN_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <?
        }
        else {
        //if user is viewing his own profile
        ?>
<li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_UR_PROFILE?> 
        </a></li><br>
<li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_BOOKMARK?> </a></li><br>
<li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_IGNORE_LIST?> </a></li><br>
<li><a href="index.php?mode=listing&act=myads&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_YOUR_LISTING?> </a></li><br>
<li><a href="index.php?mode=user&act=friends&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_FRIEND?> </a></li><br>
                      <li><a href="index.php?mode=listing&act=create&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_CRET_CLSS?></a></li>
                      <br>
                      <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_EMAIL?> </a></li>
    <?
        }
        ?>
</ul></b>
         </td>
         </tr>
         </form>
   </table>
            </td>
				</tr>
<tr><td align="center"><table border=0 cellpadding=2 cellspacing=2>
              <form name="#">
                <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
                <tr> 
                  <td class="main-text" align=right> <?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2 height="148" valign="top" align="center"><?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
              </form>
            </table></td></tr>				
			</table>
			
        <!--LEFT TABLE ENDS HERE--> <br>
        <br>
      </td>
		
      <td width=2 background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <!--CENTER TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
          <tr> 
            <td class="heading">Personal Profile</td>
          </tr>
          <tr valign="top"> 
            <td class="main-text"> 
              <table border="0" width="100%" cellpadding="2" cellspacing="2" class="main-text">
              <tr class="main-text"> 
                <td valign="top">
				<? show_profile($p_id,"personal"); ?>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_LISTINGS_FROM?> <? echo name_header($p_id,$m_id); ?> &amp; <?=LNG_FRIENDS?></td>
          </tr>
          <tr> 
            
          <td align=center valign="top" class="main-text"> 
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr class="main-text"> 
                <td valign="top" class="main-text"> 
                  <? show_listings("inprofile",$p_id,''); ?>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="0" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_PROFILE_TST_FOR?> <? echo name_header($p_id,$m_id); ?></td>
          </tr>
          <tr> 
            <td class="main-text" align=center> 
              <table border=0 width=100% cellpadding=2 cellspacing=2>
                <tr class="main-text"> 
                  <td  class="main-text"> <? show_testimonials($p_id,$m_id); ?>
                  </td>
                  <td align=right>&nbsp;</td>
                </tr>
				<tr><td colspan="2" align="center"><?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id&lng=$lng_id\"' value='".LNG_WRITE_TESTIMONIAL."'>";
          }
        ?></td></tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      <td background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <br>
      <table border=0 cellpadding=5 cellspacing=5>
        <tr valign="top"> 
          <td height="179"> 
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
                        (1&deg;)<br>
                        <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
                        <?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br>
                        <? echo count_network($m_id,"3","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
                        <?=LNG_LOGIN_3_DEG_AWAY?><br>
                        <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
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
          </td>
        </tr>
        <tr valign="top"> 
          <td height="224"> 
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
            <div align="center"></div>
            <div align="center"></div>
          </td>
        </tr>
      </table>
    </td>
	</tr>
</table>
<?
show_footer();
}

function professional_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table border=0 width="100%" cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
    <tr>
		
      <td width=297 align=center valign=top height="577"> <!--LEFT TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
				<tr>
					<td>
						<table border=0 width=100% cellpadding=2 cellspacing=2>
							<tr>
								<td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_profile_photo($p_id); ?><br><? show_online($p_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="main-text">
                      
                    <li><a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($p_id,"1","num"); ?> 
                      <?=LNG_FRIENDS?></a></li>
                      
                    <li><a href="index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($m_id,"all","num"); ?> 
                      <?=LNG_PEOCARD_IN_NET?></a></li>
                      
                    <li><a href="index.php?mode=login&act=home&lng=<?=$lng_id?>"><?=LNG_HOME?></a></li>
                    </ul>
						</td>
							</tr>
							<tr>
								
                  <td colspan=2 class="main-text"><b><?=LNG_PROFILE_MS?></b>: <? echo member_since($p_id); ?> </td>
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
				
          <tr valign="top"> 
            <td> 
              <table border=0 cellpadding=2 cellspacing=2>
                <form name="#">
                  <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                  <tr> 
                    <td class="main-text" align=right>
                      <div align="left"><b><?=LNG_PEOCARD_MY_PROFILE?></b></div>
                    </td>
                    <td>&nbsp; </td>
                    <td> 
                      <div align="right"> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan=3 height="148"><b>
                      <ul class="main-text">
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=pers&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=prof&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                      </ul></b>
                    </td>
                  </tr>
                </form>
              </table>
            </td>
				</tr>
          <tr valign="top"> 
            <td height="197" align="left"> 
                <table border=0 cellpadding=2 cellspacing=2>
                  <form name="#">
                    <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                    <tr> 
                      <td class="main-text" align=right> 
                        <div align="left"><b><?=LNG_PEOCARD_WHT_CAN_I_DO?></b></div>
                      </td>
                      <td width="63"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" align="top" class="main-text">
					<b><ul class="main-text">
  <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
<li><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member&lng=<?=$lng_id?>"> 
        <?=LNG_BOOKMARKS?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
	<li><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PROFILE_UN_BK_MARK?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <li><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_SEND?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_A_MSG?> </a></li><br>
    <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
<li><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_REMOVE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_FROM_FRND?> </a></li><br>
    <?
           }
           else {
           ?>
<li><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        Add <? echo name_header($p_id,$m_id); ?> <?=LNG_AS_A_FRIEND?> </a></li><br>
    <?
           }
           ?>
<li><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> <?=LNG_PROFILE_MK_INTRO?> </a></li><br>
<li><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_TO_GROUP?> </a></li><br>
    <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
<li><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } elseif($status==1){ ?>
<li><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_UN_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <?
        }
        else {
        //if user is viewing his own profile
        ?>
<li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_UR_PROFILE?> 
        </a></li><br>
<li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_BOOKMARK?> </a></li><br>
<li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_IGNORE_LIST?> </a></li><br>
<li><a href="index.php?mode=listing&act=myads&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_YOUR_LISTING?> </a></li><br>
<li><a href="index.php?mode=user&act=friends&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_FRIEND?> </a></li><br>
                      <li><a href="index.php?mode=listing&act=create&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_CRET_CLSS?></a></li>
                      <br>
                      <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_EMAIL?> </a></li>
    <?
        }
        ?>
</ul></b>
         </td>
         </tr>
         </form>
   </table>
            </td>
				</tr>
				<tr><td align="center"><table border=0 cellpadding=2 cellspacing=2>
              <form name="#">
                <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
                <tr> 
                  <td class="main-text" align=right> <?=LNG_LOGIN_U_ARE_HERE?> </td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2 height="148" valign="top" align="center"><?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
              </form>
            </table></td></tr>
			</table>
			
        <!--LEFT TABLE ENDS HERE--> <br>
        <br>
      </td>
		
      <td width=2 background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <!--CENTER TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
          <tr> 
            <td class="heading">Professional Profile</td>
          </tr>
          <tr valign="top"> 
            <td class="main-text"> 
              <table border="0" width="100%" cellpadding="2" cellspacing="2" class="main-text">
              <tr class="main-text"> 
                <td valign="top">
				<? show_profile($p_id,"professional"); ?>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_LISTINGS_FROM?> <? echo name_header($p_id,$m_id); ?> &amp; <?=LNG_FRIENDS?></td>
          </tr>
          <tr> 
            
          <td align=center valign="top" class="main-text"> 
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr class="main-text"> 
                <td valign="top" class="main-text"> 
                  <? show_listings("inprofile",$p_id,''); ?>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_PROFILE_TST_FOR?> <? echo name_header($p_id,$m_id); ?></td>
          </tr>
          <tr> 
            <td class="main-text" align=center> 
              <table border=0 width=100% cellpadding=2 cellspacing=2>
                <tr class="main-text"> 
                  <td  class="main-text"> <? show_testimonials($p_id,$m_id); ?>
                  </td>
                  <td align=right>&nbsp;</td>
                </tr>
				<tr><td colspan="2" align="center"><?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id&lng=$lng_id\"' value='".LNG_WRITE_TESTIMONIAL."'>";
          }
        ?></td></tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      <td background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <br>
      <table border=0 cellpadding=5 cellspacing=5>
        <tr valign="top"> 
          <td height="179"> 
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
                        (1&deg;)<br>
                        <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
                        <?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br>
                        <? echo count_network($m_id,"3","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
                        <?=LNG_LOGIN_3_DEG_AWAY?><br>
                        <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
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
          </td>
        </tr>
        <tr valign="top"> 
          <td height="224"> 
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
            <div align="center"></div>
            <div align="center"></div>
          </td>
        </tr>
      </table>
    </td>
	</tr>
</table>
<?
show_footer();
}

function model_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table border=0 width="100%" cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
    <tr>
		
      <td width=297 align=center valign=top height="577"> <!--LEFT TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
				<tr>
					<td>
						<table border=0 width=100% cellpadding=2 cellspacing=2>
							<tr>
								<td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_model_photo($p_id); ?><br><? show_online($p_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="main-text">
                      
                    <li><a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($p_id,"1","num"); ?> 
                      <?=LNG_FRIENDS?></a></li>
                      
                    <li><a href="index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($m_id,"all","num"); ?> 
                      <?=LNG_PEOCARD_IN_NET?></a></li>
                      
                    <li><a href="index.php?mode=login&act=home&lng=<?=$lng_id?>"><?=LNG_HOME?></a></li>
                    </ul>
						</td>
							</tr>
							<tr>
								
                  <td colspan=2 class="main-text"><b><?=LNG_PROFILE_MS?></b>: <? echo member_since($p_id); ?> </td>
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
				
          <tr valign="top"> 
            <td> 
              <table border=0 cellpadding=2 cellspacing=2>
                <form name="#">
                  <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                  <tr> 
                    <td class="main-text" align=right>
                      <div align="left"><b><?=LNG_PEOCARD_MY_PROFILE?></b></div>
                    </td>
                    <td>&nbsp; </td>
                    <td> 
                      <div align="right"> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan=3 height="148"><b>
                      <ul class="main-text">
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=pers&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=prof&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>

                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                      </ul></b>
                    </td>
                  </tr>
                </form>
              </table>
            </td>
				</tr>
          <tr valign="top"> 
            <td height="197" align="left"> 
                <table border=0 cellpadding=2 cellspacing=2>
                  <form name="#">
                    <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                    <tr> 
                      <td class="main-text" align=right> 
                        <div align="left"><b><?=LNG_PEOCARD_WHT_CAN_I_DO?></b></div>
                      </td>
                      <td width="63"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" align="top" class="main-text">
					<b><ul class="main-text">
  <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
<li><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member&lng=<?=$lng_id?>"> 
        <?=LNG_BOOKMARKS?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
	<li><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PROFILE_UN_BK_MARK?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <li><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_SEND?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_A_MSG?> </a></li><br>
    <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
<li><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_REMOVE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_FROM_FRND?> </a></li><br>
    <?
           }
           else {
           ?>
<li><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_ADD?> <? echo name_header($p_id,$m_id); ?> <?=LNG_AS_A_FRIEND?> </a></li><br>
    <?
           }
           ?>
<li><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> <?=LNG_PROFILE_MK_INTRO?> </a></li><br>
<li><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_TO_GROUP?> </a></li><br>
    <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
<li><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } elseif($status==1){ ?>
<li><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_UN_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <?
        }
        else {
        //if user is viewing his own profile
        ?>
<li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_UR_PROFILE?> 
        </a></li><br>
<li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_BOOKMARK?> </a></li><br>
<li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_IGNORE_LIST?> </a></li><br>
<li><a href="index.php?mode=listing&act=myads&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_YOUR_LISTING?> </a></li><br>
<li><a href="index.php?mode=user&act=friends&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_FRIEND?> </a></li><br>
                      <li><a href="index.php?mode=listing&act=create&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_CRET_CLSS?></a></li>
                      <br>
                      <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_EMAIL?> </a></li>
    <?
        }
        ?>
</ul></b>
         </td>
         </tr>
         </form>
   </table>
            </td>
				</tr>
				<tr><td align="center"><table border=0 cellpadding=2 cellspacing=2>
              <form name="#">
                <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
                <tr> 
                  <td class="main-text" align=right> <?=LNG_LOGIN_U_ARE_HERE?> </td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2 height="148" valign="top" align="center"><?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
              </form>
            </table></td></tr>
			</table>
			
        <!--LEFT TABLE ENDS HERE--> <br>
        <br>
      </td>
		
      <td width=2 background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <!--CENTER TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
          <tr> 
            <td class="heading"><?=LNG_PEOCARD_MODEL_PROFILE?></td>
          </tr>
          <tr valign="top"> 
            <td class="main-text"> 
              <table border="0" width="100%" cellpadding="2" cellspacing="2" class="main-text">
              <tr class="main-text"> 
                <td valign="top">
				<? show_profile($p_id,"model"); ?>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_LISTINGS_FROM?> <? echo name_header($p_id,$m_id); ?> &amp; <?=LNG_FRIENDS?></td>
          </tr>
          <tr> 
            
          <td align=center valign="top" class="main-text"> 
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr class="main-text"> 
                <td valign="top" class="main-text"> 
                  <? show_listings("inprofile",$p_id,''); ?>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_PROFILE_TST_FOR?> <? echo name_header($p_id,$m_id); ?></td>
          </tr>
          <tr> 
            <td class="main-text" align=center> 
              <table border=0 width=100% cellpadding=2 cellspacing=2>
                <tr class="main-text"> 
                  <td  class="main-text"> <? show_testimonials($p_id,$m_id); ?>
                  </td>
                  <td align=right>&nbsp;</td>
                </tr>
				<tr><td colspan="2" align="center"><?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id&lng=$lng_id\"' value='".LNG_WRITE_TESTIMONIAL."'>";
          }
        ?></td></tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      <td background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <br>
      <table border=0 cellpadding=5 cellspacing=5>
        <tr valign="top"> 
          <td height="179"> 
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
                        (1&deg;)<br>
                        <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
                        <?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br>
                        <? echo count_network($m_id,"3","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
                        <?=LNG_LOGIN_3_DEG_AWAY?><br>
                        <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
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
          </td>
        </tr>
        <tr valign="top"> 
          <td height="224"> 
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
            <div align="center"></div>
            <div align="center"></div>
          </td>
        </tr>
      </table>
    </td>
	</tr>
</table>
<?
show_footer();
}
function actor_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table border=0 width="100%" cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
    <tr>
		
      <td width=297 align=center valign=top height="577"> <!--LEFT TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
				<tr>
					<td>
						<table border=0 width=100% cellpadding=2 cellspacing=2>
							<tr>
								<td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_actor_photo($p_id); ?><br><? show_online($p_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="main-text">
                      
                    <li><a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($p_id,"1","num"); ?> 
                      <?=LNG_FRIENDS?></a></li>
                      
                    <li><a href="index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($m_id,"all","num"); ?> 
                      <?=LNG_PEOCARD_IN_NET?></a></li>
                      
                    <li><a href="index.php?mode=login&act=home&lng=<?=$lng_id?>"><?=LNG_HOME?></a></li>
                    </ul>
						</td>
							</tr>
							<tr>
								
                  <td colspan=2 class="main-text"><b><?=LNG_PROFILE_MS?></b>: <? echo member_since($p_id); ?> </td>
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
				
          <tr valign="top"> 
            <td> 
              <table border=0 cellpadding=2 cellspacing=2>
                <form name="#">
                  <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                  <tr> 
                    <td class="main-text" align=right>
                      <div align="left"><b><?=LNG_PEOCARD_MY_PROFILE?></b></div>
                    </td>
                    <td>&nbsp; </td>
                    <td> 
                      <div align="right"> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan=3 height="148"><b>
                      <ul class="main-text">
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=pers&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=prof&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                      </ul></b>
                    </td>
                  </tr>
                </form>
              </table>
            </td>
				</tr>
          <tr valign="top"> 
            <td height="197" align="left"> 
                <table border=0 cellpadding=2 cellspacing=2>
                  <form name="#">
                    <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                    <tr> 
                      <td class="main-text" align=right> 
                        <div align="left"><b><?=LNG_PEOCARD_WHT_CAN_I_DO?></b></div>
                      </td>
                      <td width="63"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" align="top" class="main-text">
					<b><ul class="main-text">
  <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
<li><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member&lng=<?=$lng_id?>"> 
        <?=LNG_BOOKMARKS?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
	<li><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PROFILE_UN_BK_MARK?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <li><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_SEND?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_A_MSG?> </a></li><br>
    <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
<li><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_REMOVE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_FROM_FRND?> </a></li><br>
    <?
           }
           else {
           ?>
<li><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_ADD?> <? echo name_header($p_id,$m_id); ?> <?=LNG_AS_A_FRIEND?> </a></li><br>
    <?
           }
           ?>
<li><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> <?=LNG_PROFILE_MK_INTRO?> </a></li><br>
<li><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_TO_GROUP?> </a></li><br>
    <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
<li><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } elseif($status==1){ ?>
<li><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_UN_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <?
        }
        else {
        //if user is viewing his own profile
        ?>
<li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_UR_PROFILE?> 
        </a></li><br>
<li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_BOOKMARK?> </a></li><br>
<li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_IGNORE_LIST?> </a></li><br>
<li><a href="index.php?mode=listing&act=myads&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_YOUR_LISTING?> </a></li><br>
<li><a href="index.php?mode=user&act=friends&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_FRIEND?> </a></li><br>
                      <li><a href="index.php?mode=listing&act=create&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_CRET_CLSS?></a></li>
                      <br>
                      <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_EMAIL?> </a></li>
    <?
        }
        ?>
</ul></b>
         </td>
         </tr>
         </form>
   </table>
            </td>
				</tr>
				<tr><td align="center"><table border=0 cellpadding=2 cellspacing=2>
              <form name="#">
                <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
                <tr> 
                  <td class="main-text" align=right> <?=LNG_LOGIN_U_ARE_HERE?> </td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2 height="148" valign="top" align="center"><?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
              </form>
            </table></td></tr>
			</table>
			
        <!--LEFT TABLE ENDS HERE--> <br>
        <br>
      </td>
		
      <td width=2 background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <!--CENTER TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
          <tr> 
            <td class="heading"><?=LNG_PEOCARD_AA_PROFILE?></td>
          </tr>
          <tr valign="top"> 
            <td class="main-text"> 
              <table border="0" width="100%" cellpadding="2" cellspacing="2" class="main-text">
              <tr class="main-text"> 
                <td valign="top">
				<? show_profile($p_id,"actor"); ?>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_LISTINGS_FROM?> <? echo name_header($p_id,$m_id); ?> &amp; <?=LNG_FRIENDS?></td>
          </tr>
          <tr> 
            
          <td align=center valign="top" class="main-text"> 
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr class="main-text"> 
                <td valign="top" class="main-text"> 
                  <? show_listings("inprofile",$p_id,''); ?>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_PROFILE_TST_FOR?> <? echo name_header($p_id,$m_id); ?></td>
          </tr>
          <tr> 
            <td class="main-text" align=center> 
              <table border=0 width=100% cellpadding=2 cellspacing=2>
                <tr class="main-text"> 
                  <td  class="main-text"> <? show_testimonials($p_id,$m_id); ?>
                  </td>
                <td align=right>&nbsp;</td>
                </tr>
				<tr><td colspan="2" align="center"><?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id&lng=$lng_id\"' value='".LNG_WRITE_TESTIMONIAL."'>";
          }
        ?></td></tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      <td background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <br>
      <table border=0 cellpadding=5 cellspacing=5>
        <tr valign="top"> 
          <td height="179"> 
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
                        (1&deg;)<br>
                        <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
                        <?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br>
                        <? echo count_network($m_id,"3","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
                        <?=LNG_LOGIN_3_DEG_AWAY?><br>
                        <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
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
          </td>
        </tr>
        <tr valign="top"> 
          <td height="224"> 
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
            <div align="center"></div>
            <div align="center"></div>
          </td>
        </tr>
      </table>
    </td>
	</tr>
</table>
<?
show_footer();
}
function music_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table border=0 width="100%" cellpadding=0 cellspacing=0 bgcolor="#FFFFFF">
    <tr>
		
      <td width=297 align=center valign=top height="577"> <!--LEFT TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
				<tr>
					<td>
						<table border=0 width=100% cellpadding=2 cellspacing=2>
							<tr>
								<td colspan=2 class="title"><?=LNG_MY_PROFILE?></td>
							</tr>
							<tr>
								
                  <td align=center class="mail-text" width="43%"><? show_profile_photo($p_id); ?><br><? show_online($p_id); ?></td>
								
                  <td width="57%"> 
                    <ul class="main-text">
                      
                    <li><a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($p_id,"1","num"); ?> 
                      <?=LNG_FRIENDS?></a></li>
                      
                    <li><a href="index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"><? echo count_network($m_id,"all","num"); ?> 
                      <?=LNG_PEOCARD_IN_NET?></a></li>
                      
                    <li><a href="index.php?mode=login&act=home&lng=<?=$lng_id?>"><?=LNG_HOME?></a></li>
                    </ul>
						</td>
							</tr>
							<tr>
								
                  <td colspan=2 class="main-text"><b><?=LNG_PROFILE_MS?></b>: <? echo member_since($p_id); ?> </td>
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
				
          <tr valign="top"> 
            <td> 
              <table border=0 cellpadding=2 cellspacing=2>
                <form name="#">
                  <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                  <tr> 
                    <td class="main-text" align=right>
                      <div align="left"><b><?=LNG_PEOCARD_MY_PROFILE?></b></div>
                    </td>
                    <td>&nbsp; </td>
                    <td> 
                      <div align="right"> </div>
                    </td>
                  </tr>
                  <tr> 
                    <td colspan=3 height="148"><b>
                      <ul class="main-text">
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&lng=<?=$lng_id?>"><?=LNG_BASIC?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=pers&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></li>
                        <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=prof&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></li>
                        
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=music&lng=<?=$lng_id?>"><?=LNG_LOGIN_ART_MUSI?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></li>
                      <li><a href="index.php?mode=people_card&p_id=<?=$p_id?>&act=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></li>
                      </ul></b>
                    </td>
                  </tr>
                </form>
              </table>
            </td>
				</tr>
          <tr valign="top"> 
            <td height="197" align="left"> 
                <table border=0 cellpadding=2 cellspacing=2>
                  <form name="#">
                    <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
                    <tr> 
                      <td class="main-text" align=right> 
                        <div align="left"><b><?=LNG_PEOCARD_WHT_CAN_I_DO?></b></div>
                      </td>
                      <td width="63"> 
                        <div align="right"> </div>
                      </td>
                    </tr>
                    <tr> 
                      <td colspan="2" align="top" class="main-text">
					<b><ul class="main-text">
  <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
<li><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member&lng=<?=$lng_id?>"> 
        <?=LNG_BOOKMARKS?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
	<li><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PROFILE_UN_BK_MARK?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <li><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_SEND?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_A_MSG?> </a></li><br>
    <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
<li><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_REMOVE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_FROM_FRND?> </a></li><br>
    <?
           }
           else {
           ?>
<li><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_ADD?> <? echo name_header($p_id,$m_id); ?> <?=LNG_AS_A_FRIEND?> </a></li><br>
    <?
           }
           ?>
<li><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> <?=LNG_PROFILE_MK_INTRO?> </a></li><br>
<li><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> <?=LNG_PEOCARD_TO_GROUP?> </a></li><br>
    <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
<li><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } elseif($status==1){ ?>
<li><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>&lng=<?=$lng_id?>"> 
        <?=LNG_PEOCARD_UN_IGNORE?> <? echo name_header($p_id,$m_id); ?> </a></li><br>
    <? } ?>
    <?
        }
        else {
        //if user is viewing his own profile
        ?>
<li><a href="index.php?mode=user&act=profile&pro=edit&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_UR_PROFILE?> 
        </a></li><br>
<li><a href="index.php?mode=user&act=bmarks&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_BOOKMARK?> </a></li><br>
<li><a href="index.php?mode=user&act=ignore&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_EDIT_IGNORE_LIST?> </a></li><br>
<li><a href="index.php?mode=listing&act=myads&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_YOUR_LISTING?> </a></li><br>
<li><a href="index.php?mode=user&act=friends&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_FRIEND?> </a></li><br>
                      <li><a href="index.php?mode=listing&act=create&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_CRET_CLSS?></a></li>
                      <br>
                      <li><a href="index.php?mode=messages&act=inbox&lng=<?=$lng_id?>"> <?=LNG_PEOCARD_VIEW_UR_EMAIL?> </a></li>
    <?
        }
        ?>
</ul></b>
         </td>
         </tr>
         </form>
   </table>
            </td>
				</tr>
				<tr><td align="center"><table border=0 cellpadding=2 cellspacing=2>
              <form name="#">
                <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
                <tr> 
                  <td class="main-text" align=right> <?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
                <tr> 
                  <td class="main-text" colspan=2 height="148" valign="top" align="center"><?=LNG_LOGIN_U_ARE_HERE?></td>
                </tr>
              </form>
            </table></td></tr>
			</table>
			
        <!--LEFT TABLE ENDS HERE--> <br>
        <br>
      </td>
		
      <td width=2 background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <!--CENTER TABLE STARTS HERE--> 
        <table border=0 cellpadding=5 cellspacing=5>
          <tr> 
            <td class="heading"><?=LNG_PEOCARD_ADD_MUSIC_PRO?></td>
          </tr>
          <tr valign="top"> 
            <td class="main-text"> 
              <table border="0" width="100%" cellpadding="2" cellspacing="2" class="main-text">
              <tr class="main-text"> 
                <td valign="top">
				<? show_profile($p_id,"music"); ?>
				</td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_LISTINGS_FROM?> <? echo name_header($p_id,$m_id); ?> &amp; <?=LNG_FRIENDS?></td>
          </tr>
          <tr> 
            
          <td align=center valign="top" class="main-text"> 
            <table border=0 width=100% cellpadding=2 cellspacing=2>
              <tr class="main-text"> 
                <td valign="top" class="main-text"> 
                  <? show_listings("inprofile",$p_id,''); ?>
                </td>
              </tr>
            </table>
            </td>
          </tr>
          <tr> 
            <td align=center><img src="images/orange-dot.gif" alt="" border=0 width=400 height=1></td>
          </tr>
          <tr> 
            <td class="heading"><?=LNG_PROFILE_TST_FOR?> <? echo name_header($p_id,$m_id); ?></td>
          </tr>
          <tr> 
            <td class="main-text" align=center> 
              <table border=0 width=100% cellpadding=2 cellspacing=2>
                <tr class="main-text"> 
                  <td  class="main-text"> <? show_testimonials($p_id,$m_id); ?>
                  </td>
                  <td align=right>&nbsp;</td>
                </tr>
				<tr><td colspan="2" align="center"><?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id&lng=$lng_id\"' value='".LNG_WRITE_TESTIMONIAL."'>";
          }
        ?></td></tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <p><br>
          <!--CENTER TABLE ENDS HERE--> </p>
      </td>
		
      <td background="images/dot-line.gif" height="577"><img src="images/spacer.gif" alt="" border=0 width=2 height=1></td>
		
      <td align=center valign=top height="577"> <br>
      <table border=0 cellpadding=5 cellspacing=5>
        <tr valign="top"> 
          <td height="179"> 
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
                        (1&deg;)<br>
                        <? echo count_network($m_id,"2","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=2&lng=<?=$lng_id?>"><b><?=LNG_FRIENDS?></b></a> 
                        <?=LNG_LOGIN_OF_FRNDS?> (2&deg;)<br>
                        <? echo count_network($m_id,"3","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=3&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
                        <?=LNG_LOGIN_3_DEG_AWAY?><br>
                        <? echo count_network($m_id,"4","num"); ?> <a href="index.php?mode=user&act=friends_view&pro=4&lng=<?=$lng_id?>"><b><?=LNG_LOGIN_PEOPLE?></b></a> 
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
          </td>
        </tr>
        <tr valign="top"> 
          <td height="224"> 
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
            <div align="center"></div>
            <div align="center"></div>
          </td>
        </tr>
      </table>
    </td>
	</tr>
</table>
<?
show_footer();
}
?>
