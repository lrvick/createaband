<?
$act=form_get("act");
if($act==''){
//showing user's photo album, depending on page
  $p_id=form_get("p_id");
  $m_id=cookie_get("mem_id");
  $page=form_get("page");
  if($page==''){
     $page=1;
  }//if
  show_header();
?>

<table width=100% class='body'>
  <tr> 
    <td class="lined title"><? echo name_header($p_id,$m_id); ?>'<?=LNG_PTO_ALB_PA?></td>
  <tr> 
    <td class="lined"><table align=center class='body'>
        <? photo_album($p_id,"$page",''); ?>
      </table></td>
  <tr> 
    <td class=lined align=center> 
      <? pages_line($p_id,"photo_album","$page","10"); ?>
    </td>
  <tr> 
    <td align=center>&nbsp;</td>
    <td align=center>&nbsp;</td>
</table>
<?
  show_footer();
}//if
elseif($act=='view'){
//showing one selected photo
$pho_id=form_get("pho_id");
$p_id=form_get("p_id");
$m_id=cookie_get("m_id");
	$sql_query="select photo,capture from photo where mem_id='$p_id'";
    $pho=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo);
    $photos=if_empty($photos);
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);

    show_header();
    echo "<table width=100% class='body'><tr><td class='lined title'>".name_header($p_id,$m_id)."</td><tr><td class='lined'>";
    echo "<table align=center class='body'><tr><td><img src='$photos[$pho_id]' border=0></td><tr><td align=center>$captures[$pho_id]</td></table></td></table>";
    show_footer();

}//elseif
elseif($act=='tribe'){
//showing tribe photo album, depending on page
$trb_id=form_get("trb_id");
$page=form_get("page");
if($page==''){
  $page=1;
}
  $sql_query="select name from tribes where trb_id='$trb_id'";
  $name=sql_execute($sql_query,'get');
  show_header();
?>

            <table width=100% class='body'>
              <tr><td class="lined title"><? echo $name->name; ?> <?=LNG_PHOTO_ALBUM?></td>
              <tr><td class="lined"><table align=center class='body'>
              <? tribe_photo_album($trb_id,"$page"); ?>
              </table></td>
              <tr><td class=lined align=center><? pages_line($trb_id,"tribe_photo_album","$page","10"); ?></td>
            </table>
<?
  show_footer();

}//elseif
elseif($act=='trb_view'){
//showing one selected user photo
$pho_id=form_get("pho_id");
$trb_id=form_get("trb_id");
$sql_query="select name from tribes where trb_id='$trb_id'";
  $name=sql_execute($sql_query,'get');

	$sql_query="select photo,capture from tribe_photo where trb_id='$trb_id'";
    $pho=sql_execute($sql_query,'get');
    $photos=split("\|",$pho->photo);
    $photos=if_empty($photos);
    $captures=split("\|",$pho->capture);
    $captures=if_empty($captures);

    show_header();
    echo "<table width=100% class='body'><tr><td class='lined title'>".$name->name."</td><tr><td class='lined'>";
    echo "<table align=center class='body'><tr><td><img src='$photos[$pho_id]' border=0></td><tr><td align=center>$captures[$pho_id]</td></table></td></table>";
    show_footer();

}//elseif
elseif($act=='del'){
global $base_path,$HTTP_REFERER;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$pho_id=form_get("pho_id");
$sql_query="select photo,photo_b_thumb,photo_thumb,capture from photo where mem_id='$m_id'";
$pho=sql_execute($sql_query,'get');

$photos=split("\|",$pho->photo);
$photos=if_empty($photos);
$photos_th=split("\|",$pho->photo_thumb);
$photos_th=if_empty($photos_th);
$photos_b_th=split("\|",$pho->photo_b_thumb);
$photos_b_th=if_empty($photos_b_th);
$capture=split("\|",$pho->capture);
$capture=if_empty($capture);

if(file_exists("$base_path/$photos[$pho_id]")){
  unlink("$base_path/$photos[$pho_id]");
}
if(file_exists("$base_path/$photos_th[$pho_id]")){
  unlink("$base_path/$photos_th[$pho_id]");
}
if(file_exists("$base_path/$photos_b_th[$pho_id]")){
  unlink("$base_path/$photos_b_th[$pho_id]");
}

$sql_query="select photo from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
if($photos[$i]==$mem->photo){
  $sql_query="update members set photo='',photo_b_thumb='',photo_thumb='' where mem_id='$m_id'";
  sql_execute($sql_query,'');
}//if

unset($photos[$pho_id]);
unset($photos_th[$pho_id]);
unset($photos_b_th[$pho_id]);
unset($capture[$pho_id]);

$line='';
$line2='';
$line3='';
$line4='';
foreach($photos as $p){
  $line.=$p."|";
}
foreach($photos_th as $p){
  $line2.=$p."|";
}
foreach($photos_b_th as $p){
  $line3.=$p."|";
}
foreach($capture as $p){
  $line3.=$p."|";
}

$sql_query="update photo set photo='$line',photo_thumb='$line2',
photo_b_thumb='$line3',capture='$line4'
where mem_id='$m_id'";
sql_execute($sql_query,'');

show_screen($HTTP_REFERER);

}//elseif
?>
