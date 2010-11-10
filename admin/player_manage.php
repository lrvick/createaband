<?
 
will be considered as the violation of the copyright laws */ 
$adsess=form_get("adsess");
admin_test($adsess);
$done=form_get("done");
if(empty($done))	{
	show_ad_header($adsess);
?>
<script language="JavaScript1.2">
<!-- Begin
function popUp() {
day = new Date();
id = day.getTime();
urlPop="admin/player.php";
windowW=290
windowH=215
windowX = (screen.width/2)-(windowW/2);
windowY = (screen.height/2)-(windowH/2);
eval("page" + id + " = window.open(urlPop, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+windowW+",height="+windowH+",left="+windowX+",top="+windowY+"');");
}
// End -->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title">&nbsp;Admin: Site Musics Manager</td>
  </tr>
  <tr> 
    <td align="right" class="action"><a href="javascript:popUp();">Play 
      Songs</a>&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><form name="form1" method="post" action="admin.php" enctype="multipart/form-data">
        <table width="75%" border="0" cellspacing="0" cellpadding="0" class="body">
          <tr> 
            <td width="37%" height="30"><strong>Song 1</strong></td>
            <td width="63%" height="30"> <input name="file[]" type="file" id="file[]"></td>
          </tr>
          <tr> 
            <td height="30"><strong>Song 2</strong></td>
            <td height="30"><input name="file[]" type="file" id="file[]"></td>
          </tr>
          <tr> 
            <td height="30"><strong>Song 3</strong></td>
            <td height="30"><input name="file[]" type="file" id="file[]"></td>
          </tr>
          <tr> 
            <td height="30"><strong>Song 4</strong></td>
            <td height="30"><input name="file[]" type="file" id="file[]"></td>
          </tr>
          <tr> 
            <td height="30"><strong>Song 5</strong></td>
            <td height="30"><input name="file[]" type="file" id="file[]"></td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2"><input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>">
              <input name="done" type="hidden" id="done" value="done">
              <input name="mode" type="hidden" id="mode" value="player_manage">
              <input type="submit" name="Submit" value="Upload"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?
	show_footer();
}	else	{
	global $_FILES;
	$tmpmname1=$_FILES['file']['tmp_name'][0];
	$fmtype1=$_FILES['file']['type'][0];
	$name1=$_FILES['file']['name'][0];
	if($fmtype1=="audio/mpeg")	move_uploaded_file($tmpmname1,"sitesongs/1.mp3");
	$tmpmname2=$_FILES['file']['tmp_name'][1];
	$fmtype2=$_FILES['file']['type'][1];
	$name2=$_FILES['file']['name'][1];
	if($fmtype2=="audio/mpeg")	move_uploaded_file($tmpmname2,"sitesongs/2.mp3");
	$tmpmname3=$_FILES['file']['tmp_name'][2];
	$fmtype3=$_FILES['file']['type'][2];
	$name3=$_FILES['file']['name'][2];
	if($fmtype3=="audio/mpeg")	move_uploaded_file($tmpmname3,"sitesongs/3.mp3");
	$tmpmname4=$_FILES['file']['tmp_name'][3];
	$fmtype4=$_FILES['file']['type'][3];
	$name4=$_FILES['file']['name'][3];
	if($fmtype4=="audio/mpeg")	move_uploaded_file($tmpmname4,"sitesongs/4.mp3");
	$tmpmname5=$_FILES['file']['tmp_name'][4];
	$fmtype5=$_FILES['file']['type'][4];
	$name5=$_FILES['file']['name'][4];
	if($fmtype5=="audio/mpeg")	move_uploaded_file($tmpmname5,"sitesongs/5.mp3");
	$link="admin.php?mode=player_manage&adsess=$adsess";
	show_screen($link);
}
?>