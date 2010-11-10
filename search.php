<?
if(isset($_GET["lng"]))
{
	$lng_id = $_GET["lng"];
}
else
{
	if(isset($_COOKIE["lang"]))
	{
		$lng_id = $_COOKIE["lang"];		
	}
	else
	{
		$lng_id = 0;	
	}
}

$act=form_get("act");
if($act=='user')	search_user();
elseif($act=='listing')	search_listing();
elseif($act=='events')	search_events();
elseif($act=='tribe')	search_tribe();
elseif($act=='browse')	browse();
elseif($act=='')	search_main();
elseif($act=='simple')	search_simple();
elseif($act=='music')	search_music();

//showing main search page
function search_main()	{
	
	global $lng_id;
	
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$sql_query="select zip from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$type=form_get("type");
	show_header();
?>
<table width="100%" class="body" border="0" cellpadding="0" cellspacing="0">
<tr><td width="75%" valign="top">
     <table width=100% class=body>
     <tr><td class='lined title'><?=LNG_LOGIN_MY_FRND?></td>
     <tr><td class='lined padded-6'><table class=body><? show_friends($m_id,"14","7","1"); ?></table></td>
     </table>
     </td>
     <td valign=top class='lined padded-6'>
            <? if(($type=='')||($type=='basic')){ ?>
            <table class=body>
            <tr><td class='lined-right lined-top lined-left' align=center width=50>
            <a href='index.php?mode=search&lng=<?=$lng_id?>'><b><?=LNG_BASIC?></b></a>
            </td><td class='lined' align=center width=80>
            <a href='index.php?mode=search&type=advanced&lng=<?=$lng_id?>'><?=LNG_SEARCH_ADVANC?></a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
            <tr><td colspan=2 class='maingray'><?=LNG_LISTING_MSG_PROXI?></td>
            <tr><td><?=LNG_DEGREES?></td><td><select name="degrees">
			<option value="any"><?=LNG_SEARCH_ANY_DEG?>
			<option value="4"><?=LNG_SEARCH_4_DEG?>
			<option value="3"><?=LNG_SEARCH_3_DEG?>
			<option value="2"><?=LNG_SEARCH_2_DEG?>
			<option value="1"><?=LNG_SEARCH_1_DEG?>
			</select></td>
            <tr><td><?=LNG_DISTANCE?></td><td><select name="distance">
			<option value="any"><?=LNG_SEARCH_ANY_WH?>
			<option value="5"><?=LNG_5_MILES?>
			<option value="10"><?=LNG_10_MILES?>
			<option value="25">=LNG_25_MILES?>
			<option value="100"><?=LNG_100_MILES?>
			</select></td>
            <tr><td><?=LNG_FROM?></td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_USR_SRC?></td>
	        <tr><td><?=LNG_FIRST_NAME?></td><td><input type=text size=15 name="fname"></td>
	        <tr><td><?=LNG_LAST_NAME?></td><td><input type=text size=15 name="lname"></td>
	        <tr><td><?=LNG_EMAIL?></td><td><input type=text size=15 name="email"></td>
	        <tr><td colspan=2><input type=submit value="<?=LNG_FIND_ALL_URS?>"></td>
	        </table></form></table>
            <? } elseif($type=='advanced'){ ?>
            <table class=body>
            <tr><td class='lined' align=center width=50>
            <a href='index.php?mode=search&lng=<?=$lng_id?>'><b><?=LNG_BASIC?></b></a>
            </td><td class='lined-right lined-top lined-left' align=center width=80>
            <a href='index.php?mode=search&type=advanced&lng=<?=$lng_id?>'><?=LNG_SEARCH_ADVANC?></a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="advanced">
            <tr><td colspan=2><input type='checkbox' name='only_wp' value='1'>&nbsp&nbsp<?=LNG_SEARCH_FIND_PHOTO?></td>
            <tr><td colspan=2 class='maingray'><?=LNG_LISTING_MSG_PROXI?></td>
            <tr><td><?=LNG_DEGREES?></td><td><select name="degrees">
            <option value="any"><?=LNG_SEARCH_ANY_DEG?>
			<option value="4"><?=LNG_SEARCH_4_DEG?>
			<option value="3"><?=LNG_SEARCH_3_DEG?>
			<option value="2"><?=LNG_SEARCH_2_DEG?>
			<option value="1"><?=LNG_SEARCH_1_DEG?>
			</select></td>
            <tr><td><?=LNG_DISTANCE?></td><td><select name="distance">
			<option value="any"><?=LNG_SEARCH_ANY_WH?>
			<option value="5"><?=LNG_5_MILES?>
			<option value="10"><?=LNG_10_MILES?>
			<option value="25">=LNG_25_MILES?>
			<option value="100"><?=LNG_100_MILES?>
			</select></td>
            <tr><td><?=LNG_FROM?></td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_USR_SRC?></td>
            <tr><td><?=LNG_INTERESTS?></td><td><input type=text size=15 name="interests"></td>
	        <tr><td><?=LNG_FIRST_NAME?></td><td><input type=text size=15 name="fname"></td>
	        <tr><td><?=LNG_LAST_NAME?></td><td><input type=text size=15 name="lname"></td>
	        <tr><td><?=LNG_EMAIL?></td><td><input type=text size=15 name="email"></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_PER_INFO?></td>
            <tr><td><?=LNG_SEARCH_HERE_FOR?></td><td><input type=text size=15 name='here_for'></td>
            <tr><td><?=LNG_GENDER?></td><td><input type='radio' name='gender' value='m'><?=LNG_MALE?>
            &nbsp<input type='radio' name='gender' value='f'><?=LNG_FEMALE?></td>
            <tr><td><?=LNG_SEARCH_AGE?></td><td><input type='text' size=5 name='age_from'> <?=strtolower(LNG_TO)?>&nbsp<input type='text' name='age_to' size=5></td>
            <tr><td><?=LNG_SCHOOLS?></td><td><input type='text' size=15 name='schools'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_PRO_INFO?></td>
            <tr><td><?=LNG_OCCUPATION?></td><td><input type='text' size=15 name='occupation'></td>
            <tr><td><?=LNG_COMPANY?></td><td><input type='text' size=15 name='company'></td>
            <tr><td><?=LNG_POS_TITLE?></td><td><input type='text' size=15 name='position'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_DISP_PRE?></td>
            <tr><td><?=LNG_SEARCH_SHOW?></td><td><select name='show'>
            <option value='pnt'><?=LNG_SEARCH_PTEXT?>
            <option value='po'><?=LNG_SEARCH_PHONLY?>
            </select></td>
            <tr><td><?=LNG_SEARCH_SHRT_BY?></td><td><select name='sort'>
            <option value='ll'><?=LNG_PROFILE_LAST_LGIN?>
            <option value='ff'><?=LNG_SEARCH_FFRT?>
            <option value='ma'><?=LNG_SEARCH_MILES?>
            </select></td>
	        <tr><td colspan=2><input type=submit value="<?=LNG_SEARCH?>"></td>
	        </table></form></table>
            <? } ?>
<?
show_footer();
}//function


//showing main search page
function browse()	{
	
	global $lng_id;
	
	$sec=form_get("sec");
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	//login_test($m_id,$m_pass);
	$sql_query="select zip from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$type=form_get("type");
	$fr=form_get("fr");
	if(empty($fr))	$fr=0;
	$fr_next=$fr+21;
	$fr_back = $fr-21;

	show_header();
?>
    <table width="100%" class="body" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top"> 
        <td class="main-text" valign="top"> 
		<?
		if (($sec!="music") && ($sec!="model") && ($sec!="actor"))
		{	?>
		
		<table width="100%"><tr><td class="title"><?=LNG_MEMBERS?></td></tr></table>
          <table border=0 width=100% cellpadding=2 cellspacing=2>
            <?	
				$sql_query="select * from members order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text' width='15%'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==6)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
          </table>
          <br>
          <br>
		 <?	}	
		 	
		if (($sec!="model") && ($sec!="actor"))
				{	?>
		  <table width="100%"><tr><td class="title"><?=LNG_LOGIN_ART_MUSI?></td></tr></table>
          <table border="0" cellpadding="2" cellspacing="2" width="0">
            <?
				$sql_query="select * from musicprofile where bandnam <>'' order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text' width='300'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==6)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
          </table>
          <br>
          <br> 
		  <?	}
		  
		  		if (($sec!="music") && ($sec!="actor"))
				{	?>
		  <table width="100%"><tr><td class="title"><?=LNG_SEARCH_MODELS?></td></tr></table>
          <table border=0 width=100% cellpadding=2 cellspacing=2>
            <?
				$sql_query="select * from models where height <>'' and weight <>'' order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==6)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
          </table>
          <br>
          <br> 
		  <?	}	
		  
		  		if (($sec!="music") && ($sec!="model"))
				{	?>
		  <table width="100%"><tr><td class="title"><?=LNG_ACTORS?></td></tr></table>
          <table border=0 width=100% cellpadding=2 cellspacing=2>
            <?
				$sql_query="select * from actors where height <>'' and weight <>'' order by mem_id desc limit 0,6";
				$res=sql_execute($sql_query,'res');
				if(mysql_num_rows($res))	{
				$cnt=0;
				while($row=mysql_fetch_object($res))	{ 
					if($cnt==0)	echo "<tr>";
					echo "<td class='main-text'>";
					echo show_photo($row->mem_id);
					echo "<br>";
					echo show_online($row->mem_id);
					echo "</td>";
					$cnt++;
					if ($cnt==6)
					{
						$cnt=0;
						echo "</tr>";
					}
				}
				}
				?>
          </table>
		  <? 	}	?>
		  </td>
        <td class="main-text" valign="top" align="center" width="20%"><?=LNG_YOU_AD_HERE?></td>
      </tr>
      <tr>
        <td width="100%" colspan="2" align="center" valign="top"> <table align="center">
            <? //show_mem_ser($fr,21); ?>
          </table>
          <br>
          <table border=0 cellpadding=2 cellspacing=2>
            <form name="#">
              <!--<tr>
								<td colspan=2><img src="images/search-top.gif" alt="" border=0 width=264 height=20></td>
							</tr>-->
              <tr> 
                <td class="main-text" align=right> <?=LNG_ADVERTISE_HERE?></td>
              </tr>
              <tr> 
                <td class="main-text" colspan=2 valign="top" align="center"><?=LNG_ADVERTISE_HERE?></td>
              </tr>
            </form>
          </table></td>
        <td rowspan="2" valign="top"></td>
      </tr>
      <tr> 
        <td width="42%" colspan="2" align="center">
          <? if($fr!=0) { ?>
          &nbsp;&nbsp;<a href="index.php?mode=search&act=browse&fr=<?=$fr_back?>&lng=<?=$lng_id?>" onClick="javascript:history.back(1)"><?=LNG_BACK?></a>
          <? } ?>
          &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?mode=search&act=browse&fr=<?=$fr_next?>&lng=<?=$lng_id?>"><?=LNG_SEARCH_NXT_PAGE?></a>&nbsp;&nbsp;</td>
      </tr>
    </table>
<?
show_footer();
}//function



function search_user(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$type=form_get("type");
//basic search
if($type=="basic"){

    //getting values
    $form_data=array('degrees','distance','zip','fname','lname','email');
    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    }//while


    //setting filter
    $sql_query="select zip,filter from members where mem_id='$m_id'";
    $mem=sql_execute($sql_query,'get');

    $items=split("\|",$mem->filter);

    if($zip==''){
	$zip=$mem->zip;
	}
	$degree=$degrees;
    if($degree==''){
       $degree=$items[2];
    }//if
    if($distance==''){
       $distance=$items[0];
    }//if
	//applying distance filter
	$zone=array();
    if($distance=='any'){
    $zonear=LNG_SEARCH_NOT_FOUND;
    }
    else {
    $zonear=inradius($zip,$distance);
    }

	if(($zonear=='not found')||($zonear=='no result')){
     	$sql_query="select mem_id from members";
	     $res=sql_execute($sql_query,'res');
	     while($z=mysql_fetch_object($res)){
              array_push($zone,$z->mem_id);
	     }//while
	}//if
	else {
	 $sql_query="select mem_id from members where ";
	 foreach($zonear as $zp){
	    $sql_query.="zip='$zp' or ";
	 }
	 $sql_query=rtrim($sql_query,' or ');
	 $res=sql_execute($sql_query,'res');
	 while($z=mysql_fetch_object($res)){
	    array_push($zone,$z->mem_id);
	 }//while
	}//else
	//applying degree filter
	$friends=array();
	$filter=array();
	if($degree=='any'){
	 $sql_query="select mem_id from members";
	 $res=sql_execute($sql_query,'res');
	 while($fr=mysql_fetch_object($res)){
	    array_push($friends,$fr->mem_id);
	 }//while
	}//if
	else {
	$friends=count_network($m_id,$degree,"ar");
	}
    if($friends==''){
      $friends=array();
    }
	$filter=array_intersect($friends,$zone);

    $flag=0;
    foreach($filter as $id){
       if ($id!=''){
       $flag=1;
       }
    }
    if($flag==1){
    $sql_query="select mem_id from members where (";
    reset($filter);
    foreach($filter as $id){
        $sql_query.="mem_id='$id' or ";
    }//foreach
    $sql_query=rtrim($sql_query,' or ');
    $sql_query.=") ";
    reset($form_data);
    //adding to sql-query search fields values
    while(list($key,$val)=each($form_data)){
       if((${$val}!='')&&($val!='degrees')&&($val!='distance')&&($val!='zip')){
          $sql_query.="and $val='${$val}' ";
       }//if
    }//while
    $sql_query=rtrim($sql_query);
    $res=sql_execute($sql_query,'res');
    $result='';
    if(mysql_num_rows($res)){
    $result=array();
    while($ar=mysql_fetch_object($res)){
        array_push($result,$ar->mem_id);
    }//while
    }//if
    }//if
    else {
    $result='';
    }//else
    $sorted_result=$result;

}//if
elseif($type=='advanced'){

    //getting values
    $form_data=array('degrees','gender','distance','zip','fname','lname','email');
    $form_data2=array('interests','here_for','schools','occupation','company','position');
    $only_wf=form_get("only_wp");
    $sort=form_get("sort");
    $show=form_get("show");
    $age_from=form_get("age_from");
    $age_to=form_get("age_to");

    while (list($key,$val)=each($form_data)){
    ${$val}=form_get("$val");
    }//while
    while (list($key,$val)=each($form_data2)){
    ${$val}=form_get("$val");
    }//while

    //creating unix time from normal (age from and age to)
    if($age_from!=''){
      $age_from=$age_from+1970;
      $now=time();
      $dif=mktime(0,0,0,date("m"),date("d"),$age_from);
      $born_from=$now-$dif;
    }
    if($age_to!=''){
      $age_to=$age_to+1970;
      $now2=time();
      $dif2=mktime(0,0,0,date("m"),date("d"),$age_to);
      $born_to=$now2-$dif2;
    }

    //setting filter
    $sql_query="select zip from members where mem_id='$m_id'";
    $mem=sql_execute($sql_query,'get');

    if($zip==''){
	$zip=$mem->zip;
	}
	$degree=$degrees;
	//applying distance filter
	$zone=array();
    if($distance=='any'){
    $zonear=LNG_SEARCH_NOT_FOUND;
    }
    else {
    $zonear=inradius($zip,$distance);
    }
	if(($zonear=='not found')||($zonear=='no result')){
     	$sql_query="select mem_id from members";
	     $res=sql_execute($sql_query,'res');
	     while($z=mysql_fetch_object($res)){
              array_push($zone,$z->mem_id);
	     }//while
	}//if
	else {
	 $sql_query="select mem_id from members where ";
	 foreach($zonear as $zp){
	    $sql_query.="zip='$zp' or ";
	 }
	 $sql_query=rtrim($sql_query,' or ');
	 $res=sql_execute($sql_query,'res');
	 while($z=mysql_fetch_object($res)){
	    array_push($zone,$z->mem_id);
	 }//while
	}//else
	//applying degree filter
	$friends=array();
	$filter=array();
	if($degree=='any'){
	 $sql_query="select mem_id from members";
	 $res=sql_execute($sql_query,'res');
	 while($fr=mysql_fetch_object($res)){
	    array_push($friends,$fr->mem_id);
	 }//while
	}//if
	else {
	$friends=count_network($m_id,$degree,"ar");
	}
	$filter=array_intersect($friends,$zone);

    $flag=0;
    foreach($filter as $id){
       if($id!=''){
       $flag=1;
       }
    }
    if($flag==1){
    $sql_query="select mem_id from members where (";
    reset($filter);
    foreach($filter as $id){
        $sql_query.="mem_id='$id' or ";
    }//foreach
    $sql_query=rtrim($sql_query,' or ');
    $sql_query.=") ";
    reset($form_data);
    //adding search fields values
    while(list($key,$val)=each($form_data)){
       if((${$val}!='')&&($val!='degrees')&&($val!='distance')&&($val!='zip')){
          $sql_query.="and $val='${$val}' ";
       }//if
    }//while
    $sql_query=rtrim($sql_query);
    //adding birthday criteria
    if($born_from!=''){
      $sql_query.=" and birthday<=$born_from";
    }
    if($born_to!=''){
      $sql_query.=" and birthday>=$born_to";
    }
    //if show only with photos
    if($only_wf=='1'){
      $sql_query.=" and photo!='no'";
    }
    $res=sql_execute($sql_query,'res');
    $adv_res1=array();
    while($ar=mysql_fetch_object($res)){
        array_push($adv_res1,$ar->mem_id);
    }//while

    $flag2=0;
    foreach($adv_res1 as $r){
       if($r!=''){
       $flag2=1;
       }
    }
    if($flag2==1){
    //adding profile criteria
    $sql_query="select mem_id from profiles where (";
    foreach($adv_res1 as $id){
        $sql_query.="mem_id='$id' or ";
    }//foreach
    $sql_query=rtrim($sql_query,' or ');
    $sql_query.=") ";
    reset($form_data2);
    while(list($key,$val)=each($form_data2)){
       if(${$val}!=''){
          $sql_query.="and $val='${$val}' ";
       }//if
    }//while
    $sql_query=rtrim($sql_query);
    $res=sql_execute($sql_query,'res');
    $result='';
    if(mysql_num_rows($res)){
    $result=array();
    while($ar2=mysql_fetch_object($res)){
        array_push($result,$ar2->mem_id);
    }//while
    }//if
    }//if
    }//if
    else {
       $result='';
       $sorted_result='';
    }//else

    //sorting array
    if($result!=''){
    $sorted_result=array();
        //last login
        if($sort=='ll'){
        $sql_query="select mem_id from members where ";
        foreach($result as $id){
           $sql_query.="mem_id='$id' or ";
        }//foreach
        $sql_query=rtrim($sql_query,' or ');
        $sql_query.=" order by current desc";
        $res=sql_execute($sql_query,'res');
        while($ll=mysql_fetch_object($res)){
            array_push($sorted_result,$ll->mem_id);
        }//while
        }//last login
        //friends first
        elseif($sort=='ff'){
        $fr1=count_network($m_id,"1","ar");
        $fr2=count_network($m_id,"2","ar");

        if($fr1!=''){
        foreach($result as $id){
             if(in_array($id,$fr1)){
                array_push($sorted_result,$id);
             }//if
        }//foreach
        }//if
        elseif($fr2!=''){
        foreach($result as $id){
             if(in_array($id,$fr2)){
                array_push($sorted_result,$id);
             }//if
        }//foreach
        }//elseif
        $sorted_result=array_unique($sorted_result);
        foreach($result as $id){
             if(!in_array($id,$sorted_result)){
                array_push($sorted_result,$id);
             }//if
        }//foreach
        }//elseif
        //miles away
        elseif($sort=='ma'){
            $sorted_result=$result;
        }//elseif
    }//if

}//elseif

			//output
            show_header();
            ?>
              <table>
              <tr><td width=75% valign=top>
              <table width=100% class='body'>
                    <tr><td class='lined title' valign=top><?=LNG_SEARCH_PEO_SRC?></td>
                    <?
                        if($sorted_result!=''){
                        $page=form_get("page");
                        if($page==''){
                           $page=1;
                        }//if
                        $i=1;
                        if($show=='po'){
                        echo "<tr><td><table align=center>";
                        }
                        $start=($page-1)*20;
                        $end=$start+20;
                        if($end>count($sorted_result)){
                           $end=count($sorted_result);
                        }//if
                        for($k=$start;$k<$end;$k++){
                        $sql_query="select occupation,here_for from profiles where mem_id='$sorted_result[$k]'";
                        $s_mem=sql_execute($sql_query,'get');?>

                        <? if($show!='po') {?>
                        <tr><td>
                        <table class='body lined' cellspacing=0 width=100% cellpadding=0>
              	        <tr><td width=65 height=75 rowspan=2 align=center class='lined-right padded-6'><? show_photo($sorted_result[$k]); ?></br>
	                    <? show_online($sorted_result[$k]); ?>
	                    </td>
	                    <td class='td-lined-bottom padded-6'><? connections($m_id,$sorted_result[$k]); ?></td>
	                    <tr><td class='padded-6'>
                        <? if($s_mem->occupation!=''){ ?><a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->occupation; ?>&lng=<?=$lng_id?>'><? echo $s_mem->occupation; ?></a></br><?}
                        if ($s_mem->here_for!=''){?><?=LNG_SEARCH_HERE_FOR?>: <a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->here_for; ?>&lng=<?=$lng_id?>'><? echo $s_mem->here_for; ?></a></br><?}?>
                        <?=LNG_NET_WK?>: <a href='index.php?mode=people_card&act=friends&p_id=<? echo $sorted_result[$k]; ?>&lng=<?=$lng_id?>'><? echo count_network($sorted_result[$k],"1","num"); ?> <?=strtolower(LNG_FRNDS)?></a> <?=LNG_IN_A?>
	                    <a href='index.php?mode=people_card&act=network&p_id=<? echo $sorted_result[$k]; ?>&lng=<?=$lng_id?>'><?=LNG_NETWORK_OF?> <? echo count_network($sorted_result[$k],"all","num"); ?></a>
	                    </td>
	                    </table>
                        </td>
                        <?
                        }
                        else {
                        if(($i==1)||($i%5==0)){
                             echo "<tr>";
                        }
                        ?>
                        <td>
                        <table class='body lined' cellspacing=0 cellpadding=0>
              	        <tr><td width=65 height=75 align=center class='padded-6'><? show_photo($sorted_result[$k]); ?></br>
	                    <? show_online($sorted_result[$k]); ?>
	                    </td></table></td>
                        <?
                        $i++;
                        }
                        }//foreach
                        if($show=='po'){
                        echo "</table></td>";
                        }
                        echo "<tr><td class='lined' align=center>";pages_line(count($sorted_result),"$type","$page","20");
                        echo "</td>";
                        }//if
                        else {
                           echo "<tr><td>".LNG_SEARCH_NOT_FOUND.".</td>";
                        }//else
                    ?>
              </table>
              </td>
              <td valign=top class='lined padded-6'>
            <? if(($type=='')||($type=='basic')){ ?>
            <table class=body>
            <tr><td class='lined-right lined-top lined-left' align=center width=50>
            <a href='index.php?mode=search&lng=<?=$lng_id?>'><b><?=LNG_BASIC?></b></a>
            </td><td class='lined' align=center width=80>
            <a href='index.php?mode=search&type=advanced&lng=<?=$lng_id?>'><?=LNG_SEARCH_ADVANC?></a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
            <tr><td colspan=2 class='maingray'><?=LNG_LISTING_MSG_PROXI?></td>
            <tr><td><?=LNG_DEGREES?></td><td><select name="degrees">
            <option value="any"><?=LNG_SEARCH_ANY_DEG?>
			<option value="4"><?=LNG_SEARCH_4_DEG?>
			<option value="3"><?=LNG_SEARCH_3_DEG?>
			<option value="2"><?=LNG_SEARCH_2_DEG?>
			<option value="1"><?=LNG_SEARCH_1_DEG?>
			</select></td>
            <tr><td><?=LNG_DISTANCE?></td><td><select name="distance">
			<option value="any"><?=LNG_SEARCH_ANY_WH?>
			<option value="5"><?=LNG_5_MILES?>
			<option value="10"><?=LNG_10_MILES?>
			<option value="25">=LNG_25_MILES?>
			<option value="100"><?=LNG_100_MILES?>
			</select></td>
            <tr><td><?=LNG_FROM?></td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_USR_SRC?></td>
	        <tr><td><?=LNG_FIRST_NAME?></td><td><input type=text size=15 name="fname"></td>
	        <tr><td><?=LNG_LAST_NAME?></td><td><input type=text size=15 name="lname"></td>
	        <tr><td><?=LNG_EMAIL?></td><td><input type=text size=15 name="email"></td>
	        <tr><td colspan=2><input type=submit value="<?=LNG_FIND_ALL_URS?>"></td>
	        </table></form></table>
            <? } elseif($type=='advanced'){ ?>
            <table class=body>
            <tr><td class='lined' align=center width=50>
            <a href='index.php?mode=search&lng=<?=$lng_id?>'><b><?=LNG_BASIC?></b></a>
            </td><td class='lined-right lined-top lined-left' align=center width=80>
            <a href='index.php?mode=search&type=advanced&lng=<?=$lng_id?>'><?=LNG_SEARCH_ADVANC?></a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="advanced">
            <tr><td colspan=2><input type='checkbox' name='only_wp' value='1'>&nbsp&nbsp<?=LNG_SEARCH_FIND_PHOTO?></td>
            <tr><td colspan=2 class='maingray'><?=LNG_LISTING_MSG_PROXI?></td>
            <tr><td><?=LNG_DEGREES?></td><td><select name="degrees">
            <option value="any"><?=LNG_SEARCH_ANY_DEG?>
			<option value="4"><?=LNG_SEARCH_4_DEG?>
			<option value="3"><?=LNG_SEARCH_3_DEG?>
			<option value="2"><?=LNG_SEARCH_2_DEG?>
			<option value="1"><?=LNG_SEARCH_1_DEG?>
			</select></td>
            <tr><td><?=LNG_DISTANCE?></td><td><select name="distance">
			<option value="any"><?=LNG_SEARCH_ANY_WH?>
			<option value="5"><?=LNG_5_MILES?>
			<option value="10"><?=LNG_10_MILES?>
			<option value="25">=LNG_25_MILES?>
			<option value="100"><?=LNG_100_MILES?>
			</select></td>
            <tr><td><?=LNG_FROM?></td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_USR_SRC?></td>
            <tr><td><?=LNG_INTERESTS?></td><td><input type=text size=15 name="interests"></td>
	        <tr><td><?=LNG_FIRST_NAME?></td><td><input type=text size=15 name="fname"></td>
	        <tr><td><?=LNG_LAST_NAME?></td><td><input type=text size=15 name="lname"></td>
	        <tr><td><?=LNG_EMAIL?></td><td><input type=text size=15 name="email"></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_PER_INFO?></td>
            <tr><td><?=LNG_SEARCH_HERE_FOR?></td><td><input type=text size=15 name='here_for'></td>
            <tr><td><?=LNG_GENDER?></td><td><input type='radio' name='gender' value='m'><?=LNG_MALE?>
            &nbsp<input type='radio' name='gender' value='f'><?=LNG_FEMALE?></td>
            <tr><td><?=LNG_SEARCH_AGE?></td><td><input type='text' size=5 name='age_from'>&nbspto&nbsp<input type='text' name='age_to' size=5></td>
            <tr><td><?=LNG_SCHOOLS?></td><td><input type='text' size=15 name='schools'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_PRO_INFO?></td>
            <tr><td><?=LNG_OCCUPATION?></td><td><input type='text' size=15 name='occupation'></td>
            <tr><td><?=LNG_COMPANY?></td><td><input type='text' size=15 name='company'></td>
            <tr><td><?=LNG_POS_TITLE?></td><td><input type='text' size=15 name='position'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_DISP_PRE?></td>
            <tr><td><?=LNG_SEARCH_SHOW?></td><td><select name='show'>
            <option value='pnt'><?=LNG_SEARCH_PTEXT?>
            <option value='po'><?=LNG_SEARCH_PHONLY?>
            </select></td>
            <tr><td><?=LNG_SEARCH_SHRT_BY?></td><td><select name='sort'>
            <option value='ll'><?=LNG_PROFILE_LAST_LGIN?>
            <option value='ff'><?=LNG_SEARCH_FFRT?>
            <option value='ma'><?=LNG_SEARCH_MILES?>
            </select></td>
	        <tr><td colspan=2><input type=submit value="<?=LNG_SEARCH?>"></td>
	        </table></form></table>
            <? } ?>
            <?
            show_footer();
}//function

function search_listing(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$sql_query="select zip from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');

//getting values
$form_data=array('keywords','RootCategory','Category','degree','distance','zip');
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}//while

$cat_id=$RootCategory;
$sub_cat_id=$Category;
if($cat_id==$sub_cat_id){
  $sub_cat_id='';
}//if

if($zip==''){
 $zip=$mem->zip;
}

//applying distance filter
$zone=array();
if($distance=='any'){
$zonear='no result';
}else{
$zonear=inradius($zip,$distance);
}
if(($zonear=='not found')||($zonear=='no result')){
 $sql_query="select lst_id from listings";
 $res=sql_execute($sql_query,'res');
 while($z=mysql_fetch_object($res)){
  array_push($zone,$z->lst_id);
 }
}
else {
 $sql_query="select lst_id from listings where ";
 foreach($zonear as $zp){
 	$sql_query.="zip='$zp' or ";
 }
 $sql_query=rtrim($sql_query,' or ');
 $res=sql_execute($sql_query,'res');
 while($z=mysql_fetch_object($res)){
    array_push($zone,$z->lst_id);
 }
}
//applying degree filter
$friends=array();
$filter=array();
if($degree=='any'){
 $sql_query="select mem_id from members";
 $res=sql_execute($sql_query,'res');
 while($fr=mysql_fetch_object($res)){
  	array_push($friends,$fr->mem_id);
 }
}
else {
for($i=$degree;$i>=1;$i--){
$friends=array_merge($friends,count_network($m_id,$i,"ar"));
}//for
}//else
if($friends==''){
  $friends=array();
}
$filter=$friends;
$filter=if_empty($filter);
if($filter!=''){
$filter=array_unique($filter);
}//if
$zone=if_empty($zone);

   if(($zone!='')&&($filter!='')){
   $sql_query="select lst_id from listings where ";
   reset($filter);
   if($filter!=''){
   $sql_query.="( ";
   foreach($filter as $id){
       $sql_query.="mem_id='$id' or ";
   }//foreach
   $sql_query=rtrim($sql_query,' or ');
   $sql_query.=") ";
   }//if
   if($zone!=''){
   $sql_query.="and (";
   foreach($zone as $zon){
       $sql_query.="lst_id='$zon' or ";
   }//foreach
   $sql_query=rtrim($sql_query,' or ');
   }//if
   $sql_query.=")";
   $res=sql_execute($sql_query,'res');
   if(mysql_num_rows($res)){
   $result=array();
   while($sear=mysql_fetch_object($res)){
      array_push($result,$sear->lst_id);
   }//while
   }//if
   }//if
   else{
      $result='';
   }//else

                        //output
                        show_header();
                        ?>
                          <table width=100% class='body'>
                             <tr><td valign=top width=75%>
                             <table width=100% class='body'>
                             <tr><td class='lined title'><?=LNG_SEARCH_LST_SRC_RES?></td>
                             <tr><td class='lined'>
                             <?
                        if($result!=''){
                                $result=array_unique($result);
                                $page=form_get("page");
                                if($page==''){
                                  $page=1;
                                }
                                $start=($page-1)*20;
                                $end=$start+20;
                                if($end>count($result)){
                                  $end=count($result);
                                }
                                $sql_query="select lst_id from listings where (";
                                   foreach($result as $id){

                                       $sql_query.="lst_id='$id' or ";

                                   }//foreach
                                   $sql_query=rtrim($sql_query,' or ');
                                   $sql_query.=")";
                                   if($keywords!=''){
   	                               $keyword=split(' ',$keywords);
	                               $keyword=if_empty($keyword);
	                               foreach($keyword as $word){
	                                  $sql_query.=" and description like '%$word%'";
	                               }//foreach
	                               }//if
                                if($cat_id!=''){
                                $sql_query.=" and cat_id='$cat_id'";
                                }//if
                                if($sub_cat_id!=''){
                                $sql_query.=" and sub_cat_id='$sub_cat_id'";
                                }//if
                                if($degree!='any'){
                                   $sql_query.=" and anonim!='y'";
                                }//if
                                $sql_query.=" and stat='a' order by added";

                                $total=sql_execute($sql_query,'num');
                                $sql_query.=" limit $start,20";

                                       $res=sql_execute($sql_query,'res');
                                       $final=array();
                                       while($fin=mysql_fetch_object($res)){
                                          array_push($final,$fin->lst_id);
                                       }//while
                                       $flag=0;
                                       foreach($final as $lid){
                                           if($lid!=''){
                                             $flag=1;
                                             break;
                                           }
                                       }
                                       if($flag==1){
                                       ?>
                                       <table class='body'>
                                       <?
                                       foreach($final as $lid){
                                       $sql_query="select * from listings where lst_id='$lid'";
                                       $lst=sql_execute($sql_query,'get');
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
                                       echo " - ";echo find_relations($m_id,$lst->mem_id);
	                                   }
	                                   else{
	                                   echo "anonymous";
	                                   }
	                                   echo "</br>";
	                                   }//if
	                                   }//if
                                       }//foreach
                                       echo "</table>";
                                       echo "<tr><td class='lined' align=center>";
                                       pages_line($total,"search_lst","$page","20");
                                       echo "</td>";
                                       }//if
                        			   else {
                            			  echo "".LNG_SEARCH_NOT_FOUND.".";
				                       }//else




                        }//if
                        else {
                            echo "".LNG_SEARCH_NOT_FOUND.".";

                        }//else
                        ?>                             </td></table></td>
                             <td valign=top>
                             <table class='body'>

                <tr><td class="lined title"><?=LNG_LISTING_MSG_ZO?></td>
                <tr><td class="lined padded-6">
                <form action='index.php' method=post name='searchListing'>
                <input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="listing">
				<input type=hidden name="type" value="normal">
                    <?=LNG_KEYWORDS?> <input type=text name='keywords'></br>
                    <?=LNG_CATEGORY?> <select name="RootCategory" onChange="listCategory.populate();" width="140" style="width: 140px">
							<option value=""><?=LNG_LISTING_MSG_SEL_CAT?></option>
               <option value="1000"><?=LNG_LISTING_MSG_XB?></option>
               <option value="2000"><?=LNG_LISTING_MSG_XC?></option>
               <option value="7000"><?=LNG_LISTING_MSG_FOR_SALE?></option>
               <option value="6000"><?=LNG_LISTING_MSG_HOUSING?></option>
               <option value="9000"><?=LNG_LISTING_MSG_JOBS?></option>
               <option value="4000"><?=LNG_LISTING_MSG_LOCAL?></option>
               <option value="5000"><?=LNG_LISTING_MSG_PP?></option>
               <option value="8000"><?=LNG_LISTING_MSG_SERVICE?></option>
       		     </select>
     <br/>
	   	<select name="Category" width="140" style="width: 140px">
	   				  <SCRIPT LANGUAGE="JavaScript">listCategory.printOptions();</script>
	   	</select>
	   	<SCRIPT LANGUAGE="JavaScript">listCategory.setDefaultOption("","");</script>
                </br>

                <?=LNG_LISTING_MSG_PROXI?></br>
                <?=LNG_DEGREES?> <select name="degree">
				<option value="any"><?=LNG_ANYONE?>
				<option value="4"><?=LNG_WITHIN_4_DEG?>
				<option value="3"><?=LNG_WITHIN_3_DEG?>
				<option value="2"><?=LNG_WITHIN_2_DEG?>
				<option value="1"><?=LNG_A_FRIEND?>
				</select></br>
                <?=LNG_DISTANCE?> <select name="distance">
				<option value="any"><?=LNG_ANY_DISTANCE?>
				<option value="5"><?=LNG_5_MILES?>
				<option value="10"><?=LNG_10_MILES?>
				<option value="25">=LNG_25_MILES?>
				<option value="100"><?=LNG_100_MILES?>
				</select>
                <?=LNG_FROM?> <input type=text size=10 name=zip value='<?
                $sql_query="select zip from members where mem_id='$m_id'";
                $mem=sql_execute($sql_query,'get');
                echo $mem->zip;
                ?>'></br></br>
                <input type='submit' value='<?=LNG_SEARCH?>'>
                </form>
                </td>
           </table>
</td>
</table>
<?
	show_footer();
}//function

function search_events(){
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);

	$sql_query="select zip from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');

	//getting values
	$form_data=array('keywords','RootCategory','distance','degree','zip');
	while (list($key,$val)=each($form_data)){
		${$val}=form_get("$val");
	}//while

	$cat_id=$RootCategory;
	if($zip=='')	$zip=$mem->zip;

	//applying distance filter
	$zone=array();
	if($distance=='any')	$zonear='no result';
	else	$zonear=inradius($zip,$distance);
	if(($zonear=='not found')||($zonear=='no result')){
		$sql_query="select even_id from event_list";
		$res=sql_execute($sql_query,'res');
		while($z=mysql_fetch_object($res)){
			array_push($zone,$z->even_id);
		}
	}	else	{
		$sql_query="select even_id from event_list where ";
		foreach($zonear as $zp){
			$sql_query.="even_zip='$zp' or ";
		}
		$sql_query=rtrim($sql_query,' or ');
		$res=sql_execute($sql_query,'res');
		while($z=mysql_fetch_object($res)){
			array_push($zone,$z->even_id);
		}
	}
	//applying degree filter
	$friends=array();
	$filter=array();
	if($degree=='any'){
		$sql_query="select mem_id from members";
		$res=sql_execute($sql_query,'res');
		while($fr=mysql_fetch_object($res)){
			array_push($friends,$fr->mem_id);
		}
	}	else	{
		for($i=$degree;$i>=1;$i--){
			$friends=array_merge($friends,count_network($m_id,$i,"ar"));
		}//for
	}//else
	if($friends=='')	$friends=array();
	$filter=$friends;
//	$filter=if_empty($filter);
	if($filter!='')	$filter=array_unique($filter);
//	$zone=if_empty($zone);
	if(($zone!='')&&($filter!='')){
		$sql_query="select even_id from event_list where ";
		reset($filter);
		if($filter!=''){
			$sql_query.="( ";
			foreach($filter as $id){
				$sql_query.="even_own='$id' or ";
			}//foreach
			$sql_query=rtrim($sql_query,' or ');
			$sql_query.=") ";
		}//if
		if($zone!=''){
			$sql_query.="and (";
			foreach($zone as $zon){
				$sql_query.="even_id='$zon' or ";
			}//foreach
			$sql_query=rtrim($sql_query,' or ');
		}//if
		$sql_query.=")";
		$res=sql_execute($sql_query,'res');
		if(mysql_num_rows($res)){
			$result=array();
			while($sear=mysql_fetch_object($res)){
				array_push($result,$sear->even_id);
			}//while
		}//if
   }	else	$result='';

	//output
	show_header();
	?>
	<table width=100% class='body'>
		<tr><td valign=top width=75%>
			<table width=100% class='body'>
				<tr><td class='lined title'><?=LNG_SEARCH_ESR?></td>
				<tr><td class='lined'>
				<?
				if($result!=''){
					$result=array_unique($result);
					$page=form_get("page");
					if($page=='')	$page=1;
					$start=($page-1)*20;
					$end=$start+20;
					if($end>count($result))	$end=count($result);
					$sql_query="select even_id from event_list where (";
					foreach($result as $id){
						$sql_query.="even_id='$id' or ";
					}//foreach
					$sql_query=rtrim($sql_query,' or ');
					$sql_query.=")";
					if($keywords!=''){
						$keyword=split(' ',$keywords);
						$keyword=if_empty($keyword);
						foreach($keyword as $word){
							$sql_query.=" and even_desc like '%$word%'";
						}//foreach
					}//if
					$sql_query.=" order by even_dt";
					$total=sql_execute($sql_query,'num');
					$sql_query.=" limit $start,20";
					$res=sql_execute($sql_query,'res');
					$final=array();
					while($fin=mysql_fetch_object($res)){
						array_push($final,$fin->even_id);
					}//while
					$flag=0;
					foreach($final as $lid){
						if($lid!=''){
							$flag=1;
							break;
						}//If
					}//Foreach
					if($flag==1){
					?>
					<table class='body'>
					<?
					foreach($final as $lid){
						$sql_query="select * from event_list where even_id='$lid'";
						$lst=sql_execute($sql_query,'get');
						$date=$lst->even_stat;
						echo "$date  <img src='images/icon_listing.gif'>
						<a href='index.php?mode=events&act=viewevent&seid=$lst->even_id&lng=$lng_id'>$lst->even_title</a>&nbsp";
						show_online($lst->mem_id);
						echo " - ";echo find_relations($m_id,$lst->even_own);
						echo "</br>";
					}//foreach
					echo "</table>";
					echo "<tr><td class='lined' align=center>";
					pages_line($total,"search_lst","$page","20");
					echo "</td>";
				}//if
				else {
					echo "".LNG_SEARCH_NOT_FOUND.".";
				}//else
			}//if
			else {
				echo "".LNG_SEARCH_NOT_FOUND.".";
			}//else
			?>
			</td></table></td>
			<td valign=top>
			<table class='body'>
			<tr><td class="lined title"><?=LNG_SEARCH_SRC_ENNT?></td>
			<tr><td class="lined padded-6">
			<form action='index.php' method=post name='searchEvent'>
				<input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="events">
				<input type=hidden name="type" value="normal">
				<?=LNG_KEYWORDS?> <input type=text name='keywords'></br>
				<?=LNG_CATEGORY?> <select name="RootCategory" width="140" style="width: 140px"><? events_cats(''); ?></select><br>
				<?=LNG_DEGREES?> <select name="degree">
				<option value="any"><?=LNG_ANYONE?></option>
				<option value="4"><?=LNG_WITHIN_4_DEG?></option>
				<option value="3"><?=LNG_WITHIN_3_DEG?></option>
				<option value="2"><?=LNG_WITHIN_2_DEG?></option>
				<option value="1"><?=LNG_A_FRIEND?></option>
				</select><br><br>
				<?=LNG_DISTANCE?> <select name="distance">
				<option value="any"><?=LNG_ANY_DISTANCE?></option>
				<option value="5"><?=LNG_5_MILES?></option>
				<option value="10"><?=LNG_10_MILES?></option>
				<option value="25">=LNG_25_MILES?></option>
				<option value="100"><?=LNG_100_MILES?></option>
				</select><br><br>
                <?=LNG_FROM?> <input type=text size=10 name=zip value='<?
                $sql_query="select zip from members where mem_id='$m_id'";
                $mem=sql_execute($sql_query,'get');
                echo $mem->zip;
                ?>'></br></br>
                <input type='submit' value='<?=LNG_SEARCH?>'>
                </form>
				</td>
				</table>
				</td>
				</table>
<?
	show_footer();
}//function

function search_tribe(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
   <table width=100%>
   <tr><td width=75% valign=top>
       <table width=100% class='body'>
       <tr><td class='lined title'><?=LNG_SEARCH_GRPP?></td>


<?
//just selecting tribe with description, that contents search keywords
$keywords=form_get("keywords");
if($keywords!=''){
   $keyword=split(" ",$keywords);
   $sql_query="select trb_id from tribes where (";
   foreach($keyword as $word){
       $sql_query.="description like '%$word%' or ";
   }//foreach
   $sql_query=rtrim($sql_query,' or ');
   $sql_query.=") and type!='priv' order by mem_num";
   $res=sql_execute($sql_query,'res');
   $result='';
   if(mysql_num_rows($res)){
   $result=array();
      while($tr=mysql_fetch_object($res)){
         array_push($result,$tr->trb_id);
      }//while
   }//if
}//if
else {
   $sql_query="select trb_id from tribes where type!='priv' order by mem_num";
   $res=sql_execute($sql_query,'res');
   $result='';
   if(mysql_num_rows($res)){
   $result=array();
      while($tr=mysql_fetch_object($res)){
         array_push($result,$tr->trb_id);
      }//while
   }//if
}//else

                //output
                if($result!=''){
                $result=array_unique($result);
                $page=form_get("page");
                if($page==''){
                    $page=1;
                }//if
                $start=($page-1)*20;
                $end=$start+20;
                if($end>count($result)){
                   $end=count($result);
                }
                for($k=$start;$k<$end;$k++){
                    $sql_query="select * from tribes where trb_id='$result[$k]'";
                    $trb=sql_execute($sql_query,'get');
                    $sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
                    $name=sql_execute($sql_query,'get');
                    $name->name=rtrim($name->name);

                     echo "<tr><td><table width=100% class='body' cellpadding=0 cellspacing=0>";
                     echo "<tr><td class='lined-top lined-left lined-bottom' align=center height=75 width=65>";
                     show_tribe_s_photo($trb->trb_id);echo "</br>";
                     echo "<a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id&lng=$lng_id'>$trb->name</a>";
                     echo "</td>
                     <td valign=top class='td-lined padded-6'>";
                     echo "<b><a href='index.php?mode=tribe&act=show&trb_id=$trb->trb_id&lng=$lng_id'>$trb->name</a></b></br>";
                     echo "A ".tribe_type($trb->trb_id,'output').
                     " <a href='index.php?mode=tribe&act=cat&t_cat_id=$trb->t_cat_id&lng=$lng_id'>$name->name</a> tribe.</br>";
                     echo $trb->mem_num."".LNG_MEMBERS;join_tribe_link($m_id,$trb->trb_id);
                     echo "</br></br>";
                     echo $trb->description;
                     echo "</td>";
                     echo "</table></td>";

                }//foreach
                echo "<tr><td class='lined' align=center>";
                pages_line(count($result),"search_trb","$page","20");
                echo "</td>";
                }//if
                else {
                echo "<tr><td align=center class=lined>".LNG_SEARCH_NOT_FOUND.".</td>";
                }

?>
  </table></td>
  <td valign=top>

            <table width=100% class='body'>
               <tr><td class='lined padded-6' align=center><input type=button value='<?=ucword(LNG_CREATE_GROUP)?>' onClick='window.location="index.php?mode=tribe&act=create&lng=<?=$lng_id?>"'></td>
               <tr><td class='lined title'><?=LNG_SEARCH_GROUPS?></td>
               <tr><td class='padded-6 lined'>
               <form action="index.php" method='post'>
               <input type=hidden name="mode" value="search">
			   <input type=hidden name="act" value="tribe">
               <?=LNG_KEYWORDS?></br>
               <input type='text' name='keywords'></br>
               <input type='submit' value='<?=LNG_SEARCH?>'></form>
               </td>
            </table>
       </td></table>

<?
show_footer();
}//function

//simple search(only interests)
function search_simple(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
	$fl=form_get("key");
	$sr=form_get($fl);
    //applying intersts value
    $sql_query="select mem_id from profiles where ($fl like '$sr,%') or ($fl like '%,$sr,%') or ($fl like '%,$sr') or ($fl like '$sr')";
    $sql_query=rtrim($sql_query);
    $res=sql_execute($sql_query,'res');
    $result='';
    if(mysql_num_rows($res)){
    $result=array();
    while($ar=mysql_fetch_object($res)){
        array_push($result,$ar->mem_id);
    }//while
    }//if
    else {
    $result='';
    }//else

            //output
            show_header();
            ?>
              <table>
              <tr><td width=75% valign=top>
              <table width=100% class='body'>
                    <tr><td class='lined title' valign=top><?=LNG_SEARCH_PEO_SRC?></td>
                    <?
                        if($result!=''){
                        $page=form_get("page");
                        if($page==''){
                           $page=1;
                        }//if
                        $start=($page-1)*20;
                        $end=$start+20;
                        if($end>count($result)){
                          $end=count($result);
                        }//if
                        for($k=$start;$k<$end;$k++){
                        $sql_query="select occupation,here_for from profiles where mem_id='$result[$k]'";
                        $s_mem=sql_execute($sql_query,'get');?>

                        <tr><td>
                        <table class='body lined' cellspacing=0 width=100% cellpadding=0>
              	        <tr><td rowspan=2 width=10% class='lined-right padded-6'><? show_photo($result[$k]); ?></br>
	                    <? show_online($result[$k]); ?>
	                    </td>
	                    <td class='td-lined-bottom padded-6'><? connections($m_id,$result[$k]); ?></td>
	                    <tr><td class='padded-6'>
                        <? if($s_mem->occupation!=''){ ?><a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->occupation; ?>&lng=<?=$lng_id?>'><? echo $s_mem->occupation; ?></a></br><?}
                        if ($s_mem->here_for!=''){?><?=LNG_SEARCH_HERE_FOR?>: <a href='index.php?mode=search&act=simple&interests=<? echo $s_mem->here_for; ?>&lng=<?=$lng_id?>'><? echo $s_mem->here_for; ?></a></br><?}?>
                        <?=LNG_NET_WK?>: <? echo count_network($result[$k],"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($result[$k],"all","num"); ?>
	                    </td>
	                    </table>
                        </td>
                        <?
                        }//foreach
                        echo "<tr><td class='lined' align=center>";pages_line(count($result),"simple","$page","20");
                        echo "</td>";
                        }//if
                        else {
                           echo "<tr><td>".LNG_SEARCH_NOT_FOUND.".</td>";
                        }//else
                    ?>
              </table>
              </td>
              <td valign=top class='lined padded-6'>
            <? if(($type=='')||($type=='basic')){ ?>
            <table class=body>
            <tr><td class='lined-right lined-top lined-left' align=center width=50>
            <a href='index.php?mode=search&lng=<?=$lng_id?>'><b><?=LNG_BASIC?></b></a>
            </td><td class='lined' align=center width=80>
            <a href='index.php?mode=search&type=advanced&lng=<?=$lng_id?>'><?=LNG_SEARCH_ADVANC?></a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
            <tr><td colspan=2 class='maingray'><?=LNG_LISTING_MSG_PROXI?></td>
            <tr><td><?=LNG_DEGREES?></td><td><select name="degrees">
			<option value="any"><?=LNG_ANYONE?>
			<option value="4"><?=LNG_WITHIN_4_DEG?>
			<option value="3"><?=LNG_WITHIN_3_DEG?>
			<option value="2"><?=LNG_WITHIN_2_DEG?>
			<option value="1"><?=LNG_A_FRIEND?>
			</select></td>
            <tr><td><?=LNG_DISTANCE?></td><td><select name="distance">
			<option value="any"><?=LNG_ANY_DISTANCE?>
			<option value="5"><?=LNG_5_MILES?>
			<option value="10"><?=LNG_10_MILES?>
			<option value="25">=LNG_25_MILES?>
			<option value="100"><?=LNG_100_MILES?>
			</select></td>
            <tr><td><?=LNG_FROM?></td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_USR_SRC?></td>
	        <tr><td><?=LNG_FIRST_NAME?></td><td><input type=text size=15 name="fname"></td>
	        <tr><td><?=LNG_LAST_NAME?></td><td><input type=text size=15 name="lname"></td>
	        <tr><td><?=LNG_EMAIL?></td><td><input type=text size=15 name="email"></td>
	        <tr><td colspan=2><input type=submit value="<?=LNG_FIND_ALL_URS?>"></td>
	        </table></form></table>
            <? } elseif($type=='advanced'){ ?>
            <table class=body>
            <tr><td class='lined' align=center width=50>
            <a href='index.php?mode=search&lng=<?=$lng_id?>'><b><?=LNG_BASIC?></b></a>
            </td><td class='lined-right lined-top lined-left' align=center width=80>
            <a href='index.php?mode=search&type=advanced&lng=<?=$lng_id?>'><?=LNG_SEARCH_ADVANC?></a>
            </td>
            <table class='body lined'>
	        <form action="index.php" method=post>
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="advanced">
            <tr><td colspan=2><input type='checkbox' name='only_wp' value='1'>&nbsp&nbsp<?=LNG_SEARCH_FIND_PHOTO?></td>
            <tr><td colspan=2><input type='checkbox' name='only_ol' value='1'>&nbsp;&nbsp;<?=LNG_SEARCH_FXC?></td>
            <tr><td colspan=2 class='maingray'><?=LNG_LISTING_MSG_PROXI?></td>
            <tr><td><?=LNG_DEGREES?></td><td><select name="degrees">
            <option value="any"><?=LNG_SEARCH_ANY_DEG?>
			<option value="4"><?=LNG_SEARCH_4_DEG?>
			<option value="3"><?=LNG_SEARCH_3_DEG?>
			<option value="2"><?=LNG_SEARCH_2_DEG?>
			<option value="1"><?=LNG_SEARCH_1_DEG?>
			</select></td>
            <tr><td><?=LNG_DISTANCE?></td><td><select name="distance">
			<option value="any"><?=LNG_SEARCH_ANY_WH?>
			<option value="5"><?=LNG_5_MILES?>
			<option value="10"><?=LNG_10_MILES?>
			<option value="25">=LNG_25_MILES?>
			<option value="100"><?=LNG_100_MILES?>
			</select></td>
            <tr><td><?=LNG_FROM?></td><td><input type=text size=15 name=zip value='<? echo $mem->zip; ?>'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_USR_SRC?></td>
            <tr><td><?=LNG_INTERESTS?></td><td><input type=text size=15 name="interests"></td>
	        <tr><td><?=LNG_FIRST_NAME?></td><td><input type=text size=15 name="fname"></td>
	        <tr><td><?=LNG_LAST_NAME?></td><td><input type=text size=15 name="lname"></td>
	        <tr><td><?=LNG_EMAIL?></td><td><input type=text size=15 name="email"></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_PER_INFO?></td>
            <tr><td><?=LNG_SEARCH_HERE_FOR?></td><td><input type=text size=15 name='here_for'></td>
            <tr><td><?=LNG_GENDER?></td><td><input type='radio' name='gender' value='m'><?=LNG_MALE?>
            &nbsp<input type='radio' name='gender' value='f'><?=LNG_FEMALE?></td>
            <tr><td><?=LNG_SEARCH_AGE?></td><td><input type='text' size=5 name='age_from'>&nbsp<?=strtolower(LNG_TO)?>&nbsp<input type='text' name='age_to' size=5></td>
            <tr><td><?=LNG_SCHOOLS?></td><td><input type='text' size=15 name='schools'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_PRO_INFO?></td>
            <tr><td><?=LNG_OCCUPATION?></td><td><input type='text' size=15 name='occupation'></td>
            <tr><td><?=LNG_COMPANY?></td><td><input type='text' size=15 name='company'></td>
            <tr><td><?=LNG_POS_TITLE?></td><td><input type='text' size=15 name='position'></td>
            <tr><td colspan=2 class='maingray'><?=LNG_SEARCH_DISP_PRE?></td>
            <tr><td><?=LNG_SEARCH_SHOW?></td><td><select name='show'>
            <option value='pnt'><?=LNG_SEARCH_PTEXT?>
            <option value='po'><?=LNG_SEARCH_PHONLY?>
            </select></td>
            <tr><td><?=LNG_SEARCH_SHRT_BY?></td><td><select name='sort'>
            <option value='ll'><?=LNG_PROFILE_LAST_LGIN?>
            <option value='ff'><?=LNG_SEARCH_FFRT?>
            <option value='ma'><?=LNG_SEARCH_MILES?>
            </select></td>
	        <tr><td colspan=2><input type=submit value="<?=LNG_SEARCH?>"></td>
	        </table></form></table>
            <? } ?>
            <?
            show_footer();
}//function

function search_music()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$key=form_get("key");
	$search_term=form_get("search_term");
	$m_cat=form_get("m_cat");
	$country=form_get("country");
	$page=form_get("page");
	if(empty($page))	$page=1;
	$start=($page-1)*20;
	$sql_query="select members.*,musicprofile.* from members,musicprofile where members.mem_id=musicprofile.mem_id and members.verified='y' and members.ban='n'";
	if(!empty($search_term))	{
		if($search_term=='bandname')	$sql_query.=" and musicprofile.bandnam like '%".addslashes($key)."%'";
		elseif($search_term=='bandbio')	$sql_query.=" and musicprofile.bandbio like '%".addslashes($key)."%'";
		elseif($search_term=='bandmembers')	$sql_query.=" and (musicprofile.bandmembers like '%".addslashes($key)."%' or musicprofile.bandmembers like ',%".addslashes($key)."%,' or musicprofile.bandmembers like ',%".addslashes($key)."%' or musicprofile.bandmembers like '%".addslashes($key)."%,')";
		elseif($search_term=='influences')	$sql_query.=" and musicprofile.influences like '%".addslashes($key)."%'";
		elseif($search_term=='soundslike')	$sql_query.=" and musicprofile.soundslike like '%".addslashes($key)."%'";
	}	else	{
		if(!empty($key))	$sql_query.=" and musicprofile.bandnam like '%".addslashes($key)."%'";
	}
	if(!empty($m_cat))	$sql_query.=" and (musicprofile.genre1='$m_cat' or musicprofile.genre2='$m_cat' or musicprofile.genre3='$m_cat')";
		if(!empty($country))	$sql_query.=" and members.country='$country'";
	$p_sql=$sql_query;
	$sql_query.=" limit $start,20";
	$p_url="index.php?mode=search&act=music&key=$key&search_term=$search_term&m_cat=$m_cat&country=$country&lng=$lng_id";
	$res=sql_execute($sql_query,'res');
	show_header();
?>
<form action="index.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="1%" align="left" valign="top"><img src="images/titleleft.gif" border="0"></td>
	<td class="hometitle" width="98%" style="padding-left: 7"><?=LNG_SEARCH_SRC_CRES?></td>
	<td width="2%" align="right" valign="top"><img src="images/titleright.gif" border="0"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="homelined">
  <tr align="center"> 
	<td height="3" colspan="2"></td>
  </tr>
  <tr> 
	<td width="37%" height="20" style="padding-left: 5"><?=LNG_KEYWORDS?>:</td>
	<td width="63%" height="20"><input name="key" type="text" value="<?=stripslashes($key)?>"></td>
  </tr>
  <tr> 
	<td width="37%" height="20" style="padding-left: 5"><?=LNG_CATEGORY?>:</td>
	<td width="63%" height="20"><select name="search_term">
		<option value=""<? echo selected("",$search_term) ?>>Select</option>
		<option value="bandname"<? echo selected("bandname",$search_term) ?>><?=LNG_MUSIC_BRAND_NAME?></option>
		<option value="bandbio"<? echo selected("bandbio",$search_term) ?>><?=LNG_MUSIC_BAND_BIO?></option>
		<option value="bandmembers"<? echo selected("bandmembers",$search_term) ?>><?=LNG_PROFILE_BND_MEM?></option>
		<option value="influences"<? echo selected("influences",$search_term) ?>><?=LNG_PROFILE_INFLU?></option>
		<option value="soundslike"<? echo selected("soundslike",$search_term) ?>><?=LNG_PROFILE_SND_LIKE?></option>
	  </select></td>
  </tr>
  <tr align="center"> 
	<td height="20" colspan="2">&#8212;&#8212;&#8212;&#8212;&#8212;&nbsp;&nbsp;And/Or&nbsp;&nbsp;&#8212;&#8212;&#8212;&#8212;&#8212;</td>
  </tr>
  <tr> 
	<td width="37%" height="20" style="padding-left: 5"><?LNG_MUSIC_GRENE?>:</td>
	<td width="63%" height="20"><select name="m_cat">
		<? echo show_music_cat($m_cat); ?></select></td>
  </tr>
  <tr> 
	<td width="37%" height="20" style="padding-left: 5"><?=LNG_LOCATION?>:</td>
	<td width="63%" height="20"><select name="country"><? country_drop($country); ?></select></td>
  </tr>
  <tr align="center"> 
	<td height="20" colspan="2" style="padding-left: 5"> 
	  <input name="act" type="hidden" value="music"> <input name="mode" type="hidden" value="search"> 
	  <input type="submit" class="button" name="Submit" value="<?=LNG_SEARCH?>"></td>
  </tr>
  <tr align="center"> 
	<td height="10" colspan="2"></td>
  </tr>
</table>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="hometitle">
  <tr>
	<td style="padding-left: 7;height: 20"><?=LNG_SEARCH_SRES?></td>
  </tr>
</table>
<? if(!mysql_num_rows($res)) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
  <tr>
	<td align="center"><?=LNG_SERCH_UR_SRC?>.</td>
  </tr>
</table>
<? } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="body lined">
	<tr><td style="padding-top: 5" colspan="2" height="1" class="dark"></td></tr>
<? while($row=mysql_fetch_object($res)) { ?>
	<tr><td style="padding-left: 7;padding-top: 3;padding-bottom: 3"><? show_photo($row->mem_id); ?></td><td valign="middle" style="padding-left: 5;padding-top: 3;padding-bottom: 3">
	<? echo musical_link($row->mem_id); ?><br>
	<strong><?LNG_MUSIC_GRENE?>: </strong><? echo musical_genre($row->mem_id); ?><br>
	<strong><?=LNG_LOCATION?>: </strong><? echo show_location($row->mem_id); ?><br>
	<strong><?=LNG_SERCH_LUD?>: </strong><? echo user_profile_updated($row->mem_id,"M d,Y"); ?><br>
	</td></tr>
	<tr><td colspan="2" height="1" class="dark"></td></tr>
<? } ?>
	<tr><td colspan="2" align="right" style="padding-right: 12;padding-top: 5;padding-bottom: 5"><? echo page_nums($p_sql,$p_url,$page,20); ?></td></tr>
</table>
<? } ?>
<?
	show_footer();
}
function show_mem_ser($fr,$no)	{
	global $words_lang,$blocks_lang,$frazes_lang,$buttons_lang,$titles_lang,$lang_def,$date_format;
	global $main_url;
	$sql_query="select mem_id from members where photo_thumb<>'no' order by joined desc limit $fr,$no";
	$res=mysql_query($sql_query);
	if(mysql_num_rows($res))	{
		$ss=1;
		while($row=mysql_fetch_object($res))	{
			if($ss==1)	echo "<tr>";
			echo "<td width=65 height=75><table class='table-photo'>";
			echo "<tr><td align=center width=65>";
			show_photo($row->mem_id);
			echo "</td><tr><td align=center>";
			show_online($row->mem_id);
			echo "</td></table></td>";
			if($ss==7)	{
				echo "</tr>";
				$ss=0;
			}
			$ss++;
		}
	}
}
?>
