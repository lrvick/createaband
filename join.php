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
if($act=='')	{
	$was=time()-3600*24;
	$sql_query="delete from members where verified='n' and joined<$was";
//	sql_execute($sql_query,'');
	sign_up_form();
}	elseif($act=='reg')	do_register();
elseif($act=='val')	validate();

//showing sign-up form
function sign_up_form()	{
	$inv_id=form_get("inv_id");
	global $lng_id;

	if($inv_id!='')	{
		$sql_query="select mem_id from invitations where inv_id='$inv_id'";
		$inv=sql_execute($sql_query,'get');
		$sql_query="select fname,lname from members where mem_id='$inv->mem_id'";
		$mem=sql_execute($sql_query,'get');
	}
	$sql_accc="select * from member_package order by package_amt";
	$res_accc=mysql_query($sql_accc);
	show_header();
?>
<form action="index.php" method=post>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr><td height="5"></td></tr>
<tr>
      <td class="hometitle" height="20" style="padding-left: 7"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><?=LNG_JOIN_INT_COMU?> </b></font></td>
    </tr>
<tr><td height="5"></td></tr>
<tr>
      <td class="homelined" style="padding-left: 10;padding-top: 3;padding-bottom: 3"> 
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?=LNG_JOIN_REG_TOT_FREE?></font><? if(empty($inv_id)) { ?> 
          <font face="Verdana, Arial, Helvetica, sans-serif" size="2">

          <?=LNG_JOIN_LNG_MSG_A?> <a href="http://www.Site Name.com/index.php?mode=login&amp;act=form&lng=<?=$lng_id?>"><?=LNG_JOIN_CLK_TO_LOGIN?></a>.</font><br>
          <br>
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_JOIN_LNG_MSG_B?></font><? } else { ?> 
          <br>
          <?=ucwords(stripslashes($mem->fname))?>&nbsp;<?=ucwords(stripslashes($mem->lname))?> 
          <?=LNG_JOIN_INV_TO_MEM?>. <? } ?> <br>
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_JOIN_MSG_C?> <a href="index.php?mode=privacy&lng=<?=$lng_id?>" target="_blank"><?=LNG_JOIN_PRIV?></a> 
          <?=LNG_JOIN_MSG_D?>. </font></p>
        </td>
    </tr>
<tr><td height="5"></td></tr>
<tr>
      <td valign="top" class="lined" height="809"> 
        <table align="center" cellpadding="2" cellspacing="5" width="98%">
          <tr> 
            <td width="216" class="body"><strong><?=LNG_FIRST_NAME?></strong></td>
            <td width="239"> <input type="text" name="fname"> </td>
            <td width="487" rowspan=2 class="orangebody"><?=LNG_JOIN_MSG_E?>.</td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_LAST_NAME?></strong></td>
            <td> <input type="text" name="lname"> </td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_JOIN_AKA?></strong></td>
            <td> <input type="text" name="profilenam"> </td>
            <td class="orangebody"><?=LNG_JOIN_MSG_F?>.</td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_EMAIL?></strong></td>
            <td> <input type="text" name="email"> </td>
            <td rowspan=2 class="orangebody" valign="top"><?=LNG_JOIN_MSG_G?></td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_JOIN_CONF_EMAIL?></strong></td>
            <td> <input type="text" name="email2"> </td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_PASSWORD?></strong></td>
            <td> <input type="password" name="password"> </td>
            <td class="orangebody"><?=LNG_JOIN_PASS_4?></td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_JOIN_CONF_PASS?></strong></td>
            <td> <input type="password" name="password2"> </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_STATE?></strong></td>
            <td> <input type="text" name="state"> </td>
            <td rowspan="3" class="orangebody" valign="top"><?=LNG_JOIN_MSG_H?>.<br>
              <?=LNG_JOIN_MSG_I?>. <br> <input type=checkbox name="showloc" value="0">
              <?=LNG_DONOT_SHOW_LOCATION?></td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_ZIP_POSTAL_CODE?></strong></td>
            <td> <input type="text" name="zip"> </td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_COUNTRY?></strong></td>
            <td>
            	<select name="country">
                	<? country_drop('1'); ?>
              	</select> </td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_GENDER?></strong></td>
            <td class="body"> <input type="radio" name="gender" value="m">
              <?=LNG_MALE?><br> <input type="radio" name="gender" value="f">
              <?=LNG_FEMALE?><br> <input type="radio" name="gender" value="n">
              <?=LNG_NOT_TO_SAY?></td>
            <td rowspan="2" class="orangebody" valign="top"><?=LNG_JOIN_HIDE_INFO?>.<br> <input type=checkbox name="showgender" value="0">
              <?=LNG_DONOT_SHOW_GENDER?><br> <input type=checkbox name="showage" value="0">
              <?=LNG_DONOT_SHOW_AGE?></td>
          </tr>
          <tr> 
            <td class="body"><strong><?=LNG_JOIN_BIRTH_DAY?></strong></td>
            <td class="body"> <select name=month>
                <option selected value="0"><?=LNG_MONTH?></option>
                <? month_drop(0); ?>
              </select> <select name=day>
                <option selected value="0"><?=LNG_DAY?></option>
                <? day_drop(0); ?>
              </select> <select name=year>
                <option selected value="0"><?=LNG_YEAR?></option>
                <? year_drop('0'); ?>
              </select> </td>
          </tr>
          <tr> 
            <td valign="middle" class="body"><strong><?=LNG_MEMBERSHIP?></strong></td>
            <td valign="top" class="body"> 
              <?
$ssco=1;
if(mysql_num_rows($res_accc))	{
	while($row_accc=mysql_fetch_object($res_accc))	{
		if($ssco==1)	
			echo "<input type='radio' name='pack' value='$row_accc->package_id' checked>&nbsp;".$row_accc->package_nam."&nbsp;";
		else	
			echo "<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;";
		if($row_accc->package_amt!='0.00')	
			echo "&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
		echo "<br>";
		$ssco++;
		$dis="";
	}
}
?>
            </td>
            <td class="orangebody" valign="top"><?=LNG_JOIN_MEM_PACKAGE?></td>
          </tr>
          <tr> 
            <td valign="top" class="body"><strong><?=LNG_JOIN_MSG_TALENT?> ? 
              </strong></td>
            <td class="body"> <table>
                <tr> 
                  <td width="103" valign="top" class="body"> <input name="aua_fan" type="checkbox" value="y">
                    <?=LNG_FAN?><br> <input name="aua_mc" type="checkbox" value="y">
                    <?=LNG_MC?><br> <input name="aua_vocalist" type="checkbox" value="y">
                    <?=LNG_JOIN_SINGER?> <br> <input name="aua_producer" type="checkbox" value="y">
                    <?=LNG_MODEL?><br> <input name="aua_poet" type="checkbox" value="y">
                    <?=LNG_JOIN_SONGWRITER?> </td>
                  <td width="122" valign="top" class="body"> <input type="checkbox" name="aua_dancer" value="y">
                    <?=LNG_DANCER?><br> <input name="aua_dj" type="checkbox" value="y">
                    <?=LNG_ACTORS?><br> <input name="aua_musician" type="checkbox" value="y">
                    <?=LNG_LOGIN_ART_MUSI?><br> <input name="aua_artist" type="checkbox" value="y">
                    <?=LNG_JOIN_MAGIC?> <br> <input name="aua_other" type="checkbox" value="y">
                    <?=LNG_OTHER?></td>
                </tr>
              </table></td>
            <td valign="top" class="orangebody"><?=ucfirst(LNG_SELECT_ALL)?></td>
          </tr>
          <tr> 
            <td colspan="3" height="5"></td>
          </tr>
          <tr> 
            <td colspan="3" align="center" class="body"> <div align="left"> 
                <input type="checkbox" name="terms2" value="1">
                <?=LNG_JOIN_MSG_J?></div></td>
          </tr>
          <tr> 
            <td colspan="3" align="center" class="body"> <div align="left"> 
                <input type="checkbox" name="terms" value="1">
                <?=LNG_JOIN_MSG_K?> <a href='index.php?mode=terms&lng=<?=$lng_id?>' target="_blank"><?=LNG_JOIN_TERMS_OF_USE?></a> <?=LNG_JOIN_MSG_L?><br>
              </div></td>
          </tr>
          <tr> 
            <td colspan="3" align="center"> <div align="left"> <br>
                <input type="hidden" name="mode" value="join">
                <input type="hidden" name="act" value="reg">
                <input type=submit value="<?=LNG_JOIN_REGISTER?>" class="submit">
              </div></td>
          </tr>
          <tr> 
            <td colspan="3" height="2"></td>
          </tr>
        </table>
      </td></tr></table>
  </form>
<?
	show_footer();
}

function do_register()	{
	
	global $lng_id;
	
	$m_id=cookie_get("mem_id");
	if($m_id!='')	error_screen(25);
	global $main_url;
	//getting values from form
	$form_data=array ("password","password2","fname","lname","profilenam","gender","inv_id","day","month","year","email","email2","zip","country","terms","showloc","showgender","showage","pack","zones","aua_fan","aua_mc","aua_vocalist","aua_producer","aua_poet","aua_dancer","aua_dj","aua_musician","aua_artist","aua_other","likemost_mc","likemost_graffiti","likemost_dj","likemost_breaking","raplike_oldschool","raplike_raprock","raplike_bootie","raplike_mainstreamradio","raplike_experimental","raplike_underground","raplike_gangsta","raplike_club","raplike_breaking","raplike_other","interests","music","meet_people","whathiptou","shoutouts","about","books","movies","college","highschool","job","bandnam","genre1","genre2","genre3");
	while (list($key,$val)=each($form_data))	{
		${$val}=form_get("$val");
	}
	if(empty($aua_fan))	$aua_fan='n';
	if(empty($aua_mc))	$aua_mc='n';
	if(empty($aua_vocalist))	$aua_vocalist='n';
	if(empty($aua_producer))	$aua_producer='n';
	if(empty($aua_poet))	$aua_poet='n';
	if(empty($aua_dancer))	$aua_dancer='n';
	if(empty($aua_dj))	$aua_dj='n';
	if(empty($aua_musician))	$aua_musician='n';
	if(empty($aua_artist))	$aua_artist='n';
	if(empty($aua_other))	$aua_other='n';
	if(empty($likemost_mc))	$likemost_mc='n';
	if(empty($likemost_graffiti))	$likemost_graffiti='n';
	if(empty($likemost_dj))	$likemost_dj='n';
	if(empty($likemost_breaking))	$likemost_breaking='n';
	if(empty($raplike_oldschool))	$raplike_oldschool='n';
	if(empty($raplike_raprock))	$raplike_raprock='n';
	if(empty($raplike_bootie))	$raplike_bootie='n';
	if(empty($raplike_mainstreamradio))	$raplike_mainstreamradio='n';
	if(empty($raplike_experimental))	$raplike_experimental='n';
	if(empty($raplike_underground))	$raplike_underground='n';
	if(empty($raplike_gangsta))	$raplike_gangsta='n';
	if(empty($raplike_club))	$raplike_club='n';
	if(empty($raplike_breaking))	$raplike_breaking='n';
	if(empty($raplike_other))	$raplike_other='n';
	$sql="select * from member_package where package_id='$pack'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	$package_amt=$row->package_amt;
	$sql_query="select mem_id from members where email='$email' or profilenam='$profilenam'";
	$num2=sql_execute($sql_query,'num');
	//values check
	$password=trim($password);
	$email=strtolower(trim($email));
	$email=trim($email);
	$email=str_replace( " ", "", $email );
	$email=preg_replace( "#[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/]#", "", $email );
	$email2=strtolower(trim($email2));
	$email2=trim($email2);
	$email2=str_replace( " ", "", $email2 );
	$email2=preg_replace( "#[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/]#", "", $email2 );
	$passl=strlen($password);
	if(empty($pack))	error_screen(37);
	if(!isset($terms))	$terms="no";
	//checking if e-mail and confirm e-mail fields are equal
	if($email!=$email2)	error_screen(1);
	//checking if password and confirm password fields are equal
	if($password!=$password2)	error_screen(2);
	//if required values empty
	elseif(($password=='')||($email=='')||($terms=='no')||(empty($fname))||(empty($lname))||(empty($profilenam))||($gender=='')||($day==0)||($month==0)||($year==0)||($zip=='')||($country==''))	error_screen(3);
	//checking if this e-mail is already used
	elseif($num2!=0)	error_screen(4);
	//checking password length
	elseif(($passl<4)||($passl>12))	error_screen(7);
	else	{
		//crypting password
		$crypass=md5($password);
		//preparing sql query
		if($showloc=='')	$showloc=1;
		if($showgender=='')	$showgender=1;
		if($showage=='')	$showage=1;
		$birthday=maketime(0,0,0,$month,$day,$year);
		//adding data to db
		$crypass=md5($password);
		if($package_amt=='0.00')	{
			$mem_st="F";
			$p_stat="Y";
		}	else	{
			$mem_st="P";
			$p_stat="N";
		}
		$now=time();
		$sql_query="insert into members (email,password,fname,lname,profilenam,zip,country,showloc,showgender,showage,gender,birthday,joined,mem_stat,mem_acc,pay_stat,rapzone) values ('$email','$crypass','".addslashes($fname)."','".addslashes($lname)."','$profilenam','".addslashes($zip)."','$country','$showloc','$showgender','$showage','$gender','$birthday','$now','$mem_st','$pack','$p_stat','$zones')";
		sql_execute($sql_query,'');
		$max_id=mysql_insert_id();
		@mkdir("blog/".$profilenam,0777);
		@mkdir("members/".$profilenam,0777);
		chmod("blog/".$profilenam,0777);
		chmod("members/".$profilenam,0777);
		@copy("blog_url.php","blog/".$profilenam."/index.php");
		@copy("mem_url.php","members/".$profilenam."/index.php");
		//creating photo album
		$sql_query="insert into photo (mem_id) values ('$max_id')";
		sql_execute($sql_query,'');
		$sql_query="insert into musicprofile (mem_id,bandnam,genre1,genre2,genre3) values ('$max_id','".addslashes($bandnam)."','$genre1','$genre2','$genre3')";
		sql_execute($sql_query,'');
		$sql_query="insert into profiles(mem_id,aua_fan,aua_mc,aua_vocalist,aua_producer,aua_poet,aua_dancer,aua_dj,aua_musician,aua_artist,aua_other,likemost_mc,likemost_graffiti,likemost_dj,likemost_breaking,raplike_oldschool,raplike_raprock,raplike_bootie,raplike_mainstreamradio,raplike_experimental,raplike_underground,raplike_gangsta,raplike_club,raplike_breaking,raplike_other,interests,music,meet_people,whathiptou,shoutouts,about,books,movies,college,highschool,job,updated) values ('$max_id','$aua_fan','$aua_mc','$aua_vocalist','$aua_producer','$aua_poet','$aua_dancer','$aua_dj','$aua_musician','$aua_artist','$aua_other','$likemost_mc','$likemost_graffiti','$likemost_dj','$likemost_breaking','$raplike_oldschool','$raplike_raprock','$raplike_bootie','$raplike_mainstreamradio','$raplike_experimental','$raplike_underground','$raplike_gangsta','$raplike_club','$raplike_breaking','$raplike_other','".addslashes($interests)."','".addslashes($music)."','".addslashes($meet_people)."','".addslashes($whathiptou)."','".addslashes($shoutouts)."','".addslashes($about)."','".addslashes($books)."','".addslashes($movies)."','".addslashes($college)."','".addslashes($highschool)."','".addslashes($job)."','$now')";
		sql_execute($sql_query,'');
		//sending sign-up e-mail (validation notice)
		$val_key=$email.time();
		$val_key=md5($val_key);
		$sql_query="insert into validate (email,password,val_key) values ('$email','$password','$val_key')";
		sql_execute($sql_query,'');
		$data="<a href='$main_url/index.php?mode=join&act=val&val_key=$val_key&inv_id=$inv_id&lng=$lng_id'>".LNG_JOIN_VERYFY_EMAIL."</a>.";
		messages($email,'0',$data);
		//showing a congratulation page
		$sql_query="select * from stats";
		$res=sql_execute($sql_query,'res');
		if(mysql_num_rows($res))	$sql_query="update stats set day_sgns=day_sgns+1,week_sgns=week_sgns+1,month_sgns=month_sgns+1";
		else	$sql_query="insert into (day_sgns,week_sgns,month_sgns) values ('1','1','1')";
		sql_execute($sql_query,'');
		if($package_amt=='0.00')	complete_screen(0);
		else	{
			$link="index.php?mode=paypal&pack=$pack&mem_id=$max_id&lng=$lng_id";
			show_screen($link);
		}
	}
}

function validate()	{
	//getting validate key
	$val_key=form_get("val_key");
	$inv_id=form_get("inv_id");
	$sql_query="select * from validate where val_key='$val_key'";
	$num=sql_execute($sql_query,'num');
	//if val key is invalid showing error
	if($num==0)	error_screen(6);
	$val=sql_execute($sql_query,'get');
	$data[0]=$val->email;
	$data[1]=$val->password;
	//sending user login info
	messages($val->email,"2",$data);
	//updating db (account verified)
	$sql_query="delete from validate where val_key='$val_key'";
	sql_execute($sql_query,'');
	$sql_query="update members set verified='y' where email='$data[0]'";
	sql_execute($sql_query,'');
	$sql_query="insert into network (mem_id,frd_id) values ('$mem->mem_id',2),(2,'$mem->mem_id')";
	sql_execute($sql_query,'');
	if($inv_id!='')	{
		$sql_query="select * from invitations where inv_id='$inv_id'";
		$frd=sql_execute($sql_query,'get');
		$sql_query="select mem_id from members where email='$data[0]'";
		$mem=sql_execute($sql_query,'get');
		$sql_query="insert into network (mem_id,frd_id) values ('$mem->mem_id','$frd->mem_id'),('$frd->mem_id','$mem->mem_id')";
		sql_execute($sql_query,'');
		$sql_query="update invitations set stat='f' where inv_id='$inv_id'";
		sql_execute($sql_query,'');
	}
	$sql_query="select mem_id from invitations where email='$data[0]' and stat!='f'";
	$res=sql_execute($sql_query,'res');
	$num=mysql_num_rows($res);
	if($num!=0)	{
		while($inv=mysql_fetch_object($res))	{
			$now=time();
			$sql_query="select mem_id from members where email='$data[0]'";
			$mem=sql_execute($sql_query,'get');
			$subj=LNG_INV_TO_JN." ".name_header($inv->mem_id,"ad")."\'".LNG_PER_NETWK;
			$bod=LNG_BOTTON_USER." ".name_header($inv->mem_id,"ad")." ".LNG_ADDED_FRIND_NET;
			$sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date) values ('$mem->mem_id','$inv->mem_id','$subj','$bod','friend','inbox','$now')";
			sql_execute($sql_query,'');
		}//while
	}//if
	complete_screen(2);
}


/*
//showing country drop-down list
function country_drop($val)	
{
	if(empty($val))	
	{
		$val=LNG_US;
	}
	
	$country=array(LNG_AFGAN,LNG_ALBANIA,LNG_ALGERIA,LNG_AS,LNG_ANDORRA,LNG_ANGOLA,LNG_ANGUILIA,LNG_ANTERTICA,LNG_AB,LNG_ARGENTINA,LNG_ARMENIA,LNG_ARUBA,LNG_AI,LNG_AUSTRALIA,LNG_AUSTRIA,LNG_AZ,LNG_BAHAMAS,LNG_BAHRAIN,LNG_BANGLADESH,LNG_BARBADOS,LNG_BELARUS,LNG_BELGIUM,LNG_BELIZE,LNG_BENIN,LNG_BERMUDA,LNG_BHUTAN,LNG_BOLIVIA,LNG_BOTSWANA,LNG_BI,LNG_BRAZIL,LNG_BD,LNG_BULGARIA,LNG_B_FASO,LNG_BURUNDI,LNG_CAMBODIA,LNG_CAMEROON,LNG_CANADA,LNG_CVI,LNG_CI,LNG_CHAD,LNG_CHILE,LNG_CHINA,LNG_C_ILAND,LNG_COLOMBIA,LNG_COMOROS,LNG_CRO,LNG_COOK_I,LNG_COSTA_RICA,LNG_COTE_D_IVOIRE,LNG_CROATIA,LNG_CYPRUS,LNG_CZECH,LNG_DENMARK,LNG_DJBOUTI,LNG_DOMINICA,LNG_DOMINICAN,LNG_EAST_TIMOR,LNG_ECUADOR,LNG_EGYPT,LNG_EL_SALVA,LNG_EQ_GUINEA,LNG_ERITREA,LNG_ESTONIA,LNG_ETHIOP,LNG_FALKAN_IS,LNG_FAROE,LNG_FIJI,LNG_FINLAND,LNG_FRANCE,LNG_FRENCHG,LNG_FRENCHP,LNG_GABON,LNG_GAMBIA,LNG_GEORGIA,LNG_GERMANY,LNG_GHANA,LNG_GIBRA,LNG_GREECE,LNG_GREENLND,LNG_GRENADA,LNG_GUADE,LNG_GUAM,LNG_GAUTE,LNG_GUERNSEY,LNG_GUINEA,LNG_GUINEAB,LNG_GUYANA,LNG_HAITI,LNG_HONDU,LNG_HK,LNG_HUNGARY,LNG_ICELAND,LNG_INDIA,LNG_INDONES,LNG_IRAN,LNG_IRELAND,LNG_ISLEMAN,LNG_ISRAEL,LNG_ITALY,LNG_JAMAICA,LNG_JAPAN,LNG_JERSEY,LNG_JORDAN,LNG_KAZAK,LNG_KENYA,LNG_KIRIBA,LNG_KORIA_REP,LNG_KUWAIT,LNG_KYRGY,LNG_LAOS,LNG_LAT,LNG_LEBANON,LNG_LESOTHO,LNG_LIBERIA,LNG_LIBYA,LNG_LIECHT,LNG_LIHU,LNG_LUXEM,LNG_MACAU,LNG_MACEDONIA,LNG_MADAGASCAR,LNG_MALAWI,LNG_MALAY,LNG_MALDIVES,LNG_MALI,LNG_MALTA,LNG_MARSHAL_IS,LNG_MARTINI,LNG_MAURITANIA,LNG_MAURI,LNG_MAYOTTE_IS,LNG_MEXICO,LNG_MICRONESIA,LNG_MOLDOVA,LNG_MONACO,LNG_MONGOL,LNG_MONTS,LNG_MOROCO,LNG_MOZAMBQ,LNG_MYANMAR,LNG_NAMBIA,LNG_NAURU,LNG_NEPAL,LNG_NETH,LNG_NETH_ANTI,LNG_NEWCALE,LNG_NEWZEA,LNG_NICAR,LNG_NIGER,LNG_NIGERIA,LNG_NIUE,LNG_NORFOLK_IS,LNG_NORWAY,LNG_OMAN,LNG_PAKI,LNG_PALAU,LNG_PANAMA,LNG_PAPUA,LNG_PARAGUAY,LNG_PERU,LNG_PHILIPS,LNG_PITC_IS,LNG_POLAND,LNG_PORTUGAL,LNG_PUERTO_RICO,LNG_QATAR,LNG_REUNION_IS,LNG_ROMANIA,LNG_RUSS_FED,LNG_RAWANDA,LNG_SAINTHELENA,LNG_SAINTLUCIA,LNG_SANMARINO,LNG_SARAB,LNG_SENGAL,LNG_SEYCHELL,LNG_SIERA_LE,LNG_SPORE,LNG_SLOV_REP,LNG_SOLVE,LNG_SOLO_IL,LNG_SOMALIA,LNG_SAFRICA,LNG_SGEORGIA,LNG_SPAIN,LNG_LANKA,LNG_SURINAM,LNG_SVALB,LNG_SWAZI,LNG_SWEDEN,LNG_SWITZ,LNG_SYRIA,LNG_TAIWAN,LNG_TAJIK,LNG_TANZ,LNG_THAI,LNG_TOGO,LNG_TOKELAU,LNG_TONGAI,LNG_TUNISI,LNG_TURKEY,LNG_TURKMS,LNG_TUVALU,LNG_UGND,LNG_UKRN,LNG_UK,LNG_USA,LNG_URUGUA,LNG_UZBEK,LNG_VANUA,LNG_VATI,LNG_VENEZ,LNG_VIET,LNG_WSHARA,LNG_WSAMO,LNG_YEMEN,LNG_YUGO,LNG_ZAMB,LNG_ZIMB);
	
	//$country = array('india','china');
	
	//for($i=0; $i<=count($country)-1; $i++)	
	foreach ($country as $var)
	{
?>		
		<option value="<?=$var?>" <?=getSelected($var,$val)?> > <?=$var?> </option>
<?
	}
}
*/
?>
