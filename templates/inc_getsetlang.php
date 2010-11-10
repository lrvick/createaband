<?
$uriR = $_ENV["REQUEST_URI"];
$spUri = explode("/", $uriR);
$file_path = "";
for($i=0; $i<(count($spUri)-1); $i++)
{
	if($i>0)
	{
		$file_path .= "../";
	}
	else
	{
		$file_path = "./";
	}
}

$file_path = $file_path . "lang/"; 

function getSetLangage($pg_id)
{
	global $file_path;
	
	if ($pg_id == 0)
	{		
		require $file_path . "english.php";
	}
	
	if ($pg_id == 1)
	{		
		require $file_path . "french.php";
	}

	if ($pg_id == 2)
	{		
		require $file_path . "spanish.php";
	}
		
	return $pg_id;
}

?>