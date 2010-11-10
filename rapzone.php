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
if($act=='') show_global_news();
elseif($act=='fullstory') fullstory();
 
function show_global_news()	{
	$rid=form_get("rid");
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	show_header();
	$sql_query="select * from news where rapzone='$rid' or rapzone='all' order by id desc";
	$res_mails=sql_execute($sql_query,'res');
	if(mysql_num_rows($res_mails)) {
	?>
    
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined">
  <tr> 
    <td align="left" valign="top">&nbsp;<font color="#FFCC00" size="5"><b><? echo $rid; ?></b></font></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" cellpadding="0" cellspacing="0">
        <tr> 
          <td align="right"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="right"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td valign="top"><table width="100%" height="100%" border="0" align="right" cellpadding="0" cellspacing="0" class="body">
                          <tr> 
                            <td align="right"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr> 
                                  <td valign="top"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                                      <?php $chk=1; ?>
                                      <?php while($row_mails=mysql_fetch_object($res_mails))	{
											if(!empty($row_mails->photo_thumb))	$img_dis="<img src='$row_mails->photo_thumb' border='0'>";
											else	$img_dis="";	
									  ?>
                                      <tr> 
                                        <? if ($img_dis!="") { ?>
                                        <td valign="top"> 
                                          <?=$img_dis?>
                                        </td>
                                        <td valign="top" align="left"> 
                                          <? } else { ?>
                                        <td colspan="2" valign="middle" align="left"> 
                                          <? } ?>
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td height="25" valign="top" class="body"><b> 
                                                <?=stripslashes($row_mails->title)?>
                                                </b></td>
                                            </tr>
                                            <tr> 
                                              <td class="body"><b> 
                                                <?=show_memnam($row_mails->own)?>
                                                </b>&nbsp;Posted on 
                                                <?=format_date($row_mails->dt)?>
                                                &nbsp;&nbsp; </td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body"><b><?=LNG_RAPZONE_SOURCE?> :</b> 
                                                <?=stripslashes($row_mails->source)?>
                                              </td>
                                            </tr>
                                            <tr> 
                                              <td height="25"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr> 
                                                    <td class="body"><b><?=LNG_RAPZONE_LNK?> :</b> 
                                                      <a href="<?=$row_mails->link?>" target="_blank"> 
                                                      <?=$row_mails->link?>
                                                      </a> </td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                            <tr> 
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td> <table width="97%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr> 
                                                    <td class="body"> <? echo substr(stripslashes($row_mails->matt),0,200); ?>...&nbsp;<a href="index.php?mode=rapzone&act=fullstory&rid=<?=$row_mails->id?>&lng=<?=$lng_id?>"><?=LNG_RAPZONE_FULL_STORY?></a> &nbsp;&nbsp;</td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                      <tr> 
                                        <td colspan="5" height="10"></td>
                                      </tr>
                                      <?php $chk++; ?>
                                      <?php } ?>
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
      </table></td>
  </tr>
</table>
<?php
	}
	show_footer();
}

function fullstory()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	show_header();
	$rid=form_get("rid");
	$sql_query="select * from news where rapzone='$rid' or rapzone='all' order by id desc";
	$row=sql_execute($sql_query,'get');
	if(!empty($row->photo))	$img_dis="<img src='$row->photo' border='0'>";
	else	$img_dis="";
	?>
<table border="0" align="center" cellpadding="0" cellspacing="0" class="lined">
<tr> 
        <td align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr> 
                    <td align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr> 
                                <td align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                                    <tr> 
                                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                       <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp; 
                                        <?=stripslashes($row->title)?>
                                      </td>
                                          </tr>
									  <tr> 
                                      <td align="center" valign="middle">
                                        <?=$img_dis?>
                                      </td>
                                          </tr>
                                          <tr> 
                                            <td></td>
                                          </tr>
                                          <tr> 
                                            <td align="left" valign="top" class="body"> 
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_POSTED_BY?></b> 
                                                    <?=show_memnam($row->own)?>
                                                    <?=LNG_RAPZONE_ON?>
                                                    <?=format_date($row->dt)?>
                                                  </td>
                                                </tr>
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_RAPZONE_SOURCE?> :</b> 
                                                    <?=stripslashes($row->source)?>
                                                  </td>
                                                </tr>
                                                <tr> 
                                                  <td width="84%" class="body"><table width="98%" align="center">
                                                      <tr> 
                                                        <td class="body"><strong><?=LNG_RAPZONE_TEXT?> :</strong> 
                                                          <?=stripslashes($row->matt)?>
                                                        </td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_RAPZONE_PG_LNK?> :</b> <a href="<?=$row->link?>" target="_blank"> 
                                                    <?=$row->link?>
                                                    </a> </td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3" align="center">&nbsp;</td>
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
?>
