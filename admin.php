<?
require('data.php');
require('functions.php');
$mode=form_get("mode");
sql_connect();
ad_check($mode);
?>
