<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act==''){
  blog_cats_manage();
}
elseif($act=='b_del'){
  delete_blogs();
}

function blog_cats_manage(){
global $main_url;
$adsess=form_get("adsess");
admin_test($adsess);
show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Blogs Manager</td>
   <tr><td class='lined padded-6' align=center>
   </td>
   <tr><td class='lined padded-6'>
   <form action='admin.php' method=post>
        <table width=90% align="center" cellpadding=10 cellspacing=1 class='body'>
          <input type='hidden' name='mode' value='blogs_manager'>
          <input type='hidden' name='act' value='b_del'>
          <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
          <?php
           $page=form_get("page");
		   if($page=='')	$page=1;
		   $start=($page-1)*20;
		   $sql_query="select * from blogs order by blog_own limit $start,20";
		   $p_sql="select blog_id from blogs order by blog_own";
		   $p_url="admin.php?mode=blogs_manager&adsess=$adsess";
           $res=sql_execute($sql_query,'res');
		   if(mysql_num_rows($res)) {
           while($cat=mysql_fetch_object($res)){
		   if(empty($cat->blog_img))	$imgdis="<img src='blog/noimage.jpg' border='0'>";
		   else	$imgdis="<img src='".$cat->blog_img."' border='0'>";
		   ?>
          <tr> 
            <td width="6%" rowspan="3" align="left"><input type="checkbox" name="blog_id[]" value="<?=$cat->blog_id?>"></td>
            <td width="5%" rowspan="3" align="left">
              <?=$imgdis?>
            </td>
            <td width="89%" align="left"><b> <i><a href="<?=$main_url?>/blog/<? echo mem_profilenam($cat->blog_own); ?>" target="_blank"><? echo name_header($cat->blog_own,'ad'); ?></a></i> 
              </b></td>
          </tr>
          <tr>
            <td align="left"><strong><?=stripslashes($cat->blog_title)?></strong><br>Posted: <? echo date("m/d/Y h:i A",$cat->blog_dt); ?></td>
          </tr>
          <tr> 
            <td align="left"><b> 
              <?=stripslashes($cat->blog_matt)?>
              </b></td>
          </tr>
          <?
           }//while
         ?>
          <tr> 
            <td colspan=3 align=right> <? echo page_nums($p_sql,$p_url,$page,20); ?> 
            </td>
          </tr>
          <tr> 
            <td colspan=3 align=right> <input name="Submit" type="submit" id="Submit" value="Delete Blogs"> 
            </td>
          </tr>
          <? } else { ?>
          <tr> 
            <td align="center" class="body">No blogs</td>
          </tr>
          <? } ?>
        </table>
      </form></td></table>
<?
show_footer();
}//function

function delete_blogs() {
$adsess=form_get("adsess");
admin_test($adsess);

$blog_id=form_get("blog_id");

foreach($blog_id as $id){
   $sql_query="delete from blogs where blog_id='$id'";
   sql_execute($sql_query,'');
}//foreach

blog_cats_manage();
}//function
?>