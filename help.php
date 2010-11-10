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
if($act=='')	 faqs();
elseif($act=='list')	 faqs_list();

function faqs()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	//login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$sql_mails="select * from faq_cat order by faqcat_id";
	$res_mails=mysql_query($sql_mails);
	show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined">
  <tr> 
    <td class="title">&nbsp;&nbsp;<?=LNG_HELP?>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <? if(mysql_num_rows($res_mails)) { ?>
  <? $s=0; ?>
  <tr> 
    <td valign="top"> <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0" class="body action">
        <? while($row=mysql_fetch_object($res_mails)) {
		if($s==0)	echo "<tr>";
		echo "<td><li>&nbsp;<b><a href='index.php?mode=help&act=list&cat=$row->faqcat_id&lng=$lng_id'>".stripslashes($row->faqcat_nam)."</a></b></li></td>";
		$s++;
		if($s==2)	{
			echo "</tr>";
			$s=0;
		}
		} ?>
		<tr><td height="5"></td></tr>
      </table></td>
  </tr>
  <? } ?>
</table>
<?
	show_footer();
}

function faqs_list()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	//login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$sql_query="select faqcat_nam from faq_cat where faqcat_id='$cat'";
	$cats=sql_execute($sql_query,'get');
	$sql_mails="select * from faqs where fa_post='n' and fa_cat='$cat' order by priority";
	$res_mails=mysql_query($sql_mails);
	show_header();
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
  <tr> 
    <td class="title action">&nbsp;<?=LNG_HELP?> - 
      <a href="index.php?mode=help&act=list&cat=<?=$cat?>&lng=<?=$lng_id?>" name="head"><?=stripslashes($cats->faqcat_nam)?></a>
    </td>
  </tr>
  <tr><td height="5"></td></tr>
  <tr>
    <td align="center" valign="top"><table width="75%" border="0" cellspacing="0" cellpadding="0">
	<?php if(mysql_num_rows($res_mails)) { ?>
	<?php while($row_mails=mysql_fetch_object($res_mails))	{ ?>
	<tr> 
	  <td><b> 
		<li>
		  <?=stripslashes($row_mails->fa_title)?>
		</li>
		</b></td>
	</tr>
	<tr> 
	  <td><table border="0" width="90%" cellpadding="0" cellspacing="0" align="center">
		  <tr> 
			<td class="body"> 
			  <?=stripslashes($row_mails->fa_desc)?>
			</td>
		  </tr>
		  <tr> 
			<td align="right" class="body"><a href="#head"><?=LNG_TOP?></a></td>
		  </tr>
		</table></td>
	</tr>
	<tr> 
	  <td>&nbsp;</td>
	</tr>
	<? } ?>
	<? } ?>
      </table></td>
  </tr>
</table>
<?php
	show_footer();
}
?>
