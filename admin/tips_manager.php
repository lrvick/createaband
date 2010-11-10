<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='')	tips_list();
elseif($act=='new')	new_tip();
elseif($act=='t_add')	add_tip();
elseif($act=='t_del')	delete_tip();

function tips_list()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
 <form action="admin.php" method="post">
   <table width="100%">
   <tr><td class="lined title">Admin: Tips Manager</td><td align="right" class="lined body"><a href="admin.php?mode=tips_manager&act=new&adsess=<?=$adsess?>">New Tip</a>&nbsp;</td></tr>
   <tr><td colspan="2" class="lined padded-6">
         <input type="hidden" name="mode" value="tips_manager">
         <input type="hidden" name="act" value="t_del">
         <input type="hidden" name="adsess" value="<?=$adsess?>">
         <?php
           $sql_query="select * from tips order by tip_id desc";
           $res=sql_execute($sql_query,'res');
			echo "<table width='90%' align='center' cellpadding='10' cellspacing='1' class='body'>";
		   if(mysql_num_rows($res)) {
	           while($cat=mysql_fetch_object($res)){
	               echo "<tr><td><input type='checkbox' name='t_id[]' value='$cat->tip_id'></td><td><b>".stripslashes($cat->tip_header)."</b></td><td>".substr(stripslashes($cat->tip),0,100)."..</td></tr>";
	           }//while
			}	else	{
				echo "<tr><td align=center>No tips</td></tr>";
			}
			echo "</table>";
         ?>
		 </td></tr>
         <tr>
          <td colspan="2" align="right" class="lined padded-6"> 
		  <? if(mysql_num_rows($res)) { ?>
            <input name="Submit" type="submit" id="Submit" value="Delete Tips">
		<? } ?>
          </td></tr></table>
		  </form>
<?php
show_footer();
}//function

function new_tip()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
 <form action="admin.php" method="post">
   <table width="100%">
   <tr><td class="lined title">Admin: Tips Manager</td><td align="right" class="lined"><a href="admin.php?mode=tips_manager&act=new&adsess=<?=$adsess?>">New Tip</a>&nbsp;</td></tr>
   <tr>
      <td colspan="2" class="lined padded-6">
        <table width="43%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="46%" height="30" class="body">Tip Header</td>
            <td width="54%" height="30"> 
              <input name="new_tip" type="text" size="25"> <input type="hidden" name="mode" value="tips_manager"> 
              <input type="hidden" name="act" value="t_add"> <input type="hidden" name="adsess" value="<?=$adsess?>"></td>
          </tr>
          <tr> 
            <td class="body">Message</td>
            <td><textarea name="sys_message" cols="20" rows="3" id="sys_message"></textarea></td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2"> 
              <input name="submit" type="submit" id="submit" value="Add New Tip">
            </td>
          </tr>
        </table> </td>
    </tr>
	</table>
	</form>
<?php
show_footer();
}//function

function add_tip(){
	$adsess=form_get("adsess");
	admin_test($adsess);
	$new_tip=form_get("new_tip");
	$sys_message=form_get("sys_message");
	$sql_query="insert into tips(tip_header,tip) values ('".addslashes($new_tip)."','".addslashes($sys_message)."')";
	sql_execute($sql_query,'');
	tips_list();
}//function

function delete_tip() {
	$adsess=form_get("adsess");
	admin_test($adsess);
	$t_id=form_get("t_id");
	foreach($t_id as $id){
		$sql_query="delete from tips where tip_id='$id'";
		sql_execute($sql_query,'');
	}//foreach
	tips_list();
}//function
?>