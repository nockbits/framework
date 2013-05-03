<?php if($err_msg){ ?>
<div class="err">
  <b>Errors:</b><br/>
  &nbsp;<?php __e($err_msg);?>
</div>
<?php } ?>

<form name="frm1" id="frm1" class="frm1" method="post" action="">
  <input type="hidden" name="cm" value="add" />
  <input type="hidden" name="ct" value="<?php __e($ts);?>" />
  ###add form###
</form>  