<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if(($act=='')||($act=='inbox')){
  inbox();
}
elseif($act=='saved'){
  saved();
}
elseif($act=='view_fdb'){
  view_fdbsage();
}
elseif($act=='fdb_list'){
  fdb_list_action();
}
elseif($act=='fdb'){
  fdb_action();
}

function inbox(){
$adsess=form_get("adsess");
admin_test($adsess);

		$sql_query="select * from lst_feedback where folder='inbox' order by date desc";
        $num=sql_execute($sql_query,'num');
        $res=sql_execute($sql_query,'res');

        show_ad_header($adsess);
        ?>
        <table class='body' class="body" width=100%>
           <tr><td class="lined title">Listing Feedback: Inbox</td>
           <tr><td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr><td class="lined-top lined-left lined-right" width=150><a href='admin.php?mode=admin_feedback&act=inbox&adsess=<? echo $adsess; ?>'><b>Inbox</b></a></td>
           <td class="lined" width=150><a href='admin.php?mode=admin_feedback&act=saved&adsess=<? echo $adsess; ?>'><b>Saved</b></a></td>
           </table></td>

           <tr><td class=lined>
           <table class='body' width=100%>
           <? if($num!=0){ ?>
                <tr><td>Select</td><td>New</td><td>From</td><td>Feedback</td><td>Sent</td>
                <form action='admin.php' method='post'>
                <input type='hidden' name='mode' value='admin_feedback'>
                <input type='hidden' name='act' value='fdb_list'>
                <input type='hidden' name='refer' value='inbox'>
                <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
                <input type='hidden' name='pro' value=''>


                <?
                          while($fdb=mysql_fetch_object($res)){

                              $sent=date("m/d/y h:i A",$fdb->date);


                              if($fdb->new=='new'){
                              echo "<tr style='font-weight:bolder'>";
                              }
                              else{
                              echo "<tr>";
                              }

                              echo"<td><input type='checkbox' name='fdb_id[]' value='$fdb->fdb_id'></td>";
                              if($fdb->new=='new'){
                              echo "<td><img src='images/icon_updated.gif'></td>";
                              }//if
                              else{
                              echo "<td>&nbsp</td>";
                              }//else

                              $sql_query="select title from listings where lst_id='$fdb->lst_id'";
                              $lst=sql_execute($sql_query,'get');
                              $feedback=$lst->title.": ".$fdb->pro;
                              echo "<td><a href='index.php?mode=people_card&p_id=$fdb->mem_id'>";
                              echo name_header($fdb->mem_id,"ad");echo"</a></td>";
                              echo "<td><a href='admin.php?mode=admin_feedback&act=view_fdb&fdb_id=$fdb->fdb_id&adsess=$adsess'>$feedback</a><td>$sent</td>";

                          }//while

                ?>

           <tr><td colspan=5 align=right>
           <input type='submit' value='Delete' onClick='this.form.pro.value="del"'>
           <input type='submit' value='Save' onClick='this.form.pro.value="sav"'>
           </td></form>
           <? }
           else {
             echo "<tr><td align=center>No feedbacks.</td>";
           }?>
           </table>
           </td>

        </table>
        <?
        show_footer();

}//function

function saved(){
$adsess=form_get("adsess");
admin_test($adsess);

		$sql_query="select * from lst_feedback where folder='saved' order by date desc";
        $num=sql_execute($sql_query,'num');
        $res=sql_execute($sql_query,'res');

        show_ad_header($adsess);
        ?>
        <table class='body' class="body" width=100%>
           <tr><td class="lined title">Listing Feedback: Saved</td>
           <tr><td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr><td class="lined" width=150><a href='admin.php?mode=admin_feedback&act=inbox&adsess=<? echo $adsess; ?>'><b>Inbox</b></a></td>
           <td class="lined-top lined-left lined-right" width=150><a href='admin.php?mode=admin_feedback&act=saved&adsess=<? echo $adsess; ?>'><b>Saved</b></a></td>
           </table></td>

           <tr><td class=lined>
           <table class='body' width=100%>
           <? if($num!=0){ ?>
                <tr><td>Select</td><td>New</td><td>From</td><td>Feedback</td><td>Sent</td>
                <form action='admin.php' method='post'>
                <input type='hidden' name='mode' value='admin_feedback'>
                <input type='hidden' name='act' value='fdb_list'>
                <input type='hidden' name='refer' value='saved'>
                <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
                <input type='hidden' name='pro' value=''>


                <?
                          while($fdb=mysql_fetch_object($res)){

                              $sent=date("m/d/y h:i A",$fdb->date);


                              if($fdb->new=='new'){
                              echo "<tr style='font-weight:bolder'>";
                              }
                              else{
                              echo "<tr>";
                              }

                              echo"<td><input type='checkbox' name='fdb_id[]' value='$fdb->fdb_id'></td>";
                              if($fdb->new=='new'){
                              echo "<td><img src='images/icon_updated.gif'></td>";
                              }//if
                              else{
                              echo "<td>&nbsp</td>";
                              }//else

                              $sql_query="select title from listings where lst_id='$fdb->lst_id'";
                              $lst=sql_execute($sql_query,'get');
                              $feedback=$lst->title.": ".$fdb->pro;
                              echo "<td><a href='index.php?mode=people_card&p_id=$fdb->mem_id'>";
                              echo name_header($fdb->mem_id,"ad");echo"</a></td>";
                              echo "<td><a href='admin.php?mode=admin_feedback&act=view_fdb&fdb_id=$fdb->fdb_id&adsess=$adsess'>$feedback</a><td>$sent</td>";

                          }//while

                ?>

           <tr><td colspan=5 align=right>
           <input type='submit' value='Delete' onClick='this.form.pro.value="del"'>
           <input type='submit' value='Save' onClick='this.form.pro.value="sav"'>
           </td></form>
           <? }
           else {
             echo "<tr><td align=center>No feedbacks.</td>";
           }?>
           </table>
           </td>

        </table>
        <?
        show_footer();
}//function

function view_fdbsage(){
$adsess=form_get("adsess");
admin_test($adsess);

	$fdb_id=form_get("fdb_id");
    $sql_query="select * from lst_feedback where fdb_id='$fdb_id'";
    $fdb=sql_execute($sql_query,'get');
    $date=date("m/d/y h:i A",$fdb->date);
    show_ad_header($adsess);
    ?>
    <table class='body' width=100%>
           <tr><td class="lined title">Listing Feedback: View feedback</td>
           <tr><td>&nbsp;</td>
           <tr><td><table class='body'>
           <tr><td class="lined" width=150><a href='admin.php?mode=admin_feedback&act=inbox&adsess=<? echo $adsess; ?>'><b>Inbox</b></a></td>
           <td class="lined" width=150><a href='admin.php?mode=admin_feedback&act=saved&adsess=<? echo $adsess; ?>'><b>Saved</b></a></td>
           </table></td>
           <tr><td class="lined padded-6">
        <table class='body' width=100%>
            <tr><td align=right class="title">From</td>
            <td>
            <table class='body lined' cellspacing=0 cellpadding=0>
               <tr><td rowspan=2 class='lined-right padded-6'><? show_photo($fdb->mem_id); ?></br>
               <? show_online($fdb->mem_id); ?>
               </td>
               <td class='td-lined-bottom padded-6'>Admin View</td>
               <tr><td class='padded-6'>Network: <? echo count_network($fdb->mem_id,"1","num"); ?> friends in a
               network of <? echo count_network($fdb->mem_id,"all","num"); ?>
               </td>
            </table>
            </td>
            <form action="admin.php">
            <input type="hidden" name="mode" value="admin_feedback">
            <input type="hidden" name="act" value="fdb">
            <input type="hidden" name="pro" value="">
            <input type="hidden" name="fdb_id" value="<? echo $fdb_id; ?>">
            <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
            <tr><td align=right class="title">Date</td>
            <td>
            <? echo $date; ?>
            </td>
            <tr><td align=right class="title">Subject</td>
            <td>
            <? $sql_query="select title from listings where lst_id='$fdb->lst_id'";
                              $lst=sql_execute($sql_query,'get');
                              $feedback=$lst->title.": ".$fdb->pro;
                              echo $feedback; ?>
            </td>
            <tr><td align=right class="title">Feedback</td>
            <td>
            <?
            $body="Listing called \"$lst->title\" ";
            if($fdb->pro=='mis-cat'){
                $body.="is mis-categorized";
            }
            elseif($fdb->pro=='best'){
                $body.="is best of E-Friends";
            }
            elseif($fdb->pro=='spam'){
                $body.="is a spam!";
            }
            elseif($fdb->pro=='mature'){
                $body.="is mature.";
            }
            elseif($fdb->pro=='repeat'){
                $body.="needs to be repeated.";
            }
            echo $body;
            ?></td>
            <tr><td align=right colspan=2>
            <input type="submit" onClick="this.form.pro.value='del'" value="Delete">
            <input type="submit" onClick="this.form.pro.value='sav'" value="Save">
        </table></form>
      </td>
  </table>
  <?
  $sql_query="update lst_feedback set new='' where fdb_id='$fdb_id'";
  sql_execute($sql_query,'');
  show_footer();

}//function

function fdb_list_action(){
$adsess=form_get("adsess");
admin_test($adsess);

	$refer=form_get("refer");

	$fdb_id=form_get("fdb_id");

    $pro=form_get("pro");

    if($pro=='sav'){

         foreach($fdb_id as $ms){

         $sql_query="update lst_feedback set folder='saved' where fdb_id='$ms'";
         sql_execute($sql_query,'');

         }//foreach

    }//if

    elseif($pro=='del'){

         foreach($fdb_id as $ms){

         $sql_query="delete from lst_feedback where fdb_id='$ms'";
         sql_execute($sql_query,'');

         }//foreach

    }//elseif

    $refer();

}//function

function fdb_action(){
$adsess=form_get("adsess");
admin_test($adsess);

      $fdb_id=form_get("fdb_id");
      $pro=form_get("pro");

      if($pro=='del'){
         $sql_query="delete from lst_feedback where fdb_id='$fdb_id'";
         sql_execute($sql_query,'');

         inbox();

      }//if

      elseif($pro=='sav'){

         $sql_query="update lst_feedback set folder='saved' where fdb_id='$fdb_id'";
         sql_execute($sql_query,'');

         view_fdbsage();

      }//elseif

}//functions

?>