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
if($act=='create')	create_listing();
elseif($act=='all')	show_listing_cats();
elseif($act=='show_cat')	show_cat_list();
elseif($act=='show_sub_cat')	show_sub_cat_list();
elseif($act=='show')	show_listing();
elseif($act=='forward')	forward_listing();
elseif($act=='filter')	set_filter();
elseif($act=='feedback')	feedback();
elseif($act=='manage')	{
	$pro=form_get("pro");
	if($pro=='')	manage(0);
	else	manage(1);
}
elseif($act=='delete')	del_listing();

//creating listing
function create_listing()	{
$m_id=cookie_get("mem_id");
global $lng_id;
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$trb_id=form_get("trb_id");
if($trb_id!=''){
  tribe_access_test($m_id,$trb_id);
}

$pro=form_get("pro");
//showing first step of create listing
if($pro==''){
$sql_query="select * from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
show_header();
    ?>

<form method="post" name="manageListing" enctype="multipart/form-data" action="index.php">
<input type="hidden" name="mode" value="m_listings">
<input type="hidden" name="act" value="create">
<input type="hidden" name="pro" value="predone">
<input type="hidden" name='trb_id' value='<? echo $trb_id; ?>'>

<table width="100%" cellpadding="14" class="body">
<tr>
<td align="center">
        <table width="696" cellpadding="0" cellspacing="1" border="0" align="left">
          <tr>
<td class="lined" colspan="3">
<table width="100%" height="20" cellpadding="0" cellspacing="0" border="0">
<tr>
<td align="left" class="title">
<?=LNG_MLIST_SETP1?>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="lined" colspan="2" align="center" valign="top">
<table cellpadding="0" cellspacing="20" border="0">
<tr>
<td align="left" valign="top">
                    <table cellpadding="0" cellspacing="10" border="0" align="left">
                      <tr>
<td colspan="2" align="left" valign="middle">
<span class="subtitle">
<?=LNG_LISTING_MSG_A?>
</span>
<br/>
<span class="body">
</span>
</td>
</tr>
<tr>
<td height="10">
<img src="images/onepix.gif">
</td>
</tr>
<tr>
<td align="left" valign="top">
<span class="body">
<br/>
<nobr>
<?=LNG_CATEGORY?>&nbsp;
</nobr>
</span>
<br/>
<span class="form-comment"><?=LNG_LISTING_REQUIRED?></span>
</td>
<td colspan="1" align="left" valign="top">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td align="left" valign="top">
<div class="form-comment">
&nbsp;<?=LNG_LISTING_SEL_A_CAT?>
</div>
<select name="message_rootCategoryId" size="5" onChange="listmessage_categoryId.populate();" width="150" style="width: 150px">
<? listing_mcats(''); ?>
</select>
</td>
<td>
<img src="images/onepix.gif" width="10">
</td>
<td align="left" valign="top">
<div class="form-comment">
&nbsp;<?=LNG_LISTING_SET_A_SUB_CAT?>
</div>
<select name="message_categoryId" size="5" width="150" style="width: 150px">
<SCRIPT LANGUAGE="JavaScript">listmessage_categoryId.printOptions();</script>
</select>
</td>
</tr>
<tr>
                              <td colspan="3"> <span class="body"> <br>
                                <?=LNG_LISTING_MSG_B?> 
                                <p> <?=LNG_LISTING_MSG_C?> </p>
                                </span> </td>
</tr>
</table>
</td>
<td rowspan="1" align="left" valign="top">
<img src="images/onepix.gif" height="10">
<div class="form_tip lined padded-6">
<span class="body">
<?=LNG_LISTING_MSG_D?>
</span>
</div>
</td>
</tr>
<tr>
<td height="10">
<img src="images/onepix.gif">
</td>
</tr>
<tr>
<td align="left" valign="top">
<span class="body">
<nobr>
<?=LNG_TITLE?>&nbsp;
</nobr>
<br/>
<span class="form-comment"><?=LNG_LISTING_REQUIRED?></span>
</span>
</td>
<td align="left" valign="top">
<span class="body">
<input type="text" size="48" name="title" value=""/>
</span>
</td>
<td rowspan="2" align="left" valign="top">
<div class="form_tip lined padded-6">
<span class="body">
<?=LNG_LISTING_MSG_E?>
</span>
</div>
</td>
</tr>
<tr>
<td height="10">
<img src="images/onepix.gif">
</td>
</tr>
<tr>
                        <td align="left" valign="middle"> <span class="body"> 
                          <nobr> <?=LNG_DESCRIPTION?>&nbsp; </nobr> </span> </td>
<td align="left" valign="middle">
<span class="subtitle">
<textarea name="description" rows="6" cols="50"></textarea>
</span>
</td>
</tr>
<tr>
<td align="left" valign="middle">
<span class="body">
<nobr>
<?=LNG_ZIP_POSTAL_CODE?>&nbsp;
</nobr>
</span>
</td>
<td align="left" valign="middle">
<span class="body">
<input type="text" size="10" name="zip" value="<? echo $mem->zip; ?>"/>
<br/>
<span class="form-comment">
<?=LNG_LISTING_MSG_F?>
</span>
</span>
</td>
<td rowspan="1" align="left" valign="top">
<div class="form_tip lined padded-6">
<span class="body">
<?=LNG_LISTING_MSG_G?>
</span>
</div>
</td>
</tr>
<tr>
<td>
<img src="images/onepix.gif" height="20">
</td>
</tr>
<tr>
<td align="left" valign="middle">
<span class="body">
<nobr>
<?=LNG_PHOTO?>
</nobr>
</span>
<br/>
<span class="form-comment">
<?=LNG_LISTING_MSG_H?>
</span>
</td>
<td align="left" valign="middle">
<span class="body">
<nobr>
<input type="file" name="photo"/>
</nobr>
</span>
</td>
<td rowspan="1" align="left" valign="top">
<div class="form_tip lined padded-6">
<span class="body">
<?=LNG_LISTING_MSG_I?>
</span>
</div>
</td>
</tr>
<tr>
<td>
<img src="images/onepix.gif" height="20">
</td>
</tr>
<tr><td class='body'><?LNG_LISTING_MSG_J?> ?</td>
<td class='body'><select name='live'>
<?
for($i=1;$i<=30;$i++){
  echo "<option value='$i'>$i</option>\n";
}
?>
</select> <?=LNG_LISTING_MSG_K?></td>
<tr>
<td>
<span class="body">
<?=ucfirst(LNG_JOIN_PRIV)?>
</span>
</td>
<td align="left" valign="top">
<span class="body">
<nobr>
<input type="checkbox" name="show_pic" value="0" >
<?=LNG_LISTING_MSG_L?>
</nobr>
</span>
</td>
</tr>
<tr>
<td></td>
<td align="left" valign="top">
<span class="body">
<nobr>
<input type="checkbox" name="anonim" value="1" >
<?=LNG_LISTING_MSG_M?>
</nobr>
</span>
</td>
</tr>
<tr>
<td colspan="3" height="10" align="right">
<hr color="#c0c0c0" size="1" width="100%">
<span class="body">
<?=LNG_LISTING_MSG_N?>.
</span>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="lined" width="500" align="center" valign="middle">
<table width="100%" height="34" cellpadding="0" cellspacing="6">
<tr>
<td bgcolor="#C0C0C0" class="tip-title">
<?=LNG_TIPS?>
</td>
<td width="100%" bgcolor="#E5E5E5" class="tip-text">
<?=LNG_LISTING_MSG_O?>
</td>
</tr>
</table>
</td>
<td class="lined" align="center" valign="middle">
<nobr>
              <input type="submit" value="<?=LNG_MLIST_CREATE_ADD?>">
&nbsp;
<input type="submit" name="onclick='javascript:history(-1)'" value="<?=LNG_CANCEL?>"/>
</nobr>
</td>
</tr>
</table>
</td>
</tr>
</table>
</form>
    <?
    show_footer();
}//if
elseif($pro=='predone'){
global $_FILES,$base_path;
//getting values
       $cat_id=form_get("message_rootCategoryId");
       $sub_cat_id=form_get("message_categoryId");
       $title=form_get("title");
       $description=form_get("description");
       $zip=form_get("zip");
       $privacy=form_get("show_pic");
       $anonim=form_get("anonim");
       $tmpfname=$_FILES['photo']['tmp_name'];
	   $ftype=$_FILES['photo']['type'];
	   $fsize=$_FILES['photo']['size'];
       $trb_id=form_get("trb_id");
       $live=form_get("live");

       if(($cat_id=='')||($sub_cat_id=='')||($title=='')||($description=='')){
         error_screen(3);

       }

       //if photo uploaded - checking if the type is OK
       if($tmpfname!=''){
if($ftype=='image/bmp'){
  $p_type=".bmp";
}
elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg')){
  $p_type=".jpeg";
}
elseif($ftype='image/gif'){
  $p_type=".gif";
}
else {
  error_screen(9);
}
$rand=rand(0,10000);
$newname=md5($m_id.time().$rand);

//saving file
	move_uploaded_file($tmpfname,"photos/".$newname.$p_type);
       }//if

        $now=time();
        //creating description part (limited by 10 words)
        $part=split(" ",$description);
        $descr_part='';
        for($i=0;$i<10;$i++){
           $descr_part.=" ".$part[$i];
        }
        if($anonim=='1'){
           $ano='y';
        }
        else {
           $ano='n';
        }
        $member=$m_id;
        if($privacy==''){
            $pr='n';
        }
        else{
            $pr='y';
        }

        if($tmpfname!=''){
        $photo="photos/".$newname.$p_type;
        }
        else {
        $photo='no';
        }

        //updating db
        $live=$live*24*60*60;
        $sql_query="insert into music_listings(cat_id,sub_cat_id,mem_id,added,title,description,descr_part,
        photo,privacy,zip,live,anonim) values('$cat_id','$sub_cat_id','$member','$now','$title','$description',
        '$descr_part','$photo','$pr','$zip','$live','$ano')";
        sql_execute($sql_query,'');
        $sql_query="select max(lst_id) as maxid from music_listings";
        $max=sql_execute($sql_query,'get');

        //showing 2 step of create listing
        show_header();
        ?>

                <table width=100% class=body>
                <form action='index.php' method=post>
                <input type="hidden" name='mode' value='m_listings'>
                <input type="hidden" name='act' value='create'>
                <input type="hidden" name='pro' value='done'>
                <input type="hidden" name='lst_id' value='<? echo $max->maxid; ?>'>
                  <tr><td class='lined title'><?=LNG_LISTING_MSG_Q?>: <? echo $title; ?></td>
                  <tr><td class='lined padded-6'>
                     <table width=100% class=body>
                     <tr><td colspan=2><span class=maingray><?=LNG_LISTING_MSG_R?></span></br>
                     <?=LNG_MLIST_LNG_MSGA?>.</td>
                     <tr><td valign=top width=25%><?=LNG_MLIST_SHOW_CLLIST?></td><td>
                     <input type=radio name='degrees' value='1'><?=LNG_LISTING_MSG_U?> - <? echo count_network($m_id,"1","num"); ?> <?=LNG_LISTING_MSG_V?></br>
                     <input type=radio name='degrees' value='2'><?=LNG_LISTING_MSG_W?> - <? echo count_network($m_id,"2","num"); ?> <?=LNG_LISTING_MSG_V?></br>
                     <input type=radio name='degrees' checked value='4'><?=LNG_LISTING_MSG_X?> - <? echo count_network($m_id,"all","num"); ?> <?=LNG_LISTING_MSG_V?></br>
                     <input type=radio name='degrees' value='any'><?=LNG_LISTING_MSG_Y?></br>
                     <input type=radio name='degrees' value='trb'><?=LNG_LISTING_MSG_Z?></br>
                     </td>
                     <tr><td><?=LNG_LISTING_MSG_ZA?></td><td><select name=tribe>
                     <option value=''><?=LNG_SELECT_GROUP?>
                     <? drop_mem_tribes($m_id,$trb_id); ?>
                     </select>
                     </td>
                     <tr><td></td><td><span class='form-comment'><?=LNG_MLIST_ABC?></span></td>
                     <tr><td colspan=2><?=LNG_LISTING_MSG_ZC?></td>
                     <tr><td colspan=2>&nbsp;</td>
                     <tr><td colspan=2 class='maingray'><?=LNG_MLIST_TELL_OTHER?></td>
                     <tr><td colspan=2><?=LNG_MLIST_FW_EMAIL?>.</td>
                     <tr><td valign=top><?=LNG_LISTING_MSG_ZF?></br>
                     <span class='form-comment'><?=LNG_MLIST_FRND_INVTIE?></span></td>
                     <td><textarea rows=5 cols=45 name='emails'></textarea></td>
                     <tr><td><?=LNG_SUBJECT?></br>
                     <span class='form-comment'>(<?=LNG_MLIST_FREE_FEEL?>)</span></td>
                     <td valign='top'><input type='text' name='subj' value='<? echo name_header($m_id,"ad"); ?> <?=LNG_LISTING_MSG_ZI?> (<? echo $title; ?>) '></td>
                     <tr><td><?=LNG_YOUR_MSG?></td><td><textarea name='mes' rows='5' cols='45'><?=LNG_MLIST_CRT_LIST?> "<? echo $title; ?>" .  <?=LNG_LISTING_MSG_ZK?>
<?
global $main_url,$lng_id;
//creating just created listing link
$link=$main_url."/index.php?mode=m_listings&act=show&lst_id=".$max->maxid."&lng=".$lng_id;
echo "<a href='$link'>$link</a>"; ?>

<?=LNG_MLIST_MSG_BROW?>
                     </textarea></td>
                     <tr><td></td><td align=right><input type=submit value='<?=LNG_LISTING_MSG_PUBLISH?>'>
                     &nbsp<input type='button' value='<?=LNG_CANCEL?>' onClick='window.location="index.php?mode=login&act=home&lng=<?=$lng_id?>"'></td>
                     </table>
                  </td></form>
                </table>

        <?
        show_footer();

}//elseif
elseif($pro=='done'){
//getting values
$degrees=form_get("degrees");
$tribe=form_get("tribe");
$emails=form_get("emails");
$subj=form_get("subj");
$mes=form_get("mes");
$lst_id=form_get("lst_id");
$emails=ereg_replace(" ","",$emails);

//deleting listings, which weren't activated for 1 hour
$interval=time()-60*60;
$sql_query="delete from music_listings where added<$interval and stat='p'";
sql_execute($sql_query,'');

//updating db and activating listing
$sql_query="update music_listings set show_deg='$degrees',trb_id='$tribe',stat='a' where lst_id='$lst_id'";
sql_execute($sql_query,'');

   //sending emails to friends of lister
   if($emails!=''){
   $email=split(",",$emails);
   $email=if_empty($email);
   $data[0]=$subj;
   $data[1]=$mes;
   $data[2]=name_header($m_id,"ad");
   $sql_query="select email from members where mem_id='$m_id'";
   $k=sql_execute($sql_query,'get');
   $data[3]=$k->email;
   $now=time();
   foreach($email as $addr){
       messages($addr,"7",$data);
   }//foreach
   }//if

   //redirect
   global $main_url,$lng_id;
   if($tribe!=''){
   $link=$main_url."/index.php?mode=tribe&act=show&trb_id=$tribe&lng=$lng_id";
   }//if
   else {
   $link=$main_url."/index.php?mode=login&act=home&lng=$lng_id";
   }//else
   show_screen($link);

}//elseif
}//function

//showing listing categories list
function show_listing_cats(){
$m_id=cookie_get("mem_id");
global $lng_id;
$sql_query="select cat_id from music_categories";
$res=sql_execute($sql_query,'res');
$cats=array();
while($cat=mysql_fetch_object($res)){
  array_push($cats,$cat->cat_id);
}//while

//find middle of array
if(count($cats)>2)	$mid=(int)(count($cats)/2)+2;
else	$mid=count($cats);
show_header();
?>
  <table width=100%>

      <tr>
    <td width=75% valign="top"> 
      <table width=100%>
               <tr><td class="lined title"><?=LNG_LISTING_MSG_ZN?></td>
               <tr><td class="lined">

                    <table width=100%>
                        <tr><td valign=top>
                        <?
                           for($i=0;$i<$mid;$i++){

                               $sql_query="select name from music_categories where cat_id='$cats[$i]'";
                               $cat=sql_execute($sql_query,'get');
                               $cat_name=strtoupper($cat->name);
                               $sql_query="select lst_id from music_listings where cat_id='$cats[$i]'";
                               $l_num=sql_execute($sql_query,'num');
                               echo "<span class='body'><b><a href='index.php?mode=m_listings&act=show_cat&cat_id=$cats[$i]&lng=$lng_id'>$cat_name ($l_num)</a></b></span></br>";

                               $sql_query="select sub_cat_id,name from music_sub_categories where cat_id='$cats[$i]'";
                               $res=sql_execute($sql_query,'res');
                               while($sub=mysql_fetch_object($res)){

                                   echo "&nbsp&nbsp&nbsp&nbsp";
                                   echo "<span class='form-comment'>
                                   <a href='index.php?mode=m_listings&act=show_sub_cat&sub_cat_id=$sub->sub_cat_id&lng=$lng_id'>$sub->name</a></span></br>";

                               }//while

                           }//for
                        ?>
                        </td>
                        <td valign=top>
                        <?
                           for($i=$mid;$i<count($cats);$i++){

                               $sql_query="select name from music_categories where cat_id='$cats[$i]'";
                               $cat=sql_execute($sql_query,'get');
                               $cat_name=strtoupper($cat->name);
                               $sql_query="select lst_id from music_listings where cat_id='$cats[$i]'";
                               $l_num=sql_execute($sql_query,'num');
                               echo "<span class='body'><b><a href='index.php?mode=m_listings&act=show_cat&cat_id=$cats[$i]&lng=$lng_id'>$cat_name ($l_num)</a></b></span></br>";

                               $sql_query="select sub_cat_id,name from music_sub_categories where cat_id='$cats[$i]'";
                               $res=sql_execute($sql_query,'res');
                               while($sub=mysql_fetch_object($res)){

                                   echo "&nbsp&nbsp&nbsp&nbsp";
                                   echo "<span class='form-comment'>
                                   <a href='index.php?mode=m_listings&act=show_sub_cat&sub_cat_id=$sub->sub_cat_id&lng=$lng_id'>$sub->name</a></span></br>";

                               }//while

                           }//for
                        ?>
                        </td>

                    </table>

               </td>
               <tr><td class="lined title"><?=LNG_MLIST_MY_CL_LST?></td>
               <tr><td class="lined body"><? show_listings("my",$m_id,''); ?></td>
			   <tr><td class=lined>
			   	<input type=button value='<?=LNG_PROFILE_CRT_LISTING?>' onClick='window.location="index.php?mode=listing&act=create&lng=<?=$lng_id?>"'></td>
           </table>

      </td>
      <td valign=top>

           <table class='body'>
                <tr><td align=center class='lined padded-6'><input type=button value='<?=LNG_PROFILE_CRT_LISTING?>' onClick='window.location="index.php?mode=m_listings&act=create&lng=<?=$lng_id?>"'></td>
                <tr><td class="lined title"><?=LNG_LISTING_MSG_ZO?></td>
                <tr><td class="lined padded-6">
                <form action='index.php' method=post name='musicsearchListing'>
                <input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="listing">
                    <?=LNG_KEYWORDS?> <input type=text name='keywords'></br>
	<?=LNG_CATEGORY?> <select name="RootCategory" onChange="listCategory.populate();" width="140" style="width: 140px">
	<option value=""><?=LNG_LISTING_MSG_SEL_CAT?></option>
	<? listing_mcats(''); ?>
	</select>
	<br>
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
				<option value="25"><?=LNG_25_MILES?>
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

//showing listings of one category
function show_cat_list(){
$m_id=cookie_get("mem_id");
global $lng_id;
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$page=form_get("page");
if($page==''){
  $page=1;
}

$cat_id=form_get('cat_id');
$sql_query="select name from music_categories where cat_id='$cat_id'";
$cat=sql_execute($sql_query,'get');
$sql_query="select name,sub_cat_id from music_sub_categories where cat_id='$cat_id'";
$res=sql_execute($sql_query,'res');
show_header();
     ?>
  <table width=100%>

      <tr><td width=75% valign=top>

           <table width=100%>
               <tr><td class="lined title"><?=LNG_LISTING_MSG_ZN?></td>
               <tr><td class="lined" align=center><?
                     $line='';
                     while($sub=mysql_fetch_object($res)){

                     $line.="<span class='form-comment'>
                     <a href='index.php?mode=m_listings&act=show_sub_cat&sub_cat_id=$sub->sub_cat_id&lng=$lng_id'>$sub->name</a></span>";
                     $line.=" | ";

               }//while
               $line=rtrim($line,' | ');
               echo $line;
               ?></td>
               <tr><td class="lined body">
                    <? show_listings('cat',$m_id,"$page"); ?>

               </td>
               <tr><td class='lined body' align=center><? pages_line($cat_id,"cat","$page","20"); ?></td>
               <tr><td class=lined><input type=button value='<?=LNG_PROFILE_CRT_LISTING?>' onClick='window.location="index.php?mode=m_listings&act=create&lng=<?=$lng_id?>"'></td>
               <tr><td class="lined title"><?=LNG_MY_LISTINGS?></td>
               <tr><td class="lined body"><? show_listings("my",$m_id,''); ?></td>
           </table>

      </td>
      <td>

           <table>
                <tr><td align=center class='lined padded-6'><input type=button value='<?=LNG_PROFILE_CRT_LISTING?>' onClick='window.location="index.php?mode=m_listings&act=create&lng=<?=$lng_id?>"'></td>
                <tr><td class="lined title"><?=LNG_LISTING_MSG_ZO?></td>
                <tr><td class="lined padded-6 body">
                <form action='index.php' method=post name='searchListing'>
                <input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="listing">
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

//showing listings of one sub-category
function show_sub_cat_list(){
$m_id=cookie_get("mem_id");
global $lng_id;
$page=form_get("page");
if($page==''){
  $page=1;
}

$sub_cat_id=form_get('sub_cat_id');
$sql_query="select cat_id from music_sub_categories where sub_cat_id='$sub_cat_id'";
$cat=sql_execute($sql_query,'get');
$cat_id=$cat->cat_id;
$sql_query="select name,sub_cat_id from music_sub_categories where cat_id='$cat_id'";
$res=sql_execute($sql_query,'res');
show_header();
     ?>
  <table width=100%>

      <tr><td width=75% valign=top>

           <table width=100%>
               <tr><td class="lined title"><?=LNG_LISTING_MSG_ZN?></td>
               <tr><td class="lined" align=center><?
                     $line='';
                     while($sub=mysql_fetch_object($res)){


                     if($sub_cat_id==$sub->sub_cat_id){
                     $line.="<span class='body'>
                     $sub->name</span>";
                     $line.=" | ";
                     }
                     else{
                     $line.="<span class='form-comment'>
                     <a href='index.php?mode=m_listings&act=show_sub_cat&sub_cat_id=$sub->sub_cat_id&lng=$lng_id'>$sub->name</a></span>";
                     $line.=" | ";
                     }

               }//while
               $line=rtrim($line,' | ');
               echo $line;
               ?></td>
               <tr><td class="lined body">
                    <? show_listings('sub_cat',$m_id,"$page"); ?>

               </td>
               <tr><td class='lined body' align=center><? pages_line($sub_cat_id,"sub_cat","$page","20"); ?></td>
               <tr><td class=lined><input type=button value='<?=LNG_PROFILE_CRT_LISTING?>' onClick='window.location="index.php?mode=m_listings&act=create&lng=<?=$lng_id?>"'></td>
               <tr><td class="lined title"><?=LNG_MLIST_MY_CL_LST?></td>
               <tr><td class="lined body"><? show_listings("my",$m_id,''); ?></td>
           </table>

      </td>
      <td>

           <table class='body'>
                <tr><td align=center class='lined padded-6'><input type=button value='<?=LNG_PROFILE_CRT_LISTING?>' onClick='window.location="index.php?mode=m_listings&act=create&lng=<?=$lng_id?>"'></td>
                <tr><td class="lined title"><?=LNG_LISTING_MSG_ZO?></td>
                <tr><td class="lined padded-6">
                <form action='index.php' method=post name='searchListing'>
                <input type=hidden name="mode" value="search">
				<input type=hidden name="act" value="listing">
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

function show_listing(){
$m_id=cookie_get("mem_id");
global $lng_id;
//updating history of user's surfing the site
$lst_id=form_get('lst_id');
if($m_id!=''){
  $sql_query="select history from members where mem_id='$m_id'";
  $mem=sql_execute($sql_query,'get');
  $hist=split("\|",$mem->history);
  $hist=if_empty($hist);
  if($hist==''){
    $hist[]='';
  }
  $adding="index.php?mode=m_listings&act=show&lst_id=$lst_id&lng=$lng_id";
  if(!in_array($adding,$hist)){
  $sql_query="select title from music_listings where lst_id='$lst_id'";
  $lst=sql_execute($sql_query,'get');
  $addon="|$adding|".$lst->title;
  if(count($hist)>=10){
     for($i=2;$i<count($hist);$i++){
         $line.=$hist[$i]."|";
     }//for
     $line.=$addon;
     $sql_query="update members set history='$line' where mem_id='$m_id'";
  }//if
  else {
  $sql_query="update members set history=concat(history,'$addon') where mem_id='$m_id'";
  }//else
  sql_execute($sql_query,'');
  }//if
}//if
//showing the listing
$sql_query="select * from music_listings where lst_id='$lst_id'";
$lst=sql_execute($sql_query,'get');

    $date=date("m/d/y h:i A",$lst->added);
    show_header();
    ?>
    <table width=100%>
    <tr><td valign=top>
    <table class="body" width=100%>
           <tr><td class="lined padded-6"><?=LNG_MLIST_VIEW_A_LISTING?></td>
           <tr><td class="lined padded-6">
        <table class="body" width=100%>
            <tr><td align=right class="title"><?=LNG_MLIST_LISTER?></td>
            <td>
            <table class="body lined" cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 class='lined-right padded-6' width=65 align=center height=75><?
               if(($lst->privacy=='y')||($lst->anonim=='y')){
                   echo "<img src='images/unknownUser_th.jpg' border=0>";
               }//if
               else {
                  show_photo($lst->mem_id);
               }//else
               ?></br>
               <?
               if($lst->anonim!='y'){
               show_online($lst->mem_id);
               }
               else {
               echo LNG_ANONYMOUS;
               } ?>
               </td>
               <? if($lst->anonim!='y'){
               ?>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$lst->mem_id); ?></td>
               <tr><td class="padded-6"><?=LNG_NET_WK?>: <a href='index.php?mode=people_card&act=friends&p_id=<? echo $lst->mem_id; ?>&lng=<?=$lng_id?>'><? echo count_network($lst->mem_id,"1","num"); ?> <?=strtolower(LNG_FRNDS)?></a> <?=LNG_IN_A?>
               <a href='index.php?mode=people_card&act=network&p_id=<? echo $lst->mem_id; ?>&lng=<?=$lng_id?>'><?=LNG_NETWORK_OF?> <? echo count_network($lst->mem_id,"all","num"); ?></a>
               </td>
               <? } ?>
            </table>
            </td>
            <form name="listing" action="index.php">
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="lst">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="lst_id" value="<? echo $lst_id; ?>">
            <tr><td align=right class="title"><?=LNG_DATE?></td>
            <td>
            <? echo $date; ?>
            </td>
            <tr><td align=right class="title"><?LNG_TITLE?></td>
            <td>
            <? echo $lst->title; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_MESSAGE?></td>
            <td>
            <?
            $description=ereg_replace("\n","</br>",$lst->description);
            echo $description; ?></td>

            <?
                  $sql_query="select city,state from zipData where zipcode='$lst->zip'";
                  $num=sql_execute($sql_query,'num');
                  if($num!=0) {
                  echo '<tr><td align=right class="title">'.LNG_LOCATION.'</td>
                  <td>';
                     $loc=sql_execute($sql_query,'get');
                     $city=strtolower($loc->city);
                     $city=ucfirst($city);
                     $location=$city.", ".$loc->state;
                     echo $location."</td>";
                  }

            ?>
            <tr><td align=right class="title"><?=LNG_LISTING_MSG_LST_IN?></td>
            <td>
            <?
            $sql_query="select name from music_categories where cat_id='$lst->cat_id'";
            $c_name=sql_execute($sql_query,'get');
            $sql_query="select name from music_sub_categories where sub_cat_id='$lst->sub_cat_id'";
            $sub_c_name=sql_execute($sql_query,'get');
            echo "<a href='index.php?mode=m_listings&act=show_cat&cat_id=$lst->cat_id&lng=$lng_id'>$c_name->name</a>&nbsp&gt;&nbsp<a
            href='index.php?mode=m_listings&act=show_sub_cat&sub_cat_id=$lst->sub_cat_id&lng=$lng_id'>$sub_c_name->name</a>";
            ?></td>
            <tr><td align=right class="title"><?=LNG_LISTING_MSG_FEEDBACK?>?</td>
            <td>
            <?
            echo "<a href='index.php?mode=m_listings&act=feedback&pro=best&lst_id=$lst_id&lng=$lng_id'>".LNG_LISTING_MSG_BE."</a> |
            <a href='index.php?mode=m_listings&act=feedback&pro=spam&lst_id=$lst_id&lng=$lng_id'>".LNG_LISTING_MSG_SPAM."</a> |
            <a href='index.php?mode=m_listings&act=feedback&pro=mature&lst_id=$lst_id&lng=$lng_id'>".LNG_LISTING_MSG_MATURE."</a> |
            <a href='index.php?mode=m_listings&act=feedback&pro=mis-cat&lst_id=$lst_id&lng=$lng_id'>".LNG_LISTING_MCC."</a> |
            <a href='index.php?mode=m_listings&act=feedback&pro=repeat&lst_id=$lst_id&lng=$lng_id'>".LNG_LISTING_RPL."</a>";
            ?></td>
            <?
            if($lst->trb_id!='0'){
            $sql_query="select name from tribes where trb_id='$lst->trb_id'";
            $trb=sql_execute($sql_query,'get');
            echo "<tr><td align=right class='title'>".LNG_LISTING_ALIG."</td>
            <td>";
            echo "<a href='index.php?mode=tribe&act=show&trb_id=$lst->trb_id&lng=$lng_id'>$trb->name</a></td>";
            }//if
            ?>
            <tr><td colspan=2 align=center><? if($lst->photo!='no'){
            echo "<img src='$lst->photo' border=0>";
            } ?></td>
            <tr><td colspan=2 align=right><input type="submit" onClick="this.form.pro.value='forw'" value="<?=LNG_LISTING_FORD?>">
            <? if($lst->anonim!='y'){ ?><input type="submit" onClick="this.form.pro.value='reply'" value="<?=LNG_REPLY?>"><? } ?></td>
        </table>
      </td>
  </table></td>
  <td valign=top>
	<table class="body" width=100%>
    <tr><td><table class="lined body">
    <tr><td class=lined><? show_photo($m_id); ?></br>
    <? show_online($m_id); ?>
    </td>
    <td><?=LNG_PROFILE_MS?> <? echo member_since($m_id); ?>
    </br></br>
    <a href='index.php?mode=people_card&act=friends&p_id=<? echo $m_id; ?>&lng=<?=$lng_id?>'><? echo count_network($m_id,"1","num"); ?> <?=LNG_FRNDS?></a></br>
    <a href='index.php?mode=people_card&act=network&p_id=<? echo $m_id; ?>&lng=<?=$lng_id?>'><? echo count_network($m_id,"all","num"); ?> <?=LNG_LOGIN_IN_MY_NET?></a></br>&nbsp
    </td>
    </table></td>
    <tr><td>
        <table class="shade lined body" width=100%>
        <tr><td class="bodygray bold"><?=strtoupper(LNG_PEOCARD_WHT_CAN_I_DO)?></td>
        <? if($m_id==$lst->mem_id){ ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=m_listings&act=manage&lst_id=<? echo $lst_id; ?>&lng=<?=$lng_id?>">
           <?=LNG_MLIST_MANAGE_LIST?>
           </a></td>
        <? } ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=m_listings&act=create&lng=<?=$lng_id?>">
           <?=LNG_PROFILE_CRT_LISTING?>
           </a></td>
           <? $sql_query="select bmr_id from bmarks where mem_id='$m_id' and type='listing'
           and sec_id='$lst_id'";
           $num=sql_execute($sql_query,'num');
           if($num==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $lst_id; ?>&type=listing&lng=<?=$lng_id?>">
           <?=LNG_BOOKMARKS?> <? echo "\"".$lst->title.'"'; ?>
           <?
           }
           else {
             $bmr=sql_execute($sql_query,'get');
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>&lng=<?=$lng_id?>">
           <?=LNG_PROFILE_UN_BK_MARK?> <? echo "\"".$lst->title.'"'; ?>
           <?
           }
           ?>
           <? if ($lst->anonim!='y'){
           ?>
           <tr><td><img src="images/medicon_person.gif">
           <a href="javascript:document.listing.pro.value='reply';document.listing.submit();">
           <?=LNG_LISTING_RTO_LIST?>
           </a></td>
           <? } ?>
           <tr><td><img src="images/medicon_network.gif">
           <a href="javascript:document.listing.pro.value='forw';document.listing.submit();">
           <?=LNG_LISTING_FRD_LISTING?>
           </a></td>

        </table></form>
    </td>
      <?
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
     }
     else {
        echo "     <tr><td>
        <table class='td-shade lined body' width=100%>
             <tr><td bgcolor=white class='bodygray bold'>".LNG_MY_BOOKMARKS."</td>";
       $res=sql_execute($sql_query,'res');
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){

                  echo "<tr><td><img src='images/medicon_person.gif' border=0><a href='index.php?mode=people_card&p_id=$bmr->sec_id&lng=$lng_id'>".name_header($bmr->sec_id,$m_id)."</a></td>";

              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from music_listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/icon_listing.gif' border=0>
                  &nbsp&nbsp<a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id&lng=$lng_id'>".
                  $lst->title."</a>
                  </td>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/medicon_tribe.gif' border=0>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id&lng=$lng_id'>".
                  $trb->name."</a>
                  </td>";

              }//elseif

       }//while
     echo "</table></td>";
     }//else
             ?>

    </table>
</td></table>
  <?
show_footer();
}//function

//feedback recording
function feedback(){
global $admin_mail,$system_mail,$lng_id;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$lst_id=form_get('lst_id');
$type=form_get("pro");
$now=time();

//adding record to admin db
$sql_query="insert into music_lst_feedback(lst_id,mem_id,folder,pro,date,new)
 values('$lst_id','$m_id','inbox','$type','$now','new')";
sql_execute($sql_query,'');

complete_screen(8);

}//function

//forward listing
function forward_listing(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
global $lng_id;
$lst_id=form_get('lst_id');
$frw=form_get('frw');
if($frw==''){
show_header();
?>
  <table width=100% class="body">
     <tr><td class="lined title"><?=LNG_LISTING_F_A_L?></td>
     <tr><td class="lined padded-6">
     <?=LNG_MLIST_PER_MSG_FLIST?></br></br>
	 <?=LNG_LISTING_LNG_MSG?>.</br></br>
     <table class="body">
     <form action='index.php' method='post'>
     <input type='hidden' name='mode' value='listing'>
     <input type='hidden' name='act' value='forward'>
     <input type='hidden' name='frw' value='done'>
     <input type='hidden' name='lst_id' value='<? echo $lst_id; ?>'>
     <tr><td><?=LNG_SUBJECT?></td><td><input type='text' size=25 name='subject' value='Listing Forward'></td>
     <tr><td><?=LNG_YOUR_MSG?></td><td><textarea rows=5 cols=45 name='body'></textarea></td>
     <tr><td><?=LNG_YOUR_FRIENDS?></td><td><select name='rec_id[]'>
     <? drop_friends($m_id); ?>
     </select></br>
     <select name='rec_id[]'>
     <? drop_friends($m_id); ?>
     </select></br>
     <select name='rec_id[]'>
     <? drop_friends($m_id); ?>
     </select>
     </td>
     <tr><td colspan=2 align=right><input type='button' value="<?=LNG_CANCEL?>" onClick='window.location="index.php?mode=listing&act=show&lst_id=<? echo $lst_id; ?>&lng=<?=$lng_id?>"'>&nbsp<input type='submit' value='<?=LNG_SEND?>'></td>
     </table></td>
     </td>
  </table>
<?
show_footer();
}//if
elseif($frw=='done'){
global $main_url,$lng_id;

     //creating listing link
     $lst_link=$main_url."/index.php?mode=m_listings&act=show&lst_id=$lst_id&lng=$lng_id";
     $lst_link=urlencode($lst_link);
     $subject=urlencode(form_get('subject'));
     $body=urlencode(form_get('body'))." $lst_link";
     $rec_id=form_get('rec_id');
     $rec_id=if_empty($rec_id);
     if($rec_id==''){
        $link=$main_url."/index.php?mode=m_listings&act=show&lst_id=$lst_id&lng=$lng_id";
     }//if
     else {
     $link=$main_url."/index.php?mode=messages&act=compose&done=done&subject=$subject";
     $link.="&answer=$body&lng=$lng_id";

     foreach($rec_id as $rec){
       $link.="&rec_id[]=$rec";
     }//foreach
     }//else

     //going to messages system to continue forward listing
     show_screen($link);

}//elseif
}//function

//set filter on home page display of recent listings
function set_filter(){
global $main_url,$lng_id;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$distance=form_get("distance");
$degrees=form_get("degrees");
$zip=form_get("zip");

$filter="$distance|$zip|$degrees";

$sql_query="update members set filter='$filter' where mem_id='$m_id'";
sql_execute($sql_query,'');

$link=$main_url."/index.php?mode=login&act=home&lng=$lng_id";
show_screen($link);

}//function

function manage($mod){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
global $lng_id;
login_test($m_id,$m_pass);
$lst_id=form_get("lst_id");
$sql_query="select * from music_listings where lst_id='$lst_id'";
$lst=sql_execute($sql_query,'get');
if($m_id!=$lst->mem_id){
  error_screen(28);
}//if
if($mod==0){
$sql_query="select * from music_listings where lst_id='$lst_id'";
$lst=sql_execute($sql_query,'get');
show_header();
?>
   <table width=100%>
   <tr><td class='lined title'><?=LNG_LISTING_EDL?></td>
   <tr><td class='lined padded-6'>
   <table class='body'>
         <form action='index.php' method=post name='searchListing'>
         <input type='hidden' name='mode' value='listing'>
         <input type='hidden' name='act' value='manage'>
         <input type='hidden' name='lst_id' value='<? echo $lst_id; ?>'>
         <input type='hidden' name='pro' value='done'>
         <tr><td><?LNG_TITLE?></td><td><input type='text' name='title' value='<? echo $lst->title; ?>'></td>
         <tr><td><?=LNG_CATEGORY?></td><td><select name="RootCategory" onChange="listCategory.populate();" width="140" style="width: 140px">
		<option value=""><?=LNG_LISTING_MSG_SEL_CAT?></option>
        <? listing_cats("$lst->cat_id"); ?>
       	</select>&nbsp<select name="Category" width="140" style="width: 140px">
	   				  <SCRIPT LANGUAGE="JavaScript">listCategory.printOptions();</script>
	   	</select>
	   	<SCRIPT LANGUAGE="JavaScript">listCategory.setDefaultOption("<? echo $lst->cat_id; ?>","<? echo $lst->sub_cat_id; ?>");</script></td>
         <tr><td colspan=2 align=center><?=LNG_DESCRIPTION?></td>
         <tr><td colspan=2 align=center><textarea rows=5 cols=45 name='description'><? echo $lst->description; ?></textarea></td>
         <tr><td align=right><input type='submit' value='<?=LNG_LISTING_UPADE?>'></td><td align=right><input type='button' value='Delete Listing' onClick='window.location="index.php?mode=listing&act=delete&lst_id=<? echo $lst_id; ?>&lng=<?=$lng_id?>"'></td>
   </form></table></td></table>
<?
show_footer();
}//if
elseif($mod==1){
    $title=form_get("title");
    $cat_id=form_get("RootCategory");
    $sub_cat_id=form_get("Category");
    $description=form_get("description");

    $part=split(" ",$description);
        $descr_part='';
        for($i=0;$i<10;$i++){
           $descr_part.=" ".$part[$i];
        }

    $sql_query="update music_listings set title='$title',description='$description',descr_part='$descr_part',
    cat_id='$cat_id',sub_cat_id='$sub_cat_id' where lst_id='$lst_id'";
    sql_execute($sql_query,'');

    show_listing();

}//elseif

}//function

function del_listing(){
$m_id=cookie_get("mem_id");
global $lng_id;
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$lst_id=form_get("lst_id");
$sql_query="select mem_id from music_listings where lst_id='$lst_id'";
$lst=sql_execute($sql_query,'get');
if($m_id!=$lst->mem_id){
  error_screen(28);
}//if
$sql_query="delete from music_listings where lst_id='$lst_id'";
sql_execute($sql_query,'');

complete_screen(7);
}//function

?>
