<?
require('data.php');
require('functions.php');
sql_connect();
function directory() {
	$song_album=cookie_get("song_album");
	$play=cookie_get("song_sel");
	$tk=cookie_get("song_tk");
	$sql_query="select * from musics where m_id='$song_album'";
	$cat=sql_execute($sql_query,'get');
	$sql_query="select * from songs where s_id='$play'";
	$sel=sql_execute($sql_query,'get');
	$title=stripslashes($sel->s_title);
	$file=$sel->s_name;
	$alb=stripslashes($cat->m_title);
	print "<song title=\"$title\" artist=\"$alb\" path=\"$file\"/>\n";
	$sql_query="select * from songs where s_sec='$song_album'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$tk=1;
		while ($row=mysql_fetch_object($res))	{
			if($row->s_id!=$play)	{
				$title=stripslashes($row->s_title);
				$file=$row->s_name;
				$alb=stripslashes($cat->m_title);
				print "<song title=\"$title\" artist=\"$alb\" path=\"$file\"/>\n";
			}
			$tk++;
		}
	} 
	return $result;
}
?>
<?
print "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<songs>\n";
echo directory();
print "</songs>";
?>
