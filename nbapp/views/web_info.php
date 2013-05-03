<?php if(is_array($err) && count($err) > 0){ ?>
<div class="screenmsgbox">
  <fieldset class="err"><legend>Error(s)</legend>
    <p><?php __e(implode("<br/>", $err));?></p>
  </fieldset>
</div>  
<?php } ?>



<?php if(is_array($msg) && count($msg) > 0){ ?>
<div class="screenmsgbox">
  <fieldset class="suc"><legend>Success</legend>
    <p><?php __e(implode("<br/>", $msg));?></p>
  </fieldset>
</div>
<?php } ?>