<?
 
will be considered as the violation of the copyright laws */ 
show_header(); ?>
<table width="100%">
<tr><td class="lined title">Admin Section</td>
<tr><td class='lined padded-6'>
<table align="center" class='body'>
        <form action="admin.php" method="post">
<input type="hidden" name="mode" value="admin_login">
<input type="hidden" name="act" value="log">
<tr>
            <td width="69"><strong>Admin</strong></td>
            <td width="160"><input type="text" class="textfield" name="admin"></td>
<tr>
            <td><strong>Password</strong></td>
            <td><input type="password" class="textfield" name="password"></td>
<tr><td>&nbsp;</td>
            <td align="center">
<input type="submit" class="textfield" name="Submit" value="Log In">
            </td>
</form>
</table></td>
</table>
<? show_footer(); ?>
