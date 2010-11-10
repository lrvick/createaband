<?

/**

Fill in the appropriate values into the array below. Each line should end with a comma EXCEPT for the last line, which does not, since it is the end of the array.

ttl => Main chat area titles & labels
opt => Drop-down or option lists
msg => Messages displayed in the text areas
btn => Push-button labels
rbn => Radio-button labels
chk => Checkbox labels

NOTE: <name> and <room> should not be changed. These are variables that will merge with real data during the course of the chat.

*/


$roomListMap = Array ( );

// use all lower case words for the $badWords array

$badWords = Array ( "fuck", "cunt", "shit", "cock", "bitch" );

$language = Array(

"ttl1" => "Who's Here",
"ttl2" => "The Chat",
"ttl3" => "Welcome",
"ttl4" => "Message:",
"ttl5" => "Message Size",
"ttl6" => "User List Size",
"ttl7" => "Who's Where",
"ttl8" => "All Users",
"ttl9" => "Create a new room! Room names must contain only alpha-numeric characters  (A-Z,a-z,0-9). Enter room name here:",
"ttl10" => "If creating a private room, select the users to allow access to the room from the All Users list. They will be sent an invitation to join the private chat when the room is created.",
"ttl11" => "Individual Sound Control",
"ttl12" => "Volume",
"ttl13" => "Balance",
"ttl17" => "Skins",

"opt4" => "N/A",
"opt6" => "Send a private chat invitation to...",	// to disable this option, set to ""
"opt7" => "Send a private message to...",			// to disable this option, set to ""
"opt8" => "Boot user from single room...",
"opt9" => "Boot user from all rooms...",
"opt10" => "Ban user IP from all chat activity...",
"opt11" => "Private Room",
"opt12" => "- Select User -",
"opt13" => "- Select Action -",
"opt15" => "- Select Window -",
"opt16" => "Main Chat Window",
"opt20" => "Display Options",
"opt21" => "Sound Control",
"opt22" => "Public and Private Rooms",
"opt23" => "Save this Chat",
"opt24" => "Get Help",
"opt25" => "Support Forum",
"opt26" => "- Options -",
"opt27" => "Logout",

"btn1" => "Pause",
"btn3" => "Submit",
"btn4" => "Reset Colors",
"btn5" => "Clear Messages",
"btn6" => "Create New Room",
"btn7" => "Sample",
"btn8" => "Test",
"btn9" => "OK",

"rbn1" => "Metallic",
"rbn2" => "Ivory",
"rbn3" => "Aqua",
"rbn4" => "Olive",
"rbn5" => "Navy",
"rbn6" => "Pink",
"rbn7" => "Oak",
"rbn8" => "Black",
"rbn9" => "Body Text",
"rbn10" => "Main Background",
"rbn11" => "Button Background",
"rbn12" => "Button Text",
"rbn13" => "Input Text",
"rbn14" => "Input Background",
"rbn15" => "Chat Text",
"rbn16" => "Chat Background",
"rbn17" => "System Messages",
"rbn18" => "Smilies",
"rbn19" => "Enter Room Notify",
"rbn20" => "User Name",
"rbn21" => "User List",
"rbn22" => "User List Bgnd",
"rbn23" => "Make this room public",
"rbn24" => "Make this room private",

"chk1" => "Hide Profile",
"chk2" => "Enter Room Sound",
"chk3" => "Leave Room Sound",
"chk4" => "Receive Message Sound",
"chk5" => "Send Message Sound",
"chk6" => "Mute All Sounds",

"msg1" => "Welcome to the support forum, <name>!",
"msg2" => "To send a support message, choose the recipient from the drop-menu.",
"msg3" => "Spies cannot activate special commands!",
"msg4" => "A representative will be with you soon. If there is no response, please ring the bell to get our attention.",
"msg5" => "No Answer? Ring the bell...",
"msg6" => "Welcome to the chat, <name>!",
"msg7" => "You may not enter <room> because it is at its user capacity. Please wait until one or more users leaves the room.",
"msg8" => "(Type your message here and click Submit)",
"msg9" => "Spies cannot submit to the chat!",
"msg10" => "Please select a recipient!",
"msg11" => "You cannot send a message to yourself!",
"msg12" => "*** <name> is ringing the support bell! ***",
"msg13" => "Private chat invite",
"msg14" => "Your private chat invitation has been sent. To enter the private room <room>, select it from the room list.",
"msg15" => "New Public Room",
"msg16" => "A new public room named <room> has been created, and all current users have been notified of this change. To enter the room, select it from the room list.",
"msg17" => "<name> has invited you to a private chat in the <room> room. To enter the private room, select it from your room list.",
"msg18" => "<name> has created a new public chat room called <room>. This room has been added to your room list.",
"msg19" => "Boot",
"msg20" => "Ban",
"msg21" => "<name> has booted you from all rooms in this chat session. You are now logged-out.",
"msg22" => "<name> has been booted from all rooms in this chat session.",
"msg23" => "<name> has booted you from <room> for this chat session.",
"msg24" => "<name> has banned you from the chat. Your IP address (<ip>) has been logged to prevent future chat re-entry.",
"msg25" => "<name> has been banned from the chat. The IP of <name> (<ip>) has been logged to prevent future chat re-entry.",
"msg26" => "Request for Support",
"msg27" => "<name> has requested support",
"msg28" => "You may not enter the chat at this time because every available room is at its maximum capacity.",
"msg29" => "Room names may contain only alpha-numeric characters.",
"msg30" => "You may not enter the chat at this time because your IP address, <ip>, has been banned from the chat.",
"msg31" => "(moderator)",
"msg34" => "A room with this name already exists.",
"msg35" => "Please enter a name for this new room.",
"msg36" => "<room> has been successfully added.",
"msg37" => "(in private)",
"msg38" => "(moderated)",
"msg40" => "Private from <name>",
"msg41" => "Message to <name>",
"msg42" => "Private to <name>",
"msg43" => "We're sorry, but the chat is not available at this time. Please check the chat schedule and login during the normal hours of operation.",
"msg50" => "has entered",
"msg51" => "<name> has been booted from <room> for this chat session.",
"msg52" => "Ringing...",
"msg53" => "You are now logged out."

);

?>