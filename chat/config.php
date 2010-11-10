<?
ini_set('error_reporting',7); import_request_variables("GP");

/** MySQL Configuration */
$database = "autv_friends";	// MySQL database name
$dbuser = "autv_masters";	// MySQL username
$dbpass = "jans123";	// MySQL password
$host = "localhost";		// MySQL host name

$moderatorPassword = "jans123";	// to login as a moderator
$spyPassword = "jans123";		// to login as a spy (disabled when using XOOPS)


/** ROOMS. This is the default rooms list. You may add as many rooms as you want,
separated by commas. You should not put any spaces after the commas. If you want
foreign language users to see these room names in their own language, then you
should edit the appropriate $roomListMap file. */

//$rooms = "The Lounge,Hollywood,Tech Talk,Current Events";
//require('rooms.php');
/** Language modules. If you add a language module (ie, create a new
"language_name.php" file in languages folder), add the module name here. For
example, if you add a Hungarian language module, you would just append 'hungarian'
to the end of this line, e.g.:

$languageList = "english,...,italian,hungarian";

(and you would create a hungarian.php file in the /languages folder!)
*/

$languageList = "english,spanish,french,german,italian";

/** The characters to substitute for "bad" words, when found. */

$badWordSubstitute = "!@#$%&";

/** The default language is the language to 'fall back on' if a setting in the
specified language file cannot be found. */

$defaultLanguage = "english";

/** Chat availability days and times.

If you want the chat to only be accessible at
certain hours of the day, or certain days of the week, or certain weeks of
the month, you may specify those hours, weekdays, and days of month here.
Use 0-23 for hours, 0-6 for weekdays, and 0-31 for days of month. For example,
if you set $hours="7-9,12,15-17" and $weekdays="0-2,5,6" then the chat will only
be operable between 7-9 am, 12-1 pm, and 3-5 pm on Sunday through Tuesday,
Friday, and Saturday. If you set $monthdays="1-4,30", then the chat will only
be activated on the first four days of every month and the 30th of every month.
To disable this option, set $hours = ""; $weekdays = ""; and $monthdays="";
The dates and times are always relative to the web server system day/time. */

$hours = "";
$weekdays = "";
$monthdays = "";

/** The amount of time, in seconds, that an IP address is banned for. */

$banTime = 3600;

/** Maximum number of users allowed in each room (must be >0). If you don't want
to limit the number of users, then set this value to 99999  NOTE: If
operating the chat in Tech Support mode, then set this to 99999  */

$maxUsersPerRoom = 99999;

/** To force Chat to operate in "Tech Support" mode, set this
variable to true. In Tech Support mode, every person who logs in will
engage in a 1-on-1 private chat with a moderator. NOTE: If you are a
moderator, you may ONLY send private chat messages, which means that before
sending any message, you must select the recipient from the drop-menu. */

$techSupport = false;

/** If you want the chat room to be in a page other than index.php,
change this variable to match the new file name. */

$indexPath = "index.php";

/** The options that follow affect the chat look and feel, as well
as the available rooms, and behavior in special cirumstances, e.g.
private chats and if Flash 6 is not detected. Instead of giving you a
detailed explanation of each variable, it is much better for you to
experiment with the options to see how they affect the chat. */

/** The page to display if the user does not have Flash 6 */
$noFlash = "noFlash.php";

/** GROUPS: If you want specific users to only have access to certain rooms,
specify the rooms (aka "groups") and users here. You must follow this
format (uses a PHP associative array), and change the $useGroups flag from
false to true. Separate user names with commas, as shown below. In the example
below, there are three chat rooms available: marketing, finance, and public
relations. Joe Smith, Sally Ride, and Bill Paxton only have access to the
marketing room. DO NOT put spaces after the commas! */

$useGroups = false;

$groups = Array (

"marketing" => "Joe Smith,Sally Ride,Bill Paxton",
"finance" => "Dan Johnson,Samantha Gates,Duane Horcher,Bill Murray",
"public relations" => "Julie Moore,Wendy Moore,David Gregory,Jim Sanchez"

);

/**

ADDING ROOMS: Please edit the appropriate language file to add more rooms.
E.g. english.php to edit the chat rooms that one sees when using English.
You can add as many rooms as you wish by editing the

'rooms' => "....",

part of the $language array.

*/

/** Sounds: To disable any individual sound, set its variable to
false. To disable all sounds, set all variables to false. */

$enterRoomSound = true;	// Jetsons sound when user enters room
$leaveRoomSound = true;	// door-shut sound when user leaves room
$receiveMsgSound = false;	// when user receives a message
$sendMsgSound = false;	// when user sends a messages

$initialVolume = 70;	// the initial volume setting (0-100)

/** If you do not want users to modify their display and/or sounds,
change either (or both) of these variables from true to false. If you
set $usersMayAddRooms to false, then users will not be able to create new
public OR private rooms (because the 'rooms' panel will be hidden. */

$usersMayChangeDisplay = true;
$usersMayChangeSounds = true;
$usersMayAddRooms = true;

/** Font color and style of the "... has entered..." text. */

$welcomeColor = "EEEEEE";

//time format was disabled in Chat 3.8 (must be changed in the .fla directly)
//$welcomeTimeFormat = "h:i:s a";

/** Default color of the smilies, :) :( ;) :o, etc. */

$smilieColor = "FFFF00";

/** Background Color. */

$textBackgroundColor = "666666";	// message & userlist areas
$inputTextColor = "FFFFFF";			// input text area
$backgroundColor = "d5d5d5";		// entire room background color

/** Font color and size of the main chat window. */

$messageFontSize = 14;			// values: 8,10,12,14,16,18
$messageFontColor = "FFFFFF";	// values: any Hex color value

/** Font color and style of the user list window. */

$userlistFontSize = 14;			// values: 8,10,12,14,16,18
$userlistFontColor = "FFFFFF";

/** Colors of main chat window buttons. */

$buttonColor = "666666";
$buttonTextColor = "FFFFFF";

/** The font color of the Flash window text (e.g. "Type Your Message:",
"Who's Here", "The Chat", "Privat chat with:") */

$titleFontColor = "666666";

/** The font color of the Welcome in "Welcome <name>". */

$welcomeTitleColor = "FFFFFF";

/** The font color of the name in "Welcome <name>". */

$welcomeTitleNameColor = "666666";

/** The color for the private chat invitation messages, E.g. "Dear <name>,
user <user> has invited you to a private chat..." */

$privateChatInviteColor = "666666";

/** If users are to be automatically logged in - i.e., the login form
is NOT to be displayed, then set this variable to false. If this
variable is set to false, then you should pass a PHP variable to this
script called $name, which will be the user name in the chat room. */

// DEVELOPER NOTE: this feature was replaced in v3.2 by auto-login via URL
$displayLoginForm = true;

/** This is the popup window when a user clicks on a user name in the 'users'
window. To disable the profile popups, set $profilePopup variable to false. */

$profilePopup = true;
$popupPath = "profile.php";
$popupHeight = 500;
$popupWidth = 400;
$popupLeftOffset = 10;
$popupTopOffset = 10;
$popupOptions = "resizable,scrollbars";


/*******************************************************/
/********** DO NOT MODIFY THE CONTENTS BELOW ***********/
/*******************************************************/

define( "INCLUDES", 1 );


/** General database access class. If using a database other than MySQL, simply
modify the functions below accordingly. */

class DBConnection
{
	var $connection;
	var $database;
	var $dbuser;
	var $dbpass;
	var $host;
	var $queryString;

	function DBConnection()	// connect to the appropriate mysql database
	{
		global $database, $dbuser, $dbpass, $host;

		$this->database = $database;
		$this->dbuser = $dbuser;
		$this->dbpass = $dbpass;
		$this->host = $host;

		$this->connection = mysql_connect ( $this->host, $this->dbuser, $this->dbpass )
			or die ( "There was a MySQL configuration problem - your host name, username, or password is incorrect!" );

		mysql_select_db ( $this->database )
			or die ( "Unable to make connection to MySQL database: $this->database. The system connected to MySQL, but did not find the specified database source." );
	}

	/** Iterator. */
	function next( $result )
	{
		return mysql_fetch_row( $result );
	}

	/** Return the number of rows in a result set. */
	function rowsInResult( $result )
	{
		if ( !$result )
			return 0;

		return mysql_num_rows( $result );
	}

	/** Return only the first item of the first row of a query - useful with "SELECT ID" queries. */
	function getValue( $query )
	{
		$result = mysql_query( $query );

		if ( !$result || mysql_num_rows( $result ) == 0 )
			return "";

		return mysql_result( $result, 0, 0 );
	}

	/** Execute a plain query string, return the result set. */
	function query( $query )
	{
		$this->queryString = $query;
		return mysql_query( $query );
	}

	/** Close the database connection. */
	function close()
	{
		mysql_close();
	}

	/** Returns true if the executed query retrieves a record, or false if no record is returned by executing the query */
	function exists ( $table, $whereClause = "" )
	{
		$query = "SELECT ID FROM $table $whereClause LIMIT 1";

		$result = mysql_query ( $query );

		if ( !$result )
			return false;	// if the query was invalid, return false

		return mysql_num_rows ( $result ) != 0;
	}
}

?>