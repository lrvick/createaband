<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
$err_mess=form_get("err_mess");
if($act==''){
  banner_manage();
}
elseif($act=='b_del'){
  delete_banners();
}
elseif($act=='create'){
  create();
}
elseif($act=='edi'){
  modify();
}

function banner_manage(){
global $main_url;
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   
<table width="100%" cellpadding="0" cellspacing="0" class="body">
  <tr>
    <td class="lined title">Admin: Banner Manager</td>
  </tr>
  <tr>
    <td align="right" class="body"><a href="admin.php?mode=banner_manager&act=create&adsess=<?=$adsess?>">Add a Banner</a>&nbsp;&nbsp;<a href="admin.php?mode=adcode_manager&type=h&adsess=<?=$adsess?>">Advertise Code</a>&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="lined padded-6" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td class="lined padded-6"> <form action="admin.php" method="post">
        <table width="98%" align="center" cellpadding="10" cellspacing="1" class="body">
          <?php
		  	$page=form_get("page");
			if($page=='')	$page=1;
			$start=($page-1)*20;
           $sql_query="select * from banners order by b_dt desc limit $start,20";
		   $p_sql="select b_id from banners order by b_dt desc";
		   $p_url="admin.php?mode=banner_manager&adsess=$adsess";
           $res=sql_execute($sql_query,'res');
		  ?>
          <?php if(!mysql_num_rows($res)) { ?>
          <tr align="center"> 
            <td colspan="6">No Banners.</td>
          </tr>
          <?php } else { ?>
          <tr> 
            <td align="left" class="title">&nbsp;</td>
            <td align="left" class="title">URL</td>
            <td align="left" class="title">Type</td>
            <td align="left" class="title">Expired</td>
            <td align="left" class="title">CTR</td>
            <td align="left" class="title">&nbsp;</td>
          </tr>
          <?php
           while($cat=mysql_fetch_object($res)){
		   		if($cat->b_typ=="H")	$whe="Header";
				elseif($cat->b_typ=="M")	$whe="Main Page";
				elseif($cat->b_typ=="F")	$whe="Footer";
				else	$whe="Other";
				if($cat->b_see!=0)	$ctr=round(($cat->b_clks/$cat->b_see)*100)."%";
				else	$ctr="0%";
				$tmp=explode(".",$cat->b_img);
				$tmp_count=count($tmp);
				$ext=strtolower($tmp[$tmp_count-1]);
				if($ext=="swf")	{
					$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='320' height='60'>
  							<param name='movie' value='".$main_url."/".$cat->b_img."'>
							<param name='quality' value='high'>
							<embed src='".$main_url."/".$cat->b_img."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='320' height='60'></embed></object>";
				}	else	$img_s="<img src='".$main_url."/".$cat->b_img."' border='0' width='320' height='60'>";
		   ?>
          <tr> 
            <td width="5%" align="left"><input type="checkbox" name="b_id[]" value="<?=$cat->b_id?>"></td>
            <td width="24%" align="left" class="body"><b> <a href="admin.php?mode=banner_manager&act=edi&seid=<?=$cat->b_id?>&adsess=<?=$adsess?>"> 
              <?=$cat->b_url?>
              </a> </b></td>
            <td width="16%" align="left" class="body"> 
              <?=$whe?>
            </td>
            <td width="13%" align="left" class="body"> 
              <?=$cat->b_exp?>
            </td>
            <td width="11%" align="left" class="body">
              <?=$ctr?>
            </td>
            <td width="31%" align="left" class="body"> 
              <?=$img_s?>
            </td>
          </tr>
          <?php
           }//while
         ?>
          <tr> 
            <td align="left">&nbsp;</td>
            <td align="left" class="body">&nbsp;</td>
            <td colspan="3" align="left" class="body">&nbsp;</td>
            <td align="right" class="body"> 
              <?=pages_line("$adsess","banner_list","$page","20");?>
              &nbsp;</td>
          </tr>
          <tr> 
            <td colspan="6" align="right"> <input type="hidden" name="mode" value="banner_manager"> 
              <input type="hidden" name="act" value="b_del"> <input type="hidden" name="adsess" value="<?=$adsess?>"> 
              <input name="Submit" type="submit" id="Submit" value="Delete Banners"> 
            </td>
          </tr>
          <?php }//IF ?>
        </table>
      </form></td>
  </tr>
</table>
<?php
show_footer();
}//function

function create(){
global $main_url,$_FILES,$base_path,$ban_hwidth,$ban_hheight,$ban_fwidth,$ban_fheight,$ban_mwidth,$ban_mheight;
$adsess=form_get("adsess");
$done=form_get("done");
$err_mess=form_get("err_mess");
admin_test($adsess);
if(empty($done))	{
show_ad_header($adsess);
?>
<table width="100%" cellpadding="0" cellspacing="0" class="body">
  <tr> 
    <td colspan="2" class="lined title">Admin: Add a Banner</td>
  </tr>
  <tr> 
    <td width="77%" class="lined form_tip">&nbsp;&nbsp;* fields are mandatory!</td>
    <td width="23%" align="right" class="lined form_tip"><a href="admin.php?mode=banner_manager&adsess=<?=$adsess?>">Banners 
      List</a>&nbsp;&nbsp;<a href="admin.php?mode=adcode_manager&type=h&adsess=<?=$adsess?>">Advertise Code</a>&nbsp;&nbsp;</td>
  </tr>
<script language="JavaScript1.2">
function done_me(vals)	{
	if(document.form1.dur[0].checked==true)	{
		document.form1.month_f.disabled=false;
		document.form1.day_f.disabled=false;
		document.form1.year_f.disabled=false;
		document.form1.month_t.disabled=false;
		document.form1.day_t.disabled=false;
		document.form1.year_t.disabled=false;
		document.form1.numi.disabled=true;
		document.form1.numc.disabled=true;
	}	else if(document.form1.dur[1].checked==true)	{
		document.form1.month_f.disabled=true;
		document.form1.day_f.disabled=true;
		document.form1.year_f.disabled=true;
		document.form1.month_t.disabled=true;
		document.form1.day_t.disabled=true;
		document.form1.year_t.disabled=true;
		document.form1.numi.disabled=false;
		document.form1.numc.disabled=true;
	}	else if(document.form1.dur[2].checked==true)	{
		document.form1.month_f.disabled=true;
		document.form1.day_f.disabled=true;
		document.form1.year_f.disabled=true;
		document.form1.month_t.disabled=true;
		document.form1.day_t.disabled=true;
		document.form1.year_t.disabled=true;
		document.form1.numi.disabled=true;
		document.form1.numc.disabled=false;
	}
}
</script>
  <tr> 
    <td colspan="2" valign="top" class="lined padded-6"> <form name="form1" action="admin.php" method="post" enctype="multipart/form-data">
        <table width="65%" align="center" cellpadding="10" cellspacing="1" class="body">
          <?php if(!empty($err_mess)) { ?>
          <tr align="center"> 
            <td colspan="2" class="lined form_tip"> 
              <?=ucwords($err_mess)?>
            </td>
          </tr>
          <?php } ?>
          <tr> 
            <td class="body">Type</td>
            <td class="body"><select name="typ" size="1" id="typ">
                <option value="H" selected>For Header</option>
                <option value="F">For Footer</option>
                <option value="M">Main Page</option>
				<option value="O">Other</option>
              </select></td>
          </tr>
          <tr> 
            <td class="body">Description</td>
            <td width="61%" class="body"><textarea name="descr" cols="30" rows="3" id="descr"></textarea></td>
          </tr>
          <tr>
            <td class="body">Zips</td>
            <td class="body"><input name="zips" type="text" id="zips" size="30">
			<br><span class='orangebody'>[ separate multiple zipcodes with commas ]</span></td>
          </tr>
          <tr> 
            <td class="body">URL *</td>
            <td class="body"><input name="url" type="text" id="url" size="30"></td>
          </tr>
          <tr> 
            <td class="body">Image *<br> </td>
            <td class="body"><input name="photo" type="file" id="photo" size="25"></td>
          </tr>
          <tr> 
            <td colspan="2" class="body">[<font size="1">Note: Dimensions for 
              Header- <?=$ban_hwidth?>x<?=$ban_hheight?> pixels. For Footer- <?=$ban_fwidth?>x<?=$ban_fheight?> pixels.</font> <font size="1">For 
              Main Page- <?=$ban_mwidth?>x<?=$ban_mheight?> pixels.</font>]</td>
          </tr>
          <tr> 
            <td colspan="2" class="body"><strong>Choose the Duration for Display</strong></td>
          </tr>
          <tr> 
            <td width="39%" height="89" class="body"><input name="dur" type="radio" value="D" onClick="javascript: done_me(this.value)" checked>
              Specify Date</td>
            <td valign="top" class="body">From &nbsp;: 
              <select name=month_f id="month_f">
                <option selected value="0">Month 
                <? month_drop(0); ?>
              </select> <select name=day_f id="day_f">
                <option selected value="0">Day 
                <? day_drop(0); ?>
              </select> <select name=year_f id="year_f">
                <option selected value="0">Year 
                <? year_drop('now'); ?>
              </select> <br> <br>
              To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
              <select name=month_t id="month_t">
                <option selected value="0">Month 
                <? month_drop(0); ?>
              </select> <select name=day_t id="day_t">
                <option selected value="0">Day 
                <? day_drop(0); ?>
              </select> <select name=year_t id="year_t">
                <option selected value="0">Year 
                <? year_drop('now'); ?>
              </select></td>
          </tr>
          <tr> 
            <td width="39%" class="body"><input type="radio" name="dur" value="I" onClick="javascript: done_me(this.value)">
              Number of Impressions</td>
            <td class="body"><input name="numi" type="text" id="numi" size="15" disabled></td>
          </tr>
          <tr> 
            <td width="39%" class="body"><input type="radio" name="dur" value="C" onClick="javascript: done_me(this.value)">
              Number of Clicks</td>
            <td class="body"><input name="numc" type="text" id="numc" size="15" disabled></td>
          </tr>
          <tr> 
            <td class="body">Blocked</td>
            <td class="body"><input name="blk" type="checkbox" id="blk" value="Y"></td>
          </tr>
          <tr> 
            <td colspan="5" align="right"> <input type="hidden" name="mode" value="banner_manager"> 
              <input type="hidden" name="act" value="create"> <input type="hidden" name="done" value="done"> 
              <input type="hidden" name="adsess" value="<?=$adsess?>"> <input name="Submit" type="submit" id="Submit" value="Add Banner"> 
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?php
show_footer();
}	else	{
$form_data=array ("typ","descr","url","blk","dur","month_f","day_f",
"year_f","month_t","day_t","year_t","numi","numc","zips");
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}
if($dur=="D")	{
	$f_day=mktime(0,0,0,$month_f,$day_f,$year_f);
	$t_day=mktime(0,0,0,$month_t,$day_t,$year_t);
}
$tmpfname=$_FILES['photo']['tmp_name'];
$ftype=$_FILES['photo']['type'];
$fsize=$_FILES['photo']['size'];
if(empty($url) or empty($tmpfname) or empty($dur))	{
		$matt="please enter the banner details.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=create&adsess=$adsess&err_mess=$matt";
	}	elseif(($dur=='D') and (($day_t==0)||($month_t==0)||($year_t==0)||($day_f==0)||($month_f==0)||($year_f==0)))	{
		$matt="please enter the banner details.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=create&adsess=$adsess&err_mess=$matt";
	}	elseif(($dur=='C') and empty($numc))	{
		$matt="please enter the banner details.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=create&adsess=$adsess&err_mess=$matt";
	}	elseif(($dur=='I') and empty($numi))	{
		$matt="please enter the banner details.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=create&adsess=$adsess&err_mess=$matt";
	}	else	{
		if(empty($blk))	$blk='N';
		$sql_ins="insert into banners (b_desc,b_url,b_typ,b_blk,b_dur,b_f_day,b_t_day,b_noi,b_ncl,b_dt,b_zips) values (";
		$sql_ins.="'".addslashes($descr)."','".$url."','".$typ."','".$blk."','".$dur."','$f_day','$t_day','$numi','$numc',now(),'$zips')";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		if($tmpfname!='')	{
			if($ftype=="image/bmp")	$p_type=".bmp";
			elseif(($ftype=="image/jpeg")||($ftype=="image/pjpeg"))	$p_type=".jpeg";
			elseif($ftype=="image/gif")	$p_type=".gif";
			elseif($ftype=="application/x-shockwave-flash")	$p_type=".swf";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
//			echo "Shodel -> <br>Img Type : ".$ftype."<br>P Type : ".$p_type."<br>Name : ".$newname.$p_type;
//			copy($tmpfname,$base_path."/banners/".$newname.$p_type);
			move_uploaded_file($tmpfname,"banners/".$newname.$p_type);
			$photo="banners/".$newname.$p_type;
			$sql_img="update banners set b_img='".$photo."' where b_id=".$prim;
			mysql_query($sql_img);
		}
		$matt="Banner is successfully added.";
		$hed=$main_url."/admin.php?mode=banner_manager&adsess=$adsess&err_mess=$matt";
	}
	show_screen($hed);
}
}//function
function modify(){
global $main_url,$_FILES,$base_path,$ban_hwidth,$ban_hheight,$ban_fwidth,$ban_fheight,$ban_mwidth,$ban_mheight;
$adsess=form_get("adsess");
$done=form_get("done");
$err_mess=form_get("err_mess");
$seid=form_get("seid");
admin_test($adsess);
if(empty($done))	{
show_ad_header($adsess);
$sql_query="select * from banners where b_id='$seid'";
$row=sql_execute($sql_query,'get');
?>
<table width="100%" cellpadding="0" cellspacing="0" class="body">
  <tr> 
    <td colspan="2" class="lined title">Admin: Modify Banner</td>
  </tr>
<script language="JavaScript1.2">
function done_me(vals)	{
	if(document.form1.dur[0].checked==true)	{
		document.form1.month_f.disabled=false;
		document.form1.day_f.disabled=false;
		document.form1.year_f.disabled=false;
		document.form1.month_t.disabled=false;
		document.form1.day_t.disabled=false;
		document.form1.year_t.disabled=false;
		document.form1.numi.disabled=true;
		document.form1.numc.disabled=true;
	}	else if(document.form1.dur[1].checked==true)	{
		document.form1.month_f.disabled=true;
		document.form1.day_f.disabled=true;
		document.form1.year_f.disabled=true;
		document.form1.month_t.disabled=true;
		document.form1.day_t.disabled=true;
		document.form1.year_t.disabled=true;
		document.form1.numi.disabled=false;
		document.form1.numc.disabled=true;
	}	else if(document.form1.dur[2].checked==true)	{
		document.form1.month_f.disabled=true;
		document.form1.day_f.disabled=true;
		document.form1.year_f.disabled=true;
		document.form1.month_t.disabled=true;
		document.form1.day_t.disabled=true;
		document.form1.year_t.disabled=true;
		document.form1.numi.disabled=true;
		document.form1.numc.disabled=false;
	}
}
</script>
  <tr> 
    <td width="77%" class="lined form_tip">&nbsp;&nbsp;* fields are mandatory!</td>
    <td width="23%" align="right" class="lined form_tip"><a href="admin.php?mode=banner_manager&adsess=<?=$adsess?>">Banners 
      List</a>&nbsp;&nbsp;<a href="admin.php?mode=adcode_manager&type=h&adsess=<?=$adsess?>">Advertise Code</a>&nbsp;&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" valign="top" class="lined padded-6"> <form name="form1" action="admin.php" method="post" enctype="multipart/form-data">
        <table width="65%" align="center" cellpadding="10" cellspacing="1" class="body">
          <?php if(!empty($err_mess)) { ?>
          <tr align="center"> 
            <td colspan="2" class="lined form_tip"> 
              <?=ucwords($err_mess)?>
            </td>
          </tr>
          <?php } ?>
          <?php
  				$tmp=explode(".",$row->b_img);
				$tmp_count=count($tmp);
				$ext=strtolower($tmp[$tmp_count-1]);
				if($ext=="swf")	{
					$img_s="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='320' height='60'>
  							<param name='movie' value='".$main_url."/".$row->b_img."'>
							<param name='quality' value='high'>
							<embed src='".$main_url."/".$row->b_img."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='320' height='60'></embed></object>";
				}	else	$img_s="<img src='".$main_url."/".$row->b_img."' border='0' width='320' height='60'>";
		  ?>
          <tr align="center" valign="top"> 
            <td colspan="2" class="body">
              <?=$img_s?>
            </td>
          </tr>
          <tr> 
            <td class="body">Type</td>
            <td class="body"><select name="typ" size="1" id="typ">
				<? if($row->b_typ=="H") { ?>
                <option value="H" selected>For Header</option>
				<? } else { ?>
                <option value="H">For Header</option>
				<? } ?>
				<? if($row->b_typ=="F") { ?>
                <option value="F" selected>For Footer</option>
				<? } else { ?>
                <option value="F">For Footer</option>
				<? } ?>
				<? if($row->b_typ=="M") { ?>
                <option value="M" selected>Main Page</option>
				<? } else { ?>
                <option value="M">Main Page</option>
				<? } ?>
				<? if($row->b_typ=="O") { ?>
				<option value="O" selected>Other</option>
				<? } else { ?>
				<option value="O">Other</option>
				<? } ?>
              </select></td>
          </tr>
          <tr> 
            <td class="body">Description</td>
            <td width="61%" class="body"><textarea name="descr" cols="30" rows="3" id="descr"><?=stripslashes($row->b_desc)?></textarea></td>
          </tr>
          <tr>
            <td class="body">Zips</td>
            <td class="body"><input name="zips" type="text" id="zips" size="30" value="<?=$row->b_zips?>">
              <br><span class='orangebody'>[ separate multiple zipcodes with commas ]</span>
            </td>
          </tr>
          <tr> 
            <td class="body">URL *</td>
            <td class="body"><input name="url" type="text" id="url" value="<?=$row->b_url?>" size="30"></td>
          </tr>
          <tr> 
            <td class="body">Image<br> </td>
            <td class="body"><input name="photo" type="file" id="photo" size="25"></td>
          </tr>
          <tr> 
            <td colspan="2" class="body">[<font size="1">Note: Dimensions for 
              Header- <?=$ban_hwidth?>x<?=$ban_hheight?> pixels. For Footer- <?=$ban_fwidth?>x<?=$ban_fheight?> pixels.</font> <font size="1">For 
              Main Page- <?=$ban_mwidth?>x<?=$ban_mheight?> pixels.</font>]</td>
          </tr>
          <tr> 
            <td colspan="2" class="body"><strong>Choose the Duration for Display</strong></td>
          </tr>
          <?php
		  	if($row->b_dur=="D")	{
				$chk_d="checked";
				$d_f=date("d",$row->b_f_day);
				$m_f=date("m",$row->b_f_day);
				$y_f=date("Y",$row->b_f_day);
				$d_t=date("d",$row->b_t_day);
				$m_t=date("m",$row->b_t_day);
				$y_t=date("Y",$row->b_t_day);
			}	elseif($row->b_dur=="I")	{
				$chk_i="checked";
				$d_f="0";
				$m_f="0";
				$y_f="now";
				$d_t="0";
				$m_t="0";
				$y_t="now";
			}	else	{
				$chk_c="checked";
				$d_f="0";
				$m_f="0";
				$y_f="now";
				$d_t="0";
				$m_t="0";
				$y_t="now";
			}
			if($row->b_blk=="Y")	$chk="checked";
		  ?>
          <tr> 
            <td width="39%" height="89" class="body"><input name="dur" type="radio" value="D" onClick="javascript: done_me(this.value)" <?=$chk_d?>>
              Specify Date</td>
            <td valign="top" class="body">From &nbsp;: 
              <select name=month_f id="month_f" onFocus="javascript: done_me(this.value)">
                <option selected value="0">Month 
                <? month_drop($m_f); ?>
              </select> <select name=day_f id="day_f" onFocus="javascript: done_me(this.value)">
                <option selected value="0">Day 
                <? day_drop($d_f); ?>
              </select> <select name=year_f id="year_f" onFocus="javascript: done_me(this.value)">
                <option selected value="0">Year 
                <? year_drop($y_f); ?>
              </select> <br> <br>
              To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
              <select name=month_t id="month_t" onFocus="javascript: done_me(this.value)">
                <option selected value="0">Month 
                <? month_drop($m_t); ?>
              </select> <select name=day_t id="day_t" onFocus="javascript: done_me(this.value)">
                <option selected value="0">Day 
                <? day_drop($d_t); ?>
              </select> <select name=year_t id="year_t" onFocus="javascript: done_me(this.value)">
                <option selected value="0">Year 
                <? year_drop($y_t); ?>
              </select></td>
          </tr>
          <tr> 
            <td width="39%" class="body"><input type="radio" name="dur" value="I" onClick="javascript: done_me(this.value)" <?=$chk_i?>>
              Number of Impressions </td>
            <td class="body"><input name="numi" type="text" id="numi" value="<?=$row->b_noi?>" onFocus="javascript: done_me(this.value)" size="15"> 
              <br>
              [<font size="1">Present Impressions 
              <?=$row->b_see?>
              </font>] </td>
          </tr>
          <tr> 
            <td width="39%" class="body"><input type="radio" name="dur" value="C" onClick="javascript: done_me(this.value)" <?=$chk_c?>>
              Number of Clicks </td>
            <td class="body"><input name="numc" type="text" id="numc" value="<?=$row->b_ncl?>" onFocus="javascript: done_me(this.value)" size="15"> 
              <br>
              [<font size="1">Present Clicks 
              <?=$row->b_clks?>
              </font>] </td>
          </tr>
          <tr> 
            <td class="body">Blocked</td>
            <td class="body"><input name="blk" type="checkbox" id="blk" value="Y" <?=$chk?>></td>
          </tr>
          <tr> 
            <td class="body">Expired</td>
            <td class="body"> 
              <?=$row->b_exp?>
            </td>
          </tr>
          <tr> 
            <td colspan="5" align="right"> <input type="hidden" name="mode" value="banner_manager"> 
              <input type="hidden" name="act" value="edi"> <input type="hidden" name="seid" value="<?=$seid?>"> 
              <input type="hidden" name="done" value="done"> <input type="hidden" name="adsess" value="<?=$adsess?>"> 
              <input name="Submit" type="submit" id="Submit" value="Modify Banner"> 
            </td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?php
show_footer();
}	else	{
$form_data=array ("typ","descr","url","blk","dur","month_f","day_f",
"year_f","month_t","day_t","year_t","numi","numc","zips");
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}
if($dur=="D")	{
	$f_day=mktime(0,0,0,$month_f,$day_f,$year_f);
	$t_day=mktime(0,0,0,$month_t,$day_t,$year_t);
}
$tmpfname=$_FILES['photo']['tmp_name'];
$ftype=$_FILES['photo']['type'];
$fsize=$_FILES['photo']['size'];
if(empty($url) or empty($dur))	{
		$matt="please enter the banner details.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=edi&seid=$seid&adsess=$adsess&err_mess=$matt";
	}	elseif(($dur=='D') and (($day_t==0)||($month_t==0)||($year_t==0)||($day_f==0)||($month_f==0)||($year_f==0)))	{
		$matt="please select the duration dates.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=edi&seid=$seid&adsess=$adsess&err_mess=$matt";
	}	elseif(($dur=='C') and empty($numc))	{
		$matt="please enter the nimber of clicks.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=edi&seid=$seid&adsess=$adsess&err_mess=$matt";
	}	elseif(($dur=='I') and empty($numi))	{
		$matt="please enter the number of impressions.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=edi&seid=$seid&adsess=$adsess&err_mess=$matt";
	}	else	{
		if(empty($blk))	$blk='N';
		$sql_up="update banners set b_desc='".addslashes($descr)."',b_url='".$url."',b_typ='".$typ."',b_blk='".$blk."',";
		$sql_up.="b_dur='".$dur."',b_f_day='$f_day',b_t_day='$t_day',b_noi='$numi',b_ncl='$numc',b_exp='N',b_zips='$zips' where b_id=$seid";
		mysql_query($sql_up);
		$prim=$seid;
		if($tmpfname!='')	{
			if($ftype=="image/bmp")	$p_type=".bmp";
			elseif(($ftype=="image/jpeg")||($ftype=="image/pjpeg"))	$p_type=".jpeg";
			elseif($ftype=="image/gif")	$p_type=".gif";
			elseif($ftype=="application/x-shockwave-flash")	$p_type=".swf";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
//			echo "Shodel -> <br>Img Type : ".$ftype."<br>P Type : ".$p_type."<br>Name : ".$newname.$p_type;
//			copy($tmpfname,$base_path."/banners/".$newname.$p_type);
			move_uploaded_file($tmpfname,"banners/".$newname.$p_type);
			$photo="banners/".$newname.$p_type;
			$sql_img="update banners set b_img='".$photo."' where b_id=".$prim;
			mysql_query($sql_img);
		}
		$matt="this banner details updated.";
		$hed=$main_url."/admin.php?mode=banner_manager&act=edi&seid=$seid&adsess=$adsess&err_mess=$matt";
	}
	show_screen($hed);
}
}//function

function delete_banners() {
$adsess=form_get("adsess");
admin_test($adsess);

$b_id=form_get("b_id");

foreach($b_id as $id){
	$sql_query="select * from banners where b_id='$id'";
	$num=sql_execute($sql_query,'num');
	if($num!=0)	{
		$row=sql_execute($sql_query,'get');
		@unlink($row->b_img);
	}
	$sql_query="delete from banners where b_id='$id'";
	sql_execute($sql_query,'');
}//foreach

banner_manage();
}//function
?>