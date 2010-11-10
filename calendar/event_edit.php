<?
require_once("includes/config.php");

$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$submit=form_get("submit");
$day=form_get("day");
$month=form_get("month");
$year=form_get("year");
$id=form_get("id");
$err=form_get("err");
if(isset($submit)){
	$form_data=array ("title","description","day","month","year","hour","minute","invite","pri","acc","dhour","dminute","id");
	while (list($key,$val)=each($form_data)){
		${$val}=form_get("$val");
	}
	if((!empty($title)) and (!empty($description)))	{
		$sql="select * from calendar_events where event_id='$id'";
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		$eve_listid=$row->event_para;
		$stat=$year."-".$month."-".$day;
		mysql_query("update event_list set even_title='".addslashes($title)."',even_stat='".$stat."',even_desc='".addslashes($description)."' where even_id='$eve_listid'");
		mysql_query("update calendar_events set event_day='$day',event_month='$month',event_year='$year',event_time='$hour:$minute'
		,event_title='$title',event_desc='$description',event_part='$invite',event_priority='$pri',event_access='$acc',event_dur='$dhour:$dminute',event_update=now() where event_id='$id'");
		header("Location:calendar.php?mode=event&id=$id");
		exit;
	}	else	{
		$err="Please fill properly";
		header("Location:calendar.php?mode=event_edit&month=$month&day=$day&year=$year&hr=$hour&min=$minute&id=$id&err=$err");
		exit;
	}
}
show_header();
?>
<?php
$query = "SELECT * FROM calendar_events WHERE event_id='$id'";
$query_result = mysql_query ($query);
while ($info = mysql_fetch_object($query_result)){
    $date = date ("l, jS F Y", mktime(0,0,0,$info->event_month,$info->event_day,$info->event_year));
    $time_array = split(":", $info->event_time);
    $dur_array = split(":", $info->event_dur);
    $time = date ("H:i a", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="9%">&nbsp;</td>
    <td width="91%"><form name="form1" method="post" action="calendar.php">
        <table width="480" border="0" cellspacing="0" cellpadding="0" class="body">
          <tr>
            <td height="40" valign="top" class="body">&nbsp;</td>
            <td height="40" valign="top" class="body">&nbsp;</td>
          </tr>
          <?php if(!empty($err)) { ?>
          <tr>
            <td height="25" colspan="2" align="center" valign="top"><font color="#FF0000">
              <?=ucwords($err)?>
              </font></td>
          </tr>
          <?php } ?>
          <tr> 
            <td width="200" height="40" valign="top" class="body">Who Is Invited</td>
            <td height="40" valign="top" class="body"><input name="id" type="hidden" value="<?=$id?>"> 
              <select name="invite" id="invite">
                <option value=""> --- Please Select --- </option>
                <?php if($info->event_part == 'Just my direct Friends') { ?>
                <option value="Just my direct Friends" selected> Just my direct 
                Friends </option>
                <?php } else { ?>
                <option value="Just my direct Friends"> Just my direct Friends 
                </option>
                <?php } ?>
                <?php if($info->event_part == 'Friends and Friends of Friends') { ?>
                <option value="Friends and Friends of Friends" selected> Friends 
                and Friends of Friends </option>
                <?php } else { ?>
                <option value="Friends and Friends of Friends"> Friends and Friends 
                of Friends </option>
                <?php } ?>
              </select> <input name="mode" type="hidden" id="mode" value="event_edit"> 
            </td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="addevent">Event Title 
              *</td>
            <td height="40" valign="top"> <input name="title" type="text" id="title" size="30" value="<?=$info->event_title?>"> 
            </td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="addevent">Event Description 
              *</td>
            <td height="40" valign="top"> <textarea name="description" cols="25" rows="5" id="description"><?=$info->event_desc?></textarea> 
            </td>
          </tr>
          <tr> 
            <td valign="top" colspan="2" class="addevent">&nbsp;</td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="body">Event Date</td>
            <td height="40" valign="top" class="body">Month 
              <select name="month" id="month">
                <?php for($i=1; $i<=12; $i++) { ?>
                <option value="<?=$i?>" <? if($info->event_month == $i){ echo "selected"; } ?>>
                <?=$i?>
                </option>
                <?php } ?>
              </select>
              Date 
              <select name="day" id="day">
                <?php for($i=1; $i<=31; $i++) { ?>
                <option value="<?=$i?>" <? if($info->event_day == $i){ echo "selected"; } ?>>
                <?=$i?>
                </option>
                <?php } ?>
              </select>
              Year 
              <select name="year" id="year">
                <?php
			$year	=	date ("Y", mktime(0,0,0,$month,$date,$year));
		?>
                <?php for($i=$year; $i<=$year+7; $i++) { ?>
                <option value="<?=$i?>" <? if($info->event_year == $i){ echo "selected"; } ?>>
                <?=$i?>
                </option>
                <?php } ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="body">Event Time</td>
            <td height="40" valign="top" class="body"> <select name="hour" id="hour">
                <?php for($i=0; $i<=23; $i++)	{	?>
                <option value="<?=$i?>" <? if($time_array[0] == $i){ echo "selected"; } ?>><? echo date ("H", mktime($i,0,0,$month,$date,$year)); ?></option>
                <?php } ?>
              </select>
              : 
              <select name="minute" id="minute">
                <?php for($i=0; $i<=59; $i++)	{	?>
                <option value="<?=$i?>" <? if($time_array[1] == $i){ echo "selected"; } ?>><? echo date ("i", mktime(0,$i,0,$month,$date,$year)); ?></option>
                <?php } ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="body">Duration</td>
            <td height="40" valign="top" class="body"> <select name="dhour" id="dhour">
                <?php for($i=0; $i<=23; $i++)	{	?>
                <option value="<?=$i?>" <? if($dur_array[0] == $i){ echo "selected"; } ?>><? echo date ("H", mktime($i,0,0,$month,$date,$year)); ?></option>
                <?php } ?>
              </select>
              : 
              <select name="dminute" id="dminute">
                <?php for($i=0; $i<=59; $i++)	{	?>
                <option value="<?=$i?>" <? if($dur_array[1] == $i){ echo "selected"; } ?>><? echo date ("i", mktime(0,$i,0,$month,$date,$year)); ?></option>
                <?php } ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="body">Priority</td>
            <td height="40" valign="top" class="body"> <select name="pri" id="pri">
                <option value=""> --- Select --- </option>
                <?php if($info->event_priority == 'High') { ?>
                <option value="High" selected> High </option>
                <?php } else { ?>
                <option value="High"> High </option>
                <?php } ?>
                <?php if($info->event_priority == 'Medium') { ?>
                <option value="Medium" selected> Medium </option>
                <?php } else { ?>
                <option value="Medium"> Medium </option>
                <?php } ?>
                <?php if($info->event_priority == 'Low') { ?>
                <option value="Low" selected> Low </option>
                <?php } else { ?>
                <option value="Low"> Low </option>
                <?php } ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="200" height="40" valign="top" class="body">Access</td>
            <td height="40" valign="top" class="body"> <select name="acc" id="acc">
                <option value=""> --- Select --- </option>
                <?php if($info->event_access == 'Public') { ?>
                <option value="Public" selected> Public </option>
                <?php } else { ?>
                <option value="Public"> Public </option>
                <?php } ?>
                <?php if($info->event_access == 'Confidential') { ?>
                <option value="Confidential" selected> Confidential </option>
                <?php } else { ?>
                <option value="Confidential"> Confidential </option>
                <?php } ?>
              </select>
              <input name="ul" type="hidden" value="index"> </td>
          </tr>
          <tr> 
            <td width="200">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input name="submit" type="submit" id="submit" value="Modify Event"></td>
          </tr>
        </table>
</form></td>
  </tr>
</table>
<?php } ?>
<?php
show_footer();
?>
