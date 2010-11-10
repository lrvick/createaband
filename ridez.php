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
if($act=='')	 ridez();
elseif($act=='create')	create_ride();
elseif($act=='create_done')	create_done();
elseif($act=='edride')	edride();
elseif($act=='modride')	modride();
elseif($act=='remride')	remride();
elseif($act=='viewimg')	viewrideimg();

function ridez()	{
	global $main_url;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	if($page=='')	$page=1;
	$start=($page-1)*20;
	$sql_mails="select * from ridez order by ride_dt desc limit $start,20";
	$p_sql="select ride_id from ridez order by ride_dt desc";
	$p_url="index.php?mode=ridez&lng=" . $lng_id;
	$res_mails=mysql_query($sql_mails);
	show_header();
	?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
				  <td align="left" valign="top" class="text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						
                <td align="right" class="body"><a href="index.php?mode=ridez&act=create&lng=<?=$lng_id?>"><?=LNG_RIDEZ_AD_RID?></a>&nbsp;&nbsp;</td>
					  </tr>
					  <tr> 
						<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr> 
							  <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
								  <tr> 
									<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
										<tr> 
										  
                                  <td height="20" colspan="2" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_RIDEZ_RIDZ?></td>
										</tr>
										<tr> 
										  
                                  <td height="20" colspan="2" align="right" valign="middle" class="form-comment">&nbsp;&nbsp; 
                                  </td>
										</tr>
										<?php	if(!empty($err_mess))	{	?>
										<tr> 
										  <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
											<?=ucwords($err_mess)?></td>
										</tr>
										<?php	}	?>
										<?php if(!mysql_num_rows($res_mails)) { ?>
										<tr> 
										  
                                  <td height="20" colspan="2" align="center" valign="middle" class="body"><?=LNG_RIDEZ_NO_ITM?> </td>
										</tr>
										<?php } else { ?>
										<tr> 
										  <td height="20" colspan="2" align="left" valign="middle"> 
											<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
											  <tr> 
												<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
													<?php $chk=1; ?>
													<?php while($row_mails=mysql_fetch_object($res_mails))	{
														if(empty($row_mails->ride_img))	$imgdis="<img src='ride/noimage.jpg' border='0'>";
														else	$imgdis="<a href='index.php?mode=ridez&act=viewimg&seid=$row_mails->ride_id&lng=$lng_id'><img src='".$row_mails->ride_img."' border='0'><a>";
											  ?>
													<tr> 
													  <td> 
														<?=$imgdis?>
													  </td>
                                                  <td valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr> 
                                                    <td class="body"><b> <? echo name_header($row_mails->ride_own,$m_id); ?> 
                                                      </b>&nbsp;&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                    <td class="body"><strong><?=stripslashes($row_mails->ride_title)?></strong></td>
                                                  </tr>
                                                  <tr> 
                                                    <td class="body">&nbsp;&nbsp; 
                                                      <?=stripslashes($row_mails->ride_matt)?>
                                                    </td>
                                                  </tr>
                                                </table> </td>
													  <td align="right" class="body"> 
													  <? if($row_mails->ride_own==$m_id) { ?>
														<a href="index.php?mode=ridez&act=edride&seid=<?=$row_mails->ride_id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>&nbsp;&nbsp;
														<a href="index.php?mode=ridez&act=remride&seid=<?=$row_mails->ride_id?>&page=<?=$page?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>&nbsp;&nbsp;<br> <? } ?>
														<? echo date("m/d/Y h:i A",$row_mails->ride_dt); ?>
														&nbsp;&nbsp; </td>
													</tr>
													<tr> 
													  <td colspan="3">&nbsp;</td>
													</tr>
													<?php $chk++; ?>
													<?php } ?>
													<tr> 
													  <td colspan="3" class="text">&nbsp;</td>
													</tr>
													<tr> 
													  <td width="17%" align="left">&nbsp;</td>
													  <td width="62%" align="left">&nbsp;</td>
													  <td width="21%" align="right">&nbsp; 
													  </td>
													</tr>
												  </table></td>
											  </tr>
											</table></td>
										</tr>
										<tr> 
										  <td width="93%" height="20" align="right" valign="middle" class="body"> 
											<? echo page_nums($p_sql,$p_url,$page,20); ?>
										  </td>
										  <?php } ?>
										  <td width="7%" align="center" valign="middle" class="text">&nbsp;</td>
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
	<?php
	show_footer();
}
function create_ride()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="right" class="body"><a href="index.php?mode=ridez"><?=LNG_RIDEZ_RID_LST?></a>&nbsp;&nbsp;</td>
        </tr>
        <tr> 
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_RIDEZ_CR_RIDE?></td>
                          </tr>
                          <?php	if(!empty($err_mess))	{	?>
                          <tr> 
                            <td height="20" align="center" valign="middle" class="form-comment"> 
                              <?=ucwords($err_mess)?>
                            </td>
                          </tr>
                          <?php	}	?>
                          <tr> 
                            <td align="left" valign="middle" class="text"> <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr> 
                                    <td class="body">&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr> 
                                    <td height="25" class="body">&nbsp;&nbsp;<?=LNG_TITLE?></td>
                                    <td height="25"><input name="ride_title2" type="text" id="ride_title2" size="25"></td>
                                  </tr>
                                  <tr> 
                                    <td width="44%" class="body">&nbsp;&nbsp;<?=LNG_MATTER?></td>
                                    <td width="56%"><textarea name="textarea" cols="35" rows="5" id="textarea" class="field"></textarea> 
                                      <input name="second2" type="hidden" id="second2" value="set"> 
                                      <input name="mode2" type="hidden" id="mode2" value="<?=$mode?>"> 
                                      <input name="act2" type="hidden" id="mode2" value="create_done"></td>
                                  </tr>
                                  <tr> 
                                    <td class="body">&nbsp;&nbsp;<?=LNG_IMAGE?></td>
                                    <td height="30"> <input name="photo2" type="file" id="photo2" size="30" class="field"> 
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td colspan="2" align="center"><input type="submit" name="Submit2" value="<?=LNG_RIDEZ_CREATE?>"></td>
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
	$ridematt=form_get("ridematt");
	$ride_title=form_get("ride_title");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if((empty($ridematt)) || (empty($ride_title)))	{
		$matt="please enter the ride matter.";
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}	else	{
		$now=time();
		$sql_ins="insert into ridez (ride_own,ride_matt,ride_title,ride_dt) values (";
		$sql_ins.="$m_id,'".addslashes($ridematt)."','".addslashes($ride_title)."','$now')";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		if($tmpfname!='')	{
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old="ride/".$newname.$p_type;
			$thumb1="ride/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,"ride/".$newname.$p_type);
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
			$photo="ride/".$newname.$p_type;
			$photo_thumb="ride/".$newname_th.".jpeg";
			$sql_img="update ridez set ride_img='".$photo_thumb."',ride_aimg='".$photo."' where ride_id=".$prim;
			mysql_query($sql_img);
		}
		$matt=LNG_RIDEZ_ADDED_LIST;
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}
	show_screen($hed);
}
function edride()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$sql_query="select * from ridez where ride_id='$seid'";
	$row=sql_execute($sql_query,'get');
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="right" class="body"><a href="index.php?mode=ridez&lng=<?=$lng_id?>"><?=LNG_RIDEZ_RID_LST?></a>&nbsp;&nbsp;</td>
              </tr>
              <tr> 
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="86%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                          <tr> 
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_RIDEZ_EDT_RID?></td>
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
                                          <td height="25" class="body">&nbsp;&nbsp;<?=LNG_TITLE?></td>
                                          <td height="25"><input name="ride_title" type="text" id="ride_title3" size="25" value="<?=stripslashes($row->ride_title)?>"></td>
                                        </tr>
                                        <tr> 
                                          <td width="46%" class="body">&nbsp;&nbsp;<?=LNG_MATTER?></td>
                                          <td width="54%"> <textarea name="ridematt" cols="35" rows="5" id="textarea2" class="field"><?=stripslashes($row->ride_matt)?></textarea> 
                                            <input name="second" type="hidden" id="second3" value="set"> 
                                            <input name="mode" type="hidden" id="mode3" value="<?=$mode?>"> 
                                            <input name="act" type="hidden" id="act2" value="modride"> 
                                            <input name="seid" type="hidden" id="seid2" value="<?=$seid?>"> 
                                          </td>
                                        </tr>
                                        <tr> 
                                          <td class="body">&nbsp;&nbsp;<?=LNG_IMAGE?></td>
                                          <td height="30"><input name="photo" type="file" id="photo3" size="30" class="field"></td>
                                        </tr>
                                        <tr> 
                                          <td colspan="2" align="center"><input type="submit" name="Submit" value="<?=LNG_RIDEZ_MODIFY?>"></td>
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
<?php
	show_footer();
}
function modride()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$ridematt=form_get("ridematt");
	$ride_title=form_get("ride_title");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if((empty($ridematt)) || (empty($ride_title)))	{
		$matt=LNG_RIDEZ_ENTER_RID_MAT;
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}	else	{
		$sql_ins="update ridez set ride_title='".addslashes($ride_title)."',ride_matt='".addslashes($ridematt)."' where ride_id=$seid";
		mysql_query($sql_ins);
		$prim=$seid;
		if($tmpfname!='')	{
			if(($ftype=='image/jpeg')||($ftype=='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype=='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			$newname_th=$newname."th";
			$old="ride/".$newname.$p_type;
			$thumb1="ride/".$newname_th.".jpeg";
			move_uploaded_file($tmpfname,"ride/".$newname.$p_type);
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
			$photo="ride/".$newname.$p_type;
			$photo_thumb="ride/".$newname_th.".jpeg";
			$sql_img="update ridez set ride_img='".$photo_thumb."',ride_aimg='".$photo."' where ride_id=".$prim;
			mysql_query($sql_img);
		}
		$matt=LNG_RIDEZ_UPDATED_RIDE;
		$hed="index.php?mode=$mode&act=$act&err_mess=$matt&lng=" . $lng_id;
	}
	show_screen($hed);
}
function remride()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
	$sql_query="select * from ridez where ride_id='$seid'";
	$num=sql_execute($sql_query,'num');
	if($num!=0)	{
		$row_img=sql_execute($sql_query,'get');
		$pic_out=$row_img->ride_img;
		if(file_exists($pic_out))	@unlink($pic_out);
	}
  	$sql_messrem="delete from ridez where ride_id=$seid";
	mysql_query($sql_messrem);
	$matt=LNG_REMOVAL_COMPLETED;
	$hed="index.php?mode=$mode&err_mess=$matt&page=$page&lng=" . $lng_id;
	show_screen($hed);
}

function viewrideimg()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$seid=form_get("seid");
	$sql_query="select * from ridez where ride_id='$seid'";
	$img=sql_execute($sql_query,'get');
	if(empty($img->ride_img))	$imgdis="<img src='ride/noimage.jpg' border='0'>";
	else	$imgdis="<img src='".$img->ride_aimg."' border='0'>";
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
        <td align="center"><a href="index.php?mode=ridez&lng=<?=$lng_id?>"><?=LNG_BACK?></a></td>
      </tr>
	  <tr><td height="5"></td></tr>
    </table>
<?php
	show_footer();
}
?>
