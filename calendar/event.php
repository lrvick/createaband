<?
require_once("includes/config.php");

$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$id=form_get("id");
$query = "SELECT * FROM calendar_events WHERE event_id='$id'";
$query_result = mysql_query ($query);
$query_row = mysql_fetch_object($query_result);
header("Location:index.php?mode=events&act=viewevent&seid=".$query_row->event_para."&page=1");
exit();
$query = "SELECT * FROM calendar_events WHERE event_id='$id'";
$query_result = mysql_query ($query);
while ($info = mysql_fetch_object($query_result)){
	$month=$info->event_month;
	$year=$info->event_year;
	$f_dt=$info->event_day;
    $date = date ("l, jS F Y", mktime(0,0,0,$info->event_month,$info->event_day,$info->event_year));
    $time_array = split(":", $info->event_time);
    $dur_array = split(":", $info->event_dur);
    $time = date ("H:i a", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year));
show_header();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="7%">&nbsp;</td>
    <td width="93%"><table width="100%" height="180" border="0" cellpadding="0" cellspacing="0" class="body">
  <tr>
    <td> 
      <table width="480" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td colspan="2" class="header1"><u><? echo $date . " at " . $time; ?></u></td>
              </tr>
              <tr> 
                <td width="195" height="25" class="body">&nbsp;</td>
                <td width="285" height="25" class="body">&nbsp;</td>
              </tr>
              <?php if($m_id==$info->event_mem)	{	?>
              <tr> 
                <td align="right" valign="bottom" colspan="2" class="body"><a href="calendar.php?mode=event_edit&<? echo "day=$info->event_day&month=$info->event_month&year=$info->event_year&id=$info->event_id"; ?>">Edit</a>&nbsp;&nbsp;&nbsp;<a href="calendar.php?mode=event_delete&<? echo "day=$info->event_day&month=$info->event_month&year=$info->event_year&id=$info->event_id"; ?>">Delete</a></td>
              </tr>
              <?php } ?>
              <tr> 
                <td height="20" class="body">&nbsp;Event Title :</td>
                <td height="20" class="body"> 
                  <?=$info->event_title?>
                </td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Created by :</td>
                <td height="20" class="body"> 
                  <?=show_online($info->event_mem);?>
                </td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Date :</td>
                <td height="20" class="body"> <? echo $date . " at " . $time; ?> 
                </td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Duration :</td>
                <td height="20" class="body"><? echo date ("H:i a", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year)) ?> 
                  - <? echo date ("H:i a", mktime($time_array['0']+$dur_array['0'],$time_array['1']+$dur_array['1'],0,$info->event_month,$info->event_day,$info->event_year)) ?></td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Priority :</td>
                <td height="20" class="body"> 
                  <?=$info->event_priority?>
                </td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Access :</td>
                <td height="20" class="body"> 
                  <?=$info->event_access?>
                </td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Participants :</td>
                <td height="20" class="body"> 
                  <?=$info->event_part?>
                </td>
              </tr>
              <tr> 
                <td height="20" class="body">&nbsp;Updated :</td>
                <td height="20" class="body"> 
                  <?=format_date($info->event_update,0)?>
                </td>
              </tr>
              <tr> 
                <td class="body">&nbsp;Description :</td>
                <td class="body"> 
                  <?=$info->event_desc?>
                </td>
              </tr>
              <tr> 
                <td class="body">&nbsp;</td>
                <td class="body">&nbsp;</td>
              </tr>
              <tr align="center"> 
                <td colspan="2" class="body"> 
                  <form name="form1" method="post" action="calendar.php">
                    <input name="mode" type="hidden" id="mode" value="calendar">
                    &nbsp;Month : 
                    <select name="mont" id="mont">
                      <?php month_show($month,$year); ?>
                    </select>
                    <input type="submit" name="Submit" value="Go">
                  </form></td>
              </tr>
            </table>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>
<? } ?>
<?php
show_footer();
function month_show($month,$year)	{
	$cur_month = date ("M Y", mktime(0,0,0,$month,1,$year));
	$year=$year+1;
	for($i=0; $i<=24; $i++)	{
			$dis_month = date ("M Y", mktime(0,0,0,$month-$i,1,$year));
			$dis_monthval = date ("m/Y", mktime(0,0,0,$month-$i,1,$year));
		if($dis_month == $cur_month)	echo	"<option value='$dis_monthval' selected>$dis_month</option>";
		else	echo	"<option value='$dis_monthval'>$dis_month</option>";
	}
}
function week_show($month,$year,$date)	{
	$cur_weekst = date ("M j", mktime(0,0,0,$month,$date,$year));
	for($i=1; $i<=90; $i++)	{
		$j=$i+6;
		$dis_week = date ("M j", mktime(0,0,0,$month-1,$i,$year))." - ".date ("M j", mktime(0,0,0,$month-1,$j,$year));
		echo	"<option value='".date ("n/j/Y", mktime(0,0,0,$month-1,$i,$year))."'>$dis_week</option>";
		$i=$j;
	}
}
?>