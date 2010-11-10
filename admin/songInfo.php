<?
 
will be considered as the violation of the copyright laws */ 
require('../data.php');
function directory() {
	for($i=1; $i<=5; $i++)	{
		$title="Track_".$i;
		$file="../sitesongs/".$i.".mp3";
		$alb="";
		print "<song title=\"$title\" artist=\"$alb\" path=\"$file\"/>\n";
	} 
	return $result;
}
?>
<?
print "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<songs>\n";
echo directory();
print "</songs>";
?>