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
if(($act=='')||($act=='inbox')){
  inbox();
}
elseif($act=='sent'){
  sent();
}
elseif($act=='saved'){
  saved();
}
elseif($act=='view_mes'){
  view_message();
}
elseif($act=='view_inv'){
  view_invitation();
}
elseif($act=='view_tst'){
  view_testimonial();
}
elseif($act=='inv_action'){
  inv_action();
}
elseif($act=='tst_action'){
  tst_action();
}
elseif($act=='trb_inv_action'){
  trb_inv_action();
}
elseif($act=='trb_req_action'){
  trb_req_action();
}
elseif($act=='mes_list'){
  mes_list_action();
}
elseif($act=='mes'){
  mes_action();
}
elseif($act=='compose'){
  compose();
}
elseif($act=='lst'){
  listing_action();
}
elseif($act=='view_trb_inv'){
  view_trb_invitation();
}
elseif($act=='view_trb_req'){
  view_trb_request();
}

//showing inbox list
function inbox(){
$m_id=cookie_get("mem_id");

global $lng_id;

$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$page=form_get("page");
if($page==''){
  $page=0;
}
$start=$page*15;

		$sql_query="select * from messages_system where mem_id='$m_id' and folder='inbox' and type='message' order by date desc";
        $num=sql_execute($sql_query,'num');
        $res=sql_execute($sql_query,'res');

        show_header();
        ?>
        <table class='body' class="body" width=100%>
           <tr>
  <td class="lined title">
    <table class='body' width=100%>
      <tr> 
        <td class="lined title"><b><?=LNG_PROFILE_MSG_CNTR?>: <?=LNG_MSG_INBOX?> - <a href="http://www.Site Name.com/index.php?mode=login&amp;act=home&lng=<?=$lng_id?>"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?=LNG_RETURN_HOME_PAGE?></font></a></b></td>
    </table>
    
  </td>
<tr>
  <td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr>
        <td class="lined-top lined-left lined-right" width=150 height="23"><a href='index.php?mode=messages&act=inbox&lng=<?=$lng_id?>'><b><font color="#3366FF"><?=LNG_MSG_INBOX?></font></b></a></td>
           
        <td class="lined" width=150 height="23"><a href='index.php?mode=messages&act=sent&lng=<?=$lng_id?>'><b><?=LNG_MSG_SENT?></b></a></td>
           
        <td class="lined" width=150 height="23"><a href='index.php?mode=messages&act=saved&lng=<?=$lng_id?>'><b><?=LNG_MSG_SAVED?></b></a></td>
           </table></td>

           <tr><td class=lined>
           
    <table class='body' width=80%>
      <? if($num!=0){ ?>
      <tr> 
        <td height="15"><b><br>
          <?=LNG_MUSIC_SELECT?></b></td>
        <td height="15"><b><br>
          <?=LNG_MSG_NEW?></b></td>
        <td height="15"><b><br>
          <?=LNG_FROM?></b></td>
        <td  height="15"><b><br>
          <?=LNG_SUBJECT?></b></td>
        <td height="15"><b><br>
          <?=LNG_MSG_SENT?></b></td>
        <td height="15"><form action='index.php' method='post'>
            <input type='hidden' name='mode' value='messages'>
            <input type='hidden' name='act' value='mes_list'>
            <input type='hidden' name='refer' value='inbox'>
            <input type='hidden' name='pro' value=''>
            <?
                          while($mes=mysql_fetch_object($res)){

                              $sent=date("m/d/y h:i A",$mes->date);


                              if($mes->new=='new'){
                              echo "<tr style='font-weight:bolder'>";
                              }
                              else{
                              echo "<tr>";
                              }

                              echo"<td><input type='checkbox' name='mes_id[]' value='$mes->mes_id'></td>";
                              //if message is new
                              if($mes->new=='new'){
                              echo "<td><img src='images/icon_updated.gif'></td>";
                              }//if
                              else{
                              echo "<td>&nbsp</td>";
                              }//else

                              echo "<td><a href='index.php?mode=people_card&p_id=$mes->frm_id'>&lng=$lng_id";
                              echo name_header($mes->frm_id,$m_id);echo"</a></td>";
                              echo "<td><a href='index.php?mode=messages&act=view_mes&mes_id=$mes->mes_id&lng=$lng_id'>$mes->subject</a><td>$sent</td>";

                          }//while

                ?>
            <tr> 
              <td colspan=5 align=right height="138"> <div align="left"> <br>
                  <br>
                  <br>
                  <input type='submit' value='<?=LNG_DELETE?>' onClick='this.form.pro.value="del"'>
                  <input type='submit' value='<?=LNG_MSG_SAVE?>' onClick='this.form.pro.value="sav"'>
                  &nbsp&nbsp&nbsp&nbsp 
                  <input type='button' value='<?=LNG_MSG_CMP_MSG?>' onClick='window.location="index.php?mode=messages&act=compose&lng=<?=$lng_id?>"'>
                  &nbsp <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                </div></td>
              <td height="138">
          </form>
          <? }
           else {
             echo "<tr><td align=center>".LNG_MSG_NO_MSG."</td>";
             echo "<tr><td align=right><input type='button' value='".LNG_MSG_CMP_MSG."' onClick='window.location=\"index.php?mode=messages&act=compose&lng=$lng_id\"'>&nbsp</td>";
           }?>
    </table>
           </td>

        </table>
        <?
        show_footer();

}//function

//sent folder list
function sent(){
$m_id=cookie_get("mem_id");
global $lng_id;
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$page=form_get("page");
if($page==''){
  $page=0;
}
$start=$page*15;

		$sql_query="select * from messages_system where mem_id='$m_id' and folder='sent' and type='message' order by date desc";
        $res=sql_execute($sql_query,'res');
        $num=sql_execute($sql_query,'num');
        show_header();
        ?>
        <table class='body' width=100%>
           <tr>
      <td class="lined title"><b><?=LNG_PROFILE_MSG_CNTR?>: <?=LNG_MSG_SENT?></b></td>
           <tr><td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr><td class="lined" width=150><a href='index.php?mode=messages&act=inbox&lng=<?=$lng_id?>'><b><?=LNG_MSG_INBOX?></b></a></td>
            <td class="lined-top lined-left lined-right" width=150><a href='index.php?mode=messages&act=sent&lng=<?=$lng_id?>'><b><font color="#3366FF"><?=LNG_MSG_SENT?></font></b></a></td>
           <td class="lined" width=150><a href='index.php?mode=messages&act=saved&lng=<?=$lng_id?>'><b><?=LNG_MSG_SAVED?></b></a></td>
           </table></td>

           <tr>
      <td class=lined height="189"> 
        <table class='body' width=100%>
          <? if($num!=0) { ?>
          <tr> 
            <td height="23"> <p><b><?=LNG_MUSIC_SELECT?></b></p></td>
            <td height="23"> <p><b><?=LNG_MSG_NEW?></b></p></td>
            <td height="23"><b><?=LNG_TO?></b></td>
            <td height="23"><b><?=LNG_SUBJECT?></b></td>
            <td height="23"><b><?=LNG_MSG_SENT?></b></td>
            <td height="23"><form action='index.php' method='post'>
                <input type='hidden' name='mode' value='messages'>
                <input type='hidden' name='act' value='mes_list'>
                <input type='hidden' name='refer' value='sent'>
                <input type='hidden' name='pro' value=''>
                <?
                          while($mes=mysql_fetch_object($res)){

                              $sent=date("m/d/y h:i A",$mes->date);


                              echo "<tr>";

                              echo"<td><input type='checkbox' name='mes_id[]' value='$mes->mes_id'></td>";
                              echo "<td>&nbsp</td>";
                              echo "<td><a href='index.php?mode=people_card&p_id=$mes->frm_id&lng=$lng_id'>";
                              echo name_header($mes->frm_id,$m_id);echo"</a></td>";
                              echo "<td><a href='index.php?mode=messages&act=view_mes&mes_id=$mes->mes_id&lng=$lng_id'>$mes->subject</a></td><td>$sent</td>";

                          }//while

                ?>
                <tr> 
                  <td colspan=5 align=right height="177"> <div align="left"> <br>
                      <br>
                      <br>
                      <input type='submit' value='<?=LNG_DELETE?>' onClick='this.form.pro.value="del"'>
                      <input type='submit' value='<?=LNG_MSG_SAVE?>' onClick='this.form.pro.value="sav"'>
                      &nbsp&nbsp&nbsp&nbsp 
                      <input type='button' value='<?=LNG_MSG_CMP_MSG?>' onClick='window.location="index.php?mode=messages&act=compose&lng=<?=$lng_id?>"'>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <br>
                    </div></td>
                  <td height="177">
              </form>
              <? }
           else {
             echo "<tr><td align=center>".LNG_MSG_NO_MSG."</td>";
             echo "<tr><td align=right><input type='button' value='".LNG_MSG_CMP_MSG."' onClick='window.location=\"index.php?mode=messages&act=compose&lng=$lng_id\"'>&nbsp</td>";
           }?>
        </table>
           </td>

        </table>
        <?
        show_footer();
}//function

//saved folder content
function saved(){
$m_id=cookie_get("mem_id");
global $lng_id;
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$page=form_get("page");
if($page==''){
  $page=0;
}
$start=$page*15;

		$sql_query="select * from messages_system where mem_id='$m_id' and folder='saved' and type='message' order by date desc";
        $res=sql_execute($sql_query,'res');
        $num=sql_execute($sql_query,'num');
        show_header();
        ?>
        <table class='body' width=100%>
           <tr>
      <td class="lined title"><b><?=LNG_PROFILE_MSG_CNTR?>: <?=LNG_MSG_SAVED?></b></td>
           <tr><td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr><td class="lined" width=150><a href='index.php?mode=messages&act=inbox&lng=<?=$lng_id?>'><b><?=LNG_MSG_INBOX?></b></a></td>
           <td class="lined" width=150><a href='index.php?mode=messages&act=sent&lng=<?=$lng_id?>'><b><?=LNG_MSG_SENT?></b></a></td>
            <td class="lined-top lined-left lined-right" width=150><a href='index.php?mode=messages&act=saved&lng=<?=$lng_id?>'><b><font color="#3366FF"><?=LNG_MSG_SAVED?></font></b></a></td>
           </table></td>

           <tr><td class=lined>
           
        <table class='body' width=100%>
          <? if($num!=0) { ?>
          <tr> 
            <td><b><?=LNG_MUSIC_SELECT?></b></td>
            <td><b><?=LNG_MSG_NEW?></b></td>
            <td><b><?=LNG_TO?></b></td>
            <td><b><?=LNG_SUBJECT?></b></td>
            <td><b><?=LNG_MSG_SENT?></b></td>
            <form action='index.php' method='post'>
              <input type='hidden' name='mode' value='messages'>
              <input type='hidden' name='act' value='mes_list'>
              <input type='hidden' name='refer' value='sent'>
              <input type='hidden' name='pro' value=''>
              <?
                          while($mes=mysql_fetch_object($res)){

                              $sent=date("m/d/y h:i A",$mes->date);


                              if($mes->new=='new'){
                              echo "<tr style='font-weight:bolder'>";
                              }
                              else{
                              echo "<tr>";
                              }

                              echo"<td><input type='checkbox' name='mes_id[]' value='$mes->mes_id'></td>";
                              if($mes->new=='new'){
                              echo "<td><img src='images/icon_updated.gif'></td>";
                              }//if
                              else{
                              echo "<td>&nbsp</td>";
                              }//else

                              echo "<td><a href='index.php?mode=people_card&p_id=$mes->frm_id&lng=$lng_id'>";
                              echo name_header($mes->frm_id,$m_id);echo"</a></td>";
                              echo "<td><a href='index.php?mode=messages&act=view_mes&mes_id=$mes->mes_id&lng=$lng_id'>$mes->subject</a></td><td>$sent</td>";

                          }//while

                ?>
              <tr> 
                <td colspan=5 align=right> <div align="left"> 
                    <p><br>
                      <br>
                      <br>
                      <input type='submit' value='<?=LNG_DELETE?>' onClick='this.form.pro.value="del"'>
                      <input type='submit' value='<?=LNG_MSG_SAVE?>' onClick='this.form.pro.value="sav"'>
                      &nbsp&nbsp&nbsp&nbsp 
                      <input type='button' value='<?=LNG_MSG_CMP_MSG?>' onClick='window.location="index.php?mode=messages&act=compose&lng=<?=$lng_id?>"'>
                    </p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                  </div></td>
            </form>
            <? }
           else {
             echo "<tr><td align=center>".LNG_MSG_NO_MSG."</td>";
             echo "<tr><td align=right><input type='button' value='".LNG_MSG_CMP_MSG."' onClick='window.location=\"index.php?mode=messages&act=compose&lng=$lng_id\"'>&nbsp</td>";
           }
           ?>
        </table>
           </td>

        </table>
        <?
        show_footer();
}//function

//showing a message
function view_message(){
$m_id=cookie_get("mem_id");
global $lng_id;
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$mes_id=form_get("mes_id");
    $sql_query="select * from messages_system where mes_id='$mes_id'";
    $mes=sql_execute($sql_query,'get');
    $date=date("m/d/y h:i A",$mes->date);
    show_header();
    ?>
    <table class='body' width=100%>
           <tr>
      <td class="lined title"><b><?=LNG_PROFILE_MSG_CNTR?>: <?=LNG_MSG_VIEW_MSG?></b></td>
           <tr><td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr><td class="lined" width=150><a href='index.php?mode=messages&act=inbox&lng=<?=$lng_id?>'><b><?=LNG_MSG_INBOX?></b></a></td>
           <td class="lined" width=150><a href='index.php?mode=messages&act=sent&lng=<?=$lng_id?>'><b><?=LNG_MSG_SENT?></b></a></td>
           <td class="lined" width=150><a href='index.php?mode=messages&act=saved&lng=<?=$lng_id?>'><b><?=LNG_MSG_SAVED?></b></a></td>
           </table></td>
           <tr><td class="lined padded-6">
        <table class='body' width=100%>
            <tr><td align=right class="title"><?=LNG_FROM?></td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($mes->frm_id); ?></br>
               <? show_online($mes->frm_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$mes->frm_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($mes->frm_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($mes->frm_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php">
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="mes">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="mes_id" value="<? echo $mes_id; ?>">
            <tr><td align=right class="title"><?=LNG_DATE?></td>
            <td>
            <? echo $date; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_SUBJECT?></td>
            <td>
            <? echo $mes->subject; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_MSG_MESGG?></td>
            <td>
            <?
            $body=ereg_replace("\n","</br>",$mes->body);
             echo $body; ?></td>
            <tr>
            <td align=right colspan=2> 
              <div align="left"> <br>
                <br>
                <input type="submit" onClick="this.form.pro.value='del'" value="<?=LNG_DELETE?>">
                <input type="submit" onClick="this.form.pro.value='sav'" value="<?=LNG_MSG_SAVE?>">
                &nbsp&nbsp&nbsp&nbsp
                <input type="submit" onClick="this.form.pro.value='forw'" value="<?=LNG_LISTING_FORD?>">
                <input type="submit" onClick="this.form.pro.value='reply'" value="<?=LNG_REPLY?>">
              </div>
            </td></form>
        </table>
      </td>
  </table>
  <?
  //if user views this message it is no longer new
  $sql_query="update messages_system set new='' where mes_id='$mes_id'";
  sql_execute($sql_query,'');
  show_footer();

}//function

//shows friendship invitation
function view_invitation(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$inv_id=form_get("inv_id");
    $sql_query="select * from messages_system where mes_id='$inv_id'";
    $mes=sql_execute($sql_query,'get');
    $date=date("m/d/Y",$mes->date);
    show_header();
    ?>
    <table class='body' width=100%>
           <tr>
      <td class="lined padded-6 title"><b><?=LNG_MSG_VIEW_INFO?></b></td>
           <tr><td class="lined padded-6">
        <table class='body' width=100%>
            <tr><td align=right class="title"><?=LNG_FROM?></td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td vasilek rowspan=2 class='lined-right padded-6'><? show_photo($mes->frm_id); ?></br>
               <? show_online($mes->frm_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$mes->frm_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($mes->frm_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($mes->frm_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php">
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="inv_action">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="inv_id" value="<? echo $inv_id; ?>">
            <tr><td align=right class="title"><?=LNG_DATE?></td>
            <td>
            <? echo $date; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_SUBJECT?></td>
            <td>
            <? echo $mes->subject; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_MESSAGE?></td>
            <td>
            <? echo $mes->body; ?></td>
            <tr><td align=right class="title"><?=LNG_MSG_UR_ANS?></td>
            <td><textarea name='answer' rows=5 cols=45></textarea></td>
            <tr>
            <td align=right colspan=2> 
              <p align=left> <br>
                <br>
                <input type="submit" onClick="this.form.pro.value='del'" value="<?=LNG_MSG_DENY?>">
                <input type="submit" onClick="this.form.pro.value='conf'" value="<?=LNG_MSG_ACCEPT?>">
              </p>
              </form>
            </td>
        </table>
      </td>
  </table>
  <?
  show_footer();

}//function

//showing tribe invitation
function view_trb_invitation(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$trb_inv_id=form_get("trb_inv_id");
    $sql_query="select * from messages_system where mes_id='$trb_inv_id'";
    $mes=sql_execute($sql_query,'get');
    $date=date("m/d/Y",$mes->date);
    show_header();
    ?>
    <table class='body' width=100%>
           <tr>
      <td class="lined padded-6"><b><?=LNG_MSG_VIEW_INFO?></b></td>
           <tr><td class="lined padded-6">
        <table class='body' width=100%>
            <tr><td align=right class="title"><?=LNG_FROM?></td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($mes->frm_id); ?></br>
               <? show_online($mes->frm_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$mes->frm_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($mes->frm_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($mes->frm_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php">
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="trb_inv_action">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="trb_inv_id" value="<? echo $trb_inv_id; ?>">
            <tr><td align=right class="title"><?=LNG_DATE?></td>
            <td>
            <? echo $date; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_SUBJECT?></td>
            <td>
            <? echo $mes->subject; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_MESSAGE?></td>
            <td>
            <? echo $mes->body; ?></td>
            <tr>
            <td align=right colspan=2> 
              <p align=left> <br>
                <br>
                <input type="submit" onClick="this.form.pro.value='del'" value="<?=LNG_MSG_DENY?>">
                <input type="submit" onClick="this.form.pro.value='conf'" value="<?=LNG_MSG_ACCEPT?>">
              </p>
              </form>
            </td>
        </table>
      </td>
  </table>
  <?
  show_footer();

}//function

//showing tribe join request
function view_trb_request(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$trb_req_id=form_get("trb_req_id");
    $sql_query="select * from messages_system where mes_id='$trb_req_id'";
    $mes=sql_execute($sql_query,'get');
    $date=date("m/d/Y",$mes->date);
    show_header();
    ?>
    <table class='body' width=100%>
           <tr>
      <td class="lined padded-6"><b><?=LNG_MSG_V_REQUEST?></b></td>
           <tr><td class="lined padded-6">
        <table class='body' width=100%>
            <tr><td align=right class="title"><?=LNG_FROM?></td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($mes->frm_id); ?></br>
               <? show_online($mes->frm_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$mes->frm_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($mes->frm_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($mes->frm_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php">
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="trb_req_action">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="trb_req_id" value="<? echo $trb_req_id; ?>">
            <tr><td align=right class="title"><?=LNG_DATE?></td>
            <td>
            <? echo $date; ?>
            </td>

            <tr>
            <td align=right colspan=2> 
              <p align=left> <br>
                <br>
                <input type="submit" onClick="this.form.pro.value='del'" value="<?=LNG_MSG_DENY?>">
                <input type="submit" onClick="this.form.pro.value='conf'" value="<?=LNG_MSG_ACCEPT?>">
              </p>
              </form>
            </td>
        </table>
      </td>
  </table>
  <?
  show_footer();

}//function

//showing testimonial
function view_testimonial(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$tst_id=form_get("tst_id");
    $sql_query="select * from testimonials where tst_id='$tst_id'";
    $tst=sql_execute($sql_query,'get');
    $date=date("m/d/Y",$tst->added);
    show_header();
    ?>
    <table class='body' width=100%>
           <tr>
      <td class="lined padded-6"><b><?=LNG_MSG_VIEW_TEST?> </b></td>
           <tr><td class="lined padded-6">
        <table class='body' width=100%>
            <tr><td align=right class="title"><?=LNG_FROM?></td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 vasilek class='lined-right padded-6'><? show_photo($tst->from_id); ?></br>
               <? show_online($tst->from_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$tst->from_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($tst->from_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($tst->from_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="index.php">
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="tst_action">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="tst_id" value="<? echo $tst_id; ?>">
            <tr><td align=right class="title"><?=LNG_DATE?></td>
            <td>
            <? echo $date; ?>
            </td>
            <tr><td align=right class="title"><?=LNG_TESTIMONIALS?></td>
            <td>
            <? echo $tst->testimonial; ?></td>
            <tr>
            <td align=right colspan=2> 
              <p align=left> <br>
                <br>
                <input type="submit" onClick="this.form.pro.value='del'" value="<?=LNG_DELETE?>">
                <input type="submit" onClick="this.form.pro.value='conf'" value="<?=LNG_MSG_APPROVE?>">
              </p>
              </form>
            </td>
        </table>
      </td>
  </table>
<?
show_footer();
}//function

//what to do with friendship invitation
function inv_action(){
global $main_url, $lng_id;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$inv_id=form_get("inv_id");
    $sql_query="select frm_id,subject from messages_system where mes_id='$inv_id'";
    $frm=sql_execute($sql_query,'get');

    $pro=form_get("pro");

    $answer=form_get("answer");
    $subject="Invitation Answer";
    $now=time();


    //confirm
    if($pro=='conf'){

       //updating db, making users friends
       $sql_query="insert into network (mem_id,frd_id)
       values ($m_id,$frm->frm_id),($frm->frm_id,$m_id)";
       sql_execute($sql_query,'');
       $sql_query="delete from messages_system where mes_id='$inv_id'";
       sql_execute($sql_query,'');
       $sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date)
       values ('$frm->frm_id','$m_id','$subject','$answer','message','new','inbox','$now')";
       sql_execute($sql_query,'');

    }//elseif

    //deny
    elseif($pro=='del'){

       //deleting invitaion from db
       $sql_query="delete from messages_system where mes_id='$inv_id'";
       sql_execute($sql_query,'');
       $sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date)
       values ('$frm->frm_id','$m_id','$subject','$answer','message','new','inbox','$now')";
       sql_execute($sql_query,'');

    }//elseif

    //redirect
    $location=$main_url."/index.php?mode=login&act=home&lng=$lng_id";
    show_screen($location);

}//function

//what to do with testimonial
function tst_action(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$tst_id=form_get("tst_id");
    $sql_query="select from_id from testimonials where tst_id='$tst_id'";
    $from=sql_execute($sql_query,'get');

    $pro=form_get("pro");

    //confirm
    if($pro=='conf'){

       //testimonial activated
       $sql_query="update testimonials set stat='a' where tst_id='$tst_id'";
       sql_execute($sql_query,'');

    }//if

    //deny
    elseif($pro=='del'){

       //testimonial deleted
       $sql_query="delete from testimonials where tst_id='$tst_id'";
       sql_execute($sql_query,'');

    }//elseif

    //redirect
    global $main_url,$lng_id;
    $location=$main_url."/index.php?mode=login&act=home&lng=$lng_id";
    show_screen($location);

}//function

//actions with messages list
function mes_list_action(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$refer=form_get("refer");

	$mes_id=form_get("mes_id");

    $pro=form_get("pro");

    //save
    if($pro=='sav'){

         if($mes_id!=''){
         foreach($mes_id as $ms){

         //moving messages to saved folder
         $sql_query="update messages_system set folder='saved' where mes_id='$ms'";
         sql_execute($sql_query,'');

         }//foreach
         }//if

    }//if

    //deleting messages
    elseif($pro=='del'){

         if($mes_id!=''){
         foreach($mes_id as $ms){

         $sql_query="delete from messages_system where mes_id='$ms'";
         sql_execute($sql_query,'');

         }//foreach
         }//if

    }//elseif

    //the function with name of refer value will work now (for ex. $refer='inbox', so inbox will be shown)
    $refer();

}//function

//what to do with messages
function mes_action(){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

      $mes_id=form_get("mes_id");
      $pro=form_get("pro");

      //delete
      if($pro=='del'){
         $sql_query="delete from messages_system where mes_id='$mes_id'";
         sql_execute($sql_query,'');

         inbox();

      }//if

      //save
      elseif($pro=='sav'){

         $sql_query="update messages_system set folder='saved' where mes_id='$mes_id'";
         sql_execute($sql_query,'');

         view_message();

      }//elseif

      //forward
      elseif($pro=='forw'){

         select_recipient($mes_id,'forw');

      }//elseif

      //reply
      elseif($pro=='reply'){
         global $main_url,$lng_id;

         $sql_query="select frm_id from messages_system where mes_id='$mes_id'";
         $rec=sql_execute($sql_query,'get');
         $rec_id=$rec->frm_id;

         $link=$main_url."/index.php?mode=messages&act=compose&mes_id=$mes_id&rec_id=$rec_id&pro=$pro&lng=$lng_id";
         show_screen($link);

      }//elseif

}//functions

//select recipient of forward or new message from friends list
function select_recipient($mes_id,$type){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$friends=count_network($m_id,"1","ar");
show_header();
?>
<table class='body' width=100%>
<tr>
      <td class="lined title"><b><?=LNG_MSG_SEL_RECP?> </b></td>
<tr><td class="lined">
<form action='index.php' method='post'>
<input type='hidden' name='mode' value='messages'>
<input type='hidden' name='act' value='compose'>

	<?
      	if($type=='forw'){

            echo "<input type='hidden' name='pro' value='forw'>";
            echo "<input type='hidden' name='mes_id' value='$mes_id'>";
            if($friends!=''){
            foreach($friends as $friend){

                echo " <table class='body' class='lined'>
                <tr><td vasilek>";show_photo($friend);echo "</br>
                <input type=radio name='rec_id' value='$friend'>";show_online($friend);
                echo "</td></table>";

            }//foreach
            }//if
            else {
               echo "<p align=center>".LNG_NO_FRIENDS."</p>";
            }//else

        }//if

        elseif($type=='reply'){

            echo "<input type='hidden' name='pro' value='reply'>";
            echo "<input type='hidden' name='mes_id' value='$mes_id'>";
            if($friends!=''){
            foreach($friends as $friend){

                echo " <table class='body' class='lined'>
                <tr><td vasilek>";show_photo($friend);echo "</br>
                <input type=radio name='rec_id' value='$friend'>";show_online($friend);
                echo "</td></table>";

            }//foreach
            }//if
            else {
               echo "<p align=center>".LNG_NO_FRIENDS."</p>";
            }//else

        }//elseif

        elseif($type==''){

            if($friends!=''){
            foreach($friends as $friend){

                echo " <table class='body' class='lined'>
                <tr><td vasilek>";show_photo($friend);echo "</br>
                <input type=radio name='rec_id' value='$friend'>";show_online($friend);
                echo "</td></table>";

            }//foreach
            }//if
            else {
               echo "<p align=center>".LNG_NO_FRIENDS."</p>";
            }//else

        }//elseif
    ?>

</td>
<tr>
      <td class=lined align=right> 
        <div align="left"> <br>
          <br>
          <input type='submit' value='<?=LNG_MUSIC_SELECT?>'>
        </div>
        </form></td>
</table>
<?
show_footer();
}//function

//composing new message
function compose(){
global $main_url,$lng_id;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

   $pro=form_get("pro");
   $mes_id=form_get("mes_id");
   $rec_id=form_get("rec_id");
   $err=form_get("err");
   //if recipient is not chosen
   if($rec_id==''){
     select_recipient('','');
   }
   else {
   $intro=form_get("intro");

   $lst_id=form_get('lst_id');

   $done=form_get("done");

   if($done==''){

   		if($mes_id!=''){
   		//if forward or reply need to know what message is forwarded or replied
   		if(($pro=='forw')||($pro='reply')){

   		$sql_query="select * from messages_system where mes_id='$mes_id'";
        $mes=sql_execute($sql_query,'get');

   		}//if
   		}//if
   elseif($lst_id!=''){
   //or if this is listing forward or reply
   if(($pro=='forw')||($pro='reply')){

   		$sql_query="select * from listings where lst_id='$lst_id'";
        $lst=sql_execute($sql_query,'get');
        $mes->subject=$lst->title;
        $mes->body=$lst->description;
        $mes->frm_id=$lst->mem_id;

   }//if
   }//elseif
   //if this is making intro
   elseif($intro!=''){

        $mes->subject=name_header($m_id,'')."".LNG_MSG_WLIKE."".name_header($rec_id[0],'')."".LNG_MSG_AND."".
        name_header($rec_id[1],'')."".LNG_MSG_TOMEET;
        $mes->body=name_header($rec_id[0],'')."".LNG_MSG_AND."".name_header($rec_id[1],'').",".LNG_MSG_LNG_MMSG;

   }//elseif
        show_header();
   		?>
          <table class='body' width=100%>
          <tr>
      <td class="lined title"><b><?=LNG_MSG_MSG_SYSTEM?>:</b> 
        <? if($pro=='forw'){echo LNG_MSG_FMSG;}
          elseif($pro=='reply'){echo LNG_MSG_RPLYMSG;}
          elseif($pro==''){echo LNG_MSG_CMM_MSG;} ?>
      </td>
          <tr>
      <td class="orangebody" align="center"> <?php if(!empty($err)) { ?> <b><?=LNG_MSG_FILL_SUB?></b> <?php } ?> &nbsp;</td>
          <tr><td class="lined">
              <table class='body' width=100%>
            <tr><td align=right class="title"><?=LNG_TO?></td>
            <td>
            <?
            //showing a list of recpients or...
            if(is_array($rec_id)){
              foreach($rec_id as $recid){
             ?>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 class='lined-right padded-6'><? show_photo($recid); ?></br>
               <? show_online($recid); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$recid); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($recid,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($recid,"all","num"); ?>
               </td>
            </table>
            <?
            }
            }
            //...showing one recipient
            else {
            ?>
             <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 class='lined-right padded-6'><? show_photo($rec_id); ?></br>
               <? show_online($rec_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'><? connections($m_id,$rec_id); ?></td>
               <tr><td class='padded-6'><?=LNG_NET_WK?>: <? echo count_network($rec_id,"1","num"); ?> <?=LNG_F_IN_NET?> <? echo count_network($rec_id,"all","num"); ?>
               </td>
            </table>
            <? } ?>
            </td>
            <form action="index.php" method=post>
            <input type="hidden" name="mode" value="messages">
            <input type="hidden" name="act" value="compose">
            <input type="hidden" name="done" value="done">
            <?
            if(is_array($rec_id)){
               foreach($rec_id as $recid){
                 echo "<input type='hidden' name='rec_id[]' value='$recid'>";
               }
            }
            else {
                 echo "<input type='hidden' name='rec_id' value='$rec_id'>";
            }
            ?>
            <tr><td align=right class="title"><?=LNG_SUBJECT?></td>
            <td><input type='text' name='subject'
            value='<? if($pro=="reply"){echo LNG_RE."".$mes->subject;}
            elseif($pro=="forw"){echo LNG_MSG_FW."".$mes->subject;}
            else { echo $mes->subject; }
             ?>'>
            </td>
            <tr><td align=right class="title"><?=LNG_YOUR_MSG?></td>
            <td><textarea name='answer' rows=5 cols=45><?
            if($intro==''){echo make_reply($mes->body,$mes->frm_id);}
            else {echo $mes->body;} ?></textarea></td>
            <tr><td align=right colspan=2>
              <p align=center> 
                <input type="button" onClick="window.location='index.php?mode=messages&act=inbox&lng=<?=$lng_id?>'" value="<?=LNG_CANCEL?>">
                <input type="submit" value="<?=LNG_SEND?>">
              </p>
              </form>
            </td>
        </table>
          </td>
          </table>
        <?
        show_footer();

   }//if
   elseif($done=='done'){
   if(is_array($rec_id)){
	   //if there are more than one recipient
	   foreach($rec_id as $recid){

        //getting values
        $subject=form_get("subject");
        $answer=form_get("answer");
        $now=time();
		
		if(empty($subject) || empty($answer)) {
			$link=$main_url."/index.php?mode=messages&act=compose&rec_id=$recid&err=y&lng=$lng_id";
			show_screen($link);
			exit();
		}
		
        //checkin recipient ignore list
        $sql_query="select ignore_list from members where mem_id='$recid'";
        $ign=sql_execute($sql_query,'get');

        $ignore=split("\|",$ign->ignore);
        $ignore=if_empty($ignore);

        if($ignore!=''){
        foreach($ignore as $ig){
        	if($ig==$m_id){
               $flag=1;
               break;
            }//if
        }//foreach
        }//if

        //saving message in user's sent folder and recipient inbox
        //if not ignored
        if($flag!=1){
        $sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date)
        values('$recid','$m_id','$subject','$answer','message','new','inbox','$now')";
        sql_execute($sql_query,'');
        $data[0]=LNG_MSG_NOTI_SITE;
        $data[1]=LNG_MSG_REC_MSG."".name_header($m_id,"").". ".LNG_MSG_TO_VIEW_MSG." <a href='$main_url'>".LNG_MSG_HERE."</a>.";
        $data[2]=name_header($m_id,"ad");
        $sql_query="select email from members where mem_id='$m_id'";
        $k=sql_execute($sql_query,'get');
        $data[3]=$k->email;
        $sql_query="select email from members where mem_id='$recid'";
        $t=sql_execute($sql_query,'get');
        messages($t->email,"7",$data);
        }//if
        $sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date)
        values ('$m_id','$recid','$subject','$answer','message','new','sent','$now')";
        sql_execute($sql_query,'');



   }//foreach
   inbox();
   }//if
   else {
   //same for one recipient
   		$subject=form_get("subject");
        $answer=form_get("answer");
        $now=time();

		if(empty($subject) || empty($answer)) {
			$link=$main_url."/index.php?mode=messages&act=compose&rec_id=$rec_id&err=y";
			show_screen($link);
			exit();
		}

        $sql_query="select ignore_list from members where mem_id='$rec_id'";
        $ign=sql_execute($sql_query,'get');

        $ignore=split("\|",$ign->ignore);
        $ignore=if_empty($ignore);

        if($ignore!=''){
        foreach($ignore as $ig){
        	if($ig==$m_id){
               $flag=1;
               break;
            }//if
        }//foreach
        }//if

        if($flag!=1){
        $sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date)
        values('$rec_id','$m_id','$subject','$answer','message','new','inbox','$now')";
        sql_execute($sql_query,'');
        $data[0]=LNG_MSG_NOTI_SITE;
        $data[1]=LNG_MSG_REC_MSG."".name_header($m_id,"").". ".LNG_MSG_TO_VIEW_MSG." <a href='$main_url'>".LNG_MSG_HERE."</a>.";
        $data[2]=name_header($m_id,"ad");
        $sql_query="select email from members where mem_id='$m_id'";
        $k=sql_execute($sql_query,'get');
        $data[3]=$k->email;
        $sql_query="select email from members where mem_id='$rec_id'";
        $t=sql_execute($sql_query,'get');
        messages($t->email,"7",$data);
        }//if
        $sql_query="insert into messages_system (mem_id,frm_id,subject,body,type,new,folder,date)
        values ('$m_id','$rec_id','$subject','$answer','message','new','sent','$now')";
        sql_execute($sql_query,'');

        inbox();

   }//else
   }//elseif
   }//else

}//function

//function adds > sign to existing forwarded or replied message
function make_reply($message,$mem_id){

   if($message==''){
      return '';
   }//if

   else {
   $sql_query="select fname from members where mem_id='$mem_id'";
   $mem=sql_execute($sql_query,'get');

   $mes=$mem->fname." wrote:\n\n\n&gt;";
   $message=ereg_replace("\n","\n&gt;",$message);
   $words=split(' ',$message);
   for($i=0;$i<count($words);$i++){
        $mes.=$words[$i]." ";
        if($i%10==0){
          $mes.="\n&gt;";
        }//if

   }//for


   return $mes;
   }//else

}//function

//what to do with listing
function listing_action(){
global $main_url,$lng_id;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$pro=form_get('pro');
$lst_id=form_get('lst_id');
$sql_query="select * from listings where lst_id='$lst_id'";
$lst=sql_execute($sql_query,'get');

        //if reply redirect to compose function with needed values
		if($pro=='reply'){

              $link=$main_url."/index.php?mode=messages&act=compose";
              $link.="&rec_id=$lst->mem_id&lst_id=$lst_id&pro=reply&lng=$lng_id";

              show_screen($link);


        }//if
        //same for forward
        elseif($pro=='forw'){

              $link=$main_url."/index.php?mode=listing&act=forward&lst_id=$lst_id&lng=$lng_id";
              show_screen($link);

        }//if

}//function

//what to do with tribe invitation
function trb_inv_action(){
global $main_url,$lng_id;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$trb_inv_id=form_get("trb_inv_id");
    $sql_query="select * from messages_system where mes_id='$trb_inv_id'";
    $frm=sql_execute($sql_query,'get');

    $pro=form_get("pro");

    //confirm
    if($pro=='conf'){

       //updating db, making user a member of tribe
       $sql_query="update members set tribes=concat(tribes,'|$frm->special') where mem_id='$m_id'";
       sql_execute($sql_query,'');
       $sql_query="delete from messages_system where mes_id='$trb_inv_id'";
       sql_execute($sql_query,'');
       $sql_query="update tribes set members=concat(members,'|$m_id'),mem_num=mem_num+1 where trb_id='$frm->special'";
       sql_execute($sql_query,'');

    }//elseif

    //delete invitation
    elseif($pro=='del'){

       $sql_query="delete from messages_system where mes_id='$inv_id'";
       sql_execute($sql_query,'');

    }//elseif

    //redirect
    $location=$main_url."/index.php?mode=login&act=home&lng=$lng_id";
    show_screen($location);

}//function

//what to do with join request
function trb_req_action(){
global $main_url;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

	$trb_req_id=form_get("trb_req_id");
    $sql_query="select * from messages_system where mes_id='$trb_req_id'";
    $frm=sql_execute($sql_query,'get');

    $pro=form_get("pro");

    //confirm
    if($pro=='conf'){

       $sql_query="update members set tribes=concat(tribes,'|$frm->special') where mem_id='$frm->frm_id'";
       sql_execute($sql_query,'');
       $sql_query="delete from messages_system where mes_id='$trb_req_id'";
       sql_execute($sql_query,'');
       $sql_query="update tribes set members=concat(members,'|$frm->frm_id'),mem_num=mem_num+1 where trb_id='$frm->special'";
       sql_execute($sql_query,'');

    }//elseif

    //delete
    elseif($pro=='del'){

       $sql_query="delete from messages_system where mes_id='$trb_req_id'";
       sql_execute($sql_query,'');

    }//elseif

    //redirect
    $location=$main_url."/index.php?mode=login&act=home&lng=$lng_id";
    show_screen($location);

}//function

?>
