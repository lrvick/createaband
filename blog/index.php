<?php
require('../data.php');
require('../functions.php');
sql_connect();

$act=form_get("act");
if($act=='')	 blogs();
elseif($act=='viewimg')	viewblogimg();

function blogs()	{
	global $main_url;	
	$seid=form_get("seid");
	$pro=$seid;
	show_header();
	$page=form_get("page");
	if($page=='')	$page=1;
	$start=($page-1)*20;
	$sql_query="select mem_id from members where profilenam='$seid'";
	$mem=sql_execute($sql_query,'get');
	$seid=$mem->mem_id;
	$sql_mails="select * from blogs where blog_own='$seid' order by blog_dt desc limit $start,20";
	$p_sql="select blog_id from blogs where blog_own='$seid' order by blog_dt desc";
	$p_url="index.php?seid=$seid";
	$res_mails=mysql_query($sql_mails);
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" class="lined padded-6">
		  <tr>
			<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
				  <td width="67" align="left" valign="top">&nbsp;</td>
				  <td width="663" align="left" valign="top" class="text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr> 
							  <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
								  <tr> 
									<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="title">&nbsp;&nbsp;Blog</td>
                                    </tr>
                                    <?php if(!mysql_num_rows($res_mails)) { ?>
                                    <tr>
                                      <td colspan="2" align="center" valign="middle" class="body">&nbsp;</td>
                                    </tr>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">Blog 
                                        Is Empty!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle"> 
                                        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                <?php $chk=1; ?>
                                                <?php while($row_mails=mysql_fetch_object($res_mails))	{
														if(empty($row_mails->blog_img))	$imgdis="<img src='noimage.jpg' border='0'>";
														else	$imgdis="<a href='index.php?act=viewimg&seid=$row_mails->blog_id&own=$pro'><img src='$main_url/".$row_mails->blog_img."' border='0'></a>";
											  ?>
                                                <tr> 
                                                  <td> 
                                                    <?=$imgdis?>
                                                  </td>
                                                  <td valign="middle"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr> 
                                                        <td class="body"><b> 
                                                          <?=stripslashes($row_mails->blog_title)?>
                                                          </b>&nbsp;&nbsp;</td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body">&nbsp;&nbsp; 
                                                          <?=stripslashes($row_mails->blog_matt)?>
                                                        </td>
                                                      </tr>
                                                    </table></td>
                                                  <td align="right" class="body"> 
                                                    <? echo date("m/d/Y h:i A",$row_mails->blog_dt); ?>
                                                    &nbsp;&nbsp; </td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3" height="5"></td>
                                                </tr>
                                                <?php $chk++; ?>
                                                <?php } ?>
                                                <tr> 
                                                  <td colspan="3" class="text">&nbsp;</td>
                                                </tr>
                                                <tr> 
                                                  <td width="30%" align="left">&nbsp;</td>
                                                  <td width="47%" align="left">&nbsp;</td>
                                                  <td width="23%" align="right">&nbsp; 
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
				  <td width="50" align="left" valign="top">&nbsp;</td>
				</tr>
			  </table></td>
		  </tr>
		</table>
<?php
	show_footer();
}

function viewblogimg()	{
	global $main_url;
	$seid=form_get("seid");
	$own=form_get("own");
	$sql_query="select * from blogs where blog_id='$seid'";
	$img=sql_execute($sql_query,'get');
	if(empty($img->blog_img))	$imgdis="<img src='blog/noimage.jpg' border='0'>";
	else	$imgdis="<img src='$main_url/".$img->blog_aimg."' border='0'>";
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
        <td align="center"><a href="index.php?seid=<?=$own?>">Back</a></td>
      </tr>
	<tr><td height="5"></td></tr>
    </table>
<?php
	show_footer();
}
?>