<?
require('../data.php');
require('functions.php');
sql_connect();
global $main_url,$base_path;
$mode=form_get("mode");
$act=form_get("act");
if(!empty($mode) or !empty($act))	{
	header("Location:../index.php?mode=$mode&act=$act");
	exit;
}
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
include_once( "config.php" );
include_once 'header.php';
if ( $techSupport )
	readfile( "supportForumHelp.php" );

else
	readfile( "generalChatHelp.php" );

// more help file options can be added here, if needed
include_once 'footer.php';
?>