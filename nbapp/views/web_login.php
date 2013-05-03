<?php #web_login.php ?>

<h3>Admin Management System :: Login</h3>
<br class="clearall"/>
<form name="frmLogin" id="frmLogin" action="<?php __e(nb_site_url("func=login"));?>" method="post">
  <input type="hidden" name="mode" id="mode" value="check" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
  <?php nb_admin_info($err,$msg);?>

  <table cellpadding="2" cellspacing="2" border="0" class="frmcom loginimg">
    <tbody>
      <tr>
        <td width="10%"><label for="txtUsername">Username</label></td>
        <td><input type="text" name="txtUsername" id="txtUsername" value="" class="box boxlogin" maxlength="50"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><label for="txtPassword">Password</label></td>
        <td><input type="password" name="txtPassword" id="txtPassword" value="" class="box boxlogin" maxlength="50"/></td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td>
           <input type="submit" name="srch_btn" id="srch_btn" value="Login" class="button-submit" onclick="" />
           <input type="reset" name="srch_btn" id="srch_btn" value="Cancel" class="button-submit" onclick="" />
        </td>
      </tr>
    </tbody>
  </table>
</form>
