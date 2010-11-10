<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
$err_mess=form_get("err_mess");
if($act==''){
  ip_manage();
}
elseif($act=='del'){
  delete_ip();
}
elseif($act=='add'){
  create();
}

function ip_manage(){
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: IP Manager</td>
   <tr>
    <td class='lined padded-6 body' align=center> 
      <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='ip_manager'>
   <input type='hidden' name='act' value='add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <strong>IP :</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=text name='new_ip'>&nbsp;&nbsp;<input type=submit value='Add New IP'>
      </form></td></tr>
   <tr><td class='lined padded-6'>
   <table width=90% align="center" cellpadding=10 cellspacing=1 class='body'>
        <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='ip_manager'>
         <input type='hidden' name='act' value='del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from ips";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp</td><td class='body'><input type=checkbox name='f_cat_id[]' value='$cat->ip_id'></td><td><b>$cat->ip</b></td></tr>";
           }//while
         ?>
         <tr>
          <td colspan=3 align=right> 
            <input name="Submit" type="submit" id="Submit" value="Delete IPs">
          </td>
		 </tr>
   </table></td></table>
<?
show_footer();
}//function

function create(){
$adsess=form_get("adsess");
admin_test($adsess);

$new_ip=form_get("new_ip");
$sql_query="select * from ips where ip='".$new_ip."'";
$num=sql_execute($sql_query,'num');
if($num=="")	{
	$sql_query="insert into ips (ip) values ('".$new_ip."')";
	sql_execute($sql_query,'');
}
ip_manage();
}//function

function delete_ip() {
$adsess=form_get("adsess");
admin_test($adsess);

$f_cat_id=form_get("f_cat_id");

foreach($f_cat_id as $id){
   $sql_query="delete from ips where ip_id='$id'";
   sql_execute($sql_query,'');
}//foreach
ip_manage();
}//function
?>