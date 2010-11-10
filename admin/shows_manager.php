<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if(empty($act))	events_list();
elseif($act=='del')	delete_event();

function events_list()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr><td class="lined title">Admin: Shows Manager</td></tr>
	<tr><td valign="top" class="lined padded-6">
<?
	$page=form_get("page");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	$sql_query="select * from shows order by id desc limit $start,20";
	$p_sql="select id from shows order by id desc";
	$p_url="admin.php?mode=shows_manager&adsess=$adsess";
	$num=sql_execute($sql_query,'num');
	if($num==0)	{
?>
		<table class="body" width="100%" cellpadding="10" cellspacing="1">
		<tr><td align="center">No Shows.</td></tr>
		</table>
<?
	}	else	{
?>
		<form action="admin.php" method="post">
		<table class="body" width="100%" cellpadding="1" cellspacing="1">
          <tr> 
            <td height="1" colspan="6"> <input type="hidden" name="mode" value="shows_manager"> 
              <input type="hidden" name="act" value="del"> <input type="hidden" name="adsess" value="<?=$adsess?>"> 
            </td>
          </tr>
          <tr> 
            <td><strong>Select</strong></td>
            <td><strong>Venue</strong></td>
            <td><strong>Organizer</strong></td>
            <td><strong>Country</strong></td>
            <td><strong>Show Time</strong></td>
            <td><strong>Description</strong></td>
          </tr>
          <?
		$res=sql_execute($sql_query,'res');
		while($fru=mysql_fetch_object($res))	{
?>
          <tr> 
            <td><input type="checkbox" name="fru_id[]" value="<?=$fru->id?>"></td>
            <td> 
              <?=stripslashes($fru->venue)?>
            </td>
            <td><a href="admin.php?mode=users_manager&act=edi&adsess=<?=$adsess?>&mem_id=<?=$fru->mem_id?>"><? echo name_header($fru->mem_id,'ad'); ?></a></td>
            <td> 
              <?=stripslashes($fru->country)?>
            </td>
            <td><? echo date("D M j G:i:s Y",$fru->showdate); ?></td>
            <td> 
              <?=stripslashes($fru->description)?>
            </td>
          </tr>
          <?
		}//while
?>
          <tr> 
            <td colspan="6" align="center" class="body"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
          </tr>
          <tr> 
            <td colspan="6" align="right"><input type="submit" value="Delete Shows" class="button"></td>
          </tr>
        </table>
      </form>
<?
	}//else
?>
</td></tr>
</table>
<?
	show_footer();
}

function delete_event()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$fru_id=form_get("fru_id");
	foreach($fru_id as $fid)	{
		$sql_query="delete from shows where id='$fid;'";
		sql_execute($sql_query,'');
	}
	events_list();
}
?>