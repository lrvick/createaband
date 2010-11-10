<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act==''){
  forums_list();
}
elseif($act=='del'){
  delete_forum('','');
}
elseif($act=='cat'){
  forum_cats_manage();
}
elseif($act=='c_del'){
  delete_category();
}
elseif($act=='c_add'){
  add_category();
}

function forums_list(){
$adsess=form_get("adsess");
admin_test($adsess);

show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Forums Manager</td>
   <tr><td class='lined padded-6'>
   <table class='body' width=100% cellpadding=10 cellspacing=1>
   <?
      $page=form_get("page");
	  if($page=='')	$page=1;
	  $start=($page-1)*20;
      $sql_query="select * from forums limit $start,20";
	  $p_sql="select f_id from forums";
	  $p_url="admin.php?mode=forums_manager&adsess=$adsess";
      $num=sql_execute($sql_query,'num');
      if($num==0){
         echo "<tr><td align=center>No Threads.</td><tr><td align=right>";
      }//if
      else{
      echo "<form action='admin.php' method=post>
      <input type=hidden name='mode' value='forums_manager'>
      <input type=hidden name='act' value='del'>
      <input type=hidden name='adsess' value='$adsess'>
      <tr><td><strong>Select</strong></td><td><strong>Posts</strong></td><td><strong>Forum Creator</strong></td><td><strong>Type</strong></td><td><strong>Category</strong></td>";
         $res=sql_execute($sql_query,'res');
         while($fru=mysql_fetch_object($res)){
           $sql_query="select name from f_categories where f_cat_id='$fru->f_c_id'";
           $name=sql_execute($sql_query,'get');

              echo "<tr><td><input type=checkbox name='fru_id[]' value='$fru->f_id'></td>
              <td>".stripslashes($fru->f_matt)."</td>
              <td><a href='admin.php?mode=users_manager&act=edi&adsess=$adsess&mem_id=$fru->f_own'>".name_header($fru->f_own,'ad')."</a></td>
              <td>$fru->f_st</td><td>$name->name</td>";
         }//while
		 echo "<tr><td colspan=5 align=center class='lined'>";page_nums($p_sql,$p_url,$page,20);echo "</td>";
         echo "<tr><td colspan=5 align=right><input type=submit value='Delete Forums'>";
      }//else

   ?>
   &nbsp<input value='Manage Categories' type=button onclick="window.location='admin.php?mode=forums_manager&act=cat&adsess=<? echo $adsess; ?>'">
   </table></td></table>
   <?
   show_footer();
}//function

function delete_forum($mod,$forums){
if($mod==''){
$adsess=form_get("adsess");
admin_test($adsess);

$fru_id=form_get("fru_id");
}//if
elseif($mod='bcg') {
$fru_id=array();
$fru_id=$forums;
}//else

foreach($fru_id as $fid){
global $base_path;
   $sql_query="delete from forums where f_id='$fid;'";
   sql_execute($sql_query,'');
}//foreach
if($mod==''){
   forums_list();
}//if
else {
   return 1;
}//else
}//function

function forum_cats_manage(){
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Forum Categories Manager</td>
   <tr><td class='lined padded-6 body' align=left>
   <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='forums_manager'>
   <input type='hidden' name='act' value='c_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <strong>Name :</strong> &nbsp;<input type=text name='new_cat'>&nbsp;<strong>Description :</strong> <input type=text name='new_cat_desc'>&nbsp<input type=submit value='Add New Category'>
   </td></form>
   <tr><td class='lined padded-6'>
   <table width=90% align="center" cellpadding=10 cellspacing=1 class='body'>
        <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='forums_manager'>
         <input type='hidden' name='act' value='c_del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?php
           $sql_query="select * from f_categories";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp</td><td><input type=checkbox name='f_cat_id[]' value='$cat->f_cat_id'></td><td><b>$cat->name</b></td>";
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
$new_cat_desc=form_get("new_cat_desc");
$sql_query="insert into f_categories(name,descr) values('".addslashes($new_cat)."','".addslashes($new_cat_desc)."')";
sql_execute($sql_query,'');

forum_cats_manage();
}//function

function delete_category() {
$adsess=form_get("adsess");
admin_test($adsess);

$f_cat_id=form_get("f_cat_id");

foreach($f_cat_id as $id){
   $sql_query="delete from f_categories where f_cat_id='$id'";
   sql_execute($sql_query,'');
   $sql_query="select f_id from forums where f_c_id='$id'";
   $res=sql_execute($sql_query,'res');
   $forums=array();
   while($fru=mysql_fetch_object($res)){
      array_push($forums,$fru->f_id);
   }//while
   delete_forum('bcg',$forums);
}//foreach

forum_cats_manage();
}//function
?>