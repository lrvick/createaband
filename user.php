<?
$act=form_get("act");

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


$pro=form_get("pro");
if($act=="profile")	{
	if($pro=="edit")	edit_profile();
}	elseif($act=="bmarks")	bookmarks_manager();
elseif($act=="del")	del_photo();
elseif($act=="inv")	invite_page();
elseif($act=='invite_tribe')	invite_to_tribe();
elseif($act=="ignore")	ignore();
elseif($act=="save")	save();
elseif($act=="chpass")	change_password();
elseif($act=="upload")	photo_upload();
elseif($act=='tst')	write_testimonial();
elseif($act=='friends')	friends_manager();
elseif($act=='listings')	view_listings();
elseif($act=='intro')	make_intro();
elseif($act=='inv_db')	{
	$pro=form_get("pro");
	if($pro=='')	sent_invitations();
	else	del_inv();
}
elseif($act='friends_view')	friends_view();

//delete invitation
function del_inv()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$inv_id=form_get("inv_id");
	$sql_query="delete from invitations where inv_id='$inv_id'";
	sql_execute($sql_query,'');
	sent_invitations();
}//function

//edit profile
function edit_profile()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$m_acc=cookie_get("mem_acc");
	$type=form_get("type");
	if(($type=='')||($type=="basic"))	{
		show_header();
   ?>
<form action="index.php" name="profile" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_BASIC?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
	  <tr align="center">
		    <td class="lined-top lined-right lined-left"><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><b><?=LNG_BASICS?></b></a></td>
		    <td class="lined"><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><b><?=LNG_PERSONAL?></b></a></td>
		    <td class="lined"><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><b><?=LNG_PROFESSIONAL?></b></a></td>
		    <td class="lined"><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><b><?=LNG_MODEL?></b></a></td>
		    <td class="lined"><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><b><?=LNG_ACTORS?></b></a></td>
		    <td class="lined"><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><b><?=LNG_ACCOUNT?></b></a></td>
		<?php if($m_acc!=0) { ?>
            <td class="lined"><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><b><?=LNG_PHOTOS?></b></a></td>
            <?php } ?>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <br>
              <?=LNG_BESIC_PROFILE_MSG?><br>
			<?=LNG_BESIC_END_MSG?>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body">
		<? show_profile_edit($m_id,"basic"); ?>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="save">
		<input type="hidden" name="type" value="basic">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button value="<?LNG_PREVIOUS?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>">
		<input type=button onClick="javascript:formsubmit('basic')" value="<?=LNG_SAVE_CHANGES?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//basic profile
	//personal profile
	elseif($type=='personal')	{
		show_header();
?>
<form action="index.php" name="profile" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_PERSONAL?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?> </font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <br>
              <?=LNG_PER_PROFILE_MSG?><br>
			<?=LNG_BESIC_END_MSG?>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body">
		<? show_profile_edit($m_id,"personal"); ?>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="save">
		<input type="hidden" name="type" value="personal">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>'" value="<?=LNG_PREVIOUS?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>">
		<input type=button onClick="javascript:formsubmit('personal')" value="<?=LNG_SAVE_CHANGES?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//personal profile
	//professional
	elseif($type=="professional")	{
		show_header();
?>
<form action="index.php" name="profile" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title"><b>&nbsp;<?=LNG_EDIT_PROFILE?> - <?=LNG_PROFESSIONAL?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?> </font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <br>
              <?=LNG_PROF_PROFILE_MSG?><br>
			<?=LNG_BESIC_END_MSG?>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body">
		<? show_profile_edit($m_id,"professional"); ?>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="save">
		<input type="hidden" name="type" value="professional">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>'" value="<?=LNG_PREVIOUS?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>">
		<input type=button onClick="javascript:formsubmit('professional')" value="<?=LNG_SAVE_CHANGES?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//professional
	
	elseif($type=="model")	{
		show_header();
?>
<form action="index.php" name="profile" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_MODEL?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?> </font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <br>
              <?=LNG_COMPLET_FIELD?> </td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body">
		<? show_profile_edit($m_id,"model"); ?>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="save">
		<input type="hidden" name="type" value="model">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>'" value="<?=LNG_PREVIOUS?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>">
		<input type=button onClick="javascript:formsubmit('model')" value="<?=LNG_SAVE_CHANGES?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//model

elseif($type=="actor")	{
		show_header();
?>
<form action="index.php" name="profile" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_ACTORS?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?> </font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></b></td>
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <br>
              <?=LNG_CREATE_ACTOR_MSG?> 
            </td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body">
		<? show_profile_edit($m_id,"actor"); ?>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="save">
		<input type="hidden" name="type" value="actor">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>'" value="<?=LNG_PREVIOUS?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>">
		<input type=button onClick="javascript:formsubmit('actor')" value="<?=LNG_SAVE_CHANGES?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//actor
	
	//photos
	elseif($type=="photos")	{
		$m_phot=cookie_get("mem_phot");
		$err_mess=form_get("err_mess");
		$row_chk=photo_album_count($m_id,"1","edi");
		$ned_ph=$m_phot-$row_chk;
		if($ned_ph<0)	$ned_ph=0;
		if($ned_ph==0)	$dia_img="disabled";
		show_header();
?>
<form action="index.php" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_PHOTO_ALBUM?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?> </font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <strong><br>
              <?=LNG_UPLD_PHOTO?> :-</strong> <?=LNG_UPLD_PHOTO_SIZE?><br>
			<span class="orangebody"><?php if($ned_ph==0) { ?><?=LNG_UPLD_MAX?><?php } else { ?><?=LNG_CAN_UPLD?> <?=$ned_ph?> <?=LNG_MORE_PHOTO?><?php } ?></span>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center" valign="top">
		<table border="0" cellspacing="0" cellpadding="0" class="lined body">
			<? photo_album($m_id,"1","edi"); ?>
		</table>
	</td>
  </tr>
  <tr><td height="3" bgcolor="#C0C0C0"></td></tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="75%" border="0" cellspacing="3" cellpadding="3" class="body">
          <tr> 
            <td><strong><?=LNG_PHOTO?></strong></td>
            <td><input type="file" name="photo"></td>
          </tr>
          <tr> 
            <td><strong><?=LNG_CAPTION?></strong></td>
            <td><input type="text" name="capture"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" name="main" value="1">
              <b><?=LNG_SET_MAIN_PHOTO?></b></td>
          </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="right"> 
        <div align="center">
          <input type="hidden" name="mode" value="user">
          <input type="hidden" name="act" value="upload">
          <input type="hidden" name="type" value="photos">
          <input type="hidden" name="m_phot" value="<?=$m_phot?>">
          <input type="submit" name="submit" value="<?=LNG_UPLOAD_PHOTO?>" <?=$dia_img?>>
          &nbsp;&nbsp; </div>
      </td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//photos
	//account
	elseif($type="account")	{
		show_header();
   ?>
<form action="index.php" name="profile" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_ACCOUNT_DETAILS?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?> </font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=model&lng=<?=$lng_id?>"><?=LNG_MODEL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=actor&lng=<?=$lng_id?>"><?=LNG_ACTORS?> 
              </a></b></td>
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		    <td> <br>
              <?=LNG_CHNG_ACC_DETAILS?>..<br>
              . </td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body">
		<? show_profile_edit($m_id,"account"); ?>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="save">
		<input type="hidden" name="type" value="account">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>'" value="<?=LNG_PREVIOUS?>">
		<?php if($m_acc==0) { ?><input type=button value="<?=LNG_NEXT?>"><?php } else { ?><input type="button"  onclick="window.location='index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>"><?php } ?>
		<input type=button onClick="javascript:formsubmit('account')" value="<?=LNG_SAVE_CHANGES?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}//account
}

function save()	{
	global $main_url;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$now=time();
	$sql_query="update profiles set updated='$now' where mem_id='$m_id'";
	sql_execute($sql_query,'');
	$red=array("basic","personal","professional","model","actor","photos","account");
    //getting type and redirect if cancel,next or previous
    $type=form_get("type");
    $redirect=form_get("redir");
    if($redirect=="cancel")	{
		$location="index.php?mode=login&act=home&lng=$lng_id";
		show_screen($location);
	}	elseif($redirect=='next')	{
		$location="index.php?mode=user&act=profile&pro=edit&type=&lng=$lng_id";
		for($i=0;$i<count($red);$i++)	{
			if($type==$red[$i])	{
				$location.=$red[$i+1];
				break;
			}//if
		}//for
		show_screen($location);
	}	elseif($redirect=='prev')	{
		$location="index.php?mode=user&act=profile&pro=edit&type=&lng=$lng_id";
		for($i=0;$i<count($red);$i++)	{
			if($type==$red[$i])	{
				$location.=$red[$i-1];
				break;
			}//if
		}//for
		show_screen($location);
	}
    //basic
	if($type=="basic")	{
		//getting values
		$vals=array("here_for","gender","showloc","showage","showgender","country","zip","interests","month","day","year","occupation","showonline","rateme","city","state","ethnicity");
		foreach($vals as $val)	{
			${$val}=form_get("$val");
		}
		$birthday=maketime(0,0,0,$month,$day,$year);
		if($showloc=='')	$showloc='1';
		if($showage=='')	$showage='1';
		if($showgender=='')	$showgender='1';
		if($showonline=='')	$showonline='1';
		if($rateme=='')	$rateme='1';
		$zones=form_get("zones");
		$sql_query="update members set birthday='$birthday',rapzone='$zones'";
		foreach($vals as $val)	{
			if(($val!="occupation")&&($val!='here_for')&&($val!='interests')&&($val!="month")&&($val!="day")&&($val!="year"))	{
				$sql_query.=",$val='${$val}'";
			}//if
		}//foreach
		$sql_query.=" where mem_id='$m_id'";
		sql_execute($sql_query,'');
		$sql_query="update profiles set occupation='$occupation',here_for='$here_for',interests='$interests' where mem_id='$m_id'";
		sql_execute($sql_query,'');
	}
	//personal
	elseif($type=="personal")	{
		//getting values
		$vals=array("hometown","schools","languages","website","books","music","movies","travel","clubs","about","meet_people","aua_fan","aua_mc","aua_vocalist","aua_producer","aua_poet","aua_dancer","aua_dj","aua_musician","aua_artist","aua_other","likemost_mc","likemost_graffiti","likemost_dj","likemost_breaking","raplike_oldschool","raplike_raprock","raplike_bootie","raplike_mainstreamradio","raplike_experimental","raplike_underground","raplike_gangsta","raplike_club","raplike_breaking","raplike_other","whathiptou","shoutouts","college","highschool","job","style_card","marstat","religion","smoker","drinker","children");
		foreach($vals as $val)	{
			${$val}=form_get("$val");
		}
		if(empty($aua_fan))	$aua_fan='n';
		if(empty($aua_mc))	$aua_mc='n';
		if(empty($aua_vocalist))	$aua_vocalist='n';
		if(empty($aua_producer))	$aua_producer='n';
		if(empty($aua_poet))	$aua_poet='n';
		if(empty($aua_dancer))	$aua_dancer='n';
		if(empty($aua_dj))	$aua_dj='n';
		if(empty($aua_musician))	$aua_musician='n';
		if(empty($aua_artist))	$aua_artist='n';
		if(empty($aua_other))	$aua_other='n';
		if(empty($likemost_mc))	$likemost_mc='n';
		if(empty($likemost_graffiti))	$likemost_graffiti='n';
		if(empty($likemost_dj))	$likemost_dj='n';
		if(empty($likemost_breaking))	$likemost_breaking='n';
		if(empty($raplike_oldschool))	$raplike_oldschool='n';
		if(empty($raplike_raprock))	$raplike_raprock='n';
		if(empty($raplike_bootie))	$raplike_bootie='n';
		if(empty($raplike_mainstreamradio))	$raplike_mainstreamradio='n';
		if(empty($raplike_experimental))	$raplike_experimental='n';
		if(empty($raplike_underground))	$raplike_underground='n';
		if(empty($raplike_gangsta))	$raplike_gangsta='n';
		if(empty($raplike_club))	$raplike_club='n';
		if(empty($raplike_breaking))	$raplike_breaking='n';
		if(empty($raplike_other))	$raplike_other='n';
		$sub_cat_id=form_get("sub_cat_id");
		if($sub_cat_id!='')	{
			foreach($sub_cat_id as $sid)	{
				$ans.=$sid."|";
			}
		}
		$now=time();
		$sql_query="update profiles set ";
		foreach($vals as $val)	{
			$sql_query.="$val='${$val}',";
		}//foreach
		$sql_query=rtrim($sql_query,',');
		$sql_query.=",updated='$now' where mem_id='$m_id'";
		sql_execute($sql_query,'');
	}
	//professional
	elseif($type=="professional")	{
		//getting vals
		$vals=array("position","company","industry","specialities","skills","overview","p_positions","p_companies","assotiations","income","education");
		foreach($vals as $val)	{
			${$val}=form_get("$val");
		}
		$sql_query="update profiles set ";
		foreach($vals as $val)	{
			$sql_query.="$val='${$val}',";
		}//foreach
		$sql_query=rtrim($sql_query,',');
		$sql_query.=" where mem_id='$m_id'";
		sql_execute($sql_query,'');
	}
	//model
	elseif($type=="model")	{
		global $_FILES;
		//getting vals
		$vals=array("height","weight","skincolor","haircolor","shoesize","dresssize","bustsize","hips","waist","languages","shirtcollar","jacketsuit","inseam","interest");
		foreach($vals as $val)	{
			${$val}=form_get("$val");
		}
		$sql_chk="select * from models where mem_id='$m_id'";
		$res=sql_execute($sql_chk,'res');
		if(!mysql_num_rows($res))	{
			$sql_ins="insert into models (mem_id) values ('$m_id')";
			sql_execute($sql_ins,'');
		}
		$tmpfname=$_FILES['photo']['tmp_name'];
		$ftype=$_FILES['photo']['type'];
		$fsize=$_FILES['photo']['size'];
		if(!empty($tmpfname))	{
			$sql_query="select photo,photo_thumb from models where mem_id='$m_id' ";
			$pho_row=sql_execute($sql_query,'get');
			if($pho_row->photo!='')	{
				if(file_exists($pho_row->photo))	@unlink($pho_row->photo);
			}
			if($pho_row->photo_thumb!='')	{
				if(file_exists($pho_row->photo_thumb))	@unlink($pho_row->photo_thumb);
			}
			//checkin image size
			if($fsize>500*1024)	error_screen(10);
			//checkin image type
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."mth";
			$newname_b_th=$newname."mbth";
			$old="photos/".$newname.$p_type;
			$thumb1="photos/".$newname_th.".jpeg";
			$thumb2="photos/".$newname_b_th.".jpeg";
			move_uploaded_file($tmpfname,"photos/".$newname.$p_type);
			//creating thumbnails
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
			ImageJpeg($destImage1, $thumb1, 80);
			ImageJpeg($destImage2, $thumb2, 80);
			ImageDestroy($srcImage);
			ImageDestroy($destImage1);
			ImageDestroy($destImage2);
			//updating db
			$now=time();
			$photo="photos/".$newname.$p_type;
			$photo_b_thumb="photos/".$newname_b_th.".jpeg";
			$photo_thumb="photos/".$newname_th.".jpeg";
			if(file_exists($photo))	@unlink($photo);
		}	else	{
			$photo_b_thumb="";
			$photo_thumb="";
		}
		$sql_query="update models set ";
		foreach($vals as $val)	{
			$sql_query.="$val='${$val}',";
		}//foreach
		$sql_query=rtrim($sql_query,',');
		$sql_query.=",photo='$photo_b_thumb',photo_thumb='$photo_thumb' where mem_id='$m_id'";
		sql_execute($sql_query,'');
	}
	//actor
	elseif($type=="actor")	{
		global $_FILES;
		//getting vals
		$vals=array("height","weight","skincolor","haircolor","shoesize","dresssize","bustsize","hips","waist","languages","shirtcollar","jacketsuit","inseam","interest");
		foreach($vals as $val)	{
			${$val}=form_get("$val");
		}
		$sql_chk="select * from actors where mem_id='$m_id'";
		$res=sql_execute($sql_chk,'res');
		if(!mysql_num_rows($res))	{
			$sql_ins="insert into actors (mem_id) values ('$m_id')";
			sql_execute($sql_ins,'');
		}
		$tmpfname=$_FILES['photo']['tmp_name'];
		$ftype=$_FILES['photo']['type'];
		$fsize=$_FILES['photo']['size'];
		if(!empty($tmpfname))	{
			$sql_query="select photo,photo_thumb from actors where mem_id='$m_id' ";
			$pho_row=sql_execute($sql_query,'get');
			if($pho_row->photo!='')	{
				if(file_exists($pho_row->photo))	@unlink($pho_row->photo);
			}
			if($pho_row->photo_thumb!='')	{
				if(file_exists($pho_row->photo_thumb))	@unlink($pho_row->photo_thumb);
			}
			//checkin image size
			if($fsize>500*1024)	error_screen(10);
			//checkin image type
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."ath";
			$newname_b_th=$newname."abth";
			$old="photos/".$newname.$p_type;
			$thumb1="photos/".$newname_th.".jpeg";
			$thumb2="photos/".$newname_b_th.".jpeg";
			move_uploaded_file($tmpfname,"photos/".$newname.$p_type);
			//creating thumbnails
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
			ImageJpeg($destImage1, $thumb1, 80);
			ImageJpeg($destImage2, $thumb2, 80);
			ImageDestroy($srcImage);
			ImageDestroy($destImage1);
			ImageDestroy($destImage2);
			//updating db
			$now=time();
			$photo="photos/".$newname.$p_type;
			$photo_b_thumb="photos/".$newname_b_th.".jpeg";
			$photo_thumb="photos/".$newname_th.".jpeg";
			if(file_exists($photo))	@unlink($photo);
		}	else	{
			$photo_b_thumb="";
			$photo_thumb="";
		}
		$sql_query="update actors set ";
		foreach($vals as $val)	{
			$sql_query.="$val='${$val}',";
		}//foreach
		$sql_query=rtrim($sql_query,',');
		$sql_query.=",photo='$photo_b_thumb',photo_thumb='$photo_thumb' where mem_id='$m_id'";
		sql_execute($sql_query,'');
	}
	//account
	elseif($type=="account")	{
		//getting vals
		$pack=form_get("pack");
		$pack_old=form_get("pack_old");
		$email=form_get("email");
		$fname=form_get("fname");
		$lname=form_get("lname");
		$notifications=form_get("notifications");
		$password=form_get("password");
		if($notifications=='')	$notifications=0;
		if(empty($pack))	$pack=$pack_old;
		if($pack!=$pack_old)	{
			$sql="select * from member_package where package_id=$pack";
			$res=mysql_query($sql);
			$row=mysql_fetch_object($res);
			$package_amt=$row->package_amt;
			if($package_amt=='0.00')	{
				$mem_st="F";
				$p_stat="Y";
			}	else	{
				$mem_st="P";
				$p_stat="N";
			}
		}
		$sql_query="select * from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		$sql_query="update members set fname='$fname',lname='$lname',notifications='$notifications'";
		if($pack!=$pack_old)	{
			$sql_query.=",mem_acc='$pack',mem_stat='$mem_st',pay_stat='$p_stat'";
		}
		$sql_query.="where mem_id='$m_id'";
		sql_execute($sql_query,'');
		if($email!=$mem->email)	{
			$crypass=md5($password);
			if($crypass!=$mem->password)	error_screen(0);
			else	{
				$sql_query="update members set email='$email' where mem_id='$m_id'";
				sql_execute($sql_query,'');
				$data[0]=$email;
				$data[1]=$password;
				messages($email,"3",$data);
			}
		}
		if($pack!=$pack_old)	{
			if($package_amt!='0.00')	{
				global $main_url;
				$redirect=$main_url."/index.php?mode=update_paypal&pack=$pack&mem_id=$m_id&lng=$lng_id";
				show_screen($redirect);
			}
		}
	}
	//photos
	elseif($type=="photos")	{
	}
	////redirecting////
	$location="index.php?mode=user&act=profile&pro=edit&type=&lng=$lng_id";
	if($redirect=='')	$location.=$type;
	else	$location.=$redirect;
	show_screen($location);
}//function

function show_profile_edit($mem_id,$type)	{
	$sql_query="select * from profiles where mem_id='$mem_id'";
	$pro=sql_execute($sql_query,'get');
	$sql_query="select * from members where mem_id='$mem_id'";
	$mem=sql_execute($sql_query,'get');
	//basic profile
	if($type=="basic")	{
		$sql_accc="select * from member_package order by package_amt";
		$res_accc=mysql_query($sql_accc);
		$sql_query="select * from rapzones order by rapzone";
		$res_rap=sql_execute($sql_query,'res');
		$here_for=$pro->here_for;
		$gender=$mem->gender;
		$showloc=$mem->showloc;
		$showage=$mem->showage;
		$showgender=$mem->showgender;
		$location=$mem->country;
		$zip=$mem->zip;
		$interests=$pro->interests;
		$birthday=$mem->birthday;
		$month=date("m",$birthday);
		$day=date("j",$birthday);
		$year=date("Y",$birthday);
		$occupation=$pro->occupation;
		$showonline=$mem->showonline;
		$rateme=$mem->rateme;
		$country=$mem->country;
		$acc=$mem->mem_acc;
		$ethnicity=$mem->ethnicity;
		$state=$mem->state;
		$city=$mem->city;
?>
<table width="98%" border="0" cellspacing="3" cellpadding="3" class="body" align="center">
  <tr> 
    <td width="25%"><strong><?=LNG_OCCUPATION?></strong></td>
    <td colspan="2"><input type="text" name="occupation" value="<?=stripslashes($occupation)?>"></td>
    <td width="24%" rowspan="9" valign="top"><table border=0 cellpadding=2 cellspacing=2>
          <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
          <tr> 
            <td class="main-text" valign="top" align="center" height="148"><?=LNG_YOU_AD_HERE?></td>
          </tr>
      </table></td>
  </tr>
  <tr class="body"> 
    <td><strong><?=LNG_COUNTRY?></strong></td>
    <td width="24%"> <select name="country">
        <? country_drop(stripslashes($country)); ?>
      </select> </td>
    <td width="27%"  class="orangebody"><input type="checkbox" name="showonline" value="0"<? echo checked($showonline,"0"); ?>>
      <?=LNG_DONOT_SHOW?> </td>
  </tr>
  <tr> 
    <td><strong><?=LNG_ZIP?></strong></td>
    <td><input type="text" name="zip" value="<?=stripslashes($zip)?>"></td>
    <td  class="orangebody"><input type="checkbox" name="showloc" value="0"<? echo checked($showloc,"0"); ?>>
      <?=LNG_DONOT_SHOW_LOCATION?> </td>
  </tr>
  <tr> 
    <td><strong><?=LNG_GENDER?></strong></td>
    <td> <input type="radio" name="gender" value="m"<? echo checked($gender,"m"); ?>>
      <?=LNG_MALE?><br> <input type="radio" name="gender" value="f"<? echo checked($gender,"f"); ?>>
      <?=LNG_FEMALE?><br> <input type="radio" name="gender" value="n"<? echo checked($gender,"n"); ?>>
      <?=LNG_NOT_TO_SAY?> </td>
    <td  class="orangebody"><input type="checkbox" name="showgender" value="0"<? echo checked($showgender,"0"); ?>>
      <?=LNG_DONOT_SHOW_GENDER?> </td>
  </tr>
  <tr> 
    <td><strong><?=LNG_DATE_BIRTH?> </strong></td>
    <td> <select name="month">
        <? month_drop($month); ?>
      </select> <select name="day">
        <? day_drop($day); ?>
      </select> <select name="year">
        <? year_drop($year); ?>
      </select> </td>
    <td  class="orangebody"><input type="checkbox" name="showage" value="0"<? echo checked($showage,"0"); ?>>
      <?=LNG_DONOT_SHOW_AGE?> </td>
  </tr>
  <tr> 
    <td><strong><?=LNG_ETHNICITY?></strong><br>
    </td>
    <td colspan="2"><select name="ethnicity">
        <option value="No Answer"><?=LNG_NO_ANSWER?></option>
        <option value="Asian"><?=LNG_ASIAN?></option>
        <option value="Black/African Descend"><?=LNG_BAD?></option>
        <option value="East Indian"><?=LNG_EST_IND?></option>
		<option value="Latino/Hispanic"><?=LNG_LH?></option>
		<option value="Middle Eastern"><?=LNG_MID_EST?></option>
		<option value="Native American"><?=LNG_NTV_AMRC?></option>
		<option value="Pacific Islander"><?=LNG_PACI_IS?></option>
		<option value="White/Caucasian"><?=LNG_WHITE_CSIN?></option>
		<option value="Other"><?=LNG_OTHER?></option>
        <option selected value="<?=$ethnicity?>">
        <?=$ethnicity?>
        </option>
      </select> </td>
  </tr>
  <tr> 
    <td><strong><?=LNG_CITY_REG?></strong><br>
    </td>
    <td colspan="2"><input type="text" name="city" value="<?=stripslashes($city)?>"></td></tr>
	<tr> 
    <td><strong><?=LNG_STATE?></strong><br>
    </td>
    <td colspan="2"><input type="text" name="state" value="<?=stripslashes($state)?>"></td></tr>
  <tr> 
    <td><strong><?=LNG_INTERESTS?></strong><br> <span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
    <td colspan="2"> <textarea name="interests" cols="40" rows="5"><?=stripslashes($interests)?></textarea> 
    </td>
  </tr>
</table>
<?
	}//basic
	//personal
	elseif($type=="personal")	{
		$hometown=$pro->hometown;
		$schools=$pro->schools;
		$languages=$pro->languages;
		$website=$pro->website;
		$books=$pro->books;
		$music=$pro->music;
		$movies=$pro->movies;
		$travel=$pro->travel;
		$clubs=$pro->clubs;
		$about=$pro->about;
		$meet_people=$pro->meet_people;
		$aua_fan=$pro->aua_fan;
		$aua_mc=$pro->aua_mc;
		$aua_vocalist=$pro->aua_vocalist;
		$aua_producer=$pro->aua_producer;
		$aua_poet=$pro->aua_poet;
		$aua_dancer=$pro->aua_dancer;
		$aua_dj=$pro->aua_dj;
		$aua_musician=$pro->aua_musician;
		$aua_artist=$pro->aua_artist;
		$aua_other=$pro->aua_other;
		$likemost_mc=$pro->likemost_mc;
		$likemost_graffiti=$pro->likemost_graffiti;
		$likemost_dj=$pro->likemost_dj;
		$likemost_breaking=$pro->likemost_breaking;
		$raplike_oldschool=$pro->raplike_oldschool;
		$raplike_raprock=$pro->raplike_raprock;
		$raplike_bootie=$pro->raplike_bootie;
		$raplike_mainstreamradio=$pro->raplike_mainstreamradio;
		$raplike_experimental=$pro->raplike_experimental;
		$raplike_underground=$pro->raplike_underground;
		$raplike_gangsta=$pro->raplike_gangsta;
		$raplike_club=$pro->raplike_club;
		$raplike_breaking=$pro->raplike_breaking;
		$raplike_other=$pro->raplike_other;
		$whathiptou=$pro->whathiptou;
		$shoutouts=$pro->shoutouts;
		$college=$pro->college;
		$highschool=$pro->highschool;
		$job=$pro->job;
		$style_card=$pro->style_card;
		$marstat=$pro->marstat;
		$religion=$pro->religion;
		$smoker=$pro->smoker;
		$drinker=$pro->drinker;
		$children=$pro->children;
?>
<table width="98%" border="0" cellspacing="3" cellpadding="3" class="body" align="center">
  <tr> 
    <td width="43%"><strong><?=LNG_ABOUT_ME?></strong></td>
    <td width="37%"><textarea name="about"><?=stripslashes($about)?></textarea></td>
    <td width="20%" rowspan="16" valign="top"><table border=0 cellpadding=2 cellspacing=2>
          <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
          <tr> 
            <td class="main-text" valign="top" align="center" height="148"><?=LNG_YOU_AD_HERE?></td>
          </tr>
      </table></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_ARE_U_A?></strong><br> <span class="orangebody"><?=LNG_SELECT_ALL?></span></td>
    <td> <table class="body">
        <tr> 
          <td valign="top"> <input name="aua_fan" type="checkbox" value="y"<? echo checked($aua_fan,"y"); ?>>
            <?=LNG_FAN?><br> <input name="aua_mc" type="checkbox" value="y"<? echo checked($aua_mc,"y"); ?>>
            <?=LNG_MC?><br> <input name="aua_vocalist" type="checkbox" value="y"<? echo checked($aua_vocalist,"y"); ?>>
            <?=LNG_VOCALIST?><br> <input name="aua_producer" type="checkbox" value="y"<? echo checked($aua_producer,"y"); ?>>
            <?=LNG_MODEL?><br> <input name="aua_poet" type="checkbox" value="y"<? echo checked($aua_poet,"y"); ?>>
            <?=LNG_POET?> </td>
          <td valign="top"> <input type="checkbox" name="aua_dancer" value="y"<? echo checked($aua_dancer,"y"); ?>>
            <?=LNG_DANCER?><br> <input name="aua_dj" type="checkbox" value="y"<? echo checked($aua_dj,"y"); ?>>
            <?=LNG_ACTORS?><br> <input name="aua_musician" type="checkbox" value="y"<? echo checked($aua_musician,"y"); ?>>
            <?=LNG_MUSICIAN?><br> <input name="aua_artist" type="checkbox" value="y"<? echo checked($aua_artist,"y"); ?>>
            <?=LNG_ARTIST?><br> <input name="aua_other" type="checkbox" value="y"<? echo checked($aua_other,"y"); ?>>
            <?=LNG_OTHER?> </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_COLLEGE?></strong></td>
    <td><input type="text" name="college" value="<?=stripslashes($college)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_MARITAL_STATUS?></strong></td>
    <td><select name="marstat">
	<option value="Single"><?=LNG_SINGLE?></option>
	<option value="Married"><?=LNG_MARRIED?></option>
	<option value="Divorced"><?=LNG_DIVORCED?></option>
	<option value="Swinger"><?=LNG_SWINGER?></option>
	<option value="In a Relationship"><?=LNG_IN_RELATION_SHIP?></option>
	<option selected value="<?=$marstat?>"><?=$marstat?></option>
	</select>
  </tr>
  <tr> 
    <td><strong><?=LNG_RELIGION?></strong></td>
    <td><input type="text" name="religion" value="<?=stripslashes($religion)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_SMOKER?></strong></td>
    <td><select name="smoker">
	<option value="Yes"><?=LNG_YES?></option>
	<option value="No"><?=LNG_NO?></option>
	<option value="Sometimes"><?=LNG_SOME_TIME?></option>
	<option selected value="<?=$smoker?>"><?=$smoker?></option>
	</select></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_DRINKER?></strong></td>
    <td><select name="drinker">
	<option value="Yes"><?=LNG_YES?></option>
	<option value="No"><?=LNG_NO?></option>
	<option value="Sometimes"><?=LNG_SOME_TIME?></option>
	<option selected value="<?=$drinker?>"><?=$drinker?></option>
	</select></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_CHILDREN?></strong></td>
    <td><select name="children">
	<option value="I don't want kids"><?=LNG_DONOT_WANT_KIND?></option>
	<option value="Someday"><?=LNG_SOME_DAY?></option>
	<option value="Undecided"><?=LNG_UNDECIDED?></option>
	<option value="Love kids but not for me"><?=LNG_LOVE_KIND?></option>
	<option value="Your kids are fine for me"><?=LNG_KIND_ME?></option>
	<option value="Proud Parent"><?=LNG_PROUD_PARENT?></option>
	<option selected value="<?=$children?>"><?=$children?></option>
	</select></td>
  </tr>
    <tr> 
    <td><strong><?=LNG_HIGH_SCHOOL?></strong></td>
    <td><input type="text" name="highschool" value="<?=stripslashes($highschool)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_DREAM_JOB?></strong></td>
    <td><input type="text" name="job" value="<?=stripslashes($job)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_HOME_TOWN?></strong></td>
    <td><input type="text" name="hometown" value="<?=stripslashes($hometown)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_SCHOOLS?></strong></td>
    <td><input type="text" name="schools" value="<?=stripslashes($schools)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_LANGUAGES?></strong></td>
    <td><input type="text" name="languages" value="<?=stripslashes($languages)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_PERSONAL_WEBSITE?></strong></td>
    <td><input type="text" name="website" value="<?=stripslashes($website)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_FAV_BOOKS?></strong></td>
    <td><input type="text" name="books" value="<?=stripslashes($books)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_FAV_MUSIC?></strong></td>
    <td><input type="text" name="music" value="<?=stripslashes($music)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_FAV_MOVI_TV?></strong></td>
    <td><input type="text" name="movies" value="<?=stripslashes($movies)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_I_TRAVEL_TO?></strong></td>
    <td><input type="text" name="travel" value="<?=stripslashes($travel)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_CLUBS_ORGS?></strong></td>
    <td><input type="text" name="clubs" value="<?=stripslashes($clubs)?>"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_MY_PROF_STYLE?></strong><br> <span class="orangebody"><?=LNG_PUT_CUSTOM_STYLE?></span></td>
    <td><textarea name="style_card"><?=stripslashes($style_card)?></textarea></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_WANT_TO_MEET?></strong></td>
    <td>
	<select name="meet_people">
	<option value="Dating"><?=LNG_DATING?></option>
	<option value="Serious Relationship"><?=LNG_SERIOUS_REL?></option>
	<option value="Friends"><?=LNG_FRIENDS?></option>
	<option value="Networking"><?=LNG_NET_WORKING?></option>
	<option selected value="<?=$meet_people?>"><?=$meet_people?></option>
	</select>
</td>
  </tr>
</table>
<?php
	}//personal
	//professional
	elseif($type=="professional")	{
		$position=$pro->position;
		$company=$pro->company;
		$industry=$pro->industry;
		$specialities=$pro->specialities;
		$skills=$pro->skills;
		$overview=$pro->overview;
		$p_positions=$pro->p_positions;
		$p_companies=$pro->p_companies;
		$assotiations=$pro->assotiations;
		$income=$pro->income;
		$education=$pro->education;
?>
<table width="98%" border="0" cellspacing="3" cellpadding="3" class="body" align="center">
  <tr>
  	<td><strong><?=LNG_POS_TITLE?></strong></td>
	<td><input type="text" name="position" value="<?=stripslashes($position)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_COMPANY?></strong></td>
	<td><input type="text" name="company" value="<?=stripslashes($company)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_INCOME?></strong></td>
	<td><input type="text" name="income" value="<?=stripslashes($income)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_INDUSTRY?></strong></td>
	<td>
		<select name="industry">
			<option value=""><?=LNG_PLEASE_SELECT?> ...</option>
			<? industry_drop("$industry"); ?>
		</select>
	</td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_SPEC_INDUSTRIES?></strong><br><span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
	<td><textarea name="specialities"><?=stripslashes($specialities)?></textarea></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_EDUCATION?></strong><br>
    </td>
	<td><select name="education">
        <option value="High School"><?=LNG_HIGH_SCHOOL?></option>
        <option value="Some College"><?=LNG_SOME_COLLEGE?></option>
        <option value="GED"><?=LNG_GED?></option>
        <option value="In College"><?=LNG_IN_COLLEGE?></option>
		<option value="College Graduate"><?=LNG_COLL_GRADUATE?></option>
		<option value="Post Graduate"><?=LNG_POST_GRADUATE?></option>
		<option value="Trade School"><?=LNG_TRADE_SCHOOL?></option>
        <option selected value="<?=$education?>">
        <?=$education?>
        </option>
      </select></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_SKILLS?></strong><br><span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
	<td><textarea name="skills"><?=stripslashes($skills)?></textarea></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_OVERVIEW?></strong></td>
	<td><textarea name="overview"><?=stripslashes($overview)?></textarea></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_PAST_POSITION?></strong><br><span class='orangebody'><?=LNG_SEP_WITH_COMMA?></span></td>
	<td><input type="text" name="p_positions" value="<?=stripslashes($p_positions)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_PAST_COMPANIES?></strong><br><span class='orangebody'><?=LNG_SEP_WITH_COMMA?></span></td>
	<td><input type="text" name="p_companies" value="<?=stripslashes($p_companies)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_ASSOTIATIONS?></strong><br><span class='orangebody'><?=LNG_SEP_WITH_COMMA?></span></td>
	<td><input type="text" name="assotiations" value="<?=stripslashes($assotiations)?>"></td>
	<td class="orangebody"></td>
  </tr>
</table>
<?
	}//professional
	
	//model
	elseif($type=="model")	{
		$sql_mod="select * from models where mem_id='$mem_id'";
		$mods=sql_execute($sql_mod,'get');
		$height =$mods->height;
		$weight =$mods->weight;
		$skincolor =$mods->skincolor;
		$haircolor =$mods->haircolor;
		$shoesize =$mods->shoesize;
		$dresssize =$mods->dresssize;
		$bustsize =$mods->bustsize;
		$hips =$mods->hips;
		$waist =$mods->waist;
		$languages =$mods->languages;
		$shirtcollar =$mods->shirtcollar;
		$jacketsuit =$mods->jacketsuit;
		$inseam  =$mods->inseam;
		$interest  =$mods->interest;
?>
<table width="98%" border="0" cellspacing="3" cellpadding="3" class="body" align="center">
  <tr> 
    <td width="25%"><strong><?=LNG_HEIGHT?></strong></td>
    <td><input type="text" name="height" value="<?=stripslashes($height)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_WEIGHT?></strong></td>
    <td><input type="text" name="weight" value="<?=stripslashes($weight)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_SKIN_COLOR?></strong></td>
    <td> <input type="text" name="skincolor" value="<?=stripslashes($skincolor)?>"> 
    </td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_HAIR_COLOR?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="haircolor" value="<?=stripslashes($haircolor)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_SHOE_SIZE?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="shoesize" value="<?=stripslashes($shoesize)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_DRESS_SIZE?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="dresssize" value="<?=stripslashes($dresssize)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_BUST_SIZE?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="bustsize" value="<?=stripslashes($bustsize)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_HIPS?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="hips" value="<?=stripslashes($hips)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_WAIST?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="waist" value="<?=stripslashes($waist)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_LANGUAGES?></strong><br>
      <span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
    <td><input type="text" name="languages" value="<?=stripslashes($languages)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_SHIR_COLOR?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="shirtcollar" value="<?=stripslashes($shirtcollar)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_JACKET_SUIT?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="jacketsuit" value="<?=stripslashes($jacketsuit)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_INSEAM?></strong><br>
      <span class="orangebody"></span></td>
    <td><input type="text" name="inseam" value="<?=stripslashes($inseam)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr> 
    <td><strong><?=LNG_INTERESTS?></strong><br>
      <span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
    <td><input type="text" name="interest" value="<?=stripslashes($interest)?>"></td>
    <td class="orangebody"></td>
  </tr>
  <tr>
    <td><strong><?=LNG_PHOTO?></strong></td>
    <td><input type="file" name="photo"></td>
    <td class="orangebody"></td>
  </tr>
</table>
<?
	}//model
		//actor
	elseif($type=="actor")	{
		$sql_mod="select * from actors where mem_id='$mem_id'";
		$mods=sql_execute($sql_mod,'get');
		$height =$mods->height;
		$weight =$mods->weight;
		$skincolor =$mods->skincolor;
		$haircolor =$mods->haircolor;
		$shoesize =$mods->shoesize;
		$dresssize =$mods->dresssize;
		$bustsize =$mods->bustsize;
		$hips =$mods->hips;
		$waist =$mods->waist;
		$languages =$mods->languages;
		$shirtcollar =$mods->shirtcollar;
		$jacketsuit =$mods->jacketsuit;
		$inseam  =$mods->inseam;
		$interest  =$mods->interest;
?>
<table width="98%" border="0" cellspacing="3" cellpadding="3" class="body" align="center">
  <tr>
  	<td width="25%"><strong><?=LNG_HEIGHT?></strong></td>
	<td><input type="text" name="height" value="<?=stripslashes($height)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong>LNG_WEIGHT</strong></td>
	<td><input type="text" name="weight" value="<?=stripslashes($weight)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_SKIN_COLOR?></strong></td>
	<td>
		<input type="text" name="skincolor" value="<?=stripslashes($skincolor)?>">
	</td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_HAIR_COLOR?></strong><br><span class="orangebody"></span></td>
	<td><input type="text" name="haircolor" value="<?=stripslashes($haircolor)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_SHOE_SIZE?></strong><br><span class="orangebody"></span></td>
	<td><input type="text" name="shoesize" value="<?=stripslashes($shoesize)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_DRESS_SIZE?></strong><br><span class="orangebody"></span></td>
	<td><input type="text" name="dresssize" value="<?=stripslashes($dresssize)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_BUST_SIZE?></strong><br><span class="orangebody"></span></td>
	<td><input type="text" name="bustsize" value="<?=stripslashes($bustsize)?>"></td>
	<td class="orangebody"></td>
  </tr>
    <tr>
  	<td><strong><?=LNG_HIPS?></strong><br><span class="orangebody"></span></td>
	<td><input type="text" name="hips" value="<?=stripslashes($hips)?>"></td>
	<td class="orangebody"></td>
  </tr>
   <tr>
  	<td><strong><?=LNG_WAIST?></strong><br><span class="orangebody"></span></td>
	<td><input type="text" name="waist" value="<?=stripslashes($waist)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_INTERESTS?></strong><br><span class="orangebody"><?=LNG_SEP_WITH_COMMA?></span></td>
	<td><input type="text" name="interest" value="<?=stripslashes($interest)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
    <td><strong><?=LNG_PHOTO?></strong></td>
    <td><input type="file" name="photo"></td>
    <td class="orangebody"></td>
  </tr>
</table>
<?
	}//actor

	//account
	elseif($type=="account")	{
		$email=$mem->email;
		$fname=$mem->fname;
		$lname=$mem->lname;
		$acc=$mem->mem_acc;
		$notifications=$mem->notifications;
		$sql_accc="select * from member_package order by package_amt";
		$res_accc=mysql_query($sql_accc);
		$sql="select * from member_package where package_id=".$acc;
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		$package_amt=$row->package_amt;
		$sql_max="select max(package_amt) as amt_max from member_package";
		$res_max=mysql_query($sql_max);
		$row_max=mysql_fetch_object($res_max);
?>
<table width="98%" border="0" cellspacing="3" cellpadding="3" class="body" align="center">
  <tr>
  	<td><strong><?=LNG_EMAIL?></strong><br><span class="orangebody"><?=LNG_YOUR_LOGIN?></span></td>
	<td><input type="text" name="email" value="<?=$email?>"><br><span class="orangebody"><?=LNG_ENTER_NEW_EMAIL?></span></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td></td>
	<td><input type="password" name="password"><br><span class="orangebody"><?=LNG_PASS_REQ_TO_CNANGE_EMAIL?></span></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_FIRST_NAME?></strong></td>
	<td><input type="text" name="fname" value="<?=stripslashes($fname)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_LAST_NAME?></strong></td>
	<td><input type="text" name="lname" value="<?=stripslashes($lname)?>"></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_PASSWORD?></strong></td>
	<td class="action"><a href="index.php?mode=user&act=chpass&lng=<?=$lng_id?>"><?=LNG_CHANGE_PASSWORD?></a></td>
	<td class="orangebody"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_MEMBERSHIP?></strong></td>
	<td>
		<? if($row_max->amt_max==$package_amt) { ?>
			<?=stripslashes($row->package_nam)?><input name="pack" type="hidden" value="<?=$acc?>">
		<? } else {
			if(mysql_num_rows($res_accc)) {
				$ssco=0;
				while($row_accc=mysql_fetch_object($res_accc)) {
					if($package_amt<$row_accc->package_amt) {
						$dis="<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
					}
		?>
		<?=$dis?><br>
		<?
					$dis="";
				}
			}
		}
		?>
	</td>
	<td class="orangebody"><input name="pack_old" type="hidden" value="<?=$acc?>"></td>
  </tr>
  <tr>
  	<td><strong><?=LNG_EMAIL_NOTIFY?></strong></td>
	<td colspan="2">
		<input type="checkbox" name="notifications" value="1"<? echo checked($notifications,"1"); ?>>
		<?=LNG_EMAIL_IN_INBOX?>
	</td>
  </tr>
</table>
<?
	}//account
}//function

function change_password()	{
	global $cookie_url;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$m_acc=cookie_get("mem_acc");
	$pro=form_get("pro");
	if($pro=='')	{
		show_header();
     ?>
<form action="index.php" name="profile" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr><td height="5"></td></tr>
  <tr>
      <td class="title">&nbsp;<b><?=LNG_EDIT_PROFILE?> - <?=LNG_CHANGE_PASSWORD?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="title">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body action">
          <tr align="center"> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=basic&lng=<?=$lng_id?>"><?=LNG_BASICS?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=personal&lng=<?=$lng_id?>"><?=LNG_PERSONAL?></a></b></td>
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>"><?=LNG_PROFESSIONAL?></a></b></td>
            <td class="lined-top lined-right lined-left"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account&lng=<?=$lng_id?>"><?=LNG_ACCOUNT?></a></b></td>
            <?php if($m_acc!=0) { ?> 
            <td class="lined"><b><a href="index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>"><?=LNG_PHOTOS?></a></b></td>
            <?php } ?> </tr>
        </table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
	<table width="98%" border="0" cellspacing="0" cellpadding="0" class="body">
	  <tr>
		<td>
			<?=LNG_SHARE_WITH_FRIENDS?><br>
			<?=LNG_BESIC_END_MSG?>
		</td>
	  </tr>
	</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td class="body" align="center">
		<table width="75%" border="0" cellspacing="3" cellpadding="3" class="body">
		  <tr>
			<td><strong><?=LNG_OLD_PASSWORD?>:</strong></td>
			<td><input type="password" name="oldpass"></td>
		  </tr>
		  <tr>
			<td><strong><?=LNG_NEW_PASSWORD?>:</strong></td>
			<td><input type="password" name="newpass"></td>
		  </tr>
		  <tr>
			<td><strong><?=LNG_CONF_PASSWORD?>:</strong></td>
			<td><input type="password" name="newpass2"></td>
		  </tr>
		</table>
	</td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
      <td class="body" align="left"> 
        <input type="hidden" name="mode" value="user">
		<input type="hidden" name="act" value="chpass">
		<input type="hidden" name="pro" value="done">
		<input type="hidden" name="type" value="account">
		<input type="hidden" name="redir" value="">
		<input type=button onClick="window.location='index.php?mode=people_card&p_id=<?=$m_id?>&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
		<input type=button onClick="window.location='index.php?mode=user&act=profile&pro=edit&type=professional&lng=<?=$lng_id?>'" value="<?=LNG_PREVIOUS?>">
		<?php if($m_acc==0) { ?><input type=button value="<?=LNG_NEXT?>"><?php } else { ?><input type="button"  onclick="window.location='index.php?mode=user&act=profile&pro=edit&type=photos&lng=<?=$lng_id?>'" value="<?=LNG_NEXT?>"><?php } ?>
		<input type=button onClick="javascript:formsubmit('account')" value="<?=LNG_CHANGE_PASSWORD?>">&nbsp;&nbsp;
	</td>
  </tr>
  <tr><td height="5"></td></tr>
</table>
</form>
<?
		show_footer();
	}	elseif($pro=='done')	{
		//getting values
		$oldpass=form_get("oldpass");
		$newpass=form_get("newpass");
		$newpass2=form_get("newpass");
		$type=form_get("type");
		$redirect=form_get("redir");
		//if password and confirm are not equal
		if($newpass!=$newpass2)	error_screen(2);
		//crypting old password and checkin
		$crypass=md5($oldpass);
		$sql_query="select password,email from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		if($mem->password!=$crypass)	error_screen(0);
		//crypting new pass and updating db
		$newcrypass=md5($newpass);
		$sql_query="update members set password='$newcrypass' where mem_id='$m_id'";
		sql_execute($sql_query,'');
		//sending user new login info
		$data[0]=$mem->email;
		$data[1]=$newpass;
		messages($mem->email,"3",$data);
		////redirecting////
		$time=time()+3600*24;
		SetCookie("mem_id",$m_id,$time,"/",$cookie_url);
		SetCookie("mem_pass",$newcrypass,$time,"/",$cookie_url);
		$location="index.php?mode=user&act=profile&pro=edit&type=&lng=$lng_id";
		if($redirect=='')	$location.=$type;
		else	$location.=$redirect;
		show_screen($location);
	}
}//function

function photo_upload()	{
	global $_FILES,$base_path,$main_url;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$m_phot=cookie_get("mem_phot");
	$tmpfname=$_FILES['photo']['tmp_name'];
	$ftype=$_FILES['photo']['type'];
	$fsize=$_FILES['photo']['size'];
	$capture=form_get('capture');
	$main=form_get('main');
	if($main=='')	$main=0;
	if(!empty($tmpfname))	{
		//checkin image size
		if($fsize>500*1024)	error_screen(10);
		//checkin image type
		if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
		elseif($ftype=='image/gif')	$p_type=".gif";
		else	error_screen(9);
		$row_chk=photo_album_count($m_id,"1","edi");
		if($row_chk<$m_phot)	{
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$newname_b_th=$newname."bth";
			$old="photos/".$newname.$p_type;
			$thumb1="photos/".$newname_th.".jpeg";
			$thumb2="photos/".$newname_b_th.".jpeg";
			move_uploaded_file($tmpfname,"photos/".$newname.$p_type);
			//creating thumbnails
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
			ImageJpeg($destImage1, $thumb1, 80);
			ImageJpeg($destImage2, $thumb2, 80);
			ImageDestroy($srcImage);
			ImageDestroy($destImage1);
			ImageDestroy($destImage2);
			//updating db
			$now=time();
			$photo="photos/".$newname.$p_type;
			$photo_b_thumb="photos/".$newname_b_th.".jpeg";
			$photo_thumb="photos/".$newname_th.".jpeg";
			if(empty($capture))	$capture=" ";
			$sql_query="update photo set photo=concat(photo,'|$photo'),photo_b_thumb=concat(photo_b_thumb,'|$photo_b_thumb'),photo_thumb=concat(photo_thumb,'|$photo_thumb'),capture=concat(capture,'|$capture') where mem_id='$m_id'";
			sql_execute($sql_query,'');
			if($main=='1')	{
				$sql_query="update members set photo='$photo',photo_thumb='$photo_thumb',photo_b_thumb='$photo_b_thumb' where mem_id='$m_id'";
				sql_execute($sql_query,'');
			}
		}	else	$err_mess="You can upload only upto $m_phot photo(s).<br>Your maximum limit reached.";
	}
	//redirect
	$location="index.php?mode=user&act=profile&pro=edit&type=photos&err_mess=$err_mess&lng=$lng_id";
	show_screen($location);
}//function

function bookmarks_manager()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$pro=form_get("pro");
	//showing bookmarks
	if($pro=='')	{
		show_header();
?>
<table width=100% class="body">
<tr>
    <td class="lined title"><?=LNG_BOOKMARKS?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
<tr>
    <td class=lined align=center> <?
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
       echo LNG_NO_BOOK_MARKS;
     }
     else {
       $res=sql_execute($sql_query,'res');
	   
	   $cnt=0;
	   echo "<table border=0 width=100% cellpadding=2 cellspacing=2>";
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){
				  if($cnt==0)	echo "<tr>";
				  echo "<td class='main-text'>";
				  echo "<table class='lined body'><tr><td align=center>";show_photo($bmr->sec_id);
                  echo "</br>";show_online($bmr->sec_id);echo"</td>
                  <tr><td class=lined align=center>
                  <a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id&lng=$lng_id'><?=LNG_UN_BOOKMARK?></a></td></table>";
				  echo "</td>";
				  $cnt++;
					if ($cnt==6)
					{
						$cnt=0;
						echo "</tr>";
					}	
              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<table class='lined body'><tr><td align=center>
                  <a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id&lng=$lng_id'>$lst->title</a>
                  </td>
                  <tr><td class=lined align=center>
                  <a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id&lng=$lng_id'><?=LNG_UN_BOOKMARK?></a>
                  </td>
                  </table>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<table class='lined body'><tr><td align=center>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id&lng=$lng_id'>$trb->name</a>
                  </td>
                  <tr><td class=lined align=center>
                  <a href='index.php?mode=user&act=bmarks&pro=del&bmr_id=$bmr->bmr_id&lng=$lng_id'><?=LNG_UN_BOOKMARK?></a>
                  </td>
                  </table>";

              }//elseif

       }//while

     }//else
?> 
      <div align="left"></div>
      <div align="left"></div>
    </td>
</table>
<?
show_footer();
}//if
elseif($pro=='add'){
//adding bookmark and redirect to referer
global $HTTP_REFERER;
   $sec_id=form_get("sec_id");
   $type=form_get("type");

   $sql_query="select bmr_id from bmarks where mem_id='$m_id' and sec_id='$sec_id' and
   type='$type'";

   $num=sql_execute($sql_query,'num');

   if($num>0){
     error_screen(23);
   }

   $sql_query="insert into bmarks(mem_id,sec_id,type) values('$m_id','$sec_id','$type')";
   sql_execute($sql_query,'');

   $location=$HTTP_REFERER;
   show_screen($location);
}//elseif
elseif($pro=='del'){
//deleting bookmark and redirecting to referer
global $HTTP_REFERER;

   $bmr_id=form_get('bmr_id');
   $sql_query="delete from bmarks where bmr_id='$bmr_id'";
   sql_execute($sql_query,'');

   $location=$HTTP_REFERER;
   show_screen($location);

}//elseif

}//function

//send invitations outside the system
function invite_page(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
if($pro==''){
show_header();
?>
<table width=100%>
  <tr> 
    <td colspan="3" class="title"> <?=LNG_INVITE_UR_FRIENDS?>
    </td>
  </tr>
  <tr> 
    <td colspan=2>&nbsp;</td>
  <tr> 
    <td class="body padded-6" width=70%> 
      <blockquote> 
        <p><?=LNG_PER_NET_MORE_USEFUL?></p>
        <p><?=LNG_FRM_INVITE_FRIENDS?></p>
        <ul>
          <li><?=LNG_STAY_CONNECTED?> </li>
          <li><?=LNG_TAP_EXP_KNOWL?> </li>
          <li><?=LNG_LARGER_AUDIENCE?> 
          </li>
          <li><?=LNG_GROW_PER_NET?> </br></br> 
          </li>
        </ul>
      <form action="index.php" method=post>
          <input type="hidden" name="mode" value="user">
          <input type="hidden" name="act" value="inv">
          <input type="hidden" name="pro" value="done">
          <span class='orangebody'><?=LNG_REQ_FILD?></span>&nbsp;</br> 
          <table border="0" cellspacing="0" width="100%" class="body padded-6">
            <tr> 
              <td width="14%" align="left" valign="middle" height="157"><b><font color="#0066CC"><?=LNG_FRIEND_EMAILS?></font></b> <span class='orangebody'>*</span></td>
              <td width="86%" height="157"> 
                <p style="margin-top: 0; margin-bottom: 0"> <span class='orangebody'><?=LNG_SEP_MULT_EMAIL?></span></p>
                <p style="margin-top: 0; margin-bottom: 0"> 
                  <textarea rows=5 cols=40 name="emails"></textarea>
                  <br>
              </td>
            </tr>
            <tr> 
              <td width="14%"><b><font color="#0066CC"><?=LNG_SUBJECT?></font></b></td>
              <td width="86%"> 
                <input type=text size=25 name=subject value='<?=LNG_JOIN_WITH_SITE?>'>
              </td>
            </tr>
            <tr> 
              <td width="14%" valign="top"><b><font color="#0066CC"><?=LNG_MESSAGE?></font></b></td>
              <td width="86%"> 
                <textarea name=mes rows=5 cols=50><?=LNG_SITE_LAUNCH?></textarea>
                <br>
              </td>
            </tr>
            <tr> 
              <td width="14%">&nbsp;</td>
              <td align="right" width="86%"> 
                <div align="left"> 
                  <input name="submit" type="submit" value="<?=LNG_INVITE_FRIENDS?>">
                  &nbsp 
                  <input name="button" type=button onClick="window.location='index.php?mode=login&act=home&lng=<?=$lng_id?>'" value='<?=LNG_CANCEL?>'>
                  &nbsp; </div>
              </td>
            </tr>
          </table>
          <p></br> </p>
        </form>
      </blockquote>
      </td>
    <td width="98%" valign=top class="body padded-6 lined"> <b><font color="#0066CC"><?=LNG_LOCKING_SOMEONE?></font></b></br></br> <?=LNG_ALREAD_USE_SITE?></br></br> 
      <span class="orangebody"><?=LNG_COMP_TO_SEARCH?></span></br> 
      <table class=body>
        <form action="index.php" method="post">
          <input type=hidden name="mode" value="search">
          <input type=hidden name="act" value="user">
          <input type=hidden name="type" value="basic">
          <tr> 
            <td width="76"><font color="#0066CC"><b><?=LNG_FIRST_NAME?></b></font></td>
            <td width="85"> 
              <input type=text size=15 name="fname">
            </td>
          <tr> 
            <td width="76"><font color="#0066CC"><b><?=LNG_LAST_NAME?></b></font></td>
            <td width="85"> 
              <input type=text size=15 name="lname">
            </td>
          <tr> 
            <td width="76"><font color="#0066CC"><b><?=LNG_EMAIL?></b></font></td>
            <td width="85"> 
              <input type=text size=15 name="email">
            </td>
          <tr> 
            <td colspan=2><br>
              <input type=submit value="<?=LNG_FIND_ALL_URS?>">
            </td>
        </form>
      </table>
      <br>
      <table border=0 cellpadding=2 cellspacing=2>
          <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>--> 
          <tr> 
            <td class="main-text" align=right> <?=LNG_ADVERTISE_HERE?>
            </td>
          </tr>
          <tr> 
            <td class="main-text" colspan=2 height="148" valign="top" align="center">
              <?=LNG_ADVERTISE_HERE?>
            </td>
          </tr>
      </table>
      <p align="left"> 
    </td>
</table>
<?
show_footer();
}//if
else{
   global $main_url;
   //getting values
   $emails=form_get("emails");
   $subject=form_get("subject");
   $mes=form_get("mes");

   $emails=ereg_replace("\r","",$emails);
   $emails=ereg_replace("\n","",$emails);
   $emails=ereg_replace(" ","",$emails);

   $email=split(",",$emails);
   $email=if_empty($email);
   $data[0]=$subject;
   $now=time();
   if($email!=''){
   show_header();
   echo "<table width=100% class='body'>
   <tr><td class='lined title'><?=LNG_INVITATION?></td>
   <tr><td class='lined'>";
   foreach($email as $addr){
   //if user is site member - standart invitation
      $sql_query2="select mem_id from members where email='$addr'";
      $num=sql_execute($sql_query2,'num');
      if($num!=0){

      $fr=sql_execute($sql_query2,'get');
      $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$fr->mem_id'";
      $num2=sql_execute($sql_query,'num');
      $sql_query="select mes_id from messages_system where
      (mem_id='$m_id' and frm_id='$fr->mem_id' and type='friend') or
      (mem_id='$fr->mem_id' and frm_id='$m_id' and type='friend')";
      $num=sql_execute($sql_query,'num');

   if($m_id==$fr->mem_id){
     echo $addr . " : " . LNG_CANOT_INVITE_USELF . "</br>";
   }//if
   elseif($num>0){
     echo $addr . " - ". LNG_AL_READY_INVITED . "</br>";
   }//elseif
   elseif($num2>0){
     echo $addr . " - " . LNG_ALREADY_FRND . "</br>";
   }//elseif
   else {
///////////////////////////////
       $subj= LNG_INV_TO_JN . "" . name_header($m_id,$fr->mem_id)."\'" . LNG_PER_NETWK;
       $bod= LNG_BOTTON_USER . " ".name_header($m_id,$fr->mem_id). " " . LNG_ADDED_FRIND_NET;
       $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date)
        values('$fr->mem_id','$m_id','$subj','$bod','friend','inbox','$now')";
        sql_execute($sql_query,'');

        echo $addr . " : " . LNG_INVT_IS_SENT . "</br>";
   }//else

       }//if a user
       else {
       //if user is not site member - just sending email
       $sql_query="insert into invitations (mem_id,email,date) values ('$m_id','$addr','$now')";
       sql_execute($sql_query,'');
       $sql_query="select max(inv_id) as maxid from invitations";
       $max=sql_execute($sql_query,'get');
       $data[1]=$mes."<br>
       <a href='$main_url/index.php?mode=join&inv_id=$max->maxid&lng=$lng_id'>$main_url/index.php?mode=join&inv_id=$max->maxid&lng=<?=$lng_id?></a><br><a href='$main_url'>$main_url</a><br>";
       $data[2]=name_header($m_id,"ad");
       $sql_query="select email from members where mem_id='$m_id'";
       $k=sql_execute($sql_query,'get');
       $data[3]=$k->email;
       messages($addr,"6",$data);
       echo $addr . " : " . LNG_INVT_IS_SENT . "</br>";
       }//else
   }//foreach
   echo "</td></table>";
   }//if
   else {
      error_screen(3);
   }//else
   show_footer();
}//else
}//function


function ignore(){
global $HTTP_REFERER;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

  $pro=form_get("pro");
  $mem_id=form_get("p_id");
  //adding to ignore list and redirect to referer
  if($pro=="add"){
      $sql_query="update members set ignore_list=concat(ignore_list,'|$mem_id') where mem_id='$m_id'";
      sql_execute($sql_query,'');
      $location=$HTTP_REFERER;
      show_screen($location);
  }//if
  elseif($pro=="del"){
  //deleting from ignore list and redirecting to referer
      $sql_query="select ignore_list from members where mem_id='$m_id'";
      $mem=sql_execute($sql_query,'get');
      $ignore=split("\|",$mem->ignore_list);
      $ignore=if_empty($ignore);
      $line="";
      if($ignore!=''){
      foreach($ignore as $ign){
          if($ign!=$mem_id){
           $line.="|".$ign;
          }
      }//foreach
      }//if
      else{
         $line='';
      }//else


      $sql_query="update members set ignore_list='$line' where mem_id='$m_id'";
      sql_execute($sql_query,'');
      $location=$HTTP_REFERER;
      show_screen($location);
  }//elseif
  //showign ignore list
  elseif($pro==''){
      show_header();
      echo "<table width=100% class=body>
      <tr><td class='lined title'><?=LNG_MY_IGNORE_LIST?></td>
      <tr><td class=lined align=center>";
      $sql_query="select ignore_list from members where mem_id='$m_id'";
      $mem=sql_execute($sql_query,'get');
      $ignore=split("\|",$mem->ignore_list);
      $ignore=if_empty($ignore);
      if($ignore!=''){
      foreach($ignore as $ign){

         echo "<table class=lined>
         <tr><td vasilek class=lined>";show_photo($ign);echo "</br>";
         show_online($ign);
         echo "</td></table>
         <a href='index.php?mode=user&act=ignore&pro=del&p_id=$ign&lng=$lng_id'><?=LNG_REMOVE?></a>";

      }//foreach
      }//if
      else {
      echo "<p align=center>" . LNG_IGNORE_LIST_EMPTY . "</p>";
      }//else
      echo "
      </td><tr><td>
      <table class='bodytip' cellpadding=0 cellspacing=0 width=100%>
      <tr><td class='dark' align=center><?=LNG_TIP?></td><td align=center class='td-shade'><?=LNG_SEE_LISTINGS?></td></table>
      </td></table>";
      show_footer();

  }//elseif

}//function


function write_testimonial(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
$p_id=form_get("p_id");
if($pro==''){
show_header();
?>
  <table width=100% class='body'>
      <tr>
    <td class="lined title" colspan=2><?=LNG_WRITE_TESTIMONIAL?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
      <tr><td class="lined" colspan=2>
		<p><?=LNG_HOW_U_FEEL?> <? echo name_header($p_id,$m_id); ?> ?</p>
		<p><?=LNG_SPACE_TO_MSG?></p>
		<p><?=LNG_AFTER?> <? echo name_header($p_id,$m_id); ?> <?=LNG_APPROV_TESTI?> <? echo name_header($p_id,$m_id); ?>'<?=LNG_HOME_PG?></p>
		</br>
               <table class='body lined' cellspacing=0 cellpadding=0 align=center>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($p_id); ?></br>
               <? show_online($p_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$p_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($p_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($p_id,"all","num"); ?>
               </td>
               </table>&nbsp</td>
            <tr>
    <td colspan=2 class="title lined"><?=LNG_YOUR_TESTIMONI?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
            <tr><td colspan=2 align=center class=lined>
            <form action="index.php">
            <input type="hidden" name="mode" value="user">
            <input type="hidden" name="act" value="tst">
            <input type="hidden" name="pro" value="done">
            <input type="hidden" name="p_id" value="<? echo $p_id; ?>">
            <textarea name=text rows=5 cols=45></textarea>
            
        <p align=center>
          <input type="submit" value="<?=LNG_SEND?>">
        </p>
      </form>
            </td>
        </table>
      </td>
  </table>
<?
show_footer();
}//if
elseif($pro=='done'){
global $main_url;
   $refer=form_get("refer");
   $text=form_get("text");
   $now=time();
   //updating db
   $sql_query="insert into testimonials (mem_id,from_id,testimonial,added)
   values('$p_id','$m_id','$text','$now')";
   sql_execute($sql_query,'');

   //sending user a message
   $data[0]=name_header($m_id,'');
   $sql_query="select email from members where mem_id='$p_id'";
   $per=sql_execute($sql_query,'get');
   messages($per->email,"4",$data);

   $location=$main_url."/index.php?mode=people_card&p_id=$p_id&lng=$lng_id";
   show_screen($location);

}//elseif
}//function

function friends_view(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pro=form_get("pro");
if($pro=='1'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'><?=LNG_FRNDS?></td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","1");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='2'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'><?=LNG_FRNDS?></td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","2");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends2","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='3'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'><?=LNG_FRNDS?></td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","3");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends3","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='4'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'><?=LNG_FRNDS?></td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","4");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends4","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
elseif($pro=='all'){
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'><?=LNG_FRNDS?></td>
       <tr><td><table align=center>";
       show_friends_deg($m_id,"10","5","$page","all");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friendsall","$page","10");
       echo "</td>
       </table>";
       show_footer();
}//if
}//function

function friends_manager(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
    $pro=form_get("pro");
    if($pro=='add'){
       add_friend();
    }//if
    elseif($pro=='remove'){
       remove_friend();
    }//elseif
    elseif($pro==''){
    //showing friends list
    $page=form_get("page");
    if($page==''){
      $page=1;
    }
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'><?=LNG_FRNDS?></td>
       <tr><td><table align=center>";
       show_friends($m_id,"10","5","$page");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($m_id,"friends","$page","10");
       echo "</td>
       </table>";
       show_footer();
    }//elseif

}//function

function add_friend(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

   $add=form_get("add");
   $frd_id=form_get("frd_id");

   $sql_query="select mes_id from messages_system where
   (mem_id='$m_id' and frm_id='$frd_id' and type='friend') or
   (mem_id='$frd_id' and frm_id='$m_id' and type='friend')";

   $num=sql_execute($sql_query,'num');
   //if user already invited another user to be friends
//   if($num>0){
//     error_screen(18);
//   }//if

   $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$fr->mem_id'";
   $num=sql_execute($sql_query,'num');
   if($num>0){
     error_screen(18);
   }//if

   if($add==''){

   show_header();
   ?>
       <table width=100%>
           <tr>
    <td class="lined padded-6 title"><?=LNG_ADD?> <? echo name_header($frd_id,$m_id); ?> 
      <?=LNG_AS_A_FRIEND?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
           <tr><td class="lined padded-6">
        <table width=100%>
            <tr><td align=right class="title"><?=LNG_TO?></td>
            <td>
            <table class='lined body' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($frd_id); ?></br>
               <? show_online($frd_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$frd_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($frd_id,"1","num"); ?> <?=LNG_IN_A_NET?> <? echo count_network($frd_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php" method=post>
            <input type="hidden" name="mode" value="user">
            <input type="hidden" name="act" value="friends">
            <input type="hidden" name="pro" value="add">
            <input type="hidden" name="add" value="done">
            <input type="hidden" name="frd_id" value="<? echo $frd_id; ?>">
            <tr><td align=right class="title"><?=LNG_SUBJECT?></td>
            <td>
            <input type=text size=25 name=subject value="Invitation to Join <? echo name_header($m_id,$frd_id); ?>'s Personal Network">
            </td>
            <tr><td align=right class="title"><?=LNG_MESSAGE?></td>
            <td>
            <textarea name=mes rows=5 cols=45></textarea>
            </td>
            <tr><td colspan=2 align=right>
            <div align="center">
              <input type="submit" value="<?=LNG_SEND?>">
            </div>
            </form></td>
        </table>
      </td>
  </table>
   <?
   show_footer();
   }//if
   elseif($add=='done'){
        $mes=form_get("mes");
        $subject=form_get("subject");
        $now=time();

        //updating db (putting request to user inbox)
        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date)
        values('$frd_id','$m_id','$subject','$mes','friend','inbox','$now')";
        sql_execute($sql_query,'');

        $sql_query="select email from members where mem_id='$frd_id'";
        $frd=sql_execute($sql_query,'get');

        //sending a message
        $data[0]=$subject;
        $data[1]=$mes;
        messages($frd->email,"5",$data);

        global $main_url;
        $link=$main_url."/index.php?mode=people_card&p_id=$frd_id&lng=$lng_id";

        show_screen($link);

   }//elseif

}//function

function remove_friend(){
//deleting user from friends and redirect to referer
global $HTTP_REFERER;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$frd_id=form_get("frd_id");

          $sql_query="delete from network where mem_id='$m_id' and frd_id='$frd_id'";
          sql_execute($sql_query,'');
          $sql_query="delete from network where mem_id='$frd_id' and frd_id='$m_id'";
          sql_execute($sql_query,'');

          show_screen($HTTP_REFERER);

}//function

//view user's listings
function view_listings(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

show_header();
?>
<table width=100%>
<tr>
    <td class="lined title"><?=LNG_MY_LISTINGS?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
<tr><td class='lined padded-6'><? show_listings("my",$m_id,''); ?></td>
</table>
<?
show_footer();

}//function

//making intro
function make_intro(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$pro=form_get("pro");
$p_id=form_get("p_id");
if($pro==''){
show_header();
?>
   <table width=100% class='body'>
   <tr>
    <td class="lined title"><?=LNG_MAKE_INTROD?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
   <tr>
    <td class='lined padded-6'> 
      <p><?=LNG_HAVE_FRIND_MSG?> <br>
        <?=LNG_MK_INTRO_DISC?> <br>
        <?=LNG_THEY_HV_SOMETHINGS?></p>
   <p align=center>
	   
      <table align=left class='body lined' cellspacing=0 cellpadding=0>
        <tr>
          <td rowspan=2 vasilek class='lined-right padded-6' width="40">&nbsp;</td>
          <td rowspan=2 vasilek class='lined-right padded-6' width="66"><? show_photo($p_id); ?></br> 
            <? show_online($p_id); ?> </td>
          <td class='td-lined-bottom padded-6' width="236"><? connections($m_id,$p_id); ?></td>
        
        <tr>
          <td class='padded-6' width="236"><?=LNG_NET_WK?>: <? echo count_network($p_id,"1","num"); ?> 
            <?=LNG_F_IN_NET?> <? echo count_network($p_id,"all","num"); ?> 
          </td>
        
      </table>
   </p>
   <p>&nbsp;</p></td>
   <tr><td class="lined title"><?=LNG_WHICH_FRND_INTRO?> <? echo name_header($p_id,$m_id); ?></td>
   <tr><td class='lined padded-6'>
   <form action="index.php" method='post'>
   <input type=hidden name='mode' value='user'>
   <input type=hidden name='act' value='intro'>
   <input type=hidden name='p_id' value='<? echo $p_id; ?>'>
   <input type=hidden name='pro' value='done'>
        <?
        $friends=count_network($m_id,"1","ar");
        if($friends!=''){
            foreach($friends as $friend){

                echo " <table class='body' class='lined'>
                <tr><td vasilek>";show_photo($friend);echo "</br>
                <input type=radio name='rec_id' value='$friend'>";show_online($friend);
                echo "</td></table>";

        }//foreach
        }//if
        ?>
   </td>
   <tr><td class=lined align=right>
      <div align="left">
        <input type=submit value='<?=LNG_SEL_FRIND?>'>
      </div>
      </form></td>
   </table>
<?
show_footer();
}//if
elseif($pro=='done'){
global $main_url;

$rec_id=form_get("rec_id");
//redirecting to messages system->compose message with selected recipients
$link=$main_url."/index.php?mode=messages&act=compose&rec_id[]=$rec_id&rec_id[]=$p_id&intro=1&lng=$lng_id";
show_screen($link);

}//elseif
}//function

//showing sent invitations
function sent_invitations(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

show_header();
?>
       <table width=100%>
       <tr>
    <td class='lined title'><?=LNG_INVITE_HISTORY?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
       <tr><td class='lined'>
           <table class=body>

                 <?

                    $sql_query="select * from invitations where mem_id='$m_id'";
                    $res=sql_execute($sql_query,'res');
                    $num=sql_execute($sql_query,'num');
                    if($num==0){
                        echo "<tr><td align=center>" . LNG_NO_INVVT_IS_SENT . "</td>";
                    }//if
                    else {
                    echo "<tr><td>" . LNG_SENT_TO . "</td><td>" . LNG_DATE . "</td><td>" . LNG_STATUS . "</td><td>" . LNG_ACTION . "</td>";
                       while($inv=mysql_fetch_object($res)){
                       $date=date("m/d/Y",$inv->date);
                       if($inv->stat=='p'){
                         $stat='Pending';
                       }//if
                       elseif($inv->stat=='r'){
                         $stat= LNG_USER_REGISTERD;
                       }//elseif
                       elseif($inv->stat=='f'){
                         $stat= LNG_USR_IS_UR_FRND;
                       }//elseif

                           echo "<tr><td>$inv->email</td><td>$date</td><td>$stat</td><td><a href='index.php?mode=user&act=inv_db&pro=del&inv_id=$inv->inv_id&lng=$lng_id'>" . LNG_DELETE . "</a></td>";
                       }//while


                    }//else


                 ?>
           </table></td>
       <tr><td class=lined align=right>
      <div align="left">
        <input type=button value='<?=LNG_BACK?>' onClick='window.location="index.php?mode=login&act=home&lng=<?=$lng_id?>"'>
      </div>
    </td>
       </table>

<?
show_footer();
}//function

function invite_to_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$p_id=form_get("p_id");

$pro=form_get("pro");
if($pro==''){
  show_header();
  ?>
  <table width=100% class='body'>
  <form action='index.php' method=post>
  <input type='hidden' name='mode' value='user'>
  <input type='hidden' name='act' value='invite_tribe'>
  <input type='hidden' name='pro' value='done'>
  <input type='hidden' name='p_id' value='<? echo $p_id; ?>'>
  <tr>
    <td colspan=2 class="lined title"><?=LNG_INVITE?> <? echo name_header($p_id,$m_id); ?> 
      <?=LNG_TO_JOIN?> <? echo $trb->name; ?> <b>- <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
  <tr><td colspan=2 class=lined><table width=100% class='body'>
  <tr><td align=right class="title"><?=LNG_TO?></td>
  <td><table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 class='lined-right padded-6'><? show_photo($p_id); ?></br>
               <? show_online($p_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$p_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?> : <? echo count_network($p_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($p_id,"all","num"); ?>
               </td>
            </table></td>
   <tr><td align=right class="title"><?=ucfirst(LNG_GROUP)?></td><td><select name=tribe>
                     <option value=''><?=LNG_SELECT_GROUP?>
                     <? drop_mem_tribes($m_id,''); ?>
                     </select></td>
   <tr><td align=right class="title"><?=LNG_MESSAGE?></td><td><textarea rows=5 cols=45 name='body'></textarea></td>
   <tr><td></td><td><input type='submit' value='<?=LNG_SEND?>'></td></form>
  </table></td></table>
  <?
  show_footer();

}//if
elseif($pro=='done'){
global $main_url;
$body=form_get("body");
$now=time();
$tribe=form_get("tribe");
$p_id=form_get("p_id");
$subject=name_header($p_id,$m_id)." " . LNG_INV_TO_JOIN;

        if($tribe!=''){
        $join=$main_url."/index.php?mode=tribe&act=join&trb_id=$tribe&lng=$lng_id";
        $body.="\n"."<a href=$join>join</a>";
        $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date,special)
        values('$p_id','$m_id','$subject','$body','message','inbox','$now','$trb_id')";
        sql_execute($sql_query,'');
        $data[0]=$subject;
        $data[1]=$body;
        $data[2]=name_header($m_id,$p_id);
        $sql_query="select email from members where mem_id='$m_id'";
        $k=sql_execute($sql_query,'get');
        $data[3]=$k->email;
        $sql_query="select email from members where mem_id='$p_id'";
        $t=sql_execute($sql_query,'get');
        messages($t->email,"7",$data);
        }//if

 $link=$main_url."/index.php?mode=people_card&p_id=$p_id&lng=$lng_id";
 show_screen($link);

}//elseif
}//function
function del_photo()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	global $main_url;
	$page=form_get("page");
	$pho_id=form_get("pho_id");
	del_album($m_id,"1","del",$pho_id);
	$link=$main_url."/index.php?mode=user&act=profile&pro=edit&type=photos&lng=$lng_id";
	show_screen($link);
}
?>
