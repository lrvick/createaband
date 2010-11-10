<?
$conn_id;
$sql_res;
$sql_res2;
$sql_query;

$HTTP_REFERER=$_SERVER["HTTP_REFERER"];
$REQUEST_METHOD=$_SERVER["REQUEST_METHOD"];

function sql_connect(){
global $conn_id,$sql_host,$sql_user,$sql_pass,$sql_db;
$conn_id=mysql_connect($sql_host,$sql_user,$sql_pass);
mysql_select_db($sql_db);
}

function sql_execute($sql_query,$wtr){
global $conn_id;
$sql_res=mysql_query($sql_query,$conn_id);
if($wtr=='get'){
if(mysql_num_rows($sql_res)){
return mysql_fetch_object($sql_res);
}
else {
return '';
}
}
elseif($wtr=='num'){
return mysql_num_rows($sql_res);
}
elseif($wtr=='res'){
return $sql_res;
}
}

function sql_rows($id,$table){
global $conn_id;
$query="select $id from $table";
$result=mysql_query($query,$conn_id);
$number=mysql_num_rows($result);
return $number;
}

function sql_close(){
global $conn_id;
mysql_close($conn_id);
}
function h_banners()	{
global $cookie_url,$main_url;
	$sql="select * from banners where b_blk='N' and b_typ='H' and b_exp='N'";
	$res=mysql_query($sql);
	$dis=array();
	$dis_id=array();
	$num=mysql_num_rows($res);
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$tmp=explode(".",$row->b_img);
			$tmp_count=count($tmp);
			$ext=strtolower($tmp[$tmp_count-1]);
			if($ext=="swf")	{
				$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='420' height='60'>
  						<param name='movie' value='".$main_url."/".$row->b_img."'>
						<param name='quality' value='high'>
						<embed src='".$main_url."/".$row->b_img."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='420' height='60'></embed></object>";
			}	else	$img_s="<img src='".$main_url."/".$row->b_img."' border='0' width='420' height='60' alt='".stripslashes($row->b_desc)."' ismap>";
			$dis[]="<A href='".$main_url."/banners/index.php?url=".$row->b_url."&seid=".$row->b_id."&sess=set' target='_blank'>".$img_s."</a>";
			$dis_id[]=$row->b_id;
		}
		$tak=rand(0,$num);
		$sql_query="select * from banners where b_id='$dis_id[$tak]'";
		$num=sql_execute($sql_query,'num');
		if($num!=0)	{
			$bann=sql_execute($sql_query,'get');
				$d_f=date("d",$bann->b_f_day);
				$m_f=date("m",$bann->b_f_day);
				$y_f=date("Y",$bann->b_f_day);
				$d_t=date("d",$bann->b_t_day);
				$m_t=date("m",$bann->b_t_day);
				$y_t=date("Y",$bann->b_t_day);
//				$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
//				$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
				$f_day=$y_f."/".$m_f."/".$d_f;
				$t_day=$y_t."/".$m_t."/".$d_t;
				$today=date("Y")."/".date("m")."/".date("d");
				if(($bann->b_dur=="D") and (strcmp($today,$t_day)>=0))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
					delete_banner($dis_id[$tak]);
				}
			echo $dis[$tak];
			$sql_query="select * from banners where b_id='$dis_id[$tak]'";
			$ba=sql_execute($sql_query,'get');
			$b_see=$ba->b_see+1;
			mysql_query("update banners set b_see=$b_see where b_id='$dis_id[$tak]'");
		}
	}
}
function f_banners()	{
global $cookie_url,$main_url;
	$sql="select * from banners where b_blk='N' and b_typ='F' and b_exp='N'";
	$res=mysql_query($sql);
	$dis=array();
	$dis_id=array();
	$num=mysql_num_rows($res);
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$tmp=explode(".",$row->b_img);
			$tmp_count=count($tmp);
			$ext=strtolower($tmp[$tmp_count-1]);
			if($ext=="swf")	{
				$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='720' height='60'>
  						<param name='movie' value='".$main_url."/".$row->b_img."'>
						<param name='quality' value='high'>
						<param name='wmode' value='opaque'>
						<param name='loop' value='false'>
						<embed src='".$main_url."/".$row->b_img."' loop='false' wmode='opaque' quality='high' swLiveConnect='false' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='720' height='60'></embed></object>";
			}	else	$img_s="<img src='".$main_url."/".$row->b_img."' border='0' width='720' height='60' alt='".stripslashes($row->b_desc)."' ismap>";
			$dis[]="<A href='".$main_url."/banners/index.php?url=".$row->b_url."&seid=".$row->b_id."&sess=set' target='_blank'>".$img_s."</a>";
			$dis_id[]=$row->b_id;
		}
		$tak=rand(0,$num);
		$sql_query="select * from banners where b_id='$dis_id[$tak]'";
		$num=sql_execute($sql_query,'num');
		if($num!=0)	{
			$bann=sql_execute($sql_query,'get');
				$d_f=date("d",$bann->b_f_day);
				$m_f=date("m",$bann->b_f_day);
				$y_f=date("Y",$bann->b_f_day);
				$d_t=date("d",$bann->b_t_day);
				$m_t=date("m",$bann->b_t_day);
				$y_t=date("Y",$bann->b_t_day);
//				$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
//				$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
//				$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
				$f_day=$y_f."/".$m_f."/".$d_f;
				$t_day=$y_t."/".$m_t."/".$d_t;
				$today=date("Y")."/".date("m")."/".date("d");
				if(($bann->b_dur=="D") and (strcmp($today,$t_day)>=0))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
					delete_banner($dis_id[$tak]);
				}
				elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
					delete_banner($dis_id[$tak]);
				}
			echo $dis[$tak];
			$sql_query="select * from banners where b_id='$dis_id[$tak]'";
			$ba=sql_execute($sql_query,'get');
			$b_see=$ba->b_see+1;
			mysql_query("update banners set b_see=$b_see where b_id='$dis_id[$tak]'");
		}
	}
}

function mailing($to,$name,$from,$subj,$body) {
global $SERVER_NAME;
$subj=nl2br($subj);
$body=nl2br($body);
$recipient = $to;
$headers = "From: " . "$name" . "<" . "$from" . ">\n";
$headers .= "X-Sender: <" . "$to" . ">\n";
$headers .= "Return-Path: <" . "$to" . ">\n";
$headers .= "Error-To: <" . "$to" . ">\n";
$headers .= "Content-Type: text/html\n";
mail("$recipient","$subj","$body","$headers");
}

function form_get($value){
global $HTTP_POST_VARS,$HTTP_GET_VARS,$_SERVER;
$REQUEST_METHOD=$_SERVER["REQUEST_METHOD"];
if($REQUEST_METHOD=='POST'){
$get_value=$HTTP_POST_VARS["$value"];
}
elseif($REQUEST_METHOD=='GET'){
$get_value=$HTTP_GET_VARS["$value"];
}
return $get_value;
}

function cookie_get($name){
global $HTTP_COOKIE_VARS;
return $HTTP_COOKIE_VARS[$name];
}

//require file, depending on mode
function check($mode){
global $cookie_url,$main_url;
  if(isset($mode)){
    $document=$mode.".php";
  }
  else{
  	$document="main.php";
  }
  require("$document");
}

//require admin file, depending on mode
function ad_check($mode){
  if(isset($mode)){
    $document=$mode.".php";
  }
  else{
  	$document="main.php";
  }
  require("admin/$document");
}

//printing java code for listing categories
function listing_cats_java($mod){
$sql_query="select * from categories";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
if($mod==1){
echo ";
 listCategory.setDefaultOption('$cat->cat_id','$cat->cat_id');
 listCategory.addOptions('$cat->cat_id','Select Subcategory','$cat->cat_id'";
}
elseif($mod==2){
$nex=$cat->cat_id+1;
echo "
listmessage_categoryId.setDefaultOption('$cat->cat_id','$nex');
listmessage_categoryId.addOptions('$cat->cat_id'";
}
   $sql_query="select * from sub_categories where cat_id='$cat->cat_id'";
   $res2=sql_execute($sql_query,'res');
   while($sub=mysql_fetch_object($res2)){
      echo ",'$sub->name','$sub->sub_cat_id'";
   }//while
   echo ");";
}//while

}//function

// Returnds the curent page number on a multipage display
function getpage(){
  	if(!isset($_GET['page'])) $page=1;
  	else $page=$_GET['page'];
    return $page;
}
function getpages(){
  	if(!isset($_GET['page'])) $page=1;
  	else $page=$_GET['page'];
    return $page;
}

//Displays the page numbers
function show_page_nos($sql,$url,$lines,$page){
    $tmp	=explode("LIMIT",$sql);
    if(count($tmp)<1) $tmp	=explode("limit",$sql);
  	$pgsql	=$tmp[0];
    include 'show_pagenos.php';
}
//Formats The Date
function format_date($date,$time=0){
    $tmp	=explode(" ",$date);
	$date2	=explode("-",$tmp[0]);
	$date	=$date2[1]."-".$date2[2]."-".$date2[0];
	if($time) return $date." ".$tmp[1];
	else return $date;
}

//just printing listing cats list
function listing_cats($sel){
$sql_query="select * from categories";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
    if($cat->cat_id=="$sel"){
    echo "<option selected value='$cat->cat_id'>$cat->name";
    }
    else{
    echo "<option value='$cat->cat_id'>$cat->name";
    }

}//while
}//function

//admin header
function show_ad_header($adsess){
$mode=form_get("mode");
$act=form_get("act");
?>
<html>
<head>
<title>Site Administration</title>
<link href="styles/style.css" type="text/css" rel="stylesheet">
<? if(($mode='listings_manager')&&($act=='edit')) {?>
<script language="Javascript" src="DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listCategory = new DynamicOptionList("Category","RootCategory");

<?
listing_cats_java(1);
?>

	listCategory.addOptions('','Select Subcategory','');
 listCategory.setDefaultOption('','');

function init() {
	var theform = document.forms["searchListing"];
	listCategory.init(theform);
	}
</SCRIPT>

<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listCategory.init(document.forms['searchListing']);">
<? } ?>
</head>
<body topmargin=2 leftmargin=2>
<table width="740">
<tr><td width=100%>
<? require('templates/ad_header.php'); ?>
</td>
<tr><td width=100%>
<?
}//function


//showing header
function show_header(){
?>
<html>
<head>
<title>Demo Site</title>
<link href="styles/style.css" type="text/css" rel="stylesheet">
<?
$mode=form_get("mode");
$act=form_get("act");
if($mode=="user"){
   ?>
      <script language="JavaScript">
      <!--

         function formsubmit(type){
            document.profile.redir.value=type;
            document.profile.submit();
         }

      -->
      </script>
   <?
}
elseif(($mode=='listing')&&($act=='create')){
?>
<script language="Javascript" src="DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listmessage_categoryId = new DynamicOptionList("message_categoryId","message_rootCategoryId");

<? listing_cats_java(2); ?>
																																					listmessage_categoryId.addOptions('8000','computer','8001','creative','8002','erotic','8003','event','8004','household','8005','garden / labor / haul','8006','lessons','8007','looking for','8008','skilled trade','8009','sm biz ads','8010','therapeutic','8011');


function init() {
	var theform = document.forms["manageListing"];
	listmessage_categoryId.init(theform);
	}
</SCRIPT>
<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listmessage_categoryId.init(document.forms['manageListing']);">
<?
}
elseif((($mode=='listing')&&($act!='create')&&($act!='show')&&($act!='feedback'))||(($mode=='search')&&($act=='listing'))){
?>
<script language="Javascript" src="DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listCategory = new DynamicOptionList("Category","RootCategory");

<?
 listing_cats_java(1);
?>


	listCategory.addOptions('','Select Subcategory','');
 listCategory.setDefaultOption('','');

function init() {
	var theform = document.forms["searchListing"];
	listCategory.init(theform);
	}
</SCRIPT>

<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listCategory.init(document.forms['searchListing']);">
<?
}//elseif
?>
</head>
<body topmargin=2 leftmargin=2>
<table width="740">
<tr><td width=100%>
<? require('templates/header.php'); ?>
</td>
<tr><td width=100%>
<?
}


//showing footer
function show_footer(){
?>
</td>
<tr><td width=100%>
<? require("templates/footer.php"); ?>
</td></body></html>
<?
sql_close();
}


//redirect
function show_screen($loc){
Header("Location: $loc");
exit;
}

//error reports
function error_screen($errid){
$sql_query="select * from errors where err_id='$errid'";
$err=sql_execute($sql_query,'get');
$error_line=$err->error;
$detailes_line=$err->detailes;
show_header();
require('error.php');
show_footer();
exit();
}

//complete pages
function complete_screen($comid){
$sql_query="select * from complete where cmp_id='$comid'";
$cmp=sql_execute($sql_query,'get');
$header_line=$cmp->complete;
$detailes_line=$cmp->detailes;
show_header();
require('complete.php');
show_footer();
exit();
}

//checkin user login info
function login_test($mem_id,$mem_pass){
$sql_query="select password,ban from members where mem_id='$mem_id'";
$num=sql_execute($sql_query,'num');
$mem=sql_execute($sql_query,'get');
//if password incorrect
if(($num==0)||($mem_pass!=$mem->password)){
error_screen(0);
}
//if user banned
elseif($mem->ban=='y'){
error_screen(12);
}
//updating db (setting user in online mode)
$now=time();
$was=$now-60*20;
$sql_query="update members set current='$now' where mem_id='$mem_id'";
sql_execute($sql_query,'');
$sql_query="update members set online='off' where current < $was";
sql_execute($sql_query,'');
}

//checkin admin session key
function admin_test($session){
$time=time();
$interval=$time-3600*24;
$sql_query="delete from admin where started < $interval";
sql_execute($sql_query,'');
$sql_query="select * from admin where sess_id='$session'";
$num=sql_execute($sql_query,'num');
if($num==0){
error_screen(24);
}
}

//sending messages, depending on message id
function messages($to,$mid,$data){
global $system_mail,$site_name;
if($mid==7){
$subject=$data[0];
$body=$data[1];
$name=$data[2];
$from_mail=$data[3];
}//if
else{
$sql_query="select * from messages where mes_id='$mid'";
$mes=sql_execute($sql_query,'get');
$subject=$mes->subject;
$body=$mes->body;

//replacing templates
$body=ereg_replace("\|email\|","$data[0]",$body);
$body=ereg_replace("\|password\|","$data[1]",$body);
$body=ereg_replace("\|link\|","$data",$body);
$body=ereg_replace("\|subject\|","$data[0]",$body);
$body=ereg_replace("\|message\|","$data[1]",$body);
$body=ereg_replace("\|user\|","$data[0]",$body);

$subject=ereg_replace("\|email\|","$data[0]",$subject);
$subject=ereg_replace("\|password\|","$data[1]",$subject);
$subject=ereg_replace("\|link\|","$data",$subject);
$subject=ereg_replace("\|subject\|","$data[0]",$subject);
$subject=ereg_replace("\|message\|","$data[1]",$subject);
$subject=ereg_replace("\|user\|","$data[0]",$subject);

$name=$site_name;
$from_mail=$system_mail;
}//else

$subject=stripslashes($subject);
$body=stripslashes($body);

$sql_query="select notifications from members where email='$to'";
$num=sql_execute($sql_query,'num');
if($num>0){
  $mem=sql_execute($sql_query,'get');
  if($mem->notifications=='1'){
    $stat=1;
  }
  else {
    $stat=0;
  }
}
else {
  $stat=1;
}

if(($stat==1)||($mid<4)){
mailing($to,$name,$from_mail,$subject,$body);
}
}

//deleting empty values of array
function if_empty($data){
$flag=0;
if($data==''){
  return '';
}//if
else{
$result=array();
foreach($data as $val){
  if($val!=''){
    $flag=1;
    array_push($result,$val);
  }//if
}//foreach
if($flag==0){
  return '';
}//elseif
else {
  return $result;
}//else
}//else
}//function

//showing country drop-down list
function country_drop(){
?>
          <OPTION VALUE="United States">United States</OPTION>
		  <OPTION VALUE="Afghanistan">Afghanistan</OPTION>
		  <OPTION VALUE="Albania">Albania</OPTION>
		  <OPTION VALUE="Algeria">Algeria</OPTION>
          <OPTION VALUE="American Samoa">American Samoa</OPTION>
          <OPTION VALUE="Andorra">Andorra</OPTION>
          <OPTION VALUE="Angola">Angola</OPTION>
          <OPTION VALUE="Anguilla">Anguilla</OPTION>
          <OPTION VALUE="Antartica">Antartica</OPTION>
          <OPTION VALUE="Antigua and Barbuda">Antigua and Barbuda</OPTION>
          <OPTION VALUE="Argentina">Argentina</OPTION>
          <OPTION VALUE="Armenia">Armenia</OPTION>
          <OPTION VALUE="Aruba">Aruba</OPTION>
          <OPTION VALUE="Ascension Island">Ascension Island</OPTION>
          <OPTION VALUE="Australia">Australia</OPTION>
          <OPTION VALUE="Austria">Austria</OPTION>
          <OPTION VALUE="Azerbaijan">Azerbaijan</OPTION>
          <OPTION VALUE="Bahamas">Bahamas</OPTION>
          <OPTION VALUE="Bahrain">Bahrain</OPTION>
          <OPTION VALUE="Bangladesh">Bangladesh</OPTION>
          <OPTION VALUE="Barbados">Barbados</OPTION>
          <OPTION VALUE="Belarus">Belarus</OPTION>
          <OPTION VALUE="Belgium">Belgium</OPTION>
          <OPTION VALUE="Belize">Belize</OPTION>
          <OPTION VALUE="Benin">Benin</OPTION>
          <OPTION VALUE="Bermuda">Bermuda</OPTION>
          <OPTION VALUE="Bhutan">Bhutan</OPTION>
          <OPTION VALUE="Bolivia">Bolivia</OPTION>
          <OPTION VALUE="Botswana">Botswana</OPTION>
          <OPTION VALUE="Bouvet Island">Bouvet Island</OPTION>
          <OPTION VALUE="Brazil">Brazil</OPTION>
          <OPTION VALUE="Brunei Darussalam">Brunei Darussalam</OPTION>
          <OPTION VALUE="Bulgaria">Bulgaria</OPTION>
          <OPTION VALUE="Burkina Faso">Burkina Faso</OPTION>
          <OPTION VALUE="Burundi">Burundi</OPTION>
          <OPTION VALUE="Cambodia">Cambodia</OPTION>
          <OPTION VALUE="Cameroon">Cameroon</OPTION>
          <OPTION VALUE="Canada">Canada</OPTION>
          <OPTION VALUE="Cape Verde Islands">Cape Verde Islands</OPTION>
          <OPTION VALUE="Cayman Islands">Cayman Islands</OPTION>
          <OPTION VALUE="Chad">Chad</OPTION>
          <OPTION VALUE="Chile">Chile</OPTION>
          <OPTION VALUE="China">China</OPTION>
          <OPTION VALUE="Christmas Island">Christmas Island</OPTION>
          <OPTION VALUE="Colombia">Colombia</OPTION>
          <OPTION VALUE="Comoros">Comoros</OPTION>
          <OPTION VALUE="Congo, Republic of">Congo, Republic of</OPTION>
          <OPTION VALUE="Cook Islands">Cook Islands</OPTION>
          <OPTION VALUE="Costa Rica">Costa Rica</OPTION>
          <OPTION VALUE="Cote d Ivoire">Cote d'Ivoire</OPTION>
          <OPTION VALUE="Croatia/Hrvatska">Croatia/Hrvatska</OPTION>
          <OPTION VALUE="Cyprus">Cyprus</OPTION>
          <OPTION VALUE="Czech Republic">Czech Republic</OPTION>
          <OPTION VALUE="Denmark">Denmark</OPTION>
          <OPTION VALUE="Djibouti">Djibouti</OPTION>
          <OPTION VALUE="Dominica">Dominica</OPTION>
          <OPTION VALUE="Dominican Republic">Dominican Republic</OPTION>
          <OPTION VALUE="East Timor">East Timor</OPTION>
          <OPTION VALUE="Ecuador">Ecuador</OPTION>
          <OPTION VALUE="Egypt">Egypt</OPTION>
          <OPTION VALUE="El Salvador">El Salvador</OPTION>
          <OPTION VALUE="Equatorial Guinea">Equatorial Guinea</OPTION>
          <OPTION VALUE="Eritrea">Eritrea</OPTION>
          <OPTION VALUE="Estonia">Estonia</OPTION>
          <OPTION VALUE="Ethiopia">Ethiopia</OPTION>
          <OPTION VALUE="Falkland Islands">Falkland Islands</OPTION>
          <OPTION VALUE="Faroe Islands">Faroe Islands</OPTION>
          <OPTION VALUE="Fiji">Fiji</OPTION>
          <OPTION VALUE="Finland">Finland</OPTION>
          <OPTION VALUE="France">France</OPTION>
          <OPTION VALUE="French Guiana">French Guiana</OPTION>
          <OPTION VALUE="French Polynesia">French Polynesia</OPTION>
          <OPTION VALUE="Gabon">Gabon</OPTION>
          <OPTION VALUE="Gambia">Gambia</OPTION>
          <OPTION VALUE="Georgia">Georgia</OPTION>
          <OPTION VALUE="Germany">Germany</OPTION>
          <OPTION VALUE="Ghana">Ghana</OPTION>
          <OPTION VALUE="Gibraltar">Gibraltar</OPTION>
          <OPTION VALUE="Greece">Greece</OPTION>
          <OPTION VALUE="Greenland">Greenland</OPTION>
          <OPTION VALUE="Grenada">Grenada</OPTION>
          <OPTION VALUE="Guadeloupe">Guadeloupe</OPTION>
          <OPTION VALUE="Guam">Guam</OPTION>
          <OPTION VALUE="Guatemala">Guatemala</OPTION>
          <OPTION VALUE="Guernsey">Guernsey</OPTION>
          <OPTION VALUE="Guinea">Guinea</OPTION>
          <OPTION VALUE="Guinea-Bissau">Guinea-Bissau</OPTION>
          <OPTION VALUE="Guyana">Guyana</OPTION>
          <OPTION VALUE="Haiti">Haiti</OPTION>
          <OPTION VALUE="Honduras">Honduras</OPTION>
          <OPTION VALUE="Hong Kong">Hong Kong</OPTION>
          <OPTION VALUE="Hungary">Hungary</OPTION>
          <OPTION VALUE="Iceland">Iceland</OPTION>
          <OPTION VALUE="India">India</OPTION>
          <OPTION VALUE="Indonesia">Indonesia</OPTION>
          <OPTION VALUE="Iran">Iran</OPTION>
          <OPTION VALUE="Ireland">Ireland</OPTION>
          <OPTION VALUE="Isle of Man">Isle of Man</OPTION>
          <OPTION VALUE="Israel">Israel</OPTION>
          <OPTION VALUE="Italy">Italy</OPTION>
          <OPTION VALUE="Jamaica">Jamaica</OPTION>
          <OPTION VALUE="Japan">Japan</OPTION>
          <OPTION VALUE="Jersey">Jersey</OPTION>
          <OPTION VALUE="Jordan">Jordan</OPTION>
          <OPTION VALUE="Kazakhstan">Kazakhstan</OPTION>
          <OPTION VALUE="Kenya">Kenya</OPTION>
          <OPTION VALUE="Kiribati">Kiribati</OPTION>
          <OPTION VALUE="Korea, Republic of">Korea, Republic of</OPTION>
          <OPTION VALUE="Kuwait">Kuwait</OPTION>
          <OPTION VALUE="Kyrgyzstan">Kyrgyzstan</OPTION>
          <OPTION VALUE="Laos">Laos</OPTION>
          <OPTION VALUE="Latvia">Latvia</OPTION>
          <OPTION VALUE="Lebanon">Lebanon</OPTION>
          <OPTION VALUE="Lesotho">Lesotho</OPTION>
          <OPTION VALUE="Liberia">Liberia</OPTION>
          <OPTION VALUE="Libya">Libya</OPTION>
          <OPTION VALUE="Liechtenstein">Liechtenstein</OPTION>
          <OPTION VALUE="Lithuania">Lithuania</OPTION>
          <OPTION VALUE="Luxembourg">Luxembourg</OPTION>
          <OPTION VALUE="Macau">Macau</OPTION>
          <OPTION VALUE="Macedonia">Macedonia</OPTION>
          <OPTION VALUE="Madagascar">Madagascar</OPTION>
          <OPTION VALUE="Malawi">Malawi</OPTION>
          <OPTION VALUE="Malaysia">Malaysia</OPTION>
          <OPTION VALUE="Maldives">Maldives</OPTION>