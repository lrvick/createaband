<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='')	package_list();
elseif($act=='del')	delete_pack('','');
elseif($act=='edi')	pack_manage();
elseif($act=='c_del')	delete_category();
elseif($act=='c_add')	add_category();
elseif($act=='new')	new_category();

function package_list()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="lined title">&nbsp;&nbsp;<b>Admin: Package Manager</b></td>
  </tr>
</table>
<br>
<?php
	$sql_query="select * from member_package order by package_amt";
	$res=sql_execute($sql_query,'res');
	$num=sql_execute($sql_query,'num');
	if($num==0)	{
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined padded-6">
  <tr>
    <td height="25" align="center" class="body">No membership packages in the system.</td>
  </tr>
</table>
<?php
	}	else	{
?>
<form action="admin.php" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined padded-6">
    <tr> 
      <td height="20" class="body"><strong>Select</strong></td>
      <td height="20" class="body"><strong>Package Name</strong></td>
      <td height="20" class="body"><strong>Package Amount</strong></td>
    </tr>
<?php
		while($fru=mysql_fetch_object($res))	{
?>
    <tr> 
      <td height="20"> <input type="checkbox" name="fru_id[]" value="<?=$fru->package_id?>"></td>
      <td height="20" class="body"> 
        <a href="admin.php?mode=package_manager&act=edi&adsess=<?=$adsess?>&pack_id=<?=$fru->package_id?>"><?=stripslashes($fru->package_nam)?></a>
      </td>
      <td height="20" class="body">
	  $<?=$fru->package_amt?>
      </td>
    </tr>
<?php
		}
?>
    <tr align="right" valign="middle"> 
      <td height="25" colspan="6">
	  <input type="hidden" name="mode" value="package_manager">
	  <input type="hidden" name="act" value="">
	  <input type="hidden" name="adsess" value="<?=$adsess?>">
      </td>
    </tr>
  </table>
<?php } ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined padded-6">
    <tr align="left" valign="middle"> 
      <td height="25" colspan="6"> 
        <?php if($num!=0) { ?><input type="Submit" value="Delete Packages" onclick="javascript:this.form.act.value='del'">&nbsp;&nbsp;<?php } ?>
		<input type="button" value="New Package" onclick="window.location='admin.php?mode=package_manager&act=new&adsess=<?=$adsess?>'">
	  </td>
    </tr>
  </table>
  </form>
<?
	show_footer();
}

function new_category()	{
	global $main_url;
	$adsess=form_get("adsess");
	admin_test($adsess);
	$pro=form_get("pro");
	if(empty($pro))	{
		show_ad_header($adsess);
?>
<script language="JavaScript1.2" src="<?=$main_url?>/js/num.js"></script>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="lined title">&nbsp;&nbsp;<b>Admin: New Package</b></td>
  </tr>
</table>
<br>
<form action="admin.php" method="post">
  <table width="100%" border="0" cellspacing="7" cellpadding="0" class="lined padded-6">
    <tr> 
      <td class="body"><strong>Package Name:</strong></td>
      <td><input name="pack_capt" type="text" id="pack_capt" class="form"></td>
    </tr>
    <tr> 
      <td class="body"><strong>Amount:</strong></td>
      <td><input name="amt" type="text" id="amt" class="formsmall" onBlur="this.value=getNumeric(this.value)"></td>
    </tr>
    <tr> 
      <td class="body" valign="top"><strong>Options:</strong></td>
      <td class="body" valign="top"> <input name="grp" type="checkbox" id="grp" value="Y"> 
        &nbsp;Groups<br> <input name="list" type="checkbox" id="list" value="Y"> 
        &nbsp;Listings<br> <input name="eve" type="checkbox" id="eve" value="Y"> 
        &nbsp;Events<br> <input name="blog" type="checkbox" id="blog" value="Y"> 
        &nbsp;Blogs<br> <input name="chat" type="checkbox" id="chat" value="Y"> 
        &nbsp;Chat<br> <input name="forum" type="checkbox" id="forum" value="Y"> 
        &nbsp;Forums </td>
    </tr>
    <tr> 
      <td class="body"><strong>Photos:</strong></td>
      <td class="body">
	  <input name="nop" type="text" id="nop" class="formsmall" onBlur="this.value=Numeric(this.value)">
	  <input type="hidden" name="mode" value="package_manager">
	  <input type="hidden" name="act" value="new">
	  <input type="hidden" name="pro" value="done">
	  <input type="hidden" name="adsess" value="<?=$adsess?>">
	  </td>
    </tr>
    <tr align="center"> 
      <td colspan="2" class="body"><input type="submit" name="Submit" value="Add Package"></td>
    </tr>
  </table>
</form>
<?
		show_footer();
	}	else	{
		$pack_capt=form_get("pack_capt");
		$amt=form_get("amt");
		$grp=form_get("grp");
		if(empty($grp))	$grp="N";
		$list=form_get("list");
		if(empty($list))	$list="N";
		$eve=form_get("eve");
		if(empty($eve))	$eve="N";
		$blog=form_get("blog");
		if(empty($blog))	$blog="N";
		$chat=form_get("chat");
		if(empty($chat))	$chat="N";
		$forum=form_get("forum");
		if(empty($forum))	$forum="N";
		$nop=form_get("nop");
		if(empty($nop))	$nop=0;
		if(!empty($pack_capt) or !empty($amt))	{
			$sql_query="select * from member_package where package_nam='".addslashes($pack_capt)."'";
			$res=sql_execute($sql_query,'res');
			if(!mysql_num_rows($res))	{
				$sql_query="insert into member_package (package_nam,package_grp,package_list,package_eve,package_blog,package_chat,package_forum,package_nphot,package_amt) values ('".addslashes($pack_capt)."','$grp','$list','$eve','$blog','$chat','$forum','$nop','$amt')";
				sql_execute($sql_query,'');
			}
		}
		package_list();
	}
}

function delete_pack($mod,$forums)	{
	if($mod=='')	{
		$adsess=form_get("adsess");
		admin_test($adsess);
		$fru_id=form_get("fru_id");
	}	elseif($mod='bcg')	{
		$fru_id=array();
		$fru_id=$forums;
	}
	foreach($fru_id as $fid)	{
		$sql_query="delete from member_package where package_id='$fid'";
		sql_execute($sql_query,'');
	}
	if($mod=='')	package_list();
	else	return 1;
}

function pack_manage()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$pack_id=form_get("pack_id");
	$pro=form_get("pro");
	$sql_query="select * from member_package where package_id='$pack_id'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		if(empty($pro))	{
			$pak=sql_execute($sql_query,'get');
			show_ad_header($adsess);
?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined padded-6">
  <tr> 
    <td class="lined title">&nbsp;&nbsp;<b>Admin: Modify Package</b></td>
  </tr>
</table>
<br>
<form method="post" action="admin.php">
  <table border="0" cellpadding="0" cellspacing="7" width="100%" class="lined padded-6">
    <tr> 
      <td class="body"><strong>Package Name:</strong></td>
      <td><input name="pack_capt" type="text" id="pack_capt" class="form" value="<?=stripslashes($pak->package_nam)?>"></td>
    </tr>
    <tr> 
      <td class="body"><strong>Amount:</strong></td>
      <td><input name="amt" type="text" id="amt" class="formsmall" onBlur="this.value=getNumeric(this.value)" value="<?=$pak->package_amt?>"></td>
    </tr>
    <tr> 
      <td class="body" valign="top"><strong>Options:</strong></td>
      <td class="body" valign="top"> <input name="grp" type="checkbox" id="grp" value="Y" <? checked($pak->package_grp,'Y'); ?>> 
        &nbsp;Groups<br> <input name="list" type="checkbox" id="list" value="Y" <? checked($pak->package_list,'Y'); ?>> 
        &nbsp;Listings<br> <input name="eve" type="checkbox" id="eve" value="Y" <? checked($pak->package_eve,'Y'); ?>> 
        &nbsp;Events<br> <input name="blog" type="checkbox" id="blog" value="Y" <? checked($pak->package_blog,'Y'); ?>> 
        &nbsp;Blogs<br> <input name="chat" type="checkbox" id="chat" value="Y" <? checked($pak->package_chat,'Y'); ?>> 
        &nbsp;Chat<br> <input name="forum" type="checkbox" id="forum" value="Y" <? checked($pak->package_forum,'Y'); ?>> 
        &nbsp;Forums </td>
    </tr>
    <tr> 
      <td class="body"><strong>Photos:</strong></td>
      <td class="body">
	  <input name="nop" type="text" id="nop" class="formsmall" onBlur="this.value=Numeric(this.value)" value="<?=$pak->package_nphot?>">
	  <input type="hidden" name="mode" value="package_manager">
	  <input type="hidden" name="act" value="edi">
	  <input type="hidden" name="pro" value="done">
	  <input type="hidden" name="pack_id" value="<?=$pack_id?>">
	  <input type="hidden" name="adsess" value="<?=$adsess?>">
	  </td>
    </tr>
    <tr align="center"> 
      <td colspan="2" class="body">
	  <input name="submit" type="submit" value="Save Changes">
      </td>
    </tr>
  </table>
</form>
<?
			show_footer();
		}	else	{
			$pack_capt=form_get("pack_capt");
			$amt=form_get("amt");
			$grp=form_get("grp");
			if(empty($grp))	$grp="N";
			$list=form_get("list");
			if(empty($list))	$list="N";
			$eve=form_get("eve");
			if(empty($eve))	$eve="N";
			$blog=form_get("blog");
			if(empty($blog))	$blog="N";
			$chat=form_get("chat");
			if(empty($chat))	$chat="N";
			$forum=form_get("forum");
			if(empty($forum))	$forum="N";
			$nop=form_get("nop");
			if(empty($nop))	$nop=0;
			if(!empty($pack_capt) or !empty($amt))	{
				$sql_query="select * from member_package where package_nam='".addslashes($pack_capt)."' and package_id<>'$pack_id'";
				$res=sql_execute($sql_query,'res');
				if(!mysql_num_rows($res))	{
					$sql_query="update member_package set package_nam='".addslashes($pack_capt)."',package_grp='$grp',package_list='$list',package_eve='$eve',package_blog='$blog',package_chat='$chat',package_forum='$forum',package_nphot='$nop',package_amt='$amt' where package_id='$pack_id'";
					sql_execute($sql_query,'');
				}
			}
			package_list();
		}
	}
}
?>