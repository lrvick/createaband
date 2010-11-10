<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='')	music_list();
elseif($act=='del')	delete_music('','');
elseif($act=='cat')	music_cats_manage();
elseif($act=='c_del')	delete_category();
elseif($act=='c_add')	add_category();
elseif($act=='top')	top();
elseif($act=='cool')	cool();

function music_list()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
   <table width=100% class="lined padded-6">
   <tr><td class='title'>&nbsp;Admin: Albums Manager</td>
   <tr><td class='action' align="right"><a href="admin.php?mode=player_manage&adsess=<?=$adsess?>">Site Music Manager</a>&nbsp;</td>
   <tr><td>
   <table width=100% cellpadding=10 cellspacing=1 class="body">
   <?
         $page=form_get("page");
         if($page==''){
           $page=1;
         }
         $start=($page-1)*20;
      $sql_query="select * from musics order by m_dt desc limit $start,20";
      $num=sql_execute($sql_query,'num');
      if($num==0){
         echo "<tr><td align=center class=body>No musics in the system.</td><tr><td align=right>";
      }//if
      else{
      echo "<form action='admin.php' method=post>
      <input type=hidden name='mode' value='musics_manager'>
      <input type=hidden name='act' value='del'>
      <input type=hidden name='adsess' value='$adsess'>
      <tr><td>&nbsp;<b>Select</b></td><td><b>No. of Songs</b></td><td><b>Title</b></td><td><b>From</b></td><td><b>Top Album</b></td><td><b>Cool Album</b></td>";
         $res=sql_execute($sql_query,'res');
         while($fru=mysql_fetch_object($res)){
              echo "<tr><td>&nbsp;<input type=checkbox name='fru_id[]' value='$fru->m_id'></td>
			  <td>";
			  echo track_co($fru->m_id);
			  echo "</td>
              <td>".stripslashes($fru->m_title)."</td>
              <td><a href='admin.php?mode=users_manager&act=edi&adsess=$adsess&mem_id=$fru->m_own'>".name_header($fru->m_own,'ad')."</a></td>";
			  if($fru->top_alb!="y")	echo "<td><span class='action'><a href='admin.php?mode=musics_manager&act=top&pro=y&adsess=$adsess&alb_id=$fru->m_id'>Set as top</a></span></td>";
			  else	echo "<td><span class='action'><a href='admin.php?mode=musics_manager&act=top&pro=n&adsess=$adsess&alb_id=$fru->m_id'>Unset top</a></span></td>";
			  if($fru->cool_alb!="y")	echo "<td><span class='action'><a href='admin.php?mode=musics_manager&act=cool&pro=y&adsess=$adsess&alb_id=$fru->m_id'>Set as Cool</a></span></td>";
			  else	echo "<td><span class='action'>Cool</span></td>";
         }//while
		 echo "<tr><td colspan=7 align=center class='smalltext'>";pages_line($adsess,"ad_songs",$page,"20");echo "</td>";
         echo "<tr><td colspan=7 align=right><input type=submit value='Delete Songs' class=submit>";
      }//else
   ?>
   &nbsp<input value='Manage Genre' type=button onclick="window.location='admin.php?mode=musics_manager&act=cat&adsess=<? echo $adsess; ?>'" class="submit">
   </table></td></table>
   <?
	show_footer();
}//function

function delete_music($mod,$music)	{
	if($mod=='')	{
		$adsess=form_get("adsess");
		admin_test($adsess);
		$fru_id=form_get("fru_id");
	}//if
	elseif($mod='bcg')	{
		$fru_id=array();
		$fru_id=$music;
	}//else
	foreach($fru_id as $fid)	{
		$sql_query="select * from musics where m_id='$fid'";
		$muc=sql_execute($sql_query,'get');
		$pic_out=$muc->photo;
		if(file_exists($pic_out))	@unlink($pic_out);
		$pic_out=$muc->photo_thumb;
		if(file_exists($pic_out))	@unlink($pic_out);
		$pic_out=$muc->photo_b_thumb;
		if(file_exists($pic_out))	@unlink($pic_out);
		$sql_query="delete from musics where m_id='$fid'";
		sql_execute($sql_query,'');
		$sql_query="select * from songs where s_sec='$fid'";
		$res=sql_execute($sql_query,'res');
		if(mysql_num_rows($res))	{
			while($row=mysql_fetch_object($res))	{
				$pic_out=$row->s_name;
				if(file_exists($pic_out))	@unlink($pic_out);
			}
			$sql_query="delete from songs where s_sec='$fid'";
			sql_execute($sql_query,'');
		}
	}//foreach
	if($mod=='')	{
		music_list();
	}//if
	else {
		return 1;
	}//else
}//function

function music_cats_manage()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
?>
   <table width=100% class="lined padded-6">
   <tr>
    <td class='title'>&nbsp;Admin: Genre Manager</td>
   <tr>
    <td align=center class="body"> 
      <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='musics_manager'>
   <input type='hidden' name='act' value='c_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   Name : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=text name='new_cat'>&nbsp<input class="button" type=submit value='Add New Genre'>
      </form></td>
   <tr><td>
   <table width=90% align="center" cellpadding=10 cellspacing=1>
        <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='musics_manager'>
         <input type='hidden' name='act' value='c_del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from m_categories";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp</td><td><input type=checkbox name='m_cat_id[]' value='$cat->m_cat_id'></td><td class=body><b>$cat->name</b></td>";
           }//while
         ?>
         <tr>
          <td colspan=3 align=right> 
            <input name="Submit" type="submit" id="Submit" value="Delete Genre" class="submit">
          </td></form>
   </table></td></table>
<?
	show_footer();
}//function

function add_category()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$new_cat=form_get("new_cat");
	$sql_query="insert into m_categories(name) values('".addslashes($new_cat)."')";
	sql_execute($sql_query,'');
	music_cats_manage();
}//function

function delete_category()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$m_cat_id=form_get("m_cat_id");
	foreach($m_cat_id as $id)	{
		$sql_query="delete from m_categories where m_cat_id='$id'";
		sql_execute($sql_query,'');
		$sql_query="select m_id from musics where m_c_id='$id'";
		$res=sql_execute($sql_query,'res');
		$musics=array();
		while($fru=mysql_fetch_object($res))	{
			array_push($musics,$fru->m_id);
		}//while
		delete_music('bcg',$musics);
	}//foreach
	music_cats_manage();
}//function

function track_co($id)	{
	$sql_query="select count(s_id) as tot from songs where s_sec='$id'";
	$row=sql_execute($sql_query,'get');
	return $row->tot;
}

function top()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$alb_id=form_get("alb_id");
	$pro=form_get("pro");
	if($pro=='y')	{
		$sql_query="select count(m_id) as top_se from musics";
		$row=sql_execute($sql_query,'get');
		if($row->top_se<=10)	{
			$sql_query="update musics set top_alb='y' where m_id='$alb_id'";
			sql_execute($sql_query,'');
		}
	}	else	{
		$sql_query="update musics set top_alb='n' where m_id='$alb_id'";
		sql_execute($sql_query,'');
	}
	music_list();
}

function cool()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$alb_id=form_get("alb_id");
	$sql_query="update musics set cool_alb='y' where m_id='$alb_id'";
	sql_execute($sql_query,'');
	$sql_query="update musics set cool_alb='n' where m_id<>'$alb_id'";
	sql_execute($sql_query,'');
	music_list();
}
?>