<?

if ( !defined( "INCLUDES" ) )
	include( "config.php" );

$connection = new DBConnection();

// read the appropriate language array


include( "languages/" . $lang . ".php" );

$result = "";

// construct a url string from the array

$keys = array_keys( $language );
$numKeys = sizeof( $keys );

for ( $i = 0; $i < $numKeys; $i++ )
{
	//if ( $keys[$i] == "msg12" )
	//	break;	// messages after 12 belong to PHP, not Flash

	if ( $language[$keys[$i]] )
		$result .= $keys[$i] . "=" . str_replace( " ", "+", $language[$keys[$i]] ) . "&";
}

$savedLanguage = $language;
$savedRoomListMap = $roomListMap;

// now, loop through the default language version, and fill in any gaps

include( "languages/$defaultLanguage.php" );

$keys = array_keys( $language );
$numKeys = sizeof( $keys );

for ( $i = 0; $i < $numKeys; $i++ )
{
	//if ( $keys[$i] == "msg12" )
	//	break;	// messages after 12 belong to PHP, not Flash

	if ( !$savedLanguage[$keys[$i]] )
		$result .= $keys[$i] . "=" . str_replace( " ", "+", $language[$keys[$i]] ) . "&";
}

/** Build a string from the $roomListMap array and send to Flash. Check to make sure the mapping is defined by using is_array */

if ( is_array( $savedRoomListMap ) )
{
	$mapKeys = array_keys( $savedRoomListMap );

	foreach( $mapKeys as $mapKey )
	{
		if ( trim( $savedRoomListMap[$mapKey] ) != "" )
			$mapKeyString .= $mapKey . "|" . $savedRoomListMap[$mapKey] . "|";
	}

	if ( $mapKeyString )
		$result .= "mapRoom=" . str_replace( " ", "+", $mapKeyString ) . "&";
}

/** Now, get the starting display options and append to string. */

if ( $useGroups )
{
	// users will only have access to the room for his/her group...

	foreach( $groups as $groupName => $nameList )
	{
		// split the comma delimited list into an array
		$nameArray = explode( ",", $nameList );

		if ( in_array( $name, $nameArray ) )
		{
			$result = $result . "rooms=$groupName";
			break;
		}
	}
}
else	{
	$sql_query="select * from chat_rooms";
	$res=mysql_query($sql_query);
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$rooms.=stripslashes($row->rooms).",";
		}
	}	else	$rooms='';
	$st_co=strlen($rooms);
	$rooms=substr($rooms,0,$st_co-1);
	$result = $result . "rooms=$rooms";
}


$result .= "&max_users=$maxUsersPerRoom&smilie_color=$smilieColor&bgcolor=$backgroundColor&rooms_panel=$usersMayAddRooms&display_panel=$usersMayChangeDisplay&sound_panel=$usersMayChangeSounds&support=$support&show_profiles=$profilePopup&button_text_color=$buttonTextColor&button_color=$buttonColor&init_vol=$initialVolume&snd_send=$sendMsgSound&snd_receive=$receiveMsgSound&snd_enter=$enterRoomSound&snd_leave=$leaveRoomSound&user_font_size=$userlistFontSize&user_font_face=$userlistFontType&msg_font_face=$messageFontType&msg_font_size=$messageFontSize&enter_color=$welcomeColor&private_color=$privateChatInviteColor&user_color=$userlistFontColor&msg_color=$messageFontColor&input_text_color=$inputTextColor&bg_text_color=$textBackgroundColor&welcome_color=$welcomeTitleColor&welcome_name_color=$welcomeTitleNameColor&title_color=$titleFontColor";


/** Now, check modpass to see if this is a moderator or a spy. */

if ( $modpass == $moderatorPassword )
{
	$result .= "&moderator=1";
	$isModerator = true;
}
else if ( $modpass == $spyPassword )
	$result .= "&spy=1";

/** Clean up the chat_users table */

$connection->query( "DELETE FROM chat_users WHERE datetime < NOW() - 15" );

/** Check to see if $name is already present in the database. If it is, then append a number to the end of the name and send back to Flash. */

$numNames = $connection->getValue( "SELECT COUNT(ID) FROM chat_users WHERE name LIKE '$name' AND datetime < NOW() - 15" );

/** If someone else is already using this name in a chat, append a number
at the end of the name so that everyone has a unique identifier. */

if ( $numNames > 0 )
	$name = $name . " " . $numNames;

$result .= "&name=$name";

/** Check for tech support mode. */

if ( $techSupport & !$isModerator )
{
	$room = time() . "_support";
	$result .= "&room=$room";
	$result .= "&support=1";
}
else if ( $techSupport )
{
	$support = 1;
	$result .= "&support=1";
}

/** Check to see which room we should start in. */

// if maxUsersPerRoom < 99999 then check the rooms to find first available one

$roomIndex = "0";

if ( $maxUsersPerRoom < 99999 )
{
	// scan all the rooms in $rooms, and set $roomIndex to be the
	// first that does not exceed our user limit

	$roomsAsArray = explode( ",", $language['rooms'] );

	foreach( $roomsAsArray as $curRoom )
	{
		$numUsersInThisRoom = $connection->getValue( "SELECT COUNT(ID) FROM chat_users WHERE room = '$curRoom'" );

		if ( $numUsersInThisRoom < $maxUsersPerRoom )
		{
			break;
		}
		$roomIndex++;
	}

	// if we have checked all rooms and there are none with space, display an error to the user

	if ( $roomIndex >= sizeof( $roomsAsArray ) )
		$result .= "&errorMsg=" . str_replace( " ", "+", $language['msg28'] );
}

/** Check to make sure that FlashChat is in acceptable hours of operation. */

function validDateTime( $current, $range )
{
	if ( trim( $range ) == "" || !$range )	// no restrictions specified
		return true;

	$rangeArray = explode( ",", $range );

	// loop through the possible range values

	foreach( $rangeArray as $rangeValue )
	{
		// check range
		if ( strstr( $rangeValue, "-" ) )
		{
			// break up the range value into min and max
			list( $min, $max ) = explode( "-", $rangeValue );

			$min = trim( $min );
			$max = trim( $max );	// in case xx - xx was used instead of xx-xx

			if ( $current >= $min && $current < $max )
				return true;
		}

		// check specific value
		else if ( $rangeValue == $current )
			return true;
	}

	return false;
}

if ( $days || $monthdays || $weekdays )
{
	// get the current server day and time

	$serverDayOfMonth = date("j");
	$serverDayOfWeek = date("w");
	$serverHour = date("G");

	$monthDaysValid = validDateTime( $serverDayOfMonth, $monthdays );
	$weekDaysValid = validDateTime( $serverDayOfWeek, $weekdays );
	$hourValid = validDateTime( $serverHour, $hours );

	if ( !$weekDaysValid || !$hourValid || !$monthDaysValid )
	{
		$result .= "&errorMsg=" . str_replace( " ", "+", $language['msg43'] );
	}
}

/** Check for a banned IP address and cleanup IP address tables. */

// do not allow HTML tags in name
$username = strip_tags( $username );

$myip = $_SERVER['REMOTE_ADDR'];

// remove IP addresses from chat_banned that have timed out
$connection->query( "DELETE FROM chat_banned WHERE NOW() - datetime >= $banTime" );

// remove entries from chat_ip that have timed out
$connection->query( "DELETE FROM chat_ip WHERE NOW() - datetime >= $banTime" );

// determine if this user is still banned
$banned = $connection->getValue( "SELECT IP FROM chat_banned WHERE ip = '$myip' AND NOW() - datetime < $banTime" );

if ( $banned )
{
	$banMessage = str_replace( "<ip>", $myip, $language['msg30'] );

	$result .= "&errorMsg=" . str_replace( " ", "+", $banMessage );
}
else
	// insert this user IP address in chat_ip (in case they are banned later)
	$connection->query( "INSERT INTO chat_ip VALUES( '$name', '$myip', NOW() )" );


$result .= "&room_index=$roomIndex";

header("Content-type: application/x-www-form-urlencoded");
header("Pragma: no-cache");
header("Expires: 0");

print $result;

// DO NOT PRINT ANYTHING - NOT EVEN A SPACE OR
// CARRIAGE RETURN - AFTER THIS

?>