<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act==''){
  listings_list();
}
elseif($act=='del'){
  delete_listing();
}
elseif($act=='edi'){
  $pro=form_get("pro");
  if($pro==''){
  edit_listing(0);
  }
  else{
  edit_listing(1);
  }
}
elseif($act=='cat'){
  manage_cats_list();
}
elseif($act=='c_del'){
  delete_category();
}
elseif($act=='c_add'){
  add_category();
}
elseif($act=='cs_add'){
  add_sub_category();
}

function listings_list(){
$adsess=form_get("adsess");
admin_test($adsess);

show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Listings Manager</td>
   <tr><td class='lined padded-6'>
   <table class='body' width=100% cellpadding=10 cellspacing=1>
        <?
        $page=form_get("page");
        if($page==''){
          $page=1;
        }
        $start=($page-1)*20;
          $sql_query="select * from listings limit $start,20";
		  $p_sql="select lst_id from listings";
		  $p_url="admin.php?mode=listings_manager&adsess=$adsess";
          $num=sql_execute($sql_query,'num');
          if($num==0){
            echo "<tr><td align=center>No listings.</td><tr><td align=right>";
          }//if
          else{
          echo "<form action='admin.php' method=post>
           <input type=hidden name='mode' value='listings_manager'>
           <input type=hidden name='act' value=''>
           <input type=hidden name='adsess' value='$adsess'>
           <tr><td><strong>Select</strong></td><td><strong>Title</strong></td><td><strong>Listing</strong></td><td><strong>Lister</strong></td><td><strong>Category</strong></td>";
             $res=sql_execute($sql_query,'res');
             while($lst=mysql_fetch_object($res)){

                 echo "<tr><td><input type=checkbox name='lst_id[]' value='$lst->lst_id'></td>
                 <td><span class='action'><a href='admin.php?mode=listings_manager&act=edi&adsess=$adsess&lst_id=$lst->lst_id'>$lst->title</a></span></td>
                 <td>$lst->descr_part</td><td><a href='admin.php?mode=users_manager&act=edi&adsess=$adsess&mem_id=$lst->mem_id'>".name_header($lst->mem_id,'ad')."</a></td>
                 <td>".get_cat_name($lst->cat_id)."</td>";

             }//while
          echo "<tr><td colspan=5 align=center class='lined'>";page_nums($p_sql,$p_url,$page,20); echo "</td>";
          echo "<tr><td colspan=5 align=right><input type='submit' value='Delete Listings' onclick='javascript:this.form.act.value=\"del\"'>";
          }//else



        ?>
        &nbsp<input type=button value='Manage Categories' onclick="window.location='admin.php?mode=listings_manager&act=cat&adsess=<? echo $adsess; ?>'"></td>
   </table></form>
   </td>
   </table>

<?
show_footer();
}//function

function delete_listing(){
$adsess=form_get("adsess");
admin_test($adsess);

$lst_id=form_get("lst_id");

foreach($lst_id as $lid){
    $sql_query="delete from listings where lst_id='$lid'";
    sql_execute($sql_query,'');
}//foreach

listings_list();

}//function

function edit_listing($mod){
$adsess=form_get("adsess");
admin_test($adsess);

$lst_id=form_get("lst_id");

if($mod==0){
$sql_query="select * from listings where lst_id='$lst_id'";
$lst=sql_execute($sql_query,'get');
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Edit Listing</td>
   <tr><td class='lined padded-6'>
   <table class='body'>
         <form action='admin.php' method=post name='searchListing'>
         <input type='hidden' name='mode' value='listings_manager'>
         <input type='hidden' name='act' value='edi'>
         <input type='hidden' name='lst_id' value='<? echo $lst_id; ?>'>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <input type='hidden' name='pro' value='done'>
         <tr><td>Title</td><td><input type='text' name='title' value='<? echo $lst->title; ?>'></td>
         <tr><td>Category</td><td><select name="RootCategory" onChange="listCategory.populate();" width="140" style="width: 140px">
		<option value="">Select Category</option>
        <? listing_cats("$lst->cat_id"); ?>
       	</select>&nbsp<select name="Category" width="140" style="width: 140px">
	   				  <SCRIPT LANGUAGE="JavaScript">listCategory.printOptions();</script>
	   	</select>
	   	<SCRIPT LANGUAGE="JavaScript">listCategory.setDefaultOption("<? echo $lst->cat_id; ?>","<? echo $lst->sub_cat_id; ?>");</script></td>
         <tr><td colspan=2 align=center>Description</td>
         <tr><td colspan=2 align=center><textarea rows=5 cols=45 name='description'><? echo $lst->description; ?></textarea></td>
         <tr><td colspan=2 align=right><input type='submit' value='Update'></td>
   </form></table></td></table>
<?
show_footer();
}//if
elseif($mod==1){
    $title=form_get("title");
    $cat_id=form_get("RootCategory");
    $sub_cat_id=form_get("Category");
    $description=form_get("description");

    $part=split(" ",$description);
        $descr_part='';
        for($i=0;$i<10;$i++){
           $descr_part.=" ".$part[$i];
        }

    $sql_query="update listings set title='$title',description='$description',descr_part='$descr_part',
    cat_id='$cat_id',sub_cat_id='$sub_cat_id' where lst_id='$lst_id'";
    sql_execute($sql_query,'');

    edit_listing(0);

}//elseif
}//function

function manage_cats_list(){
$adsess=form_get("adsess");
admin_test($adsess);
$sql_query="select cat_id from categories";
$res=sql_execute($sql_query,'res');
$cats=array();
while($cat=mysql_fetch_object($res)){
   array_push($cats,$cat->cat_id);
}//while
//find middle of array
$mid=(int)(count($cats)/2)+2;
show_ad_header($adsess);
?>
  <table width=100% class='body'>
   <tr><td class='lined title'>Admin: Manage Listing Categories</td>
   <tr><td class='lined padded-6' align=center>
   <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='listings_manager'>
   <input type='hidden' name='act' value='c_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <input type=text name='new_cat'>&nbsp<input type=submit value='Add New Category'>
   </td></form>
   <tr><td class='lined padded-6'>
   <table class='body' width=100%>
         <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='listings_manager'>
         <input type='hidden' name='act' value=''>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <tr><td valign=top width=50%>
         <table class=body>
         <?
            for($i=0;$i<$mid;$i++){
            $sql_query="select * from categories where cat_id='$cats[$i]'";
            $cat=sql_execute($sql_query,'get');
               echo "<tr><td colspan=2><input type=checkbox name='cat_id[]' value='$cat->cat_id'></td><td><b>$cat->name</b></td>";
               $sql_query="select * from sub_categories where cat_id='$cat->cat_id'";
               $res2=sql_execute($sql_query,'res');
               while($sub=mysql_fetch_object($res2)){
                   echo "<tr><td>&nbsp</td><td><input type=checkbox name='sub_cat_id[]' value='$sub->sub_cat_id'></td><td class='form-comment'>$sub->name</td>";
               }//while
            echo "<tr><td colspan=3>
            <input type=hidden name='cat_id_ex[]' value='$cats[$i]'>
            <input type='text' size=15 name='new_sub[]'>&nbsp<input type='submit' value='Add' onClick='this.form.act.value=\"cs_add\"'>
            </td>";
            }//for
         ?>
         </table></td>
         <td valign=top>
         <table class=body>
         <?
            for($i=$mid;$i<count($cats);$i++){
            $sql_query="select * from categories where cat_id='$cats[$i]'";
            $cat=sql_execute($sql_query,'get');
               echo "<tr><td colspan=2><input type=checkbox name='cat_id[]' value='$cat->cat_id'></td><td><b>$cat->name</b></td>";
               $sql_query="select * from sub_categories where cat_id='$cat->cat_id'";
               $res2=sql_execute($sql_query,'res');
               while($sub=mysql_fetch_object($res2)){
                   echo "<tr><td>&nbsp</td><td><input type=checkbox name='sub_cat_id[]' value='$sub->sub_cat_id'></td><td class='form-comment'>$sub->name</td>";
               }//while
            echo "<tr><td colspan=3>
            <input type=hidden name='cat_id_ex[]' value='$cats[$i]'>
            <input type='text' size=15 name='new_sub[]'>&nbsp<input type='submit' value='Add' onClick='this.form.act.value=\"cs_add\"'>
            </td>";
            }//for
         ?>
         </table>
         </td>
         <tr><td colspan=2 align=right><input type='submit' value='Delete Categories' onClick='this.form.act.value="c_del"'></td>
  </form></table></td></table>
<?
show_footer();
}//function

function add_category(){
$adsess=form_get("adsess");
admin_test($adsess);

$sql_query="select max(cat_id) as max from categories";
$max=sql_execute($sql_query,'get');

$new_num=$max->max+1000;

$name=form_get("new_cat");

$sql_query="insert into categories(cat_id,name) values('$new_num','$name')";
sql_execute($sql_query,'');

manage_cats_list();

}//function

function add_sub_category(){
$adsess=form_get("adsess");
admin_test($adsess);

$cat_ids=form_get("cat_id_ex");
$names=form_get("new_sub");

for($i=0;$i<count($names);$i++){
  if($names[$i]!=''){
    $stop=$i;break;
  }
}//for

$cat_id=$cat_ids[$stop];
$name=$names[$stop];

$sql_query="select max(sub_cat_id) as max from sub_categories where cat_id='$cat_id'";
$num=sql_execute($sql_query,'num');
if($num==0){
  $newnum=$cat_id+1;
}//if
else{
  $max=sql_execute($sql_query,'get');
  $newnum=$max->max+1;
}//else

$sql_query="insert into sub_categories(cat_id,sub_cat_id,name) values('$cat_id','$newnum','$name')";
sql_execute($sql_query,'');

manage_cats_list();

}//function

function delete_category(){
$adsess=form_get("adsess");
admin_test($adsess);

$cat_id=form_get("cat_id");
$sub_cat_id=form_get("sub_cat_id");

if($sub_cat_id!=''){
  foreach($sub_cat_id as $sid){
       $sql_query="delete from sub_categories where sub_cat_id='$sid'";
       sql_execute($sql_query,'');
       $sql_query="delete from listings where sub_cat_id='$sid'";
       sql_execute($sql_query,'');
  }//foreach
}//if

if($cat_id!=''){
  foreach($cat_id as $cid){
      $sql_query="delete from categories where cat_id='$cid'";
      sql_execute($sql_query,'');
      $sql_query="delete from sub_categories where cat_id='$cid'";
      sql_execute($sql_query,'');
      $sql_query="delete from listings where cat_id='$cid'";
      sql_execute($sql_query,'');
  }//foreach
}//if

manage_cats_list();

}//function


?>