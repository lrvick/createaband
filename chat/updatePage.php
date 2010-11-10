<?

if ( !defined( "INCLUDES" ) )
	include( "config.php" );

if ( !$lang )
	$lang = $defaultLanguage;

include( "languages/$lang.php" );

$output = "";

$connection = new DBConnection();

$name = addslashes( $name );

// updates users in ALL rooms...
$connection->query( "UPDATE chat_users SET datetime = NOW() WHERE name = '$name' AND room = '$room'" );

// delete users that have not had their 'update time' renewed in X seconds
$connection->query( "DELETE FROM chat_users WHERE datetime < NOW() - 15" );

// general maintenence.. delete all chat messages from all rooms older than 12 hours (assumes no chat will last that long)
$connection->query( "DELETE FROM chat_messages WHERE datetime < NOW() - 43200" );

function parseURL( $inputString )
{
	$inputTokens = explode( " ", $inputString );

	$input = "";

	foreach( $inputTokens as $token )
	{
		// check for email address
		if ( eregi( "^[0-9a-z]([-_.]?[0-9a-z]*)*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]*$", $token ) )
		{
			$token = "<U><A HREF=\"mailto:" . $token . "\">" . $token . "</A></U>";
		}
		// check for https:// and http://
		else if( eregi( "^https?://[A-Za-z0-9\%\?\_\:\~\/\.-]+$", $token ) )
		{
			$token = "<U><A TARGET=\"linkWindow\" HREF=\"" . $token . "\">" . $token . "</A></U>";
		}
		// check for www.
		else if( eregi( "^w{3}\.[A-Za-z0-9\%\?\_\:\~\/\.-]+\.[a-z]*$", $token ) )
		{
			$token = "<U><A TARGET=\"linkWindow\" HREF=\"http://" . $token . "\">" . $token . "</A></U>";
		}

		$input .= $token . " ";
	}

	return trim( $input );
}

// clean up the user input by replacing "bad words" with a mask
function checkBadWords($inputString)
{
	global $badWords, $badWordSubstitute;

	$naughty = array();

	foreach ( $badWords as $badWord )
	{
		$naughty["/$badWord/i"] = $badWordSubstitute;
	}

	return preg_replace( array_keys($naughty), array_values($naughty), $inputString );
}

if ( $input )
{
	$input = trim( addslashes( $input ) );

	if ( $userto )
	{
		// determine which room $userto is in so that we may direct our private message appropriately

		$toroom = $connection->getValue( "SELECT room FROM chat_users WHERE name = '$userto'" );
	}

	if ( $input == "admin::invite" )	// "admin::invite" is generated from "INVITE" button, not from textfield
	{
		// a new public or private room has been created

		// get the list of people who should be notified of this new private room (if private)

		if ( $userto == "ALL_USERS" )
		{
			// generate $recipientList via a DB query
			$recipientResult = $connection->query( "SELECT name FROM chat_users" );

			while( list( $thisUser ) = $connection->next( $recipientResult ) )
			{
				$recipientList [] = $thisUser;
			}
		}
		else
		{
			// generate $recipientList using data sent from Flash
			$recipientList = explode( "|", $userto );
		}

		foreach( $recipientList as $recipient )
		{
			// do not send the notification to the person who created the room (that comes after the foreach loop)
			if ( !$recipient || $recipient == $userfrom )
				continue;

			// get the room that $recipient is in
			$toroom = $connection->getValue( "SELECT room FROM chat_users WHERE name = '$recipient'" );

			// convert ' and " to unicode (replace with PHP urlencode function?)
			$newroom = str_replace( "\'", "%27", $newroom );
			$newroom = str_replace( "\"", "%22", $newroom );


			if ( $userto == "ALL_USERS" )
				$input = "<private><RM=" . str_replace( " ", "_", $newroom ) . "><B>[msg15]</B>: msg18|||<name>|$userfrom|<room>|$newroom";

			else
				$input = "<private><RM=" . str_replace( " ", "_", $newroom ) . "><B>[msg13]</B>: msg17|||<name>|$userfrom|<room>|$newroom";

			$connection->query( "INSERT INTO chat_messages VALUES( NULL, '$toroom', '$recipient', '$input', NOW() )" );
		}

		if ( $userto == "ALL_USERS" )
		{
			$newPublicRoom = $language['msg15'];
			$newPublicRoomMessage = str_replace( "<room>", $newroom, $language['msg16'] );

			// now notify the sender of that the messages have been sent out
			$input = "<private><B>[$newPublicRoom]</B>: $newPublicRoomMessage";
		}
		else
		{
			$privateChatInvite = $language['msg13'];
			$privateChatInviteMessage = str_replace( "<room>", $newroom, $language['msg14'] );

			// now notify the sender of that the messages have been sent out
			$input = "<private><B>[$privateChatInvite]</B>: $privateChatInviteMessage";
		}

		// send a message to the room we are *actually* in right now
		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$userfrom', '$input', NOW() )" );
	}

	else if ( $input == "admin::ringbell" )
	{
		// <RB> tag = Ring Bell

		$ringBellMessage = str_replace( "<name>", $userfrom, $language['msg12'] );

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '', '', '<RB><B>$ringBellMessage</B>', NOW() )" );
	}

	else if ( $input == "admin::private" )
	{
		$private_message = parseURL( $private_message );

		// if we are in tech support mode, then all messages are private, so there is no need to insert [Private from...]

		if ( $techSupport )
			$input = "<private><B>[$userfrom]</B>: $private_message";
		else
			$input = "<private><B>[msg40]</B>: $private_message|||<name>|$userfrom";


		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$toroom', '$userto', '$input', NOW() )" );

		// insert a notification to the person who *sent* the private message

		if ( $techSupport )	// note: the <notify> tag has been removed from these lines
		{
			$messageToName = str_replace( "<name>", $userto, $language['msg41'] );

			$input = "<private><B>[$messageToName]</B>: $private_message";
		}
		else
		{
			$privateToName = str_replace( "<name>", $userto, $language['msg42'] );

			$input = "<private><B>[$privateToName]</B>: $private_message";
		}

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$userfrom', '$input', NOW() )" );
	}

	else if ( $input == "admin::reset" )
	{
		$connection->query( "DELETE FROM chat_users WHERE room = '$room'" );
		$connection->query( "DELETE FROM chat_messages WHERE room = '$room'" );
	}

	else if ( $input == "admin::history" )
	{
		$ID = 1;
	}

	else if ( $input == "admin::banall" )	// ban user from all rooms
	{
		$inputPrefix = "<banall><private><B>[msg19]</B>: ";

		// Flash will concatenate $inputPrefix to the result of the $inputMergeItem + $inputMergeBody merge
		// performing this merge at Flash will give the user the correct message + the correct language

		// merge syntax: bodyText|||mergeTag1|mergeItem1|mergeTag2|mergeItem2|mergeTag3|...

		$input = $inputPrefix . "msg21|||<name>|$userfrom";

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$toroom', '$userto', '$input', NOW() )" );

		$boot = $language['msg19'];
		$input = "<private><B>[$boot]</B>: " . str_replace( "<name>", $userto, $language['msg22'] );

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$userfrom', '$input', NOW() )" );
	}

	else if ( $input == "admin::banroom" )	// boot user from this room only (the room they are currently in)
	{
		$inputPrefix = "<banroom><private><B>[msg19]</B>: ";	// NOTE: used to be <banall> ... bug in actionscript?

		$input = $inputPrefix . "msg23|||<name>|$userfrom|<room>|$toroom";

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$toroom', '$userto', '$input', NOW() )" );

		$bootFromRoomMessage = str_replace( "<name>", $userto, $language['msg51'] );
		$bootFromRoomMessage = str_replace( "<room>", $toroom, $bootFromRoomMessage );

		$boot = $language['msg19'];
		$input = "<private><B>[$boot]</B>: $bootFromRoomMessage";

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$userfrom', '$input', NOW() )" );
	}

	else if ( $input == "admin::banip" )
	{
		$userip = $connection->getValue( "SELECT ip FROM chat_ip WHERE name = '$userto'" );

		// get the IP address of this banned user and input into the chat_banned table
		// (effectively preventing them from re-logging in should they refresh their screen)

		$connection->query( "INSERT INTO chat_banned VALUES( '$userip', NOW() )" );

		// now boot this user name from all rooms (effectively booting them from the chat)

		$inputPrefix = "<banall><private><B>[msg20]</B>: ";

		$input = $inputPrefix . "msg24|||<name>|$userfrom|<ip>|$userip";

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$toroom', '$userto', '$input', NOW() )" );

		// send the moderator a notification of the ban

		$banFromAllMessage = str_replace( "<name>", $userto, $language['msg25'] );
		$banFromAllMessage = str_replace( "<ip>", $userip, $banFromAllMessage );

		$input = "<private><B>[$ban]</B>: $banFromAllMessage";

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$userfrom', '$input', NOW() )" );
	}

	else
	{
		$input = parseURL( $input );

		$input = checkBadWords( $input );

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$name', ': $input', NOW() )" );
	}
}

if ( $action == "get_users" )	// get the values to update the "users" window
{
	// update profile hidden status
	$connection->query( "UPDATE chat_users SET hide_profile = '$hp' WHERE name = '$name'" );

	$result = $connection->query( "SELECT name, room, moderator, hide_profile FROM chat_users ORDER BY ID Desc" );

	$output = "output=";

	while( list( $userName, $userRoom, $isModerator, $hideProfile ) = $connection->next( $result ) )
	{
		$output .= "<U>";

		if ( $isModerator )
			$output .= "<M>";

		if ( $hideProfile == 1 )	// only link is hidden
			$output .= "<H>";

		else if ( $hideProfile == 2 )	// completely hidden (spy mode)
			$output .= "<S>";

		$output .= "$userName<R>$userRoom";
	}
}
else if ( $action == "get_messages" )	// get the values to update the "messages" window. Do not execute unless we have a valid ID
{
	$outputString = "";

	// do a ->query instead of a ->getValue here in case we have two users with the same name in different rooms
	$numUsersResult = $connection->query( "SELECT ID FROM chat_users WHERE name = '$name' AND room = '$room'" );

	// check to see if this is a new entry to the chat room. Do not allow entry of blank $name/$room values
	if ( $room && $name && $connection->rowsInResult( $numUsersResult ) == 0 && !$spy )
	{
		// if we are the first person entering a room, then delete all previous messages in this room

		if ( !$connection->getValue( "SELECT ID FROM chat_users WHERE room = '$room'" ) )
		{
			$connection->query( "DELETE FROM chat_messages WHERE room = '$room'" );
			//$ID = $maxID = 0;
		}
		else
		{
			// get the new maxID *for this room*

			if ( $techSupport && $moderator )
			{
				// if in tech support mode and this is a moderator, then get ALL messages across ALL rooms
				$maxID = $connection->getValue( "SELECT MAX(ID) FROM chat_messages" );
			}
			else
			{
				$maxID = $connection->getValue( "SELECT MAX(ID) FROM chat_messages WHERE room = '$room'" );

			}
			$ID = $maxID;
		}

		$time = " (msgTime)";

		if ( $techSupport && !$moderator )
			$welcomeMsg = "<enter><support><B>[msg26]</B>: msg27|||<name>|$name";	// send the support technician a message

		else
			$welcomeMsg = "<enter><B>[$room]</B>: $name msg50 $time";	// will perform a substitution at Flash for msg50

		$connection->query( "INSERT INTO chat_messages VALUES ( NULL, '$room', '$name', '$welcomeMsg', NOW() )" );

		// final 0 means that chat profile is *not* hidden by default, although users may opt to hide it
		if ( !$spy )
			$hidden = "0";
		else
			$hidden = "2";	// 2 = spy mode (no profile entry at all!)

		$connection->query( "INSERT INTO chat_users VALUES ( NULL, '$name', '$room', NOW(), '$moderator', $hidden )" );


		// remove old room references (do not need to do this because it will time out!)
		$connection->query( "DELETE FROM chat_users WHERE name = '$name' AND room <> '$room'" );
	}

	// NOTE: the 'OR name = '$name' clause is so that people can receive private messages even from people in other rooms


	// if we are in tech support mode, and this person is a tech support person, then get all messages with ID > $ID,
	// regardless of room name

	if ( $techSupport && $moderator )
	{
		$result = $connection->query( "SELECT ID, name, message FROM chat_messages WHERE ID > $ID ORDER BY ID ASC" );
	}
	else
	{
		$result = $connection->query( "SELECT ID, name, message FROM chat_messages WHERE room = '$room' AND ID > $ID ORDER BY ID ASC" );
	}

	while( list( $ID, $thisName, $thisMessage ) = $connection->next( $result ) )
	{
		// check for private chat invites. Skip those that don't belong to us

		if ( strstr( $thisMessage, "<private>" ) )
		{
			// NOTE: <notify> may be archaic (?)

			if ( $thisName != $name || ( strstr( $thisMessage, "<notify>" ) && !is_numeric( $room ) ) )
				continue;
			else
				$thisName = "";
		}

		$outputString .= "<ID=$ID>" . $thisName . $thisMessage . "<BR>";
	}

	if ( $outputString != "" )
		$output = "output=$outputString";
	else
		$output = "output=";

	if ( !$maxID )	// this is an actual input to the chat, not just a "...has entered the chat..."
	{
		if ( $techSupport && $moderator )
		{
			$maxID = $connection->getValue( "SELECT MAX(ID) FROM chat_messages" );
		}
		else
		{
			$maxID = $connection->getValue( "SELECT MAX(ID) FROM chat_messages WHERE room = '$room'" );
		}
	}

	// get the max ID so that we dont have to return as much data in each transmission
	$output .= "&maxID=$maxID";
}

// get the moderator message and append to output string
//$output .= "&moderator=" . $connection->getValue( "SELECT message FROM chat_moderator WHERE ID=1" );

if ( $numUsersWithSameName )
	$output .= "&newName=" . $name;	// update name

// format the output
$output = str_replace( " ", "+", $output );
//$output = addslashes( $output );

$connection->close();

header("Content-type: application/octetstream");
header("Pragma: no-cache");
header("Expires: 0");

print $output;

?>