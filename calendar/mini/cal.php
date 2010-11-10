<?
//if (isset($_GET['monthno_p'])) $monthno_p = $_GET['prev_month'];
//if (isset($_GET['year_p'])) $year_p = $_GET['year_p'];
if (!isset($prev_month)) $monthno=date(n);
else	$monthno=$prev_month;
if (!isset($prev_year))	$year = date(Y);
else	$year=$prev_year;
$monthfulltext = date(F, mktime(0, 0, 0, $monthno, 1, $year));
$monthshorttext = date(M, mktime(0, 0, 0, $monthno, 1, $year));

$day_in_mth = date(t, mktime(0, 0, 0, $monthno, 1, $year)) ;
$day_text = date(D, mktime(0, 0, 0, $monthno, 1, $year));


?>
<table width=100% border="0" align="center" cellpadding="0" cellspacing="1" class="body">
  <tr> 
    <td colspan="7" align="center" class="hometitle" height="20"><a href="/calendar"><? echo $monthfulltext." ".$year ?></a></td>
  </tr>
  <tr><td colspan="7" height="3"></td></tr>
  <tr align="center"> 
    <td height="20"><strong><font size="-2">Sun</font></strong></td>
    <td height="20"><strong><font size="-2">Mon</font></strong></td>
    <td height="20"><strong><font size="-2">Tue</font></strong></td>
    <td height="20"><strong><font size="-2">Wed</font></strong></td>
    <td height="20"><strong><font size="-2">Thu</font></strong></td>
    <td height="20"><strong><font size="-2">Fri</font></strong></td>
    <td height="20"><strong><font size="-2">Sat</font></strong></td>
  </tr>
  <tr> 
    <?

$day_of_wk = date(w, mktime(0, 0, 0, $monthno, 1, $year));

if ($day_of_wk <> 0){
   for ($i=0; $i<$day_of_wk; $i++)
   { echo "<td height='15'>&nbsp;</td>"; }
}

for ($date_of_mth = 1; $date_of_mth <= $day_in_mth; $date_of_mth++) {

    if ($day_of_wk = 0){
   for ($i=0; $i<$day_of_wk; $i++);
   { echo "<tr align='right'>"; }
}
    $day_text = date(D, mktime(0, 0, 0, $monthno, $date_of_mth, $year));
    $date_no = date(j, mktime(0, 0, 0, $monthno, $date_of_mth, $year));
    $day_of_wk = date(w, mktime(0, 0, 0, $monthno, $date_of_mth, $year));
	if ( $date_no ==  date(j) &&  $monthno == date(n) )	{
		echo "<td height='15' style=\"padding-right: 5\" align='right'><font size='-2'>";
		$dt=date("Y-m-d", mktime(0, 0, 0, $monthno, $date_of_mth, $year));
		$sql_query="select * from event_list where even_stat='$dt' and even_active='Y'";
		$res=sql_execute($sql_query,'res');
		if(mysql_num_rows($res))	echo "<a href='index.php?mode=events&dt=$dt' title='Click to view the event'>";
		echo $date_no;
		if(mysql_num_rows($res))	echo "</a>";
		echo "</font></td>";
	}	else	{
		echo "<td height='15' style=\"padding-right: 5\" align='right'><font size='-2'>";
		$dt=date("Y-m-d", mktime(0, 0, 0, $monthno, $date_of_mth, $year));;
		$sql_query="select * from event_list where even_stat='$dt' and even_active='Y'";
		$res=sql_execute($sql_query,'res');
		if(mysql_num_rows($res))	echo "<a href='index.php?mode=events&dt=$dt'>";
		echo $date_no;
		if(mysql_num_rows($res))	echo "</a>";
		echo "</font></td>";
	}
	if ( $day_of_wk == 6 ) {  echo "</tr>"; }
	if ( $day_of_wk < 6 && $date_of_mth == $day_in_mth ) {
	for ( $i = $day_of_wk ; $i < 6; $i++ ) {
		echo "<td height='15'>&nbsp;</td>";
	}
		echo "</tr>";
	}
 }
?>
</table>