<?php #web_login.php ?>

<h3>Sorry we found an issue, please rectify it.</h3>
<br class="clearall"/>
<form name="frmLogin" id="frmLogin" action="#" method="post">

  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>
      <tr>
        <td>
          <div class="generror">
            <span class="typemsg"><?php __e($err);?></span>
            <span class="typerror">ERROR :: <?php __e($error);?></span>
          </div>
        </td>
      </tr>
      
    </tbody>
  </table>
  
</form>
