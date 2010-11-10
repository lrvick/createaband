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
if($act=="testi")	testi();
elseif($act=="contact")	contact();
elseif($act=='advert')	advert();

function testi()	{
	$page=form_get("page");
	if(empty($page))	$page=1;
	$from=($page-1)*20;
	show_header();
?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title">&nbsp;<?=LNG_TESTIMONIALS?></td>
  </tr>
</table>
<table width=100% class='body' align="center"><? show_testimonials_home($from,20); ?></table>
<table width=100% align="center"><tr><td align="center"><? pages_line("0","testimons",$page,"20") ?></td></tr></table>
<br>
<?
	show_footer();
}

function contact()	{
	global $admin_mail,$site_name;
	$done=form_get("done");
	if(empty($done))	{
		show_header();
?>
<script language="JavaScript1.2">
var good;
function checkEmailAddress(field) {
	var goodEmail = field.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi);
	if (goodEmail){
		good = true;
	} else {
		alert('Please enter a valid e-mail address.');
		field.focus();
		field.select();
		good = false;
	}
}

function sendOff(){
	nmcheck = document.form1.nm.value;
	if (nmcheck.length <1) {
		alert('Please enter your name.');
		return;
	}
	emcheck = document.form1.em.value;
	if (emcheck.length <1) {
		alert('Please enter your email.');
		return;
	}
	commcheck = document.form1.comm.value;
	if (commcheck.length <1) {
		alert('Please enter your comments.');
		return;
	}
	good = false
	checkEmailAddress(document.form1.em);
}
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2" class="title">&nbsp;<?=LNG_CONTACT_US?></td>
  </tr>
  <tr> 
    <td width="62">&nbsp;</td>
    <td width="718">&nbsp;&nbsp; <?=LNG_QUES_COMMENT_MSG?><font color="#FF0000"><font size="2"><?=LNG_MANDATORY_FIELDS?></font></font></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><form name="form1" method="post" action="index.php">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="30">&nbsp;<?=LNG_NAME?></td>
            <td height="30"> <input type="text" name="nm"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_EMAIL?></td>
            <td height="30"><input type="text" name="em"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_COMMENTS?></td>
            <td height="30"><textarea name="comm" cols="50" rows="3" id="comm"></textarea></td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2"><input name="act" type="hidden" id="act" value="contact"> 
              <input name="mode" type="hidden" id="mode" value="common"> <input name="done" type="hidden" id="done" value="done"> 
              <input type="submit" name="Submit" value="Send Mail" onClick="javascript:this.value='<?=LNG_COMM_PW?>';sendOff();" class="submit"> 
              &nbsp; <input type="reset" name="Submit2" value="<?=LNG_COMM_FRSET?>" class="submit"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?
		show_footer();
	}	else	{
		$to = $admin_mail;
		$em=form_get("em");
		$nm=form_get("nm");
		$comm=form_get("comm");
		$chk=is_email_valid($em);
		if((!empty($em)) and ($chk==1) and (!empty($nm)) and (!empty($comm)))	{
			$now=time();
			$sql_query="insert into contact_req (name,email,comment,date) values ('".addslashes($nm)."','".addslashes($em)."','".addslashes($comm)."','$now')";
			sql_execute($sql_query,'');
			$data[3] = $em;
			$data[2] = $nm;
			$data[0] = $site_name." " . LNG_COMM_CREQ;
			$data[1] = $comm;
			messages($to,8,$data);
		}
		$link="index.php?mode=common&act=contact&lng=" . $lng_id;
		show_screen($link);
		exit();
	}
}

function advert()	{
	global $admin_mail,$site_name;
	$done=form_get("done");
	$err=form_get("err");
	if(empty($done))	{
		show_header();
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2" class="title">&nbsp;<?=LNG_ADVERTISE_WITH_US?></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp; <?=LNG_ADVERTISE_MSG?><font color="#FF0000"><font size="2"> 
      <?=LNG_STAR_FIELD?></font></font></td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td width="718" valign="top"><form name="form1" method="post" action="index.php">
        <table width="100%" border="0" cellspacing="3" cellpadding="3">
		<? if(!empty($err)) { ?>
          <tr> 
            <td height="30" colspan="2" class="lined"><?=LNG_PROPER_FILL?></td>
          </tr>
		<? } ?>
          <tr> 
            <td width="43%" height="30">&nbsp;<?=LNG_FIRST_NAME?> <font color="#FF0000">*</font></td>
            <td width="57%" height="30"> <input type="text" name="fname"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_LAST_NAME?> <font color="#FF0000">*</font></td>
            <td height="30"><input type="text" name="lname"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_COMPANY?></td>
            <td height="30"><input type="text" name="company"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_EMAIL?> <font color="#FF0000">*</font></td>
            <td height="30"><input type="text" name="email"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_WEBSITE_URL?></td>
            <td height="30"><input type="text" name="siteurl"  size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_PHONE?></td>
            <td height="30"><input type="text" name="phoneno" size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_CITY?></td>
            <td height="30"><input type="text" name="city" size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_STATE?></td>
            <td height="30"><input type="text" name="stpro" size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_COUNTRY?></td>
            <td height="30"> <select name="country">
                <? echo country_drop(); ?> </select></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_INDUSTRY?></td>
            <td height="30"><input type="text" name="industry" size="30"></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_MONTHLY_BUDGET?></td>
            <td height="30"> <select name="emb">
                <option value="--None--" selected><?=LNG_NONE?></option>
                <option value="<<$3k"><?=LNG_L3K?></option>
                <option value="$3-10k"><?=LNG_3_10K?></option>
                <option value="$10-30k"><?=LNG_10_30K?></option>
                <option value="$30k>>"><?=LNG_G30K></option>
              </select></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_COMPANY_DESC?></td>
            <td height="30"><textarea name="descom" cols="35" rows="5"></textarea></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_TIME_FRAME?></td>
            <td height="30"> <select name="timeframe">
                <option value="--None--" selected><?=LNG_NONE?></option>
                <option value="1-3 Months"><?=LNG_1_3_MONTH?></option>
                <option value="3-6 Months"><?=LNG_3_6_MONTH?></option>
                <option value="Immediate"><?=LNG_IMMEDIATE?></option>
                <option value="Research Only"><?=LNG_RESEARCH_ONLY?></option>
              </select></td>
          </tr>
          <tr> 
            <td height="30">&nbsp;<?=LNG_ADVERTISE_ONLINE?></td>
            <td height="30"> <select name="advonline">
                <option value="--None--" selected><?=LNG_NONE?></option>
                <option value="No"><?=LNG_NO?></option>
                <option value="Yes"><?=LNG_YES?></option>
              </select></td>
          </tr>
          <tr align="center"> 
            <td height="30" colspan="2"><input name="act" type="hidden" id="act" value="advert"> 
              <input name="mode" type="hidden" id="mode" value="common"> <input name="done" type="hidden" id="done" value="done"> 
              <input type="submit" name="Submit" value="<?=LNG_COMM_SEND_REQ?>" onClick="javascript:this.value='<?=LNG_COMM_PW?>';" class="submit"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?
		show_footer();
	}	else	{
		$to = $admin_mail;
		$vals=array("fname","lname","company","siteurl","email","phoneno","city","stpro","country","industry","emb","descom","timeframe","advonline");
		foreach($vals as $val)	{
			${$val}=form_get("$val");
		}
		$chk=is_email_valid($email);
		if((empty($fname))||(empty($lname))||(empty($email))||($chk!=1))	{
			$link="index.php?mode=common&act=advert&err=y&lng=" . $lng_id;
			show_screen($link);
			exit();
		}	else	{
			$now=time();
			$sql_query="insert into advert (fname,lname,company,siteurl,email,phoneno,city,stpro,country,industry,emb,descom,timeframe,advonline,date) values ('".addslashes($fname)."','".addslashes($lname)."','".addslashes($company)."','".addslashes($siteurl)."','".addslashes($email)."','".addslashes($phoneno)."','".addslashes($city)."','".addslashes($stpro)."','".addslashes($country)."','".addslashes($industry)."','".addslashes($emb)."','".addslashes($descom)."','".addslashes($timeframe)."','".addslashes($advonline)."','$now')";
			sql_execute($sql_query,'');
		}
		$link="index.php?mode=common&act=advert&lng=" . $lng_id;
		show_screen($link);
		exit();
	}
}
?>
