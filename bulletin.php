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
if(empty($act))	manage_bullets();
elseif($act=='create')	create();
elseif($act=='view')	view();
elseif($act=='postcomment')	postcomment();
elseif($act=='edi')	modify();
elseif($act=='del')	delet();
elseif($act=='mem_bullets')	mem_bullets();

function manage_bullets()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$page=form_get("page");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	$sql_query="select * from bulletin order by date desc limit $start,20";
	$p_sql="select * from bulletin order by date desc";
	$p_url="index.php?mode=bulletin&lng=" . $lng_id;
	$res=sql_execute($sql_query,'res');
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined body">
  <tr> 
    <td class="title">&nbsp;<?=LNG_BULLETEIN?></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td><table width="59%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="30%" class="action"><a href="index.php?mode=bulletin&act=mem_bullets&rec_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_MY_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&lng=<?=$lng_id?>"><?=LNG_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&act=create&lng=<?=$lng_id?>"><?=LNG_CREATE_NEW_BULLETEIN?></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan="2" height="5"></td></tr>
  <? if(mysql_num_rows($res)) { ?>
  <tr> 
    <td colspan="2" align="center" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
        <tr> 
          <td width="16%" class="body">&nbsp;<strong><?=LNG_FROM?></strong></td>
          <td width="39%" class="body">&nbsp;<strong><?=LNG_SUBJECT?></strong></td>
          <td colspan="2" class="body">&nbsp;<strong><?=LNG_DATE?></strong></td>
        </tr>
        <? while($row=mysql_fetch_object($res)) { ?>
        <tr> 
          <td class="body">&nbsp;<? echo show_photo($row->mem_id); ?><br>&nbsp;<? echo show_online($row->mem_id); ?></td>
          <td class="body">&nbsp;<a href="index.php?mode=bulletin&act=view&b_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=stripslashes($row->subj)?></a></td>
          <td width="26%" class="body">&nbsp;<? echo date("m/d/Y h:i A",$row->date); ?></td>
          <td width="19%" align="center" class="body">
            <? if($row->mem_id==$m_id) { ?>
            <a href="index.php?mode=bulletin&act=edi&b_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a> / <a href="index.php?mode=bulletin&act=del&b_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>
            <? } ?>
          </td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
  <tr> 
    <td colspan="2" align="center" valign="top" class="body"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
  <? } else { ?>
    <tr>
          <td colspan="2" align="center" class="body"><?=LNG_EMPTY_BULLETIN?></td>
        </tr>
  <? } ?>
  <tr><td colspan="2" height="5"></td></tr>
</table>
</td>
  </tr>
</table>
<?
	show_footer();
}

function create()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$done=form_get("done");
	if(empty($done))	{
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;<?=LNG_BULLETEIN?></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td><table width="59%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="30%" class="action"><a href="index.php?mode=bulletin&act=mem_bullets&rec_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_MY_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&lng=<?=$lng_id?>"><?=LNG_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&act=create&lng=<?=$lng_id?>"><?=LNG_CREATE_NEW_BULLETEIN?></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
  <tr><td height="5"></td></tr>
  <tr>
    <td align="center" valign="top"><form action="index.php" method="post">
        <table width="75%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td height="25" colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td width="19%" height="30" align="center" class="body"><?=LNG_SUBJECT?></td>
            <td width="81%">&nbsp;
				<input name="subj" type="text" id="subj" size="45"></td>
          </tr>
          <tr> 
            <td height="30" align="center" class="body"><?=LNG_BODY?></td>
            <td>&nbsp;
				<textarea name="body" cols="45" rows="5" id="body"></textarea></td>
          </tr>
          <tr> 
            <td height="30" colspan="2" align="right"> 
              <input name="done" type="hidden" id="done" value="done"> 
              <input name="act" type="hidden" id="act" value="create"> <input name="mode" type="hidden" id="mode" value="bulletin"> 
              <input type="submit" name="Submit" value="<?=LNG_BULATIN_PB?>" class="submit"></td>
          </tr>
        </table>
</form>
</td>
  </tr>
</table>
	</td>
	</tr>
</table>
<?
			show_footer();
		}	else	{
			$subj=form_get("subj");
			$body=form_get("body");
			$dt=time();
			$sql_query="insert into bulletin (mem_id,subj,body,date) values ('$m_id','".addslashes($subj)."','".addslashes($body)."','$dt')";
			sql_execute($sql_query,'');
			manage_bullets();
		}
}

function view()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$b_id=form_get("b_id");
	$sql_query="select * from bulletin where id='$b_id'";
	$bull=sql_execute($sql_query,'get');
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;<?=LNG_BULLETEIN?></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td><table width="59%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="30%" class="action"><a href="index.php?mode=bulletin&act=mem_bullets&rec_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_MY_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&lng=<?=$lng_id?>"><?=LNG_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&act=create&lng=<?=$lng_id?>"><?=LNG_CREATE_NEW_BULLETEIN?></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan="2" height="5"></td></tr>
  <tr> 
    <td colspan="2" align="center" valign="top"><table width="75%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="31%" class="body"><strong><?=LNG_FROM?> :</strong></td>
          <td width="69%" class="body">&nbsp;<? echo show_photo($bull->mem_id); ?><br> &nbsp;<? echo show_online($bull->mem_id); ?></td>
        </tr>
        <tr> 
          <td class="body"><strong><?=LNG_FROM?> :</strong></td>
          <td class="body">&nbsp;<? echo date("m/d/Y h:i A",$bull->date); ?></td>
        </tr>
        <tr> 
          <td class="body"><strong><?=LNG_SUBJECT?> :</strong></td>
          <td class="body">&nbsp;<?=stripslashes($bull->subj)?>
          </td>
        </tr>
        <tr> 
          <td class="body"><strong><?=LNG_BODY?> :</strong></td>
          <td class="body">&nbsp;<?=stripslashes($bull->body)?>
          </td>
        </tr>
        <tr>
          <td class="body">&nbsp;</td>
          <td align="right" class="body action"> <? if($bull->mem_id==$m_id) { ?><a href="index.php?mode=bulletin&act=edi&b_id=<?=$b_id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a> / <a href="index.php?mode=bulletin&act=del&b_id=<?=$b_id?>"><?=LNG_DELETE?></a> / <? } ?><a href="index.php?mode=bulletin&act=postcomment&b_id=<?=$b_id?>&lng=<?=$lng_id?>"><?=LNG_POST_COMMENT?></a>&nbsp;&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr><td colspan="2" height="5"></td></tr>
</table>
</td>
	</tr>
</table>
<?
	show_footer();
}

function postcomment()	{
	global $main_url;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$b_id=form_get("b_id");
	$done=form_get("done");
	if(empty($done))	{
		$sql_query="select * from bulletin where id='$b_id'";
		$bull=sql_execute($sql_query,'get');
		show_header();
?>
<form action="index.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;<?=LNG_BULLETEIN?></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td><table width="59%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="30%" class="action"><a href="index.php?mode=bulletin&act=mem_bullets&rec_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_MY_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&lng=<?=$lng_id?>"><?=LNG_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&act=create&lng=<?=$lng_id?>"><?=LNG_CREATE_NEW_BULLETEIN?></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan="2" height="5"></td></tr>
  <tr> 
    <td colspan="2" align="center" valign="top"><table width="75%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
          <td width="31%" class="body"><strong><?=LNG_TO?> :</strong></td>
          <td width="69%" class="body">&nbsp;<? echo show_photo($bull->mem_id); ?><br> &nbsp;<? echo show_online($bull->mem_id); ?>
		  <input type="hidden" name="mode" value="bulletin">
		  <input type="hidden" name="act" value="postcomment">
		  <input type="hidden" name="done" value="done">
		  <input type="hidden" name="rec_id" value="<?=$bull->mem_id?>">
              <input name="b_id" type="hidden" id="b_id" value="<?=$b_id?>"> </td>
        </tr>
        <tr> 
            <td height="30" class="body"><strong><?=LNG_SUBJECT?> :</strong></td>
            <td height="30">&nbsp;<input name="subject" type="text" id="subject" value="<?=LNG_RE?><?=stripslashes($bull->subj)?>" size="40">
          </td>
        </tr>
        <tr> 
          <td class="body"><strong><?=LNG_BODY?> :</strong></td>
          <td>&nbsp;<textarea name="answer" cols="40" rows="5" id="answer"></textarea>
          </td>
        </tr>
        <tr>
          <td class="caption">&nbsp;</td>
          <td align="right"><input type="submit" value="<?=LNG_SEND?>" class="submit">&nbsp;&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr><td colspan="2" height="5"></td></tr>
</table></td>
</tr></table>
</form>
<?
		show_footer();
	}	else	{
		$subject=form_get("subject");
		$answer=form_get("answer");
		$rec_id=form_get("rec_id");
		$b_id=form_get("b_id");
		$now=time();
		//checkin recipient ignore list
		$sql_query="select ignore_list from members where mem_id='$rec_id'";
		$ign=sql_execute($sql_query,'get');
		$ignore=split("\|",$ign->ignore);
		$ignore=if_empty($ignore);
		if($ignore!='')	{
			foreach($ignore as $ig)	{
				if($ig==$m_id)	{
					$flag=1;
					break;
				}
			}
		}
		//saving message in user's sent folder and recipient inbox
		//if not ignored
		if($flag!=1)	{
			$sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date) values ('$rec_id','$m_id','".addslashes($subject)."','".addslashes($answer)."','message','new','inbox','$now')";
			sql_execute($sql_query,'');
			$data[0]=$subj;
			$data[1]=$body."<br>" . LNG_BULATIN_CLICK . "<a href='$main_url'>" . LNG_LOGIN . "</a>" . LNG_BULATIN_OR . "<a href='$main_url/index.php?mode=join&lng=$lng_id'>" . LNG_JOIN . "</a>.";
			$data[2]=name_header($m_id,"ad");
			$sql_query="select email from members where mem_id='$m_id'";
			$k=sql_execute($sql_query,'get');
			$data[3]=$k->email;
			$sql_query="select email from members where mem_id='$rec_id'";
			$t=sql_execute($sql_query,'get');
			messages($t->email,"7",$data);
		}
		$sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date) values ('$m_id','$rec_id','".addslashes($subject)."','".addslashes($answer)."','message','new','sent','$now')";
		sql_execute($sql_query,'');
		$link="index.php?mode=bulletin&lng=" . $lng_id;
		show_screen($link);
	}
}

function modify()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$b_id=form_get("b_id");
	$done=form_get("done");
	if(empty($done))	{
		$sql_query="select * from bulletin where id='$b_id'";
		$bull=sql_execute($sql_query,'get');
		show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;<?=LNG_BULLETEIN?></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td><table width="59%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="30%" class="action"><a href="index.php?mode=bulletin&act=mem_bullets&rec_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_MY_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&lng=<?=$lng_id?>"><?=LNG_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&act=create&lng=<?=$lng_id?>"><?=LNG_CREATE_NEW_BULLETEIN?></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="top"><form action="index.php" method="post">
        <table width="75%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td height="25" colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td width="19%" height="30" align="center" class="body"><strong><?=LNG_SUBJECT?></strong> </td>
            <td width="81%">&nbsp;
<input name="subj" type="text" id="subj" value="<?=stripslashes($bull->subj)?>" size="45"></td>
          </tr>
          <tr> 
            <td height="30" align="center" class="body"><strong><?=LNG_BODY?></strong></td>
            <td>&nbsp;
<textarea name="body" cols="45" rows="5" id="body"><?=stripslashes($bull->body)?></textarea></td>
          </tr>
          <tr> 
            <td height="30" colspan="2" align="right"> 
              <input name="done" type="hidden" id="done" value="done"> <input name="b_id" type="hidden" id="b_id" value="<?=$b_id?>">
              <input name="act" type="hidden" id="act" value="edi"> <input name="mode" type="hidden" id="mode" value="bulletin"> 
              <input type="submit" name="Submit" value="<?=LNG_BULATIN_MDFY?>" class="submit"></td>
          </tr>
        </table>
</form>
</td>
  </tr>
</table></td>
</tr></table>
<?
			show_footer();
		}	else	{
			$subj=form_get("subj");
			$body=form_get("body");
			$b_id=form_get("b_id");
			$sql_query="update bulletin set subj='".addslashes($subj)."',body='".addslashes($body)."' where id='$b_id'";
			sql_execute($sql_query,'');
			$link="index.php?mode=bulletin&act=view&b_id=$b_id&lng=" . $lng_id;
			show_screen($link);
		}
}

function delet()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$b_id=form_get("b_id");
	$sql_query="delete from bulletin where id='$b_id'";
	sql_execute($sql_query,'');
	manage_bullets();
}

function mem_bullets()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	$page=form_get("page");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	$sql_query="select * from bulletin where mem_id='$rec_id' order by date desc limit $start,20";
	$p_sql="select * from bulletin where mem_id='$rec_id' order by date desc";
	$p_url="index.php?mode=bulletin&act=mem_bullets&rec_id=$rec_id&lng=" . $lng_id;
	$res=sql_execute($sql_query,'res');
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;<?=LNG_BULLETEIN?></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td><table width="59%" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="30%" class="action"><a href="index.php?mode=bulletin&act=mem_bullets&rec_id=<?=$m_id?>&lng=<?=$lng_id?>"><?=LNG_MY_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&lng=<?=$lng_id?>"><?=LNG_BULLETEIN_LIST?></a></td>
                <td width="28%" class="action"><a href="index.php?mode=bulletin&act=create&lng=<?=$lng_id?>"><?=LNG_CREATE_NEW_BULLETEIN?></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td height="5"></td></tr>
  <? if(mysql_num_rows($res)) { ?>
  <tr> 
    <td align="center" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="16%" class="body">&nbsp;<strong><?=LNG_FROM?></strong></td>
          <td width="39%" class="body">&nbsp;<strong><?=LNG_SUBJECT?></strong></td>
          <td colspan="2" class="body">&nbsp;<strong><?=LNG_DATE?></strong></td>
        </tr>
        <? while($row=mysql_fetch_object($res)) { ?>
        <tr> 
          <td class="body">&nbsp;<? echo show_photo($row->mem_id); ?><br>&nbsp;<? echo show_online($row->mem_id); ?></td>
          <td class="body">&nbsp;<a href="index.php?mode=bulletin&act=view&b_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=stripslashes($row->subj)?></a></td>
          <td width="26%" class="body">&nbsp;<? echo date("m/d/Y h:i A",$row->date); ?></td>
          <td width="19%" align="center" class="body">
            <? if($row->mem_id==$m_id) { ?>
            <a href="index.php?mode=bulletin&act=edi&b_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a> / <a href="index.php?mode=bulletin&act=del&b_id=<?=$row->id?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>
            <? } ?>
          </td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
  <tr> 
    <td align="center" valign="top" class="body"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
  </tr>
  <? } else { ?>
    <tr><td colspan="2" align="center" class="body"><?=LNG_EMPTY_BULLETIN?></td></tr>
  <? } ?>
  <tr><td height="5"></td></tr>
</table></td>
</tr></table>
<?
	show_footer();
}
?>
