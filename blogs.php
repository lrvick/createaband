<?php
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
$err_mess=form_get("err_mess");
if($act=='')	 blogs();
elseif($act=='create')	create_blog();
elseif($act=='create_done')	create_done();
elseif($act=='edblog')	edblog();
elseif($act=='modblog')	modblog();
elseif($act=='remblog')	remblog();
elseif($act=='viewimg')	viewblogimg();

function blogs()	{
	
	global $lng_id;
	
	global $main_url;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	//login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	if($page=='')	$page=1;
	$start=($page-1)*20;
	$sql_mails="select * from blogs order by blog_dt desc limit $start,20";
	$p_sql="select blog_id from blogs order by blog_dt desc";
	$p_url="index.php?mode=blogs";
	$res_mails=mysql_query($sql_mails);
	show_header();
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
              <tr> 
                <td height="20" colspan="2" align="left" valign="middle" class="lined title"><?=LNG_BLOG?>
                </td>
              </tr>
              <tr> 
                <td height="20" colspan="2" align="right" valign="middle" class="body"> 
                  <a href="index.php?mode=blogs&act=create&lng=<?=$lng_id?>"> <br>
                  <?=LNG_ADD_BLOG?></a>
                  <a href="index.php?mode=blogs&amp;act=edblog&amp;seid=<?=$row_mails->blog_id?>&lng=<?=$lng_id?>"><b> 
                  </b></a> | 
                  <a href="<?=$main_url?>/blog/<? echo mem_profilenam($m_id); ?>"><?=LNG_VIEW_MY_BLOGS?></a> | 
                  <?=LNG_MY_BLOG_URL?>
                  <a href="<?=$main_url?>/blog/<? echo mem_profilenam($m_id); ?>">
                  <?=$main_url?>/blog/<? echo mem_profilenam($m_id); ?></a>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
                  <br> </td>
              </tr>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <?php	if(!empty($err_mess))	{	?>
              <tr> 
                <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
                  <?=ucwords($err_mess)?>
                </td>
              </tr>
              <?php	}	?>
              <?php if(!mysql_num_rows($res_mails)) { ?>
              <tr> 
                <td height="20" colspan="2" align="center" valign="middle" class="body"><?=LNG_BLOG_EMPTY?></td>
              </tr>
              <?php } else { ?>
              <tr> 
                <td height="121" colspan="2" align="left" valign="middle"> <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <?php $chk=1; ?>
                          <?php while($row_mails=mysql_fetch_object($res_mails))	{
														if(empty($row_mails->blog_img))	$imgdis="<img src='blog/noimage.jpg' border='0'>";
														else	$imgdis="<a href='index.php?mode=blogs&act=viewimg&seid=$row_mails->blog_id&lng=$lng_id'><img src='".$row_mails->blog_img."' border='0'><a>";
											  ?>
                          <tr> 
                            <td valign="top" colspan="4" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td width="81%"><table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr> 
                                        <td class="body"><b> <? echo name_header($row_mails->blog_own,$m_id); ?> 
                                          </b>&nbsp;&nbsp;</td>
                                      </tr>
                                      <tr> 
                                        <td class="body"><strong> 
                                          <?=stripslashes($row_mails->blog_title)?>
                                          </strong></td>
                                      </tr>
                                      <tr> 
                                        <td class="body">&nbsp;&nbsp; 
                                          <?=stripslashes($row_mails->blog_matt)?>
                                        </td>
                                      </tr>
                                    </table></td>
                                  <td width="19%" valign="top" class="body">
                                    <? if($row_mails->blog_own==$m_id) { ?>
                                    <a href="index.php?mode=blogs&act=edblog&seid=<?=$row_mails->blog_id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>&nbsp;&nbsp;
                                    <a href="index.php?mode=blogs&act=remblog&seid=<?=$row_mails->blog_id?>&page=<?=$page?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>&nbsp;&nbsp;<br> 
                                    <? } ?>
                                    <? echo date("m/d/Y h:i A",$row_mails->blog_dt); ?> 
                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <?php $chk++; ?>
                          <?php } ?>
                          <tr> 
                            <td width="69%" align="left">&nbsp;</td>
                            <td width="16%" align="left">&nbsp;</td>
                            <td width="0%" align="left">&nbsp;</td>
                            <td width="15%" align="right">&nbsp; </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr> 
                <td width="93%" height="20" align="right" valign="middle" class="body"> 
                  <? echo page_nums($p_sql,$p_url,$page,20); ?> </td>
                <?php } ?>
              </tr>
            </table>
	<?php
	show_footer();
}
function create_blog()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	show_header();
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        
    <td valign="top"><table width="100%" cellpadding="0" cellspacing="0" class="lined body">
	<tr><td class="title">&nbsp;<?=LNG_CREATE_BLOG?></td></tr>
	<tr>
          <td align="right" class="body"><a href="index.php?mode=blogs&act=create&lng=<?=$lng_id?>">&nbsp;<?=LNG_ADD_BLOG?></a>
          <a href="index.php?mode=blogs&amp;act=edblog&amp;seid=<?=$row_mails->blog_id?>&lng=<?=$lng_id?>"> 
            </a> | <a href="<?=$main_url?>/blog/<? echo mem_profilenam($m_id); ?>"><?=LNG_VIEW_MY_BLOGS?></a>| <a href="index.php?mode=blogs&lng=<?=$lng_id?>"><?=LNG_BLOG_LIST?></a>&nbsp;&nbsp;</td>
        </tr>
		<tr><td><form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                      
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                <tr> 
                  <td class="body" width="36%">&nbsp;</td>
                  <td width="64%">&nbsp;</td>
                </tr>
                <tr> 
                  <td height="25" class="body" width="36%">&nbsp;<b>&nbsp;</b><?=LNG_TITLE?><b>:</b></td>
                  <td height="25" width="64%"> <input name="blog_title" type="text" id="blog_title" size="25"></td>
                </tr>
                <tr> 
                  <td width="36%" class="body">&nbsp;&nbsp;<?=LNG_SUBJECT_MATTER?></td>
                  <td width="64%"> <textarea name="blogmatt" cols="35" rows="5" id="blogmatt" class="field"></textarea> 
                    <input name="second" type="hidden" id="second" value="set"> 
                    <input name="mode" type="hidden" id="act" value="<?=$mode?>"> 
                    <input name="act" type="hidden" id="act" value="create_done"></td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" valign="top"> <input type="submit" name="Submit" value="<?=LNG_RIDEZ_CREATE?>"> 
                  </td>
                </tr>
                <tr> 
                  <td colspan="2" align="center"></td>
                </tr>
              </table>
                                    </form></td></tr>
		</table>

    </td>
      </tr>
    </table>
<?php
	show_footer();
}

function create_done()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$sql_query="select * from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$blogmatt=form_get("blogmatt");
	$blog_title=form_get("blog_title");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if((empty($blogmatt)) || (empty($blog_title)))	{
		$matt=LNG_BLOG_MAT;
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}	else	{
		$now=time();
		$sql_ins="insert into blogs (blog_own,blog_matt,blog_title,blog_dt) values (";
		$sql_ins.="$m_id,'".addslashes($blogmatt)."','".addslashes($blog_title)."','$now')";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		if($tmpfname!='')	{
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old="blog/".$newname.$p_type;
			$thumb1="blog/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,"blog/".$newname.$p_type);
			//creating thumbnails
			if($p_type==".jpeg")	$srcImage = imagecreatefromjpeg( $old );
			elseif($p_type==".gif")	$srcImage = imagecreatefromgif( $old );
		
			$sizee=getimagesize($old);
			$srcwidth=$sizee[0];
			$srcheight=$sizee[1];
			//landscape
			if($srcwidth>$srcheight){
			$destwidth1=100;
			$rat=$destwidth1/$srcwidth;
			$destheight1=(int)($srcheight*$rat);
			}
			//portrait
			elseif($srcwidth<$srcheight){
			$destheight1=100;
			$rat=$destheight1/$srcheight;
			$destwidth1=(int)($srcwidth*$rat);
			}
			//quadro
			elseif($srcwidth==$srcheight){
			$destwidth1=100;
			$destheight1=100;
			}
		
			$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
			ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
			imagejpeg($destImage1, $thumb1, 80);
			imagedestroy($srcImage);
			imagedestroy($destImage1);
			$photo="blog/".$newname.$p_type;
			$photo_thumb="blog/".$newname_th.".jpeg";
			$sql_img="update blogs set blog_img='".$photo_thumb."',blog_aimg='".$photo."' where blog_id=".$prim;
			mysql_query($sql_img);
		}
		$matt=LNG_BLOG_ADDED_LIST;
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}
	show_screen($hed);
}
function edblog()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$sql_query="select * from blogs where blog_id='$seid'";
	$row=sql_execute($sql_query,'get');
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
       
	    <tr> 
          <td align="left" valign="top">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="86%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                          <tr> 
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_EDIT_BLOG?></td>
                                </tr>
								<tr> 
                <td align="right" class="body"><a href="index.php?mode=blogs&act=create&lng=<?=$lng_id?>"><?=LNG_ADD_BLOG?></a>
                <a href="index.php?mode=blogs&amp;act=edblog&amp;seid=<?=$row_mails->blog_id?>&lng=<?=$lng_id?>"></a>| 
                <a href="<?=$main_url?>/blog/<? echo mem_profilenam($m_id); ?>"><?=LNG_VIEW_MY_BLOGS?></a> | 
                <a href="index.php?mode=blogs&lng=<?=$lng_id?>"><?=LNG_BLOG_LIST?></a>&nbsp;&nbsp;</td>
              </tr>
                                <tr> 
                                  <td height="20" align="left" valign="middle" class="body">&nbsp;</td>
                                </tr>
                                <?php	if(!empty($err_mess))	{	?>
                                <tr> 
                                  <td height="20" align="center" valign="middle" class="form-comment"> 
                                    <?=ucwords($err_mess)?>
                                  </td>
                                </tr>
                                <?php	}	?>
                                <tr> 
                                  <td align="left" valign="middle" class="body"> 
                                    <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr> 
                                          <td height="25" class="body" width="33%">&nbsp;<b>&nbsp;</b><?=LNG_TITLE?> :</td>
                                          <td height="25" width="67%"> <input name="blog_title2" type="text" id="blog_title2" size="25" value="<?=stripslashes($row->blog_title)?>"></td>
                                        </tr>
                                        <tr> 
                                          <td width="33%" class="body">&nbsp;&nbsp;<?=LNG_SUBJECT_MATTER?></td>
                                          <td width="67%"> <textarea name="textarea" cols="35" rows="5" id="textarea" class="field"><?=stripslashes($row->blog_matt)?></textarea> 
                                            <input name="second2" type="hidden" id="second2" value="set"> 
                                            <input name="mode2" type="hidden" id="mode" value="<?=$mode?>"> 
                                            <input name="act2" type="hidden" id="act2" value="modblog"> 
                                            <input name="seid" type="hidden" id="seid" value="<?=$seid?>"> 
                                          </td>
                                        </tr>
                                        <tr> 
                                          <td colspan="2" align="center" valign="top"> 
                                            <input type="submit" name="Submit2" value="<?=LNG_RIDEZ_MODIFY?>"> 
                                          </td>
                                        </tr>
                                        <tr> 
                                          <td colspan="2" align="center"></td>
                                        </tr>
                                      </table>
                                    </form></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table> </td>
        </tr>
      </table></td>
      </tr>
    </table>
<?php
	show_footer();
}
function modblog()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$blogmatt=form_get("blogmatt");
	$blog_title=form_get("blog_title");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if((empty($blogmatt)) || (empty($blog_title)))	{
		$matt=LNG_BLOG_MAT;
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}	else	{
		$sql_ins="update blogs set blog_title='".addslashes($blog_title)."',blog_matt='".addslashes($blogmatt)."' where blog_id=$seid";
		mysql_query($sql_ins);
		$prim=$seid;
		if($tmpfname!='')	{
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old="blog/".$newname.$p_type;
			$thumb1="blog/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,"blog/".$newname.$p_type);
			//creating thumbnails
			if($p_type==".jpeg")	$srcImage = imagecreatefromjpeg( $old );
			elseif($p_type==".gif")	$srcImage = imagecreatefromgif( $old );
		
			$sizee=getimagesize($old);
			$srcwidth=$sizee[0];
			$srcheight=$sizee[1];
			//landscape
			if($srcwidth>$srcheight){
			$destwidth1=100;
			$rat=$destwidth1/$srcwidth;
			$destheight1=(int)($srcheight*$rat);
			}
			//portrait
			elseif($srcwidth<$srcheight){
			$destheight1=100;
			$rat=$destheight1/$srcheight;
			$destwidth1=(int)($srcwidth*$rat);
			}
			//quadro
			elseif($srcwidth==$srcheight){
			$destwidth1=100;
			$destheight1=100;
			}
		
			$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
			ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
			imagejpeg($destImage1, $thumb1, 80);
			imagedestroy($srcImage);
			imagedestroy($destImage1);
			$photo="blog/".$newname.$p_type;
			$photo_thumb="blog/".$newname_th.".jpeg";
			$sql_img="update blogs set blog_img='".$photo_thumb."',blog_aimg='".$photo."' where blog_id=".$prim;
			mysql_query($sql_img);
		}
		$matt=LNG_BLOG_UPDATE_LIST;
		$hed="index.php?mode=blogs&lng=" . $lng_id;
	}
	show_screen($hed);
}
function remblog()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
	$sql_query="select * from blogs where blog_id='$seid'";
	$num=sql_execute($sql_query,'num');
	if($num!=0)	{
		$row_img=sql_execute($sql_query,'get');
		$pic_out=$row_img->blog_img;
		if(file_exists($pic_out))	@unlink($pic_out);
	}
  	$sql_messrem="delete from blogs where blog_id=$seid";
	mysql_query($sql_messrem);
	$matt=LNG_REMOVAL_COMPLETED;
	$hed="index.php?mode=$mode&err_mess=$matt&page=$page&lng=" . $lng_id;
	show_screen($hed);
}

function viewblogimg()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$seid=form_get("seid");
	$sql_query="select * from blogs where blog_id='$seid'";
	$img=sql_execute($sql_query,'get');
	if(empty($img->blog_img))	$imgdis="<img src='blog/noimage.jpg' border='0'>";
	else	$imgdis="<img src='".$img->blog_aimg."' border='0'>";
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body lined">
<tr><td height="5"></td></tr>
      <tr> 
        <td align="center">
          <?=$imgdis?>
        </td>
      </tr>
      <tr>
        
    <td align="center"><a href="index.php?mode=blogs&lng=<?=$lng_id?>"><?=LNG_BACK?></a></td>
      </tr>
	  <tr><td height="5"></td></tr>
    </table>
<?php
	show_footer();
}
?>
