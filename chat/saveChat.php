<?
require('../data.php');
require('../functions.php');


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

sql_connect();
global $main_url,$base_path;
$mode=form_get("mode");
$act=form_get("act");
if(!empty($mode) or !empty($act))	{
	header("Location:../index.php?mode=$mode&act=$act&lng=$lng_id");
	exit;
}
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
$m_pnam=cookie_get("mem_pnam");
$name=cookie_get("mem_pnam");
login_test($m_id,$m_pass);


/*
if ( !defined( "INCLUDES" ) )
{
	include( "config.php" );
	include( "languages/" . $defaultLanguage . ".php" );
}

*/

show_header();
?>
<br><br><div align='center'>
  <table width='500' border='0' cellspacing='0' cellpadding='0' class='body'>
    <tr>
      <td align="center" class='lined padded-6'><b><?=LNG_SAVECHAT_CHAT_SESS?> : 
        <?=$name?>
        <br>
        <?=LNG_SAVECHAT_ROOM?> : 
        <?=$room?>
        </b></td>
    </tr>
    <tr>
      <td class='lined padded-6'> 
<?php
$connection = new DBConnection();

// get messages, skipping private messages
//echo "select name, message from chat_messages where room = '$room' and name='$name' and message not like '%<private>%' and message not like '%$room%' order by id asc";
$sql_query="select name, message from chat_messages where room = '$room' and name='$name' and message not like '%<private>%' and message not like '%$room%' order by id asc";
$res=sql_execute($sql_query,'res');
$result=sql_execute($sql_query,'get');
//$result = $connection->query( "select name, message from chat_messages where room = '$room' and name='$name' and message not like '%<private>%' and message not like '%$room%' order by id asc" );

$output = "";

/** Parse message and substitute appropriate language messages for language codes. */


/*
function getLanguage( $message )
{
	$words = explode( " ", $message );

	global $language;

	foreach( $words as $word )
	{
		if ( $language[$word] )
			$result .= $language[$word] . " ";
		else
			$result .= $word . " ";
	}
	return $result;
}

while( list( $name, $message ) = mysql_fetch_row( $res ) )
{
	// remove extraneous <FONT> tags
	$name = strip_tags( $name );
	$message = strip_tags( $message );

	$message = getLanguage( $message );
	$name = getLanguage( $name );

	if ( !$message || !$name )
		continue;

	$output .= "<b>$name</b> $message<br>\r\n";
}

$output .= "";

//$connection->close();

print $output;
*/
?>
      </td>
    </tr>
  </table>
	</div>	<br><br>
<?php
show_footer();
//include_once("footer.php");
?>