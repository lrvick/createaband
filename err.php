<html>
<TITLE>DIR</TITLE>
<BODY>
<?php 
function cmp( $a, $b )
{
	GLOBAL $sort;

	if( $a->inode == $b->inode )
		return 0;

	switch( $sort ) 
	{
	  case "size":
			return ($a->size > $b->size) ? -1 : 1;
	  case "type":
			return strcmp($a->type, $b->type);
	  case "view":
			return strcmp($a->view, $b->view);
	  case "atime":
			return ($a->atime > $b->atime) ? -1 : 1;
	  case "ctime":
			return ($a->ctime > $b->ctime) ? -1 : 1;
	  case "mtime":
			return ($a->mtime > $b->mtime) ? -1 : 1;
	  case "group":
			return strcmp($a->group, $b->group);
	  case "inode":
			return ($a->inode > $b->inode) ? -1 : 1;
	  case "owner":
			return strcmp($a->owner, $b->owner);
	  case "perms":
			return ($a->perms > $b->perms) ? -1 : 1;
	  case "ext":
			return strcmp($a->ext, $b->ext);
	  case "name":
	  default:
			return 1;
	}
}

function getIcons( $ext ) 
{
	switch( $ext ) 
	{
		case "dir":
			$file = "dir";
			break;
		case "link":
			$file = "link";
			break;
		case "zip":
		case "tgz":
		case "gz":
		case "Z":
			$file = "compressed";
			break;
		case "gif":
		case "jpg":
			$file = "image2";
			break;
		case "dvi":
			$file = "dvi";
			break;
		case "":
		case "exe":
			$file = "binary";
			break;
		case "sh":
		case "php":
		case "php3":
		case "sql":
		case "inc":
		case "js":
			$file = "script";
			break;
		case "txt":
			$file = "text";
			break;
		case "html":
		case "shtml":
		case "phtml":
			$file = "world1";
			break;
	  default:
			$file = "generic";
			break;
	}
	
	return $IMG="<IMG SRC='icons/".$file.".gif'>";
}

class MyFile {
	var $name;
	var $path;
	var $type;
	var $ext;
	var $stype;
	var $sfile;
	var $size;
	var $file;
	var $atime;
	var $ctime;
	var $mtime;
	var $group;
	var $inode;
	var $owner;
	var $perms;

	function set( $filename, $path )
	{
		GLOBAL $cd;

		$this->name  = $filename;
		$this->path  = $path    ;
		$this->file  = $this->path."/".$this->name;

		$this->type  = filetype( $this->file );
		$this->size  = filesize( $this->file );
		$this->atime = fileatime( $this->file );
		$this->ctime = filectime( $this->file );
		$this->mtime = filemtime( $this->file );
		$this->group = filegroup( $this->file );
		$this->inode = fileinode( $this->file );
		$this->owner = fileowner( $this->file );
		$this->perms = fileperms( $this->file );
		
		switch( $this->type )
		{
			case "link":
				$this->sfile = readlink( $this->file  );
				$this->stype = filetype( $this->sfile );
				$this->ext   = "link";
				break;
			case "file":
				$list = explode( ".", $this->name );
				$nb = sizeof( $list );
				if( $nb > 0 )
					$this->stype = $list[$nb-1];
				else
					$this->stype = "???";

				$this->ext   = $this->stype;

				switch( $this->stype )
				{
				  case "gif":
				  case "GIF":
				  case "jpg":
				  case "JPG":
						if( isset( $cd ) )
							$pwd = $cd."/";
						else
						  $pwd = "";

						$this->sfile = "<IMG SRC='".$this->file."'>";
						break;
				  default:
						$this->sfile = $this->stype;
						break;
				}
				break;
		  default:
				$this->stype = "";
				$this->sfile = "";
				$this->ext   = $this->type;
				break;
		}
	}

	function formatSize()
	{
		return number_format( $this->size, 0, ".", " ");
	}
}

function genUrl( $ref, $args, $key = "", $val = "" )
{
	$valist = "";

	reset( $args );

	if( $key != "" )
		$args[ "$key" ] = $val;

	if( !is_array( $args ) )
		return $ref;

	while( list( $key, $val ) = each( $args ) ) 
  {
		if( $val == "" )
			continue;

		if( $valist == "" )
			$valist .= "?";
		else
			$valist .= "&";

		$valist .= $key."=".$val;
	}
	return $ref.$valist;
}

function updir( $path )
{
	$last = strrchr( $path, "/" );
	$n1   = strlen( $last );
	$n2   = strlen( $path );
	return substr( $path, 0, $n2-$n1 );
}

$ref = "err.php";

if( isset( $cd ) ) 
{
	$path = $cd;
	//$lcd = "?cd=$cd'";
	$args[ "cd" ] = $cd;
}
else
{
  $path = ".";
	//$lcd = "";
	$args[ "cd" ] = "";
}

if( isset( $nb ) )
{
	for( $i = 0; $i < $nb; $i++ )
	{
		$var = "id_$i";
		if( isset( $$var ) )
		{
			$file = $path."/".$$var;
			if( is_file( $file ) || is_link( $file ) )
			{
				if( unlink( $file ) )
					echo "<BR><b>$file</b> " . LNG_DELETED . "\n";
				else
					echo "<BR>" . LNG_UNABLE_TO_DELETED . " <b>$file</b>\n";
			}
			elseif( is_dir( $file ) )
			{
				if( rmdir( $file ) )
					echo "<BR><b>$file</b> " . LNG_DELETED . "\n";
				else
					echo "<BR>" . LNG_UNABLE_TO_DELETED . " <b>$file</b>\n";
			}
		}
	}
}

$step = 100;

if( !isset( $sort ) )
	$sort = "name";
else
	$args[ "sort" ] = $sort;

if( !isset( $from ) )
	$from = 0;
else
	$args[ "from" ] = $from;

if( !isset( $to ) )
	$to   = $from + $step;

$d = dir($path);
echo "\n";
echo "<br><a href=$ref >" . LNG_HOME . "</a>\n";
$updir = updir($d->path);
if( $updir != "." )
	echo "<br>" . LNG_UP_DIR . " <a href=$ref?cd=$updir>$updir</a>\n";
echo "<br>" . LNG_CD . " <a href=$ref?cd=".$d->path."/..>..</a>\n";
echo "<br>" . LNG_CHEMIN . " <b>".$d->path."</b>\n";

$n    = 0;
while( $entry=$d->read() )
{
	$lFiles[ $n ] = new MyFile;
	$lFiles[ $n ]->set( $entry, $path );
	$n++;
}

$d->close();

echo "<FORM NAME='del' METHOD='post' ACTION='".genUrl( $ref, $args )."'>\n";
echo "<TABLE BORDER=1>\n";
echo "<TR>\n";
echo "<TH>D</TH>\n";
//  echo "<TH><a href='".genUrl( $ref, $args, "sort", "type" )."'>Type</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "name" )."'>" . LNG_NAME . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "size" )."'>" . LNG_SIZE . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "ext"   )."'>" . LNG_EXT . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "atime" )."'>" . LNG_ATIME . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "ctime" )."'>" . LNG_CTIME . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "mtime" )."'>" . LNG_MTIME . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "perms" )."'>" . LNG_PERMS . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "group" )."'>" . LNG_GROUP . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "owner" )."'>" . LNG_OWNER . "</a></TH>\n";
echo "<TH><a href='".genUrl( $ref, $args, "sort", "inode" )."'>" . LNG_INODE . "</a></TH>\n";
echo "<TH>View</TH>\n";
echo "</TR>\n";

@usort( $lFiles, cmp );

for( $i = 0; $i < $n; $i++ )
{
	if( ( $i < $from ) || ( $i >= $to ) )
		continue;

	$k = $i;
	echo "<TR>\n";
	echo "<TD><INPUT TYPE='checkbox' NAME='id_$k' VALUE='".
		$lFiles[ $k ]->name
		."'></TD>\n";

	$IMG=getIcons( $lFiles[ $k ]->ext );

	$dform = "M j y H:i";
//  	echo "<TD ALIGN=CENTER >".$lFiles[ $k ]->type."</TD>\n";
	echo "<TD>$IMG".$lFiles[ $k ]->name."</TD>\n";
	echo "<TD ALIGN=RIGHT  >".$lFiles[ $k ]->formatSize()."</TD>\n";
	echo "<TD>".$lFiles[ $k ]->ext  ."</TD>\n";
	echo "<TD>".date( $dform, $lFiles[ $k ]->atime )."</TD>\n";
	echo "<TD>".date( $dform, $lFiles[ $k ]->ctime )."</TD>\n";
	echo "<TD>".date( $dform, $lFiles[ $k ]->mtime )."</TD>\n";
	echo "<TD>".$lFiles[ $k ]->perms."</TD>\n";
	echo "<TD>".$lFiles[ $k ]->group."</TD>\n";
	echo "<TD>".$lFiles[ $k ]->owner."</TD>\n";
	echo "<TD>".$lFiles[ $k ]->inode."</TD>\n";

	switch( $lFiles[ $k ]->type )
	{
   	case "link":
			if( $lFiles[ $k ]->stype == "dir" )
			{
				$tcd = $lFiles[ $k ]->path."/".$lFiles[ $k ]->name;
				echo "<TD><a href='".
					genUrl( $ref, $args, "cd", $tcd )."'>".
					$lFiles[ $k ]->sfile."</a></TD>\n";
			}
			else
				echo "<TD>".$lFiles[ $k ]->sfile."</TD>\n";
			break;
	  case "dir":
			$tcd = $lFiles[ $k ]->path."/".$lFiles[ $k ]->name;
			echo "<TD><a href='".
				genUrl( $ref, $args, "cd", $tcd )."'>".
				$lFiles[ $k ]->name."</a></TD>\n";
			break;
	  case "file":
			echo "<TD>".$lFiles[ $k ]->sfile."</TD>\n";
			break;
	  default:
			echo "<TD>" . LNG_NO . "</TD>\n";
			break;
	}
	echo "</TR>\n";
}

echo "</TABLE>\n";

$from = $from - $step;
if( isset( $cd ) )
{
	echo "<INPUT TYPE='hidden' NAME='cd' VALUE='$cd'>\n";
}
echo "<INPUT TYPE='hidden' NAME='nb' VALUE='$n'>\n";

//echo "<br>from=$from;to=$to;n=$n\n";
echo "<br>\n";
if( $from >=  0 )
{
	echo "<a href='".
		genUrl( $ref, $args, "from", $from )."' >" . LNG_PREV . "</a>/\n";
}
if( $to   <= $n )
{
	echo "<a href='".
		genUrl( $ref, $args, "from", $to )."'   >" . LNG_NEXT . "</a> \n";
}
echo "<br>\n";
echo "<INPUT TYPE='submit' VALUE='" . LNG_DELETE . "'>\n";
echo "</FORM>\n";

?>
</body>
</html>