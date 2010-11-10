<?
if(isset($_GET["lng"]))
{
	$lng_id = $_GET["lng"];
}
else
{
	if(isset($_COOKIE["lang"]))
	{
		$lng_id = $_COOKIE["lang"];		
	}
	else
	{
		$lng_id = 0;	
	}
}


$act=form_get("act");
//showing the forgot form
if($act==''){
show_header();
echo '<table width="100%" class=\'body lined\' align=center>';
?>
<form action="index.php?lng=<?=$lng_id?>" method="post">
<input type="hidden" name="mode" value="forgot">
<input type="hidden" name="act" value="done">
<tr>
    <td colspan="2" align=center><br>
      <br>
      <br>
      <?=LNG_PREVIOUS_EMAIL?>
      <br>
      <?=LNG_PASS_EMAIL?><br>
      <br>
      <br>
      <br>
    </td>
<tr>
	<td align=right width=40%><?=LNG_EMAIL?></td>
	<td align=left><input type="text" size="20" name="email" class="textfield"></td>
<tr><td>&nbsp;</td><td align=left><input type="submit" class="textfield" name="Submit" value="<?=LNG_FORGOT_GO?>">
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
    </td>
</form>
</table>
<?
show_footer();
}
elseif($act=='done'){
global $main_url;
$email=form_get("email");
//checking if inputted e-mail is registered
$sql_query="select mem_id,email from members where email='$email'";
$num=sql_execute($sql_query,'num');
if($num==0){
error_screen(5);
}
//creating temporary password
$mem=sql_execute($sql_query,'get');
$pass=$mem->email;
$salt=time();
$temp_pass=crypt($pass,$salt);
$cry_temp_pass=md5($temp_pass);
$sql_query="update members set password='$cry_temp_pass' where mem_id='$mem->mem_id'";
sql_execute($sql_query,'');
$data[0]=$email;
$data[1]=$temp_pass;

//sending new login data to user
messages($email,"1",$data);
complete_screen(1);
}
?>
