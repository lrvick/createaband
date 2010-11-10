<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act==''){
  events_list();
}
elseif($act=='del'){
  delete_event('','');
}
elseif($act=='cat'){
  event_cats_manage();
}
elseif($act=='c_del'){
  delete_category();
}
elseif($act=='c_add'){
  add_category();
}

function events_list(){
$adsess=form_get("adsess");
admin_test($adsess);

show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Events Manager</td>
   <tr><td class='lined padded-6'>
   <table class='body' width=100% cellpadding=10 cellspacing=1>
   <?
      $page=form_get("page");
	  if($page=='')	$page=1;
	  $start=($page-1)*20;
      $sql_query="select * from event_list order by even_dt desc limit $start,20";
	  $p_sql="select even_id from event_list order by even_dt desc";
	  $p_url="admin.php?mode=events_manager&adsess=$adsess";
      $num=sql_execute($sql_query,'num');
      if($num==0){
         echo "<tr><td align=center>No Events.</td><tr><td align=right>";
      }//if
      else{
      echo "<form action='admin.php' method=post>
      <input type=hidden name='mode' value='events_manager'>
      <input type=hidden name='act' value='del'>
      <input type=hidden name='adsess' value='$adsess'>
      <tr><td>Select</td><td>Title</td><td>Events Creator</td><td>Category</td><td>Start</td><td>End</td>";
         $res=sql_execute($sql_query,'res');
         while($fru=mysql_fetch_object($res)){
           $sql_query="select event_nam from event_cat where event_id='$fru->even_cat'";
           $name=sql_execute($sql_query,'get');

              echo "<tr><td><input type=checkbox name='fru_id[]' value='$fru->even_id'></td>
              <td>".stripslashes($fru->even_title)."</td>
              <td><a href='admin.php?mode=users_manager&act=edi&adsess=$adsess&mem_id=$fru->f_own'>".name_header($fru->even_own,'ad')."</a></td>
              <td>$name->event_nam</td><td>$fru->even_stat</td><td>$fru->even_end</td>";
         }//while
		 echo "<tr><td colspan=6 align=center class='body'>";page_nums($p_sql,$p_url,$page,20);echo "</td>";
         echo "<tr><td colspan=6 align=right><input type=submit value='Delete Events'>";
      }//else

   ?>
   &nbsp<input value='Manage Categories' type=button onclick="window.location='admin.php?mode=events_manager&act=cat&adsess=<? echo $adsess; ?>'">
   </table></td></table>
   <?
   show_footer();
}//function

function delete_event($mod,$events){
if($mod==''){
$adsess=form_get("adsess");
admin_test($adsess);

$fru_id=form_get("fru_id");
}//if
elseif($mod='bcg') {
$fru_id=array();
$fru_id=$events;
}//else

foreach($fru_id as $fid){
global $base_path;
   $sql_query="delete from event_list where even_id='$fid;'";
   sql_execute($sql_query,'');
}//foreach
if($mod==''){
   events_list();
}//if
else {
   return 1;
}//else
}//function

function event_cats_manage(){
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Event Categories Manager</td>
   <tr><td class='lined padded-6' align=center>
   <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='events_manager'>
   <input type='hidden' name='act' value='c_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <input type=text name='new_cat'>&nbsp<input type=submit value='Add New Category'>
   </td></form>
   <tr><td class='lined padded-6'>
   <table width=90% align="center" cellpadding=10 cellspacing=1 class='body'>
        <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='events_manager'>
         <input type='hidden' name='act' value='c_del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from event_cat";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp</td><td><input type=checkbox name='f_cat_id[]' value='$cat->event_id'></td><td><b>$cat->event_nam</b></td>";
           }//while
         ?>
         <tr>
          <td colspan=3 align=right> 
            <input name="Submit" type="submit" id="Submit" value="Delete Categories">
          </td>
   </table></td></table>
<?
show_footer();
}//function

function add_category(){
$adsess=form_get("adsess");
admin_test($adsess);

$new_cat=form_get("new_cat");
$sql_query="insert into event_cat(event_nam) values('".addslashes($new_cat)."')";
sql_execute($sql_query,'');

event_cats_manage();
}//function

function delete_category() {
$adsess=form_get("adsess");
admin_test($adsess);

$f_cat_id=form_get("f_cat_id");

foreach($f_cat_id as $id){
   $sql_query="delete from event_cat where event_id='$id'";
   sql_execute($sql_query,'');
   $sql_query="select even_id from event_list where even_cat='$id'";
   $res=sql_execute($sql_query,'res');
   $events=array();
   while($fru=mysql_fetch_object($res)){
      array_push($events,$fru->even_id);
   }//while
   delete_event('bcg',$events);
}//foreach

event_cats_manage();
}//function
?>