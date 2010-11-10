<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='')	tribes_list();
elseif($act=='del')	delete_tribe('','');
elseif($act=='cat')	tribe_cats_manage();
elseif($act=='c_del')	delete_category();
elseif($act=='c_add')	add_category();
elseif($act=="set")	set();

function tribes_list(){
$adsess=form_get("adsess");
admin_test($adsess);

show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Groups Manager</td>
   <tr><td class='lined padded-6'>
   <table class='body' width=100% cellpadding=10 cellspacing=1>
   <?
      $page=form_get("page");
	  if($page=='')	$page=1;
	  $start=($page-1)*20;
	  $sql_query="select * from tribes limit $start,20";
	  $p_sql="select trb_id from tribes";
	  $p_url="admin.php?mode=tribes_manager&adsess=$adsess";
	  $num=sql_execute($sql_query,'num');
      if($num==0){
         echo "<tr><td align=center>No Groups.</td><tr><td align=right>";
      }//if
      else{
      echo "<form action='admin.php' method=post>
      <input type=hidden name='mode' value='tribes_manager'>
      <input type=hidden name='act' value='del'>
      <input type=hidden name='adsess' value='$adsess'>
      <tr><td><strong>Select</strong></td><td><strong>Group Name</strong></td><td><strong>Group Creator</strong></td><td><strong>Members</strong></td><td><strong>Category</strong></td><td><strong>Featured</strong></td>";
         $res=sql_execute($sql_query,'res');
         while($trb=mysql_fetch_object($res)){
           $sql_query="select name from t_categories where t_cat_id='$trb->t_cat_id'";
           $name=sql_execute($sql_query,'get');

              echo "<tr><td><input type=checkbox name='trb_id[]' value='$trb->trb_id'></td>
              <td>$trb->name";
			  if($trb->feat=="y")	echo "&nbsp;(&nbsp;<strong>F</strong>&nbsp;)&nbsp;";
			  echo "</td>
              <td><a href='admin.php?mode=users_manager&act=edi&adsess=$adsess&mem_id=$trb->mem_id'>".name_header($trb->mem_id,'ad')."</a></td>
              <td>$trb->mem_num</td><td>$name->name</td><td><a href='admin.php?mode=tribes_manager&act=set&seid=$trb->trb_id&adsess=$adsess'>Set as Featured</a></td>";
         }//while
		 echo "<tr><td colspan=6 align=center class='lined'>";page_nums($p_sql,$p_url,$page,20);echo "</td>";
         echo "<tr><td colspan=6 align=right><input type=submit value='Delete Groups'>";
      }//else

   ?>
   &nbsp<input value='Manage Categories' type=button onclick="window.location='admin.php?mode=tribes_manager&act=cat&adsess=<? echo $adsess; ?>'">
   </table></td></table>
   <?
   show_footer();
}//function

function delete_tribe($mod,$tribes){
if($mod==''){
$adsess=form_get("adsess");
admin_test($adsess);

$trb_id=form_get("trb_id");
}//if
elseif($mod='bcg') {
$trb_id=array();
$trb_id=$tribes;
}//else

foreach($trb_id as $tid){
global $base_path;
   $sql_query="select url from tribes where trb_id='$tid'";
   $trb=sql_execute($sql_query,'get');
   $folder="groups/".$trb->url;
   unlink("$folder/index.php");
   rmdir("$folder");
   $sql_query="select members from tribes where trb_id='$tid'";
   $trb=sql_execute($sql_query,'get');
   $members=split("\|",$trb->members);
   $members=if_empty($members);
   if($members!=''){
     foreach($members as $mid){
          $sql_query="select tribes from members where mem_id='$mid'";
          $mem=sql_execute($sql_query,'get');
          $tribes=split("\|",$mem->tribes);
          $tribes=if_empty($tribes);
          $line='';
          foreach($tribes as $tr){
             if($tr!=$tid){
              $line.="|$tr";
             }
          }//foreach
          $sql_query="update members set tribes='$line' where mem_id='$mid'";
          sql_execute($sql_query,'');
     }//foreach
   }//if
   $sql_query="delete from tribes where trb_id='$tid;'";
   sql_execute($sql_query,'');
   $sql_query="delete from board where trb_id='$tid;'";
   sql_execute($sql_query,'');
   $sql_query="delete from replies where trb_id='$tid;'";
   sql_execute($sql_query,'');
   $sql_query="delete from events where trb_id='$tid;'";
   sql_execute($sql_query,'');
}//foreach
if($mod==''){
   tribes_list();
}//if
else {
   return 1;
}//else
}//function

function tribe_cats_manage(){
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Group Categories Manager</td>
   <tr><td class='lined padded-6' align=center>
   <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='tribes_manager'>
   <input type='hidden' name='act' value='c_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <input type=text name='new_cat'>&nbsp<input type=submit value='Add New Category'>
   </td></form>
   <tr><td class='lined padded-6'>
   <table class='body' width=100% cellpadding=10 cellspacing=1>
         <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='tribes_manager'>
         <input type='hidden' name='act' value='c_del'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <?
           $sql_query="select * from t_categories";
           $res=sql_execute($sql_query,'res');
           while($cat=mysql_fetch_object($res)){
               echo "<tr><td width=200>&nbsp</td>
               <td><input type=checkbox name='t_cat_id[]' value='$cat->t_cat_id'></td>
               <td><b>$cat->name</b></td>";
           }//while
         ?>
         <tr><td colspan=3 align=right><input type=submit value='Delete Categories'></td>
   </table></td></table>
<?
show_footer();
}//function

function add_category(){
$adsess=form_get("adsess");
admin_test($adsess);

$new_cat=form_get("new_cat");
$sql_query="insert into t_categories(name) values('$new_cat')";
sql_execute($sql_query,'');

tribe_cats_manage();
}//function

function delete_category() {
$adsess=form_get("adsess");
admin_test($adsess);

$t_cat_id=form_get("t_cat_id");

foreach($t_cat_id as $id){
   $sql_query="delete from t_categories where t_cat_id='$id'";
   sql_execute($sql_query,'');
   $sql_query="select trb_id from tribes where t_cat_id='$id'";
   $res=sql_execute($sql_query,'res');
   $tribes=array();
   while($trb=mysql_fetch_object($res)){
      array_push($tribes,$trb->trb_id);
   }//while
   delete_tribe('bcg',$tribes);
}//foreach

tribe_cats_manage();
}//function

function set()	{
	$adsess=form_get("adsess");
	admin_test($adsess);
	$seid=form_get("seid");
	$sql_query="update tribes set feat='y' where trb_id='$seid'";
	sql_execute($sql_query,'');
	$sql_query="update tribes set feat='n' where trb_id<>'$seid'";
	sql_execute($sql_query,'');
	tribes_list();
}
?>