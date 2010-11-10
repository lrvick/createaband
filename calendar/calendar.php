<?
require_once("includes/config.php");

$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$done=form_get("done");

/*$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());  
$db_select = mysql_select_db ($DBName) or die (mysql_error());
$db_table = $TBL_PR . "events";*/

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 

$time_start = getmicrotime();
$mont	=	form_get("mont");
$month	=	form_get("month");
$year	=	form_get("year");
if(!empty($mont))	{
	$tmp	=	split("/",$mont);
	$month	=	$tmp[0];
	$year	=	$tmp[1];
}
if(empty($year))	$year = date("Y");
if(empty($month))	$month = date("n");

$query = "SELECT * FROM calendar_events WHERE event_month='$month' and event_year='$year' and event_active='Y' ORDER BY event_time";
$query_result = mysql_query ($query);
while ($info = mysql_fetch_array($query_result))
{
    $day = $info['event_day'];
    $event_id = $info['event_id'];
    $events[$day][] = $info['event_id'];
    $event_info[$event_id]['0'] = substr($info['event_title'], 0, 8);;
    $event_info[$event_id]['1'] = $info['event_time'];
	$event_info[$event_id]['2'] = $info['event_dur'];
}

$todays_date = date("j");
$todays_month = date("n");
$todays_year = date("Y");
$first_day_of_month = date ("w", mktime(0,0,0,$month,1,$year));
$first_day_of_month = $first_day_of_month;
$days_in_month = date ("t", mktime(0,0,0,$month,1,$year));
$count_boxes = 0;
$days_so_far = 0;
if(($month == $todays_month) and ($year == $todays_year))	$f_dt=$todays_date;
else	$f_dt=1;
if($month == 12){
    $next_month = 1;
    $next_year = $year + 1;
	if($month == 1)	$prev_year = $year-1;
	else	$prev_year = $year;
	$prev_month = 11;
} else {
	if($month == 1)	$prev_year = $year-1;
	else	$prev_year = $year;
    $next_month = $month + 1;
    $next_year = $year;
	$prev_month = $month - 1;
}
/*if($month == 2){
    $prev_month = 13;
    $prev_year = $year - 1;
} else {
    $prev_month = $month - 1;
    $prev_year = $year;
}*/
show_header();
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="80%">  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="middle"> 
          <td colspan="3" class="datehead"><? echo date ("F Y", mktime(0,0,0,$month,1,$year)); ?></td>
        </tr>
		<tr><td colspan="3" align="center" class="body"><b>To add or to view an event click on the specific date</b></td></tr>
        <tr> 
          <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> 
                  <?php require 'mini/prev_cal.php'; ?>
                </td>
              </tr>
            </table></td>
          <td width="200" align="center">&nbsp;</td>
          <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="right"> 
                  <?php require 'mini/next_cal.php'; ?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table>
  <br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="1" cellpadding="0" cellspacing="0" class="body">
                    <tr valign="bottom"> 
                      <td width="100" height="20" align="center" class="datetitle">Sunday</td>
                      <td width="100" height="20" align="center" class="datetitle">Monday</td>
                      <td width="100" height="20" align="center" class="datetitle">Tuesday</td>
                      <td width="100" height="20" align="center" class="datetitle">Wednesday</td>
                      <td width="100" height="20" align="center" class="datetitle">Thursday</td>
                      <td width="100" height="20" align="center" class="datetitle">Friday</td>
                      <td width="100" height="20" align="center" class="datetitle">Saturday</td>
                    </tr>
                    <tr valign="top"> 
                      <?
		for ($i = 1; $i <= $first_day_of_month; $i++) {
			$days_so_far = $days_so_far + 1;
			$count_boxes = $count_boxes + 1;
			echo "<td width=\"100\" height=\"100\" class=\"dayboxes\">&nbsp;</td>\n";
		}
		for ($i = 1; $i <= $days_in_month; $i++) {
   			$days_so_far = $days_so_far + 1;
   			$count_boxes = $count_boxes + 1;
			if($month == $todays_month and $year == $todays_year){
				if($i == $todays_date)	$class = "daytitlecol";
				else	$class = "dayboxes";
			} else	$class = "dayboxes";
			echo "<td width=\"100\" height=\"100\" class=\"$class\">\n";
			$link_month = $month;
			$dt=date("m/d/Y", mktime(0, 0, 0, $month, $i, $year));
			echo "<div align=\"right\">\n<a href='index.php?mode=events&cat=&act=create&dt=$dt' title'Create Your Event'>$i</a>&nbsp;</div>\n";
			if(isset($events[$i])){
				echo "<div align=\"left\">\n";
				while (list($key, $value) = each ($events[$i])) {
					$till=$event_info[$value]['1']+$event_info[$value]['2'];
					echo "&nbsp;<a href=\"calendar.php?mode=event&id=$value\">&nbsp;&raquo;&nbsp;".$event_info[$value]['0']."</a>\n<br>\n";
				}
				echo "</div>\n";
			}
			echo "</td>\n";
			if(($count_boxes == 7) and ($days_so_far != (($first_day_of_month) + $days_in_month))){
				$count_boxes = 0;
				echo "</tr><tr valign=\"top\">\n";
			}
		}
		$extra_boxes = 7 - $count_boxes;
		if($extra_boxes < 7	)	{
			for ($i = 1; $i <= $extra_boxes; $i++) {
				echo "<td width=\"100\" height=\"100\" class=\"title\">&nbsp;</td>\n";
			}
		}
		$time_end = getmicrotime();
		$time = round($time_end - $time_start, 3);
		?>
                    </tr>
                  </table></td>
              </tr><tr>
                <td class="lined"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td align="right">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td class="body"> <form name="form1" method="post" action="calendar.php">
					  <input name="mode" type="hidden" id="mode" value="calendar">
                          &nbsp;Month : 
                          <select name="mont" id="mont">
                            <?php month_show($month,$year); ?>
                          </select>
                          <input type="submit" name="Submit" value="Go">
                        </form></td>
                      <td align="right" class="body"> <form name="form2" method="post" action="calendar.php">
						  <input name="mode" type="hidden" id="mode" value="week">		
                          Week : 
                          <select name="wee" id="wee">
                            <?php week_show($month,$year,$f_dt); ?>
                          </select>
                          <input type="submit" name="Submit" value="Go">
                          &nbsp; 
                        </form></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
  </tr>
</table>
</td><td valign="top" align="center"><script language="Javascript"></script></td>
  </tr>
</table>
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