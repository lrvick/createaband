<?
 
will be considered as the violation of the copyright laws */ 
$adsess=form_get("adsess");
admin_test($adsess);
$sql_query="select count(mem_id) as tot from members";
$mem=sql_execute($sql_query,'get');
$sql_query="select count(mem_id) as tot from members where verified='y'";
$memv=sql_execute($sql_query,'get');
$sql_query="select count(mem_id) as tot from members where verified<>'y'";
$memn=sql_execute($sql_query,'get');
$day_of_week=date("w");
$month_start=mktime(0,0,0,date("m"),1,date("Y"));
$week_start=mktime(0,0,0,date("m"),date("d")-$day_of_week,date("Y"));
$day_start=mktime(0,0,0,date("m"),date("d"),date("Y"));

//$sql_query="select mem_id from members where joined like '$day_start'";
//$day_sgns=sql_execute($sql_query,'num');
//$sql_query="select mem_id from members where joined like '$week_start'";
//$week_sgns=sql_execute($sql_query,'num');
//$sql_query="select mem_id from members where joined like '$month_start'";
//$month_sgns=sql_execute($sql_query,'num');

$sql_query="select * from stats";
$stats=sql_execute($sql_query,'get');

$day_sgnin=$stats->day_sgnin;
$week_sgnin=$stats->week_sgnin;
$month_sgnin=$stats->month_sgnin;

$day_vis=$stats->day_vis;
$week_vis=$stats->week_vis;
$month_vis=$stats->month_vis;

$day_sgns=$stats->day_sgns;
$week_sgns=$stats->week_sgns;
$month_sgns=$stats->month_sgns;

$vis=$stats->vis;



$visits=split("\|",$vis);
//$visits=if_empty($visits);

for($i=0;$i<23;$i++){
  for($j=0;$j<count($visits);$j++){
       $hour=date("H",$visits[$j]);
       if($i==$hour){
          $hours[$i][$j]=$j;
       }//if
  }//for
}//for

$all=count($visits);

$max=0;
$t=0;
for($s=0;$s<23;$s++){
  $per=((count($hours[$s])/$all))*100;
  $perc[$s]=(int)($per);
  if(count($houts[$s])>$max){
     $t=$s;
  }
}

show_ad_header($adsess);
?>
  <table width=100%>
      <tr><td class='lined title'>Statistics</td>
      <tr><td><table class='body lined' width=100%>
      <tr><td class='padded-6' width=70% valign=top>
Number of members: <?=$mem->tot?><br>
Number of verified members: <?=$memv->tot?><br>
Number of not-verified members: <?=$memn->tot?><br>
Number of visitors today: <?=$day_vis?><br>
Number of visitors this week: <?=$week_vis?><br>
Number of visitors this month: <?=$month_vis?><br>
Number of signups today: <?=$day_sgns?><br>
Number of signups this week: <?=$week_sgns?><br>
Number of signups this month: <?=$month_sgns?><br>
Number of signin today: <?=$day_sgnin?><br>
Number of signin this week: <?=$week_sgnin?><br>
Number of signin this month: <?=$month_sgnin?><br>
      </td>
      <td width="30%" align=left class='padded-6'>
<?
echo "Visitors from 00:00 till 01:00 ".count($hours[0])."($perc[0]%)</br>";
echo "Visitors from 01:00 till 02:00 ".count($hours[1])."($perc[1]%)</br>";
echo "Visitors from 02:00 till 03:00 ".count($hours[2])."($perc[2]%)</br>";
echo "Visitors from 03:00 till 04:00 ".count($hours[3])."($perc[3]%)</br>";
echo "Visitors from 04:00 till 05:00 ".count($hours[4])."($perc[4]%)</br>";
echo "Visitors from 05:00 till 06:00 ".count($hours[5])."($perc[5]%)</br>";
echo "Visitors from 06:00 till 07:00 ".count($hours[6])."($perc[6]%)</br>";
echo "Visitors from 07:00 till 08:00 ".count($hours[7])."($perc[7]%)</br>";
echo "Visitors from 08:00 till 09:00 ".count($hours[8])."($perc[8]%)</br>";
echo "Visitors from 09:00 till 10:00 ".count($hours[9])."($perc[9]%)</br>";
echo "Visitors from 10:00 till 11:00 ".count($hours[10])."($perc[10]%)</br>";
echo "Visitors from 11:00 till 12:00 ".count($hours[11])."($perc[11]%)</br>";
echo "Visitors from 12:00 till 13:00 ".count($hours[12])."($perc[12]%)</br>";
echo "Visitors from 13:00 till 14:00 ".count($hours[13])."($perc[13]%)</br>";
echo "Visitors from 14:00 till 15:00 ".count($hours[14])."($perc[14]%)</br>";
echo "Visitors from 15:00 till 16:00 ".count($hours[15])."($perc[15]%)</br>";
echo "Visitors from 16:00 till 17:00 ".count($hours[16])."($perc[16]%)</br>";
echo "Visitors from 17:00 till 18:00 ".count($hours[17])."($perc[17]%)</br>";
echo "Visitors from 18:00 till 19:00 ".count($hours[18])."($perc[18]%)</br>";
echo "Visitors from 19:00 till 20:00 ".count($hours[19])."($perc[19]%)</br>";
echo "Visitors from 20:00 till 21:00 ".count($hours[20])."($perc[20]%)</br>";
echo "Visitors from 21:00 till 22:00 ".count($hours[21])."($perc[21]%)</br>";
echo "Visitors from 22:00 till 23:00 ".count($hours[22])."($perc[22]%)</br>";
echo "Visitors from 23:00 till 00:00 ".count($hours[23])."($perc[23]%)</br>";
?>
      </td></table></td>
  </table>
<?
show_footer();
?>