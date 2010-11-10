<?
include_once( "data.php" );
include_once( "chat/functions.php" );
include_once( "chat/config.php" );
$name=cookie_get("mem_em");
// delete the user $username from all rooms
mysql_query( "delete from chat_users where name='$name'" );
mysql_query( "delete from chat_messages where name='$name'" );
header("Location:../index.php?mode=login&act=logout");
exit;
?>