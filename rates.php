<?php
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);

$sql_query="select chk_rate from members where mem_id='$m_id'";
$las=sql_execute($sql_query,'get');
if($las->chk_rate!="0000-00-00 00:00:00")	$last=format_date($las->chk_rate);
else	$last=date("m/d/Y");
$sql_query="update members set chk_rate=now() where mem_id='$m_id'";
sql_execute($sql_query,'');
$sql_query="select count(id) as cou,sum(rate) as suu from hotornot where ph_memid='$m_id'";
$rt=sql_execute($sql_query,'get');
if($rt->cou>0)	$rate=round($rt->suu/$rt->cou,2);
else	$rate=0;
$sql_query="select * from hotornot where ph_memid='$m_id' order by dt";
$res=sql_execute($sql_query,'res');
show_header();
?>
<table width="100%" class="body">
  <tr> 
    <td class="lined title">&nbsp;<?=LNG_RATES_RATING?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
        <tr> 
          <td colspan="2" align="right" class="body"><?=LNG_RATES_RT_CHK?> <?=$last?>
            &nbsp;</td>
        </tr>
        <?php if(!mysql_num_rows($res)) { ?>
        <tr> 
          <td colspan="2" align="center" class="body"><?=LNG_RATES_NO_RATING_FND?></td>
        </tr>
        <?php } else { ?>
        <tr> 
          <td align="center" class="body"><strong><?=LNG_RATES_MEM?></strong></td>
          <td align="center" class="body"><strong><?=LNG_RATES_RAT?></strong></td>
        </tr>
        <?php while($row=mysql_fetch_object($res)) { ?>
        <tr> 
          <td align="center" class="body"><? echo show_memnam($row->memid); ?></td>
          <td align="center" class="body"> 
            <?=$row->rate?>
          </td>
        </tr>
        <?php } ?>
        <tr valign="middle"> 
          <td height="30" colspan="2" align="center" class="orangebody">
		  <?=LNG_RATES_UR_RAT?> <font size="3"><?=$rate?></font></td>
        </tr>
        <?php } ?>
        <tr valign="middle">
          <td colspan="2" align="center">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
