<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act==''){
  news_manage();
}
elseif($act=='n_del'){
  delete_news();
}

function news_manage(){
global $main_url;
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: News Manager</td>
   <tr><td class='lined padded-6' align=center>
   </td>
   <tr><td class='lined padded-6'>
   <form action='admin.php' method=post>
   <table width=90% align="center" cellpadding=10 cellspacing=1 class='body'>
         <input type='hidden' name='mode' value='news_manager'>
         <input type='hidden' name='act' value='n_del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from news order by own";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=5% align='left'><input type=checkbox name='n_id[]' value='$cat->id'>&nbsp;<b>".stripslashes($cat->title)."</b></td></tr>";
           }//while
         ?>
         <tr>
          <td align=right> 
            <input name="Submit" type="submit" id="Submit" value="Delete News">
          </td>
		 </tr>
   </table></form></td></table>
<?
show_footer();
}//function

function delete_news() {
$adsess=form_get("adsess");
admin_test($adsess);

$n_id=form_get("n_id");

foreach($n_id as $id){
	$sql_query="select * from news where id='$id'";
	$num=sql_execute($sql_query,'num');
	if($num!=0)	{
		$row_img=sql_execute($sql_query,'get');
		$pic_out="./".$row_img->img;
		if(file_exists($pic_out))	@unlink($pic_out);
	}
  	$sql_messrem="delete from news where id=$id";
	mysql_query($sql_messrem);
  	$sql_messrem="delete from news_comments where news_id=$id";
	mysql_query($sql_messrem);
}//foreach

news_manage();
}//function
?>