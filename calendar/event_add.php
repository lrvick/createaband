<?
require_once("includes/config.php");

$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$submit=form_get("submit");
$day=form_get("day");
$month=form_get("month");
$year=form_get("year");
$hr=form_get("hr");
$err=form_get("err");
$wee=form_get("wee");
if(isset($submit)){
	require_once("includes/config.php");
	//getting values from form
	$form_data=array ("title","description","day","month","year","hour","minute","invite","pri","acc","dhour","dminute","ul","wee");
	while (list($key,$val)=each($form_data)){
		${$val}=form_get("$val");
	}
	if((!empty($title)) and (!empty($description)))	{
		mysql_query("insert into calendar_events (event_id,event_mem,event_day,event_month,event_year,event_time,event_title,event_desc,event_part,event_priority,event_access,event_dur,event_date,event_update)
		 values ('',$m_id,'$day','$month','$year','$hour:$minute','$title','$description','$invite','$pri','$acc','$dhour:$dminute',now(),now())");
		header("Location:calendar.php?mode=$ul&month=$month&day=$day&year=$year&hr=$hour&min=$minute&wee=$wee&err=$err");
		exit;
	}	else	{
		$err="Please fill properly";
		header("Location:calendar.php?mode=event_add&month=$month&day=$day&year=$year&hr=$hour&min=$minute&err=$err");
		exit;
	}
}
show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="5%">&nbsp;</td>
    <td width="95%"><form name="form1" method="post" action="calendar.php">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
    <tr>
      <td height="40" valign="top" class="body">&nbsp;</td>
      <td height="40" valign="top" class="body"><input name="mode" type="hidden" id="mode" value="event_add"></td>
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
      <td height="40" valign="top" class="body"> <select name="invite" id="invite">
          <option value=""> --- Please Select --- </option>
          <option value="Just my direct Friends"> Just my direct Friends </option>
          <option value="Friends and Friends of Friends"> Friends and Friends 
          of Friends </option>
        </select> </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top" class="addevent">Event Title *</td>
      <td height="40" valign="top"> <input name="title" type="text" id="title" size="30"> 
      </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top" class="addevent">Event Description 
        *</td>
      <td height="40" valign="top"> <textarea name="description" cols="25" rows="5" id="description"></textarea> 
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
          <option value="<?=$i?>" <? if($month == $i){ echo "selected"; } ?>>
          <?=$i?>
          </option>
          <?php } ?>
        </select>
        Date 
        <select name="day" id="day">
          <?php for($i=1; $i<=31; $i++) { ?>
          <option value="<?=$i?>" <? if($day == $i){ echo "selected"; } ?>>
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
          <option value="<?=$i?>" <? if($year == $i){ echo "selected"; } ?>>
          <?=$i?>
          </option>
          <?php } ?>
        </select> </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top" class="body">Event Time</td>
      <td height="40" valign="top" class="body"> <select name="hour" id="hour">
          <?php for($i=0; $i<=23; $i++)	{	?>
          <option value="<?=$i?>" <? if($hr == $i){ echo "selected"; } ?>><? echo date ("H", mktime($i,0,0,$month,$date,$year)); ?></option>
          <?php } ?>
        </select>
        : 
        <select name="minute" id="minute">
          <?php for($i=0; $i<=59; $i++)	{	?>
          <option value="<?=$i?>" <? if($min == $i){ echo "selected"; } ?>><? echo date ("i", mktime(0,$i,0,$month,$date,$year)); ?></option>
          <?php } ?>
        </select> </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top" class="body">Duration</td>
      <td height="40" valign="top" class="body"> <select name="dhour" id="dhour">
          <?php for($i=0; $i<=23; $i++)	{	?>
          <option value="<?=$i?>" <? if($dhr == $i){ echo "selected"; } ?>><? echo date ("H", mktime($i,0,0,$month,$date,$year)); ?></option>
          <?php } ?>
        </select>
        : 
        <select name="dminute" id="dminute">
          <?php for($i=0; $i<=59; $i++)	{	?>
          <option value="<?=$i?>" <? if($dmin == $i){ echo "selected"; } ?>><? echo date ("i", mktime(0,$i,0,$month,$date,$year)); ?></option>
          <?php } ?>
        </select> </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top" class="body">Priority</td>
      <td height="40" valign="top" class="body"> <select name="pri" id="pri">
          <option value=""> --- Select --- </option>
          <option value="High"> High </option>
          <option value="Medium"> Medium </option>
          <option value="Low"> Low </option>
        </select> </td>
    </tr>
    <tr> 
      <td width="200" height="40" valign="top" class="body">Access</td>
      <td height="40" valign="top" class="body"> <select name="acc" id="acc">
          <option value=""> --- Select --- </option>
          <option value="Public"> Public </option>
          <option value="Confidential"> Confidential </option>
        </select>
        <?php if(!empty($hr)) { ?>
        <input name="ul" type="hidden" value="week">
        <?php } else { ?>
        <input name="ul" type="hidden" value="calendar">
              <?php } ?>
              <input name="wee" type="hidden" id="wee" value="<?=$wee?>"> </td>
    </tr>
    <tr> 
      <td width="200">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="submit" type="submit" id="submit" value="Add Event"></td>
    </tr>
  </table>
</form>
</td>
  </tr>
</table>
<?php
show_footer();
?>