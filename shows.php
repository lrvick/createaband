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
if(empty($act))	 shows();
elseif($act=='view')	view();

function shows()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$page=form_get("page");
	$country=form_get("country");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	if(empty($country))	$country=show_from_members("country",$m_id);
	$sql_query="select * from shows where country='$country' order by id desc limit $start,20";
	$p_sql="select * from shows where country='$country' order by id desc";
	$res=sql_execute($sql_query,'res');
	$p_url="index.php?mode=shows&lng=" . $lng_id;
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
  <tr> 
    <td class="hometitle" height="20" style="padding-left: 12"><?=LNG_SHOWS_SHOW_IN?> <?=ucwords(stripslashes($country))?></td>
  </tr>
  <tr> 
    <td height="20" style="padding-right: 12;padding-top: 3" align="right">
	<form action="index.php" method="post" name="shows">
	<input type="hidden" name="mode" value="shows">
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><select name="country" onChange="javascript:document.shows.submit();"><? echo country_drop($country); ?></select></td>
		</tr>
	</table>
	</form>
	</td>
  </tr>
  <tr> 
    <td align="center" valign="top">
<? if(!mysql_num_rows($res)) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
<tr>
  <td height="20" align="center"><?=LNG_SHOWS_NO_SHOW_IN?> <?=ucwords(stripslashes($country))?></td>
</tr>
</table>
<? } else { ?>
      <table width="98%" border="0" cellspacing="0" cellpadding="0" class="body lined">
        <tr class="lined"> 
          <td width="8%" height="25" class="title" style="padding-left: 7"><?=LNG_DATE?></td>
          <td width="7%" height="25" class="title"><?=LNG_SHOWS_TIME?></td>
          <td width="18%" height="25" class="title"><?=LNG_SHOWS_BRAND?></td>
          <td width="23%" height="25" class="title"><?=LNG_SHOWS_VENUE?></td>
          <td width="35%" height="25" class="title"><?=LNG_LOCATION?></td>
          <td width="9%" height="25" class="title"><?=LNG_SHOWS_COST?></td>
        </tr>
        <? while($row=mysql_fetch_object($res)) { ?>
        <tr class="lined body"> 
          <td height="20" style="padding-left: 1"><? echo date("m.d.y",$row->showdate); ?></td>
          <td height="20"><? echo date("g:ia",$row->showdate); ?></td>
          <td height="20"><? echo musical_link($row->mem_id); ?></td>
          <td height="20"><a href="index.php?mode=shows&act=view&rec_id=<?=$row->id?>&lng=<?=$lng_id?>"><strong><?=stripslashes($row->venue)?></strong></a></td>
          <td height="20">
		  <? if(!empty($row->address)) { ?><?=stripslashes($row->address)?>, <? } ?><? if(!empty($row->city)) { ?><?=stripslashes($row->city)?><br><? } ?>
		  <? if(!empty($row->state)) { ?><?=stripslashes($row->state)?>, <? } ?><? if(!empty($row->country)) { ?><?=stripslashes($row->country)?> <? } ?><? if(!empty($row->zip)) { ?>- <?=stripslashes($row->zip)?><? } ?>
		  </td>
          <td height="20"><?=stripslashes($row->cost)?></td>
        </tr>
        <tr><td height="3" colspan="6"></td></tr>
       <? } ?>
        <tr><td height="3" colspan="6"></td></tr>
        <tr> 
          <td height="20" colspan="6" align="right" class="body" style="padding-right: 17"><? echo page_nums($p_sql,$p_url,$page,20); ?></td>
        </tr>
      </table>
<? } ?>
	</td>
  </tr> 
</table>
<?
	show_footer();
}

function view()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$rec_id=form_get("rec_id");
	$sql_query="select * from shows where id='$rec_id'";
	$row=sql_execute($sql_query,'get');
	show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body lined">
  <tr> 
    <td class="hometitle" height="20" style="padding-left: 12"><?=LNG_SHOWS_SHOW_DETAILS?></td>
  </tr>
  <tr> 
    <td valign="top" class="body" style="padding-left: 12;padding-top: 5">
	<strong><? echo date("D M j G:i:s Y",$row->showdate); ?> - <?=stripslashes($row->venue)?></strong> <? if(!empty($row->cost)) { ?>{<?=stripslashes($row->cost)?>}<? } ?><br>
	<strong><?=LNG_SHOWS_BRAND?>:</strong> <? echo musical_link($row->mem_id); ?><br>
	<? if(!empty($row->address)) { ?><?=stripslashes($row->address)?>, <? } ?><? if(!empty($row->city)) { ?><?=stripslashes($row->city)?><br><? } ?>
	<? if(!empty($row->state)) { ?><?=stripslashes($row->state)?>, <? } ?><? if(!empty($row->country)) { ?><?=stripslashes($row->country)?> <? } ?><? if(!empty($row->zip)) { ?>- <?=stripslashes($row->zip)?><? } ?><br>
	<span style="padding-left: 17"><?=stripslashes($row->description)?></span>
	</td>
  </tr> 
</table>
<?
	show_footer();
}
?>
