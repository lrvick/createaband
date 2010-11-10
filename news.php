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
//echo "<br>==>" . $act;

$act=form_get("act");
$err_mess=form_get("err_mess");
if($act=='')	 show_news();
elseif($act=='create')	create_news();
elseif($act=='create_done')	create_done();
elseif($act=='ednews')	ednews();
elseif($act=='modnews')	modnews();
elseif($act=='remnews')	remnews();
elseif($act=='view')	viewnews();
elseif($act=='comment')	addcomment();
function news()	{
	global $lines10,$lcoun,$lng_id;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	show_header();
	$mode=form_get("mode");
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_mails="select * from news order by dt desc";
	$res_mails=mysql_query($sql_mails);
	?>
	<tr>
  <td valign="top" width="100%">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
        <td align="left" valign="top"> <table width="100%" cellpadding="0" cellspacing="0">
            <tr> 
              <td align="right"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr> 
                          <td width="86%" valign="top"><table width="100%" height="100%" border="0" align="right" cellpadding="0" cellspacing="0" class="body">
                              <tr> 
                                <td align="right" valign="top"> 
                                  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_NEWS_RPA?></td>
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
                                      <td height="20" colspan="2" align="center" valign="middle" class="body"><?=LNG_LIST_IS_EMPTY?></td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle"> 
                                        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                <?php $chk=1; ?>
                                                <?php while($row_mails=mysql_fetch_object($res_mails))	{
														$fr=split(",",$row_mails->mems);
														$show=0;
														for($i=0; $i<=count($fr); $i++)	{
															if($m_id==$fr[$i])	$show=1;
														}
														if($show==1)	{
											  ?>
                                                <tr> 
                                                  <td width="86%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td height="25" colspan="2" class="body"><b> 
                                                          <?=stripslashes($row_mails->title)?>
                                                          </b></td>
                                                      </tr>
                                                      <tr> 
                                                        <td width="80%" class="body"><b> 
                                                          <?=show_memnam($row_mails->own)?>
                                                          </b>&nbsp;<?=LNG_POSTED_ON?> 
                                                          <?=format_date($row_mails->dt)?>
                                                          &nbsp;&nbsp;</td>
                                                        <td width="20%" align="right" class="body"> 
                                                          <?php if($m_id==$row_mails->own)	{ ?>
                                                          <a href="admin.php?mode=news&act=ednews&seid=<?=$row_mails->id?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>&nbsp;&nbsp;
                                                          <a href="admin.php?mode=news&act=remnews&seid=<?=$row_mails->id?>&page=<?=$page?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a> 
                                                          <?php } ?>
                                                        </td>
                                                      </tr>
                                                      <tr> 
                                                        <td height="25" colspan="2" class="body"><b><?=LNG_RAPZONE_SOURCE?> 
                                                          :</b> 
                                                          <?=stripslashes($row_mails->source)?>
                                                        </td>
                                                      </tr>
                                                      <tr> 
                                                        <td height="25" colspan="2"> 
                                                          <table width="89%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr> 
                                                              <td class="body"><b><?=LNG_RAPZONE_LNK?> 
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
                                                                <? echo substr(rep_htm(stripslashes($row_mails->matt)),0,200); ?>...&nbsp;<a href="admin.php?mode=news&act=view&seid=<?=$row_mails->id?>&lng=<?=$lng_id?>"><?=LNG_RAPZONE_FULL_STORY?></a> &nbsp;&nbsp;</td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="4">&nbsp;</td>
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
  <td valign="top" width="100%"><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="admin.php?mode=news&adsess=<?=$adsess?>&lng=<?=$lng_id?>"><?=LNG_NEWS_VIEW_POSTS?></a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_NEWS_P_NEW_AR?></td>
                                    </tr>
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="body">&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <font size="1"><?=LNG_NEWS_NOTE?> 
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
                                        <form method="post" action="admin.php">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;<?=LNG_TITLE?> 
                                                * </td>
                                              <td height="25"> <input name="title" type="text" id="title" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;<?=LNG_RAPZONE_SOURCE?> 
                                                * </td>
                                              <td height="25"><input name="source" type="text" id="source" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;<?=LNG_RAPZONE_PG_LNK?> *</td>
                                              <td height="25"><input name="link" type="text" id="link" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td width="27%" class="body">&nbsp;&nbsp;<?=LNG_RAPZONE_TEXT?> 
                                                * </td>
                                              <td width="73%"><textarea name="matt" cols="35" rows="5" id="matt" class="field"></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="news"> 
                                                <input name="act" type="hidden" id="act" value="create_done"></td>
                                              <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>">
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="<?=LNG_RIDEZ_CREATE?>"></td>
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
	$adsess=form_get("adsess");
	global $lng_id;
	admin_test($adsess);
	$matt=form_get("matt");
	$title=form_get("title");
	$source=form_get("source");
	$link=form_get("link");
	$m_id=0;
	if((empty($matt)) || (empty($title)) || (empty($source)) || (empty($link))) 	{
		$matt=LNG_NEWS_AX;
		$hed="admin.php?mode=news&act=create&err_mess=$matt&adsess=$adsess&lng=$lng_id";
	}	else	{
		$sql_ins="insert into news (own,title,source,matt,link,mems,dt) values (";
		$sql_ins.="'$m_id','".addslashes($title)."','".addslashes($source)."','".addslashes($matt)."','$link','$fr',now())";
		mysql_query($sql_ins);
		$matt="The Article is Added";
		$hed="admin.php?mode=news&err_mess=$matt&adsess=$adsess&lng=$lng_id";
	}
	show_screen($hed);
}
function ednews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	global $lng_id;
	show_ad_header($adsess);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$err_mess=form_get("err_mess");
	$sql_query="select * from news where id='$seid'";
	$row=sql_execute($sql_query,'get');
?>
<tr>
  <td valign="top" width="100%" ><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="67" align="left" valign="top">&nbsp;</td>
              <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="admin.php?mode=news&adsess=<?=$adsess?>&lng=<?=$lng_id?>"><?=LNG_NEWS_BX?></a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?=LNG_NEWS_CX?></td>
                                    </tr>
                                    <tr>
                                      <td height="20" align="left" valign="middle" class="body">&nbsp;&nbsp;&nbsp;&nbsp; <font size="1"><?=LNG_NEWS_NOTE?> </font></td>
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
                                        <form name="form1" method="post" action="admin.php">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;<?=LNG_TITLE?> 
                                                * </td>
                                              <td height="25"><input name="title" type="text" id="title" size="30" value="<?=stripslashes($row->title)?>"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;<?=LNG_RAPZONE_SOURCE?> 
                                                * </td>
                                              <td height="25"><input name="source" type="text" id="source" size="30" value="<?=stripslashes($row->source)?>"></td>
                                            </tr>
                                            <tr> 
                                              <td height="25" class="body">&nbsp;&nbsp;<?=LNG_RAPZONE_PG_LNK?> *</td>
                                              <td height="25"><input name="link" type="text" id="link" size="30" value="<?=$row->link?>"></td>
                                            </tr>
                                            <tr> 
                                              <td width="46%" class="body">&nbsp;&nbsp;<?=LNG_RAPZONE_TEXT?> 
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
	global $lng_id;
	$mode=form_get("mode");
	$seid=form_get("seid");
	$matt=form_get("matt");
	$title=form_get("title");
	$source=form_get("source");
	$link=form_get("link");
	$show=form_get("show");
	for($i=0; $i<=count($show); $i++)	{
		if(!empty($fr))	$fr=$fr.",".$show[$i];
		else	$fr=$show[$i];
	}
	$fr=$fr.$m_id;
	if((empty($matt)) || (empty($title)) || (empty($source)) || (empty($link)) || ($fr==$m_id))	{
		$matt=LNG_NEWS_DX;
		$hed="admin.php?mode=news&act=ednews&seid=$seid&err_mess=$matt&adsess=$adsess&lng=$lng_id";
	}	else	{
		$sql_ins="update news set title='".addslashes($title)."',source='".addslashes($source)."',matt='".addslashes($matt)."',mems='$fr',link='$link' where id=$seid";
		mysql_query($sql_ins);
		$prim=$seid;
		$matt="Article is Updated.";
		$hed="admin.php?mode=news&act=ednews&seid=$seid&err_mess=$matt&adsess=$adsess&lng=$lng_id";
	}
	show_screen($hed);
}
function remnews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	global $lng_id;
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
  	$sql_messrem="delete from news where id=$seid";
	mysql_query($sql_messrem);
  	$sql_messrem="delete from news_comments where news_id=$seid";
	//mysql_query($sql_messrem);
	$matt="The Article is Removed";
	$hed="admin.php?mode=$mode&err_mess=$matt&page=$page&adsess=$adsess&lng=$lng_id";
	show_screen($hed);
}
function viewnews()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	global $lng_id;
	$mode=form_get("mode");
	$seid=form_get("seid");
	$sql_query="select * from news where id='$seid'";
	$row=sql_execute($sql_query,'get');
	$sql_comm="select * from news_comments where news_id='$seid'";
	//$res_comm=mysql_query($sql_comm);
?>
<tr>
  <td valign="top" width="100%">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                            <td align="right" class="body"><a href="admin.php?mode=news&adsess=<?=$adsess?>&lng=<?=$lng_id?>"><?=LNG_NEWS_BX?> 
                                              </a>&nbsp;&nbsp;</td>
                                          </tr>
                                          <tr> 
                                            <td align="left" valign="top" class="body"> 
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_POSTED_BY?> </b> 
                                                    <?=show_memnam($row->own)?>
                                                    <?=LNG_ON?>
                                                    <?=format_date($row->dt)?>
                                                  </td>
                                                </tr>
                                                <tr> 
                                                  <td height="25" class="body">&nbsp;&nbsp;<b><?=LNG_RAPZONE_SOURCE?> 
                                                    :</b> 
                                                    <?=stripslashes($row->source)?>
                                                  </td>
                                                </tr>
                                                <tr> 
                                                  <td width="84%" class="body"><table width="98%" align="center">
                                                      <tr> 
                                                        <td class="body"><strong><?=LNG_RAPZONE_TEXT?> 
                                                          :</strong> 
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
                                                <tr align="right"> 
                                                  <td colspan="3" class="body"> 
                                                    <?php if($m_id==$row->own)	{ ?>
                                                    <a href="admin.php?mode=news&act=ednews&seid=<?=$seid?>&lng=<?=$lng_id?>"><?=LNG_EDIT?></a>&nbsp;&nbsp;<a href="admin.php?mode=news&act=remnews&seid=<?=$seid?>&lng=<?=$lng_id?>"><?=LNG_DELETE?></a>&nbsp;&nbsp; 
                                                    <?php } ?>
                                                    &nbsp;</td>
                                                </tr>
                                                <?php if(mysql_num_rows($res_comm)) { 
										  			while($row_comm=mysql_fetch_object($res_comm))	{
										  ?>
                                                <tr> 
                                                  <td colspan="3" align="center" valign="top" class="lined"> 
                                                    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                      <tr> 
                                                        <td class="title">&nbsp;&nbsp;<?=LNG_NEWS_ADDED_BY?> 
                                                          <?=show_memnam($row_comm->own)?>
                                                          <?=LNG_ON?>
                                                          <?=format_date($row_comm->dt)?>
                                                        </td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body"><table width="92%" align="center">
                                                            <tr> 
                                                              <td class="body"> 
                                                                <?=stripslashes($row_comm->comm)?>
                                                              </td>
                                                            </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                </tr>
                                                <?php } } ?>
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
function show_news()	{
	$m_id=cookie_get("mem_id");	
	
	global $lng_id;
	
	$sql_query="select rapzone from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');	
	$sql_query="select * from news where rapzone='$mem->rapzone' or rapzone ='all' order by id desc";	
	$res_mails=sql_execute($sql_query,'res');	
	show_header();
	
	if(mysql_num_rows($res_mails)) {		
	?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
  <?php $chk=1; ?>    
  <?php while($row_mails=mysql_fetch_object($res_mails))	{
		if(!empty($row_mails->photo_thumb))	$img_dis="<img src='$row_mails->photo_thumb' border='0'>";
		else	$img_dis="";			
  ?>
  <tr> 
  	<td valign="top" align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <? 
		  if ($img_dis!="") { ?>
		  <td width="17%" height="25" valign="top" class="body" rowspan="4"><?=$img_dis?></td> <? } ?>
          <td width="83%" valign="top" class="body"><b> 
            <?=stripslashes($row_mails->title)?>
            </b></td>
        </tr>
        <tr> 
          <td colspan="2" class="body"><b> 
            <?=show_memnam($row_mails->own)?>
            </b>&nbsp;<?=LNG_POSTED_ON?> 
            <?=format_date($row_mails->dt)?>
            &nbsp;&nbsp; </td>
        </tr>
        <tr> 
          <td height="25" colspan="2" class="body"><b><?=LNG_RAPZONE_SOURCE?> :</b> 
            <?=stripslashes($row_mails->source)?>
          </td>
        </tr>
        <tr> 
          <td height="25" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class="body"><b><?=LNG_RAPZONE_LNK?> :</b> <a href="<?=$row_mails->link?>" target="_blank"> 
                  <?=$row_mails->link?>
                  </a> </td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="2"> <table width="97%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td class="body"> <? echo substr(stripslashes($row_mails->matt),0,200); ?>...&nbsp;<a href="index.php?mode=login&act=news&typ=l&seid=<?=$row_mails->id?>&lng=<?=$lng_id?>"><?=LNG_RAPZONE_FULL_STORY?></a> &nbsp;&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>
    </td>
	  </tr>
	  <tr> 
		<td colspan="5" height="10"></td>
	  </tr>
	  <?php $chk++; ?>
	  <?php } ?>
	</table>
<?php
	}
	show_footer();
}

?>
