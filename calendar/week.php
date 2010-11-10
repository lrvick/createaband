<?
require_once("includes/config.php");

$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

/*$db_connection = mysql_connect ($DBHost, $DBUser, $DBPass) OR die (mysql_error());  
$db_select = mysql_select_db ($DBName) or die (mysql_error());
$db_table = $TBL_PR . "events";*/

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 

$time_start = getmicrotime();
$mont	=	form_get("wee");
$month	=	form_get("month");
$year	=	form_get("year");
if(!empty($mont))	{
	$tmp	=	split("/",$mont);
	$month	=	$tmp[0];
	$date	=	$tmp[1];
	$year	=	$tmp[2];
}
if(empty($year))	$year = date("Y");
if(empty($month))	$month = date("n");

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
<script language="JavaScript1.2" src="includes/pops.js"></script>
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="middle"> 
          <td width="82" height="25" align="left" valign="bottom" class="body">&nbsp;&nbsp;<a href="calendar.php?mode=week&wee=<?=date ("n/j/Y", mktime(0,0,0,$month,$date-7,$year))?>&done=done"><< Previous</a></td>
          <td class="datehead"><? echo date ("F d, Y", mktime(0,0,0,$month,$date,$year)); ?> 
            - <? echo date ("F d, Y", mktime(0,0,0,$month,$date+6,$year)); ?></td>
          <td width="65" height="25" align="right" valign="bottom" class="body"><a href="calendar.php?mode=week&wee=<?=date ("n/j/Y", mktime(0,0,0,$month,$date+7,$year))?>&done=done">Next >></a>&nbsp;&nbsp;</td>
        </tr>
        <tr> 
          <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td>&nbsp;</td>
              </tr>
            </table></td>
          <td width="593" align="center">&nbsp;</td>
          <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="right">&nbsp; </td>
              </tr>
            </table></td>
        </tr>
      </table>
<br><br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><table width="100%" border="1" cellpadding="0" cellspacing="0" class="body">
                    <tr valign="bottom"> 
                      <td width="100" height="20" class="datetitle">&nbsp;</td>
					  <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date,$year)); ?></td>
                      <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date+1,$year)); ?></td>
                      <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date+2,$year)); ?></td>
                      <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date+3,$year)); ?></td>
                      <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date+4,$year)); ?></td>
                      <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date+5,$year)); ?></td>
                      <td width="100" height="20" class="datetitle"><? echo date ("D, F d", mktime(0,0,0,$month,$date+6,$year)); ?></td>
                    </tr>
					<?php for($i=0; $i<=23; $i++)	{	?>
                    <tr valign="bottom">
                      <td height="20" class="datetitle" align="center" valign="middle"><? echo date ("H a", mktime($i,0,0,$month,$date,$year)); ?></td>
					<?php
						$date1	=	date ("j", mktime(0,0,0,$month,$date,$year));
						$month1	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year1	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd1	=	even($date1,$month1,$year1,$i);
						$class1	=	even_class($date1,$month1,$year1,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class1?>"><div align="left">&nbsp;<?=$sdd1?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date1?>&month=<?=$month1?>&year=<?=$year1?>&hr=<?=date ("H", mktime($i,0,0,$month1,$date1,$year1))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
                    <?php
						$date2	=	date ("j", mktime(0,0,0,$month,$date+1,$year));
						$month2	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year2	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd2	=	even($date2,$month2,$year2,$i);
						$class2	=	even_class($date2,$month2,$year2,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class2?>"><div align="left">&nbsp;<?=$sdd2?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date2?>&month=<?=$month2?>&year=<?=$year2?>&hr=<?=date ("H", mktime($i,0,0,$month2,$date2,$year2))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
					  <?php
						$date3	=	date ("j", mktime(0,0,0,$month,$date+2,$year));
						$month3	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year3	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd3	=	even($date3,$month3,$year3,$i);
						$class3	=	even_class($date3,$month3,$year3,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class3?>"><div align="left">&nbsp;<?=$sdd3?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date3?>&month=<?=$month3?>&year=<?=$year3?>&hr=<?=date ("H", mktime($i,0,0,$month3,$date3,$year3))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
                    <?php
						$date4	=	date ("j", mktime(0,0,0,$month,$date+3,$year));
						$month4	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year4	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd4	=	even($date4,$month4,$year4,$i);
						$class4	=	even_class($date4,$month4,$year4,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class4?>"><div align="left">&nbsp;<?=$sdd4?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date4?>&month=<?=$month4?>&year=<?=$year4?>&hr=<?=date ("H", mktime($i,0,0,$month4,$date4,$year4))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
					<?php
						$date5	=	date ("j", mktime(0,0,0,$month,$date+4,$year));
						$month5	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year5	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd5	=	even($date5,$month5,$year5,$i);
						$class5	=	even_class($date5,$month5,$year5,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class5?>"><div align="left">&nbsp;<?=$sdd5?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date5?>&month=<?=$month5?>&year=<?=$year5?>&hr=<?=date ("H", mktime($i,0,0,$month5,$date5,$year5))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
					<?php
						$date6	=	date ("j", mktime(0,0,0,$month,$date+5,$year));
						$month6	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year6	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd6	=	even($date6,$month6,$year6,$i);
						$class6	=	even_class($date6,$month6,$year6,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class6?>"><div align="left">&nbsp;<?=$sdd6?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date6?>&month=<?=$month6?>&year=<?=$year6?>&hr=<?=date ("H", mktime($i,0,0,$month6,$date6,$year6))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
					<?php
						$date7	=	date ("j", mktime(0,0,0,$month,$date+6,$year));
						$month7	=	date ("n", mktime(0,0,0,$month,$date,$year));
						$year7	=	date ("Y", mktime(0,0,0,$month,$date,$year));
						$sdd7	=	even($date7,$month7,$year7,$i);
						$class7	=	even_class($date7,$month7,$year7,"calendar_events",$i);
					?>
					  <td height="20" valign="top" align="center" class="<?=$class7?>"><div align="left">&nbsp;<?=$sdd7?><br></div><div align="right"><a href="calendar.php?mode=event_add&day=<?=$date7?>&month=<?=$month7?>&year=<?=$year7?>&hr=<?=date ("H", mktime($i,0,0,$month7,$date7,$year7))?>&wee=<?=$mont?>" style="text-decoration : none">+</a></div>&nbsp;</td>
                    </tr>
					<?php } ?>
                  </table></td>
              </tr><tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
</td>
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
function even($date,$month,$year,$i)	{
	$query = "SELECT * FROM calendar_events WHERE event_day='$date' and event_month='$month' and event_year='$year' and event_active='Y'";
	$query_result = mysql_query ($query);
	$row	=	mysql_fetch_object($query_result);
	if(!empty($row->event_time))	{
		if($i == $row->event_time)	$ec_matt = "<a href=\"calendar.php?mode=event&id=$row->event_id\" title=\"Duration : ".date ("H:i a", mktime($i,0,0,$month,$date,$year))." - ".date ("H:i a", mktime($i+$row->event_dur,0,0,$month,$date,$year))."\">".date ("H:i", mktime($row->event_time,0,0,$month,$date,$year))."&nbsp;&raquo;&nbsp;".substr($row->event_title,0,8)."</a>";
		else	$ec_matt = "";
	}
	return	$ec_matt;
}
function even_col($date,$month,$year,$db_table,$i)	{
	$query = "SELECT * FROM $db_table WHERE event_day='$date' and event_month='$month' and event_year='$year' and event_active='Y'";
	$query_result = mysql_query ($query);
	$row	=	mysql_fetch_object($query_result);
	if($row->event_time == $i)	{
		if(!empty($row->event_dur))	$ret_dur = $row->event_dur;
	}	else	$ret_dur=0;
	return	$ret_dur;
}
function even_class($date,$month,$year,$db_table,$i)	{
	$query = "SELECT * FROM $db_table WHERE event_day='$date' and event_month='$month' and event_year='$year' and event_active='Y'";
	$query_result = mysql_query ($query);
	if(mysql_num_rows($query_result))	{
		$row = mysql_fetch_object($query_result);
		if($row->event_time == $i)	$ec_matt = "daytitlecol";
		else	$ec_matt = "dayboxes";
	}	else	$ec_matt = "dayboxes";
	return	$ec_matt;
}
?>