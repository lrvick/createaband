<?
require("templates/lang_header.php");
$server = $_SERVER["SERVER_NAME"];
error_reporting(0);

/*
$conn_id = "";
$sql_res = "";
$sql_res2 = "";
$sql_query = "";
*/

if(isset($_SERVER["HTTP_REFERER"]))
	$HTTP_REFERER=$_SERVER["HTTP_REFERER"];
	
$REQUEST_METHOD=$_SERVER["REQUEST_METHOD"];

function sql_connect()	{
	
	global $sql_db;
	
	global $conn_id,$sql_host,$sql_user,$sql_pass;
	$conn_id=mysql_connect($sql_host,$sql_user,$sql_pass);
	mysql_select_db($sql_db);
}

function sql_execute($sql_query,$wtr)	{
	
	global $conn_id;
	
	$sql_res=mysql_query($sql_query,$conn_id);
	if($wtr=='get')	{
		if(mysql_num_rows($sql_res))	{
			return mysql_fetch_object($sql_res);
		}
		else {
			return '';
		}
	}
	elseif($wtr=='num')	{
		return mysql_num_rows($sql_res);
	}
	elseif($wtr=='res')	{
		return $sql_res;
	}
}

function sql_rows($id,$table)	{
	//global $conn_id;
	$query="select $id from $table";
	$result=mysql_query($query,$conn_id);
	$number=mysql_num_rows($result);
	return $number;
}

function sql_close()
{
	
	global $conn_id;
	
	mysql_close($conn_id);
}

function h_banners()	{
	global $cookie_url,$main_url,$ban_hwidth,$ban_hheight;
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
				$img_s="<script language=\"JavaScript1.2\">
						function disps()	{
							window.open(\"$main_url/banners/index.php?url=$row->b_url&seid=$row->b_id&sess=set&lng=$lng_id\",\"MyWindow\",'toolbar,width=screen.width,height=screen.height')
						}
						</script>
						<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"$ban_hwidth\" height=\"$ban_hheight\" onClick=\"javascript:disps();\">
  						<param name=\"movie\" value=\"$main_url/$row->b_img\">
						<param name=\"quality\" value=\"high\">
						<embed src=\"$main_url/$row->b_img\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"$ban_hwidth\" height=\"$ban_hheight\"></embed></object>";
			}	else	$img_s="<a href=\"$main_url/banners/index.php?url=$row->b_url&seid=$row->b_id&sess=set&lng=$lng_id\" target=\"_blank\"><img src=\"$main_url/$row->b_img\" border=\"0\" width=\"$ban_hwidth\" height=\"$ban_hheight\" alt=\"".stripslashes($row->b_desc)."\" ismap></a>";
			$dis[]=$img_s;
			$dis_id[]=$row->b_id;
		}
		$couu_h=count($dis_id);
		$tak=rand(0,$couu_h-1);
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
			$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
			$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
			$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
			if(($bann->b_dur=="D") and ($today>$t_day))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
				delete_banner($dis_id[$tak]);
			}
			echo $dis[$tak];
			for($i=0; $i<=$ip_co; $i++)	{
					mysql_query("update banners set b_see=b_see+1 where b_id='$dis_id[$tak]'");
			}
		}
	}
}
function f_banners()	{
	global $cookie_url,$main_url,$ban_fwidth,$ban_fheight;
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
				$img_s="<script language=\"JavaScript1.2\">
						function disps1()	{
							window.open(\"$main_url/banners/index.php?url=$row->b_url&seid=$row->b_id&sess=set&lng=$lng_id\",\"MyWindow\",'toolbar,width=screen.width,height=screen.height')
						}
						</script>
						<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"$ban_fwidth\" height=\"$ban_fheight\" onClick=\"javascript:disps1();\">
  						<param name=\"movie\" value=\"$main_url/$row->b_img\">
						<param name=\"quality\" value=\"high\">
						<embed src=\"$main_url/$row->b_img\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"$ban_fwidth\" height=\"$ban_fheight\"></embed></object>";
			}	else	$img_s="<a href=\"$main_url/banners/index.php?url=$row->b_url&seid=$row->b_id&sess=set&lng=$lng_id\" target=\"_blank\"><img src=\"$main_url/$row->b_img\" border=\"0\" width=\"$ban_fwidth\" height=\"$ban_fheight\" alt=\"".stripslashes($row->b_desc)."\" ismap></a>";
			$dis[]=$img_s;
			$dis_id[]=$row->b_id;
		}
		$couu_f=count($dis_id);
		$tak=rand(0,$couu_f-1);
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
			$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
			$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
			$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
			if(($bann->b_dur=="D") and ($today>$t_day))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
				delete_banner($dis_id[$tak]);
			}
			echo $dis[$tak];
			for($i=0; $i<=$ip_co; $i++)	{
				mysql_query("update banners set b_see=b_see+1 where b_id='$dis_id[$tak]'");
			}
		}
	}
}

function m_banners()	{
	global $cookie_url,$main_url,$ban_mwidth,$ban_mheight;
	$sql="select * from banners where b_blk='N' and b_typ='M' and b_exp='N'";
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
				$img_s="<script language=\"JavaScript1.2\">
						function disps1()	{
							window.open(\"$main_url/banners/index.php?url=$row->b_url&seid=$row->b_id&sess=set&lng=$lng_id\",\"MyWindow\",'toolbar,width=screen.width,height=screen.height')
						}
						</script>
						<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"$ban_mwidth\" height=\"$ban_mheight\" onClick=\"javascript:disps1();\">
  						<param name=\"movie\" value=\"$main_url/$row->b_img\">
						<param name=\"quality\" value=\"high\">
						<embed src=\"$main_url/$row->b_img\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"$ban_mwidth\" height=\"$ban_mheight\"></embed></object>";
			}	else	$img_s="<a href=\"$main_url/banners/index.php?url=$row->b_url&seid=$row->b_id&sess=set&lng=$lng_id\" target=\"_blank\"><img src=\"$main_url/$row->b_img\" border=\"0\" width=\"$ban_mwidth\" height=\"$ban_mheight\" alt=\"".stripslashes($row->b_desc)."\" ismap></a>";
			$dis[]=$img_s;
			$dis_id[]=$row->b_id;
		}
		$couu_h=count($dis_id);
		$tak=rand(0,$couu_h-1);
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
			$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
			$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
			$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
			if(($bann->b_dur=="D") and ($today>$t_day))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
				delete_banner($dis_id[$tak]);
			}
			echo $dis[$tak];
			for($i=0; $i<=$ip_co; $i++)	{
					mysql_query("update banners set b_see=b_see+1 where b_id='$dis_id[$tak]'");
			}
		}
	}
}

function o_banners($width,$height)	{
	global $cookie_url,$main_url;
	$sql="select * from banners where b_blk='N' and b_typ='O' and b_exp='N'";
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
				$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='$width' height='$height'>
  						<param name='movie' value='".$main_url."/".$row->b_img."'>
						<param name='quality' value='high'>
						<embed src='".$main_url."/".$row->b_img."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='$width' height='$height'></embed></object>";
			}	else	$img_s="<img src='".$main_url."/".$row->b_img."' border='0' width='$width' height='$height' alt='".stripslashes($row->b_desc)."' ismap>";
			$dis[]="<A href='".$main_url."/banners/index.php?url=".$row->b_url."&seid=".$row->b_id."&sess=set&lng=$lng_id' target='_blank'>".$img_s."</a>";
			$dis_id[]=$row->b_id;
		}
		$couu_h=count($dis_id);
		$tak=rand(0,$couu_h-1);
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
			$f_day=mktime(0,0,0,$m_f,$d_f,$y_f);
			$t_day=mktime(0,0,0,$m_t,$d_t,$y_t);
			$today=mktime(0,0,0,date("m"),date("d"),date("Y"));
			if(($bann->b_dur=="D") and ($today>$t_day))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="C" and ($bann->b_ncl<=$bann->b_clks))	{
				delete_banner($dis_id[$tak]);
			}
			elseif($bann->b_dur=="I" and ($bann->b_noi<=$bann->b_see))	{
				delete_banner($dis_id[$tak]);
			}
			echo $dis[$tak];
			for($i=0; $i<=$ip_co; $i++)	{
					mysql_query("update banners set b_see=b_see+1 where b_id='$dis_id[$tak]'");
			}
		}
	}
}

function mailing($to,$name,$from,$subj,$body)	{
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

function form_get($value)	
{
	global $HTTP_POST_VARS,$HTTP_GET_VARS,$_SERVER;
	
	$REQUEST_METHOD=$_SERVER["REQUEST_METHOD"];
//	echo $REQUEST_METHOD;
	if($REQUEST_METHOD=='POST')
	{
			
		if(isset($HTTP_POST_VARS["$value"]))
		{
			$get_value = $HTTP_POST_VARS["$value"];
		}
		else
		{
			$get_value = "";
		}
	
	//	$get_value = $HTTP_POST_VARS["$value"];
	}
	if($REQUEST_METHOD=='GET')	
	{
			
		if(isset($HTTP_GET_VARS["$value"]))
		{
			$get_value = $HTTP_GET_VARS["$value"];
		}
		else
		{
			$get_value = "";
		}
	
	//	$get_value=$HTTP_GET_VARS["$value"];
	}
//	echo "===========>>" . $get_value;
	return $get_value;
}

function cookie_get($name)
{	
	global $HTTP_COOKIE_VARS;
	
	if(isset($HTTP_COOKIE_VARS[$name]))	
	{
		$retCook = $HTTP_COOKIE_VARS[$name];
	}
	else
	{
		$retCook = "";
	}
	
	return $retCook;	
//		return $HTTP_COOKIE_VARS[$name];
}

//require file, depending on mode
function check($mode)
{
	global $cookie_url,$main_url;
	if(isset($mode))
	{
		$document=$mode.".php";
	}
	else
	{
		$document="main.php";
	}
	
	require("$document");
}

//require admin file, depending on mode
function ad_check($mode)	{	
	if(isset($mode) && $mode != "")	{
		$document=$mode.".php";
	}
	else{
		$document="main.php";
	}
	require("admin/$document");
}

//require calendar file, depending on mode
function cal_check($mode)	{
	if(isset($mode))	{
		$document=$mode.".php";
	}
	else{
		$document="calendar.php";
	}
	require("calendar/$document");
}

//printing java code for listing categories
function listing_cats_java($mod)	{
	$sql_query="select * from categories";
	$res=sql_execute($sql_query,'res');
	while($cat=mysql_fetch_object($res))	{
		if($mod==1)	{
			echo ";
			 listCategory.setDefaultOption('$cat->cat_id','$cat->cat_id');
			 listCategory.addOptions('$cat->cat_id','Select Subcategory','$cat->cat_id'";
		}
		elseif($mod==2)	{
			$nex=$cat->cat_id+1;
			echo "
			 listmessage_categoryId.setDefaultOption('$cat->cat_id','$nex');
			 listmessage_categoryId.addOptions('$cat->cat_id'";
		}
		$sql_query="select * from sub_categories where cat_id='$cat->cat_id'";
		$res2=sql_execute($sql_query,'res');
		while($sub=mysql_fetch_object($res2))	{
			echo ",'".str_replace("'","\'",stripslashes($sub->name))."','$sub->sub_cat_id'";
		}//while
		echo ");";
	}//while
}//function

//printing java code for music listing categories
function mlisting_cats_java($mod)	{
	$sql_query="select * from music_categories";
	$res=sql_execute($sql_query,'res');
	while($cat=mysql_fetch_object($res))	{
		if($mod==1)	{
			echo ";
			 listCategory.setDefaultOption('$cat->cat_id','$cat->cat_id');
			 listCategory.addOptions('$cat->cat_id', LNG_SELECT_SUBCAT, '$cat->cat_id'";
		}
		elseif($mod==2)	{
			$nex=$cat->cat_id+1;
			echo "
			 listmessage_categoryId.setDefaultOption('$cat->cat_id','$nex');
			 listmessage_categoryId.addOptions('$cat->cat_id'";
		}
		$sql_query="select * from music_sub_categories where cat_id='$cat->cat_id'";
		$res2=sql_execute($sql_query,'res');
		while($sub=mysql_fetch_object($res2))	{
			echo ",'$sub->name','$sub->sub_cat_id'";
		}//while
		echo ");";
	}//while
}//function

//printing java code for listing categories
function listing_mcats_java($mod)	{
	$sql_query="select * from music_categories";
	$res=sql_execute($sql_query,'res');
	while($cat=mysql_fetch_object($res))	{
		if($mod==1)	{
			echo ";
			 listCategory.setDefaultOption('$cat->cat_id','$cat->cat_id');
			 listCategory.addOptions('$cat->cat_id', LNG_SELECT_SUBCAT,'$cat->cat_id'";
		}
		elseif($mod==2)	{
			$nex=$cat->cat_id+1;
			echo "
			 listmessage_categoryId.setDefaultOption('$cat->cat_id','$nex');
			 listmessage_categoryId.addOptions('$cat->cat_id'";
		}
		$sql_query="select * from music_sub_categories where cat_id='$cat->cat_id'";
		$res2=sql_execute($sql_query,'res');
		while($sub=mysql_fetch_object($res2))	{
			echo ",'$sub->name','$sub->sub_cat_id'";
		}//while
		echo ");";
	}//while
}//function

// Returnds the curent page number on a multipage display
function getpage()	{
	if(!isset($_GET['page'])) $page=1;
	else $page=$_GET['page'];
	return $page;
}

function getpages()	{
	if(!isset($_GET['page'])) $page=1;
	else $page=$_GET['page'];
	return $page;
}

//Displays the page numbers
function show_page_nos($sql,$url,$lines,$page)	{
	$tmp	=explode("LIMIT",$sql);
	if(count($tmp)<1) $tmp	=explode("limit",$sql);
	$pgsql	=$tmp[0];
	include 'show_pagenos.php';
}

//Formats The Date
function format_date($date,$time=0)	{	
		
	if($date != "")
	{
		$tmp	=explode(" ",$date);
		$date2	=explode("-",$tmp[0]);
		$date	=$date2[1]."-".$date2[2]."-".$date2[0];
		if($time) return $date." ".$tmp[1];
		else return $date;
	}
}

//just printing listing cats list
function listing_cats($sel)	{
	$sql_query="select * from categories";
	$res=sql_execute($sql_query,'res');
	while($cat=mysql_fetch_object($res))	{
		if($cat->cat_id=="$sel")	{
			echo "<option selected value='$cat->cat_id'>$cat->name";
		}
		else{
			echo "<option value='$cat->cat_id'>$cat->name";
		}
	}//while
}//function

//just printing listing cats list
function listing_mcats($sel)	{
	$sql_query="select * from music_categories";
	$res=sql_execute($sql_query,'res');
	while($cat=mysql_fetch_object($res))	{
		if($cat->cat_id=="$sel")	{
			echo "<option selected value='$cat->cat_id'>$cat->name";
		}
		else{
			echo "<option value='$cat->cat_id'>$cat->name";
		}
	}//while
}//function

//just printing events cats list
function events_cats($sel)	{
	$sql_query="select * from event_cat";
	$res=sql_execute($sql_query,'res');
	while($cat=mysql_fetch_object($res))	{
		if($cat->cat_id=="$sel")	{
			echo "<option selected value='$cat->event_id'>".stripslashes($cat->event_nam)."</option>";
		}
		else{
			echo "<option value='$cat->event_id'>".stripslashes($cat->event_nam)."</option>";
		}
	}//while
}//function

//admin header
function show_ad_header($adsess)	
{
	global $admin_title,$main_url;
	$currPage = getCurentpage();
	
	$mode=form_get("mode");
	$act=form_get("act");
	
?>
<html>
<head>
<title><?=$admin_title?></title>
<!-- Start Metatags -->
<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<!-- End Metatags -->
<link href="<?=$main_url?>/styles/style.css" type="text/css" rel="stylesheet">
<? if(($mode='listings_manager')&&($act=='edit')) {?>
<script language="Javascript" src="<?=$main_url?>/DynamicOptionList.js"></script>
<script language="JavaScript">
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
</script>

<body marginwidth="5" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listCategory.init(document.forms['searchListing']);">
<? 
} 
?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr><td valign="top"><? require('templates/ad_header.php'); ?></td></tr>
<tr><td height="7"></td></tr>
<tr><td valign="top">
<?
}//function

//showing header
function show_header()	{
	global $site_title,$main_url;
	
		
	$currPage = getCurentpage();
	
	$mode=form_get("mode");
	$act=form_get("act");
	$pagestyles="<link href=\"$main_url/styles/style.css\" type=\"text/css\" rel=\"stylesheet\">";
	if($mode=='profile')	{
		$mem_id=form_get("mem_id");
		$sql_query="select * from musicprofile where mem_id='$mem_id'";
		$musicpro=sql_execute($sql_query,'get');
		$site_title=$site_title." - ".ucwords(stripslashes($musicpro->bandnam));
		if(!empty($musicpro->styles))	$pagestyles="<style>".stripslashes($musicpro->styles)."</style>";
	}
	elseif(($mode=='people_card') && ((empty($act)) || ($act=='pers') || ($act=='prof')))	{
		$p_id=form_get("p_id");
		$sql_query="select style_card from profiles where mem_id='$p_id'";
		$style=sql_execute($sql_query,'get');
		if(!empty($style->style_card))	$pagestyles="<style>".stripslashes($style->style_card)."</style>";
	}
?>

<html>
<head>
<title><? echo $site_title; ?></title>
<!-- Start Metatags -->
<meta name="Generator" content="EditPlus">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<!-- End Metatags -->
<? echo $pagestyles; ?>
<?
	$mode=form_get("mode");
	$act=form_get("act");
	if($mode=="user")	{
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
	elseif(($mode=='listing')&&($act=='create'))	{
?>
<script language="Javascript" src="<?=$main_url?>/DynamicOptionList.js"></script>
<script language="JavaScript">
var listmessage_categoryId = new DynamicOptionList("message_categoryId","message_rootCategoryId");
<? listing_cats_java(2); ?>
listmessage_categoryId.addOptions('8000','computer','8001','creative','8002','erotic','8003','event','8004','household','8005','garden / labor / haul','8006','lessons','8007','looking for','8008','skilled trade','8009','sm biz ads','8010','therapeutic','8011');
function init() {
	var theform = document.forms["manageListing"];
	listmessage_categoryId.init(theform);
}
</script>
<body marginwidth="0" leftmargin ="0" topmargin="0" marginheight="0" onLoad="listmessage_categoryId.init(document.forms['manageListing']);">
<?
	}
	elseif(($mode=='m_listings')&&($act=='create'))	{
?>
<script language="Javascript" src="<?=$main_url?>/DynamicOptionList.js"></script>
<script language="JavaScript">
var listmessage_categoryId = new DynamicOptionList("message_categoryId","message_rootCategoryId");
<? mlisting_cats_java(2); ?>
listmessage_categoryId.addOptions('8000','computer','8001','creative','8002','erotic','8003','event','8004','household','8005','garden / labor / haul','8006','lessons','8007','looking for','8008','skilled trade','8009','sm biz ads','8010','therapeutic','8011');
function init() {
	var theform = document.forms["manageListing"];
	listmessage_categoryId.init(theform);
}
</script>
<body marginwidth="0" leftmargin ="0" topmargin="0" marginheight="0" onLoad="listmessage_categoryId.init(document.forms['manageListing']);">
<?
	}
	elseif((($mode=='listing')&&($act!='create')&&($act!='show')&&($act!='feedback'))||(($mode=='search')&&($act=='listing')))	{
?>
<script language="Javascript" src="<?=$main_url?>/DynamicOptionList.js"></script>
<script language="JavaScript">
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
</script>
<body marginwidth="0" leftmargin ="0" topmargin="0" marginheight="0" onLoad="listCategory.init(document.forms['searchListing']);">
<?
	}
	elseif((($mode=='m_listings')&&($act!='create')&&($act!='show')&&($act!='feedback'))||(($mode=='search')&&($act=='musiclisting')))	{
?>
<script language="Javascript" src="<?=$main_url?>/DynamicOptionList.js"></script>
<script language="JavaScript">
var listCategory = new DynamicOptionList("Category","RootCategory");
<?
 mlisting_cats_java(1);
?>
listCategory.addOptions('','Select Subcategory','');
listCategory.setDefaultOption('','');
function init() {
	var theform = document.forms["musicsearchListing"];
	listCategory.init(theform);
}
</script>
<body marginwidth="0" leftmargin ="0" topmargin="0" marginheight="0" onLoad="listCategory.init(document.forms['musicsearchListing']);">
<?
	}
?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >


<div id="center_for_ie" class="container">
<div id="content_area" class="container">
<div style="background: black; width:775px; max-width:775px;">

<? require('templates/header.php'); ?>

<?
}//header

//showing footer
function show_footer()	{
?>
<? require("templates/footer.php"); ?>

</div>
</div>
</div>

</body>
</html>


<?
	sql_close();
}//footer

//redirect
function show_screen($loc)	{
	header("Location: $loc");
	exit;
}

//error reports
function error_screen($errid)	{
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
function complete_screen($comid)	{
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
function login_test($mem_id,$mem_pass)	{
	$sql_query="select password,ban from members where mem_id='$mem_id'";
	$num=sql_execute($sql_query,'num');
	$mem=sql_execute($sql_query,'get');
	//if password incorrect
	if(($num==0)||($mem_pass!=$mem->password))	{
		error_screen(0);
	}
	//if user banned
	elseif($mem->ban=='y')	{
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
function admin_test($session)	{
	$time=time();
	$interval=$time-3600*24;
	$sql_query="delete from admin where started < $interval";
	sql_execute($sql_query,'');
	$sql_query="select * from admin where sess_id='$session'";
	$num=sql_execute($sql_query,'num');
	if($num==0)	{
		error_screen(24);
	}
}

//sending messages, depending on message id
function messages($to,$mid,$data)	{
	global $system_mail,$site_namemail;
	$m_id=cookie_get("mem_id");
	
	
	if(!isset($data[3]))
	{
		$data[3] = "";
	}
	
	echo $data[1];
	if(($mid==7) || ($mid==6))	{
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
		$body=ereg_replace("\|email\|","$data[3]",$body);
		$body=ereg_replace("\|password\|","$data[1]",$body);
		$body=ereg_replace("\|link\|","$data",$body);
		$body=ereg_replace("\|subject\|","$data[0]",$body);
		$body=ereg_replace("\|message\|","$data[1]",$body);
		$body=ereg_replace("\|user\|","$data[0]",$body);
		$subject=ereg_replace("\|email\|","$data[3]",$subject);
		$subject=ereg_replace("\|password\|","$data[1]",$subject);
		$subject=ereg_replace("\|link\|","$data",$subject);
		$subject=ereg_replace("\|subject\|","$data[0]",$subject);
		$subject=ereg_replace("\|message\|","$data[1]",$subject);
		$subject=ereg_replace("\|user\|","$data[0]",$subject);
		$name=$site_namemail;
		$from_mail=$system_mail;
	}//else
	$subject=stripslashes($subject);
	$body=stripslashes($body);
	if(empty($name))	$name=$site_namemail;
	if(empty($from_mail))	$from_mail=$system_mail;
	$sql_query="select notifications from members where email='$to'";
	$num=sql_execute($sql_query,'num');
	if($num>0)	{
		$mem=sql_execute($sql_query,'get');
		if($mem->notifications=='1')	{
			$stat=1;
		}
		else {
			$stat=0;
		}
	}
	else {
		$stat=1;
	}
	if(($stat==1)||($mid<4))	{
		if(empty($m_id))	{
			$wel="Hi";
			$thn="".LNG_SITE_ADMIN;
		}	else	{
			$sql_query="select fname,lname from members where email='$from_mail'";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				$from_nams=sql_execute($sql_query,'get');
				$thn=LNG_THANKS . ",<br>".stripslashes($from_nams->fname)."&nbsp;".stripslashes($from_nams->lname);
			}	else		$thn= LNG_THANKS . ",<br>" . LNG_SITE_ADMIN;		
			$sql_query="select fname,lname from members where email='$to'";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				$to_nams=sql_execute($sql_query,'get');
				$wel="Dear ".stripslashes($to_nams->fname)."&nbsp;".stripslashes($to_nams->lname).",";
			}	else	$wel=LNG_DEAR_FRIEND . ",";
		}
		global $main_url,$site_namemail;
		$matter="<table width='511' cellpadding='1' cellspacing='0' style='border:1px outset #000000; padding:2; border-collapse: collapse; font-family:Verdana; font-size:8pt' bgcolor='#FFFFFF' bordercolor='#636563'><tr><td colspan='2' valign='top' bgcolor='#F75D08'><a href='$main_url'><img src='$main_url/images/logo.jpg' border='0'></a></td></tr><tr><td height='20' align='center' bgcolor='#088AFF' colspan='2'><span style='color:#FFFFFF;text-decoration:none;font-family:arial,sans-serif,helvetica;font-size:12px'><strong>$subject</strong></span></td></tr><tr><td width='69' valign='top'>&nbsp;</td><td valign='top' width='441'><table width='100%' cellpadding='5' cellspacing='0' border='0'><tr><td valign='top' style='font-family: arial,sans-serif,helvetica;font-size: 12px'><p>$wel</p><p>$body</p><p>$thn<br><a href='$main_url'>$main_url</a></p><p>" . LNG_COURTESY_MSG . $site_namemail. "</p></td></tr></table></td></tr></table>";
		//include_once 'templates/mail.php';
		//echo "To: ".$to."<br>Name: ".$name."<br>Frommail: ".$from_mail."<br>" . LNG_SUBJECT . " : ".$subject."<br>" . LNG_MATTER . " : ".$matter;
		mailing($to,$name,$from_mail,$subject,$matter);
	}
}

//deleting empty values of array
function if_empty($data)	{
	$flag=0;
	if($data=='')	{
		return '';
	}//if
	else	{
		$result=array();
		foreach($data as $val)	{
			if($val!='')	{
				$flag=1;
				array_push($result,$val);
			}//if
		}//foreach
		if($flag==0)	{
			return '';
		}//elseif
		else {
			return $result;
		}//else
	}//else
}
//function

//showing country drop-down list
function country_drop($val)	
{
	if(empty($val))	
	{
		$val=LNG_US;
	}
	
	$country=array(LNG_AFGAN,LNG_ALBANIA,LNG_ALGERIA,LNG_AS,LNG_ANDORRA,LNG_ANGOLA,LNG_ANGUILIA,LNG_ANTERTICA,LNG_AB,LNG_ARGENTINA,LNG_ARMENIA,LNG_ARUBA,LNG_AI,LNG_AUSTRALIA,LNG_AUSTRIA,LNG_AZ,LNG_BAHAMAS,LNG_BAHRAIN,LNG_BANGLADESH,LNG_BARBADOS,LNG_BELARUS,LNG_BELGIUM,LNG_BELIZE,LNG_BENIN,LNG_BERMUDA,LNG_BHUTAN,LNG_BOLIVIA,LNG_BOTSWANA,LNG_BI,LNG_BRAZIL,LNG_BD,LNG_BULGARIA,LNG_B_FASO,LNG_BURUNDI,LNG_CAMBODIA,LNG_CAMEROON,LNG_CANADA,LNG_CVI,LNG_CI,LNG_CHAD,LNG_CHILE,LNG_CHINA,LNG_C_ILAND,LNG_COLOMBIA,LNG_COMOROS,LNG_CRO,LNG_COOK_I,LNG_COSTA_RICA,LNG_COTE_D_IVOIRE,LNG_CROATIA,LNG_CYPRUS,LNG_CZECH,LNG_DENMARK,LNG_DJBOUTI,LNG_DOMINICA,LNG_DOMINICAN,LNG_EAST_TIMOR,LNG_ECUADOR,LNG_EGYPT,LNG_EL_SALVA,LNG_EQ_GUINEA,LNG_ERITREA,LNG_ESTONIA,LNG_ETHIOP,LNG_FALKAN_IS,LNG_FAROE,LNG_FIJI,LNG_FINLAND,LNG_FRANCE,LNG_FRENCHG,LNG_FRENCHP,LNG_GABON,LNG_GAMBIA,LNG_GEORGIA,LNG_GERMANY,LNG_GHANA,LNG_GIBRA,LNG_GREECE,LNG_GREENLND,LNG_GRENADA,LNG_GUADE,LNG_GUAM,LNG_GAUTE,LNG_GUERNSEY,LNG_GUINEA,LNG_GUINEAB,LNG_GUYANA,LNG_HAITI,LNG_HONDU,LNG_HK,LNG_HUNGARY,LNG_ICELAND,LNG_INDIA,LNG_INDONES,LNG_IRAN,LNG_IRELAND,LNG_ISLEMAN,LNG_ISRAEL,LNG_ITALY,LNG_JAMAICA,LNG_JAPAN,LNG_JERSEY,LNG_JORDAN,LNG_KAZAK,LNG_KENYA,LNG_KIRIBA,LNG_KORIA_REP,LNG_KUWAIT,LNG_KYRGY,LNG_LAOS,LNG_LAT,LNG_LEBANON,LNG_LESOTHO,LNG_LIBERIA,LNG_LIBYA,LNG_LIECHT,LNG_LIHU,LNG_LUXEM,LNG_MACAU,LNG_MACEDONIA,LNG_MADAGASCAR,LNG_MALAWI,LNG_MALAY,LNG_MALDIVES,LNG_MALI,LNG_MALTA,LNG_MARSHAL_IS,LNG_MARTINI,LNG_MAURITANIA,LNG_MAURI,LNG_MAYOTTE_IS,LNG_MEXICO,LNG_MICRONESIA,LNG_MOLDOVA,LNG_MONACO,LNG_MONGOL,LNG_MONTS,LNG_MOROCO,LNG_MOZAMBQ,LNG_MYANMAR,LNG_NAMBIA,LNG_NAURU,LNG_NEPAL,LNG_NETH,LNG_NETH_ANTI,LNG_NEWCALE,LNG_NEWZEA,LNG_NICAR,LNG_NIGER,LNG_NIGERIA,LNG_NIUE,LNG_NORFOLK_IS,LNG_NORWAY,LNG_OMAN,LNG_PAKI,LNG_PALAU,LNG_PANAMA,LNG_PAPUA,LNG_PARAGUAY,LNG_PERU,LNG_PHILIPS,LNG_PITC_IS,LNG_POLAND,LNG_PORTUGAL,LNG_PUERTO_RICO,LNG_QATAR,LNG_REUNION_IS,LNG_ROMANIA,LNG_RUSS_FED,LNG_RAWANDA,LNG_SAINTHELENA,LNG_SAINTLUCIA,LNG_SANMARINO,LNG_SARAB,LNG_SENGAL,LNG_SEYCHELL,LNG_SIERA_LE,LNG_SPORE,LNG_SLOV_REP,LNG_SOLVE,LNG_SOLO_IL,LNG_SOMALIA,LNG_SAFRICA,LNG_SGEORGIA,LNG_SPAIN,LNG_LANKA,LNG_SURINAM,LNG_SVALB,LNG_SWAZI,LNG_SWEDEN,LNG_SWITZ,LNG_SYRIA,LNG_TAIWAN,LNG_TAJIK,LNG_TANZ,LNG_THAI,LNG_TOGO,LNG_TOKELAU,LNG_TONGAI,LNG_TUNISI,LNG_TURKEY,LNG_TURKMS,LNG_TUVALU,LNG_UGND,LNG_UKRN,LNG_UK,LNG_USA,LNG_URUGUA,LNG_UZBEK,LNG_VANUA,LNG_VATI,LNG_VENEZ,LNG_VIET,LNG_WSHARA,LNG_WSAMO,LNG_YEMEN,LNG_YUGO,LNG_ZAMB,LNG_ZIMB);
	
	//$country = array('india','china');
	
	//for($i=0; $i<=count($country)-1; $i++)	
	foreach ($country as $var)
	{
?>
		<option value="<?=$var?>"> <?=getSelected($var,$val)?> <?=$var?> </option>
<?
	}
}

//days drop-down list
function day_drop($sel)	{
	for($i=1;$i<=31;$i++)	{
		if($i==$sel)	{
			echo "<option selected value='$i'>$i\n";
		}	else	{
			echo "<option value='$i'>$i\n";
		}
	}
}

//months drop-down list
function month_drop($sel)	{
	$month= array(1=>LNG_JAN, 2=>LNG_FEB, 3=>LNG_MAR, 4=>LNG_APR, 5=>LNG_MAY, 6=>LNG_JUN, 7=>LNG_JUL, 8=>LNG_AUG, 9=>LNG_SEP, 10=>LNG_OCT, 11=>LNG_NOV, 12=>LNG_DEC);
	for($i= 1;$i<=12;$i++)	{
		if( $i==$sel)	{
			echo "<option selected value='$i'>$month[$i]\n";
		}   
		else {
			echo "<option value='$i'>$month[$i]\n";
		}   
	}
}   

//years drop-down list
function year_drop($sel)	{
	if($sel=='now')	{
		$year=2010;
		$start=date("Y");
		for($i=$start;$i<=$year;$i++)	{
			echo "<option value='$i'>$i\n";
		}//for
	}//if
	else{
		$year=date("Y");
		for($i=$year-75;$i<=$year;$i++)	{
			if($i==$sel)	{
				echo "<option selected value='$i'>$i\n";
			}
			else {
				echo "<option value='$i'>$i\n";
			}
		}
	}//else
}

//showing if user is online,offline or anonymous
function show_online($m_id)	{
	
	global $lng_id;
	
	$sql_query="select showonline,online,profilenam from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	if(($mem->online=='on') && ($mem->showonline=='1')){
		echo "<img src='images/icon_online.gif' alt='" . LNG_USER_ONLINE . "'>";
		echo "&nbsp&nbsp<span class=body><a href='index.php?mode=people_card&p_id=$m_id&lng=$lng_id'>$mem->profilenam</a></span>";
	}
	else{
		echo "<img src='images/icon_offline.gif' alt='" . LNG_USER_OFFLINE . "'>";
		echo "&nbsp&nbsp<span class=body><a href='index.php?mode=people_card&p_id=$m_id&lng=$lng_id'>$mem->profilenam</a></span>";
	}
}

//showing user's name
function show_memnam($m_id)	{
	
	global $lng_id;
	
	$sql_query="select fname,lname from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	echo "<span><a href='index.php?mode=people_card&p_id=$m_id&lng=$lng_id'>$mem->fname</a></span>";
}

//showing user main photo
function show_photo($m_id)	{
	
	global $lng_id;
	
	if($m_id=='anonim')	echo "<img src='images/unknownUser_th.jpg' border=0>";
	else	{
		$sql_query="select photo_thumb from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		if($mem->photo_thumb=='no')	$mem->photo_thumb="images/unknownUser_th.jpg";
		else                        $mem->photo_thumb=$mem->photo_thumb;
		echo "<a href='index.php?mode=people_card&p_id=$m_id&lng=$lng_id'><img src='$mem->photo_thumb' border='0'></a>";
	}
}

//calculating number of new messages in inbox
function mes_num($m_id)	{
	$sql_query="select mes_id from messages_system where mem_id='$m_id'
	and folder='inbox' and type='message' and new='new'";
	$num=sql_execute($sql_query,'num');
	return $num;
}

//calculating number or creating array of user's friends, depending on degree
function count_network($m_id,$deg,$mod)	{
	//degree 1
	if($deg==1)	{
		$sql_query="select frd_id from network where mem_id='$m_id'";
		$num=sql_execute($sql_query,'num');
		if($num==0)	{
			$friend='';
		}//if
		else {
			$res=sql_execute($sql_query,'res');
			$friend=array();
			while($fr=mysql_fetch_object($res))	{
				if(!empty($fr->frd_id))	array_push($friend,$fr->frd_id);
			}//while
			$friend=del_dup($friend);
			$num=count($friend);
		}//else
	}//deg1
	//degree 2
    elseif($deg==2)	{
		$fr=array();
		$fr=count_network($m_id,"1","ar");
		if($fr=='')	{
			$friend='';
			$num=0;
		}//if
		else {
			$friend=array();
			foreach($fr as $fid)	{
				$sql_query="select frd_id from network where mem_id='$fid' and frd_id!='$m_id'";
				$res=sql_execute($sql_query,'res');
				while($fri=mysql_fetch_object($res))	{
					if(!empty($fri->frd_id))	array_push($friend,$fri->frd_id);
				}//while
			}//foreach
			$friend=del_dup($friend);
			$friend=array_diff($friend,$fr);
			$num=count($friend);
		}//else
	}//deg2
	//degree 3
	elseif($deg==3)	{
		$fr=array();
		$fr1=count_network($m_id,"1","ar");
		$fr=count_network($m_id,"2","ar");
		if($fr=='')	{
			$friend='';
			$num=0;
		}//if
		else {
			$friend=array();
			foreach($fr as $fid)	{
				$sql_query="select frd_id from network where mem_id='$fid' and frd_id!='$m_id'";
				$res=sql_execute($sql_query,'res');
				while($fri=mysql_fetch_object($res)){
					if(!empty($fri->frd_id))	array_push($friend,$fri->frd_id);
				}//while
			}//foreach
			$friend=del_dup($friend);
			$friend=array_diff($friend,$fr);
			$friend=array_diff($friend,$fr1);
			$num=count($friend);
		}//else
	}//deg3
	//degree 4
	elseif($deg==4)	{
		$fr=array();
		$fr1=count_network($m_id,"1","ar");
		$fr2=count_network($m_id,"2","ar");
		$fr=count_network($m_id,"3","ar");
		if($fr=='')	{
			$friend='';
			$num=0;
		}//if
		else {
			$friend=array();
			foreach($fr as $fid)	{
				$sql_query="select frd_id from network where mem_id='$fid' and frd_id!='$m_id'";
				$res=sql_execute($sql_query,'res');
				while($fri=mysql_fetch_object($res))	{
					if(!empty($fri->frd_id))	array_push($friend,$fri->frd_id);
				}//while
			}//foreach
			$friend=del_dup($friend);
			$friend=array_diff($friend,$fr);
			$friend=array_diff($friend,$fr1);
			$friend=array_diff($friend,$fr2);
			$num=count($friend);
		}//else
	}//deg4
	//degree all
	elseif($deg=='all')	{
		$num=count_network($m_id,"1","num")+count_network($m_id,"2","num")+
		count_network($m_id,"3","num")+count_network($m_id,"4","num");
		$friend=array_merge(count_network($m_id,"1","ar"),count_network($m_id,"2","ar"),
		count_network($m_id,"3","ar"),count_network($m_id,"4","ar"));
	}//degall
	////////////////////////////////////
	//format output
	if ($mod=='num')	{
		return $num;
	}
	elseif ($mod=='ar')	{
		return $friend;
	}
	////////////////////////////////////
}

//deleting duplicates from array
function del_dup($data)	{
	$result=array();
	$result=array_unique($data);
	return $result;
}

//showing random tip
function show_tip()	{
	$dis=array();
	$sql_query="select tip_id from tips";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$dis[]=$row->tip_id;
		}
	}
	$tak=rand(0,count($dis)-1);
	$sql_query="select * from tips where tip_id='$dis[$tak]'";
	$tip=sql_execute($sql_query,'get');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
  <tr>
    <td class="hometitle" style="padding-left: 7" height="20"><?=stripslashes($tip->tip_header)?></td>
  </tr>
  <tr>
    <td style="padding-left: 7" align="center"><?=stripslashes($tip->tip)?></td>
  </tr>
</table>
<?
}

//creating array of lister friends
function lister_degree($mem_id,$deg)	{
	$result=array();
	for($i=$deg;$i>=1;$i--)	{
		$network=count_network($mem_id,"$i","ar");
		$result=array_merge($result,$network);
	}
	$result=if_empty($result);
	if($result=='')	{
		$result[]='';
	}
	return $result;
}//function

//showing listings, depending on mode
function show_listings($mode,$m_id,$page)	{
	$now=time();
	$sql_query="delete from listings where added+live<$now";
	sql_execute($sql_query,'');
	if($mode!='tribe')	{
		//setting ignore list
		$sql_query="select ignore_list from members where mem_id='$m_id'";
		$mem1=sql_execute($sql_query,'get');
		$ignore=split("\|",$mem1->ignore_list);


// Error here
		$ignore=if_empty($ignore);
		//setting filter
		$sql_query="select filter,zip from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		
		
		if($mem->filter != "")
		{
		
			$items=split("\|",$mem->filter);
			$distance=$items[0];
						
			$zip=$items[1];
			if($zip=='')	{
				$zip=$mem->zip;
			}
			$degree=$items[2];
		}
		else
		{
			$distance = "";
			$zip = "";
			$degree = "";
		}
		
		
		//applying distance filter
		$zone=array();
		if($distance=='any')	{
			$zonear='no result';
		}	else	{
			$zonear=inradius($zip,$distance);
		}
		
		if(($zonear=='not found')||($zonear=='no result'))	{
			$sql_query="select lst_id from listings";
			$res=sql_execute($sql_query,'res');
			while($z=mysql_fetch_object($res))	{
				array_push($zone,$z->lst_id);
			}
		}
		else {
			$sql_query="select lst_id from listings where ";
			foreach($zonear as $zp)	{
				$sql_query.="zip='$zp' or ";
			}
			$sql_query=rtrim($sql_query,' or ');
			$res=sql_execute($sql_query,'res');
			while($z=mysql_fetch_object($res))	{
				array_push($zone,$z->lst_id);
			}
		}
		//applying degree filter
		$friends=array();
		$filter=array();
		if($degree=='any')	{
			$sql_query="select mem_id from members";
			$res=sql_execute($sql_query,'res');
			while($fr=mysql_fetch_object($res))	{
				array_push($friends,$fr->mem_id);
			}
		}
		else {
			for($i=$degree;$i>=1;$i--)	{
				$friends=array_merge($friends,count_network($m_id,$i,"ar"));
			}//for
		}//else
		$filter=$friends;
	}//if
	$zone=if_empty($zone);
	$filter=if_empty($filter);
	//recent listings
	if($mode=='recent')	{
		if(($filter!='')&&($zone!=''))	{
			$sql_query="select * from listings where (";
			if($filter!='')	{
				foreach($filter as $id)	{
					$sql_query.="mem_id='$id' or ";
				}//foreach
				$sql_query=rtrim($sql_query,' or ');
			}//if
			if($zone!='')	{
				$sql_query.=") and (";
				foreach($zone as $zon)	{
					$sql_query.="lst_id='$zon' or ";
				}//foreach
				$sql_query=rtrim($sql_query,' or ');
				$sql_query.=")";
			}//if
			if($ignore!='')	{
				//deleting from sql-query ignored users
				foreach($ignore as $ign)	{
					$sql_query.=" and mem_id!='$ign'";
				}//foreach
			}//if
			if($degree!='any')	{
				$sql_query.=" and anonim!='y'";
			}//if
			$sql_query.=" and stat='a' order by added desc";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				$i=0;
				while($lst=mysql_fetch_object($res))	{
					if($lst->show_deg!='trb')	{
					if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id))	{
						$lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
					}	else	{
						$lister_friends[]=$m_id;
					}
					//checkin if user is a friend of lister
					if((in_array($m_id,$lister_friends))||($lst->anonim=='y'))	{
						$date=date("m/d/Y",$lst->added);
						$sql_query="select name from categories where cat_id='$lst->cat_id'";
						$cat=sql_execute($sql_query,'get');
						$sql_query="select name from sub_categories where sub_cat_id='$lst->sub_cat_id'";
						$sub=sql_execute($sql_query,'get');
						echo "<table>";
						echo "<tr><td><table><tr><td align=center width=0 height=75 class=body>";
						echo "</td><tr><td align=center class=body>";
						echo "</td></table></td>";
						echo "<td><table width=100%><tr><td class=body><a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id'><img src='images/icon_listing.gif' border=0>$lst->title</a></td><tr><td class=body>$date - $cat->name - $sub->name</td><tr><td class=body>$lst->descr_part <span class=body><a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id&lng=$lng_id'>more</a></span></td><tr><td class=body>";
						if($lst->anonim!='y')	{
                     connections($m_id,$lst->mem_id);
                     }
                     echo "</td>
                     </table>
                     </td>";
                     echo "</table>";
                     if($i==5){
                       break;
                     }
                     $i++;
                     }//if
                }//while
                }//if
                }//else
                }//if
            }//if
            //profile section listings from user and friends
            elseif($mode=='inprofile'){
            $friends=array();
            $friends=count_network($m_id,"1","ar");
            $sql_query="select * from listings where (mem_id='$m_id'";
            if($friends!=''){
            foreach($friends as $fr){
                $sql_query.=" or mem_id='$fr'";
            }//foreach
            }//if
            $sql_query.=") and stat='a' order by added";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo "<p align=center class=body>No listings available</p>&nbsp";
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id&lng=$lng_id'>$lst->title</a>";
                $c_name=get_cat_name($lst->cat_id);
                echo " (<a href='index.php?mode=listing&act=show_cat&cat_id=$lst->cat_id&lng=$lng_id'>$c_name</a>) - ";
                show_online($lst->mem_id);
                echo "</br>";
            }//while
            }//else
            }//elseif
            //showing user's listings
            elseif($mode=='my'){
            $sql_query="select * from listings where mem_id='$m_id' and stat='a'";
            $sql_query.=" order by added";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo LNG_NO_LIST_AVAIABLE;
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id&lng=$lng_id'>$lst->title</a>";
                $c_name=get_cat_name($lst->cat_id);
                echo " (<a href='index.php?mode=listing&act=show_cat&cat_id=$lst->cat_id&lng=$lng_id'>
                $c_name</a>) - ";show_online($lst->mem_id);
                echo "</br>";
            }//while
            }//else
            }//elseif
            //showing one category listings
            elseif($mode=='cat'){
            $cid=form_get('cat_id');
            $start=($page-1)*20;
            $sql_query="select * from listings where cat_id='$cid' and stat='a'";
            $sql_query.=" order by added limit $start,20";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo LNG_NO_LIST_AVAIABLE;
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
                if($lst->show_deg!='trb'){
                if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id)){
                $lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
                }
                else{
                $lister_friends[]=$m_id;
                }
                if((in_array($m_id,$lister_friends))||($lst->anonim=='y')){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id&lng=$lng_id'>$lst->title</a>&nbsp";
                if($lst->anonim!='y'){
                show_online($lst->mem_id);echo " - ";
                }
                else{
                echo LNG_ANONYMOUS;
                }
                echo find_relations($m_id,$lst->mem_id);
                echo "</br>";
                }//if
                }//if
            }//while
            }//else
            }//elseif
            //showing one sub-category listings
            elseif($mode=='sub_cat'){
            $sid=form_get('sub_cat_id');
            $start=($page-1)*20;
            $sql_query="select * from listings where sub_cat_id='$sid' and stat='a'";
            $sql_query.=" order by added limit $start,20";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo LNG_NO_LIST_AVAIABLE;
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
                if($lst->show_deg!='trb'){
                if(($lst->show_deg!='any')&&($lst->mem_id!=$m_id)){
                $lister_friends=lister_degree($lst->mem_id,$lst->show_deg);
                 }
                 else{
                 $lister_friends[]=$m_id;
                 }
                if((in_array($m_id,$lister_friends))||($lst->anonim=='y')){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id&lng=$lng_id'>$lst->title</a>&nbsp";
                if($lst->anonim!='y'){
                show_online($lst->mem_id);
                }
                else{
                echo LNG_ANONYMOUS;
                }
                echo " - ";echo find_relations($m_id,$lst->mem_id);
                echo "</br>";
                }//if
                }//if
            }//while
            }//else
            }//elseif
            //showing tribe listings
            elseif($mode=='tribe'){
            $sql_query="select * from listings where trb_id='$m_id' and stat='a'";
            $sql_query.=" order by added";
            $num=sql_execute($sql_query,'num');
            if($num==0){
             echo LNG_NO_LIST_AVAIABLE;
            }//if
            else {
            $res=sql_execute($sql_query,'res');
            while($lst=mysql_fetch_object($res)){
             	$date=date("m/d",$lst->added);
                echo "$date  <img src='images/icon_listing.gif'>
                <a href='index.php?mode=listing&act=show&lst_id=$lst->lst_id&lng=$lng_id'>$lst->title</a>";
                $c_name=trim(get_cat_name($lst->cat_id));
                echo " (<a href='index.php?mode=listing&act=show_cat&cat_id=$lst->cat_id&lng=$lng_id'>$c_name</a>) - ";
                show_online($lst->mem_id);
                echo "</br>";
            }//while
            }//else
            }//elseif

}//function

//searching degree between 2 users
function find_relations($mem_id,$frd_id){
if($frd_id=='0'){
   return '';
}
if($mem_id==$frd_id){
   return 'You';
}//if
else {
  $fr1=count_network($mem_id,"1","ar");
  if(is_array($fr1)&&in_array($frd_id,$fr1)){
    return "1&deg";
  }//if
  else {
  	   $fr2=count_network($mem_id,"2","ar");
       if(is_array($fr2)&&in_array($frd_id,$fr2)){
           return "2&deg";
       }//if
       else {
            $fr3=count_network($mem_id,"3","ar");
            if(is_array($fr3)&&in_array($frd_id,$fr3)){
                 return "3&deg";
            }//if
            else {
                 $fr4=count_network($mem_id,"4","ar");
                 if(is_array($fr4)&&in_array($frd_id,$fr4)){
                       return "4&deg";
                 }//if
                 else{
                       return "(unrelated)";
                 }//else
            }//else
       }//else
  }//else
}//else

}//function

//building a connection chain between 2 user's
function connections($mem_id,$frd_id){
//anonymous
if($frd_id=='0'){
echo '';
}
//1 user and 2 are the same
elseif($mem_id==$frd_id){
  echo "You";
}//if
else {
$friend=array();
$friend=count_network($mem_id,"1","ar");

//1 degree
if (is_array($friend)&&in_array($frd_id,$friend)){
    echo show_online($frd_id)."<img src='images/icon_arrow_blue.gif' border=0>You";
}//if
//2 degree
else {

     $friend=count_network($mem_id,"2","ar");
     if(is_array($friend)&&in_array($frd_id,$friend)){

             $deg2=count_network($frd_id,"1","ar");
             $my=count_network($mem_id,"1","ar");

             if(count($my)<count($deg2)){
             $result=array_intersect($my,$deg2);
             }
             else{
             $result=array_intersect($deg2,$my);
             }

             show_online($frd_id);echo "<img src='images/icon_arrow_blue.gif' border=0>";
             show_online($result[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>You";

     }//if
     //3 degree
     else{

             $friend=count_network($mem_id,"3","ar");
             if(is_array($friend)&&in_array($frd_id,$friend)){

                    $deg1=count_network($frd_id,"1","ar");
                    $my2=count_network($mem_id,"2","ar");
                    if(count($my2)<count($deg1)){
             		$result=array_intersect($my2,$deg1);
		            }
        		    else{
		            $result=array_intersect($deg1,$my2);
        		    }

                    $deg2=count_network($frd_id,"2","ar");
                    $my=count_network($mem_id,"1","ar");
                    if(count($my)<count($deg2)){
      	            $result2=array_intersect($my,$deg2);
	                }
	                else{
	                $result2=array_intersect($deg2,$my);
	                }

                    foreach($result2 as $one){
                       if($one!=''){
                          $last=$one;
                          break;
                       }//if
                    }//foreach

                    show_online($frd_id);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                    show_online($result[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                    show_online($last);echo "<img src='images/icon_arrow_blue.gif' border=0>You";


             }//if
             //4 degree
             else{

                    $friend=count_network($mem_id,"4","ar");
                    if(is_array($friend)&&in_array($frd_id,$friend)){

                               $deg1=count_network($frd_id,"1","ar");
                               $my3=count_network($mem_id,"3","ar");
                               if(count($my3)<count($deg1)){
             	               $result=array_intersect($my3,$deg1);
	                           }
	                           else{
	                           $result=array_intersect($deg1,$my3);
	                           }

                               $deg2=count_network($frd_id,"2","ar");
                               $my2=count_network($mem_id,"2","ar");
                               if(count($my2)<count($deg2)){
             	               $result1=array_intersect($my2,$deg2);
	                           }
	                           else{
	                           $result1=array_intersect($deg2,$my2);
	                           }

                               $deg3=count_network($frd_id,"3","ar");
                               $my1=count_network($mem_id,"1","ar");

                               if(count($my1)<count($deg3)){
             	               $result2=array_intersect($my1,$deg3);
	                           }
	                           else{
	                           $result2=array_intersect($deg3,$my1);
	                           }

                               foreach($result2 as $one){
                                   if($one!=''){
                                     $last=$one;
                                     break;
                                   }//if
                               }//foreach


                               show_online($frd_id);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                               show_online($result[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                               show_online($result1[0]);echo "<img src='images/icon_arrow_blue.gif' border=0>";
                               show_online($last);echo "<img src='images/icon_arrow_blue.gif' border=0>You";

                    }//if
                    //no connection
                    else{

                               echo LNG_NO_CONNECTION;show_online($frd_id);

                    }//else
             }//else
     }//else
}//else
}//else
}//function

//searching zip codes within specified radius
function inradius($zip,$radius)
    {
        $sql_query="SELECT * FROM zipData WHERE zipcode='$zip'";
        $num=sql_execute($sql_query,'num');
        if($num==0){
          return "not found";
        }//if
        else {
        	$zp=sql_execute($sql_query,'get');
            $lat=$zp->lat;
            $lon=$zp->lon;
            $sql_query="SELECT zipcode FROM zipData WHERE (POW((69.1*(lon-\"$lon\")*cos($lat/57.3)),\"2\")+POW((69.1*(lat-\"$lat\")),\"2\"))<($radius*$radius) ";
            $num2=sql_execute($sql_query,'num');
            if($num2>0){
                    $res=sql_execute($sql_query,'res');
                    $i=0;
                    while($found=mysql_fetch_object($res)) {
                    $zipArray[$i]=$found->zipcode;
                    $i++;
                	}//while
            }//if
            else {
              return LNG_NO_RESULT;
            }//else
        }//else
     return $zipArray;
    } // end func

//showing one user friends
function show_friends($m_id,$limit,$inline,$page){

    $friends=count_network($m_id,"1","ar");
    if($friends!='')	{
	    $start=($page-1)*$limit;
	    $end=$start+$limit;
	    if($end>count($friends))	$end=count($friends);
	    for($i=$start;$i<$end;$i++){
	        $frd=$friends[$i];
			if(!empty($frd))	{
		        if(($i==0)||($i%$inline==0))
		        {
		           echo "<tr>";
		        }//if
			    echo "<td width=65 height=75><table class='body'>";
			    echo "<tr><td align=center width=65>";
			    show_photo($frd);
				echo "</td>
				<tr><td align=center>";
				show_online($frd);
				echo "</td></table></td>";
			}
	    }//foreach
    }//if
    else {
       echo "<div align='center'><p class='body' align=center>No friends.</p></div>";
    }//else

}//function

//showing pages line (if the output is too big, for ex. search results are split into several pages)
function pages_line($id,$type,$page,$limit){
   //spliting friends list
   if($type=='friends'){
      $friends=count_network($id,"1","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=people_card&act=friends&p_id=$id&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if

   }//if
   if($type=='friends2'){
      $friends=count_network($id,"2","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=2&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
   if($type=='friends3'){
      $friends=count_network($id,"3","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=3&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
   if($type=='friends4'){
      $friends=count_network($id,"4","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=4&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
   if($type=='friendsall'){
      $friends=count_network($id,"all","num");
      if($friends!='0'){
      if($friends%$limit==0){
        $pages=$friends/$limit;
      }//if
      else {
        $pages=(int)($friends/$limit)+1;
      }//else

      $first="<a href='index.php?mode=user&act=friends_view&pro=all&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

      //spliting members list
      elseif($type=='members'){
      $membs=tribe_members($id);
      $members=count($membs);
      if($members!='0'){
      if($members%$limit==0){
        $pages=$members/$limit;
      }//if
      else {
        $pages=(int)($members/$limit)+1;
      }//else

      $first="<a href='index.php?mode=tribe&act=view_mems&trb_id=$id&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting category listings list
   elseif($type=='cat'){
      $sql_query="select * from listings where cat_id='$id' and stat='a'";
      $listings=sql_execute($sql_query,'num');
      if($listings!='0'){
      if($listings%$limit==0){
        $pages=$listings/$limit;
      }//if
      else {
        $pages=(int)($listings/$limit)+1;
      }//else

      $first="<a href='index.php?mode=listing&act=show_cat&cat_id=$id&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting sub-category listings list
   elseif($type=='sub_cat'){
      $sql_query="select * from listings where sub_cat_id='$id' and stat='a'";
      $listings=sql_execute($sql_query,'num');
      if($listings!='0'){
      if($listings%$limit==0){
        $pages=$listings/$limit;
      }//if
      else {
        $pages=(int)($listings/$limit)+1;
      }//else

      $first="<a href='index.php?mode=listing&act=show_sub_cat&sub_cat_id=$id&page=&lng=$lng_id";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting user's photos list
   elseif($type=='photo_album'){

      $sql_query="select photo from photo where mem_id='$id'";
      $pho=sql_execute($sql_query,'get');
      $phot=split("\|",$pho->photo);
      $phot=if_empty($phot);

      $photos=count($phot);
      if($photos!='0'){
      if($photos%$limit==0){
        $pages=$photos/$limit;
      }//if
      else {
        $pages=(int)($photos/$limit)+1;
      }//else

      $first="<a href='index.php?mode=photo_album&p_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

   //spliting tribe photo list
   elseif($type=='tribe_photo_album'){
      $sql_query="select photo from tribe_photo where trb_id='$id'";
      $pho=sql_execute($sql_query,'get');
      $phot=split("\|",$pho->photo);
      $phot=if_empty($phot);

      $photos=count($phot);
      if($photos!='0'){
      if($photos%$limit==0){
        $pages=$photos/$limit;
      }//if
      else {
        $pages=(int)($photos/$limit)+1;
      }//else

      $first="<a href='index.php?mode=photo_album&act=tribe&trb_id=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
      }//if

      //spliting basic search results
      elseif($type=='basic'){

      $first="<a href='index.php?mode=search&act=user&type=basic";

    $form_data=array('degrees','distance','zip','fname','lname','email');
    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    $first.="&".$val."=".urlencode(${$val});
    }//while

    $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

         //spliting advanced search results
         elseif($type=='advanced'){

      $first="<a href='index.php?mode=search&act=user&type=advanced";

    $form_data=array('degrees','gender','distance','zip','fname','lname','email',
    'interests','here_for','schools','occupation','company','position',
    'only_wp','sort','show','age_from','age_to');

    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    $first.="&".$val."=".urlencode(${$val});
    }//while

    $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

   //spliting simple search results
   elseif($type=='simple'){

          $ar=array(
	"interests"    ,
	"hometown"     ,
	"schools"      ,
	"languages"    ,
	"books"        ,
	"music"        ,
	"movies"       ,
	"travel"       ,
	"clubs"        ,
	"position"     ,
	"company"      ,
	"occupation"   ,
	"specialities"
	);

    $first="<a href='index.php?mode=search&act=simple";

    foreach($ar as $val){
      ${$val}=form_get("$val");
      ${$val}=urlencode(${$val});
      $first.="&".$val."=".${$val};
    }


   $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

   //spliting listings search result
   elseif($type=='search_lst'){

      $first="<a href='index.php?mode=search&act=listing";

      $form_data=array('keywords','RootCategory','Category','degree','distance','zip');
      while (list($key,$val)=each($form_data)){
      ${$val}=form_get("$val");
      $first.="&".$val."=".urlencode(${$val});
      }//while

   $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

   //spliting tribes search result
   elseif($type=='search_trb'){

      $first="<a href='index.php?mode=search&act=tribe";

      $keywords=form_get("keywords");
      $first.="&keywords=".urlencode($keywords);

   $first.="&page=";

      $search=$id;
      if($search%$limit==0){
        $pages=$search/$limit;
      }//if
      else {
        $pages=(int)($search/$limit)+1;
      }//else

      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";

   }//if

      //spliting users admin view list
   if($type=='ad_users'){
   $sql_query="select mem_id from members";
   $num=sql_execute($sql_query,'num');
      $users=$num;
      if($users!='0'){
      if($users%$limit==0){
        $pages=$users/$limit;
      }//if
      else {
        $pages=(int)($users/$limit)+1;
      }//else

      $first="<a href='admin.php?mode=users_manager&adsess=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if
      //spliting users admin view list
   if($type=='banner_list'){
   $sql_query="select b_id from banners";
   $num=sql_execute($sql_query,'num');
      $users=$num;
      if($users!='0'){
      if($users%$limit==0){
        $pages=$users/$limit;
      }//if
      else {
        $pages=(int)($users/$limit)+1;
      }//else

      $first="<a href='admin.php?mode=banner_manager&adsess=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

         //spliting listings admin view list
   if($type=='ad_listings'){
   $sql_query="select lst_id from listings";
   $num=sql_execute($sql_query,'num');
      $listings=$num;
      if($listings!='0'){
      if($listings%$limit==0){
        $pages=$listings/$limit;
      }//if
      else {
        $pages=(int)($listings/$limit)+1;
      }//else

      $first="<a href='admin.php?mode=listings_manager&adsess=$id&page=";
      $mid="'>";
      $last="</a>";

      echo $first."1".$mid."<<".$last."&nbsp";
      if($page!='1'){
      echo $first.($page-1).$mid."<".$last;
      }//if
      echo "&nbsp&nbsp&nbsp";

      for($i=1;$i<=$pages;$i++){
          if($i==$page){
            echo "<b>";
          }
          echo $first.$i.$mid."$i".$last."&nbsp";
          if($i==$page){
            echo "</b>";
          }

      }//for

      echo "&nbsp&nbsp&nbsp";

      if($pages!=$page){
      echo $first.($page+1).$mid.">".$last."&nbsp";
      }//if
      echo $first.$pages.$mid.">>".$last."&nbsp";
      }//if
   }//if

}//function

//delete item from array
function array_unset($ar,$el){
 for($i=0;$i<count($ar);$i++){
  if($ar[$i]==$el){
    unset($ar[$i]);
  }
 }
return $ar;
}

//returns category name by category id
function get_cat_name($cat_id){
 $sql_query="select name from categories where cat_id='$cat_id'";
 $cat=sql_execute($sql_query,'get');
 return $cat->name;
}

//showing when user's profile was last updated
function show_profile_updated($p_id){
 $sql_query="select updated from profiles where mem_id='$p_id'";
 $prof=sql_execute($sql_query,'get');
 $updated=date("m/d/Y",$prof->updated);
 return $updated;
}

//showing profile photo
function show_profile_photo($mem_id){
 $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
 $mem=sql_execute($sql_query,'get');
 if($mem->photo_b_thumb=='no'){
 $mem->photo_b_thumb="images/unknownUser.jpg";
 } else $mem->photo_b_thumb=$mem->photo_b_thumb;
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'><img src='$mem->photo_b_thumb' border=0></a>";
}

function show_model_photo($mem_id){
 $sql_query="select photo from models where mem_id='$mem_id'";
 $mem=sql_execute($sql_query,'get');
 if($mem->photo==''){
 $mem->photo_b_thumb="images/unknownUser.jpg";
 } else $mem->photo_b_thumb=$mem->photo;
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'><img src='$mem->photo_b_thumb' border=0></a>";
}
function show_actor_photo($mem_id){
 $sql_query="select photo from actors where mem_id='$mem_id'";
 $mem=sql_execute($sql_query,'get');
 if($mem->photo==''){
 $mem->photo_b_thumb="images/unknownUser.jpg";
 } else $mem->photo_b_thumb=$mem->photo;
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'><img src='$mem->photo_b_thumb' border=0></a>";
}

function show_m_photo($mem_id){
 $sql_query="select photo_thumb from models where mem_id='$mem_id'";
 $mem=sql_execute($sql_query,'get');
 if($mem->photo_thumb==''){
 $mem->photo_b_thumb="images/unknownUser_th.jpg";
 } else $mem->photo_b_thumb=$mem->photo_thumb;
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'><img src='$mem->photo_b_thumb' border=0></a>";
}
function show_a_photo($mem_id){
 $sql_query="select photo_thumb from actors where mem_id='$mem_id'";
 $mem=sql_execute($sql_query,'get');
 if($mem->photo_thumb==''){
 $mem->photo_b_thumb="images/unknownUser_th.jpg";
 } else $mem->photo_b_thumb=$mem->photo_thumb;
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'><img src='$mem->photo_b_thumb' border=0></a>";
}


//showing tribe main photo
function show_tribe_photo($trb_id){
 $sql_query="select photo_b_thumb from tribes where trb_id='$trb_id'";
 $trb=sql_execute($sql_query,'get');
 if($trb->photo_b_thumb=='no'){
 $trb->photo_b_thumb="images/unknownUser.jpg";
 }
 echo "<a href='index.php?mode=photo_album&act=tribe&trb_id=$trb_id'><img src='$trb->photo_b_thumb' border=0></a>";
}

//showing tribe main photo (small)
function show_tribe_s_photo($trb_id){
 $sql_query="select photo_thumb from tribes where trb_id='$trb_id'";
 $trb=sql_execute($sql_query,'get');
 if($trb->photo_thumb=='no'){
 $trb->photo_thumb="images/unknownUser_th.jpg";
 }
 echo "<a href='index.php?mode=tribe&act=show&trb_id=$trb_id'><img src='$trb->photo_thumb' border=0></a>";
}

//showing the link to tribe photo album
function tribe_photo_link($trb_id){
 $sql_query="select photo,updated from tribe_photo where trb_id='$trb_id'";
 $ph=sql_execute($sql_query,'get');
 $items=split("\|",$ph->photo);
 $items=if_empty($items);
 $items=array_unset($items,'no');
 if($items==''){
   $num=0;
 }
 else {
 $num=count($items);
 }
 if($num!=0){
 echo "<a href='index.php?mode=photo_album&act=tribe&trb_id=$trb_id'>$num LNG_PHOTO_IN_ALBUM</a>";
 }
 else {
 echo LNG_NO_PHOTO_IN_ALBUM;
 }
}

//showing link to viewing tribe's members
function tribe_members_link($trb_id){
$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);
$num=count($members);

if($num!=0){echo "<a href='index.php?mode=tribe&act=view_mems&trb_id=$trb_id'>$num LNG_MEMBERS</a>";}

}//function

//showing number of new discussion board posts since last user's visit
function tribe_new_posts($mem_id,$trb_id){
$visit=cookie_get("$trb_id");
if($visit==''){
  $visit=0;
}

$sql_query="select top_id from board where trb_id='$trb_id' and added>$visit";
$num=sql_execute($sql_query,'num');

if($num==0){
  return LNG_NO_NEW_POSTS;
}//if
else {
  return "$num LNG_NEW_POSTS <span><a href='index.php?mode=tribe&act=show&trb_id=$trb_id'>LNG_READ</a></span>";
}//else
}//function

//returns tribe's members array
function tribe_members($trb_id){
$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
$members=split("\|",$trb->members);
$members=if_empty($members);

return $members;
}//function

//shows tribe members
function show_members($trb_id,$limit,$inline,$page){
$members=tribe_members($trb_id);

    if($members!=''){
    $start=($page-1)*$limit;
    $end=$start+$limit;
    if($end>count($members)){
      $end=count($members);
    }
    for($i=$start;$i<$end;$i++){
        $frd=$members[$i];
        if(($i==0)||($i%$inline==0))
        {
           echo "<tr>";
        }//if
	    echo "<td width=65 height=75><table>";
	    echo "<tr><td align=center width=65>";
	    show_photo($frd);
        echo "</td>
        <tr><td align=center>";
        show_online($frd);
        echo "</td></table></td>";
    }//foreach
    }//if
    else {
       echo "<p align=center>" . LNG_NO_MEMBERS . "</p>";
    }//else

}//function

//showing topics of tribe discussion board
function show_board($trb_id){
$sql_query="select * from board where trb_id='$trb_id'";
$res=sql_execute($sql_query,'res');
echo "<tr><td>" . LNG_TOPIC . "</td><td>" . LNG_AUTHOR . "</td><td>" . LNG_REPLIES . "</td><td>" . LNG_LAST_POST . "</td>";
while($brd=mysql_fetch_object($res)){

$sql_query="select rep_id,added from replies where top_id='$brd->top_id' order by added desc";
$num=sql_execute($sql_query,'num');
$res2=sql_execute($sql_query,'res');
$one=mysql_fetch_object($res2);
if($one->added==''){
  $one->added=$brd->added;
}
$last_post=date("m/d/Y",$one->added);

   echo "<tr><td><a href='index.php?mode=tribe&act=board&pro=view&top_id=$brd->top_id&trb_id=$trb_id'>$brd->topic</a></td>
   <td><a href='index.php?mode=people_card&p_id=$brd->mem_id'>";
   echo name_header($brd->mem_id,'');
   echo "</a></td><td>$num</td><td>$last_post</td>";

}//while


}//function

//showing tribe events list
function show_events($trb_id){
$sql_query="select * from events where trb_id='$trb_id'";
$res=sql_execute($sql_query,'res');

while($evn=mysql_fetch_object($res)){
  $date=date("m/d/Y",$evn->start_date);
  echo "<a href='index.php?mode=tribe&act=event&pro=view&evn_id=$evn->evn_id&trb_id=$trb_id'>$evn->title</a> $date";
  $start_time=date("h:i A",$evn->start_time);
                    if($evn->start_time!='0'){
                       echo " @ $start_time ";
                    }
                    echo "</br>";
}//while

}//function

//user friends drop-down list
function drop_mem_tribes($mem_id,$sel){
$sql_query="select tribes from members where mem_id='$mem_id'";
$mem=sql_execute($sql_query,'get');
$tribes=split("\|",$mem->tribes);
$tribes=if_empty($tribes);

if($tribes!=''){
  foreach($tribes as $trb){

      $sql_query="select name from tribes where trb_id='$trb'";
      $name=sql_execute($sql_query,'get');
      if($trb==$sel){
      echo "<option selected value='$trb'>$name->name\n";
      }
      else {
      echo "<option value='$trb'>$name->name\n";
      }

  }//foreach
}//if

}//function

//returns tribe type
function tribe_type($trb_id,$mode){
$sql_query="select type from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');
if($trb->type=='pub'){
  $text=LNG_PUBLIC;
}
elseif($trb->type=='mod'){
  $text=LNG_MOD_MEMBER;
}
elseif($trb->type=='priv'){
  $text=LNG_PRIVATE;
}
if($mode=='output'){
  return $text;
}
elseif($mode=='get'){
  return $trb->type;
}
}//function

//showing join tribe link, if user is not a member
function join_tribe_link($mem_id,$trb_id){

$sql_query="select members from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

$members=split("\|",$trb->members);
$members=if_empty($members);
$link="<span><a href='index.php?mode=tribe&act=join&trb_id=$trb_id'>" . LNG_JOIN . "</a></span>";
if($members==''){
  echo $link;
}//if
else {
$flag=0;
  foreach($members as $mem){

      if($mem==$mem_id){
         $flag=1;
         break;
      }//if

  }//foreach
if($flag==0){
   echo $link;
}//if
}//else

}//function

//checking if user has an access to the tribe (member)
function tribe_access_test($mem_id,$trb_id){
  $sql_query="select stat from tribes where trb_id='$trb_id'";
  $trb=sql_execute($sql_query,'get');
  if($trb->stat=='s'){
     error_screen(29);
  }//if
  $members=tribe_members($trb_id);
  $type=tribe_type($trb_id,'get');
  $act=form_get("act");
  if($type=='priv'){
  if(!in_array($mem_id,$members)){
    error_screen(11);
  }//if
  }
  if($act!='show'){
  if(!in_array($mem_id,$members)){
    error_screen(11);
  }//if
  }//if

}//function

//returns tribe category link
function tribe_category($trb_id){
$sql_query="select t_cat_id from tribes where trb_id='$trb_id'";
$trb=sql_execute($sql_query,'get');

$sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
$cat=sql_execute($sql_query,'get');

return "<a href='index.php?mode=tribe&act=cat&t_cat_id=$trb->t_cat_id'>$cat->name</a>";
}//function

//showing profile photo album link
function photo_album_link($mem_id){
 $sql_query="select photo,updated from photo where mem_id='$mem_id'";
 $ph=sql_execute($sql_query,'get');
 $items=split("\|",$ph->photo);
 $items=if_empty($items);
 $items=array_unset($items,"no");
 if($items==''){
   $num=0;
 }
 else {
 $num=count($items);
 }
 if($num!=0){
 echo "<a href='index.php?mode=photo_album&p_id=$mem_id'>$num LNG_PHOTO_IN_ALBUM</a>";
 }
 else {
 echo LNG_NO_PHOTO_IN_ALBUM;
 }
}

//showing member since value
function member_since($p_id){
 $sql_query="select joined from members where mem_id='$p_id'";
 $mem=sql_execute($sql_query,'get');
 $since=date("m/d/Y",$mem->joined);
 return $since;
}

//showing member since like value
function member_since_like($form,$p_id)	{
	$sql_query="select joined from members where mem_id='$p_id'";
	$mem=sql_execute($sql_query,'get');
	$since=date($form,$mem->joined);
	return $since;
}

//showing first name of user to another users if they are not realted
//and first with second name if they are friends
function name_header($p_id,$mem_id){
 $sql_query="select fname,lname,profilenam from members where mem_id='$p_id'";
 $p=sql_execute($sql_query,'get');
 $sql_query="select frd_id from network where mem_id='$p_id' and frd_id='$mem_id'";
 $num=sql_execute($sql_query,'num');
 if(($num==0)&&($mem_id!='ad')){
  return "$p->profilenam";
 }
 else {
  return "$p->profilenam";
 }
}

//showing different pages of profile
function show_profile($mem_id,$type){
	
	global $groups;
	//echo "wwwwwwww==>" . $groups;
    $sql_query="select * from profiles where mem_id='$mem_id'";
    $pro=sql_execute($sql_query,'get');
    $sql_query="select * from members where mem_id='$mem_id'";
    $mem=sql_execute($sql_query,'get');
    $sql_query="select trb_id from tribes where mem_id='$mem_id'";
    $num=sql_execute($sql_query,'num');
    $tribes=array();
    if($num==0){
       $tribes="";
    }
    else {
       $res=sql_execute($sql_query,'res');
       while($trb=mysql_fetch_object($res)){
          array_push($tribes,$trb->trb_id);
       }
    }

                    			//basic profile
                if($type=="basic"){
                      $here_for=$pro->here_for;
                      if($here_for!=''){
                        $here_for="<a href='index.php?mode=search&act=simple&key=here_for&here_for=".stripslashes($here_for)."'>".stripslashes($here_for)."</a>";
                      }
                      if($mem->showgender=="0"){
                        $gender="";
                      }
                      elseif($mem->gender=="m"){
                        $gender=LNG_MALE;
                      }
                      elseif($mem->gender=="f"){
                        $gender=LNG_FEMALE;
                      }
                      else{
                        $gender="";
                      }
                      if($mem->showloc=="0"){
                        $location="";
						$zip="";
                      }
                      else {

                        if($mem->country!='United States'){
	                        $location=$mem->country;
							$zip=$mem->zip;
                        }
                        else {
                           $sql_query="select city,state from zipData where zipcode='$mem->zip'";
                           $num=sql_execute($sql_query,'num');
                           if($num==0){
                                $location=$mem->country;
                           }
                           else {
                           $loc=sql_execute($sql_query,'get');
                              $city=strtolower($loc->city);
                              $city=ucfirst($city);
                              $location=$city.", ".$loc->state;
                           }

                        }

                      }
                      $interests=$pro->interests;
                      if($interests!=''){
                        $split=split(",",$interests);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=interests&interests=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $interests=rtrim($interest,',');
                      }
                      $hometown=$pro->hometown;
                      if($hometown!=''){
                        $hometown="<a href='index.php?mode=search&act=simple&key=hometown&hometown=".stripslashes($hometown)."'>".stripslashes($hometown)."</a>";
                      }
                      $occupation=$pro->occupation;
                      if($occupation!=''){
                        $occupation="<a href='index.php?mode=search&act=simple&key=occupation&occupation=".stripslashes($occupation)."'>".stripslashes($occupation)."</a>";
                      }
                      $rapzone=$mem->rapzone;
                      $schools=$pro->schools;
                      if($schools!=''){
                        $split=split(",",$schools);
                        $school='';
                        foreach($split as $word){
                        $school.="<a href='index.php?mode=search&act=simple&key=schools&schools=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $schools=rtrim($school,',');
                      }
                      if($mem->showage=="0"){
                        $age='';
                      }
                      else {
                         $now=time();
                         $was=$mem->birthday;
                         $dif=$now-$was;
                         $age=date("Y",$dif)-1970;
                      }
                      $college=$pro->college;
                      if($college!=''){
                        $college="<a href='index.php?mode=search&act=simple&key=college&college=".stripslashes($college)."'>".stripslashes($college)."</a>";
                      }
                      $highschool=$pro->highschool;
                      if($highschool!=''){
                        $highschool="<a href='index.php?mode=search&act=simple&key=highschool&highschool=".stripslashes($highschool)."'>".stripslashes($highschool)."</a>";
                      }
                      $job=$pro->job;
                      if($job!=''){
                        $job="<a href='index.php?mode=search&act=simple&key=job&job=".stripslashes($job)."'>".stripslashes($job)."</a>";
                      }
                      $description=array("Age"=>$age,"Gender"=>$gender,"Location"=>$location,"Zip Code"=>$zip,"Rap Zone"=>$rapzone,"Hometown"=>$hometown,"Schools"=>$schools,"High School"=>$highschool,"College"=>$college,"Job"=>$job,"Occupation"=>$occupation,"Here For"=>$here_for,"Interests"=>$interests);
                      while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td></tr>";

                           }//if

                      }//while
                      if($groups!=''){
                        echo "<tr><td>" . LNG_NET_GROUP . "</td><td>";
                        $i=0;
                        foreach($groups as $group){
                           $sql_query="select name from groups where trb_id='$group'";
                           $trb=sql_execute($sql_query,'get');
                           echo "<a href='index.php?mode=group&act=show&trb_id=$group'>$trb->name</a>";
                           $i++;
                           if($i!=count($groups)){
                             echo ", ";
                           }
                           }
                      }

                }//basic

                //personal
                elseif($type=="personal"){
                    $languages=$pro->languages;
                    if($languages!=''){
                        $split=split(",",$languages);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=languages&languages=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $languages=rtrim($ineterest,',');
                      }
					$website=$pro->website;
                    if($website!=''){
                      $website="<a href='".$website."'>".$website."</a>";
                    }
					$books=$pro->books;
                    if($books!=''){
                        $split=split(",",$books);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=books&books=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $books=rtrim($ineterest,',');
                      }
					$music=$pro->music;
                    if($music!=''){
                        $split=split(",",$music);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=music&music=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $music=rtrim($interest,',');
                      }
					$movies=$pro->movies;
                    if($movies!=''){
                        $split=split(",",$movies);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=movies&movies=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $movies=rtrim($interest,',');
                      }
					$travel=$pro->travel;
                    if($travel!=''){
                        $split=split(",",$travel);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=travel&travel=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $travel=rtrim($interest,',');
                      }
					$clubs=$pro->clubs;
                    if($clubs!=''){
                        $split=split(",",$clubs);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=clubs&clubs=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $clubs=rtrim($interest,',');
                      }
					$about=$pro->about;
					$meet_people=$pro->meet_people;
                    if($meet_people!=''){
                        $split=split(",",$meet_people);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=meet_people&meet_people=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $meet_people=rtrim($interest,',');
                      }
						if($pro->aua_fan=='y')	$arua=LNG_FAN;
						if(empty($arua))	{
							if($pro->aua_mc=='y')	$arua=LNG_MC;
						}	else	{
							if($pro->aua_mc=='y')	$arua.="," . LNG_MC;
						}
						if(empty($arua))	{
							if($pro->aua_vocalist=='y')	$arua=LNG_VOCALIST;
						}	else	{
							if($pro->aua_vocalist=='y')	$arua.="," . LNG_VOCALIST;
						}
						if(empty($arua))	{
							if($pro->aua_producer=='y')	$arua=LNG_MODEL;
						}	else	{
							if($pro->aua_producer=='y')	$arua.="," . LNG_MODEL;
						}
						if(empty($arua))	{
							if($pro->aua_poet=='y')	$arua=LNG_POET;
						}	else	{
							if($pro->aua_poet=='y')	$arua.="," . LNG_POET;
						}
						if(empty($arua))	{
							if($pro->aua_dancer=='y')	$arua=LNG_DANCER;
						}	else	{
							if($pro->aua_dancer=='y')	$arua.="," . LNG_DANCER;
						}
						if(empty($arua))	{
							if($pro->aua_dj=='y')	$arua=LNG_ACTORS;
						}	else	{
							if($pro->aua_dj=='y')	$arua.="," . LNG_ACTORS;
						}
						if(empty($arua))	{
							if($pro->aua_musician=='y')	$arua=LNG_MUSICIAN;
						}	else	{
							if($pro->aua_musician=='y')	$arua.="," . LNG_MUSICIAN;
						}
						if(empty($arua))	{
							if($pro->aua_artist=='y')	$arua=LNG_ARTIST;
						}	else	{
							if($pro->aua_artist=='y')	$arua.="," . LNG_ARTIST;
						}
						if(empty($arua))	{
							if($pro->aua_other=='y')	$arua=LNG_OTHER;
						}	else	{
							if($pro->aua_other=='y')	$arua.="," . LNG_OTHER;
						}
						if($pro->likemost_mc=='y')	$wheilike=LNG_MODEL;
						if(empty($wheilike))	{
							if($pro->likemost_graffiti=='y')	$wheilike=LNG_GRAFFITI;
						}	else	{
							if($pro->likemost_graffiti=='y')	$wheilike.="," . LNG_GRAFFITI;
						}
						if(empty($wheilike))	{
							if($pro->likemost_dj=='y')	$wheilike=LNG_ACTORS;
						}	else	{
							if($pro->likemost_dj=='y')	$wheilike.="," . LNG_ACTORS;
						}
						if(empty($wheilike))	{
							if($pro->likemost_breaking=='y')	$wheilike=LNG_BREAKING;
						}	else	{
							if($pro->likemost_breaking=='y')	$wheilike.="," . LNG_BREAKING;
						}
						if($pro->raplike_oldschool=='y')	$tkorap=LNG_OLD_SCHOOL;
						if(empty($tkorap))	{
							if($pro->raplike_raprock=='y')	$tkorap=LNG_RAP_ROCK;
						}	else	{
							if($pro->raplike_raprock=='y')	$tkorap.="," . LNG_RAP_ROCK;
						}
						if(empty($tkorap))	{
							if($pro->raplike_bootie=='y')	$tkorap=LNG_BOOTIE;
						}	else	{
							if($pro->raplike_bootie=='y')	$tkorap.="," . LNG_BOOTIE;
						}
						if(empty($tkorap))	{
							if($pro->raplike_mainstreamradio=='y')	$tkorap=LNG_M_RADIO;
						}	else	{
							if($pro->raplike_mainstreamradio=='y')	$tkorap.="," . LNG_M_RADIO;
						}
						if(empty($tkorap))	{
							if($pro->raplike_experimental=='y')	$tkorap=LNG_EXPERIMENTAL;
						}	else	{
							if($pro->raplike_experimental=='y')	$tkorap.="," . LNG_EXPERIMENTAL;
						}
						if(empty($tkorap))	{
							if($pro->raplike_underground=='y')	$tkorap=LNG_UNDER_GROUND;
						}	else	{
							if($pro->raplike_underground=='y')	$tkorap.="," . LNG_UNDER_GROUND;
						}
						if(empty($tkorap))	{
							if($pro->raplike_gangsta=='y')	$tkorap=LNG_GANGSTA;
						}	else	{
							if($pro->raplike_gangsta=='y')	$tkorap.="," . LNG_GANGSTA;
						}
						if(empty($tkorap))	{
							if($pro->raplike_club=='y')	$tkorap=LNG_CLUB;
						}	else	{
							if($pro->raplike_club=='y')	$tkorap.="," . LNG_CLUB;
						}
						if(empty($tkorap))	{
							if($pro->raplike_breaking=='y')	$tkorap=LNG_BREAKING;
						}	else	{
							if($pro->raplike_breaking=='y')	$tkorap.="," . LNG_BREAKING;
						}
						if(empty($tkorap))	{
							if($pro->raplike_other=='y')	$tkorap=LNG_OTHER;
						}	else	{
							if($pro->raplike_other=='y')	$tkorap.="," . LNG_OTHER;
						}
						$whathiptou=stripslashes($pro->whathiptou);
						$shoutouts=stripslashes($pro->shoutouts);
                    $description=array("I am a"=>$arua,"What element of hiphop I like most is"=>$wheilike,"The kind of rap I like is"=>$tkorap,"What is hiphop foe me"=>$whathiptou,"Shout Outs"=>$shoutouts,"Languages"=>$languages,"Personal Website"=>$website,"Favorite books"=>$books,"Favorite music"=>$music,"Favorite movies/tv"=>$movies,"I've traveled to"=>$travel,"Clubs"=>$clubs,"About me"=>$about,"I want to meet people for"=>$meet_people);
                   while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td></tr>";

                           }//if

                   }//while

                }//personal


                //professional
                elseif($type=="professional"){
                    $position=$pro->position;
                    if($position!=''){
                          $position="<a href='index.php?mode=search&act=simple&key=position&position=".stripslashes($position)."'>".stripslashes($position)."</a>";
                    }
					$company=$pro->company;
                    if($company!=''){
                          $company="<a href='index.php?mode=search&act=simple&key=company&company=".stripslashes($company)."'>".stripslashes($company)."</a>";
                    }
                    if($pro->industry!=''){
                    $sql_query="select name from industries where ind_id='$pro->industry'";
                    $ind=sql_execute($sql_query,'get');
					$industry=$ind->name;
                    }
                    else {
                      $industry='';
                    }

					$specialities=$pro->specialities;
                    if($specialities!=''){
                        $split=split(",",$specialities);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=specialities&specialities=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $specialities=rtrim($interest,',');
                    }
					$overview=$pro->overview;
					$skills=$pro->skills;
                    if($skills!=''){
                        $split=split(",",$skills);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=skills&skills=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $skills=rtrim($interest,',');
                      }
					$p_positions=$pro->p_positions;
                    if($p_positions!=''){
                        $split=split(",",$p_positions);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=p_positions&p_positions=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $p_positions=rtrim($interest,',');
                      }
					$p_companies=$pro->p_companies;
                    if($p_companies!=''){
                        $split=split(",",$p_companies);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=p_companies&p_companies=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $p_companies=rtrim($interest,',');
                      }
					$assotiations=$pro->assotiations;
                    if($associations!=''){
                        $split=split(",",$assotiations);
                        $interest='';
                        foreach($split as $word){
                        $interest.="<a href='index.php?mode=search&act=simple&key=assotiations&assotiations=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $assotiations=rtrim($interest,',');
                      }

                      $description=array ("Position/Title"=>$position,"Company"=>$company,"Industry"=>$industry,"Specialties"=>$specialities,"Overview"=>$overview,"Skills"=>$skills,"Past Positions"=>$p_positions,"Past Companies"=>$p_companies,"Associations"=>$assotiations);

                  while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td></tr>";

                           }//if

                   }//while

                }//professional
		//model
                elseif($type=="model"){
				$sql_mod="select * from models where mem_id='$mem_id'";
				$mods=sql_execute($sql_mod,'get');
				$height =$mods->height;
				$weight =$mods->weight;
				$skincolor =$mods->skincolor;
				$haircolor =$mods->haircolor;
				$shoesize =$mods->shoesize;
				$dresssize =$mods->dresssize;
				$bustsize =$mods->bustsize;
				$hips =$mods->hips;
				$waist =$mods->waist;
				$languages =$mods->languages;
				$shirtcollar =$mods->shirtcollar;
				$jacketsuit =$mods->jacketsuit;
				$inseam  =$mods->inseam;
				$interest  =$mods->interest;
                
					if($interest!=''){
                        $split=split(",",$interest);
                        $int1='';
                        foreach($split as $word){
                        $int1.="<a href='index.php?mode=search&act=simple&key=interest&interest=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $interest=rtrim($int1,',');
                      }
					if($languages!=''){
                        $split=split(",",$languages);
                        $int1='';
                        foreach($split as $word){
                        $int1.="<a href='index.php?mode=search&act=simple&key=languages&languages=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $languages=rtrim($int1,',');
                      }

                      $description=array ("Height"=>$height,"Weight"=>$weight,"Skin Color"=>$skincolor,"Hair Color"=>$haircolor,"Shoe Size"=>$shoesize,"Dress Size"=>$dresssize,"Bust Size"=>$bustsize,"Hips"=>$hips,"Waist"=>$waist,"Languages"=>$languages,"Shirt Collar"=>$shirtcollar,"Jacket Suit"=>$jacketsuit,"Inseam"=>$inseam,"Interest"=>$interest);

                  while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td></tr>";

                           }//if

                   }//while

                }//model
			//actor
                elseif($type=="actor"){
				$sql_mod="select * from actors where mem_id='$mem_id'";
				$mods=sql_execute($sql_mod,'get');
				$height =$mods->height;
				$weight =$mods->weight;
				$skincolor =$mods->skincolor;
				$haircolor =$mods->haircolor;
				$shoesize =$mods->shoesize;
				$dresssize =$mods->dresssize;
				$bustsize =$mods->bustsize;
				$hips =$mods->hips;
				$waist =$mods->waist;
				$languages =$mods->languages;
				$shirtcollar =$mods->shirtcollar;
				$jacketsuit =$mods->jacketsuit;
				$inseam  =$mods->inseam;
				$interest  =$mods->interest;
                
					if($interest!=''){
                        $split=split(",",$interest);
                        $int1='';
                        foreach($split as $word){
                        $int1.="<a href='index.php?mode=search&act=simple&key=interest&interest=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $interest=rtrim($int1,',');
                      }
					if($languages!=''){
                        $split=split(",",$languages);
                        $int1='';
                        foreach($split as $word){
                        $int1.="<a href='index.php?mode=search&act=simple&key=languages&languages=".stripslashes($word)."'>".stripslashes($word)."</a>,";
                        }
                        $languages=rtrim($int1,',');
                      }

                      $description=array ("Height"=>$height,"Weight"=>$weight,"Skin Color"=>$skincolor,"Hair Color"=>$haircolor,"Shoe Size"=>$shoesize,"Dress Size"=>$dresssize,"Bust Size"=>$bustsize,"Hips"=>$hips,"Waist"=>$waist,"Interest"=>$interest);

                  while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td></tr>";

                           }//if

                   }//while

                }//actor
			//music
                elseif($type=="music"){
				$sql_mod="select * from musicprofile where mem_id='$mem_id'";
				$mods=sql_execute($sql_mod,'get');
				$bandnam=$mods->bandnam;
				$genre=musical_genre($mem_id);
				$headline =$mods->headline;
				$bandbio =$mods->bandbio;
				$bandmembers=$mods->bandmembers;
				$influences =$mods->influences;
				$recordlabel=$mods->recordlabel;
				$description=array ("Band Name"=>$bandnam,"Genre"=>$genre,"Headline"=>$headline,"Band Bio"=>$bandbio,"Band Members"=>$bandmembers,"Influences"=>$influences,"Record Label"=>$recordlabel);
                  while(list($key,$val)=each($description)){

                           if($val!=''){

                                 echo "<tr><td>$key</td><td>$val</td></tr>";

                           }//if

                   }//while

                }//music


}//function

//shows testimonials on user
function show_testimonials($p_id,$m_id){
 $sql_query="select * from testimonials where mem_id='$p_id' and stat='a'";
 $num=sql_execute($sql_query,'num');
 if($num==0){
   echo "<p align=center class=body>";echo name_header($p_id,$m_id);echo LNG_NO_TESTMONIALS . "</p>";
 }
 else {
 $res=sql_execute($sql_query,'res');
 while($tst=mysql_fetch_object($res)){

    echo "<table vasilek><tr><td class=linedtd>";show_photo($tst->from_id);echo "</br>";
    show_online($tst->from_id);echo "</td>";
    $date=date("F d, Y",$tst->added);
    echo "<td valign=top class=body>$date</br>$tst->testimonial</td></table>";
 }//while
 }//else
}

//when showing form with radio or checkbox elements, functions chacks if it must be checked
function checked($val,$ch){
  if($val==$ch){
   echo " checked ";
  }
}

//showing user photo album
function photo_album($mem_id,$page,$mod){
    $page=$page-1;
    $sql_query="select photo_b_thumb,capture from photo where mem_id='$mem_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
    $main=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo_b_thumb);
    $photos=if_empty($photos);
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);
    $start=$page*6;
    $end=$start+10;
    if($end>count($photos)){
       $end=count($photos);
    }//if
    if($photos!=''){
	$cc=0;
    for($i=$start;$i<$end;$i++){
		if($main->photo_b_thumb==$photos[$i])	$main_set=LNG_MAIN_PHOTO;
        echo "<td><table class=linedtd>
        <tr><td align='center' class=body>$main_set<br><a href='index.php?mode=photo_album&act=view&pho_id=$i&p_id=$mem_id'><img src='$photos[$i]' border=0></a></td>
        <tr><td align='center' class=body>$captures[$i]</td>";
        if($mod=='edi'){
          echo "<tr><td align='center' class=body><a href='index.php?mode=user&act=del&type=photos&pro=edit&pho_id=$i'>Delete</a></td>";
        }
        echo "</table></td>";
		$cc+=1;
		if ($cc==5) 	{
			echo "<tr>";
			$cc=0;
		}
		$main_set="";

    }//for
    }//if
    else {
      echo LNG_NO_PHOTO_AVAILABLE;
    }

}//function
//showing user photo album
function photo_album_count($mem_id,$page,$mod){
    $page=$page-1;
	$cou=0;
    $sql_query="select photo_b_thumb,capture from photo where mem_id='$mem_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
    $main=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo_b_thumb);
    $photos=if_empty($photos);
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);
    $start=$page*6;
    $end=$start+10;
    if($end>count($photos)){
       $end=count($photos);
    }//if
    if($photos!=''){
    for($i=$start;$i<$end;$i++){
		$cou++;
    }//for
    }//if
	return $cou;
}//function
//Deleteing user photo album
function del_album($mem_id,$page,$mod,$cid){
	global $base_path,$main_url;
    $sql_query="select photo,photo_b_thumb,photo_thumb,capture from photo where mem_id='$mem_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from members where mem_id='$mem_id'";
    $main=sql_execute($sql_query,'get');
    $photo_b_thumb=split("\|",$pho->photo_b_thumb);
	$photo=split("\|",$pho->photo);
	$photo_thumb=split("\|",$pho->photo_thumb);
	$pho_cou=count($photo);
    $photo_b_thumb=if_empty($photo_b_thumb);
	$photo=if_empty($photo);
	$photo_thumb=if_empty($photo_thumb);
    $capture=split("\|",$pho->capture);
    $capture=if_empty($capture);
    if($pho_cou!=0){
		sql_execute($sql_query,'');
	    for($i=0;$i<$pho_cou;$i++){
		if($i!=$cid) {
			$photo_up.="|".$photo[$i];
			$photo_b_thumb_up.="|".$photo_b_thumb[$i];
			$photo_thumb_up.="|".$photo_thumb[$i];
			$capture_up.="|".$capture[$i];
		}	else	{
			if(file_exists("$photos[$i]")){
				@unlink("$photos[$i]");
			}
		}
		if($i!=$cid) {
		   if($main->photo_b_thumb==$photos[$i])	{
			   $sql_query="update members set photo='',photo_thumb='',photo_b_thumb='' where mem_id='$m_id'";
			   sql_execute($sql_query,'');
			}
		}
    }//for
	$sql_query="update photo set photo='".$photo_up."',photo_b_thumb='".$photo_b_thumb_up."',
	photo_thumb='".$photo_thumb_up."',capture='".$capture_up."' where mem_id='$mem_id'";
//	echo $sql_query;
	sql_execute($sql_query,'');
    }//if
}//function
//showing tribe photo album
function tribe_photo_album($trb_id,$page){
    $page=$page-1;
    $sql_query="select photo_b_thumb,capture from tribe_photo where trb_id='$trb_id'";
    $pho=sql_execute($sql_query,'get');
    $sql_query="select photo_b_thumb from tribes where trb_id='$trb_id'";
    $main=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo_b_thumb);
    $photos=if_empty($photos);
    $photos=array_unset($photos,"no");
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);
    $start=$page*6;
    $end=$start+10;
    if($end>count($photos)){
       $end=count($photos);
    }//if
    if($photos!=''){
    for($i=$start;$i<$end;$i++){
        echo "<td><table>
        <tr><td><a href='index.php?mode=photo_album&act=trb_view&pho_id=$i&trb_id=$trb_id'><img src='$photos[$i]' border=0></a></td>
        <tr><td align=center>$captures[$i]</td>
        </table></td>";
    }//for
    }//if
    else {
      echo LNG_NO_PHOTO_AVAILABLE;
    }

}//function

//drop-down list of user friends
function drop_friends($mem_id){
   $fr=count_network($mem_id,"1","ar");
   echo "<option value=''>" . LNG_SEL_A_FRIEND;
   if($fr!=''){
   foreach($fr as $frd){
      $sql_query="select fname from members where mem_id='$frd'";
      $f=sql_execute($sql_query,'get');
      echo "<option value='$frd'>$f->fname";
   }//foreach
   }//if

}//function

//drop-down list of tribe categories
function drop_t_cats($sel){
$sql_query="select name,t_cat_id from t_categories";
$res=sql_execute($sql_query,'res');
while($cat=mysql_fetch_object($res)){
   if($cat->t_cat_id=="$sel"){
   echo "<option selected value='$cat->t_cat_id'>$cat->name";
   }//if
   else {
   echo "<option value='$cat->t_cat_id'>$cat->name";
   }//else
}//while
}//function

//drop-down list of industries
function industry_drop($sel){
$sql_query="select * from industries";
$res=sql_execute($sql_query,'res');
while($ind=mysql_fetch_object($res)){
   echo "<option";
   if($ind->ind_id=="$sel"){
     echo LNG_SELECTED;
   }
   echo " value='$ind->ind_id'>";
   if(!ereg("_",$ind->name)){ echo "&nbsp;&nbsp;"; }
   echo "$ind->name</option>";
}//while


}//function

function show_friends_deg($m_id,$limit,$inline,$page,$deg){

    $friends=count_network($m_id,"$deg","ar");
    $friends=if_empty($friends);
    if($friends!=''){
    $start=($page-1)*$limit;
    $end=$start+$limit;
    if($end>count($friends)){
      $end=count($friends);
    }
    for($i=$start;$i<$end;$i++){
        $frd=$friends[$i];
        if(($i==0)||($i%$inline==0))
        {
           echo "<tr>";
        }//if
	    echo "<td width=65 height=75><table>";
	    echo "<tr><td align=center width=65>";
	    show_photo($frd);
        echo "</td>
        <tr><td align=center>";
        show_online($frd);
        echo "</td></table></td>";
    }//foreach
    }//if
    else {
       echo "<p align=center>" . LNG_NO_FRIENDS . "</p>";
    }//else

}//function
function delete_banner($id) {
	$sql_query="update banners set b_exp='Y' where b_id='$id'";
	sql_execute($sql_query,'');
}//function

function maketime ($hour,$minute,$second,$month,$date,$year){

       // This function can undo the Win32 error to calculate datas before 1-1-1970 (by TOTH = igtoth@netsite.com.br)
       // For centuries, the Egyptians used a (12 * 30 + 5)-day calendar
       // The Greek began using leap-years in around 400 BC
       // Ceasar adjusted the Roman calendar to start with Januari rather than March
       // All knowledge was passed on by the Arabians, who showed an error in leaping
       // In 1232 Sacrobosco (Eng.) calculated the error at 1 day per 288 years
       //    In 1582, Pope Gregory XIII removed 10 days (Oct 15-24) to partially undo the
       // error, and he instituted the 400-year-exception in the 100-year-exception, 
       // (notice 400 rather than 288 years) to undo the rest of the error
       // From about 2044, spring will again coincide with the tropic of Cancer
       // Around 4100, the calendar will need some adjusting again
   
       if ($hour === false)  $hour  = Date ("G");
       if ($minute === false) $minute = Date ("i");
       if ($second === false) $second = Date ("s");
       if ($month === false)  $month  = Date ("n");
       if ($date === false)  $date  = Date ("j");
       if ($year === false)  $year  = Date ("Y");
   
       if ($year >= 1970) return mktime ($hour, $minute, $second, $month, $date, $year);
   
       //    date before 1-1-1970 (Win32 Fix)
       $m_days = Array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
       if ($year % 4 == 0 && ($year % 100 > 0 || $year % 400 == 0))
       {
           $m_days[1] = 29; // non leap-years can be: 1700, 1800, 1900, 2100, etc.
       }
   
       //    go backward (-), based on $year
       $d_year = 1970 - $year;
       $days = 0 - $d_year * 365;
       $days -= floor ($d_year / 4);          // compensate for leap-years
       $days += floor (($d_year - 70) / 100);  // compensate for non-leap-years
       $days -= floor (($d_year - 370) / 400); // compensate again for giant leap-years
           
       //    go forward (+), based on $month and $date
       for ($i = 1; $i < $month; $i++)
       {
           $days += $m_days [$i - 1];
       }
       $days += $date - 1;
   
       //    go forward (+) based on $hour, $minute and $second
       $stamp = $days * 86400;
       $stamp += $hour * 3600;
       $stamp += $minute * 60;
       $stamp += $second;
   
       return $stamp;
}

function show_flag($id)	{
	$sql_query="select * from members where mem_id='$id'";
	$row=sql_execute($sql_query,'get');
	echo stripslashes($row->country);
}

function show_recentmembers()	{
	$sql_query="select * from members order by mem_id desc limit 0,3";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		echo "<table width=100%>";
		while($row=mysql_fetch_object($res))	{
			echo "<tr><td rowspan='3' align=right>";
			echo show_photo_home($row->mem_id);
			echo "</td><td colspan='2'>&nbsp;<a href='index.php?mode=people_card&p_id=$row->mem_id'>".stripslashes($row->profilenam)."</a></td></tr>";
			echo "<tr><td align=left>&nbsp;".stripslashes($row->ad_notes)."</td><td align=right>";
			echo show_flag($row->mem_id);
			echo "&nbsp;</td></tr>";
			echo "<tr><td colspan='2' align=left>&nbsp;";
			echo show_personality($row->mem_id,"img");
			echo show_legit($row->mem_id);
			echo "</td></tr>";
		}
		echo "</table>";
	}
}

function show_recenttest()	{
	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

	$replace = array ("","","\\1","\"","&","<",">"," ",chr(161),chr(162),chr(163),chr(169),"chr(\\1)");
	$sql_query="select * from testimonials where stat='a' order by added desc limit 0,2";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			echo "<table vasilek><tr><td rowspan='3' valign=top>";
			echo show_photo_home($row->mem_id);
			echo "<td valign=top>&nbsp;";
			echo show_memnam($row->mem_id);
			echo "</td></tr><tr><td valign=top>";
			echo "&nbsp;" . LNG_POSTED_BY;
			echo show_memnam($row->from_id);
			echo "&nbsp;" . LNG_ON . "&nbsp;".date("F d, Y",$row->added);
			echo "</td></tr><tr><td><p style='margin-left:3'>".preg_replace($search,$replace,substr(stripslashes($row->testimonial),0,200))."...</p></td></tr></table>";
		}
	}
}

function show_photo_home($m_id)	{
	if($m_id=='anonim')	echo "<img src='images/unknownUser_th.jpg' width='50' height='60' border='0'>";
	else	{
		$sql_query="select photo_thumb from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		if($mem->photo_thumb=='no')	$mem->photo_thumb="images/unknownUser_th.jpg";
		else                        $mem->photo_thumb=$mem->photo_thumb;
		echo "<a href='index.php?mode=people_card&p_id=$m_id'><img src='$mem->photo_thumb' border='0'></a>";
	}
}
function mem_zip($id)	{
	$sql_query="select zip from members where mem_id='$id'";
	$res=mysql_query($sql_query);
	if(mysql_num_rows($res))	{
		$mem=sql_execute($sql_query,'get');
		return $mem->zip;
	}	else	return '';
}

//splitting pages
function page_nums($sql_query,$url,$page,$limit)	{
	
	global $lng_id;
	
	$res=sql_execute($sql_query,'res');
	$nums=mysql_num_rows($res);
	if(mysql_num_rows($res))	{
		$nop=ceil($nums/$limit);
		$cb=floor(($page-1)/$limit)+1;
		$j=($cb-1)*$limit+1;
		if($nums%$limit==0)	$pages=$nums/$limit;
		else	$pages=(int)($nums/$limit)+1;	
		$first="<a href='$url&page=";
		$mid="'>";
		$last="</a>";
		echo $first."1&lng=".$lng_id.$mid."<<".$last."&nbsp;&nbsp;";
		
		if($page!='1')	echo $first.($page-1)."&lng=" .$lng_id.$mid."<".$last;
		echo "&nbsp;&nbsp;&nbsp;";
		for($i=$j; (($i<$j+$limit) and ($i<=$nop)); $i++) {
			if($i==$page)	echo "<b>";
			echo $first.$i."&lng=".$lng_id.$mid."$i".$last."&nbsp;&nbsp;";
			if($i==$page)	echo "</b>";
			$nex=$i;
      	}//for
		echo "&nbsp;&nbsp;&nbsp;";
		if($pages!=$page)	echo $first.($nex+1)."&lng=".$lng_id.$mid.">".$last."&nbsp;&nbsp;";
		echo $first.$pages."&lng=".$lng_id.$mid.">>".$last."&nbsp;&nbsp;";
	}
}

function mem_profilenam($id)	{
	$sql_query="select profilenam from members where mem_id='$id'";
	$res=mysql_query($sql_query);
	if(mysql_num_rows($res))	{
		$mem=sql_execute($sql_query,'get');
		echo $mem->profilenam;
	}	else	echo '';
}

function cool_mmem()	{
	$sql_query="select * from members where ban='n' and verified='y' and featured='y' and gender='m'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$mem=sql_execute($sql_query,'get');
		echo show_photo($mem->mem_id);
		echo "<br>";
		echo show_online($mem->mem_id);
	}
}

function cool_fmem()	{
	$sql_query="select * from members where ban='n' and verified='y' and featured='y' and gender='f'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$mem=sql_execute($sql_query,'get');
		echo show_photo($mem->mem_id);
		echo "<br>";
		echo show_online($mem->mem_id);
	}
}

function fe_grp()	{
	$sql_query="select * from tribes where feat='y'";
	$res_query=mysql_query($sql_query);
	if(mysql_num_rows($res_query))	{
		echo "<table cellpadding='0' cellspacing='0' class='lined'>";
		echo "<tr><td height='22' colspan='2' class='title'>&nbsp;Featured Tribe</td></tr><tr><td align='center'>";
		echo "<table align='center'><tr>";
		$row=mysql_fetch_object($res_query);
		echo "<td align='center' class='table_home_lined body'>";
		echo stripslashes($row->name);
		echo "<br>";
		echo show_tribe_home($row->trb_id);
		echo "</td>";
		echo "</tr></table></td><td>&nbsp;</td></tr></table>";
	}
}

//showing tribe main photo
function show_tribe_home($trb_id)	{
	$sql_query="select photo_b_thumb from tribes where trb_id='$trb_id'";
	$trb=sql_execute($sql_query,'get');
	if($trb->photo_b_thumb=='no')	$trb->photo_b_thumb="images/unknownUser.jpg";
	echo "<a href='index.php?mode=tribe&act=show&trb_id=$trb_id'><img src='$trb->photo_b_thumb' border=0></a>";
}

function cool_blog()	{
	$sql_query="select * from blogs group by blog_own order by blog_dt desc limit 0,10";
	$res_query=mysql_query($sql_query);
	if(mysql_num_rows($res_query))	{
		$sp=0;
		echo "<table cellpadding='0' cellspacing='0' class='lined' width='96%' align='center'>";
		echo "<tr><td height='22' colspan='2' class='title'>&nbsp;Cool Circles</td></tr><tr><td align='center'>";
		echo "<table width='100%' class='body'>";
		while($row=mysql_fetch_object($res_query))	{
			if($sp==0)	echo "<tr>";
			echo "<td class='body action'>";
			echo date("m/d/Y h:i A",$row->blog_dt);
			echo "&nbsp;&nbsp;-&nbsp;&nbsp;";
			echo blog_own($row->blog_own);
			echo "</td>";
			$sp=$sp+1;
			if($sp==2)	{
				echo "</tr>";
				$sp=0;
			}
		}
		echo "</tr></table></td><td>&nbsp;</td></tr></table>";
	}
}

function blog_own($id)	{
	global $main_url;
	$sql_query="select profilenam from members where mem_id='$id'";
	$res=mysql_query($sql_query);
	if(mysql_num_rows($res))	{
		$row=sql_execute($sql_query,'get');
		echo "<a href='$main_url/blog/$row->profilenam'>$row->profilenam</a>";
	}
}

function blog_fold($id)	{
	global $main_url;
	$sql_query="select profilenam from members where mem_id='$id'";
	$res=mysql_query($sql_query);
	if(mysql_num_rows($res))	{
		$row=sql_execute($sql_query,'get');
		$ret=$row->profilenam;
	}	else	$ret='';
	return $ret;
}

function cool_music()	{
	$sql_query="select * from musics where cool_alb='y'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		$muc=sql_execute($sql_query,'get');
		echo "<table cellpadding='0' cellspacing='0' class='lined' width='96%' align='center'>";
		echo "<tr><td height='22' colspan='2' class='title'>&nbsp;Cool Music</td></tr><tr><td align='center'>";
		echo "<table width='100%' class='body' cellpadding='3' cellspacing='3'>";
		echo "<tr><td class='body action' align='center'>";
		if(!empty($muc->photo_b_thumb))	echo "<img src='$muc->photo_b_thumb'>";
		echo "<br><b>".stripslashes($muc->m_title)."</b></td>";
		echo "<td valign='top'><b>".stripslashes($muc->m_title)."</b><br>";
		echo name_header($muc->m_own,'ad');
		echo "<br><br>".stripslashes($muc->m_matt)."</td>";
		echo "</tr><tr><td colspan='2' class='body' align='right'>[<a href='index.php?mode=music'>More Music</a>]  </td></tr></table></td><td>&nbsp;</td></tr></table>";
	}
}

function check_banorcod($type)	{
	$sql_query="select banorcod from ad_code where type='$type'";
	$stt=sql_execute($sql_query,'get');
	return $stt->banorcod;
}

function dis_cod($type,$width,$height)	{
	$sql_query="select adv_code from ad_code where type='$type'";
	$stt=sql_execute($sql_query,'get');
	echo "<table width='$width' height='$height' border='0' cellspacing='0' cellpadding='0'><tr>
	<td align='center' valign='middle'>".stripslashes($stt->adv_code)."</td></tr></table>";
}

function show_music_cat1($id)	{
	$sql_query="select * from m_categories order by name";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			if($id==$row->m_cat_id)	echo "<option value='$row->m_cat_id' selected>".stripslashes($row->name)."</option>";
			else	echo "<option value='$row->m_cat_id'>".stripslashes($row->name)."</option>";
		}
	}
}

function music_show_cat($id)	{
	$sql_query="select * from m_categories where m_cat_id='$id'";
	$row=sql_execute($sql_query,'get');
	echo stripslashes($row->name);
}

function selected($val,$ch)	{
  if($val==$ch)	echo LNG_SELECTED;
}



function getSelected($val,$ch)	{
  if($val==$ch)	echo LNG_SELECTED;
}

function hr($val)	{
	$ar=array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","00");
	for($i=0; $i<=count($ar)-1; $i++)	{
?>
	<option value="<?=$ar[$i]?>"<? echo selected($ar[$i],$val); ?>><?=$ar[$i]?></option>
<?
	}
}

function mins($val)	{
	$ar=array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
		for($i=0; $i<=count($ar)-1; $i++)	{
?>
	<option value="<?=$ar[$i]?>"<? echo selected($ar[$i],$val); ?>><?=$ar[$i]?></option>
<?
	}
}

function fetaured_art()	{
	global $main_url;
	$sql_query="select musicprofile.banner,members.profilenam from musicprofile,members where musicprofile.mem_id=members.mem_id and members.f_artist='y'";
	$bann=sql_execute($sql_query,'get');
	echo "<a href='$main_url/members/".stripslashes($bann->profilenam)."' target='_blank'><img src='$bann->banner' border='0' width='450' height='220'></a>";
}

function musical_link($m_id)	{
	global $main_url;
	$sql_query="select musicprofile.bandnam,members.profilenam from musicprofile,members where musicprofile.mem_id=members.mem_id and members.mem_id='$m_id'";
	$bann=sql_execute($sql_query,'get');
	echo "<span class='action'><a href='$main_url/members/".stripslashes($bann->profilenam)."'>".stripslashes($bann->bandnam)."</a></span>";
}

function musical_genre($m_id)	{
	global $main_url;
	$sql_query="select genre1,genre2,genre3 from musicprofile where mem_id='$m_id'";
	$bann=sql_execute($sql_query,'get');
	echo music_show_cat($bann->genre1);
	echo " / ";
	echo music_show_cat($bann->genre2);
	echo " / ";
	echo music_show_cat($bann->genre3);
}

function recent_album()	{
	$sql_query="select * from musics order by m_dt desc limit 0,1";
	$music=sql_execute($sql_query,'get');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
<tr> 
<td valign="top">
<? if(!empty($music->photo_b_thumb)) { ?><img src="<?=$music->photo_b_thumb?>" border="0" align="left"><span style="padding-left: 5"><? } ?>
<br><? echo musical_link($music->m_own); ?><br>
<a href="index.php?mode=music&act=songlist&mu_id=<?=$music->m_id?>"><strong><?=stripslashes($music->m_title)?></strong></a><br>
<? echo musical_genre($music->m_own); ?><br><br>
<div align="justify"><?=stripslashes($music->m_matt)?></div>
<? if(!empty($music->photo_b_thumb)) { ?></span><? } ?>
</td>
</tr>
</table>
<?
}

function cool_album()	{
	$sql_query="select * from musics where cool_alb='y'";
	$music=sql_execute($sql_query,'get');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
<tr> 
<td valign="top">
<? if(!empty($music->photo_b_thumb)) { ?><img src="<?=$music->photo_b_thumb?>" border="0" align="left"><span style="padding-left: 5"><? } ?>
<br><? echo musical_link($music->m_own); ?><br>
<a href="index.php?mode=music&act=songlist&mu_id=<?=$music->m_id?>"><strong><?=stripslashes($music->m_title)?></strong></a><br>
<? echo musical_genre($music->m_own); ?><br><br>
<div align="justify"><?=stripslashes($music->m_matt)?></div>
<? if(!empty($music->photo_b_thumb)) { ?></span><? } ?>
</td>
</tr>
</table>
<?
}

function show_music_cat($id)	{
	$sql_query="select * from m_categories order by name";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			if($id==$row->m_cat_id)	echo "<option value='$row->m_cat_id' selected>".stripslashes($row->name)."</option>";
			else	echo "<option value='$row->m_cat_id'>".stripslashes($row->name)."</option>";
		}
	}
}

function show_music_catdisp($id)	{
	$sql_query="select * from m_categories where m_cat_id='$id'";
	$row=sql_execute($sql_query,'get');
	echo stripslashes($row->name);
}

function show_location($id)	{
	$sql_query="select * from members where mem_id='$id'";
	$row=sql_execute($sql_query,'get');
	if($row->showloc==1)	{
		if($row->country!='United States')	$location=$row->country;
		else	{
			$sql_query="select city,state from zipData where zipcode='$row->zip'";
			$num=sql_execute($sql_query,'num');
			if($num==0)	$location=$row->country;
			else	{
				$loc=sql_execute($sql_query,'get');
				$city=strtolower($loc->city);
				$city=ucfirst($city);
				$location=$city.", ".$loc->state;
			}
		}
		echo $location;
	}	else	echo "";
}

function user_profile_updated($id,$for)	{
	$sql_query="select updated from profiles where mem_id='$id'";
	$prof=sql_execute($sql_query,'get');
	$updated=date("$for",$prof->updated);
	echo $updated;
}

function musical_band($m_id)	{
	$sql_query="select bandnam from musicprofile where mem_id='$m_id'";
	$bann=sql_execute($sql_query,'get');
	echo stripslashes($bann->bandnam);
}

function show_views($id)	{
	$sql_query="select * from members where mem_id='$id'";
	$mem=sql_execute($sql_query,'get');
	$temp=split("\|",$mem->views);
	$temp=array_unique($temp);
	echo count($temp);
}

function show_from_members($fiel,$id)	{
	$sql_query="select * from members where mem_id='$id'";
	$mem=sql_execute($sql_query,'get');
	return $mem->$fiel;
}

function show_from_profile($fiel,$id)	{
	$sql_query="select * from profiles where mem_id='$id'";
	$mem=sql_execute($sql_query,'get');
	return $mem->$fiel;
}

function show_from_musicprofile($fiel,$id)	{
	$sql_query="select * from musicprofile where mem_id='$id'";
	$mem=sql_execute($sql_query,'get');
	return $mem->$fiel;
}

function show_visit_like($lik,$m_id)	{
	$sql_query="select visit from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$visit=date($lik,$mem->visit);
	echo $visit;
}

function auto_play($id)	{
	$sql_song="select * from songs where s_own='$id' and autoplay='y'";
	$res_song=sql_execute($sql_song,'res');
	if(mysql_num_rows($res_song))	{
		$song=sql_execute($sql_song,'get');
		$songno=$song->s_id;
		$alb=$song->s_sec;
		$player="<iframe src=\"play.php?play=$songno&cat=$alb&tt=$track\" name=\"player\" width=\"295\" height=\"220\" marginwidth=\"0\" marginheight=\"0\"></iframe>";
	}	else	{
		$sql_songs="select * from songs where s_own='$id'";
		$res_songs=sql_execute($sql_songs,'res');
		if(mysql_num_rows($res_songs))	{
			$dis=array();
			while($row_songs=mysql_fetch_object($res_songs))	{
				$dis[]=$row_songs->s_id;
			}
			$tak=rand(0,(count($dis)-1));
			$sql_tak="select * from songs where s_id='$dis[$tak]'";
			$row_tak=sql_execute($sql_tak,'get');
			$songno=$row_tak->s_id;
			$alb=$row_tak->s_sec;
			$player="<iframe src=\"play.php?play=$songno&cat=$alb&tt=$track\" name=\"player\" width=\"295\" height=\"220\" marginwidth=\"0\" marginheight=\"0\"></iframe>";
		}	else	$player="";
	}
	echo $player;
}

function show_blogs($id,$limit)	{
	$sql_query="select * from blogs where blog_own='$id' order by blog_dt desc limit 0,$limit";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" class=\"body\">";
		while($row=mysql_fetch_object($res))	{
			echo "<tr>";
			if(!empty($row->blog_img))	echo "<td><a href='index.php?mode=blogs&act=viewimg&seid=$row->blog_id'><img src='".$row->blog_img."' border='0'><a></td><td>";
			else	echo "<td colspan='2'>";
			echo "<strong>".stripslashes($row->blog_title)."</strong><br>";
			echo date("m/d/Y h:i A",$row->blog_dt);
			echo "<br><br>".substr(stripslashes($row->blog_matt),0,200)."...";
			echo "</td></tr>";
		}
		echo "</table>";
	}
}

function dis_filesize($filename)	{
	$fp=fopen($filename,"r");
	fseek($fp,filesize($filename)-128);
	$f_size=number_format(filesize($filename)/1000,2);
	fclose($fp);
	echo $f_size;
}

function my_friends($id,$limit)	{
	$sql_query="select frd_id from network where mem_id='$id'";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		while($row=mysql_fetch_object($res))	{
			$frd_id[]=$row->frd_id;
		}
		if(empty($limit))	$limit=count($frd_id);
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"2\" class=\"body\">";
		for($i=0; $i<$limit; $i++)	{
			echo "<tr><td align=\"center\">";
			echo show_photo($frd_id[$i]);
			echo "<br>";
			echo show_online($frd_id[$i]);
			echo "</td></tr>";
		}
		echo "</table>";
	}	else	echo "<p align=\"center\" class=\"body\">" . LNG_NO_FRIENDS . "</p>";
}

function play_song($id)	{
	$sql_songs="select * from songs where s_sec='$id'";
	$res_songs=sql_execute($sql_songs,'res');
	if(mysql_num_rows($res_songs))	{
		$dis=array();
		while($row_songs=mysql_fetch_object($res_songs))	{
			$dis[]=$row_songs->s_id;
		}
		$tak=rand(0,(count($dis)-1));
		$sql_tak="select * from songs where s_id='$dis[$tak]'";
		$row_tak=sql_execute($sql_tak,'get');
		$songno=$row_tak->s_id;
		$alb=$row_tak->s_sec;
		$player="<iframe src=\"play.php?play=$songno&cat=$alb&tt=$track\" name=\"player\" width=\"295\" height=\"220\" marginwidth=\"0\" marginheight=\"0\"></iframe>";
	}	else	$player="";
	echo $player;
}

function main_mems($typ,$mf)	{
	$mems=array();
	switch($typ)	{
		case 'featured':
			$sql_query="select mem_id from members where f_artist='y' order by joined desc limit 0,1";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				while($row=mysql_fetch_object($res))	{
					array_push($mems,$row->mem_id);
				}
				$mems=array_unique($mems);
			}
			break;
		case 'model':
			$sql_query="select members.mem_id from members,profiles where members.mem_id=profiles.mem_id and profiles.aua_producer='y' order by members.joined desc limit 0,1";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				while($row=mysql_fetch_object($res))	{
					array_push($mems,$row->mem_id);
				}
				$mems=array_unique($mems);
			}
			break;
		case 'musian':
			$sql_query="select members.mem_id from members,profiles where members.mem_id=profiles.mem_id and profiles.aua_musician='y' order by members.joined desc limit 0,1";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				while($row=mysql_fetch_object($res))	{
					array_push($mems,$row->mem_id);
				}
				$mems=array_unique($mems);
			}
			break;
		case 'actacts':
			$sql_query="select members.mem_id from members,profiles where members.mem_id=profiles.mem_id and profiles.aua_dj='y' order by members.joined desc limit 0,1";
			$res=sql_execute($sql_query,'res');
			if(mysql_num_rows($res))	{
				while($row=mysql_fetch_object($res))	{
					array_push($mems,$row->mem_id);
				}
				$mems=array_unique($mems);
			}
			break;
	}
	if(count($mems)>0)	{
		if(count($mems)>1)	{
			$tak=rand(1,count($mems)-1);
			$mem_id=$mems[$tak];
		}	else	$mem_id=$mems[0];
		if($mem_id!='')	return $mem_id;
		else return '';
	}
}

function show_age($id)	{
	$sql_query="select showage,birthday from members where mem_id='$id'";
	$mem=sql_execute($sql_query,'get');
	if($mem->showage=="0")	$age='';
	else	{
		$now=time();
		$was=$mem->birthday;
		$dif=$now-$was;
		$age=date("Y",$dif)-1970;
	}
	return $age;
}

function home_events($no)	{
	global $cat;
	$sql_query="select * from event_list where even_cat='$cat' and even_active='Y' order by even_dt desc limit 0,$no";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		echo "<tr><td class=\"heading\" height=\"15\"><font face=\"Arial, Helvetica, sans-serif\" size=\"3\" color=\"#3399FF\"><b><font color=\"#003366\">" . LNG_EVENTS . "</font></b></font></td></tr>";
		echo "<tr><td class=\"main-text\">";
		while($row=mysql_fetch_object($res))	{
			echo "<li><a href=\"index.php?mode=events&act=viewevent&seid=$row->even_id\">".stripslashes($row->even_title)."</a></li>";
		}
		echo "<div align=\"right\"><a href=\"index.php?mode=events\"><img src=\"images/more.gif\" alt=\"\" border=\"0\" width=\"72\" height=\"26\"></a></div></td></tr>";
	}
}

function home_news($no)	{
	$sql_query="select * from news order by id desc limit 0,$no";
	$res=sql_execute($sql_query,'res');
	if(mysql_num_rows($res))	{
		echo "<tr><td class=\"heading\"><font size=\"3\" face=\"Arial, Helvetica, sans-serif\"><b><font color=\"#003366\">" . LNG_NEWS . "</font></b></font></td></tr>";
		while($row=mysql_fetch_object($res))	{
			if($row->photo_thumb!='')	$tmp="<img src=\"$row->photo_thumb\" border=\"0\" style=\"padding: 25\" align=\"left\">";
			else	$tmp="";
			echo "<tr><td class=\"main-text\" align=\"justify\" height=\"185\">$tmp<strong><a href=\"$row->link\" target=\"_blank\">".stripslashes($row->title)."<a></strong><br><br>".stripslashes($row->matt)."<br><br></td></tr>";
		}
	}
}

//E-mail validation
function is_email_valid($email) { 
  if(eregi("^[a-z0-9._-]+@+[a-z0-9._-]+.+[a-z]{2,3}$", $email)) return 1; 
  else return 0; 
}
?>
