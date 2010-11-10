<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='')	faq_manage();
elseif($act=='new')	new_faq();
elseif($act=='ed')	mod_faq();
elseif($act=='faq_del')	delete_faq();
elseif($act=='cat')	faq_cats_manage();
elseif($act=='c_add')	add_category();
elseif($act=='c_del')	delete_category();

function faq_manage()	{
	global $main_url;
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
   <table width=100% class="lined">
   <tr>
    <td class='title'>&nbsp;Admin: Manage Help</td>
   <tr><td align=center>
   </td>
   <tr><td>
   <form action='admin.php' method=post>
        <table width=90% align="center" cellpadding=10 cellspacing=1 class="body">
          <input type='hidden' name='mode' value='help_manager'>
          <input type='hidden' name='act' value='faq_del'>
          <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
          <?php
		  $page=form_get("page");
		  if(empty($page))	$page=1;
		  $start=($page-1)*20;
           $sql_query="select * from faqs where fa_post='n' order by priority limit $start,20";
		   $p_sql="select * from faqs where fa_post='n' order by priority";
		   $p_url="admin.php?mode=faq_manager&adsess=$adsess";
           $res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
           while($cat=mysql_fetch_object($res)){
		   	$sql_query="select faqcat_nam from faq_cat where faqcat_id='$cat->fa_cat'";
			$fcat=sql_execute($sql_query,'get');
		   ?>
          <tr> 
            <td width="5%" align="left"><input type="checkbox" name="f_id[]" value="<?=$cat->fa_id?>"></td>
            <td align="center"> <table width="90%" align="left" class="body">
                <tr> 
                  <td height="25"><strong>Category : 
                    <?=stripslashes($fcat->faqcat_nam)?>
                    </strong> </td>
                  <td rowspan="2" align="right"><a href="admin.php?mode=help_manager&act=ed&id=<?=$cat->fa_id?>&adsess=<?=$adsess?>">Edit</a>&nbsp;</td>
                </tr>
                <tr> 
                  <td height="25"><strong>Question : </strong> 
                    <?=stripslashes($cat->fa_title)?>
                  </td>
                </tr>
                <tr> 
                  <td colspan="2"> 
                    <?=substr(stripslashes($cat->fa_desc),0,250)?>
                    ... </td>
                </tr>
              </table></td>
          </tr>
          <?php
           }//while
         ?>
          <tr>
            <td colspan=2 align=right><? echo page_nums($p_sql,$p_url,$page,20); ?>&nbsp;</td>
          </tr>
		<? } ?>
          <tr> 
            <td colspan=2 align=right> <input type='button' value='Create New' onclick='window.location="admin.php?mode=help_manager&act=new&adsess=<? echo $adsess; ?>"' class="submit"> 
              &nbsp;
              <input value='Manage Categories' type=button onclick="window.location='admin.php?mode=help_manager&act=cat&adsess=<? echo $adsess; ?>'" class="submit"> 
              <? if(mysql_num_rows($res)) { ?>
              &nbsp;
              <input name="Submit" type="submit" id="Submit" value="Delete Selected" class="submit"> 
              <? } ?>
            </td>
          </tr>
        </table>
      </form></td></table>
<?
	show_footer();
}//function

function new_faq()	{
	global $base_path,$main_url;
	$adsess=form_get("adsess");
	$err_mess=form_get("err_mess");
	$done=form_get("done");
	admin_test($adsess);
	if(empty($done))	{
		show_ad_header($adsess);
?>
<table width=100% class="lined">
  <tr>
    <td class='title'>&nbsp;Admin: Manage Help</td>
   <tr><td align=center>
   </td>
   <tr>
    <td align="center"> 
      <form action='admin.php' method='post'>
        <table width=75% align="center" cellpadding=10 cellspacing=1 class="body">
          <?php if(!empty($err_mess))	{	?>
          <tr valign="middle"> 
            <td height="30" colspan="2" align="center" class="err"> 
              <?=ucwords($err_mess)?>
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td>Category</td>
            <td><select name="f_cat" id="f_cat">
			<?
				$sql_query="select * from faq_cat order by faqcat_id";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
					while($f_cat=mysql_fetch_object($res))	{
						echo "<option value='$f_cat->faqcat_id'>".stripslashes($f_cat->faqcat_nam)."</option>";
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Question</td>
            <td><input name="title" type="text" id="title" size="30"></td>
          </tr>
          <tr> 
            <td width="40%">Description</td>
            <td width="60%"><textarea name="perdesc" cols="50" rows="3" id="perdesc"></textarea></td>
          </tr>
		  <tr>
            <td>Priority</td>
            <td><input name="priority" type="text" id="priority" size="5"></td>
          </tr>
          <tr> 
            <td colspan="2" align=center> <input type='hidden' name='mode' value='help_manager'> 
              <input type='hidden' name='act' value='new'> <input type='hidden' name='done' value='done'> 
              <input type='hidden' name='adsess' value='<? echo $adsess; ?>'> 
              <input name="Submit" type="submit" id="Submit" value="Save" class="submit"></td>
          </tr>
        </table>
      </form></td></table>
<?
		show_footer();
	}	else	{
		$perdesc=form_get('perdesc');
		$title=form_get('title');
		$f_cat=form_get("f_cat");
		$f_priority=form_get("priority");
//		echo "if((!empty(".$tmpfname.")) and (!empty(".$perdesc.")) and (!empty(".$amt.")) and (!empty(".$title.")))	{";
		if((!empty($perdesc)) and (!empty($title)) and (!empty($f_cat)))	{
			$sql_query="insert into faqs (fa_cat,fa_title,fa_desc,fa_date,priority) values ('$f_cat','".addslashes($title)."','".addslashes($perdesc)."',now(),'$f_priority')";
			sql_execute($sql_query,'');
			$location="admin.php?mode=help_manager&adsess=$adsess";
		}	else	{
			$err_mess="fill the form properly!";
			$location="admin.php?mode=help_manager&act=new&adsess=$adsess&err_mess=$err_mess";
		}
		show_screen($location);
	}
}

function mod_faq()	{
	global $base_path,$main_url;
	$adsess=form_get("adsess");
	$err_mess=form_get("err_mess");
	admin_test($adsess);
	$done=form_get("done");
	$id=form_get("id");
	if(empty($done))	{
		$sql_query="select * from faqs where fa_id='$id'";
		$row=sql_execute($sql_query,'get');
		show_ad_header($adsess);
?>
   
<table width=100% class="lined">
  <tr>
    <td class='title'>&nbsp;Admin: Manage Help</td>
   <tr><td align=center>
   </td>
   <tr>
    <td align="center"> 
      <form action='admin.php' method='post'>
        <table width=75% align="center" cellpadding=10 cellspacing=1 class="body">
          <?php if(!empty($err_mess))	{	?>
          <tr valign="middle"> 
            <td height="30" colspan="2" align="center" class="err"> 
              <?=ucwords($err_mess)?>
            </td>
          </tr>
          <?php } ?>
          <tr>
            <td>Category</td>
            <td><select name="f_cat" id="f_cat">
                <?
				$sql_query="select * from faq_cat order by faqcat_id";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
					while($f_cat=mysql_fetch_object($res))	{
						echo "<option value='$f_cat->faqcat_id'";
						if($row->fa_cat==$f_cat->faqcat_id)	echo "selected";
						echo ">".stripslashes($f_cat->faqcat_nam)."</option>";
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Question</td>
            <td><input name="title" type="text" id="title" size="30" value="<?=stripslashes($row->fa_title)?>"></td>
          </tr>
          <tr> 
            <td width="40%">Description</td>
            <td width="60%"><textarea name="perdesc" cols="50" rows="3" id="perdesc"><?=stripslashes($row->fa_desc)?></textarea></td>
          </tr>
		  <tr>
            <td>Priority</td>
            <td><input name="priority" type="text" id="priority" size="5" value="<?=$row->priority?>"></td>
          </tr>
          <tr> 
            <td colspan="2" align=center> <input type='hidden' name='mode' value='help_manager'> 
              <input type='hidden' name='id' value='<?=$id?>'> <input type='hidden' name='act' value='ed'> 
              <input type='hidden' name='done' value='done'> <input type='hidden' name='adsess' value='<? echo $adsess; ?>'> 
              <input name="Submit" type="submit" id="Submit" value="Modify" class="submit"></td>
          </tr>
        </table>
      </form></td></table>
<?
		show_footer();
	}	else	{
		$perdesc=form_get('perdesc');
		$title=form_get('title');
		$f_per=form_get('priority');
//		echo "if((!empty(".$tmpfname.")) and (!empty(".$perdesc.")) and (!empty(".$amt.")) and (!empty(".$title.")))	{";
		if((!empty($perdesc)) and (!empty($title)))	{
			$sql_query="update faqs set fa_title='".addslashes($title)."',fa_desc='".addslashes($perdesc)."',priority='$f_per' where fa_id='$id'";
			sql_execute($sql_query,'');
			$location="admin.php?mode=help_manager&adsess=$adsess";
		}	else	{
			$err_mess="fill the form properly!";
			$location="admin.php?mode=help_manager&act=ed&id=$id&adsess=$adsess&err_mess=$err_mess";
		}
		show_screen($location);
	}
}

function delete_faq()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$f_id=form_get("f_id");
	foreach($f_id as $id)	{
		$sql_query="delete from faqs where fa_id='$id'";
		sql_execute($sql_query,'');
	}//foreach
	faq_manage();
}//function

function faq_cats_manage()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
   <table width=100% class="lined">
   <tr><td class='title'>&nbsp;Admin: Categories Manager</td>
   <tr><td align=center class="body">
   <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='help_manager'>
   <input type='hidden' name='act' value='c_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   Category&nbsp; <input type=text name='new_cat'>&nbsp;
        <input type=submit value='Add New Category' class="submit">
   </form></td>
   <tr><td>
   <table width=90% align="center" cellpadding=10 cellspacing=1 class="body">
        <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='help_manager'>
         <input type='hidden' name='act' value='c_del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from faq_cat order by faqcat_id desc";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp;</td><td><input type=checkbox name='f_cat_id[]' value='$cat->faqcat_id'></td><td><b>".stripslashes($cat->faqcat_nam)."</b></td>";
           }//while
         ?>
         <tr>
          <td colspan=3 align=right> 
            <input name="Submit" type="submit" id="Submit" value="Delete Categories" class="submit">
          </td>
   </table></td></table>
<?
	show_footer();
}//function

function add_category()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$new_cat=form_get("new_cat");
	$sql_query="insert into faq_cat(faqcat_nam) values('".addslashes($new_cat)."')";
	sql_execute($sql_query,'');
	faq_cats_manage();
}//function

function delete_category()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$f_cat_id=form_get("f_cat_id");
	foreach($f_cat_id as $id)	{
		$sql_query="delete from faq_cat where faqcat_id='$id'";
		sql_execute($sql_query,'');
		$sql_query="delete from faqs where fa_cat='$id'";
		sql_execute($sql_query,'');
	}//foreach
	faq_cats_manage();
}//function
?>