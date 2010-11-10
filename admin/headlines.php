<?php
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
$err_mess=form_get("err_mess");
if($act=='')	 news();
elseif($act=='create')	create_news();
elseif($act=='create_done')	create_done();
elseif($act=='ednews')	ednews();
elseif($act=='modnews')	modnews();
elseif($act=='remnews')	remnews();
elseif($act=='view')	viewnews();
elseif($act=='comment')	addcomment();
function news()	{
	global $lines10,$lcoun;
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
	$mode=form_get("mode");
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_mails="select * from headlines order by dt desc";
	$res_mails=mysql_query($sql_mails);
	?>
	<tr>
  <td valign="top" width="780">
    <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
        <td align="left" valign="top"> <table width="100%" cellpadding="0" cellspacing="0">
            <tr> 
              <td align="right"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr> 
                          <td width="86%" valign="top"><table width="100%" height="100%" border="0" align="right" cellpadding="0" cellspacing="0" class="body">
                              <tr> 
                                <td align="right"> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Recently 
                                        Posted Articles</td>
                                    </tr>
                                    <tr> 
                                      <td align="right" class="body"><a href="admin.php?mode=headlines&act=create&adsess=<?=$adsess?>">Post 
                                        New Article</a>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">&nbsp;</td>
                                    </tr>
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <?php if(!mysql_num_rows($res_mails)) {	 ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="top" class="body">List 
                                        Is Empty!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle"> 
                                        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td valign="top">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                                                <?php $chk=1; ?>
                                                <?php while($row_mails=mysql_fetch_object($res_mails))	{
														if(!empty($row_mails->photo_thumb))	$img_dis="<img src='$row_mails->photo_thumb' border='0'>";
														else	$img_dis="";	
														$fr=split(",",$row_mails->mems);
														$show=0;
														for($i=0; $i<=count($fr); $i++)	{
															if($m_id==$fr[$i])	$show=1;
														}
														if($show==1)	{
											  ?>
                                                <tr> 
                                                  <td width="2%" valign="top"><?=$img_dis?></td>
                                                  <td width="98%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td height="25" colspan="2" class="body"><b> 
                                                          <?=stripslashes($row_mails->title)?>
                                                          </b></td>
                                                      </tr>
                                                      <tr> 
                                                        <td width="80%" class="body"><b> 
                                                          <?=show_memnam($row_mails->own)?>
                                                          </b>&nbsp;Posted on 
                                                          <?=format_date($row_mails->dt)?>
                                                          &nbsp;<strong>Rapzone:</strong>&nbsp;<?=stripslashes($row_mails->rapzone)?>&nbsp;</td>
                                                        <td width="20%" align="right" class="body"> 
                                                          <?php if($m_id==$row_mails->own)	{ ?>
                                                          <a href="admin.php?mode=headlines&act=ednews&seid=<?=$row_mails->id?>">Edit</a>&nbsp;&nbsp;<a href="admin.php?mode=headlines&act=remnews&seid=<?=$row_mails->id?>&page=<?=$page?>">Delete</a> 
                                                          <?php } ?>
                                                        </td>
                                                      </tr>
                                                      <tr> 
                                                        <td height="25" colspan="2" class="body"><b>Source 
                                                          :</b> 
                                                          <?=stripslashes($row_mails->source)?>
                                                        </td>
                                                      </tr>
                                                      <tr> 
                                                        <td height="25" colspan="2"> 
                                                          <table width="89%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                              <td class="body"><b>Link 
                                                                :</b> <a href="<?=$row_mails->link?>" target="_blank"> 
                                                                <?=$row_mails->link?>
                                                                </a> </td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                      <tr> 
                                                        <td colspan="2">&nbsp;</td>
                                                      </tr>
                                                      <tr> 
                                                        <td colspan="2"> <table width="89%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                              <td class="body"> 
                                                                <? echo substr(stripslashes($row_mails->matt),0,200); ?>...&nbsp;</td>
                                                            </tr>
                                                            <tr>

                                                              <td align="right" class="body"> 
                                                                <a href="admin.php?mode=headlines&act=view&seid=<?=$row_mails->id?>&adsess=<?=$adsess?>">Full 
                                                                Story</a>&nbsp;&nbsp;<a href="admin.php?mode=headlines&act=ednews&seid=<?=$row_mails->id?>&adsess=<?=$adsess?>">Edit</a>&nbsp;&nbsp;<a href="admin.php?mode=headlines&act=remnews&seid=<?=$row_mails->id?>&adsess=<?=$adsess?>">Delete</a> 
                                                                &nbsp;&nbsp;</td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="5" bgcolor="#FFFFFF" height="3"></td>
                                                </tr>
                                                <?php } ?>
                                                <?php $chk++; ?>
                                                <?php } ?>
                                              </table></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <?php } ?>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <br> </td>
      </tr>
    </table>
    <br>
		<br>
	</td></tr>
	<?php
	show_footer();
}
function create_news()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
	$mode=form_get("mode");
	$err_mess=form_get("err_mess");
?>
<tr> 
  <td valign="top" width="780"><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="admin.php?mode=headlines&adsess=<?=$adsess?>">View 
                      Posts</a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Post 
                                        New Article</td>
                                    </tr>
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="body">&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <font size="1">[Note: * fields are mandatory!] 
                                        </font></td>
                                    </tr>
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <tr> 
                                      <td align="left" valign="middle" class="text"> 
                                        <form method="post" action="admin.php" enctype="multipart/form-data">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Title 
                                                * </td>
                                              <td height="25"> <input name="title" type="text" id="title" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Source 
                                                * </td>
                                              <td height="25"><input name="source" type="text" id="source" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Page 
                                                Link *</td>
                                              <td height="25"><input name="link" type="text" id="link" size="30"></td>
                                            </tr>
											<tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Rapzone 
                                                *</td>
                                              <td height="25">
											  <?
											  $sql_query="select * from rapzones";
											  $res=sql_execute($sql_query,'res');   ?>
											  <select name="zones">
												<option value="All" selected>All</option>
											<?	while($row_mails=mysql_fetch_object($res))	{ ?>
											  <option value="<?=stripslashes($row_mails->rapzone)?>" <?=$ch?>><?=stripslashes($row_mails->rapzone)?></option>
											  <? } ?>
											  </select></td>
                                            </tr>
                                            <tr>
                                              <td height="25" class="body">&nbsp;&nbsp;Photo</td>
                                              <td height="25"><input name="photo" type="file" id="photo"></td>
                                            </tr>
                                            <tr> 
                                              <td width="27%" class="body">&nbsp;&nbsp;Text 
                                                * </td>
                                              <td width="73%"><textarea name="matt" cols="35" rows="5" id="matt" class="field"></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="headlines"> 
                                                <input name="act" type="hidden" id="act" value="create_done"></td>
                                              <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>">
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="Create"></td>
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
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <br>
    <br>
</td></tr>
<?php
	show_footer();
}

function create_done()	{
	global $_FILES;
	$adsess=form_get("adsess");
	admin_test($adsess);
	$matt=form_get("matt");
	$title=form_get("title");
	$source=form_get("source");
	$link=form_get("link");
	$zones=form_get("zones");
	$tmpfname=$_FILES['photo']['tmp_name'];
	$ftype=$_FILES['photo']['type'];
	$fsize=$_FILES['photo']['size'];
	$m_id=0;
	if((empty($matt)) || (empty($title)) || (empty($source)) || (empty($link))) 	{
		$matt="Please fill form properly.";
		$hed="admin.php?mode=headlines&act=create&err_mess=$matt&adsess=$adsess";
	}	else	{
		$sql_ins="insert into headlines (own,title,source,matt,link,rapzone,dt) values (";
		$sql_ins.="'$m_id','".addslashes($title)."','".addslashes($source)."','".addslashes($matt)."','$link','".addslashes($zones)."',now())";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		if(!empty($tmpfname))	{
			$path="news";
			//checkin image size
			if($fsize>500*1024)	error_screen(10);
			//checkin image type
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old=$path."/".$newname.$p_type;
			$thumb1=$path."/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,$path."/".$newname.$p_type);
			//creating thumbnails
			if($p_type==".jpeg")	$srcImage = ImageCreateFromJPEG( $old );
			elseif($p_type==".gif")	$srcImage = ImageCreateFromGIF( $old );
			$sizee=getimagesize($old);
			$srcwidth=$sizee[0];
			$srcheight=$sizee[1];
			//landscape
			if($srcwidth>$srcheight)	{
				$destwidth1=65;
				$rat=$destwidth1/$srcwidth;
				$destheight1=(int)($srcheight*$rat);
			}
			//portrait
			elseif($srcwidth<$srcheight)	{
				$destheight1=65;
				$rat=$destheight1/$srcheight;
				$destwidth1=(int)($srcwidth*$rat);
			}
			//quadro
			elseif($srcwidth==$srcheight)	{
				$destwidth1=65;
				$destheight1=65;
			}
			$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
			ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
			ImageJpeg($destImage1, $thumb1, 80);
			ImageDestroy($srcImage);
			ImageDestroy($destImage1);
			//updating db
			$photo=$path."/".$newname.$p_type;
			$photo_thumb=$path."/".$newname_th.".jpeg";
			$sql_query="update headlines set photo='$photo',photo_thumb='$photo_thumb' where id='$prim'";
			sql_execute($sql_query,'');
		}
		$matt="The Article is Added";
		$hed="admin.php?mode=headlines&err_mess=$matt&adsess=$adsess";
	}
	show_screen($hed);
}
function ednews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	show_ad_header($adsess);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$err_mess=form_get("err_mess");
	$sql_query="select * from headlines where id='$seid'";
	$row=sql_execute($sql_query,'get');
?>
<tr>
  <td valign="top" width="780" ><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="67" align="left" valign="top">&nbsp;</td>
              <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="admin.php?mode=headlines&adsess=<?=$adsess?>">View Articles</a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Edit 
                                        Articles</td>
                                    </tr>
                                    <tr>
                                      <td height="20" align="left" valign="middle" class="body">&nbsp;&nbsp;&nbsp;&nbsp; <font size="1">[Note: 
                                        * fields are mandatory!] </font></td>
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
                                      <td align="left" valign="top" class="body"> 
                                        <form name="form1" method="post" action="admin.php" enctype="multipart/form-data">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Title 
                                                * </td>
                                              <td height="25"><input name="title" type="text" id="title" size="30" value="<?=stripslashes($row->title)?>"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Source 
                                                * </td>
                                              <td height="25"><input name="source" type="text" id="source" size="30" value="<?=stripslashes($row->source)?>"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Page 
                                                Link *</td>
                                              <td height="25"><input name="link" type="text" id="link" size="30" value="<?=$row->link?>"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Rapzone 
                                                *</td>
                                              <td height="25"> 
                                                <?
											  $sql_query="select * from rapzones";
											  $res=sql_execute($sql_query,'res');   ?>
                                                <select name="zones">
                                                  <option value="All" selected>All</option>
                                                  <?	while($row_mails=mysql_fetch_object($res))	{ 
												  		if($row->rapzone==$row_mails->rapzone)	$ch="selected";
														else	$ch="";
												  ?>
                                                  <option value="<?=stripslashes($row_mails->rapzone)?>" <?=$ch?>><?=stripslashes($row_mails->rapzone)?></option>
                                                  <? } ?>
                                                </select></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;Photo</td>
                                              <td height="25"><input name="photo" type="file" id="photo"></td>
                                            </tr>
                                            <tr> 
                                              <td width="46%" class="body">&nbsp;&nbsp;Text 
                                                * </td>
                                              <td width="54%"> <textarea name="matt" cols="35" rows="5" id="matt" class="field"><?=stripslashes($row->matt)?></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="<?=$mode?>"> 
                                                <input name="act" type="hidden" id="act" value="modnews"> 
                                                <input name="seid" type="hidden" id="seid" value="<?=$seid?>"> 
                                                <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>"> 
                                              </td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="Modify"></td>
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
                </table></td>
              <td width="50" align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
    <br>
    <br>
</td></tr>
<?php
	show_footer();
}

function modnews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$matt=form_get("matt");
	$title=form_get("title");
	$source=form_get("source");
	$link=form_get("link");
	$show=form_get("show");
	$zones=form_get("zones");
	$tmpfname=$_FILES['photo']['tmp_name'];
	$ftype=$_FILES['photo']['type'];
	$fsize=$_FILES['photo']['size'];
	if((empty($matt)) || (empty($title)) || (empty($source)) || (empty($link)))	{
		$matt="please fill the form properly.";
		$hed="admin.php?mode=headlines&act=ednews&seid=$seid&err_mess=$matt&adsess=$adsess";
	}	else	{
		$sql_ins="update headlines set title='".addslashes($title)."',source='".addslashes($source)."',matt='".addslashes($matt)."',link='$link',rapzone='".addslashes($zones)."' where id=$seid";
		mysql_query($sql_ins);
		$prim=$seid;
		if(!empty($tmpfname))	{
			$path="news";
			//checkin image size
			if($fsize>500*1024)	error_screen(10);
			//checkin image type
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old=$path."/".$newname.$p_type;
			$thumb1=$path."/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,$path."/".$newname.$p_type);
			//creating thumbnails
			if($p_type==".jpeg")	$srcImage = ImageCreateFromJPEG( $old );
			elseif($p_type==".gif")	$srcImage = ImageCreateFromGIF( $old );
			$sizee=getimagesize($old);
			$srcwidth=$sizee[0];
			$srcheight=$sizee[1];
			//landscape
			if($srcwidth>$srcheight)	{
				$destwidth1=65;
				$rat=$destwidth1/$srcwidth;
				$destheight1=(int)($srcheight*$rat);
			}
			//portrait
			elseif($srcwidth<$srcheight)	{
				$destheight1=65;
				$rat=$destheight1/$srcheight;
				$destwidth1=(int)($srcwidth*$rat);
			}
			//quadro
			elseif($srcwidth==$srcheight)	{
				$destwidth1=65;
				$destheight1=65;
			}
			$destImage1 = ImageCreateTrueColor( $destwidth1, $destheight1);
			ImageCopyResized( $destImage1, $srcImage, 0, 0, 0, 0, $destwidth1, $destheight1, $srcwidth, $srcheight );
			ImageJpeg($destImage1, $thumb1, 80);
			ImageDestroy($srcImage);
			ImageDestroy($destImage1);
			//updating db
			$photo=$path."/".$newname.$p_type;
			$photo_thumb=$path."/".$newname_th.".jpeg";
			$sql_query="update headlines set photo='$photo',photo_thumb='$photo_thumb' where id='$prim'";
			sql_execute($sql_query,'');
		}
		$matt="Article is Updated.";
		$hed="admin.php?mode=headlines&act=ednews&seid=$seid&err_mess=$matt&adsess=$adsess";
	}
	show_screen($hed);
}
function remnews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
  	$sql_messrem="delete from headlines where id=$seid";
	mysql_query($sql_messrem);
	$matt="The Article is Removed";
	$hed="admin.php?mode=$mode&err_mess=$matt&page=$page&adsess=$adsess";
	show_screen($hed);
}
function viewnews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$mode=form_get("mode");
	$seid=form_get("seid");
	show_ad_header($adsess);
	$sql_query="select * from headlines where id='$seid'";
	$row=sql_execute($sql_query,'get');
?>
<tr>
  <td valign="top" width="780">
    <table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
        <td align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
            <tr> 
              <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr> 
                                <td width="86%" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                                    <tr> 
                                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr> 
                                            <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp; 
                                              <?=stripslashes($row->title)?>
                                            </td>
                                          </tr>
                                          <tr> 
                                            <td align="right" class="body"><a href="admin.php?mode=headlines&adsess=<?=$adsess?>">View Articles 
                                              </a>&nbsp;&nbsp;</td>
                                          </tr>
                                          <tr> 
                                            <td align="left" valign="top" class="body"> 
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b>Posted 
                                                    by :</b> 
                                                    <?=show_memnam($row->own)?>
                                                    on 
                                                    <?=format_date($row->dt)?>
                                                  </td>
                                                </tr>
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b>Source 
                                                    :</b> 
                                                    <?=stripslashes($row->source)?>
                                                  </td>
                                                </tr>
                                                <tr> 
                                                  <td width="84%" class="body"><table width="98%" align="center">
                                                      <tr> 
                                                        <td class="body"><strong>Text 
                                                          :</strong> 
                                                          <?=stripslashes($row->matt)?>
                                                        </td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b>Page 
                                                    Link :</b> <a href="<?=$row->link?>" target="_blank"> 
                                                    <?=$row->link?>
                                                    </a> </td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3" align="center">&nbsp;</td>
                                                </tr>
                                                <tr align="right"> 
                                                  <td colspan="3" class="body"> 
                                                    <a href="admin.php?mode=headlines&act=ednews&seid=<?=$seid?>&adsess=<?=$adsess?>">Edit</a>&nbsp;&nbsp;<a href="admin.php?mode=headlines&act=remnews&seid=<?=$seid?>&adsess=<?=$adsess?>">Delete</a>&nbsp;&nbsp; 
                                                    &nbsp;</td>
                                                </tr>
                                        </table></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <br> </td>
      </tr>
    </table>
    <br>
    <br>
</td></tr>
<?php
	show_footer();
}

//views on user since last visit
function show_views_visit($m_id){
$sql_query="select views,visit from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$views=split("\|",$mem->views);
$views=if_empty($views);
$views_visit=array();
if($views!=''){
foreach ($views as $view){
 if($view>=$mem->visit){
  array_push($views_visit,$view);
 }
 }
 }
$num=count($views_visit);
echo $num;
}

//showing when user visited site last time
function show_visit($m_id){
$sql_query="select visit from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$visit=date("m/d",$mem->visit);
echo $visit;
}
?>