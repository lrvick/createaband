<?
 
will be considered as the violation of the copyright laws */ 
$act=form_get("act");
if($act=='log'){
do_admin_login();
}
elseif($act=='forgot'){
send_info();
}
elseif($act=='logout'){
do_log_out();
}

function do_admin_login(){
global $admin_login,$admin_password;
$admin=form_get('admin');
$password=form_get('password');
if(($admin==$admin_login)&&($password==$admin_password)){
$time=time();
$line=$admin_login.$admin_password.$time;
$adsess=md5($line);
$interval=$time-3600*24;
$sql_query="delete from admin where time < $interval";
sql_execute($sql_query,'');
$sql_query="insert into admin (sess_id,started) values ('$adsess','$time')";
sql_execute($sql_query,'');
$sql_query="select mem_id from members";
$mem=sql_execute($sql_query,'num');
$sql_query="select lst_id from listings";
$lst=sql_execute($sql_query,'num');
$sql_query="select trb_id from tribes";
$trb=sql_execute($sql_query,'num');
$sql_query="select f_id from forums";
$for=sql_execute($sql_query,'num');
$sql_query="select blog_id from blogs";
$bog=sql_execute($sql_query,'num');
$sql_query="select even_id from event_list";
$eve=sql_execute($sql_query,'num');
$sql_query="select package_id from member_package";
$pak=sql_execute($sql_query,'num');
$sql_query="select b_id from banners";
$ban=sql_execute($sql_query,'num');
show_ad_header($adsess);
?>
  <table width=100% class='body'>
    <tr><td class='lined title'>Admin Main Page</td>
    <tr>
    <td class='lined padded-6' align=center height=100 valign=middle><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" class="lined padded-6">
        <tr> 
          <td class="lined padded-6"><strong>System main statistic:</strong></td>
        </tr>
        <tr>
          <td class="action">Users: <? echo $mem; ?><br>
            Listings: <? echo $lst; ?><br>
            Groups: <? echo $trb; ?><br>
            Forums: <? echo $for; ?><br>
            Blogs: <? echo $bog; ?><br>
            Events: <? echo $eve; ?><br>
            Packages: <? echo $pak; ?><br>
            Banners: <? echo $ban; ?></td>
        </tr>
      </table><br></td>
  </table>
<?
show_footer();
}
else{
error_screen(15);
}
}

function do_log_out(){
global $main_url;
$adsess=form_get("adsess");
$sql_query="delete from admin where sess_id='$adsess'";
sql_execute($sql_query,'');
$link=$main_url."/admin";
show_screen($link);
}


?>