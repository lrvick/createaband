<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
$err_mess=form_get("err_mess");
if($act==''){
  room_manage();
}
elseif($act=='del'){
  delete_room();
}
elseif($act=='add'){
  create();
}

function room_manage(){
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Chat Rooms Manager</td>
   <tr>
    <td class='lined padded-6 body' align=center> 
      <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='chatroom_manager'>
   <input type='hidden' name='act' value='add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <strong>Room :</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=text name='new_room'>&nbsp;&nbsp;<input type=submit value='Add New Room' class="submit">
      </form></td></tr>
   <tr><td class='lined padded-6'>
   <table width=75% align="center" cellpadding=10 cellspacing=1 class='body'>
        <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='chatroom_manager'>
         <input type='hidden' name='act' value='del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from chat_rooms";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp</td><td class='body'><input type=checkbox name='r_id[]' value='$cat->id'></td><td><b>".stripslashes($cat->rooms)."</b></td></tr>";
           }//while
         ?>
         <tr>
          <td colspan=3 align=right> 
            <input name="Submit" type="submit" id="Submit" value="Delete Rooms" class="submit">
          </td>
		 </tr>
   </table></td></table>
<?
show_footer();
}//function

function create(){
$adsess=form_get("adsess");
admin_test($adsess);

$new_room=form_get("new_room");
if(!empty($new_room))	{
	$sql_query="select * from chat_rooms where rooms='".$new_room."'";
	$num=sql_execute($sql_query,'num');
	if($num=="")	{
		$sql_query="insert into chat_rooms (rooms) values ('".$new_room."')";
		sql_execute($sql_query,'');
	}
}
room_manage();
}//function

function delete_room() {
$adsess=form_get("adsess");
admin_test($adsess);

$r_id=form_get("r_id");

foreach($r_id as $id){
   $sql_query="delete from chat_rooms where id='$id'";
   sql_execute($sql_query,'');
}//foreach
room_manage();
}//function
?>