<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='')	conreq_list();
elseif($act=='del')	delete_req('','');
elseif($act=='det')	detail_view();
elseif($act=='cont')	cont();

function conreq_list()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="lined title">&nbsp;&nbsp;<b>Admin: Contact Requests</b></td>
  </tr>
</table>
<br>
<?php
	$sql_query="select * from contact_req order by date desc";
	$res=sql_execute($sql_query,'res');
	$num=sql_execute($sql_query,'num');
	if($num==0)	{
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined padded-6">
  <tr>
    <td height="25" align="center" class="body">No contact requests in the system.</td>
  </tr>
</table>
<?php
	}	else	{
?>
<form action="admin.php" method="post" name="form1">
  <table width="100%" border="0" cellspacing="3" cellpadding="3" class="lined padded-6">
    <tr> 
      <td height="20" class="body"><strong>Select</strong></td>
      <td height="20" class="body"><strong>Name</strong></td>
      <td height="20" class="body"><strong>E-mail</strong></td>
    </tr>
<?php
		while($row=mysql_fetch_object($res))	{
?>
    <tr> 
      <td height="20"> <input type="checkbox" name="req_id[]" value="<?=$row->id?>"></td>
      <td height="20" class="body"><?=stripslashes($row->name)?></td>
      <td height="20" class="body"><a href="admin.php?mode=conreq&act=det&rec_id=<?=$row->id?>&adsess=<?=$adsess?>"><?=stripslashes($row->email)?></a></td>
    </tr>
<?php
		}
?>
    <tr align="right" valign="middle"> 
      <td height="25" colspan="6">
	  <input type="hidden" name="mode" value="conreq">
	  <input type="hidden" name="act" value="">
	  <input type="hidden" name="adsess" value="<?=$adsess?>">
      </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined padded-6">
    <tr align="left" valign="middle"> 
      <td height="25" colspan="6">&nbsp;&nbsp;<input type="Submit" class="submit" value="Delete Requests" onclick="javascript:this.value='Please wait...';this.form.act.value='del';"></td>
    </tr>
  </table>
  </form>
<?php } ?>
<?
	show_footer();
}

function cont()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$rec_id=form_get("rec_id");
	$pro=form_get("pro");
	if(empty($pro))	{
		$sql_query="select * from contact_req where id='$rec_id'";
		$req=sql_execute($sql_query,'get');;
		show_ad_header($adsess);
	?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="lined title">&nbsp;&nbsp;<b>Admin: Contact Requests</b></td>
  </tr>
</table>
<br>
<form action="admin.php" method="post">
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="lined padded-6">
<tr> 
  <td height="30" colspan="2">&nbsp;Posted on : <? echo date("F j, Y, g:i a",$req->date); ?></td>
</tr>
<tr> 
  <td width="43%" height="30">&nbsp;Name</td>
  <td width="57%" height="30"> 
	<?=stripslashes($req->name)?>
  </td>
</tr>
<tr> 
  <td height="30">&nbsp;E-mail</td>
  <td height="30"> 
	<?=stripslashes($req->email)?>
  </td>
</tr>
<tr> 
  <td height="30">&nbsp;Comment</td>
  <td height="30"> 
	<?=stripslashes($req->comment)?>
  </td>
</tr>
<tr><td height="5" colspan="2"></td></tr>
</table>
<table border="0" cellspacing="3" cellpadding="3" class="padded-6" align="center">
<tr> 
  <td colspan="2">
  <input type="hidden" name="mode" value="conreq">
  <input type="hidden" name="act" value="cont">
  <input type="hidden" name="pro" value="done">
  <input type="hidden" name="adsess" value="<?=$adsess?>">
  <input type="hidden" name="rec_id" value="<?=$rec_id?>">
  </td>
</tr>
<tr> 
  <td height="30"><strong>Subject</strong></td>
  <td height="30"><input name="subj" type="text" value="Re: Contact Requests" size="30"></td>
</tr>
    <tr align="center"> 
      <td height="30" colspan="2"><strong>Message</strong></td>

</tr>
    <tr align="center"> 
      <td height="30" colspan="2"> 
        <textarea name="message" rows="5" cols="45"></textarea>
      </td>
</tr>
<tr>
  <td colspan="2" height="30" align="center"><input type="submit" class="submit" value="Send Mail" onClick="this.value='Please wait...';"></td>
</tr>
</table>
</form>
<?
		show_footer();
	}	else	{
		$data[0]=form_get("subj");
		$data[1]=form_get("message");
		$sql_query="select email from contact_req where id='$rec_id'";
		$mem=sql_execute($sql_query,'get');
		messages($mem->email,5,$data);
		$link="admin.php?mode=conreq&act=det&rec_id=$rec_id&adsess=$adsess";
		show_screen($link);
	}
}//function

function delete_req($mod,$forums)	{
	if($mod=='')	{
		$adsess=form_get("adsess");
		admin_test($adsess);
		$req_id=form_get("req_id");
	}	elseif($mod='bcg')	{
		$fru_id=array();
		$req_id=$reqs;
	}
	foreach($req_id as $fid)	{
		$sql_query="delete from contact_req where id='$fid'";
		sql_execute($sql_query,'');
	}
	if($mod=='')	conreq_list();
	else	return 1;
}

function detail_view()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$rec_id=form_get("rec_id");
	$sql_query="select * from contact_req where id='$rec_id'";
	$adv=sql_execute($sql_query,'get');
	show_ad_header($adsess);
?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="lined title">&nbsp;&nbsp;<b>Admin: Contact Requests Details</b></td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellspacing="3" cellpadding="3" class="lined padded-6">
<tr> 
  <td height="30" colspan="2">&nbsp;Posted on : <? echo date("F j, Y, g:i a",$adv->date); ?></td>
</tr>
<tr> 
  <td width="43%" height="30">&nbsp;Name</td>
  <td width="57%" height="30"> 
	<?=stripslashes($adv->name)?>
  </td>
</tr>
<tr> 
  <td height="30">&nbsp;E-mail</td>
  <td height="30"> 
	<?=stripslashes($adv->email)?>
  </td>
</tr>
<tr> 
  <td height="30">&nbsp;Comment</td>
  <td height="30"> 
	<?=stripslashes($adv->comment)?>
  </td>
</tr>
<tr align="center"> 
  <td colspan="2"><input type="button" name="Button" value="    Back    " onClick="javascript:this.value='Please wait...';history.back(1);" class="submit">&nbsp;&nbsp;
  <input type="button" name="Button" value="Contact Back" onClick="javascript:this.value='Please wait...';window.location='admin.php?mode=conreq&act=cont&adsess=<?=$adsess?>&rec_id=<?=$rec_id?>';" class="submit"></td>
</tr>
</table>
<?
	show_footer();
}
?>