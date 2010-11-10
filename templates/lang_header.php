<?
require('inc_getsetlang.php');
global $cookie_url;

$lp = $_ENV["REQUEST_URI"];
//echo "<br>======>" . $lp;

if(isset($_GET["lng"]))
{	
	$lngWhat = $_GET["lng"];	
}
else
{
	if(isset($_COOKIE["lang"]))
	{
		$lngWhat = $_COOKIE["lang"];		
	}
	else
	{
		$lngWhat = 0;
	}
}

$lng_id = getSetLangage($lngWhat);
if(isset($_COOKIE["lang"]))
{
	$lngid = $_COOKIE["lang"];
	if($lngid != $lng_id)
	{
		setcookie("lang", $lng_id);		
	}		
}
else
{
	setcookie("lang", $lng_id);
}

function getCurentpage()
{
	$urlStr = $_ENV["REQUEST_URI"];
	$splitStr = explode("/", $urlStr);
	
	$splitDotStr = explode(".", $splitStr[1]);
	
	if(count($splitDotStr) == 1)
	{
		$currPage = "index.php?lng=";
	}
	else
	{
		$urlQryStr = $_ENV["QUERY_STRING"];
		if($urlStr == "/")
		{
			$currPage = "index.php?lng=";
		}
		else
		{
			$splitUrl = explode("?", $urlStr);
			$reSplitUrl = explode("/", $splitUrl[0]);
			$page = $reSplitUrl[1];
			if($urlQryStr == "")
			{
				$currPage = $page . "?lng=";
			}
			else
			{
				$splitQryUrl = explode("=", $urlQryStr);		
				$lastQry = explode("&", $splitQryUrl[count($splitQryUrl)-2]);
				$foundLast = $lastQry[count($lastQry)-1];
				
				$splitQryUrl1 = explode("&", $urlQryStr);		
				$lastQry1 = $splitQryUrl1[count($splitQryUrl1)-1];
				
				if($foundLast == "lng")
				{
					$qrryStr = substr($urlQryStr, 0, strlen($urlQryStr)-strlen($lastQry1));
					$currPage = $page . "?" .  $qrryStr . "lng=";
				}
				else
				{
					$currPage = $page . "?" .  $urlQryStr . "&lng=";
				}
			}
		}
	}	
	return $currPage;
}
?>